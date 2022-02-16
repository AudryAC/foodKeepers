<?php
$this->load->view('templates/sidebar');
$this->load->library(array('cart'));
$cart = new Cart;

?>

<link rel="stylesheet" href="<?= base_url("assets/css/globalStyles.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/css/carritoStyles.css") ?>">

<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class=" col ">
			<div class="card">
				<!--<div class="card-header bg-transparent">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Carrito</h3>
						</div>
						<div class="col-4 text-right">
						</div>
					</div>
				</div>-->
				<div class="card-body">
					<div class="row">
						<section class="mb-4">
							<!--Grid row-->
							<div class="row">
								<!--Grid column-->
								<div class="col-lg-8">
									<!-- Card -->
									<div class="card mb-4">
										<div class="card-body">
											<h5 class="mb-4">Carrito (<span><?php echo $cart->total_items(); ?></span> artículos)</h5>
											<?php
											if ($cart->total_items() > 0) {
											//get cart items from session
											$cartItems = $cart->contents();
											foreach ($cartItems as $item) {
											?>
											<div class="row mb-4">
												<div class="col-md-5 col-lg-3 col-xl-3">
													<div class="view zoom overlay z-depth-1 rounded mb-3 mb-md-0">
														<img class="img-fluid w-100" src="<?= base_url() ?>assets/img/products/<?php echo $item["image"]; ?>">
														<a href="#!">
															<div class="mask waves-effect waves-light">
																<img class="img-fluid w-100" src="<?= base_url() ?>assets/img/products/<?php echo $item["image"]; ?>">
																<div class="mask rgba-black-slight waves-effect waves-light"></div>
															</div>
														</a>
													</div>
												</div>
												<div class="col-md-7 col-lg-9 col-xl-9">
													<div>
														<div class="d-flex justify-content-between">
															<div>
																<h5><?php echo $item["name"]; ?></h5>
																<p class="mb-3 text-muted text-uppercase small"><strong>Descripción:</strong> <?php echo $item["description"]; ?></p>
																<p class="mb-2 text-muted text-uppercase small"><strong>Código:</strong> <?php echo $item["code"]; ?></p>
															</div>
															<div class="align-items-center">
																<div class="quantity mb-0 w-100 text-right">
																	<input type="button" value="-" class="minus-btn btn-quantity" data-field="quantity">
																	<input type="text" step="1" max="" name="quantity" class="quantity-field" value="<?php echo $item["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $item["rowid"]; ?>')">
																	<input type="hidden" name="old_quantity" id="old_quantity" value="<?php echo $item["qty"]; ?>">
																	<input type="hidden" name="id" id="id" value="<?php echo $item["id"]; ?>">
																	<input type="button" value="+" class="plus-btn btn-quantity" data-field="quantity">
																</div>
															</div>
														</div>
														<div class="d-flex justify-content-between align-items-center">
															<div>
																<a type="button" class="card-link-secondary small text-uppercase mr-3 remove-cart-item" data-id="<?php echo $item["rowid"]; ?>" data-qty="<?php echo $item["qty"]; ?>" data-id-producto="<?php echo $item["id"]; ?>"><i class="fas fa-trash-alt mr-1"></i> Remover artículo </a>
															</div>
															<p class="mb-0"><span><strong><?php echo '$' . number_format($item["price"], 2) ?></strong></span></p>
															<p class="mb-0"><span><strong><?php echo '$' . number_format($item["subtotal"], 2) ?></strong></span></p>
														</div>
													</div>
												</div>
											</div>
											<hr class="mb-4">
											<?php }
											} else { ?>
												<p>Tu carrito está vacío...</p>
											<?php } ?>
										</div>
									</div>
									<!-- Card -->
								</div>
								<!--Grid column-->
								<!--Grid column-->
								<div class="col-lg-4">
									<!-- Card -->
									<div class="card mb-4">
										<div class="card-body">
											<h5 class="mb-3">Detalle de pago</h5>
											<ul class="list-group list-group-flush">
												<li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
													Subtotal
													<span><?php echo '$'. number_format($cart->total(), 2) ?></span>
												</li>
												<li class="list-group-item d-flex justify-content-between align-items-center px-0">
													Envío
													<span>Gratis</span>
												</li>
												<li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
													<div>
														<strong>IVA</strong>
													</div>
													<span><strong><?php $iva = $cart->total() * .16; echo '$'. number_format($iva, 2) ?></strong></span>
												</li>
												<li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
													<div>
														<strong>Total</strong>
													</div>
													<span><strong><?php $total = $cart->total() + $cart->total() * .16; echo '$'.number_format($total, 2); ?></strong></span>
												</li>
											</ul>
											<div class="text-center">
												<a href="<?= base_url() ?>index.php/Comprar/checkout" type="button" class="btn btn-dark btn-block text-uppercase">pagar order</a>
												<a href="<?= base_url() ?>index.php/Comprar" type="button" class="btn btn-success btn-block text-uppercase">continuar comprado</a>
											</div>
										</div>
									</div>
									<!-- Card -->
								</div>
								<!--Grid column-->
							</div>
							<!--Grid row-->
						</section>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<?php $this->load->view('templates/footer_legend'); ?>
</div>
</div>

<div class="modal fade" id="modal-remove-item" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
		<div class="modal-content text-center">
			<form id="my-removeCartItem-form" name="my-removeCartItem-form" class="form">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<h2 class="swal2-title">Advertencia</h2>
							<div id="swal2-content" style="display: block;">¿Estás seguro de eliminar este artículo de tu carrito?</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link text-red btn-close" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-danger" onclick="removeCartItem()">Sí</button>
					<input type="hidden" id="input_rowid" name="input_rowid" class="form-control">
					<input type="hidden" id="input_qty" name="input_qty" class="form-control">
					<input type="hidden" id="input_id_producto" name="input_id_producto" class="form-control">
				</div>
			</form>
		</div>
	</div>
</div>

<?php $this->load->view('templates/footer'); ?>
<script src="<?= base_url("assets/js/carrito.js") ?>"></script>
</body>

</html>
