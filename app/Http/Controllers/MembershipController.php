<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Exceptions\IncompletePayment;

class MembershipController extends Controller
{
    const PLANS = [
        'free'  => null,
        'pro'   => 'price_PRO_MONTHLY_ID',
        'elite' => 'price_ELITE_MONTHLY_ID',
    ];

    private function stripeConfigured(): bool
    {
        return filled(config('cashier.key')) && filled(config('cashier.secret'));
    }

    public function index()
    {
        $user = Auth::user();
        $intent = null;
        $checkoutPlan = null;

        if ($user && $this->stripeConfigured()) {
            $intent = $user->createSetupIntent();
            $plan = request('plan');

            if (in_array($plan, ['pro', 'elite'], true)) {
                $checkoutPlan = $plan;
            }
        }

        return view('membership.index', [
            'user'             => $user,
            'currentPlan'      => $user?->currentPlan() ?? 'free',
            'intent'           => $intent,
            'stripeConfigured' => $this->stripeConfigured(),
            'checkoutPlan'     => $checkoutPlan,
        ]);
    }

    public function subscribe(Request $request)
    {
        if (! $this->stripeConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'Online payments are not configured yet. Please try again later.',
            ], 503);
        }

        $request->validate([
            'plan'           => 'required|in:pro,elite',
            'payment_method' => 'required|string',
        ]);

        $user = Auth::user();
        $plan = $request->plan;
        $priceId = self::PLANS[$plan];

        try {
            if ($user->subscribed('default')) {
                $user->subscription('default')->swap($priceId);
            } else {
                $user->newSubscription('default', $priceId)
                    ->create($request->payment_method);
            }

            $user->forceFill(['plan' => $plan])->save();

            return response()->json([
                'success' => true,
                'message' => "Welcome! You now have full access to all AI courses.",
                'plan'    => $plan,
            ]);
        } catch (IncompletePayment $e) {
            return response()->json([
                'success'         => false,
                'requires_action' => true,
                'payment_intent'  => $e->payment->id,
            ], 402);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment failed. Please check your card details.',
            ], 422);
        }
    }

    public function cancel()
    {
        $user = Auth::user();

        if ($user->subscribed('default')) {
            $user->subscription('default')->cancel();
            $user->forceFill(['plan' => 'free'])->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Subscription cancelled. You keep access until the end of the billing period.',
        ]);
    }

    public function resume()
    {
        $user = Auth::user();

        if ($user->subscription('default') && $user->subscription('default')->onGracePeriod()) {
            $user->subscription('default')->resume();
            $user->forceFill([
                'plan' => $user->subscription('default')->stripe_price === self::PLANS['elite'] ? 'elite' : 'pro',
            ])->save();
        }

        return response()->json(['success' => true, 'message' => 'Subscription resumed!']);
    }

    public function billingPortal()
    {
        if (! $this->stripeConfigured()) {
            return redirect()->route('membership.index')
                ->with('upgrade_message', 'Billing is not available yet. Payment setup is still in progress.');
        }

        return Auth::user()->redirectToBillingPortal(route('membership.index'));
    }
}
