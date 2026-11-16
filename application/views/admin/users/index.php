        <!--begin::Container-->
        <div class="container-fluid">
        	<!--begin::Row-->
        	<div class="row">
        		<div class="col-12">
        			<!--begin::Card-->
        			<div class="card mb-4">
        				<!--begin::Card Header-->
        				<div class="card-header">
        					<div class="row g-2 align-items-center">
        						<div class="col-12 col-md-4">
        							<h3 class="card-title">User Directory</h3>
        						</div>
        						<div class="col-12 col-md-8">
        							<div class="d-flex flex-wrap justify-content-md-end gap-2">
        								<div class="input-group input-group-sm w-auto">
        									<span class="input-group-text">
        										<i class="bi bi-search" aria-hidden="true"></i>
        									</span>
        									<input
        										type="search"
        										id="user-search"
        										class="form-control"
        										placeholder="Search users"
        										aria-label="Search users"
        										style="width: 180px" />
        								</div>
        								<select
        									id="user-role-filter"
        									class="form-select form-select-sm w-auto"
        									aria-label="Filter by role">
        									<option value="all" selected>All roles</option>
        									<option value="administrator">Administrator</option>
        									<option value="editor">Editor</option>
        									<option value="author">Author</option>
        									<option value="subscriber">Subscriber</option>
        								</select>
        								<a
											href="/admin/users/form"
        									class="btn btn-sm btn-primary"
        									<i class="bi bi-person-plus-fill me-1" aria-hidden="true"> </i>
        									New user
        								</a>
        							</div>
        						</div>
        					</div>
        				</div>
        				<!--end::Card Header-->
        				<!--begin::Card Body-->
        				<div class="card-body p-0">
        					<div class="table-responsive">
        						<table class="table table-hover align-middle m-0">
        							<thead>
        								<tr>
        									<th>User</th>
        									<th>Email</th>
        									<th>Role</th>
        									<th>Status</th>
        									<th>Created</th>
        									<th class="text-end">Actions</th>
        								</tr>
        							</thead>
        							<tbody>
        								<?php foreach ($users as $user) { ?>
        									<tr>
        										<td>
        											<div class="d-flex align-items-center">
        												<?php if (! empty($user->avatar)): ?>
        													<img src="<?= base_url('uploads/avatars/' . $user->avatar) ?>"
        														alt=""
        														class="img-size-32 rounded-circle me-2"
        														style="object-fit: cover;" />
        												<?php else: ?>
        													<span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-secondary-subtle text-secondary me-2"
        														style="width: 32px; height: 32px;" aria-hidden="true">
        														<i class="bi bi-person-fill"></i>
        													</span>
        												<?php endif; ?>
        												<span class="fw-medium"><?= html_escape($user->name) ?></span>
        											</div>
        										</td>
        										<td><?= $user->email ?></td>
        										<td>
        											<span class="badge <?= $user->role == 'admin' ? 'text-bg-danger' : 'text-bg-success' ?>"> <?= $user->role ?> </span>
        										</td>
        										<td>
        											<span class="badge <?= $user->is_active == 1 ? 'text-bg-success' : 'text-bg-secondary' ?>"><?= $user->is_active == 1 ? 'Active' : 'Inactive' ?></span>
        										</td>
        										<td><?= $user->created_at ?></td>
        										<td class="text-end">
        											<div class="btn-group btn-group-sm">
        												<a
        													href="/admin/users/form/<?= $user->id ?>"
        													type="button"
        													class="btn btn-outline-secondary"
        													aria-label="Edit Alexander Pierce">
        													<i class="bi bi-pencil" aria-hidden="true"> </i>
        												</a>
        												<button type="button"
        													class="btn btn-sm <?= $user->is_active ? 'btn-outline-danger' : 'btn-outline-success' ?>"
        													title="<?= $user->is_active ? 'Deactivate' : 'Activate' ?>"
        													data-bs-toggle="modal" data-bs-target="#modal-toggle-user"
        													data-name="<?= html_escape($user->name) ?>"
        													data-active="<?= $user->is_active ? '1' : '0' ?>"
        													data-action="<?= site_url('admin/users/toggle_active/' . $user->id) ?>"
        													<?= (int) $user->id === (int) $current_user->id ? 'disabled' : '' ?>>
        													<i class="bi <?= $user->is_active ? 'bi-person-x' : 'bi-person-check' ?>"></i>
        												</button>
        											</div>
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
        				<!--end::Card Footer-->
        			</div>
        			<!--end::Card-->
        		</div>
        		<!-- /.col -->
        	</div>
        	<!--end::Row-->


        	<!--begin::Delete User Modal-->
        	<div class="modal fade" id="modal-toggle-user" tabindex="-1" aria-labelledby="modal-toggle-user-label" aria-hidden="true">
        		<div class="modal-dialog">
        			<div class="modal-content">
        				<?= form_open('', array('id' => 'form-toggle-user')) ?>
        				<div class="modal-header">
        					<h5 class="modal-title" id="modal-toggle-user-label"></h5>
        					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        				</div>
        				<div class="modal-body">
        					<p class="mb-0 js-message"></p>
        				</div>
        				<div class="modal-footer">
        					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        					<button type="submit" class="btn js-confirm"></button>
        				</div>
        				<?= form_close() ?>
        			</div>
        		</div>
        	</div>
        	<!--end::Delete User Modal-->
        </div>
        <!--end::Container-->
        <script>
        	document.addEventListener('DOMContentLoaded', function() {
        		const modal = document.getElementById('modal-toggle-user');

        		modal.addEventListener('show.bs.modal', function(event) {
        			const btn = event.relatedTarget;
        			const name = btn.dataset.name;
        			const isActive = btn.dataset.active === '1';

        			document.getElementById('form-toggle-user').action = btn.dataset.action;

        			modal.querySelector('.modal-title').textContent = isActive ? 'Deactivate user' : 'Activate user';

        			const message = modal.querySelector('.js-message');
        			message.textContent = '';
        			message.append(isActive ? 'Deactivate ' : 'Activate ');
        			const strong = document.createElement('strong');
        			strong.textContent = name;
        			message.append(strong, isActive ?
        				'? They will no longer be able to sign in. Their orders, invoices and receipts are kept.' :
        				'? They will be able to sign in again.');

        			const confirm = modal.querySelector('.js-confirm');
        			confirm.textContent = isActive ? 'Deactivate' : 'Activate';
        			confirm.className = 'btn js-confirm ' + (isActive ? 'btn-danger' : 'btn-success');
        		});
        	});
        </script>
