$("#my-clients-form").on('submit', function (e) { // MJ: MANDA UN UPDATE O INSERT DEPENDIENDO EL TIPO DE LA TRANSACCIÓN
	type = $("#input_type").val();
	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: general_base_url + 'Clientes/addEditClient',
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		beforeSend: function () {
			// Actions before send post
		},
		success: function (data) {
			if (data == 1) {
				$('#modal-clients').modal("hide");
				cleanFields();
				$clients_table.ajax.reload();
				alerts.showNotification("top", "right", type == 1 ? "El cliente se ha agregado con éxito." : "La información se ha actualizado con éxito.", "success");
			} else {
				alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
			}
		},
		error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});

$(document).on("click", ".add-edit", function () { // MJ: SE CONDICIONAN LOS PARÁMETROS A MANIPULAR EN LA MODAL, DEPENDIENDO DE LA TRANSACCIÓN
	cleanFields();
	var type = $(this).attr("data-type");
	var id_cliente = $(this).attr("data-id-cliente");
	$("#input_id_cliente").val(id_cliente);
	$("#input_type").val(type);
	if (type == 1) { // MJ: ADD CLIENT
		showSubmitButton(1);
		document.getElementById("modal-clients-tittle").innerHTML = "Agregar cliente";
		disableFields(2); // MJ: SETS READONLY ATTRIBUTE = FALSE
	} else if (type == 2 || type == 3) { // 2 EDIT CLIENT / 3 SEE CLIENT INFORMATION
		document.getElementById("modal-clients-tittle").innerHTML = type == 2 ? "Editar información de cliente" : "Ver información de cliente";
		getClientInformation(id_cliente);
		if (type == 2) { // MJ: SEE INFORMATION - DISABLE FIELDS
			disableFields(2); // MJ: SETS READONLY ATTRIBUTE = FALSE
			showSubmitButton(1); // MJ: SHOW SUBMIT BUTTON
		} else {
			disableFields(1); // MJ: SETS READONLY ATTRIBUTE = TRUE
			showSubmitButton(2); // MJ: HIDE SUBMIT BUTTON
		}
	}
	$("#modal-clients").modal();
});

function getCountries() { // MJ: CONSULTA PARA OBTENER LOS PAÍSES, SE ENVÍA EL PARÁMETRO 6 (ID DEL CATÁLOGO)
	$("#select_country option[value]").remove();
	$.getJSON(general_base_url + "General/getOptions/" + "6").done(function (data) {
		$("#select_country").append($('<option disabled selected>').val("").text("Seleccione una opción"));
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_opcion'];
			var name = data[i]['nombre'];
			$("#select_country").append($('<option>').val(id).text(name));
		}
	});
}

function getStates() { // MJ: CONSULTA PARA OBTENER LOS ESTADOS, SE ENVÍA EL PARÁMETRO 7 (ID DEL CATÁLOGO)
	$("#select_state option[value]").remove();
	$.getJSON(general_base_url + "General/getOptions/" + "7").done(function (data) {
		$("#select_state").append($('<option disabled selected>').val("").text("Seleccione una opción"));
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_opcion'];
			var name = data[i]['nombre'];
			$("#select_state").append($('<option>').val(id).text(name));
		}
	});
}

function cleanFields() { // MJ: LIMPIA EL VALUE DE LOS CAMPOS CON BASE EN UN ID
	$("#input_first_name").val("");
	$("#input_last_name").val("");
	$("#input_mothers_last_name").val("");
	$("#input_email_address").val("");
	$("#input_phone").val("");
	$("#input_contact").val("");
	$("#select_country").val("");
	$("#input_street").val("");
	$("#input_number").val("");
	$("#input_suburb").val("");
	$("#input_municipality").val("");
	$("#input_postal_code").val("");
	$("#select_state").val("");
	$("#input_state").val("");
	$("#input_id_cliente").val("");
	$("#input_type").val("");
}

function getClientInformation(id_cliente) { // MJ: SE OBTIENE ROW CON LA INFORMACIÓN DEL CLIENTE
	$.getJSON(general_base_url + "Clientes/getClientInformation/" + id_cliente).done(function (data) {
		$.each(data, function (i, v) {
			fillFields(v); // MJ: SE EJECUTA FUNCIÓN PARA SETEAR EL VALUE CON BASE EN LA INFORMACIÓN RECIBIDA
		});
		validateNationality($("#select_country").val());
	});
}

function fillFields(v) { // MJ: RECIBE ARRAY DE DATOS Y LOS COLOCA EN LOS DISINTOS INPUTS CON BASE EN UN ID
	$("#input_first_name").val(v.nombre);
	$("#input_last_name").val(v.apellido_paterno);
	$("#input_mothers_last_name").val(v.apellido_materno);
	$("#input_email_address").val(v.correo);
	$("#input_phone").val(formatPhoneNumber(v.telefono));
	$("#input_contact").val(v.contacto);
	$("#select_country").val(v.pais);
	$('#select_country').change();
	$("#input_street").val(v.calle);
	$("#input_number").val(v.numero);
	$("#input_suburb").val(v.colonia);
	$("#input_municipality").val(v.municipio);
	$("#input_postal_code").val(v.cp);
	if (v.pais == 23) { // PAÍS = MÉXICO
		$("#select_state").val(v.estado);
		$('#select_state').change();
	}
	else { // PAÍS != MÉXICO
		$("#input_state").val(v.estado);
	}
}

$(document).on('click', '.change-status', function () { // MJ: FUNCIÓN CAMBIO DE ESTATUS ACTIVO / INACTIVO
	estatus = $(this).attr("data-status");
	$.ajax({
		type: 'POST',
		url: general_base_url + 'Clientes/addEditClient',
		data: {
			'input_id_cliente': $(this).attr("data-id-cliente"),
			'input_status': $(this).attr("data-status"),
			'input_type_up': 2
		},
		dataType: 'json',
		success: function (data) {
			if (data == 1) {
				alerts.showNotification("top", "right", estatus == 1 ? "Cliente activado con éxito." : "Cliente desactivado con éxito.", "success");
				$clients_table.ajax.reload();
			} else {
				alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
			}
		}, error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});

function disableFields(type) { // MJ: DESHABILITA CAMPOS CON BASE EN EL TRIPO DE TRANSACCIÓN 1 CONSULTA 2 EDIT
	// TYPE -> 1 SET READONLY ATTRIBUTE TRUE
	document.getElementById("input_first_name").readOnly = type == 1 ? true : false;
	document.getElementById("input_last_name").readOnly = type == 1 ? true : false;
	document.getElementById("input_mothers_last_name").readOnly = type == 1 ? true : false;
	document.getElementById("input_email_address").readOnly = type == 1 ? true : false;
	document.getElementById("input_phone").readOnly = type == 1 ? true : false;
	document.getElementById("input_contact").readOnly = type == 1 ? true : false;
	document.getElementById("select_country").disabled = type == 1 ? true : false;
	document.getElementById("input_street").readOnly = type == 1 ? true : false;
	document.getElementById("input_number").readOnly = type == 1 ? true : false;
	document.getElementById("input_suburb").readOnly = type == 1 ? true : false;
	document.getElementById("input_municipality").readOnly = type == 1 ? true : false;
	document.getElementById("input_postal_code").readOnly = type == 1 ? true : false;
	document.getElementById("select_state").disabled = type == 1 ? true : false;
	document.getElementById("input_state").readOnly = type == 1 ? true : false;
}

function validateNationality(nationality) { // MJ: SI LA NACIONALIDAD ES MEXICANA EL CAMPO DE ESTADO ES UN COMBO. SINO, ES UN INPUT TEXT
	var select_state = document.getElementById("select_state");
	var input_state = document.getElementById("input_state");
	if (nationality == 23) {// PAÍS == MÉXICO
		select_state.classList.remove("hide");
		input_state.classList.add("hide");
		$("#input_state").val("");
	} else { // PAÍS != MÉXICO
		input_state.classList.remove("hide");
		select_state.classList.add("hide");
		$("#select_state").val("");
	}
}

function showSubmitButton(type) { // MJ: SE MUESTRA U OCULTA BTN CON BASE EN EL TIPO DE TRANSACCIÓN 1 ADD 2 EDIT
	var submit_button = document.getElementById("submit_button");
	if (type == 1) // MJ: SHOW SUBMIT BUTTON
		submit_button.classList.remove("hide");
	else // MJ: HIDE SUBMIT BUTTON
		submit_button.classList.add("hide");
}
