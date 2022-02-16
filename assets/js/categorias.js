$(document).ready(function () {
	setFilters("#t_categorias");

	$('#t_categorias thead tr:eq(0) th').each(function (i) {

	});
	$('#t_categorias').DataTable({
		dom: 'Bfrtip',
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fas fa-file-excel"></i>',
				titleAttr: 'Excel',
				className: 'btn btn-success',
				title: 'FK_LISTA_CATEGORIAS',
				exportOptions: {
					columns: [0, 1, 2, 3],
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
									return 'CREACIÓN';
									break;
							}
						}
					}
				},
			}
		],
		pagingType: "full_numbers",
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 25, 50, "Todos"]
		],
		drawCallback: function (settings) {
			$('[data-toggle="tooltip"]').tooltip();
		},
		language: {
			url: "../assets/vendor/datatables.net/Spanish.json",
			paginate: {
				previous: "<i class='fas fa-angle-left'>",
				next: "<i class='fas fa-angle-right'>"
			}
		},
		destroy: true,
		ordering: false,
		columns: [
			{
				data: function (d) {
					return d.id_categoria
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
					return d.nombre;
				}
			},
			{
				data: function (d) {
					return d.fecha_creacion;
				}
			},
			{
				data: function (d) {
					var buttons = '';
					if (d.estatus == 1) { // ACTIVE USER
						buttons = '<a class="dropdown-item change-status" data-id-categoria="' + d.id_categoria + '" data-status="2"><i class="fas fa-lock"></i>Desactivar</a>';
					} else {
						buttons = '<a class="dropdown-item change-status" data-id-categoria="' + d.id_categoria + '" data-status="1"><i class="fas fa-lock-open"></i>Activar</a>';
					}
					return '<div class="dropdown d-flex justify-content-center w-100">\n' +
						'     	<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n' +
						'       	<i class="fas fa-ellipsis-v"></i>\n' +
						'        </a>\n' +
						'    	<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">\n' +
						'       	<a class="dropdown-item editarCategoria" data-id-categoria="' + d.id_categoria + '"><i class="fas fa-edit"></i>Editar</a>\n' +
						'' + buttons + '' +
						'       </div>\n' +
						'    </div>';


				}
			}
		],
		columnDefs: [
			{
				searchable: true,
				orderable: false,
				targets: 0
			},

		],
		ajax: {
			url: "Categorias/getAllCategoria",
			dataSrc: "",
			type: "POST",
			cache: false,
			data: function (d) {
			}
		}
	});
});


$(document).on('click', '.change-status', function () {
	estatus = $(this).attr("data-status");
	$.ajax({
		type: 'POST',
		url: 'Categorias/changeStatus',
		data: {'id_categoria': $(this).attr("data-id-categoria"), 'estatus': $(this).attr("data-status")},
		dataType: 'json',
		success: function (data) {
			if (data == 1) {
				alerts.showNotification("top", "right", estatus == 1 ? "Categoría habilitada con éxito." : "Categoría deshabilitada con éxito.", "success");
				$('#t_categorias').DataTable().ajax.reload();
			} else {
				alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
			}
		}, error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});

function validateFE() {
	if (document.getElementById("imagenCategoria").files.length == 0) {
		alerts.showNotification('top', 'right', 'Debes seleccionar un archivo.', 'danger');
	} else {
		if ($('#nombre').val() != '' || $('#nombre').val() != null) {
			$('#sbmt_button').click();
		} else {
			alerts.showNotification('top', 'right', 'Debes llenar los campos requeridos', 'danger');
		}
	}
}

$("#addCategoriaForm").submit(function (e) {
	e.preventDefault();
}).validate({
	submitHandler: function (form) {

		var data = new FormData($(form)[0]);

		$.ajax({
			url: 'Categorias/addCategoria',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
			method: 'POST',
			type: 'POST', // For jQuery < 1.9
			success: function (data) {
				if (data.success == 1) {
					$("#addCategoriaModal").modal('toggle');
					$('#t_categorias').DataTable().ajax.reload();
					alerts.showNotification('top', 'right', data.message, 'success');
					$("#addCategoriaForm")[0].reset();
					/*var frm = document.getElementsByName('uploadEvidenceForm')[0];
					frm.reset();*/
				} else {
					$("#addCategoriaModal").modal('toggle');
					$('#t_categorias').DataTable().ajax.reload();
					alerts.showNotification('top', 'right', data.message, 'danger');
				}
			}, error: function () {
				$("#addCategoriaModal").modal('toggle');
				$('#t_categorias').DataTable().ajax.reload();
				alerts.showNotification('top', 'right', 'OCURRIO UN ERROR AL SUBIR LA EVIDENCIA, INTENTALO DE NUEVO', 'danger');
			}
		});


	}
});


/**************************/
$(document).on('click', '.editarCategoria', function () {
//editProductModal

	var id_categoria = $(this).attr("data-id-categoria");
	$.getJSON("Categorias/getCatInfoById/" + id_categoria).done(function (data) {
		$.each(data, function (i, v) {
			fillFields(v);
		});
	});
	$("#editCategoriaModal").modal('toggle');
});

function fillFields(v) {
	$('#nombreE').val(v.nombre);
	$('#id_categoriaE').val(v.id_categoria);
	if (v.imagen != null || v.imagen.length > 0) {
		$('#img_prev').removeClass('hide');
		$("#img_prev").append("<img src='../assets/img/categories/" + v.imagen + "' class='img-fluid'><input type='hidden' id='imagenCategoriaE' name='imagenCategoriaE' value='" + v.imagen + "'><br><br><center><a class='btn btn-link text-dark' onclick='changeImage()'>Cambiar imagen</a></center>");
		$('#div_img').addClass('hide');
	} else {
		$('#div_img').removeClass('hide');
		$("#img_prev").append("<img src='../assets/img/categories/" + v.imagen + "' class='img-fluid'><input type='hidden' id='imagenCategoriaE' name='imagenCategoriaE' value='" + v.imagen + "'><br><br><center><a class='btn btn-link text-dark' onclick='changeImage()'>Cambiar imagen</a></center>");
	}
}

function changeImage() {
	$("#img_prev").html('');
	$("#img_prev").addClass('hide');
	$('#div_img').removeClass('hide');
}

/*editProductForm*/
$("#editCategoryForm").submit(function (e) {
	e.preventDefault();
}).validate({
	submitHandler: function (form) {

		var data = new FormData($(form)[0]);

		$.ajax({
			url: 'Categorias/updateCategory',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
			method: 'POST',
			type: 'POST', // For jQuery < 1.9
			success: function (data) {
				if (data.success == 1) {
					$("#editCategoriaModal").modal('toggle');
					$('#t_categorias').DataTable().ajax.reload();
					alerts.showNotification('top', 'right', data.message, 'success');
					$("#editCategoryForm")[0].reset();
					/*var frm = document.getElementsByName('uploadEvidenceForm')[0];
					frm.reset();*/
				} else {
					$("#editCategoriaModal").modal('toggle');
					$('#t_categorias').DataTable().ajax.reload();
					alerts.showNotification('top', 'right', data.message, 'danger');
				}
			}, error: function () {
				$("#editCategoriaModal").modal('toggle');
				$('#t_categorias').DataTable().ajax.reload();
				alerts.showNotification('top', 'right', 'Ocurrió un error al subir la evidencia, inténtalo de nuevo.', 'danger');
			}
		});


	}
});


