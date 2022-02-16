<?php $this->load->view('templates/sidebar'); ?>

<link rel="stylesheet" href="<?= base_url("assets/css/globalStyles.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/css/productosStyles.css") ?>">

<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class=" col ">
			<div class="card">
				<div class="card-header bg-transparent">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Productos</h3>
						</div>
						<div class="col-4 text-right">
							<button class="btn btn-sm btn-success" data-target="#addProductModal" data-toggle="modal">
								Agregar
							</button>
						</div>
					</div>
				</div>

				<div class="card-body">
					<div class="table-responsive py-4">
						<table id="t_productos" class="table align-items-center table-flush">
							<thead class="thead-light">
							<tr>
								<th scope="col">Código barras</th>
								<!--<th scope="col">ID</th>-->
								<th scope="col">Estatus</th>
								<th scope="col">Nombre</th>
								<th scope="col">Categoría</th>
								<th scope="col">Precio Mayorista</th>
								<th scope="col">Precio Lista</th>
								<th scope="col">Código</th>
								<th scope="col">En stock</th>
								<th scope="col">Acción</th>
							</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- modal para añadir producto-->
	<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
		 aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modal-users-tittle">Agregar producto</h5>
				</div>
				<form id="addProductForm" class="form" name="addProductForm">
					<div class="modal-body">
						<h6 class="heading-small text-muted mb-4">Información del producto</h6>

							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-2">
									<div class="input-control">
										<input type="text" id="nombre" name="nombre" class="input-field" required maxlength="75" oninput="validateMaxLength(this)" onkeyup="toUpperCaseInputValue(this);" placeholder="Nombre">
										<label class="input-label" for="input_first_name">Nombre</label>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-2">
									<div class="input-control">
										<input type="text" id="precioMayorista" name="precioMayorista" class="input-field" onkeypress="return filterFloat(event,this);" required placeholder="Precio mayorista">
										<label class="input-label" for="input_last_name">Precio mayorista</label>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-2">
									<div class="input-control">
										<input type="text" id="precioLista" name="precioLista" class="input-field" onkeypress="return filterFloat(event,this);" required maxlength="10" placeholder="Precio lista">
										<label class="input-label" for="input_last_name">Precio lista</label>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-2">
									<div class="input-control">
										<input type="text" id="codigo" name="codigo" class="input-field text-uppercase" required maxlength="75" oninput="validateMaxLength(this)" placeholder="Código">
										<label class="input-label" for="input_last_name">Código</label>
									</div>
								</div>
								<div class="col-lg-8 col-md-8 col-sm-2">
									<div class="input-control">
										<input type="text" id="descripcion" name="descripcion" class="input-field" maxlength="250" oninput="validateMaxLength(this)" placeholder="Descripción" required>
										<label class="input-label" for="input_mothers_last_name">Descripción</label>
									</div>
								</div>
								<div class="col-lg-8 col-md-8 col-sm-2">
									<div class="form-group"><label class="form-control-label select-text" for="categoria">Categorías</label>
										<select class="form-control input-select" id="categoria" name="categoria[]"
												data-toggle="select"
												multiple
												data-style="select-with-transition"
												title="Seleccione una opción"
												placeholder="Seleccione una opción"
												data-size="7">
										</select>
									</div>
								</div>
							</div>

						<hr class="my-4"/>
						<!-- Address -->
						<h6 class="heading-small text-muted mb-4">Añade una imagen</h6>
						<div class="row">
							<div class="col-md-12">
								<div class="custom-file">
									<div class="input-group">
										<label class="input-group-btn">
											<span class="btn btn-danger btn-file">Seleccionar archivo&hellip;<input type="file" id="imagenProducto" name="imagenProducto" lang="es" style="display: none;" accept="image/*"></span>
										</label>
										<input type="text" class="form-control" id="input-file-pr1" readonly>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-link text-red btn-close" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-danger" onclick="validateFE()">Guardar</button>
						<button type="submit" id="sbmt_button" style="display: none">Cargar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal editar producto-->
	<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
		 aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modal-users-tittle">Editar producto</h5>
				</div>
				<form id="editProductForm" class="form" name="editProductForm">
					<div class="modal-body">
						<h6 class="heading-small text-muted mb-4">Información del producto</h6>
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-2">
								<div class="input-control">
									<input type="text" id="nombreE" name="nombreE" class="input-field text-uppercase" required maxlength="75" oninput="validateMaxLength(this)" placeholder="Nombre">
									<label class="input-label" for="input_first_name">Nombre</label>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-2">
								<div class="input-control">
									<input type="text" id="precioMayoristaE" name="precioMayoristaE" class="input-field" onkeypress="return filterFloat(event,this);" required placeholder="Precio mayorista">
									<label class="input-label" for="input_last_name">Precio mayorista</label>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-2">
								<div class="input-control">
									<input type="text" id="precioListaE" name="precioListaE" class="input-field" onkeypress="return filterFloat(event,this);" required placeholder="Precio lista">
									<label class="input-label" for="input_last_name">Precio lista</label>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-2">
								<div class="input-control">
									<input type="text" id="codigoE" name="codigoE" class="input-field text-uppercase" required maxlength="75" oninput="validateMaxLength(this)" placeholder="Código">
									<label class="input-label" for="input_last_name">Código</label>
								</div>
							</div>
							<div class="col-lg-8 col-md-8 col-sm-2">
								<div class="input-control">
									<input type="text" id="descripcionE" name="descripcionE" class="input-field" maxlength="250" oninput="validateMaxLength(this)" placeholder="Descripción" required>
									<label class="input-label" for="input_mothers_last_name">Descripción</label>
								</div>
							</div>
							<div class="col-lg-8 col-md-8 col-sm-2">
								<div class="form-group">
									<label class="form-control-label" for="categoriaE">Categorías</label>
									<select class="form-control" id="categoriaE" name="categoriaE[]"
											data-toggle="select" multiple data-placeholder="Seleccione una opción"
											title="Seleccione una opción">
									</select>
								</div>
							</div>
						</div>
						<hr class="my-4"/>
						<!-- Address -->
						<div id="img_prev">
						</div>
						<div id="div_img" class="hide">
							<h6 class="heading-small text-muted mb-4">Añade una imagen</h6>
							<div class="pl-lg-4">
								<div class="row">
									<div class="col-md-12">
										<div class="custom-file">
											<div class="input-group">
												<label class="input-group-btn">
													<span class="btn btn-danger btn-file">Seleccionar archivo&hellip;<input type="file" id="imagenNewProductoE" name="imagenNewProductoE" lang="es" style="display: none;" accept="image/*"></span>
												</label>
												<input type="text" class="form-control" id="input-file-pr2" readonly>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>


					</div>
					<div class="modal-footer">
						<input type="hidden" name="id_productoE" id="id_productoE">
						<button type="button" class="btn btn-link text-red btn-close" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-danger">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<?php $this->load->view('templates/footer_legend'); ?>
</div>
</div>

<?php $this->load->view('templates/footer'); ?>
<script src="<?= base_url("assets/js/productos.js") ?>"></script>
<script src="<?= base_url("assets/vendor/added/js/JsBarcode.all.min.js") ?>"></script>
</body>

</html>
