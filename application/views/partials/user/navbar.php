<nav class="app-header navbar navbar-expand bg-body">
	<!--begin::Container-->
	<div class="container-fluid">
	
				<div class="col-sm-6">
					<h1 class="mb-0 fs-3"><?= $title ?></h1>
				</div>
		<!--begin::Navbar Search-->
	<!-- 	<form
			class="navbar-search d-none d-xl-block ms-3"
			role="search"
			action="./pages/search-results.html">
			<label for="navbar-search-input" class="visually-hidden">Search</label>
			<div class="navbar-search-field">
				<input
					type="search"
					id="navbar-search-input"
					name="q"
					class="form-control"
					placeholder="Search…"
					autocomplete="off" />
				<button class="navbar-search-submit" type="submit" aria-label="Submit search">
					<i class="bi bi-search" aria-hidden="true"></i>
				</button>
			</div>
		</form> -->
		<!--end::Navbar Search-->

		<!--begin::End Navbar Links-->
		<ul class="navbar-nav ms-auto">
			<!--begin::Search (small screens: the field above is hidden, so link to the search page)-->
			<li class="nav-item d-xl-none">
				<a class="nav-link" href="./pages/search-results.html" aria-label="Search">
					<i class="bi bi-search" aria-hidden="true"></i>
				</a>
			</li>
			<!--end::Search-->
			<!--begin::Messages Dropdown Menu-->
			<li class="nav-item dropdown">
				<a
					class="nav-link"
					data-bs-toggle="dropdown"
					href="#"
					aria-label="Messages: 3 unread">
					<i class="bi bi-cart4"></i>
					<span class="navbar-badge badge text-bg-danger">3</span>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
					<a href="#" class="dropdown-item">
						<!--begin::Message-->
						<div class="d-flex">
							<div class="flex-shrink-0">
								<img
									src="./assets/img/user1-128x128.jpg"
									alt=""
									class="img-size-50 rounded-circle me-3" />
							</div>
							<div class="flex-grow-1">
								<p class="dropdown-item-title">
									Brad Diesel
									<span class="float-end fs-7 text-danger"><i class="bi bi-star-fill"></i></span>
								</p>
								<p class="fs-7">Call me whenever you can...</p>
								<p class="fs-7 text-secondary">
									<i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
								</p>
							</div>
						</div>
						<!--end::Message-->
					</a>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item">
						<!--begin::Message-->
						<div class="d-flex">
							<div class="flex-shrink-0">
								<img
									src="./assets/img/user8-128x128.jpg"
									alt=""
									class="img-size-50 rounded-circle me-3" />
							</div>
							<div class="flex-grow-1">
								<p class="dropdown-item-title">
									John Pierce
									<span class="float-end fs-7 text-secondary">
										<i class="bi bi-star-fill"></i>
									</span>
								</p>
								<p class="fs-7">I got your message bro</p>
								<p class="fs-7 text-secondary">
									<i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
								</p>
							</div>
						</div>
						<!--end::Message-->
					</a>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item">
						<!--begin::Message-->
						<div class="d-flex">
							<div class="flex-shrink-0">
								<img
									src="./assets/img/user3-128x128.jpg"
									alt=""
									class="img-size-50 rounded-circle me-3" />
							</div>
							<div class="flex-grow-1">
								<p class="dropdown-item-title">
									Nora Silvester
									<span class="float-end fs-7 text-warning">
										<i class="bi bi-star-fill"></i>
									</span>
								</p>
								<p class="fs-7">The subject goes here</p>
								<p class="fs-7 text-secondary">
									<i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
								</p>
							</div>
						</div>
						<!--end::Message-->
					</a>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item dropdown-footer">Open Shoping Cart</a>
				</div>
			</li>
			<!--end::Messages Dropdown Menu-->

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
						<p>
							Alexander Pierce - Web Developer
							<small>Member since Nov. 2023</small>
						</p>
					</li>
					<!--end::User Image-->
			
					<!--begin::Menu Footer-->
					<li class="user-footer">
								<!-- <a href="#" class="btn btn-outline-secondary">Profile</a> -->
								<?= form_open('logout', array('class' => 'd-inline')) ?>
								<!-- <a type="submit" class="dropdown-item">
									<i class="bi bi-box-arrow-right me-2"></i>Sign out
								</a> -->
								<button type="submit" class="btn btn-outline-danger float-end">Sign out</button>
								<?= form_close() ?>
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
