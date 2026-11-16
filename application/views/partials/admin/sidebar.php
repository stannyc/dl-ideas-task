<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
	<!--begin::Sidebar Brand-->
	<div class="sidebar-brand">
		<!--begin::Brand Link-->
		<a href="/admin" class="brand-link">
			<!--begin::Brand Image-->
			
			<!--end::Brand Image-->
			<!--begin::Brand Text-->
			<span class="brand-text fw-light">DL ideas - Test</span>
			<!--end::Brand Text-->
		</a>
		<!--end::Brand Link-->
	</div>
	<!--end::Sidebar Brand-->	
	<!--begin::Sidebar Wrapper-->
	<div class="sidebar-wrapper">
		<nav class="mt-2" aria-label="Main navigation">
			<!--begin::Sidebar Menu-->
			<ul
				class="nav sidebar-menu flex-column"
				data-lte-toggle="treeview"
				data-accordion="false"
				id="navigation">
				<li class="nav-item">
					<a href="/admin" class="nav-link <?=  nav_active('dashboard') ?> ?>">
						<i class="nav-icon bi bi-speedometer"></i>
						<p>
							Dashboard
							
						</p>
					</a>					
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link <?=  nav_active('user') ?>">
						<i class="nav-icon bi bi-people"></i>
						<p>
							Users
							<i class="nav-arrow bi bi-chevron-right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="/admin/users" class="nav-link">
								<i class="nav-icon bi bi-circle"></i>
								<p>List</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="/admin/users/form" class="nav-link">
								<i class="nav-icon bi bi-circle"></i>
								<p>Form</p>
							</a>
						</li>						
					</ul>
				</li>				
				<li class="nav-item">
					<a href="#" class="nav-link <?=  nav_active('product') ?>">
						<i class="nav-icon bi bi-box-seam-fill"></i>
						<p>
							Product
							<i class="nav-arrow bi bi-chevron-right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="/admin/product" class="nav-link">
								<i class="nav-icon bi bi-circle"></i>
								<p>List</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="/admin/product/form" class="nav-link">
								<i class="nav-icon bi bi-circle"></i>
								<p>Form</p>
							</a>
						</li>
					</ul>
				</li>
			
				<li class="nav-item">
					<a href="/admin/invoices" class="nav-link <?=  nav_active('invoices') ?> ?>">
						<i class="nav-icon bi bi-coin"></i>
						<p>
							Invoices
						</p>
					</a>					
				</li>		
				<li class="nav-item">
					<a href="/admin/receipts" class="nav-link <?=  nav_active('receipts') ?> ?>">
						<i class="nav-icon bi bi-receipt"></i>
						<p>
							Receipts						
						</p>
					</a>					
				</li>		
			</ul>
			<!--end::Sidebar Menu-->
	
		</nav>
	</div>
	<!--end::Sidebar Wrapper-->
</aside>
