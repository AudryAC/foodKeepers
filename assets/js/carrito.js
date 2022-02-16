function updateCartItem(obj,id){
	var oldQty = $("#old_quantity").val();
	var id_product =$("#id").val();
	estatus = $(this).attr("data-status");
	$.get("cartAction", {action:"updateCartItem", id:id, qty:obj.value, old_qty:oldQty, id_producto: id_product}, function(data){
		if(data == 'ok'){
			location.reload();
		}else{
			alerts.showNotification("top", "right", "Error al actualizar el carrito, vuelve a intentarlo.", "danger");
		}
	});
}

function confirmation() {
	swal({
		title: 'Are you sure?',
		text: "You won't be able to revert this!",
		type: 'warning',
		showCancelButton: true,
		buttonsStyling: false,
		confirmButtonClass: 'btn btn-danger',
		confirmButtonText: 'Yes, delete it!',
		cancelButtonClass: 'btn btn-secondary'
	}).then((result) => {
		if (result.value) {
			// Show confirmation
			swal({
				title: 'Deleted!',
				text: 'Your file has been deleted.',
				type: 'success',
				buttonsStyling: false,
				confirmButtonClass: 'btn btn-primary'
			});
		}
	})
}

function incrementValue(e) {
	e.preventDefault();
	var fieldName = $(e.target).data('field');
	var parent = $(e.target).closest('div');
	var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
	if (!isNaN(currentVal)) {
		parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
	} else {
		parent.find('input[name=' + fieldName + ']').val(0);
	}
	parent.find('input[name=' + fieldName + ']').change();
}

function decrementValue(e) {
	e.preventDefault();
	var fieldName = $(e.target).data('field');
	var parent = $(e.target).closest('div');
	var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
	if (!isNaN(currentVal) && currentVal > 0) {
		parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
	} else {
		parent.find('input[name=' + fieldName + ']').val(0);
	}
	parent.find('input[name=' + fieldName + ']').change();
}

$(document).on('click', '.plus-btn', function (e) {
	incrementValue(e);
});

$(document).on('click', '.minus-btn', function (e) {
	decrementValue(e);
});

$(document).on("click", ".remove-cart-item", function () { // MJ: SE CONDICIONAN LOS PARÁMETROS A MANIPULAR EN LA MODAL, DEPENDIENDO DE LA TRANSACCIÓN
	var id = $(this).attr("data-id");
	var qty = $(this).attr("data-qty");
	var id_producto = $(this).attr("data-id-producto");
	$("#input_rowid").val(id);
	$("#input_qty").val(qty);
	$("#input_id_producto").val(id_producto);
	$("#modal-remove-item").modal();
});

function removeCartItem(){
	var id = $("#input_rowid").val();
	var qty = $("#input_qty").val();
	var id_producto = $("#input_id_producto").val();
	$.ajax({
		type: 'POST',
		url: 'cartAction?action=removeCartItem&id=' + id + '&qty=' + qty + '&id_producto=' + id_producto,
		data: {},
		dataType: 'json',
		success: function (data) {
			if (data == 1) {
				setTimeout(function(){
					window.location.reload(1);
				}, 2000);
				alerts.showNotification("top", "right", "Producto eliminado del carrito.", "secondary");
				$("#modal-remove-item").modal("hide");
			} else {
				alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
			}
		}, error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
}
