<div class="col">
	<div class="card shadow-sm" style="width: 18rem;">
		<img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Wireless Headphones" style="height: 200px; object-fit: cover;">
		<div class="card-body">
			<div class="d-flex justify-content-between align-items-center mb-2">
				<h5 class="card-title mb-0">Wireless Headphones</h5>
				<span class="fw-bold text-primary fs-5">$<?=  $price ?></span>
			</div>
			<p class="card-text text-muted small">Active noise cancellation with 30-hour battery life.</p>
			<?php if (false) { ?>
				<a href="#" class="btn btn-primary w-100">Add to Cart</a>
			<?php } ?>
			<div class="d-flex gap-2 justify-content-end">
				<a class="btn btn-primary">Update</a>
				<button 
				type="button"
				class="btn btn-danger"
				data-bs-toggle="modal"
				data-bs-target="#deleteProductModal"
				>Delete</button>
			</div>
		</div>
	</div>
</div>


<!-- delete confirm modal -->
<div
	class="modal fade"
	id="deleteProductModal"
	tabindex="-1"
	aria-labelledby="deleteProductModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable">
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
				<h4>
					Are you sure want to delete <span class="text-danger"><strong>XXXX-xxx</strong></span>?
				</h4>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal">
					Delete
				</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
					Cancel
				</button>
			</div>
		</div>
	</div>
</div>
