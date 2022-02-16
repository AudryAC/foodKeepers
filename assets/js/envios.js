$(document).ready(function () {
	setFilters("#table-envios");
	shipping_table = $('#table-envios').DataTable({
		dom: 'Bfrtip',
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fas fa-file-excel"></i>',
				titleAttr: 'Excel',
				className: 'btn btn-success',
				title: 'FK_LISTA_ENVIOS',
				exportOptions: {
					columns: [1, 2, 3, 4, 5, 6, 7],
					format: {
						header: function (d, columnIdx) {
							switch (columnIdx) {
								case 1:
									return 'ID';
									break;
								case 2:
									return 'ESTATUS';
									break;
								case 3:
									return 'PEDIDO';
									break;
								case 4:
									return 'CLIENTE';
									break;
								case 5:
									return 'NO. ARTÍCULOS';
									break;
								case 6:
									return 'TOTAL';
									break;
								case 7:
									return 'FECHA';
									break;
							}
						}
					}
				},
			}
		],
		ordering: false,
		paging: true,
		pagingType: "full_numbers",
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 25, 50, "Todos"]
		],
		destroy: true,
		language: {
			url: "../assets/vendor/datatables.net/Spanish.json",
			paginate: {
				previous: "<i class='fas fa-angle-left'>",
				next: "<i class='fas fa-angle-right'>"
			}
		},
		columns: [
			{},
			{
				data: function (d) {
					return d.id_envio;
				}
			},
			{
				data: function (d) {
					var content = '';
					if (d.estatus == 1) { // ACTIVE SHIPPING
						content = '<span class="badge badge-dot w-100"><i class="bg-success"></i><span class="status text-white">1</span></span>';
					} else {
						content = '<span class="badge badge-dot w-100"><i class="bg-warning"></i><span class="status text-white">2</span></span>';
					}
					return content;
				}
			},
			{
				data: function (d) {
					return d.id_pedido;
				}
			},
			{
				data: function (d) {
					return d.nombre_cliente;
				}
			},
			{
				data: function (d) {
					return d.num_articulos;
				}
			},
			{
				data: function (d) {
					return formatMoney(d.total);
				}
			},
			{
				data: function (d) {
					return d.fecha_envio;
				}
			},
			{
				data: function (d) {
					var content = '';
					if (d.estatus_envio == 1) // ACEPTADO
						content = '<span class="badge badge-pill badge-success">aceptado</span>';
					else if (d.estatus_envio == 2) // CONTRAPROPUESTA
						content = '<span class="badge badge-pill badge-warning">contrapropuesta</span>';
					else if (d.estatus_envio == 3) // EN CAMINO
						content = '<span class="badge badge-pill badge-primary">en camino</span>';
					else if (d.estatus_envio == 4) // FNALIZADO
						content = '<span class="badge badge-pill badge-secondary">finalizado</span>';
					else
						content = '';
					return content;
				}
			},
			{
				data: function (d) {
					var buttons = '';
					if (d.estatus == 1) { // ACTIVE SHIPPING
						buttons = '<a class="dropdown-item change-status" data-id-envio="' + d.id_envio + '" data-status="2"><i class="fas fa-lock"></i>Desactivar</a>';
					} else {
						buttons = '<a class="dropdown-item change-status" data-id-envio="' + d.id_envio + '" data-status="1"><i class="fas fa-lock-open"></i>Activar</a>';
					}
					return '<div class="dropdown d-flex justify-content-center w-100"">\n' +
						'     	<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n' +
						'       	<i class="fas fa-ellipsis-v"></i>\n' +
						'        </a>\n' +
						'    	<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">\n' +
						'       	<a class="dropdown-item see-info" data-id-envio="' + d.id_envio + '" data-type="2"><i class="fas fa-info-circle"></i>Ver más</a>\n' +
						'       	<a class="dropdown-item update-status" data-id-row="' + d.id_envio + '" data-from="3" data-type="2"><i class="fas fa-exchange-alt"></i>Cambiar estatus</a>\n' +
						'' + buttons + '' +
						'       	<a class="dropdown-item see-changelog" data-id-row="' + d.id_envio + '" data-type="2"><i class="fas fa-clock"></i>Bitácora de cambios</a>\n' +
						'       </div>\n' +
						'    </div>';
				}
			}
		],
		columnDefs: [{
			ordering: false,
			className: '',
			targets: 0,
			searchable: false,
			render: function (d, type, full, meta) {
				/*if (full.estatus_envio != 1) {
					return '';
				} else {*/
				return '<div class="custom-control custom-checkbox mb-3">' +
					'   	<input class="custom-control-input" id="table-check-all' + full.id_envio + '" type="checkbox" name="idT[]" value="' + full.id_envio + '">' +
					'        <label class="custom-control-label" for="table-check-all' + full.id_envio + '"></label>' +
					'    </div>';
				/*}*/
			},
			select: {
				style: 'os',
				selector: 'td:first-child'
			},
		}],
		ajax: {
			url: "Envios/getShippingList",
			type: "POST",
			cache: false,
			data: function (d) {
			}
		},
		order: [
			[1, 'asc']
		]
	});
});

$(document).on('click', '.change-status', function () { // MJ: MODIFICA EL ESTATUS DE UN PEDIDO
	estatus = $(this).attr("data-status");
	$.ajax({
		type: 'POST',
		url: 'Envios/addEditShipping',
		data: {
			'input_id-envio': $(this).attr("data-id-envio"),
			'input_status': $(this).attr("data-status"),
			'input_type_up': 2
		},
		dataType: 'json',
		success: function (data) {
			if (data == 1) {
				alerts.showNotification("top", "right", estatus == 1 ? "Envío activado con éxito." : "Envío desactivado con éxito.", "success");
				shipping_table.ajax.reload();
			} else {
				alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
			}
		}, error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});
