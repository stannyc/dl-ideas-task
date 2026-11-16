<div class="container-fluid">
	<!-- Action bar (hidden on print) -->
	<div class="d-flex justify-content-end gap-2 mb-3 d-print-none">
		<a href="#" class="btn btn-outline-secondary">
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
					<p class="mb-2"><i class="bi bi-credit-card me-1" aria-hidden="true"></i>Visa •••• 4242</p>
					<p class="text-secondary small mb-1">For invoice</p>
					<p class="mb-0"><a href="#">INV-2026-00428</a></p>
				</div>
			</div>

			<!-- Amount paid highlight -->
			<div class="rounded bg-body-tertiary border p-3 mb-4 d-flex justify-content-between align-items-center">
				<span class="text-secondary">Amount paid</span>
				<span class="h3 mb-0 fw-semibold text-success">$77.40 USD</span>
			</div>

			<!-- Items -->
			<div class="table-responsive mb-3">
				<table class="table align-middle mb-0">
					<thead>
						<tr>
							<th class="border-top-0">Description</th>
							<th class="border-top-0 text-end" style="width: 6rem">Qty</th>
							<th class="border-top-0 text-end" style="width: 9rem">Unit price</th>
							<th class="border-top-0 text-end" style="width: 9rem">Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<p class="mb-0 fw-semibold">Pro plan subscription</p>
								<small class="text-secondary">May 18 - Jun 18, 2026</small>
							</td>
							<td class="text-end">1</td>
							<td class="text-end">$29.00</td>
							<td class="text-end">$29.00</td>
						</tr>
						<tr>
							<td>
								<p class="mb-0 fw-semibold">Additional seats</p>
								<small class="text-secondary">Pro-rated for current period</small>
							</td>
							<td class="text-end">3</td>
							<td class="text-end">$12.50</td>
							<td class="text-end">$37.50</td>
						</tr>
						<tr>
							<td>
								<p class="mb-0 fw-semibold">SMS notifications add-on</p>
								<small class="text-secondary">1,000 messages</small>
							</td>
							<td class="text-end">1</td>
							<td class="text-end">$5.00</td>
							<td class="text-end">$5.00</td>
						</tr>
					</tbody>
				</table>
			</div>

			<!-- Totals -->
			<div class="row justify-content-end">
				<div class="col-md-5 col-lg-4">
					<dl class="row mb-0">
						<dt class="col-7 text-secondary fw-normal">Subtotal</dt>
						<dd class="col-5 text-end mb-2">$71.50</dd>
						<dt class="col-7 text-secondary fw-normal">Tax (8.25%)</dt>
						<dd class="col-5 text-end mb-2">$5.90</dd>
						<dt class="col-7 fw-semibold border-top pt-2">Amount paid</dt>
						<dd class="col-5 text-end fw-semibold border-top pt-2 mb-2">$77.40 USD</dd>
						<dt class="col-7 text-secondary fw-normal">Balance due</dt>
						<dd class="col-5 text-end mb-0">$0.00</dd>
					</dl>
				</div>
			</div>

			<!-- Admin-only: payment reference (wrap in <?php if (! empty($show_internal)): ?> … <?php endif; ?>) -->
			<div class="mt-4 p-3 border rounded small d-print-none">
				<p class="text-secondary mb-1">Internal reference</p>
				<p class="mb-0 font-monospace">Stripe PaymentIntent: pi_3PQx1a2b3c4d5e6f</p>
			</div>

			<!-- Footer note -->
			<hr class="my-4" />
			<p class="text-secondary small mb-0">
				This receipt confirms your payment has been received. Please keep it for your records.
				Questions? Contact <a href="mailto:billing@example.com">billing@example.com</a>.
			</p>
		</div>
	</div>
</div>
