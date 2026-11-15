		<nav class="app-header navbar navbar-expand bg-body">
			<!--begin::Container-->
			<div class="container-fluid">
				<div class="col-sm-6">
					<h1 class="mb-0 fs-3"><?= $title ?></h1>
				</div>
				<!--begin::End Navbar Links-->
				<ul class="navbar-nav ms-auto">
					<!--begin::Fullscreen Toggle-->
					<li class="nav-item">
						<a
							class="nav-link"
							href="#"
							data-lte-toggle="fullscreen"
							aria-label="Toggle fullscreen">
							<i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
							<i data-lte-icon="minimize" class="bi bi-fullscreen-exit d-none"></i>
						</a>
					</li>
					<!--end::Fullscreen Toggle-->
					<!--begin::Color Mode Toggle (#6010)-->
					<li class="nav-item dropdown">
						<a
							class="nav-link"
							href="#"
							id="bd-theme"
							aria-label="Toggle color scheme"
							data-bs-toggle="dropdown"
							aria-expanded="false">
							<i class="bi bi-sun-fill" data-lte-theme-icon="light"></i>
							<i class="bi bi-moon-fill d-none" data-lte-theme-icon="dark"></i>
							<i class="bi bi-circle-half d-none" data-lte-theme-icon="auto"></i>
						</a>
						<ul
							class="dropdown-menu dropdown-menu-end"
							aria-labelledby="bd-theme"
							style="--bs-dropdown-min-width: 8rem">
							<li>
								<button
									type="button"
									class="dropdown-item d-flex align-items-center"
									data-bs-theme-value="light"
									aria-pressed="false">
									<i class="bi bi-sun-fill me-2"></i>
									Light
									<i class="bi bi-check-lg ms-auto d-none"></i>
								</button>
							</li>
							<li>
								<button
									type="button"
									class="dropdown-item d-flex align-items-center"
									data-bs-theme-value="dark"
									aria-pressed="false">
									<i class="bi bi-moon-fill me-2"></i>
									Dark
									<i class="bi bi-check-lg ms-auto d-none"></i>
								</button>
							</li>
							<li>
								<button
									type="button"
									class="dropdown-item d-flex align-items-center active"
									data-bs-theme-value="auto"
									aria-pressed="true">
									<i class="bi bi-circle-half me-2"></i>
									Auto
									<i class="bi bi-check-lg ms-auto d-none"></i>
								</button>
							</li>
						</ul>
					</li>
					<!--end::Color Mode Toggle-->

					<!--begin::User Menu Dropdown-->
					<li class="nav-item dropdown user-menu">
						<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
							<span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-secondary text-white img-size-32" style="height: 32px;">
								<i class="bi bi-person-fill fs-4"></i>
							</span>
							<span class="d-none d-xl-inline">Alexander Pierce</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
							<!--begin::User Image-->
							<li class="user-header text-bg-primary">
								<span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white text-secondary img-size-50" style="height: 50px;">
								<i class="bi bi-person-fill fs-4"></i>
							</span>
								<!-- <img
									src="./assets/img/user2-160x160.jpg"
									class="rounded-circle shadow"
									alt="Alexander Pierce" /> -->
								<p>
									Alexander Pierce - Web Developer
									<small>Member since Nov. 2023</small>
								</p>
							</li>
							<!--end::User Image-->

							<!--begin::Menu Footer-->
							<li class="user-footer">
								<a href="#" class="btn btn-outline-secondary">Profile</a>
								<a href="#" class="btn btn-outline-danger float-end">Sign out</a>
							</li>
							<!--end::Menu Footer-->
						</ul>
					</li>
					<!--end::User Menu Dropdown-->
				</ul>
				<!--end::End Navbar Links-->
			</div>
			<!--end::Container-->
		</nav>
