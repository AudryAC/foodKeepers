$(document).ready(function () { // MJ: FILLS ORDERS DATA TABLE
	setFilters("#table-stocks");
	$stocks_table = $('#table-stocks').DataTable({
		dom: 'Bfrtip',
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fas fa-file-excel"></i>',
				titleAttr: 'Excel',
				className: 'btn btn-success',
				title: 'FK_LISTA_INVENTARIO',
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6],
					format: {
						header: function (d, columnIdx) {
							switch (columnIdx) {
								case 0:
									return 'ID';
									break;
								case 1:
									return 'NOMBRE';
									break;
								case 2:
									return 'CATEGORÍA';
									break;
								case 3:
									return 'CANTIDAD';
									break;
								case 4:
									return 'APARTADO';
									break;
								case 5:
									return 'MÁXIMO';
									break;
								case 6:
									return 'MÍNIMO';
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
			{
				data: function (d) {
					return d.id_stock;
				}
			},
			{
				data: function (d) {
					return d.producto;
				}
			},
			{
				data: function (d) {
					return d.categoria;
				}
			},
			{
				data: function (d) {
					var traffic_lights = '';
					if (d.cantidad_total > d.max_items) // LA CANTIDAD ACTUAL ES MAYOR QUE EL MÁXIMO
						traffic_lights = '<label class="btn btn-sm btn-danger mr-4">' + d.cantidad_total + '</label>';
					else if (d.cantidad_total < d.min_items)
						traffic_lights = '<label class="btn btn-sm btn-warning mr-4">' + d.cantidad_total + '</label>';
					else
						traffic_lights = '<label class="btn btn-sm btn-success mr-4">' + d.cantidad_total + '</label>';

					return traffic_lights;
				}
			},
			{
				data: function (d) {
					return d.cantidad_actual;
				}
			},
			/*{
				data: function (d) {
					return d.tasa_compra;
				}
			},
			{
				data: function (d) {
					return d.tasa_stock;
				}
			},*/
			{
				data: function (d) {
					return d.max_items;
				}
			},
			{
				data: function (d) {
					return d.min_items;
				}
			},
			{
				data: function (d) {
					return '<div class="dropdown d-flex justify-content-center w-100"">\n' +
						'     	<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n' +
						'       	<i class="fas fa-ellipsis-v"></i>\n' +
						'        </a>\n' +
						'    	<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">\n' +
						'       	<a class="dropdown-item edit-stock" data-id-stock="' + d.id_stock + '" ><i class="fas fa-edit"></i>Editar</a>\n' +
						/*'       	<a class="dropdown-item see-changelog" data-id-stock="' + d.id_stock + '"><i class="fas fa-clock"></i>Bitácora de cambios</a>\n' +*/
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
		}],
		ajax: {
			url: "Inventario/getStockList",
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

$(document).on("click", ".edit-stock", function () { // MJ: DESPLIEGA MODAL CON LA INFORMACIÓN DEL REGISTRO DE STOCK SELECCIONADO
	cleanFields();
	var id_stock = $(this).attr("data-id-stock");
	$("#input_id_stock").val(id_stock);
	getStockInformation(id_stock);
	$("#modal-stock").modal();
});

function cleanFields() { // MJ: LIMPIA SPAN DE LA MODAL CON EL DETALLE DE LOS PEDIDOS
	$("#input-product").val('');
	$("#input_quantity").val('');
	$("#input_maximum").val('');
	$("#input_minimum").val('');
	$("#input-purchase-rate").val('');
	$("#input-stock-rate").val('');
	$("#input_id_stock").val('');
}

function getStockInformation(id_stock) { // MJ: CONSULTA LA INFORMACIÓN DE UN PEDIDO
	$.getJSON("Inventario/getStockInformation/" + id_stock).done(function (data) {
		$.each(data, function (i, v) {
			fillFields(v);
		});
	});
}

function fillFields(v) {
	$("#input-product").val(v.producto);
	$("#input_quantity").val(v.cantidad_total);
	$("#input_maximum").val(v.max_items);
	$("#input_minimum").val(v.min_items);
	$("#input-purchase-rate").val(v.tasa_compra);
	$("#input-stock-rate").val(v.tasa_stock);
}

$("#my-stock-form").on('submit', function (e) { // MJ: MANDA UN UPDATE O INSERT DEPENDIENDO EL TIPO DE LA TRANSACCIÓN
	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: 'Inventario/addEditStock',
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		beforeSend: function () {
			// Actions before send post
		},
		success: function (data) {
			if (data == 1) {
				$('#modal-stock').modal("hide");
				cleanFields();
				$stocks_table.ajax.reload();
				alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
			} else {
				alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
			}
		},
		error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});




