<?php
defined('BASEPATH') or exit('No direct script access allowed');


$is_edit = ! empty($product);

$invalid = function ($field) {
	return form_error($field) ? ' is-invalid' : '';
};
?>

<div class="col-md-6">
	<div class="card card-primary card-outline mb-4">
		<?= form_open_multipart($action, array('novalidate' => '')) ?>
		<div class="card-body">

			<?php if (! empty($error)): ?>
				<div class="alert alert-danger" role="alert">
					<i class="bi bi-exclamation-triangle me-1"></i><?= html_escape($error) ?>
				</div>
			<?php endif; ?>

			<?php if (validation_errors()): ?>
				<div class="alert alert-danger py-2 small" role="alert">
					Please fix the highlighted fields below.
				</div>
			<?php endif; ?>

			<div class="mb-3">
				<label for="nameInput" class="form-label">Product Name</label>
				<input type="text" class="form-control<?= $invalid('name') ?>" id="nameInput" name="name"
					value="<?= html_escape(set_value('name', $product->name ?? '')) ?>" />
				<?= form_error('name', '<div class="invalid-feedback">', '</div>') ?>
			</div>
			<div class="mb-3">
				<label for="descriptionInput" class="form-label">Description</label>
				<!-- <input type="password" class="form-control" id="descriptionInput" /> -->
				<textarea class="form-control<?= $invalid('description') ?>" id="descriptionInput" name="description"><?= $is_edit ? trim($product->description) : '' ?></textarea>
				<?= form_error('description', '<div class="invalid-feedback">', '</div>') ?>
			</div>
			<div class="mb-3">
				<label for="inputGroupFile02" class="form-label">Price</label>
				<div class="input-group mb-3">
					<span class="input-group-text">$</span>
					<input
						type="text"
						name="price"
						class="form-control<?= $invalid('price') ?>"
						aria-label="Amount (to the nearest dollar)"
						value="<?= $is_edit ? html_escape(set_value('price', $product->price/100 ?? '')) : '' ?>" />

					<!-- <span class="input-group-text">.00</span> -->
					<?= form_error('price', '<div class="invalid-feedback">', '</div>') ?>
				</div>
			</div>
			<div class="mb-3">
				<label for="product_image" class="form-label">Product Image</label>
				<input type="file" name="image" id="product_image" class="form-control"
					accept=".jpg,.jpeg,.png,.webp" />
			</div>

			<div>
				<?php $current_image = ! empty($product->image) ? base_url('uploads/products/' . $product->image) : NULL; ?>
				<img id="image-preview"
					<?= $current_image ? 'src="' . $current_image . '"' : '' ?>
					alt="Image preview" class="rounded border <?= $current_image ? '' : 'd-none' ?>" width="200" height="120"

					style="object-fit: cover;" />

			</div>

		</div>
		<div class="card-footer d-flex justify-content-end gap-2">
			<button type="submit" class="btn btn-primary">
				<i class="bi bi-check-lg me-1"></i><?= $is_edit ? 'Update Product' : 'Create Product' ?>
			</button>
			<a href="<?= site_url('admin/product') ?>" class="btn btn-outline-secondary">Cancel</a>
		</div>
		<?= form_close() ?>
	</div>
</div>


<script>
	document.addEventListener('DOMContentLoaded', function() {
		const input = document.getElementById('product_image');
		const preview = document.getElementById('image-preview');
		const original = preview.getAttribute('src');
		let objectUrl = null;

		function show(src) {
			if (src) {
				preview.src = src;
				preview.classList.remove('d-none');
			} else {
				preview.removeAttribute('src');
				preview.classList.add('d-none');
			}
		}


		input.addEventListener('change', function() {
			if (objectUrl) {
				URL.revokeObjectURL(objectUrl);
				objectUrl = null;
			}

			const file = input.files[0];
			if (!file || !file.type.startsWith('image/')) {
				show(original);
				return;
			}

			objectUrl = URL.createObjectURL(file);
			show(objectUrl);
		});

	});
</script>
