<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('partials/head') ?>
<body class="bg-body">
	<!-- Navbar -->
	<nav class="navbar navbar-expand-md bg-body border-bottom">
		<div class="container">
			<a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="<?= site_url() ?>">
				<i class="bi bi-bag-heart-fill text-primary fs-4"></i>Simple Store
			</a>
			<div class="ms-auto d-flex gap-2">
				<?php if ( ! empty($current_user)): ?>
					<a href="<?= site_url($current_user->role === 'admin' ? 'admin' : 'shop') ?>" class="btn btn-primary">
						<i class="bi bi-speedometer2 me-1"></i> Go to dashboard
					</a>
				<?php else: ?>
					<a href="<?= site_url('login') ?>" class="btn btn-outline-primary">
						<i class="bi bi-box-arrow-in-right me-1"></i> Sign in
					</a>
				<?php endif; ?>
			</div>
		</div>
	</nav>

	<!-- Hero -->
	<header class="hero py-5 py-lg-6">
		<div class="container py-lg-5">
			<div class="row align-items-center g-5">
				<div class="col-lg-6 text-center text-lg-start">
					<span class="badge rounded-pill text-bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2">
						<i class="bi bi-shield-check me-1"></i> Secure payments by Stripe
					</span>
					<h1 class="hero-title display-4 fw-bold mb-3">
						Shop with confidence.<br>
						<span class="text-primary">Every receipt, in one place.</span>
					</h1>
					<p class="lead text-secondary mb-4">
						Browse our catalogue, check out in seconds, and get an invoice and receipt
						the moment your payment goes through. Your full purchase history is always
						a click away.
					</p>
					<div class="d-flex flex-column flex-sm-row gap-2 justify-content-center justify-content-lg-start">
						<a href="<?= site_url(empty($current_user) ? 'login' : 'shop') ?>" class="btn btn-primary btn-lg px-4">
							<i class="bi bi-cart3 me-1"></i> Start shopping
						</a>
						<a href="#features" class="btn btn-outline-secondary btn-lg px-4">
							How it works
						</a>
					</div>
				</div>

				<div class="col-lg-6 text-center">
					<!-- Illustration: inline SVG, no external image needed -->
					<svg class="hero-art w-100" viewBox="0 0 520 420" role="img" aria-label="Shopping bag, payment card and receipt illustration" xmlns="http://www.w3.org/2000/svg">
						<defs>
							<linearGradient id="bag" x1="0" y1="0" x2="1" y2="1">
								<stop offset="0" stop-color="#4f8dfd"/>
								<stop offset="1" stop-color="#0d6efd"/>
							</linearGradient>
							<linearGradient id="card" x1="0" y1="0" x2="1" y2="1">
								<stop offset="0" stop-color="#20c997"/>
								<stop offset="1" stop-color="#198754"/>
							</linearGradient>
						</defs>

						<!-- soft backdrop -->
						<circle cx="270" cy="210" r="180" fill="#0d6efd" opacity=".06"/>
						<circle cx="270" cy="210" r="130" fill="#0d6efd" opacity=".06"/>

						<!-- receipt (back) -->
						<g transform="rotate(8 380 170)">
							<path d="M330 60 h120 v200 l-15 -10 -15 10 -15 -10 -15 10 -15 -10 -15 10 -15 -10 -15 10 z" fill="#ffffff" stroke="#dee2e6" stroke-width="2"/>
							<rect x="348" y="85" width="70" height="10" rx="5" fill="#adb5bd"/>
							<rect x="348" y="110" width="84" height="8" rx="4" fill="#dee2e6"/>
							<rect x="348" y="128" width="60" height="8" rx="4" fill="#dee2e6"/>
							<rect x="348" y="146" width="76" height="8" rx="4" fill="#dee2e6"/>
							<line x1="348" y1="172" x2="432" y2="172" stroke="#dee2e6" stroke-width="2" stroke-dasharray="5 5"/>
							<rect x="348" y="186" width="40" height="10" rx="5" fill="#198754" opacity=".8"/>
							<rect x="400" y="186" width="32" height="10" rx="5" fill="#198754" opacity=".8"/>
						</g>

						<!-- shopping bag -->
						<path d="M185 150 q0 -60 60 -60 q60 0 60 60" fill="none" stroke="#0a58ca" stroke-width="12" stroke-linecap="round"/>
						<rect x="140" y="140" width="210" height="220" rx="22" fill="url(#bag)"/>
						<rect x="140" y="140" width="210" height="40" rx="22" fill="#ffffff" opacity=".12"/>
						<circle cx="195" cy="175" r="8" fill="#0a58ca"/>
						<circle cx="295" cy="175" r="8" fill="#0a58ca"/>
						<path d="M238 245 l24 24 l46 -52" fill="none" stroke="#ffffff" stroke-width="14" stroke-linecap="round" stroke-linejoin="round"/>

						<!-- payment card (front) -->
						<g transform="translate(-10 18) rotate(-10 150 320)">
							<rect x="60" y="270" width="190" height="115" rx="14" fill="url(#card)"/>
							<rect x="60" y="295" width="190" height="20" fill="#0f5132" opacity=".35"/>
							<rect x="78" y="330" width="34" height="24" rx="4" fill="#ffe8a1"/>
							<rect x="125" y="336" width="100" height="8" rx="4" fill="#ffffff" opacity=".7"/>
							<rect x="125" y="352" width="60" height="8" rx="4" fill="#ffffff" opacity=".5"/>
						</g>

						<!-- sparkles -->
						<g fill="#ffc107">
							<path d="M440 300 l6 14 l14 6 l-14 6 l-6 14 l-6 -14 l-14 -6 l14 -6 z"/>
							<path d="M110 120 l4 9 l9 4 l-9 4 l-4 9 l-4 -9 l-9 -4 l9 -4 z"/>
						</g>
					</svg>
				</div>
			</div>
		</div>
	</header>

	<!-- Features -->
	<section id="features" class="py-5 border-top">
		<div class="container">
			<div class="text-center mb-5">
				<h2 class="fw-bold">Simple from cart to receipt</h2>
				<p class="text-secondary mb-0">Everything you need to buy and keep track of your orders.</p>
			</div>
			<div class="row g-4">
				<div class="col-md-4">
					<div class="card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<span class="feature-icon bg-primary bg-opacity-10 text-primary mb-3"><i class="bi bi-cart-check fs-4"></i></span>
							<h3 class="h5 fw-semibold">Easy checkout</h3>
							<p class="text-secondary mb-0">Add products to your cart and pay securely on Stripe's hosted checkout page.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<span class="feature-icon bg-success bg-opacity-10 text-success mb-3"><i class="bi bi-receipt fs-4"></i></span>
							<h3 class="h5 fw-semibold">Instant invoices &amp; receipts</h3>
							<p class="text-secondary mb-0">Your invoice and receipt are created automatically once the payment succeeds.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card h-100 border-0 shadow-sm">
						<div class="card-body p-4">
							<span class="feature-icon bg-warning bg-opacity-10 text-warning mb-3"><i class="bi bi-clock-history fs-4"></i></span>
							<h3 class="h5 fw-semibold">Full order history</h3>
							<p class="text-secondary mb-0">Look up, view and print any past invoice or receipt whenever you need it.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<footer class="py-4 border-top">
		<div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 small text-secondary">
			<span>&copy; <?= date('Y') ?> Simple Store</span>
			<span>Payments processed securely by Stripe</span>
		</div>
	</footer>

</body>
</html>
