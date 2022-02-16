<?php $this->load->view('templates/sidebar'); ?>

<link rel="stylesheet" href="<?= base_url("assets/css/globalStyles.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/css/clientesStyles.css") ?>">

<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class=" col ">
			<div class="card">
				<div class="card-header bg-transparent">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Clientes</h3>
						</div>
						<div class="col-4 text-right">
							<button class="btn btn-sm btn-success add-edit" data-id-cliente="" data-type="1">Agregar</button>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive py-4">
						<table class="table align-items-center table-flush" id="table-clients">
							<thead class="thead-light">
							<tr>
								<th scope="col">ID</th>
								<th scope="col" class="text-center">Estatus</th>
								<th scope="col">Nombre</th>
								<th scope="col">Correo</th>
								<th scope="col">Teléfono</th>
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

<div class="modal fade" id="modal-clients" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	 aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-clients-tittle"></h5>
			</div>
			<form id="my-clients-form" name="my-clients-form" class="form">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="input-control">
								<input type="text" id="input_first_name" name="input_first_name" class="input-field text-uppercase input-only-letters" required maxlength="75" oninput="validateMaxLength(this)" placeholder="Nombre">
								<label class="input-label" for="input_first_name">Nombre</label>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="input-control">
								<input type="text" id="input_last_name" name="input_last_name" class="input-field text-uppercase input-only-letters" required maxlength="75" oninput="validateMaxLength(this)" placeholder="Apellido paterno">
								<label class="input-label" for="input_last_name">Apellido paterno</label>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="input-control">
								<input type="text" id="input_mothers_last_name" name="input_mothers_last_name" class="input-field text-uppercase input-only-letters" required maxlength="75" oninput="validateMaxLength(this)" placeholder="Apellido materno">
								<label class="input-label" for="input_mothers_last_name">Apellido materno</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-8 col-md-8 col-sm-12">
							<div class="input-control">
								<input type="text" id="input_email_address" name="input_email_address" class="input-field text-uppercase" required maxlength="150" oninput="validateMaxLength(this)" placeholder="Correo">
								<label class="input-label" for="input_email_address">Correo</label>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="input-control">
								<input type="text" id="input_phone" name="input_phone" class="input-field" onkeyup="formatPhoneNumber(this)" required maxlength="15" oninput="validateMaxLength(this)" placeholder="Teléfono">
								<label class="input-label" for="input_phone">Teléfono</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-8 col-md-8 col-sm-12">
							<div class="input-control">
								<input type="text" id="input_contact" name="input_contact" class="input-field text-uppercase" required maxlength="250" oninput="validateMaxLength(this)" placeholder="Contacto">
								<label class="input-label" for="input_contact">Contacto</label>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="input-control">
								<select class="input-field" name="select_country" id="select_country" data-style="select-with-transition" title="Seleccione una opción" data-size="7" required onchange="validateNationality(this.options[this.selectedIndex].value != undefined? this.options[this.selectedIndex].value : '0')"></select>
								<label class="input-label" for="select_country">País</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-8 col-md-8 col-sm-12">
							<div class="input-control">
								<input type="text" id="input_street" name="input_street" class="input-field text-uppercase" required maxlength="250" oninput="validateMaxLength(this)" placeholder="Calle">
								<label class="input-label" for="input_street">Calle</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-12">
							<div class="input-control">
								<input type="text" id="input_number" name="input_number" class="input-field text-uppercase" required maxlength="35" oninput="validateMaxLength(this)" placeholder="Número">
							<label class="input-label" for="input_number">Número</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-12">
							<div class="input-control">
								<input type="text" id="input_postal_code" name="input_postal_code" class="input-field input-only-numbers" required maxlength="5" oninput="validateMaxLength(this)" placeholder="CP">
								<label class="input-label" for="input_postal_code">CP</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="input-control">
								<input type="text" id="input_suburb" name="input_suburb" class="input-field text-uppercase" required maxlength="250" oninput="validateMaxLength(this)" placeholder="Colonia">
								<label class="input-label" for="input_suburb">Colonia</label>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="input-control">
								<input type="text" id="input_municipality" name="input_municipality" class="input-field text-uppercase" required maxlength="250" oninput="validateMaxLength(this)" placeholder="Municipio">
								<label class="input-label" for="input_municipality">Municipio</label>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="input-control">
								<select class="input-field hide" name="select_state" id="select_state" data-style="select-with-transition" title="Seleccione una opción" data-size="7"></select>
								<input type="text" id="input_state" name="input_state" class="input-field text-uppercase" maxlength="250" oninput="validateMaxLength(this)" placeholder="Estado">
								<label class="input-label" for="select_state">Estado</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link text-red btn-close" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-danger hide" id="submit_button">Guardar</button>
					<!-- ID CLIENTE -->
					<input type="hidden" id="input_id_cliente" name="input_id_cliente" class="form-control">
					<!-- 1 ADD / 2 UPDATE / 3 SEE INFORMATION -->
					<input type="hidden" id="input_type" name="input_type" class="form-control">
					<!-- 1 UPDATE GENERAL / 2 CHANCE STATUS -->
					<input type="hidden" id="input_type_up" name="input_type_up" class="form-control" value="1">
				</div>
			</form>
		</div>
	</div>
</div>

<?php $this->load->view('templates/footer'); ?>
<script src="<?= base_url("assets/js/ready_clientes.js") ?>"></script>
<script src="<?= base_url("assets/js/clientes.js") ?>"></script>

</body>

</html>
