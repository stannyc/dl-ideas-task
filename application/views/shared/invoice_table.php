<div>
	<div class="col-12 px-2">
		<!--begin::Card-->
		<div class="card mb-4">
			<div class="card-header"></div>
			<!--begin::Card Body-->
			<div class="card-body p-0">
				<div class="table-responsive">
					<table class="table table-hover align-middle m-0">
						<thead>
							<tr>
								<th>Invoice Number</th>
								<th>User</th>
								<th>Issued Date</th>
								<th>Total Amount</th>
								<th>Status</th> 
								<!-- <th>Created</th> -->
								<th class="text-end">..........</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($invoices as $invoice) { ?>
								<tr>
									<td><?= $invoice->invoice_number ?></td>
									<td>
										<div class="d-flex ">
											<span class="fw-medium"><?= $invoice->user_name ?></span>
										</div>
									</td>
									<td><?= $invoice->issued_at ?></td>
									<td>$<?= number_format($invoice->amount/100, 2) ?></td>
									<td>
										<span class="badge <?= $invoice->status == 'paid' ? 'text-bg-success' : 'text-bg-warning' ?>">
											<?= $invoice->status ?>
										</span>
									</td>
									<!-- <td>Mar 12, 2025</td> -->
									<td class="text-end">
										<a
											href="invoices/detail/<?= $invoice->id;  ?>"
											type="button"
											class="btn btn-outline-secondary"
											aria-label="Delete Alexander Pierce">
											<i class="bi bi-eye-fill" aria-hidden="true"> </i>
										</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<!-- /.table-responsive -->
			</div>
			<!--end::Card Body-->
			<!--begin::Card Footer-->
			<div class="card-footer clearfix">
				<?php $this->load->view('partials/pagination', array('pagination' => $pagination)) ?>
			</div>
			<!--end::Card Footer-->
		</div>
		<!--end::Card-->
	</div>
	<!-- /.col -->
</div>
<!--end::Row-->
