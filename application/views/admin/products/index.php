<!--begin::Container-->
<div class="container-fluid">
	<!--begin::Row-->
	<div class="row  g-4 mb-4">
		<?php for ($i = 1; $i <= 10; $i++) {

			$this->load->view('shared/product_tile', array('price' => $i))

		?>
			<!-- <div class="col">
				<div class="card shadow-sm" style="width: 18rem;">
					<img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Wireless Headphones" style="height: 200px; object-fit: cover;">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center mb-2">
							<h5 class="card-title mb-0">Wireless Headphones</h5>
							<span class="fw-bold text-primary fs-5">$89.99</span>
						</div>
						<p class="card-text text-muted small">Active noise cancellation with 30-hour battery life.</p>
						<?php if (false) { ?>
							<a href="#" class="btn btn-primary w-100">Add to Cart</a>
						<?php } ?>						
						<div class="d-flex gap-2 justify-content-end">
							<a  class="btn btn-primary">Update</a>
							<a  class="btn btn-danger">Delete</a>
						</div>
					</div>
				</div>
			</div> -->
		<?php } ?>
	</div>
	<!--end::Row-->
	<div class="row">
		<div class="col">
			<div class="card-footer clearfix">
				<div class="float-start pt-1 fs-7 text-body-secondary">
					Showing 1 to 9 of 42 users
				</div>
				<ul class="pagination pagination-sm m-0 float-end">
					<li class="page-item disabled">
						<a class="page-link" href="#" aria-label="Previous"> &laquo; </a>
					</li>
					<li class="page-item active">
						<a class="page-link" href="#">1</a>
					</li>
					<li class="page-item">
						<a class="page-link" href="#">2</a>
					</li>
					<li class="page-item">
						<a class="page-link" href="#">3</a>
					</li>
					<li class="page-item">
						<a class="page-link" href="#">4</a>
					</li>
					<li class="page-item">
						<a class="page-link" href="#">5</a>
					</li>
					<li class="page-item">
						<a class="page-link" href="#" aria-label="Next"> &raquo; </a>
					</li>
				</ul>
			</div>
		</div>
	</div>




</div>
<!--end::Container-->


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
				<p>
					With <code>.modal-dialog-scrollable</code> the body scrolls instead of
					the page, so the header and footer stay put.
				</p>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer
					posuere erat a ante.
				</p>
				<p>
					Cras mattis consectetur purus sit amet fermentum. Cras justo odio,
					dapibus ac facilisis in.
				</p>
				<p>
					Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus
					magna.
				</p>
				<p class="mb-0">
					Donec ullamcorper nulla non metus auctor fringilla. Nullam quis risus
					eget urna mollis.
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
					Close
				</button>
			</div>
		</div>
	</div>
</div>
