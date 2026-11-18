<?php
defined('BASEPATH') or exit('No direct script access allowed');



$money = function ($cents) use ($currency) {
	$amount = number_format($cents / 100, 2);
	return strtolower($currency) === 'usd' ? '$' . $amount : $amount . ' ' . strtoupper($currency);
};
?>

<?php if (empty($items)): ?>

	<!-- Empty state -->
	<div class="card">
		<div class="card-body text-center py-5">
			<i class="bi bi-cart3 display-4 text-secondary"></i>
			<h2 class="h5 mt-3">Your cart is empty</h2>
			<p class="text-secondary mb-4">Browse the shop and add a few products to get started.</p>
			<a href="<?= site_url('home') ?>" class="btn btn-primary">
				<i class="bi bi-shop me-1"></i>Go to the shop
			</a>
		</div>
	</div>

<?php else: ?>

<div class="row g-4">

	<!-- Items -->
	<div class="col-lg-8">
		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h2 class="card-title h6 mb-0">
					<?= $count ?> <?= $count === 1 ? 'item' : 'items' ?> in your cart
				</h2>
				<?= form_open('cart/clear', array('class' => 'ms-auto', 'onsubmit' => "return confirm('Remove all items from your cart?');")) ?>
					<button type="submit" class="btn btn-sm btn-link text-danger text-decoration-none p-0">
						<i class="bi bi-trash3 me-1"></i>Empty cart
					</button>
				<?= form_close() ?>
			</div>

			<ul class="list-group list-group-flush">
				<?php foreach ($items as $item): ?>
				<li class="list-group-item py-3">
					<div class="row g-3 align-items-center">

						<!-- Image -->
						<div class="col-3 col-md-2">
							<?php if ( ! empty($item->image)): ?>
								<img src="<?= base_url('uploads/products/' . $item->image) ?>" alt=""
								     class="img-fluid rounded border" style="aspect-ratio: 1; object-fit: cover;">
							<?php else: ?>
								<div class="rounded border bg-body-tertiary d-flex align-items-center justify-content-center text-secondary"
								     style="aspect-ratio: 1;">
									<i class="bi bi-image fs-4"></i>
								</div>
							<?php endif; ?>
						</div>

						<!-- Name + unit price -->
						<div class="col-9 col-md-4">
							<p class="fw-semibold mb-1"><?= html_escape($item->name) ?></p>
							<small class="text-secondary"><?= $money($item->price) ?> each</small>
						</div>

						<!-- Quantity -->
						<div class="col-7 col-md-3">
							<?= form_open('cart/update', array('class' => 'input-group input-group-sm')) ?>
								<input type="hidden" name="product_id" value="<?= (int) $item->product_id ?>">
								<input type="number" name="quantity" value="<?= (int) $item->quantity ?>"
								       min="0" max="99" class="form-control" aria-label="Quantity for <?= html_escape($item->name) ?>">
								<button type="submit" class="btn btn-outline-secondary" title="Update quantity">
									<i class="bi bi-arrow-repeat"></i>
								</button>
							<?= form_close() ?>
						</div>

						<!-- Line total + remove -->
						<div class="col-5 col-md-3 d-flex justify-content-end align-items-center gap-2">
							<span class="fw-semibold"><?= $money($item->line_total) ?></span>
							<?= form_open('cart/remove') ?>
								<input type="hidden" name="product_id" value="<?= (int) $item->product_id ?>">
								<button type="submit" class="btn btn-sm btn-outline-danger" title="Remove <?= html_escape($item->name) ?>">
									<i class="bi bi-x-lg"></i>
								</button>
							<?= form_close() ?>
						</div>

					</div>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<a href="<?= site_url('home') ?>" class="btn btn-link px-0 mt-2 text-decoration-none">
			<i class="bi bi-arrow-left me-1"></i>Continue shopping
		</a>
	</div>

	<!-- Summary -->
	<div class="col-lg-4">
		<div class="card position-sticky" style="top: 1rem;">
			<div class="card-header">
				<h2 class="card-title h6 mb-0">Order summary</h2>
			</div>
			<div class="card-body">
				<dl class="row mb-0">
					<dt class="col-7 fw-normal text-secondary">Items (<?= $count ?>)</dt>
					<dd class="col-5 text-end mb-2"><?= $money($subtotal) ?></dd>

					<dt class="col-7 fw-normal text-secondary">Shipping</dt>
					<dd class="col-5 text-end mb-2">Free</dd>

					<dt class="col-7 fw-semibold border-top pt-2">Total</dt>
					<dd class="col-5 text-end fw-semibold border-top pt-2 mb-0 fs-5"><?= $money($subtotal) ?></dd>
				</dl>
			</div>
			<div class="card-footer">
				<?= form_open('cart/checkout', array('id' => 'checkout-form')) ?>
					<button type="submit" class="btn btn-primary w-100" id="checkout-button">
						<i class="bi bi-lock-fill me-1"></i>Checkout securely
					</button>
				<?= form_close() ?>
				<p class="small text-secondary text-center mt-2 mb-0">
					<i class="bi bi-credit-card me-1"></i>You'll pay on Stripe's secure page.
				</p>
			</div>
		</div>
	</div>

</div>

<script>
	document.getElementById('checkout-form').addEventListener('submit', function () {
		var btn = document.getElementById('checkout-button');
		btn.disabled = true;
		btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Redirecting to payment…';
	});
</script>

<?php endif; ?>
