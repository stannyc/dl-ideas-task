<?php $success = $this->session->flashdata('success'); ?>
<?php $error   = $this->session->flashdata('error'); ?>

<?php if ($success || $error): ?>
<div class="toast-container position-fixed top-0 end-0 p-3">
	<div class="toast align-items-center text-bg-<?= $success ? 'success' : 'danger' ?> border-0"
	     role="alert" aria-live="assertive" aria-atomic="true" id="flash-toast">
		<div class="d-flex">
			<div class="toast-body"><?= html_escape($success ?: $error) ?></div>
			<button type="button" class="btn-close btn-close-white me-2 m-auto"
			        data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
	</div>
</div>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		bootstrap.Toast.getOrCreateInstance(document.getElementById('flash-toast')).show();
	});
</script>
<?php endif; ?>
