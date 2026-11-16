<!--begin::Container-->
<div class="container-fluid">
	<!--begin::Row-->
	<div class="row  g-4 mb-4">
		<?php foreach($products as $product) {

			$this->load->view('shared/product_tile', array('product' => $product))

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


