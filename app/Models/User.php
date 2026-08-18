<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Billable, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'plan',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function currentPlan(): string
    {
        return $this->plan ?? 'free';
    }

    public function isPro(): bool
    {
        return in_array($this->currentPlan(), ['pro', 'elite']);
    }

    public function isElite(): bool
    {
        return $this->currentPlan() === 'elite';
    }

    public function hasActiveMembership(): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if ($this->isFree()) {
            return false;
        }

        return $this->subscribed('default') ||
            ($this->subscription('default') && $this->subscription('default')->onGracePeriod());
    }

    public function hasCourseAccess(): bool
    {
        return $this->isAdmin() || $this->hasActiveMembership();
    }

    public function isFree(): bool
    {
        return $this->currentPlan() === 'free';
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function dailyTutorLimit(): int
    {
        if ($this->isAdmin()) {
            return 999;
        }

        return match ($this->currentPlan()) {
            'elite' => 100,
            'pro' => 50,
            default => 5,
        };
    }
}
