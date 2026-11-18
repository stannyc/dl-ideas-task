<?php
defined('BASEPATH') or exit('No direct script access allowed');

?>



<div class="row justify-content-center">

	<div class="col-lg-6">
		<div class="card">
			<div class="card-body p-4 p-md-5 text-center">
				<div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-warning-subtle text-warning-emphasis mb-3"
					style="width: 4.5rem; height: 4.5rem;">
					<i class="bi bi-arrow-counterclockwise display-6"></i>
				</div>
				<h1 class="h3 mb-2">Payment cancelled</h1>
				<p class="text-secondary mb-4">
					No money was taken. Your items are still in your cart whenever you're ready.
				</p>
				<div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
					<a href="<?= site_url('cart') ?>" class="btn btn-primary">
						<i class="bi bi-cart3 me-1"></i>Back to cart
					</a>
					<a href="<?= site_url('shop') ?>" class="btn btn-outline-secondary">Continue shopping</a>
				</div>
			</div>
		</div>


	</div>
	
</div>
