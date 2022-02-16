<?php $this->load->view('templates/sidebar'); ?>

<link rel="stylesheet" href="<?= base_url("assets/css/globalStyles.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/css/inventarioStyles.css") ?>">

<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class=" col ">
			<div class="card">
				<div class="card-header bg-transparent">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Inventario</h3>
						</div>
						<div class="col-4 text-right">
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive py-4">
						<table class="table align-items-center table-flush" id="table-stocks">
							<thead class="thead-light">
							<tr>
								<th scope="col">ID</th>
								<th scope="col">Nombre</th>
								<th scope="col">Categoría</th>
								<th scope="col">Cantidad</th>
								<th scope="col">Apartado</th>
								<th scope="col">Máximo</th>
								<th scope="col">Mínimo</th>
								<th scope="col">Acciones</th>
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

<div class="modal fade" id="modal-stock" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	 aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Editar registro</h5>
			</div>
			<form id="my-stock-form" name="my-stock-form" class="form">
				<div class="modal-body">
					<div class="pl-lg-0">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="input-control">
									<input type="text" id="input-product" name="input_producto" class="input-field" disabled placeholder="Producto">
									<label class="input-label" for="input-product">Producto</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-12">
								<div class="input-control">
									<input type="text" id="input_quantity" name="input_quantity" class="input-field input-only-numbers" maxlength="15" oninput="validateMaxLength(this)" required placeholder="Cantidad">
									<label class="input-label" for="input_quantity">Cantidad</label>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12">
								<div class="input-control">
									<input type="text" id="input_maximum" name="input_maximum" class="input-field input-only-numbers" maxlength="11" oninput="validateMaxLength(this)" required placeholder="Máximo">
									<label class="input-label" for="input_maximum">Máximo</label>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12">
								<div class="input-control">
									<input type="text" id="input_minimum" name="input_minimum" class="input-field input-only-numbers" maxlength="11" oninput="validateMaxLength(this)" required placeholder="Mínimo">
									<label class="input-label" for="input_minimum">Mínimo</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link text-red btn-close" data-dismiss="modal" onclick="cleanFields()">Cerrar</button>
					<button type="submit" class="btn btn-danger">Guardar</button>
					<input type="hidden" id="input_id_stock" name="input_id_stock" class="form-control"> <!-- MJ: ID STOCK -->
				</div>
			</form>
		</div>
	</div>
</div>

<?php $this->load->view('templates/footer'); ?>
<script src="<?= base_url("assets/js/inventario.js") ?>"></script>

</body>

</html>
