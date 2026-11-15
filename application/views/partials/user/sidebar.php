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
					<a href="/home" class="nav-link <?=  nav_active('dashboard') ?> ?>">
						<i class="nav-icon bi bi-speedometer"></i>
						<p>
							Shop							
						</p>
					</a>					
				</li>
				<li class="nav-item">
					<a href="/invoices" class="nav-link <?=  nav_active('dashboard') ?> ?>">
						<i class="nav-icon bi bi-speedometer"></i>
						<p>
							Invoices
						</p>
					</a>					
				</li>		
				<li class="nav-item">
					<a href="/receipts" class="nav-link <?=  nav_active('dashboard') ?> ?>">
						<i class="nav-icon bi bi-speedometer"></i>
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
