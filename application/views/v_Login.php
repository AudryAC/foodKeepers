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
						<h1 class="text-red">¡Deploy changes from git!</h1>
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
							<small>Inicia sesión en tu cuenta</small>
						</div>
						<?= form_open(base_url() . 'index.php/Welcome/validateLogin') ?>
						<div class="form-group mb-3">
							<div class="input-group input-group-merge input-group-alternative">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="ni ni-satisfied"></i></span>
								</div>
								<input class="form-control" placeholder="Usuario" type="text" id="input_username" name="input_username" autocomplete="new-text">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group input-group-merge input-group-alternative">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
								</div>
								<input class="form-control" placeholder="Contraseña" type="password" id="input-password"
									   name="input-password" autocomplete="new-text">
								<div class="input-group-prepend">
									<span class="input-group-text" onclick="showPassword()"><i class="far fa-eye" id="eye_icon"></i></span>
								</div>
							</div>
						</div>

						<?= form_hidden('token', $token) ?>
						<button type="submit" class="btn btn-success btn-user btn-block" id="btnEnter">Iniciar sesión</button>
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

<div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="modal-title-default">Se requiere tu atención</h6>
			</div>
			<form id="my-resetsession-form" name="my-resetsession-form">
				<div class="modal-body text-center">
					<i class="ni ni-bell-55 ni-3x"></i>
					<h4 class="heading mt-4">¡Debes leer esto!</h4>
					<p class="text-justify">Esta cuenta ya se encuentra abierta en algún otro dispositivo.<br><b>¿Estás seguro de que quieres cerrar sesión en todos los dispositivos?</b></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link ml-auto text-red btn-close" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-danger">Confirmar</button>
					<input type="hidden" id="input_user" name="input_user" class="form-control">
					<input type="hidden" id="input_id" name="input_id" class="form-control">
				</div>
			</form>
		</div>
	</div>
</div>

<?php
if ($this->input->get('error')) : ?>
	<script type="text/javascript">
		<?php if($this->input->get('error') == 1) : ?>
		alert("Usuario / Contraseña incorrectos");
		<?php elseif($this->input->get('error') == 2): ?>
		alert("Acces restringido");
		<?php endif; ?>
	</script>
<?php endif; ?>

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
<script src="<?= base_url("assets/js/login.js") ?>"></script>
<script src="<?= base_url("assets/js/general_functions.js") ?>"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#usuario').focus();

		setTimeout(function () {
			// after 1000 ms we add the class animated to the login/register card
			$('.card').removeClass('card-hidden');
		}, 700)
	});

	<?php
	if ($this->session->userdata('errorLogin') == 33)
	{
		$this->session->unset_userdata('errorLogin');
	?>
	$(function () {
		$('#msg').html('');
		$('#msg').append('<small>Error al iniciar sesión, verifica tu información e intenta de nuevo</small>');
	});
	<?php
	} else if ($this->session->userdata('errorLogin') == 34) // MJ: NO SE PUDO ESTABLECER EL INCIO DE SESIÓN PORQUE ESTA CUENTA YA SE ENCUENTRA ABIERTA EN ALGÚN OTRO DISPOSITIVO
	{
	?>
	$(function () {
		$('#msg').html('');
		$('#msg').append('<small>Esta cuenta ya se encuentra abierta en algún otro dispositivo.</small>');
		var usuario = '<?= $this->session->userdata('userLogin') ?>';
		var id = '<?= $this->session->userdata('idSesion') ?>';
		$("#modal-notification").modal();
		$("#input_user").val(usuario);
		$("#input_id").val(id);
	});
	<?php
	$this->session->unset_userdata('errorLogin');
	$this->session->unset_userdata('userLogin');
	$this->session->unset_userdata('idSesion');
	} else if ($this->session->userdata('errorLogin') == 35) // MJ: ERROR, LA CUENTA AÚN NO HA SIDO ACTIVADA
	{
	?>
	$(function () {
		$('#msg').html('');
		$('#msg').append('<small>La cuenta a la que tratas de acceder aún no ha sido activada.</small>');
	});
	<?php
	} ?>

</script>
</body>

</html>
