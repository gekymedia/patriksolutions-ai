<div class="ai-profile-card">
    <h2>Update password</h2>
    <p class="text-muted">Ensure your account is using a long, random password to stay secure.</p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="ai-form-label">Current password</label>
            <input id="update_password_current_password" name="current_password" type="password" class="ai-form-control" autocomplete="current-password">
            @if ($errors->updatePassword->has('current_password'))
                <div class="ai-form-error">{{ $errors->updatePassword->first('current_password') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="ai-form-label">New password</label>
            <input id="update_password_password" name="password" type="password" class="ai-form-control" autocomplete="new-password">
            @if ($errors->updatePassword->has('password'))
                <div class="ai-form-error">{{ $errors->updatePassword->first('password') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="ai-form-label">Confirm password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="ai-form-control" autocomplete="new-password">
            @if ($errors->updatePassword->has('password_confirmation'))
                <div class="ai-form-error">{{ $errors->updatePassword->first('password_confirmation') }}</div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="ai-btn ai-btn-primary">Save</button>
            @if (session('status') === 'password-updated')
                <span class="small text-success">Saved.</span>
            @endif
        </div>
    </form>
</div>
