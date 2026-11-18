<?php

	$invoiceUrl = $current_user->role === 'admin' ? '/admin/invoices/detail/'.$receipt->invoice_id : '/invoices/detail/'.$receipt->invoice_id

?>
<div class="container-fluid">
	<!-- Action bar (hidden on print) -->
	<div class="d-flex justify-content-end gap-2 mb-3 d-print-none">
		<a href="<?= $invoiceUrl ?>" class="btn btn-outline-secondary">
			<i class="bi bi-file-earmark-text me-1" aria-hidden="true"></i>View invoice
		</a>
		<button class="btn btn-outline-secondary" onclick="window.print()" type="button">
			<i class="bi bi-printer me-1" aria-hidden="true"></i>Print
		</button>
	</div>

	<div class="card">
		<div class="card-body p-4 p-md-5">
			<!-- Header -->
			<div class="row mb-4">
				<div class="col-sm-6">
					<h2 class="h4 mb-0 text-primary fw-semibold">AdminLTE, Inc.</h2>
					<p class="text-secondary mb-0 small">
						795 Folsom Ave, Suite 600<br />
						San Francisco, CA 94107<br />
						billing@example.com
					</p>
				</div>
				<div class="col-sm-6 text-sm-end">
					<h1 class="h2 mb-1">Receipt</h1>
					<p class="text-secondary mb-0">
						<span class="fw-semibold">#</span>RCT-2026-00428
					</p>
					<span class="badge text-bg-success mt-1">
						<i class="bi bi-check-circle me-1" aria-hidden="true"></i>Payment received
					</span>
				</div>
			</div>

			<!-- Paid by / payment details -->
			<div class="row mb-4">
				<div class="col-sm-6">
					<p class="text-secondary small mb-1">Paid by</p>
					<p class="mb-0 fw-semibold">Acme Corporation</p>
					<p class="text-secondary small mb-0">
						Attn: Jane Doe<br />
						jane.doe@acme.example
					</p>
				</div>
				<div class="col-sm-6 text-sm-end">
					<p class="text-secondary small mb-1">Payment date</p>
					<p class="mb-2">May 18, 2026, 14:32</p>
					<p class="text-secondary small mb-1">Payment method</p>
					<p class="mb-2"><i class="bi bi-credit-card me-1" aria-hidden="true"></i><?= $receipt->payment_method ?></p>
					
				</div>
			</div>

			<!-- Amount paid highlight -->
			<div class="rounded bg-body-tertiary border p-3 mb-4 d-flex justify-content-between align-items-center">
				<span class="text-secondary">Amount paid</span>
				<span class="h3 mb-0 fw-semibold text-success">$<?= number_format($receipt->amount_paid/100, 2) ?></span>
			</div>

	



			<?php if($current_user->role === 'admin') { ?>
			<div class="mt-4 p-3 border rounded small d-print-none">
				<p class="text-secondary mb-1">Reference</p>
				<p class="mb-0 font-monospace">Stripe PaymentIntent: <?= $receipt->stripe_payment_intent_id ?></p>
			</div>
			<?php } ?>

			<!-- Footer note -->
			<hr class="my-4" />
			<p class="text-secondary small mb-0">
				This receipt confirms your payment has been received. Please keep it for your records.
				Questions? Contact <a href="mailto:billing@example.com">billing@example.com</a>.
			</p>
		</div>
	</div>
</div>
