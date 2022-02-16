<?php $this->load->view('templates/sidebar'); ?>

<link rel="stylesheet" href="<?= base_url("assets/css/globalStyles.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/css/categoriasStyles.css") ?>">

<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class=" col ">
			<div class="card">
				<div class="card-header bg-transparent">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Categorías</h3>
						</div>
						<div class="col-4 text-right">
							<button class="btn btn-sm btn-success" data-target="#addCategoriaModal" data-toggle="modal">Agregar</button>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive py-4">
						<table id="t_categorias" class="table align-items-center table-flush">
							<thead class="thead-light">
							<tr>
								<th scope="col">ID</th>
								<th scope="col" class="text-center">Estatus</th>
								<th scope="col">Nombre</th>
								<th scope="col">Creación</th>
								<th scope="col" class="text-center">Acciones</th>
							</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- modal para añadir categoria-->
	<div class="modal fade" id="addCategoriaModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
		 aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modal-users-tittle">Agregar categoría</h5>
				</div>
				<form id="addCategoriaForm" class="form" name="addCategoriaForm">
					<div class="modal-body">
						<div class="pl-lg-1">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-2">
									<div class="input-control">
										<input type="text" id="nombre" name="nombre" class="input-field text-uppercase input-only-letters" required maxlength="75" oninput="validateMaxLength(this)" placeholder="Nombre">
										<label class="input-label" for="input_first_name">Nombre</label>
									</div>
								</div>
							</div>
						</div>
						<h6 class="heading-small text-muted mb-4">Añade una imagen</h6>
						<div class="pl-lg-1">
							<div class="input-group">
								<label class="input-group-btn">
									<span class="btn btn-danger btn-file">Seleccionar archivo&hellip;<input type="file" id="imagenCategoria" name="imagenCategoria" lang="es" style="display: none;" accept="image/*"></span>
								</label>
								<input type="text" class="form-control" id="input-file-cat1" readonly>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-simple text-red btn-close" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-danger" onclick="validateFE()">Guardar</button>
						<button type="submit" id="sbmt_button" style="display: none">Cargar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal editar categoria-->
	<div class="modal fade" id="editCategoriaModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
		 aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modal-users-tittle">Editar categoría</h5>
				</div>
				<form id="editCategoryForm" class="form" name="editCategoryForm">
					<div class="modal-body">
						<div class="pl-lg-1">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-2">
									<div class="input-control">
										<input type="text" id="nombreE" name="nombreE" class="input-field text-uppercase input-only-letters" required maxlength="75" oninput="validateMaxLength(this)" placeholder="Nombre">
										<label class="input-label" for="input_first_name">Nombre</label>
									</div>
								</div>
							</div>
						</div>
						<div class="pl-lg-1">
							<div id="img_prev" class="img-container">
							</div>
						</div>
						<div class="pl-lg-1">
							<div id="div_img" class="hide">
								<h6 class="heading-small text-muted mb-4">Añade una imagen</h6>
								<div class="pl-lg-1">
									<div class="input-group">
										<label class="input-group-btn">
											<span class="btn btn-danger btn-file">Seleccionar archivo&hellip;<input type="file" id="imagenNewCategoriaE" name="imagenNewCategoriaE" lang="es" style="display: none;" accept="image/*"></span>
										</label>
										<input type="text" class="form-control" id="input-file-cat2" readonly>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-link text-red btn-close" data-dismiss="modal" onclick="cleanElement('img_prev')">Cerrar</button>
						<button type="submit" class="btn btn-danger">Guardar</button>
						<input type="hidden" name="id_categoriaE" id="id_categoriaE">
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
<script src="<?= base_url("assets/js/categorias.js") ?>"></script>

</body>

</html>
