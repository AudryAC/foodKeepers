<?php $this->load->view('templates/sidebar'); ?>

<link rel="stylesheet" href="<?= base_url("assets/css/globalStyles.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/css/comprarStyles.css") ?>">

<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class=" col ">
			<div class="card">
				<!--<div class="card-header bg-transparent">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Estatus del pedido</h3>
						</div>
						<div class="col-4 text-right">
						</div>
					</div>
				</div>-->
				<div class="card-body">
					<div class="col-xl-12 col-md-12 col-sm-12">
						<h1>Tu orden ha sido recibida</h1>
					</div>
					<div class="col-xl-12 col-md-12 col-sm-12 hide">
						<?php echo $this->session->userdata('current_order') ?>
					</div>

					<div class="row">
						<div class="col-xl-3 col-md-6 col-sm-12">
							<div class="card card-stats">
								<!-- Card body -->
								<div class="card-body">
									<div class="row">
										<div class="col ml--2 text-center">
											<h4 class="mb-0 text-uppercase">
												<a href="#!">Número de pedido</a>
											</h4>
											<small><?= $id_pedido ?></small>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-md-6 col-sm-12">
							<div class="card card-stats">
								<!-- Card body -->
								<div class="card-body">
									<div class="row">
										<div class="col ml--2 text-center">
											<h4 class="mb-0 text-uppercase">
												<a href="#!">Fecha</a>
											</h4>
											<small><?= $fecha_pedido ?></small>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-md-6 col-sm-12">
							<div class="card card-stats">
								<!-- Card body -->
								<div class="card-body">
									<div class="row">
										<div class="col ml--2 text-center">
											<h4 class="mb-0 text-uppercase">
												<a href="#!">Total</a>
											</h4>
											<small><?= '$'. number_format($importe, 2) ?></small>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-md-6 col-sm-12">
							<div class="card card-stats">
								<!-- Card body -->
								<div class="card-body">
									<div class="row">
										<div class="col ml--2 text-center">
											<h4 class="mb-0 text-uppercase">
												<a href="#!">Método de pago</a>
											</h4>
											<small><?= $forma_pago ?></small>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<!-- Pricing card -->
							<div class="card card-pricing border-0">
								<div class="card-header bg-transparent text-center">
									<h4 class="text-uppercase ls-1 text-primary mb-0">Detalles de pedido</h4>
									<small class="text-uppercase"><b><?= $nombre_cliente ?></b></small>
								</div>
								<div class="card-body px-lg-7">
									<ul class="list-unstyled">
										<li>
											<div class="row align-items-center">
												<div class="col-3">
													<h4 class="mb-0 text-uppercase text-gray">Imagen</h4>
												</div>
												<div class="col-3">
													<h5 class="mb-0 text-uppercase text-gray">Producto</h5>
												</div>
												<div class="col-2">
													<h5 class="mb-0 text-uppercase text-gray">Cantidad</h5>
												</div>
												<div class="col-2">
													<h5 class="mb-0 text-uppercase text-gray">Precio unitario</h5>
												</div>
												<div class="col-2">
													<h5 class="mb-0 text-uppercase text-gray">Subtotal</h5>
												</div>
											</div>
										</li>
										<?php
										for ($i = 0; $i < COUNT($items["name"]); $i ++) {
										?>
										<li>
											<div class="row align-items-center">
												<div class="col-3">
													<img src="<?= base_url() ?>assets/img/products/<?= $items["image"][$i]; ?>" class="avatar avatar-sm mr-2"/>
												</div>
												<div class="col-3">
													<h5 class="mb-0"><?= $items["name"][$i]; ?></h5>
												</div>
												<div class="col-2">
													<h5 class="mb-0"><?= $items["qty"][$i]; ?></h5>
												</div>
												<div class="col-2">
													<h5><?= '$' . number_format($items["price"][$i], 2) ?></h5>
												</div>
												<div class="col-2">
													<h5><?= '$' . number_format($items["subtotal"][$i], 2) ?></h5>
												</div>
											</div>
										</li>
										<?php }
										 ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="row align-items-center">
						<div class="col-8">
						</div>
						<div class="col-4 text-right">
							<a href="<?= base_url() ?>index.php/Comprar" type="button" class="btn btn-success btn-block text-uppercase">Continuar comprando</a>
						</div>
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
</body>

</html>
