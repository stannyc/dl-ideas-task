<?php
defined('BASEPATH') or exit('No direct script access allowed');


$money = function ($cents) use ($order) {
	$amount = number_format($cents / 100, 2);
	return strtolower($order->currency) === 'usd' ? '$' . $amount : $amount . ' ' . strtoupper($order->currency);
};

$is_paid    = $order->status === 'paid';
$is_pending = $order->status === 'pending';
?>



<div class="row justify-content-center">


<div class="col-lg-8 col-xl-7">

	<div class="card">
		<div class="card-body p-4 p-md-5 text-center">

			<?php if ($is_paid): ?>


				<div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success-subtle text-success mb-3"
				     style="width: 4.5rem; height: 4.5rem;">
					<i class="bi bi-check-lg display-6"></i>
				</div>

				<h1 class="h3 mb-2">Thank you, your payment was successful</h1>
				<p class="text-secondary mb-0">
					Order #<?= (int) $order->id ?> is paid.
					<?php if ($receipt): ?>Your receipt <strong><?= html_escape($receipt->receipt_number) ?></strong> is ready.<?php endif; ?>
				</p>

			<?php elseif ($is_pending): ?>


				<div class="spinner-border text-primary mb-3" style="width: 3.5rem; height: 3.5rem;" role="status">
					<span class="visually-hidden">Processing…</span>
				</div>
				<h1 class="h3 mb-2">We're confirming your payment</h1>
				<p class="text-secondary mb-0">
					This usually takes a few seconds. This page refreshes automatically.
					You won't be charged twice.
				</p>


				<?php if ($notice): ?>
					<p class="small text-secondary mt-2 mb-0"><?= html_escape($notice) ?></p>
				<?php endif; ?>

			<?php else: ?>

				<div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger-subtle text-danger mb-3"
				     style="width: 4.5rem; height: 4.5rem;">
					<i class="bi bi-x-lg display-6"></i>
				</div>
				<h1 class="h3 mb-2">Your payment was not completed</h1>
				<p class="text-secondary mb-0">
					Order #<?= (int) $order->id ?> was <?= html_escape($order->status) ?>. No money was taken.
					Your cart still has your items, so you can try again.
				</p>

			<?php endif; ?>

		</div>


		<div class="card-body border-top px-4 px-md-5">
			<div class="d-flex justify-content-between small text-secondary mb-3">
				<span>Order #<?= (int) $order->id ?><?= $invoice ? ' · ' . html_escape($invoice->invoice_number) : '' ?></span>
				<?php if ($receipt && $receipt->payment_method): ?>
					<span><i class="bi bi-credit-card me-1"></i><?= html_escape($receipt->payment_method) ?></span>
				<?php endif; ?>
			</div>

			<ul class="list-unstyled mb-3">
				<?php foreach ($items as $line): ?>
				<li class="d-flex justify-content-between py-1">
					<span><?= html_escape($line->product_name) ?> <span class="text-secondary">× <?= (int) $line->quantity ?></span></span>
					<span><?= $money($line->line_total) ?></span>
				</li>
				<?php endforeach; ?>
			</ul>

			<div class="d-flex justify-content-between border-top pt-2 fw-semibold">
				<span><?= $is_paid ? 'Total paid' : 'Total' ?></span>
				<span><?= $money($order->total_amount) ?></span>
			</div>
		</div>


		<div class="card-footer d-flex flex-column flex-sm-row justify-content-center gap-2 py-3">
			<?php if ($is_paid): ?>
				<?php if ($receipt): ?>
					<a href="<?= site_url('receipts/detail/' . (int) $receipt->id) ?>" class="btn btn-primary">
						<i class="bi bi-receipt me-1"></i>View receipt
					</a>
				<?php endif; ?>
				<a href="<?= site_url('shop') ?>" class="btn btn-outline-secondary">Continue shopping</a>

			<?php elseif ($is_pending): ?>
				<a href="<?= html_escape(current_url() . '?session_id=' . rawurlencode($this->input->get('session_id'))) ?>" class="btn btn-outline-primary">
					<i class="bi bi-arrow-clockwise me-1"></i>Check again
				</a>
				<a href="<?= site_url('invoices') ?>" class="btn btn-outline-secondary">My invoices</a>

			<?php else: ?>
				<a href="<?= site_url('cart') ?>" class="btn btn-primary">
					<i class="bi bi-cart3 me-1"></i>Back to cart
				</a>
				<a href="<?= site_url('shop') ?>" class="btn btn-outline-secondary">Continue shopping</a>
			<?php endif; ?>
		</div>
	</div>

</div>
</div>

<?php if ($is_pending): ?>
<script>	
	(function () {
		var key   = 'checkout-refreshes';
		var count = parseInt(sessionStorage.getItem(key) || '0', 10);
		if (count < 15) {
			sessionStorage.setItem(key, count + 1);
			setTimeout(function () { window.location.reload(); }, 4000);
		}
	})();
</script>
<?php else: ?>
<script>
	try { sessionStorage.removeItem('checkout-refreshes'); } catch (e) {}
</script>
<?php endif; ?>
