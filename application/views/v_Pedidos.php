<?php $this->load->view('templates/sidebar'); ?>

<link rel="stylesheet" href="<?= base_url("assets/css/globalStyles.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/css/pedidosStyles.css") ?>">

<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class=" col ">
			<div class="card">
				<div class="card-header bg-transparent">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Pedidos</h3>
						</div>
						<div class="col-4 text-right">
							<button class="btn btn-sm btn-primary update-status" data-from="1" data-type="1">Asignar
								estatus
							</button>
							<button class="btn btn-sm btn-success hide" data-id-usuario="" data-type="1">Agregar
							</button>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive py-4">
						<table class="table align-items-center table-flush" id="table-pedidos">
							<thead class="thead-light">
							<tr>
								<th scope="col"></th>
								<th scope="col">ID</th>
								<th scope="col" class="text-center">Estatus</th>
								<th scope="col">Cliente</th>
								<th scope="col">Vendedor</th>
								<th scope="col">No. artículos</th>
								<th scope="col">Total</th>
								<th scope="col">Fecha</th>
								<th scope="col">Pedido</th>
								<th scope="col">Pago</th>
								<th scope="col">Envío</th>
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

<div class="modal fade" id="modal-orders" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	 aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-orders-tittle">Información general</h5>
			</div>
			<form id="my-orders-form" name="my-orders-form">
				<div class="modal-body">

					<div class="checklist-item checklist-item-primary">
						<div class="checklist-info">
							<h5 class="checklist-title mb-0">Fecha</h5>
							<small id="span-compra"></small>
						</div>
					</div>

					<div class="checklist-item checklist-item-success">
						<div class="checklist-info">
							<h5 class="checklist-title mb-0">Cliente</h5>
							<small id="span-nombre"></small>
						</div>
					</div>

					<div class="checklist-item checklist-item-success">
						<div class="checklist-info">
							<h5 class="checklist-title mb-0">Correo electrónico</h5>
							<small id="span-correo"></small>
						</div>
					</div>

					<div class="checklist-item checklist-item-success">
						<div class="checklist-info">
							<h5 class="checklist-title mb-0">Teléfono</h5>
							<small id="span-telefono"></small>
						</div>
					</div>

					<div class="checklist-item checklist-item-success">
						<div class="checklist-info">
							<h5 class="checklist-title mb-0">Dirección</h5>
							<small id="span-direccion"></small>
						</div>
					</div>

					<div class="table-responsive py-0">
						<table class="table align-items-center table-flush">
							<thead>
							<tr>
								<td class="table-user">
									<h5 class="checklist-title mb-0">Producto</h5>
								</td>
								<td class="table-user">
									<h5 class="checklist-title mb-0">Clave</h5>
								</td>
								<td class="table-user">
									<h5 class="checklist-title mb-0">Cantidad</h5>
								</td>
								<td class="table-user">
									<h5 class="checklist-title mb-0">Precio unitario</h5>
								</td>
								<td class="table-user">
									<h5 class="checklist-title mb-0">Total</h5>
								</td>
								<td class="table-user">
									<h5 class="checklist-title mb-0">Total c/d</h5>
								</td>
							</tr>
							</thead>
							<tbody id="tbody-details">
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-xl-4 col-md-4">
							<div class="card card-stats">
								<!-- Card body -->
								<div class="card-body">
									<div class="row">
										<div class="col">
											<h5 class="card-title text-uppercase text-muted mb-0">Subtotal</h5>
											<span class="h2 font-weight-bold mb-0"
												  id="span-subtotal"></span>
										</div>
										<div class="col-auto">
											<div
												class="icon icon-shape bg-gradient-blue text-white rounded-circle shadow">
												<i class="fas fa-coins"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-md-4">
							<div class="card card-stats">
								<!-- Card body -->
								<div class="card-body">
									<div class="row">
										<div class="col">
											<h5 class="card-title text-uppercase text-muted mb-0">Envío</h5>
											<span class="h2 font-weight-bold mb-0" id="span-envio">$1,897</span>
										</div>
										<div class="col-auto">
											<div
												class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
												<i class="fas fa-truck"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-md-4">
							<div class="card card-stats">
								<!-- Card body -->
								<div class="card-body">
									<div class="row">
										<div class="col">
											<h5 class="card-title text-uppercase text-muted mb-0">Total</h5>
											<span class="h2 font-weight-bold mb-0" id="span-total"></span>
										</div>
										<div class="col-auto">
											<div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
												<i class="fas fa-wallet"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link text-red btn-close" data-dismiss="modal" onclick="cleanElement('changelog')">Cerrar</button>
					<button type="button" class="btn btn-success" onclick="printOrder(2)">Envíar correo</button>
					<button type="button" class="btn btn-danger" onclick="printOrder(1)">Imprimir</button>
					<!-- ID PEDIDO -->
					<input type="hidden" id="input_id_pedido" name="input_id_pedido" class="form-control">
				</div>
			</form>
		</div>
	</div>
</div>

<?php $this->load->view('templates/footer'); ?>

<script src="<?= base_url("assets/js/pedidos.js") ?>"></script>

</body>

</html>
