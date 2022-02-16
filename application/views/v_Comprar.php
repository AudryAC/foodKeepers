<?php
$this->load->view('templates/sidebar');
$cart = new Cart;
?>

<link rel="stylesheet" href="<?= base_url("assets/css/globalStyles.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/css/comprarStyles.css") ?>">

<!-- Page content -->
<!--skeletton of preview products -->
<div class="modal fade show" id="products-details" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-modal="true">
	<div class="modal-dialog modal- modal-dialog-centered modal- modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="modal-title-default">Detalle del producto</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- Pricing card -->
				<div class="card card-pricing border-0 text-center mb-4">
					<div class="card-header bg-transparent">
						<h4 class="text-uppercase ls-1 text-primary py-3 mb-0" id="name_product_details"></h4>
					</div>
					<div class="card-body px-lg-7">
						<div class="row row-example">
							<div class="col">
								<div class="display-2" id="precio_lista"></div>
								<span class=" text-muted">Precio lista</span>
							</div>
							<div class="col">
								<div class="display-2 text-green" id="precio_mayorista"></div>
								<span class=" text-muted text-green">Precio mayorista</span>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<ul class="list-unstyled my-4">
									<li>
										<div class="d-flex align-items-center">
											<div>
												<div
													class="icon icon-xs icon-shape bg-gradient-red text-white shadow rounded-circle">
													<i class="fas fa-spell-check"></i>
												</div>
											</div>
											<div>
												<span class="pl-2 text-sm" id="text-description"></span>
											</div>
										</div>
									</li>
									<li>
										<div class="d-flex align-items-center">
											<div>
												<div
													class="icon icon-xs icon-shape bg-gradient-red text-white shadow rounded-circle">
													<i class="fas fa-barcode"></i>
												</div>
											</div>
											<div>
												<span class="pl-2 text-sm" id="code_text"></span>
											</div>
										</div>
									</li>
									<li>
										<div class="d-flex align-items-center">
											<form class="form">
												<div class="pdt5">
													<div class="row">
														<div class="col-lg-12 col-md-12 col-sm-12">
															<div class="input-control">
																<input class="input-field" type="text" name="itemsToAdd" id="itemsToAdd" min="1" value="1" placeholder="Cantidad">
																<label class="input-label">Cantidad</label>
															</div>
														</div>
														<div class="col"><br>
															<div id="addToCartAction"></div>
															<div id="btnActionCart" class="hide"></div>
														</div>
													</div>
												</div>
											</form>
										</div>
									</li>
								</ul>
							</div>
							<div class="col" id="cnt-img-product">
							</div>
						</div>
					</div>
					<div class="card-footer">
						<!--<a href="#!" class=" text-muted">Request a demo</a>-->
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link text-red btn-close" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>


<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class="col">
			<div class="card">
				<div class="card-header bg-transparent">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Productos</h3>
						</div>
						<div class="col-4 text-right">
						</div>
					</div>
				</div>
				<div class="card-body">
					<form class="form">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="input-control">
									<select class="input-field" name="select_categories" id="select_categories" data-style="select-with-transition" title="Seleccione una opción" data-size="7"></select>
									<label class="input-label" for="select_categories">Categorías</label>
								</div>
							</div>
						</div>
						<div class="row" id="content_products">
						</div>
						<div class="row">
							<div class="text-right ml-auto">
								<a href="<?= base_url() ?>index.php/Comprar/shoppingCart" class="btn btn-success btn-icon-only rounded-circle"data-toggle="tooltip" title="Ver carrito">
									<span class="btn-inner--icon"><i class="fas fa-angle-right"></i></span>
								</a>
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
<script src="<?= base_url("assets/js/comprar.js") ?>"></script>
</body>

</html>
