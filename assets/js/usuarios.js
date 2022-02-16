$("#my-users-form").on('submit', function (e) { // MJ: POST PARA AGREGAR O EDITAR UN USUARIO
	type = $("#input_type").val();
	type_up = $("#input_type_up").val();
	form = $("#input_form").val();
	url_param = form == 1 ? 'Usuarios/addEditUser' : 'addEditUser';
	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: url_param,
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		beforeSend: function () {
			// Actions before send post
		},
		success: function (data) {
			if (data == 1) {
				if (form == 1) { // USERS FORM
					$('#modal-users').modal("hide");
					cleanFields();
					$users_table.ajax.reload();
				} else if (form == 2) { // MY PROFILE FORM
					setTimeout(function () {
						document.location.reload()
					}, 3000);
				}
				alerts.showNotification("top", "right", type == 1 ? "El usuario se ha agregado con éxito." : "La información se ha actualizado con éxito.", "success");
			} else {
				alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
			}
		},
		error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});

$(document).on("click", ".add-edit", function () { // MJ: PRELLENA MODAL CON BASE EN EL TIPO DE TRANSACCIÓN ADD / EDIT
	cleanFields();
	var type = $(this).attr("data-type");
	var id_usuario = $(this).attr("data-id-usuario");
	$("#input_id_usuario").val(id_usuario);
	$("#input_type").val(type);
	$("#input_form").val(1);
	if (type == 1) document.getElementById("modal-users-tittle").innerHTML = "Agregar usuario"; // ADD USER
	else if (type == 2) { // EDIT USER
		document.getElementById("modal-users-tittle").innerHTML = "Editar información de usuario";
		getUserInformation(id_usuario);
	}
	$("#modal-users").modal();
});

function getUsersType() { // MJ: CONSULTA PARA OBTENER LOS TIPOS DE USUARIOS, SE ENVÍA EL PARÁMETRO 1 (ID DEL CATÁLOGO)
	$("#select_user_type option[value]").remove();
	$.getJSON("General/getOptions/" + "1").done(function (data) {
		$("#select_user_type").append($('<option disabled selected>').val("").text("Seleccione una opción"));
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_opcion'];
			var name = data[i]['nombre'];
			$("#select_user_type").append($('<option>').val(id).text(name));
		}
	});
}

function getLocations() { // MJ: CONSULTA PARA OBTENER LOS ESTADOS, SE ENVÍA EL PARÁMETRO 2 (ID DEL CATÁLOGO)
	$("#select_location option[value]").remove();
	$.getJSON("General/getOptions/" + "2").done(function (data) {
		$("#select_location").append($('<option disabled selected>').val("").text("Seleccione una opción"));
		var len = data.length;
		for (var i = 0; i < len; i++) {
			var id = data[i]['id_opcion'];
			var name = data[i]['nombre'];
			$("#select_location").append($('<option>').val(id).text(name));
		}
	});
}

function cleanFields() { // MJ: LIMPIA EL VALUE DE LOS CAMPOS CON BASE EN UN ID
	$("#input_first_name").val("");
	$("#input_last_name").val("");
	$("#input_mothers_last_name").val("");
	$("#input_username").val("");
	$("#input-password").val("");
	$("#input_email_address").val("");
	$("#input_phone").val("");
	$("#select_user_type").val("");
	$("#select_location").val("");
	$("#input_id_usuario").val("");
	$("#input_type").val("");
	$("#input_form").val("");
}

function getUserInformation(id_usuario) { // MJ: SETEA LA INFORMACIÓN DEL USUARIO
	$.getJSON("Usuarios/getUserInformation/" + id_usuario).done(function (data) {
		$.each(data, function (i, v) {
			fillFields(v);
		});
	});
}

function fillFields(v) { // MJ: LLENA LA INFORMACIÓN DEL USUARIO CON BASE EN EL ROW RECIBIDO
	$("#input_first_name").val(v.nombre);
	$("#input_last_name").val(v.apellido_paterno);
	$("#input_mothers_last_name").val(v.apellido_materno);
	$("#input_username").val(v.usuario);
	$("#input-password").val(v.contrasena);
	$("#input_email_address").val(v.correo);
	$("#input_phone").val(formatPhoneNumber(v.telefono));
	$("#select_user_type").val(v.id_rol);
	$('#select_user_type').change();
	$("#select_location").val(v.id_sede);
	$('#select_location').change();
}

$(document).on('click', '.change-status', function () { // MJ: FUNCIÓN CAMBIO DE ESTATUS ACTIVO / INACTIVO
	estatus = $(this).attr("data-status");
	$.ajax({
		type: 'POST',
		url: 'Usuarios/addEditUser',
		data: {
			'input_id_usuario': $(this).attr("data-id-usuario"),
			'input_status': $(this).attr("data-status"),
			'input_type_up': 2
		},
		dataType: 'json',
		success: function (data) {
			if (data == 1) {
				alerts.showNotification("top", "right", estatus == 1 ? "Usuario activado con éxito." : "Usuario desactivado con éxito.", "success");
				$users_table.ajax.reload();
			} else {
				alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
			}
		}, error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});

$(document).on('click', '.send-email', function () { // MJ: REENVÍA CORREO PARA ACTIVACIÓN DE CUENTA
	$.ajax({
		type: 'POST',
		url: 'Usuarios/resendEmailValidation',
		data: {
			'input_id_usuario': $(this).attr("data-id-usuario")
		},
		dataType: 'json',
		success: function (data) {
			if (data == 1) {
				alerts.showNotification("top", "right", "Correo enviado con éxito.", "success");
			} else {
				alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
			}
		}, error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});

