$(document).ready(function () {
	getClients();
	getCountries();
	getPaymentMethods();
	getCardsType();
	$("#select-clients").select2();
});


function getClients() { // MJ: CONSULTA PARA OBTENER LISTADO DE TODOS CIENTES
	$("#select-clients option[value]").remove();

	/*var vc_ar = Array();
	$.getJSON("getClients").done( function( data ){
		$.each( data, function( i, v){
			event.preventDefault();
			found = vc_ar.find(element => element == v.id_opcion);
			if(found != undefined)
			{
				$("#select-clients").append('<option selected value="'+v.id_opcion+'">'+v.nombre_cliente+'</option>');
			}
			else
			{
				$("#select-clients").append('<option value="'+v.id_opcion+'">'+v.nombre_cliente+'</option>');
			}
		});
	});*/

	$.getJSON("getClients").done(function (data) {
		$("#select-clients").append($('<option disabled selected>').val("").text("Seleccione una opción"));
		$("#select-clients").append($('<option>').val("0").text("AGREGAR"));
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_opcion'];
			var name = data[i]['nombre_cliente'];
			$("#select-clients").append($('<option>').val(id).text(name));
		}
	});

}

function getPaymentMethods() { // MJ: CONSULTA PARA OBTENER LISTADO DE MÉTODOS DE PAGO
	$("#select-payment-method option[value]").remove();
	$.getJSON(general_base_url + "General/getOptions/" + 8).done(function (data) {
		$("#select-payment-method").append($('<option disabled selected>').val("").text("Seleccione una opción"));
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_opcion'];
			var name = data[i]['nombre'];
			$("#select-payment-method").append($('<option>').val(id).text(name));
		}
	});
}

$('#select-clients').on('change', function () { // MJ: SE EVALÚA EL CLIENTE SELECCIONADO, SI ES LA PRIMERA OPCIÓN (VAL == 0)
	cleanFields();
	getCountries();
	getStates();
	var id_cliente = $("#select-clients").val();
	if (id_cliente == 0) {
		$("#input_type").val("1"); // MJ: TYPE = 1 ADD CLIENT
	}
	else {
		$("#input_type").val("2"); // MJ: TYPE = 2 UPDATE CLIENT
		getClientInformation(id_cliente); // MJ: SE OBTIENE ROW CON LA INFORMACIÓN DEL CLIENTE
	}
});

$("#my-customer-form").on('submit', function (e) { // MJ: POST PARA FINALIZAR PEDIDO
	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: general_base_url + 'Comprar/cartAction?action=placeOrder',
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		beforeSend: function () {
			// Actions before send post
		},
		success: function (data) {
			if (data == 1) {
				alerts.showNotification("top", "right", "Pedido finalizado con éxito.", "success");
				location.replace(general_base_url + "Comprar/orderSuccess");
			} else {
				alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
			}
		},
		error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});

function validateCardPayment() {
	var title = document.getElementById("title-card");
	var content = document.getElementById("row-card");
	if($('#myCheckbox1').is(':checked')){
		title.classList.remove("hide");
		content.classList.remove("hide");
	}
	else{
		title.classList.add("hide");
		content.classList.add("hide");
		$('#input_card_amount').val("");
		$('#input_msi').val("");
		$('#select_type').val("");
		$('#select_type').change();
	}
}

function validateTransferPayment() {
	var title = document.getElementById("title-transfer");
	var content = document.getElementById("row-transfer");
	if($('#myCheckbox2').is(':checked')){
		title.classList.remove("hide");
		content.classList.remove("hide");
	}
	else{
		title.classList.add("hide");
		content.classList.add("hide");
		$('#input_code').val("");
		$('#input_transfer_amount').val("");
	}
}

function validateCashPayment() {
	var title = document.getElementById("title-cash");
	var content = document.getElementById("row-cash");
	if($('#myCheckbox3').is(':checked')){
		title.classList.remove("hide");
		content.classList.remove("hide");
	}
	else{
		title.classList.add("hide");
		content.classList.add("hide");
		$('#input_cash_amount').val("");
	}
}

function getCardsType() { // MJ: CONSULTA PARA OBTENER LOS ESTADOS, SE ENVÍA EL PARÁMETRO 7 (ID DEL CATÁLOGO)
	$("#select_type option[value]").remove();
	$.getJSON(general_base_url + "General/getOptions/" + "9").done(function (data) {
		$("#select_type").append($('<option disabled selected>').val("").text("Seleccione una opción"));
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_opcion'];
			var name = data[i]['nombre'];
			$("#select_type").append($('<option>').val(id).text(name));
		}
	});
}


// init the state from the input
$(".image-checkbox").each(function () {
	if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
		$(this).addClass('image-checkbox-checked');
	} else {
		$(this).removeClass('image-checkbox-checked');
	}
});

// sync the state to the input
$(".image-checkbox").on("click", function (e) {
	$(this).toggleClass('image-checkbox-checked');
	var $checkbox = $(this).find('input[type="checkbox"]');
	$checkbox.prop("checked", !$checkbox.prop("checked"))
	e.preventDefault();
});

function sumEnteredAmount() {
	var cardAmount = parseFloat                                                               (document.getElementById('input_card_amount').value);
	var transferAmount = parseFloat(document.getElementById('input_transfer_amount').value);
	var cashAmount = parseFloat(document.getElementById('input_cash_amount').value);
	var total = cardAmount + transferAmount + cashAmount;
	$("#input_entered_amount").val(formatMoney(total));
	validateTotalAmount();
}

function validateTotalAmount() {
	var totalAmount = document.getElementById('input_total_amount').value;
	var enteredAmount = document.getElementById('input_entered_amount').value;
	if (totalAmount == enteredAmount)
		$('#btn_sumbit').prop('disabled', false);
	else{
		$('#btn_sumbit').prop('disabled', true);
		if (enteredAmount > totalAmount) { // MJ: EL MONTO INGRESADO ES MAYOR A LO QUE SE TIENE QUE PAGAR
			alerts.showNotification("top", "right", "El monto ingresado es mayor al total, verifica la cantidad.", "warning");
		}
	}
}

$("input[data-type='currency']").on({
	keyup: function() {
		formatCurrency($(this));
	},
	blur: function() {
		formatCurrency($(this), "blur");
	}
});

function formatNumber(n) {
	// format number 1000000 to 1,234,567
	return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}


function formatCurrency(input, blur) {
	// appends $ to value, validates decimal side
	// and puts cursor back in right position.

	// get input value
	var input_val = input.val();

	// don't validate empty input
	if (input_val === "") { return; }

	// original length
	var original_len = input_val.length;

	// initial caret position
	var caret_pos = input.prop("selectionStart");

	// check for decimal
	if (input_val.indexOf(".") >= 0) {

		// get position of first decimal
		// this prevents multiple decimals from
		// being entered
		var decimal_pos = input_val.indexOf(".");

		// split number by decimal point
		var left_side = input_val.substring(0, decimal_pos);
		var right_side = input_val.substring(decimal_pos);

		// add commas to left side of number
		left_side = formatNumber(left_side);

		// validate right side
		right_side = formatNumber(right_side);

		// On blur make sure 2 numbers after decimal
		if (blur === "blur") {
			right_side += "00";
		}

		// Limit decimal to only 2 digits
		right_side = right_side.substring(0, 2);

		// join number by .
		input_val = "$" + left_side + "." + right_side;

	} else {
		// no decimal entered
		// add commas to number
		// remove all non-digits
		input_val = formatNumber(input_val);
		input_val = "$" + input_val;

		// final formatting
		if (blur === "blur") {
			input_val += ".00";
		}
	}

	// send updated string to input
	input.val(input_val);

	// put caret back in the right position
	var updated_len = input_val.length;
	caret_pos = updated_len - original_len + caret_pos;
	input[0].setSelectionRange(caret_pos, caret_pos);
}



