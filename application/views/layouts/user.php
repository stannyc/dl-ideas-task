<!doctype html>
<html lang="en">
<!--begin::Head-->
<?php
$this->load->view('partials/head')
?>
<!--end::Head-->
<!--begin::Body-->

<body class="fixed-header layout-fixed sidebar-expand-lg bg-body-tertiary">
	<!--begin::App Wrapper-->
	<div class="app-wrapper">
		<!--begin::Header-->
		<?php $this->load->view('partials/user/navbar') ?>
		<!--end::Header-->
		<!--begin::Sidebar-->
		<?php $this->load->view('partials/user/sidebar'); ?>
		<!--end::Sidebar-->


		<!--begin::App Main-->
		<main class="app-main">
			<!--begin::App Content Header-->
			<div class="app-content-header">
				<!--begin::Container-->
				<div class="container-fluid">
					<!--begin::Row-->
					<div class="row">
			
						<!-- <div class="col-sm-6">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb float-sm-end">
									<li class="breadcrumb-item"><a href="#">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Starter Page</li>
								</ol>
							</nav>
						</div> -->
					</div>
					<!--end::Row-->
				</div>
				<!--end::Container-->
			</div>
			<!--end::App Content Header-->
			<!--begin::App Content-->
			<div class="app-content">
				<!--begin::Container-->
				<?=  $content; ?>
				
				<!--end::Container-->
			</div>
			<!--end::App Content-->
		</main>
		<!--end::App Main-->
		<!--begin::Footer-->
		<footer class="app-footer">
			<!--begin::To the end-->
			<div class="float-end d-none d-sm-inline">By: Stanny Claus Mangamis</div>
			<!--end::To the end-->
			<!--begin::Copyright-->
			<strong>
				Coding Excercise submitted to
				<a href="https://dlideas.com/" class="text-decoration-none">DL ideas</a>
			</strong>			
			<!--end::Copyright-->
		</footer>
		<!--end::Footer-->
	</div>
	<!--end::App Wrapper-->
	<!--begin::Script-->
	<!--begin::Third Party Plugin(OverlayScrollbars)-->
	<?php
	$this->load->view('partials/scripts')
	?>
	<!--end::OverlayScrollbars Configure-->

	<!--begin::Color Mode Toggle-->
	<!-- The light/dark/auto switcher ships in adminlte.js as the ColorMode
     module (since 4.1) — no page script needed. Only the no-flash snippet
     in <head> stays inline, because it must run before first paint. -->
	<!--end::Color Mode Toggle-->

	<!--end::Script-->
</body>
<!--end::Body-->

</html>
