<?php 
$user = $current_user;
$role = $user->role;
$is_admin = $role === 'admin';
$is_active = $product->is_active == 1;

?>
<div class="col">
	<div class="card shadow-sm <?= $is_active ? '' : 'border-danger' ?>" style="width: 18rem;">
		<img src="<?= !empty($product->image) ? base_url('uploads/products/' . $product->image) : 'https://via.placeholder.com/300x200' ?>" class="card-img-top" alt="Wireless Headphones" style="height: 200px; object-fit: cover;">
		<div class="card-body">
			<div class="d-flex justify-content-between align-items-center mb-2">
				<h5 class="card-title mb-0"><?= $product->name ?></h5>
				<span class="fw-bold text-primary fs-5">$<?=  $product->price / 100 ?></span>
			</div>
			<p class="card-text text-muted small"><?= $product->description ?></p>
			<?php if (!$is_admin) { ?>
			<?= form_open('cart/add') ?>
				<input type="hidden" name="product_id" value="<?= $product->id ?>" />
				<input type="hidden" name="quantity" value="1" />
				<button href="#" class="btn btn-primary w-100">Add to Cart</button>
			<?= form_close() ?>
			<?php } else { ?>
			
			<div class="d-flex gap-2 justify-content-end">
				<a class="btn btn-primary"
					href="/admin/product/form/<?= $product->id ?>">Update</a>
				<button
					type="button"
					class="btn <?= $is_active ? 'btn-danger' : 'btn-success' ?>"
					data-bs-toggle="modal"
					data-bs-target="#deleteProductModal"
					data-name="<?= html_escape($product->name) ?>"
					data-image="<?= html_escape($product->name) ?>"
					data-active="<?= $product->is_active ? '1' : '0' ?>"
					data-action="<?= site_url('admin/product/toggle_active/' . $product->id) ?>"
				><?= $is_active ? 'Deactivete' : 'Activate' ?></button>
			</div>

			<?php } ?>
		</div>
	</div>
</div>


<!-- add to cart modal -->



<!-- delete confirm modal -->
<div
	class="modal fade"
	id="deleteProductModal"
	tabindex="-1"
	aria-labelledby="deleteProductModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable">
		<?= form_open('', array('id' => 'form-toggle-product')) ?>
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="deleteProductModalLabel">
					Delete Product
				</h1>
				<button
					type="button"
					class="btn-close"
					data-bs-dismiss="modal"
					aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<h5 class="js-message">
					Are you sure want to delete <span class="text-danger"><strong>XXXX-xxx</strong></span>?
				</h5>

			</div>
			<div class="modal-footer">
				<button type="submit" id="confirmBtn" class="btn <?= $is_active ? 'btn-danger' : ' btn-success' ?>" data-bs-dismiss="modal">
					Delete
				</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
					Cancel
				</button>
			</div>
		</div>
		<?= form_close() ?>
	</div>
</div>


<script>
	document.addEventListener('DOMContentLoaded', function() {
		const modal = document.getElementById('deleteProductModal');

		modal.addEventListener('show.bs.modal', function(event) {
			const btn = event.relatedTarget;
			const name = btn.dataset.name;
			const isActive = btn.dataset.active === '1';

			document.getElementById('form-toggle-product').action = btn.dataset.action;

			modal.querySelector('.modal-title').textContent = isActive ? 'Deactivate product' : 'Activate product';

			modal.querySelector('#confirmBtn').textContent = isActive ? 'Deactivate' : 'Activate';

			const message = modal.querySelector('.js-message');
			message.textContent = '';
			message.append(isActive ? 'Deactivate ' : 'Activate ');
			const strong = document.createElement('strong');
			strong.classList.add('text-danger');
			strong.textContent = name;
			message.append(strong, isActive ?
				'? The product will not be available for users to buy' :
				'? The product will be made available to buy');

			const confirm = modal.querySelector('.js-confirm');
			confirm.textContent = isActive ? 'Deactivate' : 'Activate';
			confirm.className = 'btn js-confirm ' + (isActive ? 'btn-danger' : 'btn-success');
		});
	});
</script>
