<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
	<meta name="author" content="Creative Tim">
	<title>Food Keepers</title>
	<!-- Favicon -->
	<link rel="icon" href="<?= base_url("assets/img/brand/favicon_fk.png") ?>" type="image/png">
	<!-- Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
	<!-- Icons -->
	<link rel="stylesheet" href="<?= base_url("assets/vendor/nucleo/css/nucleo.css") ?>" type="text/css">
	<link rel="stylesheet" href="<?= base_url("assets/vendor/@fortawesome/fontawesome-free/css/all.min.css") ?>"
		  type="text/css">
	<!-- Argon CSS -->
	<link rel="stylesheet" href="<?= base_url("assets/css/argon.css?v=1.2.0") ?>" type="text/css">

	<link rel="stylesheet" href="<?= base_url("assets/css/loginStyles.css") ?>">
</head>

<body class="bg-default">
<!-- Navbar -->
<nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
	<div class="container">
		<a class="navbar-brand" href="dashboard.html">
			<img src="<?= base_url("assets/img/brand/food_keepers_logo.svg") ?>">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse"
				aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
			<div class="navbar-collapse-header">
				<div class="row">
					<div class="col-6 collapse-brand">
						<a href="dashboard.html">
							<img src="<?= base_url("assets/img/brand/blue.png") ?>">
						</a>
					</div>
					<div class="col-6 collapse-close">
						<button type="button" class="navbar-toggler" data-toggle="collapse"
								data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false"
								aria-label="Toggle navigation">
							<span></span>
							<span></span>
						</button>
					</div>
				</div>
			</div>
			<hr class="d-lg-none"/>
		</div>
	</div>
</nav>
<!-- Main content -->
<div class="main-content m-0">
	<!-- Header -->
	<div class="header py-7 py-lg-8 pt-lg-9 m-0 white_bg">
		<div class="container">
			<div class="header-body text-center mb-7">
				<div class="row justify-content-center">
					<div class="col-xl-5 col-lg-6 col-md-8 px-5">
						<h1 class="text-red">ACTIVAR CUENTA</h1>
					</div>
				</div>
			</div>
		</div>
		<div class="separator separator-bottom separator-skew zindex-100">
			<svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
				 xmlns="http://www.w3.org/2000/svg">
				<polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
			</svg>
		</div>
	</div>
	<!-- Page content -->
	<div class="container mt--8 pb-5">
		<div class="row justify-content-center">
			<div class="col-lg-5 col-md-7">
				<div class="card bg-secondary border-0 mb-0"  id="div-result">
					<div class="card-body px-lg-5 py-lg-5" id="div-general">
						<?php if ($estatus == 3) { ?> <!-- MJ: LA CUENTA NO SE HA ACTIVADO -->
							<div class="text-center text-muted mb-4">
								<small>Para acceder a todas las funcioanalidades de tu cuenta, es necesario que la actives.</small>
							</div>
							<form id="my-activateaccount-form" name="my-activateaccount-form">
								<input type="hidden" id="input_id_usuario" name="input_id_usuario" class="form-control" value="<?= $id_usuario ?>">
								<button type="submit" class="btn btn-danger btn-user btn-block" id="btnEnter">Validar ahora</button>
							</form>
						<?php } else { ?>
							<div class="text-center text-muted mb-4">
								<small>Esta cuenta ya ha sido activada.</small>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Footer -->
<footer class="py-5" id="footer-main">
	<div class="container footer_div">
		<div class="row align-items-center justify-content-xl-between">
			<div class="col-xl-6">
				<div class="copyright text-center text-xl-left text-muted text-white">
					&copy;
					<script>document.write(new Date().getFullYear())</script>
					<a href="https://www.ferroplasticas.com" class="font-weight-bold ml-1 text-white" target="_blank">Food
						Keepers</a>
				</div>
			</div>
			<div class="col-xl-6">
				<ul class="nav nav-footer justify-content-center justify-content-xl-end">
					<li class="nav-item">
						<a href="mailto:ventasweb@ferroplasticas.com" class="nav-link text-white" target="_blank"><i
								class="far fa-envelope"></i> ventasweb@ferroplasticas.com</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link text-white" target="_blank"><i class="rojo fas fa-phone ml-4"></i>
							(442) 372 3133</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</footer>

<!-- Argon Scripts -->
<!-- Core -->
<script src="<?= base_url("assets/vendor/jquery/dist/jquery.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/js-cookie/js.cookie.js") ?>"></script>
<script src="<?= base_url("assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js") ?>"></script>
<!-- Notification -->
<script src="<?= base_url("assets/vendor/bootstrap-notify/bootstrap-notify.min.js")?>"></script>
<script src="<?= base_url("assets/js/alerts.js")?>"></script>
<!-- Argon JS -->
<script src="<?= base_url("assets/js/argon.js?v=1.2.0") ?>"></script>
<script src="<?= base_url("assets/js/validacion.js") ?>"></script>

<script>
	var general_base_url = '<?=base_url()?>';
</script>

</body>

</html>
