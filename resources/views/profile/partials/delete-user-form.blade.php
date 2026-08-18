<div class="ai-profile-card">
    <h2>Delete account</h2>
    <p class="text-muted">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>

    <button type="button" class="ai-btn ai-btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletion">
        <i class="fas fa-trash-alt"></i> Delete account
    </button>
</div>

<div class="modal fade" id="confirmUserDeletion" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: 1px solid var(--ai-border);">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="confirmUserDeletionLabel">Delete account?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-body">
                    <p class="text-muted small mb-3">
                        Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.
                    </p>
                    <label for="delete_password" class="ai-form-label">Password</label>
                    <input id="delete_password" name="password" type="password" class="ai-form-control" placeholder="Your password" required>
                    @if ($errors->userDeletion->has('password'))
                        <div class="ai-form-error">{{ $errors->userDeletion->first('password') }}</div>
                    @endif
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="ai-btn ai-btn-dark" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="ai-btn ai-btn-danger">Delete account</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new bootstrap.Modal(document.getElementById('confirmUserDeletion')).show();
        });
    </script>
    @endpush
@endif
