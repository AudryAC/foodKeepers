<?php $this->load->view('templates/sidebar'); ?>

<link rel="stylesheet" href="<?= base_url("assets/css/globalStyles.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/css/enviosStyles.css") ?>">

<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class="col">
			<div class="card">
				<div class="card-header bg-transparent">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Envíos</h3>
						</div>
						<div class="col-4 text-right">
							<button class="btn btn-sm btn-primary update-status" data-from="2" data-type="2">Asignar estatus</button>
							<button class="btn btn-sm btn-success hide" data-id-usuario="" data-type="1">Agregar</button>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive py-4">
						<table class="table align-items-center table-flush" id="table-envios">
							<thead class="thead-light">
							<tr>
								<th scope="col"></th>
								<th scope="col">ID</th>
								<th scope="col" class="text-center">Estatus</th>
								<th scope="col">Pedido</th>
								<th scope="col">Cliente</th>
								<th scope="col">No. artículos</th>
								<th scope="col">Total</th>
								<th scope="col">Fecha</th>
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

<?php $this->load->view('templates/footer'); ?>

<script src="<?= base_url("assets/js/envios.js") ?>"></script>
</body>

</html>
