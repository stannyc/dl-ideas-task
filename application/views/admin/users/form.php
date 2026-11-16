<?php
defined('BASEPATH') or exit('No direct script access allowed');


$is_edit = ! empty($user);
$is_self = $is_edit && ! empty($current_user) && (int) $user->id === (int) $current_user->id;

$invalid = function ($field) {
	return form_error($field) ? ' is-invalid' : '';
};
?>
<div class="row">
<div class="col-md-8 col-lg-6">
	<div class="card card-primary card-outline mb-4">

		<?= form_open_multipart($action, array('novalidate' => '')) ?>
			<div class="card-body">

				<?php if ( ! empty($error)): ?>
					<div class="alert alert-danger" role="alert">
						<i class="bi bi-exclamation-triangle me-1"></i><?= html_escape($error) ?>
					</div>
				<?php endif; ?>

				<?php if (validation_errors()): ?>
					<div class="alert alert-danger py-2 small" role="alert">
						Please fix the highlighted fields below.
					</div>
				<?php endif; ?>

				<!-- Name -->
				<div class="mb-3">
					<label for="name" class="form-label">Name</label>
					<input type="text" name="name" id="name" maxlength="150" required
					       class="form-control<?= $invalid('name') ?>"
					       value="<?= html_escape(set_value('name', $user->name ?? '')) ?>" />
					<?= form_error('name', '<div class="invalid-feedback">', '</div>') ?>
				</div>

				<!-- Email -->
				<div class="mb-3">
					<label for="email" class="form-label">Email address</label>
					<input type="email" name="email" id="email" maxlength="100" required
					       class="form-control<?= $invalid('email') ?>"
					       value="<?= html_escape(set_value('email', $user->email ?? '')) ?>" />
					<?= form_error('email', '<div class="invalid-feedback">', '</div>') ?>
				</div>

				<!-- Role -->
				<div class="mb-3">
					<label for="role" class="form-label">Role</label>
					<?php $role = $user->role ?? 'user'; ?>
					<select name="role" id="role" class="form-select<?= $invalid('role') ?>" <?= $is_self ? 'disabled' : '' ?>>
						<option value="user"  <?= set_select('role', 'user',  $role === 'user') ?>>User</option>
						<option value="admin" <?= set_select('role', 'admin', $role === 'admin') ?>>Admin</option>
					</select>
					<?php if ($is_self): ?>
						<!-- disabled fields aren't submitted, so send the value separately -->
						<input type="hidden" name="role" value="admin" />
						<div class="form-text">You can't change your own role.</div>
					<?php endif; ?>
					<?= form_error('role', '<div class="invalid-feedback">', '</div>') ?>
				</div>

				<!-- Password -->
				<div class="row">
					<div class="col-sm-6 mb-3">
						<label for="password" class="form-label">Password</label>
						<input type="password" name="password" id="password" maxlength="72"
						       autocomplete="new-password" <?= $is_edit ? '' : 'required' ?>
						       class="form-control<?= $invalid('password') ?>" />
						<?= form_error('password', '<div class="invalid-feedback">', '</div>') ?>
					</div>
					<div class="col-sm-6 mb-3">
						<label for="password_confirm" class="form-label">Confirm password</label>
						<input type="password" name="password_confirm" id="password_confirm" maxlength="72"
						       autocomplete="new-password"
						       class="form-control<?= $invalid('password_confirm') ?>" />
						<?= form_error('password_confirm', '<div class="invalid-feedback">', '</div>') ?>
					</div>
					<div class="col-12 form-text mt-n2 mb-3">
						<?= $is_edit ? 'Leave blank to keep the current password. ' : '' ?>Minimum 8 characters.
					</div>
				</div>

				<!-- Avatar -->
				<div class="mb-3">
					<label for="avatar" class="form-label">Avatar image</label>
					<div class="d-flex align-items-center gap-3">
						<?php if ( ! empty($user->avatar)): ?>
							<img src="<?= base_url('uploads/avatars/' . $user->avatar) ?>"
							     alt="Current avatar" class="rounded-circle border" width="56" height="56"
							     style="object-fit: cover;" />
						<?php endif; ?>
						<div class="flex-grow-1">
							<input type="file" name="avatar" id="avatar" class="form-control"
							       accept=".jpg,.jpeg,.png,.webp" />
							<div class="form-text">
								JPG, PNG or WEBP, max 1 MB.<?= ! empty($user->avatar) ? ' Choosing a file replaces the current avatar.' : '' ?>
							</div>
						</div>
					</div>
				</div>

				<!-- Active -->
				<div class="form-check form-switch">
					<input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input"
					       <?= set_checkbox('is_active', '1', $is_edit ? (bool) $user->is_active : TRUE) ?>
					       <?= $is_self ? 'disabled checked' : '' ?> />
					<label class="form-check-label" for="is_active">Active</label>
					<?php if ($is_self): ?>
						<input type="hidden" name="is_active" value="1" />
						<div class="form-text">You can't deactivate your own account.</div>
					
					<?php endif; ?>
				</div>

			</div>

			<div class="card-footer d-flex gap-2 justify-content-end">
				<button type="submit" class="btn btn-primary">
					<i class="bi bi-check-lg me-1"></i><?= $is_edit ? 'Save changes' : 'Create user' ?>
				</button>
				<a href="<?= site_url('admin/users') ?>" class="btn btn-outline-secondary">Cancel</a>
			</div>
		<?= form_close() ?>

	</div>
</div>
</div>
