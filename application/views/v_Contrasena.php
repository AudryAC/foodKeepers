<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Food Keepers">
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

	<link rel="stylesheet" href="<?= base_url("assets/css/loginStyles.css")?>">
</head>

<body class="bg-default">
<!-- Navbar -->
<nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
	<div class="container">
		<a class="navbar-brand">
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
						<a>
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
			<ul class="navbar-nav align-items-lg-center ml-lg-auto">
				<li class="nav-item">
					<a href="<?= base_url() ?>index.php/Welcome" class="nav-link">
						<span class="nav-link-inner--text text-red">INICIAR SESIÓN</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?= base_url() ?>index.php/Welcome/recoverPassword" class="nav-link">
						<span class="nav-link-inner--text text-red">RECUPERAR CONTRASEÑA</span>
					</a>
				</li>
			</ul>
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
						<h1 class="text-red">¿Se te olvidó tu contraseña?</h1>
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
				<div class="card bg-secondary border-0 mb-0">
					<div class="card-body px-lg-5 py-lg-5">
						<div class="text-center text-muted mb-4" id="msg">
							<small>Ingresa tu dirección de correo electrónico y te enviaremos una contraseña provisional la cual tendrás que restablecer al iniciar sesión.</small>
						</div>
						<?= form_open(base_url() . 'index.php/Usuarios/resetPassword') ?>
						<div class="form-group mb-3">
							<div class="input-group input-group-merge input-group-alternative">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="ni ni-send"></i></span>
								</div>
								<input class="form-control" placeholder="Correo electrónico" type="text" id="input_email_address" name="input_email_address" autocomplete="new-text">
							</div>
						</div>
						<button type="submit" class="btn btn-primary btn-user btn-block" id="btnEnter">Obtener contraseña</button>
						<?= form_close() ?>
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
					&copy; <script>document.write(new Date().getFullYear())</script> <a href="https://www.ferroplasticas.com" class="font-weight-bold ml-1 text-white" target="_blank">Food Keepers</a>
				</div>
			</div>
			<div class="col-xl-6">
				<ul class="nav nav-footer justify-content-center justify-content-xl-end">
					<li class="nav-item">
						<a href="mailto:ventasweb@ferroplasticas.com" class="nav-link text-white" target="_blank"><i class="far fa-envelope"></i> ventasweb@ferroplasticas.com</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link text-white" target="_blank"><i class="rojo fas fa-phone ml-4"></i> (442) 372 3133</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</footer>

<div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="modal-title-default">Se requiere tu atención</h6>
			</div>
			<div class="modal-body text-center">
				<i class="ni ni-bell-55 ni-3x"></i>
				<h4 class="heading mt-4">¡Debes leer esto!</h4>
				<p id="message" class="text-justify"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link ml-auto text-red btn-close" data-dismiss="modal" onclick="redirect()">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<!-- Argon Scripts -->
<!-- Core -->
<script src="<?= base_url("assets/vendor/jquery/dist/jquery.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/js-cookie/js.cookie.js") ?>"></script>
<script src="<?= base_url("assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js") ?>"></script>
<!-- Notifications -->
<script src="<?= base_url("assets/vendor/sweetalert2/dist/sweetalert2.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/bootstrap-notify/bootstrap-notify.min.js") ?>"></script>
<!-- Argon JS -->
<script src="<?= base_url("assets/js/argon.js?v=1.2.0") ?>"></script>
<script src="<?= base_url("assets/js/general_functions.js")?>"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#input_email_address').focus();
	});

	<?php
		if($this->session->userdata('statusCode') == 200)
		{
			$this->session->unset_userdata('statusCode');
		?>
			$(function () {
				$('#message').html("Se enviado una contraseña provisional a la dirección de correo electrónico que ingresaste. Consúltala e inicia sesión.");
				$("#modal-notification").modal();
			});
		<?php
		} else if($this->session->userdata('statusCode') == 500) {
			$this->session->unset_userdata('statusCode');
		?>
			$(function () {
				$('#message').html("Oops, algo salió mal. Por favor inténtalo más tarde.");
				$("#modal-notification").modal();
			});
	<?php
		}
	?>
	
	function redirect() {
		location.replace("<?= base_url() ?>index.php/Welcome")
	}
</script>
</body>

</html>
