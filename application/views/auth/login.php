<!doctype html>
<html lang="en">
<!--begin::Head-->
<?php
$this->load->view('partials/head')
?>

<!--end::Head-->
  <!--begin::Body-->
  <body class="login-page bg-body-secondary">
		<?php $this->load->view('partials/flash') ?>
    <main class="login-box">
      <h1 class="login-logo">
        <a href="/"><b>DL</b>ideas - Simple Store</a>
      </h1>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>

          <?= form_open('login') ?>
            <label class="visually-hidden" for="loginEmail">Email</label>
            <div class="input-group mb-3">
              <input id="loginEmail" type="email" name="email" class="form-control" placeholder="Email" />
              <div class="input-group-text">
                <span class="bi bi-envelope"></span>
              </div>
            </div>
            <label class="visually-hidden" for="loginPassword">Password</label>
            <div class="input-group mb-3">
              <input
                id="loginPassword"
                type="password"
								name="password"
                class="form-control"
                placeholder="Password"
              />
              <div class="input-group-text">
                <span class="bi bi-lock-fill"></span>
              </div>
            </div>
            <!--begin::Row-->
            <div class="row">
              <div class="col-8">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                  <label class="form-check-label" for="flexCheckDefault"> Remember Me </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->
          <?= form_close() ?>



          <!-- <p class="mb-1">
            <a href="forgot-password.html">I forgot my password</a>
          </p> -->

        </div>
        <!-- /.login-card-body -->
      </div>
    </main>
    <!-- /.login-box -->

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
	<?php
	$this->load->view('partials/scripts')
	?>
    <!--end::OverlayScrollbars Configure-->



    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
