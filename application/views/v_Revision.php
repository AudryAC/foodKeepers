<?php
$this->load->view('templates/sidebar');
$cart = new Cart;
?>

<link rel="stylesheet" href="<?= base_url("assets/css/globalStyles.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/css/revisionStyles.css") ?>">

<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row justify-content-center">
		<div class=" col ">
			<div class="card">
				<!--<div class="card-header bg-transparent">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Vista previa del pedido</h3>
						</div>
						<div class="col-4 text-right">
						</div>
					</div>
				</div>-->
				<div class="card-body">
					<form id="my-customer-form" name="my-customer-form" class="form">
						<div class="row">
							<section class="mb-4">
								<!--Grid row-->
								<div class="row">
									<!--Grid column-->
									<div class="col-lg-8">
										<ul class="nav nav-tabs">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#home">Información del cliente</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#menu1">Forma de pago</a>
											</li>
										</ul>

										<!-- Tab panes -->
										<div class="tab-content">
											<div class="tab-pane container active" id="home">
												<div class="row">
													<div class="col-lg-8 col-md-8 col-sm-12">
														<div class="form-group mt-3">
															<label class="form-control-label" for="select-clients">Clientes</label>
															<select class="form-control" name="select-clients[]"
																	id="select-clients"
																	data-style="select-with-transition"
																	title="Seleccione una opción"
																	data-size="7"
																	data-toggle="select"
																	data-placeholder="Seleccione una opción"></select>
														</div>
													</div>

													<div class="col-lg-12 col-md-12 col-sm-12" id="div-client-content">
														<div class="row">
															<div class="col-lg-4 col-md-4 col-sm-12">
																<div class="form-group">
																	<label class="form-control-label" for="input_first_name">Nombre</label>
																	<input type="text" id="input_first_name"
																		   name="input_first_name"
																		   class="form-control text-uppercase input-only-letters" required
																		   maxlength="75"
																		   oninput="validateMaxLength(this)"
																		   placeholder="Nombre">
																</div>
															</div>
															<div class="col-lg-4 col-md-4 col-sm-12">
																<div class="form-group">
																	<label class="form-control-label" for="input_last_name">Apellido paterno</label>
																	<input type="text" id="input_last_name"
																		   name="input_last_name"
																		   class="form-control text-uppercase input-only-letters" required
																		   maxlength="75"
																		   oninput="validateMaxLength(this)"
																		   placeholder="Apellido paterno">
																</div>
															</div>
															<div class="col-lg-4 col-md-4 col-sm-12">
																<div class="form-group">
																	<label class="form-control-label" for="input_mothers_last_name">Apellido materno</label>
																	<input type="text"
																		   id="input_mothers_last_name"
																		   name="input_mothers_last_name"
																		   class="form-control text-uppercase input-only-letters" required
																		   maxlength="75"
																		   oninput="validateMaxLength(this)"
																		   placeholder="Apellido materno">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-8 col-md-8 col-sm-12">
																<div class="form-group">
																	<label class="form-control-label" for="input_email_address">Correo</label>
																	<input type="text" id="input_email_address"
																		   name="input_email_address"
																		   class="form-control text-uppercase" required
																		   maxlength="150"
																		   oninput="validateMaxLength(this)"
																		   placeholder="Correo">
																</div>
															</div>
															<div class="col-lg-4 col-md-4 col-sm-12">
																<div class="form-group">
																	<label class="form-control-label" for="input_phone">Teléfono</label>
																	<input type="text" id="input_phone"
																		   name="input_phone"
																		   class="form-control"
																		   onkeyup="formatPhoneNumber(this)"
																		   required
																		   maxlength="15"
																		   oninput="validateMaxLength(this)">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-8 col-md-8 col-sm-12">
																<div class="form-group">
																	<label class="form-control-label" for="input_contact">Contacto</label>
																	<input type="text" id="input_contact"
																		   name="input_contact"
																		   class="form-control text-uppercase" required
																		   maxlength="250"
																		   oninput="validateMaxLength(this)"
																		   placeholder="Contacto">
																</div>
															</div>
															<div class="col-lg-4 col-md-4 col-sm-12">
																<div class="form-group">
																	<label class="form-control-label" for="select_country">País</label>
																	<select class="form-control"
																			name="select_country"
																			id="select_country"
																			data-style="select-with-transition"
																			title="Seleccione una opción"
																			data-size="7" required
																			onchange="validateNationality(this.options[this.selectedIndex].value)"></select>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-8 col-md-8 col-sm-12">
																<div class="form-group">
																	<label class="form-control-label" for="input_street">Calle</label>
																	<input type="text" id="input_street"
																		   name="input_street"
																		   class="form-control text-uppercase" required
																		   maxlength="250"
																		   oninput="validateMaxLength(this)"
																		   placeholder="Calle">
																</div>
															</div>
															<div class="col-lg-2 col-md-2 col-sm-12">
																<div class="form-group">
																	<label class="form-control-label" for="input_number">Número</label>
																	<input type="text" id="input_number"
																		   name="input_number"
																		   class="form-control text-uppercase" required
																		   maxlength="35"
																		   oninput="validateMaxLength(this)"
																		   placeholder="Número">
																</div>
															</div>
															<div class="col-lg-2 col-md-2 col-sm-12">
																<div class="form-group">
																	<label class="form-control-label" for="input_postal_code">CP</label>
																	<input type="text" id="input_postal_code"
																		   name="input_postal_code"
																		   class="form-control input-only-numbers" required
																		   maxlength="5"
																		   oninput="validateMaxLength(this)" placeholder="CP">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-4 col-md-4 col-sm-12">
																<div class="form-group">
																	<label class="form-control-label" for="input_suburb">Colonia</label>
																	<input type="text" id="input_suburb"
																		   name="input_suburb"
																		   class="form-control text-uppercase" required
																		   maxlength="250"
																		   oninput="validateMaxLength(this)"
																		   placeholder="Colonia">
																</div>
															</div>
															<div class="col-lg-4 col-md-4 col-sm-12">
																<div class="form-group">
																	<label class="form-control-label" for="input_municipality">Municipio</label>
																	<input type="text" id="input_municipality"
																		   name="input_municipality"
																		   class="form-control text-uppercase" required
																		   maxlength="250"
																		   oninput="validateMaxLength(this)"
																		   placeholder="Municipio">
																</div>
															</div>
															<div class="col-lg-4 col-md-4 col-sm-12">
																<div class="form-group">
																	<label class="form-control-label" for="select_state">Estado</label>
																	<select class="form-control hide"
																			name="select_state"
																			id="select_state"
																			data-style="select-with-transition"
																			title="Seleccione una opción"
																			data-size="7"></select>
																	<input type="text" id="input_state"
																		   name="input_state"
																		   class="form-control text-uppercase" maxlength="250"
																		   oninput="validateMaxLength(this)"
																		   placeholder="Estado">
																	<input type="hidden" id="input_type"
																		   name="input_type"
																		   class="form-control">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="tab-pane container" id="menu1">
												<div class="row ul-list">

													<div class="col-lg-4 col-md-4 col-sm-12">
														<div class="card">
															<!-- Card body -->
															<div class="card-body">
																<div class="align-items-center">
																	<h3>Tarjeta</h3>
																</div>
																<li class="li-lis tablinkst">
																	<input type="checkbox" id="myCheckbox1" name="paymentMethod[]" value="1" onchange="validateCardPayment();"/>
																	<label class="label-image" for="myCheckbox1">
																		<!-- <div class="box-img image-bk-1">
																		</div> -->
																		<img src="<?= base_url("assets/img/payment/card.png") ?>"/>
																	</label>
																</li>
															</div>
														</div>
													</div>

													<div class="col-lg-4 col-md-4 col-sm-12">
														<div class="card">
															<!-- Card body -->
															<div class="card-body">
																<div class="align-items-center">
																	<h3>Transferencia</h3>
																</div>
																<li class="li-lis tablinkst">
																	<input type="checkbox" id="myCheckbox2" name="paymentMethod[]" value="2" onchange="validateTransferPayment();"/>
																	<label class="label-image" for="myCheckbox2">
																		<!-- <div class="box-img image-bk-2"></div> -->
																		<img src="<?= base_url("assets/img/payment/bank-transfer.png") ?>"/>
																	</label>
																</li>
															</div>
														</div>
													</div>

													<div class="col-lg-4 col-md-4 col-sm-12">
														<div class="card">
															<!-- Card body -->
															<div class="card-body">
																<div class="align-items-center">
																	<h3>Efectivo</h3>
																</div>
																<li class="li-lis tablinkst">
																	<input type="checkbox" id="myCheckbox3" name="paymentMethod[]" value="3" onchange="validateCashPayment();"/>
																	<label class="label-image" for="myCheckbox3">
																		<!-- <div class="box-img">
																		</div> -->
																		<img src="<?= base_url("assets/img/payment/cash.jpg") ?>"/>
																	</label>
																</li>
															</div>
														</div>
													</div>
												</div>
												<h4 class="hide" id="title-card">Pago con tarjeta</h4>
												<div class="row hide" id="row-card">
													<div class="col-lg-6 col-md-6 col-sm-12">
														<div class="form-group">
															<label class="form-control-label"
																   for="select_type">Tipo</label>
															<select class="form-control"
																	name="select_type"
																	id="select_type"
																	data-style="select-with-transition"
																	title="Seleccione una opción"
																	data-size="7"></select>
														</div>
													</div>
													<div class="col-lg-3 col-md-3 col-sm-12">
														<div class="form-group">
															<label class="form-control-label"
																   for="input_msi">MSI</label>
															<input type="text" id="input_msi"
																   name="input_msi"
																   class="form-control input-only-numbers">
														</div>
													</div>
													<div class="col-lg-3 col-md-3 col-sm-12">
														<div class="form-group">
															<label class="form-control-label"
																   for="input_card_amount">Monto</label>
															<input type="text" id="input_card_amount"
																   name="input_card_amount"
																   class="form-control" onkeypress="return filterFloat(event,this);" onchange="sumEnteredAmount()" value="0"> <!--pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" value="" data-type="currency"-->
														</div>
													</div>

												</div>

												<h4 class="hide" id="title-transfer">Pago con transferencia</h4>
												<div class="row hide" id="row-transfer">
													<div class="col-lg-8 col-md-8 col-sm-12">
														<div class="form-group">
															<label class="form-control-label"
																   for="input_code">Clabe</label>
															<input type="text" id="input_code"
																   name="input_code"
																   class="form-control input-only-numbers"
																   maxlength="16"
																   oninput="validateMaxLength(this)">
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-12">
														<div class="form-group">
															<label class="form-control-label"
																   for="input_transfer_amount">Monto</label>
															<input type="text" id="input_transfer_amount"
																   name="input_transfer_amount"
																   class="form-control" onkeypress="return filterFloat(event,this);" onchange="sumEnteredAmount()" value="0">
														</div>
													</div>
												</div>

												<h4 class="hide" id="title-cash">Pago con efectivo</h4>
												<div class="row hide" id="row-cash">
													<div class="col-lg-4 col-md-4 col-sm-12">
														<div class="form-group">
															<label class="form-control-label"
																   for="input_cash_amount">Monto</label>
															<input type="text" id="input_cash_amount"
																   name="input_cash_amount"
																   class="form-control" onkeypress="return filterFloat(event,this);" onchange="sumEnteredAmount()" value="0">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12">
														<div class="col-lg-4 col-md-4 text-right ml-auto p-1">
															<label class="form-control-label text-left"
																   for="input_total_amount">Grand total</label>
															<input type="text" id="input_total_amount"
																   name="input_total_amount"
																   class="form-control" disabled>
														</div>

														<div class="col-lg-4 col-md-4 text-right ml-auto p-1">
															<label class="form-control-label"
																   for="input_entered_amount-amount">Monto ingresado</label>
															<input type="text" id="input_entered_amount"
																   name="input_entered_amount"
																   class="form-control" disabled>
														</div>
													</div>
												</div>


											</div>
										</div>
									</div>

									<!--Grid column-->
									<div class="col-lg-4">
										<!-- Card -->
										<div class="card mb-4">
											<div class="card-body">
												<div class="list-group list-group-flush">
													<?php
													if ($cart->total_items() > 0) {
														//get cart items from session
														$cartItems = $cart->contents();
														foreach ($cartItems as $item) {
															?>
															<a href="#"
															   class="list-group-item list-group-item-action flex-column align-items-start py-4 px-4">
																<div class="d-flex w-100 justify-content-between">
																	<div>
																		<div class="d-flex w-100 align-items-center item">
																			<span class="notify-badge"><?php echo $item["qty"]; ?></span>
																			<img src="<?= base_url() ?>assets/img/products/<?php echo $item["image"]; ?>" class="avatar avatar-xs mr-2"/>
																		</div>
																	</div>
																	<h5 class="mb-1"><?php echo $item["name"]; ?></h5>
																	<small><?php echo "$" . number_format($item["subtotal"], 2) ?></small>
																</div>
															</a>
														<?php }
													} else { ?>
														<p>Tu carrito está vacío...</p>
													<?php } ?>
												</div>
												<br>
												<h5 class="mb-3">Detalle de pago</h5>
												<ul class="list-group list-group-flush">
													<li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
														Subtotal
														<span><?php echo '$' . number_format($cart->total(), 2); ?></span>
													</li>
													<li class="list-group-item d-flex justify-content-between align-items-center px-0">
														Envío
														<span>Gratis</span>
													</li>
													<li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
														<div>
															<strong>IVA</strong>
														</div>
														<span><strong><?php $iva = $cart->total() * .16; echo '$'. number_format($iva, 2); ?></strong></span>
													</li>
													<li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
														<div>
															<strong>Total</strong>
														</div>
														<span><strong><?php $total = $cart->total() + $cart->total() * .16; echo '$'.number_format($total, 2); ?></strong></span>
													</li>
												</ul>
												<div class="text-center">
													<a href="<?= base_url() ?>index.php/Comprar" type="button"
													   class="btn btn-success btn-block text-uppercase">Continuar comprando</a>
													<button type="submit" class="btn btn-dark btn-block text-uppercase" disabled id="btn_sumbit">Finalizar</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
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
<script src="<?= base_url("assets/js/revision.js") ?>"></script>
<script src="<?= base_url("assets/js/clientes.js") ?>"></script>
<script>
	var totalAmount = <?php echo $total ?>;
	$("#input_total_amount").val(formatMoney(totalAmount));
</script>
</body>
</html>
