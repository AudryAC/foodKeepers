$(document).ready(function () {
	getCountries();
	getStates();
	setFilters("#table-clients");
	$clients_table = $('#table-clients').DataTable({ // MJ: FILL CLIENTS DATA TABLE
		dom: 'Bfrtip',
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fas fa-file-excel"></i>',
				titleAttr: 'Excel',
				className: 'btn btn-success',
				title: 'FK_LISTA_CLIENTES',
				exportOptions: {
					columns: [0, 1, 2, 3, 4],
					format: {
						header: function (d, columnIdx) {
							switch (columnIdx) {
								case 0:
									return 'ID';
									break;
								case 1:
									return 'ESTATUS';
									break;
								case 2:
									return 'NOMBRE';
									break;
								case 3:
									return 'CORREO';
									break;
								case 4:
									return 'TELÉFONO';
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
					return d.id_cliente;
				}
			},
			{
				data: function (d) {
					var content = '';
					if (d.estatus == 1) { // ACTIVE USER
						content = '<span class="badge badge-dot w-100"><i class="bg-success"></i><span class="status text-white">1</span></span>';
					} else {
						content = '<span class="badge badge-dot w-100"><i class="bg-warning"></i><span class="status text-white">2</span></span>';
					}
					return content;
				}
			},
			{
				data: function (d) {
					return d.nombre_completo;
				}
			},
			{
				data: function (d) {
					return d.correo;
				}
			},
			{
				data: function (d) {
					return formatPhoneNumber(d.telefono);
				}
			},
			{
				data: function (d) {
					var buttons = '';
					if (d.estatus == 1) { // ACTIVE USER
						buttons = '<a class="dropdown-item change-status" data-id-cliente="' + d.id_cliente + '" data-status="2"><i class="fas fa-lock"></i>Desactivar</a>';
					} else {
						buttons = '<a class="dropdown-item change-status" data-id-cliente="' + d.id_cliente + '" data-status="1"><i class="fas fa-lock-open"></i>Activar</a>';
					}
					return '<div class="dropdown d-flex justify-content-center w-100">\n' +
						'     	<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n' +
						'       	<i class="fas fa-ellipsis-v"></i>\n' +
						'        </a>\n' +
						'    	<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">\n' +
						'       	<a class="dropdown-item add-edit" data-id-cliente="' + d.id_cliente + '" data-type="2"><i class="fas fa-edit"></i>Editar</a>\n' +
						'       	<a class="dropdown-item add-edit" data-id-cliente="' + d.id_cliente + '" data-type="3"><i class="fas fa-info-circle"></i>Ver más</a>\n' +
						'' + buttons + '' +
						'       </div>\n' +
						'    </div>';
				}
			}
		],
		ajax: {
			url: "Clientes/getClientsList",
			type: "POST",
			cache: false,
			data: function (d) {
			}
		}
	});
});
