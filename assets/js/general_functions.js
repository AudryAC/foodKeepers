$().ready(function () {
	myFunctions =
		{
			validateEmptyField(field) {
				if (field == null || field == undefined || field == "") {
					return "N/A"
				} else {
					return field;
				}
			},
			number_format(number, decimals, dec_point, thousands_sep) {
				// Strip all characters but numerical ones.
				number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
				var n = !isFinite(+number) ? 0 : +number,
					prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
					sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
					dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
					s = '',
					toFixedFix = function (n, prec) {
						var k = Math.pow(10, prec);
						return '' + Math.round(n * k) / k;
					};
				// Fix for IE parseFloat(0.55).toFixed(0) = 0;
				s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
				if (s[0].length > 3) {
					s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
				}
				if ((s[1] || '').length < prec) {
					s[1] = s[1] || '';
					s[1] += new Array(prec - s[1].length + 1).join('0');
				}
				return s.join(dec);
			}
		}
});

function showPassword() { // MJ: CAMBIA EL TIPO DE TEXT A PASS WORD DE INPUT-PASSWORD
	var x = document.getElementById("input-password");
	if (x.type === "password") {
		x.type = "text";
		document.getElementById("eye_icon").classList.remove("fa-eye");
		document.getElementById("eye_icon").classList.add("fa-eye-slash");
	} else {
		x.type = "password";
		document.getElementById("eye_icon").classList.remove("fa-eye-slash");
		document.getElementById("eye_icon").classList.add("fa-eye");
	}
}

function toUpperCaseInputValue(element) { // MJ: CON BASE EN EL VALOR DE UN ELEMENTO SE PASA A MÁYUSCULA Y LO RETORNA
	element.value = element.value.toUpperCase();
}

function validateMaxLength(element) { // MJ: TOMA EL VALOR QUE SE COLOCÓ EN EL ATRIBUTO MAX LENGHT Y LO RESTRINGE A QUE SÓLO SEA ESE NÚMERO DE CARCTERES
	if (element.value.length > element.maxLength) element.value = element.value.slice(0, element.maxLength);
}

$("#my-changepassword-form").on('submit', function (e) { // MJ: POST PARA CAMBIO DE CONTRASEÑA
	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: 'Usuarios/changePassword',
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		beforeSend: function () {
			// Actions before send post
		},
		success: function (data) {
			if (data == 1) {
				$('#modal-form-reset-pass').modal("hide");
				alerts.showNotification("top", "right", "La contraseña se ha restablecido con éxito.", "success");
			} else {
				alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
			}
		},
		error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});

$('.input-password, .input_password_confirmation').on('keyup', function () { // MJ: FUNCIÓN ONKEYUP QUE VALIDA QUE EL CONTENIDO DE LOS DOS INPUTS DE PASSWORD SEA EL MISMO
	if ($('.input-password').val() != '' || $('.input_password_confirmation').val() != '') {
		if ($('.input-password').val() == $('.input_password_confirmation').val())
			$('#message').html('Ambas contraseñas coinciden').css('color', 'green');
		else
			$('#message').html('Por favor, asegúrate de que tus contraseñas coincidan.').css('color', 'red');
	} else
		$('#message').html('');
});

function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") { // MJ: FUNCIÓN PARA FORMATEAR INPUT A TIPO MONEDA
	try {
		decimalCount = Math.abs(decimalCount);
		decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

		const negativeSign = amount < 0 ? "-" : "";

		let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
		let j = (i.length > 3) ? i.length % 3 : 0;

		return '$' + negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
	} catch (e) {
		console.log(e)
	}
}

function formatPhoneNumber(input) { // MJ: FUNCIÓN PARA COLOCAR LA MÁSCARILLA A UN INPUT PHONE
	// Strip all characters from the input except digits
	input = input.toString().replace(/\D/g, '');
	// Trim the remaining input to ten characters, to preserve phone number format
	input = input.substring(0, 11);
	// Based upon the length of the string, we add formatting as necessary
	var size = input.length;
	if (size == 0) {
		input = input;
	} else if (size < 4) {
		input = '(' + input;
	} else if (size < 7) {
		input = '(' + input.substring(0, 3) + ') ' + input.substring(3, 6);
	} else {
		input = '(' + input.substring(0, 3) + ') ' + input.substring(3, 6) + '-' + input.substring(6, 10);
	}
	return input;
}

element = document.getElementById("input_phone");
if (element) { // MJ: SI EL ELEMENTO EXISTE, AGREGA EL EVENT LISTENER
	element.addEventListener("keyup", function (evt) {
		var phoneNumber = document.getElementById("input_phone");
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		phoneNumber.value = formatPhoneNumber(phoneNumber.value);
	});

}

$(document).on('click', '.update-status', function (e) { // MJ: FUNCIÓN PARA ABRIR MODAL DE CAMBIO ESTATUS EN PEDIDOS Y ENVÍOS
	e.preventDefault();
	e.stopImmediatePropagation();
	var from = $(this).attr("data-from");
	var type = $(this).attr("data-type");
	if (from == 1 || from == 2) {
		if ($('input[name="idT[]"]:checked').length > 0) { // MJ: AL MENOS SELECCINÓ UNA OPCIÓN
			if (from == 1) { // MJ: FROM PEDIDOS
				var id = $(orders_table.$('input[name="idT[]"]:checked')).map(function () {
					return this.value;
				}).get();
			} else if (from == 2) { // MJ: FROM ENVÍOS
				var id = $(shipping_table.$('input[name="idT[]"]:checked')).map(function () {
					return this.value;
				}).get();
			}
			$("#input_type_upc").val(type);
			$("#input_type_c").val(type);
			$("#input_id").val(id);
			getStatus(type);
			$("#modal-update-status").modal();
		} else { // MJ: NO HA SELECCIONADO NADA
			alerts.showNotification("top", "right", "Asegúrate de haber seleccionado al menos una opción.", "warning");
		}
	} else if (from == 3) { // MJ: INDIVIDUAL CHANGE STATUS FROM PEDIDOS & ENVÍOS
		var id = $(this).attr("data-id-row");
		$("#input_type_upc").val(type);
		$("#input_type_c").val(type);
		$("#input_id").val(id);
		getStatus(type);
		$("#modal-update-status").modal();
	}
});

function getStatus(type) { // MJ: FUNCIÓN PARA CONSULTAR LAS OPCIONES POR CATÁLOGO DE PEDIDOS Y ENVÍOS RESPECTIVAMENTE
	catalog = type == 1 ? "3" : "4";
	$("#select_status option[value]").remove();
	$.getJSON("General/getOptions/" + catalog).done(function (data) {
		$("#select_status").append($('<option disabled selected>').val("").text("Seleccione una opción"));
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_opcion'];
			var name = data[i]['nombre'];
			$("#select_status").append($('<option>').val(id).text(name));
		}
	});
}

$("#my-changestatus-form").on('submit', function (e) { // MJ: FUNCIÓN QUE CAMBIA LOS ESTATUS DE PEDIDOS Y ENVÍOS, RESPECTIVAMENTE
	e.preventDefault();
	e.stopImmediatePropagation();
	var id = $("#input_id").val();
	var type = $("#input_type_c").val();
	$.ajax({
		type: 'POST',
		url: 'General/changeStatus/' + id,
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		beforeSend: function () {
			// Actions before send post
		},
		success: function (data) {
			if (data == 1) {
				$('#modal-update-status').modal("hide");
				alerts.showNotification("top", "right", "El estatus se ha actualizado con éxito.", "success");
				type == 1 ? orders_table.ajax.reload() : shipping_table.ajax.reload();
			} else {
				alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
			}
		},
		error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});

function selectAll(e) { // MJ: CHEKEA TODAS LAS OPCIONES
	const cb = document.getElementById('all');
	if (cb.checked) {
		$('input[type="checkbox"]').prop('checked', true);
	} else {
		$('input[type="checkbox"]').prop('checked', false);
	}
}

function fillChangelog(v) { // MJ: SETEA EL ARRAY DE DATOS QUE RECIBE PARA EL CHANGELOG
	$("#changelog").append('<div class="timeline-block">' +
		'<span class="timeline-step badge-success">' +
		'<i class="ni ni-bell-55"></i>' +
		'</span>' +
		'<div class="timeline-content">' +
		'<div class="d-flex justify-content-between pt-1">' +
		'<div>' +
		'<span class="text-muted text-sm font-weight-bold">' + v.estatus + '</span>' +
		'</div>' +
		'<div class="text-right">' +
		'<small class="text-muted"><i class="fas fa-clock mr-1"></i>' + v.fecha + '</small>' +
		'</div>' +
		'</div>' +
		'<h6 class="text-sm mt-1 mb-0">' + v.nombre_usuario + '</h6>' +
		'</div>' +
		'</div>');
}

function cleanElement(element) { // MJ: LIMPIA EL CONTENIDO DE UN ELEMENTO
	var myElement = document.getElementById(element);
	myElement.innerHTML = '';
}

function setFilters(table) { // MJ: COLOCA LOS FILTROS EN EL ENCABEZADO DE CADA TABLA, RECIBE COMO PARÁMETRO EL ID DE LA TABLA
	let titulos = [];
	$('table thead tr:eq(0) th').each(function (i) {
		var title = $(this).text();
		titulos.push(title);
		$(this).html('<input type="text" style="width:100%; background:#f6f9fc; color:#8898aa; border: 0px; font-weight: 500; font-size: .65rem; text-transform: uppercase; border-bottom: 0px" class="textoshead"  placeholder="' + title + '"/>');
		$('input', this).on('keyup change', function () {
			if ($(table).DataTable().column(i).search() !== this.value) {
				$(table).DataTable()
					.column(i)
					.search(this.value)
					.draw();
			}
		});
	});
}

$(document).on('fileselect', '.btn-file :file', function (event, numFiles, label) { // MJ
	var input = $(this).closest('.input-group').find(':text'),
		log = numFiles > 1 ? numFiles + ' archivos seleccionados' : label;
	if (input.length) {
		input.val(log);
	} else {
		if (log) alert(log);
	}
});

$(document).on('change', '.btn-file :file', function () { // MJ
	var input = $(this),
		numFiles = input.get(0).files ? input.get(0).files.length : 1,
		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	input.trigger('fileselect', [numFiles, label]);
});

$(document).on("click", ".see-changelog", function (e) { // MJ: SE OBTIENE EL CHANGE LOG DE PEDIDOS O ENVÍOS
	e.preventDefault();
	e.stopImmediatePropagation();
	var id = $(this).attr("data-id-row");
	var type = $(this).attr("data-type");
	$.getJSON("General/getChangelog/" + id + "/" + type).done(function (data) {
		if (data.length > 0) {
			$.each(data, function (i, v) {
				fillChangelog(v);
			});
		} else {
			$("#changelog").append('<h6 class="text-sm mt-1 mb-0">Sin información que mostrar.</h6>');
		}
	});
	$("#modal-changelog").modal();
});

function reloadLocation() {
	location.reload();
}

function initTooltip() {
	var $tooltip = $('[data-toggle="tooltip"]');
	$tooltip.tooltip();
}

$(document).on('keypress', '.input-only-letters', function (event) { // MJ: EVALÚA EL VALOR DEL INPUT: SÓLO PERMITE LETRAS Y ESPEACIÓN EN BLANCO
	/*var regex = new RegExp("^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}*/
	/*var letters = /^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$/;
	if(inputtxt.value.match(letters)){

	} else {
		return false;
	}*/

});

$(document).on('keydown', '.input-only-letters', function (event) { // MJ: EVALÚA EL VALOR DEL INPUT: SÓLO PERMITE LETRAS Y ESPEACION EN BLANCO
	var regex = new RegExp("^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

$(document).on('keypress', '.input-only-numbers', function (event) { // MJ: EVALÚA EL VALOR DEL INPUT: SÓLO PERMITE LETRAS Y ESPEACION EN BLANCO
	var regex = new RegExp("^[0-9]");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

$(document).on('keydown', '.input-only-numbers', function (event) { // MJ: EVALÚA EL VALOR DEL INPUT: SÓLO PERMITE LETRAS Y ESPEACION EN BLANCO
	var regex = new RegExp("^[0-9]");
	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	if (!regex.test(key)) {
		event.preventDefault();
		return false;
	}
});

function filterFloat(evt, input){
	// Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
	var key = window.Event ? evt.which : evt.keyCode;
	var chark = String.fromCharCode(key);
	var tempValue = input.value+chark;
	if(key >= 48 && key <= 57){
		if(filter(tempValue)=== false){
			return false;
		}else{
			return true;
		}
	}else{
		if(key == 8 || key == 13 || key == 0) {
			return true;
		}else if(key == 46){
			if(filter(tempValue)=== false){
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}
	}
}

function filter(__val__){
	var preg = /^([0-9]+\.?[0-9]{0,2})$/;
	if(preg.test(__val__) === true){
		return true;
	}else{
		return false;
	}
}


