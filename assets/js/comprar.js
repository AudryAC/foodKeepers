$(document).ready(function () {
	getCategories();
});


function getCategories() { // MJ: CONSULTA PARA OBTENER LISTADO DE TODAS LAS CATEGORÍAS ACTIVAS
	$("#select_categories option[value]").remove();
	$.getJSON("Comprar/getCategories").done(function (data) {
		$("#select_categories").append($('<option disabled selected>').val("").text("Seleccione una opción"));
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_opcion'];
			var name = data[i]['nombre'];
			$("#select_categories").append($('<option>').val(id).text(name));
		}
	});
}

$('#select_categories').on('change', function () { // MJ: TRAE TODOS LOS PRODUCTOS POR CATEGORÍA SELECCIONADA
	var categorie = $("#select_categories").val();
	cleanElement('content_products');
	$.getJSON("Comprar/getProductsByCategorie/" + categorie).done(function (data) {
		var len = data.length;
		if (len > 0) {
			for (var i = 0; i < len; i++) {
				$("#content_products").append('<div class="col-xl-4 col-md-6 col-sm-12">\n' +
					'    <div class="card card-stats">\n' +
					'        <!-- Card body -->\n' +
					'        <div class="card-body producto-item">\n' +
					'            <div class="row align-items-center">\n' +
					'                <div class="col-auto">\n' +
					'                  	 <span class="notify-badge producto-item-modal" data-card="' + data[i]['id_producto'] + '"><i class="fas fa-search-plus"></i></span>\n' +
					'                    <img src="' + base_url + 'assets/img/products/' + data[i]['image'] + '" class="avatar avatar-xl rounded-circle">\n' +
					'                </div>\n' +
					'                <div class="col ml--2">\n' +
					'                  <h4 class="mb-0">\n' +
					'                    <a>' + data[i]['nombre'] + '</a>\n' +
					'                  </h4>\n' +
					'                  <p class="text-sm text-muted mb-0">' + formatMoney(data[i]['precio_lista']) + '</p>\n' +
					'                </div>\n' +
					'              </div>\n' +
					'                <div class="col ml--2 text-right">' +
					'                	<div class="align-items-center">' +
					' 						<div class="quantity mb-0 w-100 text-right">' +
					' 							<input type="button" value="-" class="minus-btn btn-quantity" data-field="quantity" disabled>' +
					' 							<input type="text" step="1" max="" name="quantity" class="quantity-field" value="1" onchange="addCartItem(this, '+ data[i]['id_producto'] +', 1)">' +
					'   						<input type="button" value="+" class="plus-btn btn-quantity" data-field="quantity" value="1" onclick="addCartItem(1, '+ data[i]['id_producto'] +', 2)" data-toggle="tooltip" title="Agregar al carrito">\n' +
					'     					</div>\n' +
					' 					</div>' +
					'              	 </div>\n' +
					'        </div>\n' +
					'    </div>\n' +
					'</div>	');
			}
			initTooltip();
		} else {
			$("#content_products").append('<div class="col-xl-4 col-md-6 col-sm-12"><h5 class="card-title text-uppercase mb-0">Sin productos que mostrar</h5></div>');
		}
	});
});

function addCartItem(obj, id, type){ // MJ: RECIBE 3 PARÁMETROS obj: input value / button value, id: product id y type: input onchange / button onclic
	// type 1 = INPUT ONCHANGE
	// type 2 = BUTTON ONCLIC
	var qty = type == 1 ? obj.value : obj;
	$.ajax({
		type: 'POST',
		url: 'Comprar/cartAction?action=addToCart&id=' + id + '&qty=' + qty,
		data: {},
		dataType: 'json',
		success: function (data) {
			if (data == 1) {
				alerts.showNotification("top", "right", type == 1 ? "Productos agregados con éxito." : "Producto agregado con éxito.", "secondary");
				$('#cart-shopping-content').load(location.href + " #cart-shopping-content");
				$("#cart-shopping-content").load(location.href + " #cart-shopping-content>*", "");
			} else {
				alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
			}
		}, error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
}

$(document).on('click', '.producto-item-modal', function () {
	id_producto = $(this).attr("data-card");
	console.log('alv si lo abriste: ' + id_producto);


	$.post('Productos/getProductInfoById/' + id_producto, function (data) {
		data = JSON.parse(data);
		console.log(data[0]);
		$('#name_product_details').text(data[0].nombre);
		$('#precio_lista').text("$" + data[0].precio_lista);
		$('#precio_mayorista').text("$" + data[0].precio_mayorista);
		$('#cnt-img-product').html('<img src="../assets/img/products/' + data[0].imagen + '" class="img-fluid">');
		$('#text-description').text(data[0].descripcion);
		$('#code_text').text(data[0].codigo);
		$('#addToCartAction').html('<a class="text-success mr-2 additemsca" data-id-producto="' + data[0].id_producto + '" data-toggle="tooltip" title="" data-original-title="Agregar al carrito"> <i class="fas fa-plus-circle"></i></a>');
		$('#itemsToAdd').val(1);
	});

	$('#products-details').modal();

});

$(document).on('click', '.additemsca', function () {
	id_producto = $(this).attr("data-id-producto");
	var cantidad = $('#itemsToAdd').val();
	if (cantidad != '' || cantidad != null) {
		console.log('Agregare ' + cantidad + " con el producto: id" + id_producto);
		$('#btnActionCart').html('<a class="text-success mr-2 addToCart2" id="action_call00' + id_producto + '" data-id-producto="' + id_producto + '" data-toggle="tooltip" ' +
			'title="" data-quantity="' + cantidad + '" data-original-title="Agregar al carrito"><i class="fas fa-plus-circle" data-id-producto="3"></i></a>');

		$('#action_call00' + id_producto).click();
	} else {
		alerts.showNotification('top', 'right', 'Debes seleccionar una cantidad valida', 'warning');
	}
	console.log(cantidad);
	/**/
});


$(document).on('click', '.addToCart2', function () { // MJ: MODIFICA EL ESTATUS DE UN PEDIDO
	id_producto = $(this).attr("data-id-producto");
	cantidad = $(this).attr("data-quantity");
	$.ajax({
		type: 'POST',
		url: 'Comprar/cartAction?action=addToCart&id=' + id_producto + '&qty=' + cantidad,
		data: {},
		dataType: 'json',
		success: function (data) {
			if (data == 1) {
				alerts.showNotification("top", "right", "Producto agregado con éxito.", "secondary");
				$('#products-details').modal('toggle');
				$('#cart-shopping-content').load(location.href + " #cart-shopping-content");
				$("#cart-shopping-content").load(location.href + " #cart-shopping-content>*", "");
			} else {
				alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
			}
		}, error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});
