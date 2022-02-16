<?php $this->load->view('templates/sidebar'); ?>

<link rel="stylesheet" href="<?= base_url("assets/css/globalStyles.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/css/usuariosStyles.css") ?>">

<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class=" col ">
			<div class="card">
				<div class="card-header bg-transparent">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Usuarioss</h3>
						</div>
						<div class="col-4 text-right">
							<button class="btn btn-sm btn-success add-edit" data-id-usuario="" data-type="1">Agregar</button>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive py-4">
						<table class="table align-items-center table-flush" id="table-users">
							<thead class="thead-light">
							<tr>
								<th scope="col">ID</th>
								<th scope="col" class="text-center">Estatus</th>
								<th scope="col">Nombre</th>
								<th scope="col">Correo</th>
								<th scope="col">Teléfono</th>
								<th scope="col">Usuario</th>
								<th scope="col">Tipo</th>
								<th scope="col">Ubicación</th>
								<th scope="col" class="text-center">Acciones</th>
							</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<?php $this->load->view('templates/footer_legend'); ?>
</div>
</div>

<div class="modal fade" id="modal-users" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	 aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-users-tittle"></h5>
			</div>
			<form id="my-users-form" name="my-users-form" class="form">
				<div class="modal-body">
					<h6 class="heading-small text-muted mb-4">Información de usuario</h6>
					<div class="pl-lg-0">
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-2">
								<div class="input-control">
									<input type="text" id="input_first_name" name="input_first_name" class="input-field text-uppercase input-only-letters" required maxlength="45" oninput="validateMaxLength(this)" placeholder="Nombre">
									<label class="input-label" for="input_first_name">Nombre</label>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-2">
								<div class="input-control">
									<input type="text" id="input_last_name" name="input_last_name" class="input-field text-uppercase input-only-letters" required maxlength="35" oninput="validateMaxLength(this)" placeholder="Apellido paterno">
									<label class="input-label" for="input_last_name">Apellido paterno</label>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-2">
								<div class="input-control">
									<input type="text" id="input_mothers_last_name" name="input_mothers_last_name" class="input-field text-uppercase input-only-letters" required maxlength="35" oninput="validateMaxLength(this)" placeholder="Apellido materno">
									<label class="input-label" for="input_mothers_last_name">Apellido materno</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="input-control">
									<input type="text" id="input_username" name="input_username" class="input-field text-uppercase" autocomplete="off" required maxlength="50" oninput="validateMaxLength(this)" placeholder="Nombre de usuario">
									<label class="input-label" for="input_username">Nombre de usuario</label>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="input-control">
									<div class="input-group mb-3">
										<input type="password" id="input-password" name="input-password" class="input-field" autocomplete="new-text" required maxlength="15" oninput="validateMaxLength(this)" placeholder="Contraseña">
										<!--<div class="input-group-append">
											<span class="input-group-text" onclick="showPassword()"><i class="far fa-eye" id="eye_icon"></i></span>
										</div>-->
										<label class="input-label" for="input-password">Contraseña</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<hr class="my-4"/>
					<!-- Address -->
					<h6 class="heading-small text-muted mb-4">Información general</h6>
					<div class="pl-lg-0">
						<div class="row">
							<div class="col-md-12">
								<div class="input-control">
									<input type="email" id="input_email_address" name="input_email_address" class="input-field text-uppercase" required maxlength="150" oninput="validateMaxLength(this)" placeholder="Correo elctrónico">
									<label class="input-label" for="input_email_address">Correo elctrónico</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<div class="input-control">
									<input type="text" id="input_phone" name="input_phone" class="input-field" onkeyup="formatPhoneNumber(this)" required maxlength="15" oninput="validateMaxLength(this)" placeholder="Teléfono">
									<label class="input-label" for="input_phone">Teléfono</label>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-control">
									<select class="input-field" name="select_user_type" id="select_user_type" data-style="select-with-transition" title="Seleccione una opción" data-size="7" required></select>
									<label class="input-label" for="input_user_type">Tipo de usuario</label>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-control">
									<select class="input-field" name="select_location" id="select_location" data-style="select-with-transition" title="Seleccione una opción" data-size="7" required></select>
									<label class="input-label" for="input_location">Ubicación</label>
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link text-red btn-close" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-danger">Guardar</button>
					<input type="hidden" id="input_id_usuario" name="input_id_usuario" class="form-control"> <!-- MJ: ID USUARIO -->
					<input type="hidden" id="input_type" name="input_type" class="form-control"> <!-- MJ: 1 ADD / 2 UPDATE -->
					<input type="hidden" id="input_type_up" name="input_type_up" class="form-control" value="1"> <!-- MJ: 1 UPDATE GENERAL / 2 CHANCE STATUS -->
					<input type="hidden" id="input_form" name="input_form" class="form-control"> <!-- MJ: 1 USERS FORM / 2 PROFILE FORM -->
				</div>
			</form>
		</div>
	</div>
</div>

<?php $this->load->view('templates/footer'); ?>

<script src="<?= base_url("assets/js/ready_usuarios.js") ?>"></script>
<script src="<?= base_url("assets/js/usuarios.js") ?>"></script>

</body>

</html>
