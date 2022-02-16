$(document).ready(function(){
	$('#categoria').select2();
	$("#categoriaE").select2();
	populateCats();
	setFilters("#t_productos");
	$('#t_productos').DataTable({
		dom: 'Bfrtip',
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fas fa-file-excel"></i>',
				titleAttr: 'Excel',
				className: 'btn btn-success',
				title: 'FK_LISTA_PRODUCTOS',
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7],
					format: {
						header: function (d, columnIdx) {
							switch (columnIdx) {
								case 0:
									return 'CÓDIGO BARRAS';
									break;
								case 1:
									return 'ESTATUS';
									break;
								case 2:
									return 'NOMBRE';
									break;
								case 3:
									return 'CATEGORÍA';
									break;
								case 4:
									return 'PRECIO MAYORISTA';
									break;
								case 5:
									return 'PRECIO LISTA';
									break;
								case 6:
									return 'CÓDIGO';
									break;
								case 7:
									return 'EN STOCK';
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
					var code = '<img data-value="' + d.barcode + '" class="codigo"/>';
					return code;
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
					return d.categoria;
				}
			},
			{
				data: function (d) {
					return formatMoney(d.precio_mayorista);
				}
			},
			{
				data: function (d) {
					return formatMoney(d.precio_lista);
				}
			},
			{
				data: function (d) {
					return d.codigo;
				}
			},
			{
				data: function (d) {
					return d.cantidad_total;
				}
			},
			{
				data: function (d) {
						var buttons = '';
					if (d.estatus == 1) { // ACTIVE USER
						buttons = '<a class="dropdown-item change-status" data-id-producto="' + d.id_producto + '" data-status="2"><i class="fas fa-lock"></i>Desactivar</a>';
					} else {
						buttons = '<a class="dropdown-item change-status" data-id-producto="' + d.id_producto + '" data-status="1"><i class="fas fa-lock-open"></i>Activar</a>';
					}
					return '<div class="dropdown">\n' +
						'     	<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n' +
						'       	<i class="fas fa-ellipsis-v"></i>\n' +
						'        </a>\n' +
						'    	<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">\n' +
						'       	<a class="dropdown-item editarProducto" data-id-producto="' + d.id_producto + '"><i class="fas fa-edit"></i>Editar</a>\n' +
						/*'       	<a class="dropdown-item add-edit" data-id-producto="' + d.id_producto + '"><i class="fa fa-plus" aria-hidden="true"></i>Ver detalles</a>\n' +*/
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
		drawCallback: function (settings) {
			$('[data-toggle="tooltip"]').tooltip();
			JsBarcode('.codigo').init();
		},
		ajax: {
			url: "Productos/getAllProductos",
			dataSrc: "",
			type: "POST",
			cache: false,
			data: function( d ){
			}
		}
	});



	/*fill categorias*/

});

function validateFE() {
	if( document.getElementById("imagenProducto").files.length == 0 ){
		alerts.showNotification('top', 'right', 'Selecciona un archivo', 'danger');
	}
	else
	{
		if($('#nombre').val() != '' || $('#nombre').val() != null &&
			$('#precioMayorista').val() != '' || $('#precioMayorista').val() != null &&
			$('#precioLista').val() != '' || $('#precioLista').val() != null &&
			$('#codigo').val() != '' || $('#codigo').val() != null &&
			$('#descripcion').val() != '' || $('#descripcion').val() != null)
		{
			$('#sbmt_button').click();
		}
		else
		{
			alerts.showNotification('top', 'right', 'Debes llenar los campos requeridos', 'danger');
		}
	}
}

$("#addProductForm").submit( function(e) {
	e.preventDefault();
}).validate({
	rules: {
		'nombre':{
			required: true,
		},
		'precioMayorista':{
			required: true,
		},
		'precioLista':{
			required: true,
		},
		'codigo':{
			required: true,
		},
		'descripcion':{
			required: true,
		},
	},
	messages: {
		'nombre':{
			required : "Dato requerido"
		},
		'precioMayorista':{
			required : "Dato requerido"
		},
		'precioLista':{
			required : "Dato requerido"
		},
		'codigo':{
			required : "Dato requerido"
		},
		'descripcion':{
			required : "Dato requerido"
		},
	},
	submitHandler: function( form ) {

		var data = new FormData( $(form)[0] );

		$.ajax({
			url: 'Productos/addProduct',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
			method: 'POST',
			type: 'POST', // For jQuery < 1.9
			success: function(data){
				if( data.success==1 ){
					$("#addProductModal").modal( 'toggle' );
					$('#t_productos').DataTable().ajax.reload();
					alerts.showNotification('top', 'right', data.message, 'success');
					$("#addProductForm")[0].reset();
					$("#categoria").select2('val', '');
					$("#categoria").empty();
					populateCats();
					/*var frm = document.getElementsByName('uploadEvidenceForm')[0];
					frm.reset();*/
				}else{
					$("#addProductModal").modal( 'toggle' );
					$('#t_productos').DataTable().ajax.reload();
					alerts.showNotification('top', 'right', data.message, 'danger');
				}
			},error: function( ){
				$("#addProductModal").modal( 'toggle' );
				$('#t_productos').DataTable().ajax.reload();
				alerts.showNotification('top', 'right', 'Ocurrio un error al añadir el producto, intentalo nuevamente', 'danger');
			}
		});


	}
});

$(document).on('click', '.change-status', function() {
	estatus = $(this).attr("data-status");
	$.ajax({
		type: 'POST',
		url: 'Productos/changeStatus',
		data: {'id_producto': $(this).attr("data-id-producto"), 'estatus': $(this).attr("data-status")},
		dataType: 'json',
		success: function(data){
			if( data == 1 ){
				alerts.showNotification("top", "right", estatus == 1 ? "Producto habilitado con éxito." : "Producto Deshabilitado con éxito.", "success");
				$('#t_productos').DataTable().ajax.reload();
			}else{
				alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos.", "warning");
			}
		},error: function( ){
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});


$(document).on('click', '.editarProducto', function () {
//editProductModal
	$("#categoriaE").select2('val', '');
	$("#categoriaE").empty();
	var id_producto = $(this).attr("data-id-producto");
	$.getJSON("Productos/getProductInfoById/" + id_producto).done(function (data) {
		$.each(data, function (i, v) {
			fillFields(v);
		});
	});

	/*$.post("<?=base_url()?>index.php/Productos/GetCXPbyIdProd/" + id_producto, function(data) {
		var len = data.length;
		for(var i = 0; i<len; i++){
			var id = data[i]['id_opcion'];
			var name = data[i]['nombre'];


				$("#categoriaE").append($('<option>').val(id).text(name.toUpperCase()));
		}
		 $("#categoriaE").select('refresh');
	}, 'json');*/
	loadCatsXProd(id_producto);
	$("#editProductModal").modal('toggle');
});


function loadCatsXProd(id_producto){
	//$(".listado-enfermeras").append('<option value="">Seleccione una opción</option>');
	var vc_ar = Array();
	$.ajax({
		url:   'Productos/GetCXPbyIdProd/'+id_producto,
		type: 'post',
		dataType: 'json',
		success: function(data) {
			var long_data = data.length;
			if(long_data > 0) {
				for (var i = 0; i < long_data; i++) {
					vc_ar.push(data[i].id_categoria);
				}
			}
		},
		error: function(xhr, object, message) {
			console.log(message);
			console.log('Ocurrio un error');
		}
	});
	$.getJSON("Productos/getAllCats").done( function( data ){
		$.each( data, function( i, v){
			event.preventDefault();
			// $(".listado-enfermeras").append('<option value="'+v.id_usuario+'">'+v.name_enfermera+'</option>');
			found = vc_ar.find(element => element == v.id_categoria);
			if(found != undefined)
			{
				$("#categoriaE").append('<option selected value="'+v.id_categoria+'">'+v.nombre+'</option>');
			}
			else
			{
				$("#categoriaE").append('<option value="'+v.id_categoria+'">'+v.nombre+'</option>');
			}
		});
	});
	// $(".listado-enfermeras").select2();
};



function fillFields(v) {
	$("#img_prev").html('');
	$('#nombreE').val(v.nombre);
	$('#precioMayoristaE').val(v.precio_mayorista);
	$('#precioListaE').val(v.precio_lista);
	$('#codigoE').val(v.codigo);
	$('#descripcionE').val(v.descripcion);
	$('#id_productoE').val(v.id_producto);

	if(v.imagen != null || v.imagen.length > 0)
	{
		$('#img_prev').removeClass('hide');
		$("#img_prev").append("<center><img src='../assets/img/products/"+v.imagen+"' class='img-fluid' width='350px'></center><input type='hidden' id='imagenProductoE' name='imagenProductoE' value='"+v.imagen+"'><br><br><center><a class='btn btn-link text-dark' onclick='changeImage()'>Cambiar imagen</a></center>");
		$('#div_img').addClass('hide');
	}
	else
	{
		$('#div_img').removeClass('hide');
		$("#img_prev").append("<center><img src='../assets/img/products/"+v.imagen+"' class='img-fluid' width='350px'></center><input type='hidden' id='imagenProductoE' name='imagenProductoE' value='"+v.imagen+"'><br><br><center><a class='btn btn-link text-dark' onclick='changeImage()'>Cambiar imagen</a></center>");
	}

}
function changeImage()
{
	$("#img_prev").html('');
	$("#img_prev").addClass('hide');
	$('#div_img').removeClass('hide');
}



/*editProductForm*/
$("#editProductForm").submit( function(e) {
	e.preventDefault();
}).validate({
	submitHandler: function( form ) {

		var data = new FormData( $(form)[0] );

		$.ajax({
			url: 'Productos/updateProduct',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
			method: 'POST',
			type: 'POST', // For jQuery < 1.9
			success: function(data){
				if( data.success==1 ){
					$("#editProductModal").modal( 'toggle' );
					$('#t_productos').DataTable().ajax.reload();
					alerts.showNotification('top', 'right', data.message, 'success');
					$("#editProductForm")[0].reset();
					$("#categoriaE").select2('val', '');
					$("#categoriaE").empty();
					/*var frm = document.getElementsByName('uploadEvidenceForm')[0];
					frm.reset();*/
				}else{
					$("#editProductModal").modal( 'toggle' );
					$('#t_productos').DataTable().ajax.reload();
					alerts.showNotification('top', 'right', data.message, 'danger');
				}
			},error: function( ){
				$("#editProductModal").modal( 'toggle' );
				$('#t_productos').DataTable().ajax.reload();
				alerts.showNotification('top', 'right', 'Ocurrió un error al intentar subir la evidencia, intentalo de nuevo', 'danger');
			}
		});


	}
});

function populateCats()
{
	$.getJSON("Categorias/getAllCategoria").done( function( data ){
		// $("#categoria").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
		var len = data.length;
		for( var i = 0; i<len; i++)
		{
			var id = data[i]['id_categoria'];
			var name = data[i]['nombre'];
			$("#categoria").append($('<option>').val(id).text(name));
		}
	});
	// $("#categoria").selectpicker('refresh');
}
