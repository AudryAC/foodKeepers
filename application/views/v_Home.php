<?php $this->load->view('templates/sidebar'); ?>
<link rel="stylesheet" href="<?= base_url("assets/css/globalStyles.css") ?>">

<!-- Page content-->
<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class=" col ">
			<div class="card">
				<div class="card-header bg-transparent">
					<h3 class="mb-0">Dashboard</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-xl-3 col-md-6 col-sm-12">
							<div class="card card-stats">
								<!-- Card body -->
								<div class="card-body">
									<div class="row">
										<div class="col">
											<h5 class="card-title text-uppercase text-muted mb-0">Nuevos clientes</h5>
											<span class="h2 font-weight-bold mb-0"><?= $totalc ?></span>
										</div>
										<div class="col-auto">
											<div
												class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
												<i class="ni ni-money-coins"></i>
											</div>
										</div>
									</div>
									<p class="mt-3 mb-0 text-sm">
										<span class="text-success mr-2"><i
												class="fas fa-arrow-up"></i> <?= $pc ?>%</span>
										<span class="text-nowrap">Mes actual</span>
									</p>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-md-6 col-sm-12">
							<div class="card card-stats">
								<!-- Card body -->
								<div class="card-body">
									<div class="row">
										<div class="col">
											<h5 class="card-title text-uppercase text-muted mb-0">Total pedidos</h5>
											<span class="h2 font-weight-bold mb-0"><?= $totalp ?></span>
										</div>
										<div class="col-auto">
											<div
												class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
												<i class="ni ni-chart-pie-35"></i>
											</div>
										</div>
									</div>
									<p class="mt-3 mb-0 text-sm">
										<span class="text-success mr-2"><i
												class="fas fa-arrow-up"></i> <?= $pp ?>%</span>
										<span class="text-nowrap">Mes actual</span>
									</p>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-md-6 col-sm-12">
							<div class="card card-stats">
								<!-- Card body -->
								<div class="card-body">
									<div class="row">
										<div class="col">
											<h5 class="card-title text-uppercase text-muted mb-0">Total envíos</h5>
											<span class="h2 font-weight-bold mb-0"><?= $totale ?></span>
										</div>
										<div class="col-auto">
											<div
												class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
												<i class="ni ni-chart-bar-32"></i>
											</div>
										</div>
									</div>
									<p class="mt-3 mb-0 text-sm">
										<span class="text-success mr-2"><i
												class="fas fa-arrow-up"></i> <?= $pe ?>%</span>
										<span class="text-nowrap">Mes actual</span>
									</p>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-md-6 col-sm-12">
							<div class="card card-stats">
								<!-- Card body -->
								<div class="card-body">
									<div class="row">
										<div class="col">
											<h5 class="card-title text-uppercase text-muted mb-0">Nuevos usuarios</h5>
											<span class="h2 font-weight-bold mb-0"><?= $totalu ?></span>
										</div>
										<div class="col-auto">
											<div
												class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
												<i class="ni ni-active-40"></i>
											</div>
										</div>
									</div>
									<p class="mt-3 mb-0 text-sm">
										<span class="text-success mr-2"><i
												class="fas fa-arrow-up"></i> <?= $pu ?>%</span>
										<span class="text-nowrap">Mes actual</span>
									</p>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xl-6 col-md-12 col-sm-12">
							<!--* Card header *-->
							<!--* Card body *-->
							<!--* Card init *-->
							<div class="card">
								<!-- Card header -->
								<div class="card-header">
									<!-- Surtitle -->
									<h6 class="surtitle">Crecimiento</h6>
									<!-- Title -->
									<h5 class="h3 mb-0">Total clientes <small>año actual</small></h5>
								</div>
								<!-- Card body -->
								<div class="card-body">
									<div class="chart">
										<!-- Chart wrapper -->
										<canvas id="chart-sales" class="chart-canvas"></canvas>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-md-12 col-sm-12">
							<!--* Card header *-->
							<!--* Card body *-->
							<!--* Card init *-->
							<div class="card">
								<!-- Card header -->
								<div class="card-header">
									<!-- Surtitle -->
									<h6 class="surtitle">General</h6>
									<!-- Title -->
									<h5 class="h3 mb-0">Pedidos <small>año actual</small></h5>
								</div>
								<!-- Card body -->
								<div class="card-body">
									<div class="chart">
										<!-- Chart wrapper -->
										<canvas id="chart-bars" class="chart-canvas"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xl-6 col-md-12 col-sm-12">
							<div class="card">
								<div class="card-header border-0">
									<div class="row align-items-center">
										<div class="col">
											<h3 class="mb-0">Top 5 de mayores ventas</h3>
										</div>
										<div class="col text-right">
											<a href="#!" class="btn btn-sm btn-primary">Ver más</a>
										</div>
									</div>
								</div>
								<div class="table-responsive">
									<!-- Projects table -->
									<table class="table align-items-center table-flush">
										<thead class="thead-light">
										<tr>
											<th scope="col">En stock</th>
											<th scope="col">Nombre</th>
											<th scope="col">Precio</th>
											<th scope="col">Venta mensual</th>
										</tr>
										</thead>
										<tbody>
										<tr>
											<th scope="row">
												<p class="stock-g m-0">220</p>
											</th>
											<td>
												Jarra Hermética 1L.
											</td>
											<td>
												$25.00
											</td>
											<td>
												350pzs.
											</td>
										</tr>
										<tr>
											<th scope="row">
												<p class="stock-g m-0">548</p>
											</th>
											<td>
												Contenedor jumbo grande
											</td>
											<td>
												$205
											</td>
											<td>
												315pzs.
											</td>
										</tr>
										<tr>
											<th scope="row">
												<p class="stock-g m-0">132</p>
											</th>
											<td>
												Caja master
											</td>
											<td>
												$193.20
											</td>
											<td>
												298pzs.
											</td>
										</tr>
										<tr>
											<th scope="row">
												<p class="stock-g m-0">275</p>
											</th>
											<td>
												Cubeta 16 litros
											</td>
											<td>
												$42.00
											</td>
											<td>
												281pzs.
											</td>
										</tr>
										<tr>
											<th scope="row">
												<p class="stock-b m-0">32</p>
											</th>
											<td>
												Caja colapsable
											</td>
											<td>
												$193.20
											</td>
											<td>
												256pzs.
											</td>
										</tr>
										</tbody>
									</table>
								</div><!-- END table responsive -->
							</div><!-- END card -->
						</div><!-- END col-->
						<div class="col-xl-6 col-md-12 col-sm-12">
							<div class="card">
								<div class="card-header border-0">
									<div class="row align-items-center">
										<div class="col">
											<h3 class="mb-0">Top 5 de menores ventas</h3>
										</div>
										<div class="col text-right">
											<a href="#!" class="btn btn-sm btn-primary">Ver más</a>
										</div>
									</div>
								</div>
								<div class="table-responsive">
									<!-- Projects table -->
									<table class="table align-items-center table-flush">
										<thead class="thead-light">
										<tr>
											<th scope="col">En stock</th>
											<th scope="col">Nombre</th>
											<th scope="col">Precio</th>
											<th scope="col">Venta mensual</th>
										</tr>
										</thead>
										<tbody>
										<tr>
											<th scope="row">
												<p class="stock-b m-0">10</p>
											</th>
											<td>
												Molde de galletas 12 pzs.
											</td>
											<td>
												$41.85
											</td>
											<td>
												9pzs.
											</td>
										</tr>
										<tr>
											<th scope="row">
												<p class="stock-g m-0">66</p>
											</th>
											<td>
												Minigelatineros Jgo. de 6pzs.
											</td>
											<td>
												$49.90
											</td>
											<td>
												3pzs.
											</td>
										</tr>
										<tr>
											<th scope="row">
												<p class="stock-b m-0">0</p>
											</th>
											<td>
												Rack de cocina con especieros
											</td>
											<td>
												$69.90
											</td>
											<td>
												0pzs.
											</td>
										</tr>
										<tr>
											<th scope="row">
												<p class="stock-b m-0">1</p>
											</th>
											<td>
												Practimóvil oval 4 niveles
											</td>
											<td>
												$110.00
											</td>
											<td>
												0 pzs.
											</td>
										</tr>
										<tr>
											<th scope="row">
												<p class="stock-b m-0">0</p>
											</th>
											<td>
												Combo tapas flex.
											</td>
											<td>
												$125.55
											</td>
											<td>
												0 pzs.
											</td>
										</tr>
										</tbody>
									</table>
								</div><!-- END table responsive -->
							</div><!-- END card -->
						</div><!-- END col-->
					</div><!-- END row -->
				</div>
			</div>
		</div>
	</div>

	<?php $this->load->view('templates/footer_legend'); ?>
</div>
</div>

<?php $this->load->view('templates/footer'); ?>

<script>
	var tc = <?php echo json_encode($total_c); ?>;
	var tmc = <?php echo json_encode($total_mc); ?>;
	var to = <?php echo json_encode($total_o); ?>;
	var tmo = <?php echo json_encode($total_mo); ?>;

	tc = tc.toString().split(',').map(function(item) {
		return parseInt(item, 10);
	});

	to = to.toString().split(',').map(function(item) {
		return parseInt(item, 10);
	});

</script>

<script src="<?= base_url("assets/js/home.js") ?>"></script>

</body>

</html>
