<?php $this->load->view('templates/sidebar'); ?>

<link rel="stylesheet" href="<?= base_url("assets/css/globalStyles.css")?>">
<link rel="stylesheet" href="<?= base_url("assets/css/usuariosStyles.css")?>">

<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class="col-md-12 col-sm-6">
			<div class="card">
				<div class="card-header bg-transparent">
					<h3 class="mb-0">Mi perfil</h3>
				</div>
				<div class="card-body">
					<form id="my-users-form" name="my-users-form" class="form">
						<h6 class="heading-small text-muted mb-4">Información de usuario</h6>
						<div class="pl-lg-4">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-2">
									<div class="input-control">
										<input type="text" id="input_first_name" name="input_first_name" class="input-field text-uppercase input-only-letters" value="<?= $nombre ?>" maxlength="45" oninput="validateMaxLength(this)" placeholder="Nombre">
										<label class="input-label" for="input_first_name">Nombre</label>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-2">
									<div class="input-control">
										<input type="text" id="input_last_name"  name="input_last_name" class="input-field text-uppercase input-only-letters" value="<?= $apellido_paterno ?>" maxlength="35" oninput="validateMaxLength(this)" placeholder="Apellido paterno">
										<label class="input-label" for="input_last_name">Apellido paterno</label>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-2">
									<div class="input-control">
										<input type="text" id="input_mothers_last_name" name="input_mothers_last_name" class="input-field text-uppercase input-only-letters" value="<?= $apellido_materno ?>" maxlength="35" oninput="validateMaxLength(this)" placeholder="Apellido materno">
										<label class="input-label" for="input_mothers_last_name">Apellido materno</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="input-control">
										<input type="text" id="input_username" class="input-field" autocomplete="new-text" readonly value="<?= $usuario ?>" maxlength="50" oninput="validateMaxLength(this)" placeholder="Nombre de usuario">
										<label class="input-label" for="input_username">Nombre de usuario</label>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="input-control">
										<div class="input-group mb-3">
											<input type="password" id="input-password" name="input-password" class="input-field" autocomplete="new-text" value="<?= $contrasena ?>" maxlength="15" oninput="validateMaxLength(this)" placeholder="Contraseña">
											<label class="input-label" for="input-password">Contraseña</label>
											<!--<div class="input-group-append">
												<span class="input-group-text" onclick="showPassword()"><i class="far fa-eye" id="eye_icon"></i></span>
											</div>-->
										</div>
									</div>
								</div>
							</div>
						</div>
						<hr class="my-4" />
						<!-- Address -->
						<h6 class="heading-small text-muted mb-4">Información general</h6>
						<div class="pl-lg-4">
							<div class="row">
								<div class="col-md-12">
									<div class="input-control">
										<input type="email" id="input_email_address" name="input_email_address" class="input-field text-uppercase" value="<?= $correo ?>" maxlength="150" oninput="validateMaxLength(this)" placeholder="Correo elctrónico">
										<label class="input-label" for="input_email_address">Correo elctrónico</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4">
									<div class="input-control">
										<input type="text" id="input_phone" name="input_phone" class="input-field text-uppercase" onkeyup="formatPhoneNumber(this)" maxlength="15" placeholder="Teléfono">
										<label class="input-label" for="input_phone">Teléfono</label>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="input-control">
										<input type="text" id="input_user_type" class="input-field" readonly value="<?= $tipo ?>" placeholder="Tipo de usuario">
										<label class="input-label" for="input_user_type">Tipo de usuario</label>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="input-control">
										<input type="text" id="input_location" class="input-field" readonly value="<?= $ubicacion ?>" placeholder="Ubicación">
										<label class="input-label" for="input_location">Ubicación</label>
									</div>
								</div>
							</div>
						</div>
						<hr class="my-4" />
						<div class="pl-lg-4">
							<div class="row align-items-center">
								<div class="col-10"></div>
								<div class="col-lg-2 col-md-2 col-sm-12 text-right">
									<button type="submit" class="btn btn-danger btn-user btn-block" id="btnEnter">Guardar</button>
									<input type="hidden" id="input_id_usuario" name="input_id_usuario" class="form-control" value="<?= $id_usuario ?>">
									<input type="hidden" id="input_type" name="input_type" class="form-control" value="2">
									<input type="hidden" id="input_type_up" name="input_type_up" class="form-control" value="1">
									<input type="hidden" id="input_form" name="input_form" class="form-control" value="2">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<?php $this->load->view('templates/footer_legend'); ?>
</div>
</div>

<?php $this->load->view('templates/footer'); ?>

<script src="<?= base_url("assets/js/usuarios.js")?>"></script>
<script>
	$("#input_phone").val(formatPhoneNumber(<?= $telefono ?>));
</script>
</body>

</html>
