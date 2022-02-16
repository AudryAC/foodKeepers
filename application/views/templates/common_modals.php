<div class="modal fade" id="modal-form-reset-pass" tabindex="-1" role="dialog" aria-labelledby="modal-form"
	 aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-body p-0">
				<div class="card bg-secondary border-0 mb-0">
					<div class="card-header bg-transparent pb-1">
						<div class="text-muted text-center mt-2 mb-3"><small>Restablece tu contraseña</small></div>
					</div>
					<div class="card-body px-lg-5 py-lg-5">
						<div class="text-center text-muted mb-4">
							<small>Elige una contraseña que no hayas usado hasta ahora. Para proteger tu cuenta, debes
								generar una contraseña nueva cada vez que la restablezcas.</small>
						</div>
						<form id="my-changepassword-form" name="my-changepassword-form">
							<div class="form-group mb-3">
								<div class="input-group input-group-merge input-group-alternative">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
									</div>
									<input class="form-control input-password" placeholder="Contraseña" type="password" id="input_passwordc" name="input_passwordc">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group input-group-merge input-group-alternative">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="ni ni-check-bold"></i></span>
									</div>
									<input class="form-control input_password_confirmation" placeholder="Confirmar contraseña" type="password" id="input_password_confirmation" name="input_password_confirmation">
								</div>
							</div>
							<div class="form-group">
								<div class="text-muted text-center mt-2 mb-1"><small id="message"></small></div>
							</div>
							<div class="text-center">
								<button type="submit" class="btn btn-primary my-4">Actualizar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-update-status" tabindex="-1" role="dialog" aria-labelledby="modal-default"
	 aria-hidden="true">
	<div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="modal-title-default">Actualizar estatus</h6>
			</div>
			<form id="my-changestatus-form" name="my-changestatus-form" class="form">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="input-control">
								<select class="input-field" name="select_status" id="select_status" data-style="select-with-transition" title="Selecciona una opción" data-size="7"></select>
								<label class="input-label" for="select_status">Estatus</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link text-red btn-close" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-danger">Guardar</button>
					<input type="hidden" id="input_id" name="input_id" class="form-control">
					<input type="hidden" id="input_type_c" name="input_type_c" class="form-control">
					<input type="hidden" id="input_type_upc" name="input_type_upc" class="form-control">
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-changelog" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	 aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-orders-tittle">Bitácora de cambios</h5>
			</div>
			<div class="modal-body">
				<div class="timeline timeline-one-side" data-timeline-content="axis" data-timeline-axis-style="dashed" id="changelog">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link text-red btn-close" data-dismiss="modal" onclick="cleanElement('changelog')">Cerrar
				</button>
			</div>
		</div>
	</div>
</div>
