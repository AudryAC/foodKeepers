$(document).ready(function () { // MJ: FILLS ORDERS DATA TABLE
	setFilters("#table-pedidos");
	orders_table = $('#table-pedidos').DataTable({
		dom: 'Bfrtip',
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fas fa-file-excel"></i>',
				titleAttr: 'Excel',
				className: 'btn btn-success',
				title: 'FK_LISTA_PEDIDOS',
				exportOptions: {
					columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
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
									return 'CLIENTE';
									break;
								case 4:
									return 'VENDEDOR';
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
								case 8:
									return 'PEDIDO';
									break;
								case 9:
									return 'PAGO';
									break;
								case 10:
									return 'ENVÍO';
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
					return d.id_pedido;
				}
			},
			{
				data: function (d) {
					var content = '';
					if (d.estatus == 1) { // ACTIVE ORDER
						content = '<span class="badge badge-dot w-100"><i class="bg-success"></i><span class="status text-white">1</span></span>';
					} else {
						content = '<span class="badge badge-dot w-100"><i class="bg-warning"></i><span class="status text-white">2</span></span>';
					}
					return content;
				}
			},
			{
				data: function (d) {
					return d.nombre_cliente;
				}
			},
			{
				data: function (d) {
					return d.nombre_vendedor;
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
					return d.fecha_pedido;
				}
			},
			{
				data: function (d) {
					var content = '';
					if (d.estatus_pedido == 1) // SOLICITADO
						content = '<span class="badge badge-pill badge-primary">solicitado</span>';
					else if (d.estatus_pedido == 2) // ACEPTADO
						content = '<span class="badge badge-pill badge-success">aceptado</span>';
					else if (d.estatus_pedido == 3) // CANCELADO
						content = '<span class="badge badge-pill badge-danger">cancelado</span>';
					else // AÚN NO ENTRA A PAGOS
						content = '<span class="badge badge-pill badge-secondary">sin especificar</span>';
					return content;
				}
			},
			{
				data: function (d) {
					var content = '';
					if (d.ticket == 1) // PAGADO
						content = '<span class="badge badge-pill badge-success">completo</span>';
					else // MJ: AÚN NO ENTRA A PAGOS
						content = '<span class="badge badge-pill badge-secondary">na</span>';
					return content;
				}
			},
			{
				data: function (d) {
					var content = '';
					if (d.envio == 1) // ACEPTADO
						content = '<span class="badge badge-pill badge-success">aceptado</span>';
					else if (d.envio == 2) // CONTRAPROPUESTA
						content = '<span class="badge badge-pill badge-warning">contrapropuesta</span>';
					else if (d.envio == 3) // EN CAMINO
						content = '<span class="badge badge-pill badge-dark">en camino</span>';
					else if (d.envio == 4) // FINALIZADO
						content = '<span class="badge badge-pill badge-primary">finalizado</span>';
					else
						content = '<span class="badge badge-pill badge-secondary">na</span>';
					return content;
				}
			},
			{
				data: function (d) {
					var buttons = '';
					if (d.estatus == 1) { // ACTIVE ORDER
						buttons = '<a class="dropdown-item change-status" data-id-pedido="' + d.id_pedido + '" data-status="2"><i class="fas fa-lock"></i>Desactivar</a>';
					} else {
						buttons = '<a class="dropdown-item change-status" data-id-pedido="' + d.id_pedido + '" data-status="1"><i class="fas fa-lock-open"></i>Activar</a>';
					}
					return '<div class="dropdown d-flex justify-content-center w-100"">\n' +
						'     	<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n' +
						'       	<i class="fas fa-ellipsis-v"></i>\n' +
						'        </a>\n' +
						'    	<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">\n' +
						'       	<a class="dropdown-item see-info" data-id-pedido="' + d.id_pedido + '" data-type="2"><i class="fas fa-info-circle"></i>Ver más</a>\n' +
						'       	<a class="dropdown-item update-status" data-id-row="' + d.id_pedido + '" data-from="3" data-type="1"><i class="fas fa-exchange-alt"></i>Cambiar estatus</a>\n' +
						'' + buttons + '' +
						'       	<a class="dropdown-item see-changelog" data-id-row="' + d.id_pedido + '" data-type="1"><i class="fas fa-clock"></i>Bitácora de cambios</a>\n' +
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
				if (full.estatus != 1) {
					return '';
				} else {
					return '<div class="custom-control custom-checkbox">' +
						'   	<input class="custom-control-input" id="table-check-all' + full.id_pedido + '" type="checkbox" name="idT[]" value="' + full.id_pedido + '">' +
						'        <label class="custom-control-label" for="table-check-all' + full.id_pedido + '"></label>' +
						'    </div>';
				}
			},
			select: {
				style: 'os',
				selector: 'td:first-child'
			},
		}],
		ajax: {
			url: "Pedidos/getOrdersList",
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

$(document).on("click", ".see-info", function () { // MJ: DESPLIEGA MODAL CON LA INFORMACIÓN DE UN PEDIDO
	cleanFields();
	var id_pedido = $(this).attr("data-id-pedido");
	$("#input_id_pedido").val(id_pedido);
	getOrderInformation(id_pedido);
	getOrderDetailsInformation(id_pedido);
	$("#modal-orders").modal();
});

function cleanFields() { // MJ: LIMPIA SPAN DE LA MODAL CON EL DETALLE DE LOS PEDIDOS
	document.getElementById("span-compra").innerHTML = "";
	document.getElementById("span-nombre").innerHTML = "";
	document.getElementById("span-correo").innerHTML = "";
	document.getElementById("span-telefono").innerHTML = "";
	document.getElementById("span-direccion").innerHTML = "";
	document.getElementById("span-total").innerHTML = "";
	document.getElementById("span-subtotal").innerHTML = "";
	document.getElementById("span-envio").innerHTML = "";
	$(".row-detail").remove();
}

function getOrderInformation(id_pedido) { // MJ: CONSULTA LA INFORMACIÓN DE UN PEDIDO
	$.getJSON("Pedidos/getOrderInformation/" + id_pedido).done(function (data) {
		$.each(data, function (i, v) {
			setInformation(v);
		});
	});
}

function getOrderDetailsInformation(id_pedido) { // MJ: OBTIENE DETALLE DE UN PEDIDO
	$.getJSON("Pedidos/getOrderDetailsInformation/" + id_pedido).done(function (data) {
		$.each(data, function (i, v) {
			setDetails(v);
		});
	});
}

function setInformation(v) { // MJ: SETEA LA INFORMACIÓN PARA UN PEDIDO
	var total = parseFloat(v.total) + parseFloat(v.total) * 0.16;
	document.getElementById("span-compra").innerHTML = v.fecha_pedido;
	document.getElementById("span-nombre").innerHTML = v.nombre_cliente;
	document.getElementById("span-correo").innerHTML = v.correo;
	document.getElementById("span-telefono").innerHTML = formatPhoneNumber(v.telefono);
	document.getElementById("span-direccion").innerHTML = v.direccion;
	document.getElementById("span-total").innerHTML = formatMoney(total);
	document.getElementById("span-subtotal").innerHTML = formatMoney(v.total);;
	document.getElementById("span-envio").innerHTML = "missing";
}

function setDetails(v) { // MJ: SETEA LOS DETALLES DE UN PEDIDO
	$("#tbody-details").append('<tr class="row-detail">' +
		'<td class="table-user">' +
		'<span class="text-muted">' + v.producto + '</span>' +
		'</td>' +
		'<td>' +
		'<span class="text-muted">' + v.codigo + '</span>' +
		'</td>' +
		'<td>' +
		'<span class="text-muted">' + v.cantidad + '</span>' +
		'</td>' +
		'<td>' +
		'<span class="text-muted">' + formatMoney(v.precio_lista) + '</span>' +
		'</td>' +
		'<td>' +
		'<span class="text-muted">' + formatMoney(v.total) + '</span>' +
		'</td>' +
		'<td>' +
		'<span class="text-muted">' + formatMoney(v.total_descuento) + '</span>' +
		'</td>' +
		'</tr>');
}

$(document).on('click', '.change-status', function () { // MJ: MODIFICA EL ESTATUS DE UN PEDIDO
	estatus = $(this).attr("data-status");
	$.ajax({
		type: 'POST',
		url: 'Pedidos/addEditOrder',
		data: {
			'input_id_pedido': $(this).attr("data-id-pedido"),
			'input_status': $(this).attr("data-status"),
			'input_type_up': 2
		},
		dataType: 'json',
		success: function (data) {
			if (data == 1) {
				alerts.showNotification("top", "right", estatus == 1 ? "Pedido activado con éxito." : "Pedido desactivado con éxito.", "success");
				orders_table.ajax.reload();
			} else {
				alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
			}
		}, error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});

function selectAll(e) { // MJ: COLOCA CHECKED TODOS LAS OPCIONES
	const cb = document.getElementById('all');
	if (cb.checked) {
		$('input[type="checkbox"]').prop('checked', true);
	} else {
		$('input[type="checkbox"]').prop('checked', false);
	}
}

function getOrderStatus() { // MJ: OBTIENE LAS OPCIONES DEL CATÁLOGO ESTATUS PEDIDO
	$("#select-os option[value]").remove();
	$.getJSON("General/getOptions/" + "3").done(function (data) {
		$("#select-os").append($('<option disabled selected>').val("").text("Seleccione una opción"));
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_opcion'];
			var name = data[i]['nombre'];
			$("#select-os").append($('<option>').val(id).text(name));
		}
	});
}

function printOrder(type) { // MJ: GENERA PDF CON LA INFORMACIÓN DEL PEDIDO Y MUESTRA PREVIEW
	var id_pedido = $("#input_id_pedido").val();
	window.open("Pedidos/printOrder/" + id_pedido + "/" + type, "_blank")
}

function sendEmail() { // MJ: GENERA PDF CON LA INFORMACIÓN DEL PEDIDO Y MUESTRA PREVIEW
	var id_pedido = $("#input_id_pedido").val();
	window.open("Pedidos/resendEmailValidation", "_blank")
}



