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
								<th>Transaction Date</th>
								<th>Total Amount</th>
								<th>Status</th>
								<!-- <th>Created</th> -->
								<th class="text-end">..........</th>
							</tr>
						</thead>
						<tbody>
							<?php for ($i = 1; $i <= 12; $i++) { ?>
								<tr>
									<td>xxx-xxxdrse</td>
									<td>
										<div class="d-flex ">
											<span class="fw-medium">Alexander Pierce</span>
										</div>
									</td>
									<td>Mar 12, 2025</td>
									<td>$1.500</td>
									<td>
										<span class="badge text-bg-success">Paid</span>
									</td>
									<!-- <td>Mar 12, 2025</td> -->
									<td class="text-end">
										<a
											href="invoices/detail/<?= $i;  ?>"
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
				<div class="float-start pt-1 fs-7 text-body-secondary">
					Showing 1 to 9 of 42 Invoices
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
			<!--end::Card Footer-->
		</div>
		<!--end::Card-->
	</div>
	<!-- /.col -->
</div>
<!--end::Row-->
