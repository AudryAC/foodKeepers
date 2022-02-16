$(document).ready(function () {
	getLocations();
	getUsersType();
	setFilters("#table-users");
	$users_table = $('#table-users').DataTable({ // MJ: FILLS USERS DATA TABLE
		lengthChange: !1,
		dom: 'Bfrtip',
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fas fa-file-excel"></i>',
				titleAttr: 'Excel',
				className: 'btn btn-success',
				title: 'FK_LISTA_USUARIOS',
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7],
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
								case 5:
									return 'USUARIO';
									break;
								case 6:
									return 'TIPO';
									break;
								case 7:
									return 'UBICACIÓN';
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
					return d.id_usuario
				}
			},
			{
				data: function (d) {
					var content = '';
					if (d.estatus == 1) // MJ: ACTIVE USER
						content = '<span class="badge badge-dot w-100"><i class="bg-success"></i><span class="status text-white">1</span></span>';
					else if (d.estatus == 2)
						content = '<span class="badge badge-dot w-100"><i class="bg-warning"></i><span class="status text-white">2</span></span>';
					else
						content = '<span class="badge badge-dot w-100"><i class="bg-default"></i><span class="status text-white">3</span></span>';
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
					return d.usuario;
				}
			},
			{
				data: function (d) {
					return d.tipo;
				}
			},
			{
				data: function (d) {
					return d.ubicacion;
				}
			},
			{
				data: function (d) {
					var buttons = '';
					if (d.estatus == 1) // MJ: ACTIVE USER
						buttons = '<a class="dropdown-item change-status" data-id-usuario="' + d.id_usuario + '" data-status="2"><i class="fas fa-lock"></i>Desactivar</a>';
					else if (d.estatus == 2) // MJ: USUARIO NO ACTIVO
						buttons = '<a class="dropdown-item change-status" data-id-usuario="' + d.id_usuario + '" data-status="1"><i class="fas fa-lock-open"></i>Activar</a>';
					else // MJ: USUARIO PENDIENTE ACTIVACIÓN CUENTA
						buttons = '<a class="dropdown-item send-email" data-id-usuario="' + d.id_usuario + '" data-correo="' + d.correo + '" data-status="3"><i class="fas fa-redo"></i>Reenviar activación</a>';

					return '<div class="dropdown d-flex justify-content-center w-100">\n' +
						'     	<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n' +
						'       	<i class="fas fa-ellipsis-v"></i>\n' +
						'        </a>\n' +
						'    	<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">\n' +
						'       	<a class="dropdown-item add-edit" data-id-usuario="' + d.id_usuario + '" data-type="2"><i class="fas fa-edit"></i>Editar</a>\n' +
						'' + buttons + '' +
						'       </div>\n' +
						'    </div>';
				}
			}
		],
		ajax: {
			url: "Usuarios/getUsersList",
			type: "POST",
			cache: false,
			data: function (d) {
			}
		}
	});
});
