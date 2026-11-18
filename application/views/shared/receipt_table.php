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
								<th>Receipt Number</th>
								<th>User</th>
								<th>Payment Date</th>
								<th>Payment Method</th>
								<th>Amount Paid</th>
								<th class="text-end">..........</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($receipts as $receipt) { ?>
								<tr>
									<td>
										<div class="d-flex ">
											<span class="fw-medium"><?= $receipt->receipt_number ?></span>
										</div>
									</td>
									<td><?= $receipt->user_name ?></td>
									<td><?php $issued = new DateTimeImmutable($receipt->paid_at); echo $issued->format('F jS Y')  ?></td>
									<td><?= $receipt->payment_method ?></td>
									<td>$<?= number_format($receipt->amount_paid/100, 2) ?></td>
									<td class="text-end">
										<a
											href="receipts/detail/<?= $receipt->id;  ?>"
											class="btn btn-outline-secondary"
											aria-label="Delete Alexander Pierce">
											<i class="bi bi-eye-fill" aria-hidden="true"> </i>
										</a>
									</td>
									<!-- <td class="text-end">
									<div class="btn-group btn-group-sm">
										<button
											type="button"
											class="btn btn-outline-secondary"
											aria-label="Edit Alexander Pierce">
											<i class="bi bi-pencil" aria-hidden="true"> </i>
										</button>
										<button
											type="button"
											class="btn btn-outline-danger"
											data-bs-toggle="modal"
											data-bs-target="#modal-delete-user"
											aria-label="Delete Alexander Pierce">
											<i class="bi bi-trash" aria-hidden="true"> </i>
										</button>
									</div>
								</td> -->
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
