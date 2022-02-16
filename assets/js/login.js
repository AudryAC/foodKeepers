$("#my-resetsession-form").on('submit', function (e) { // MJ: MANDA UN UPDATE O INSERT DEPENDIENDO EL TIPO DE LA TRANSACCIÓN
	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: 'index.php/Welcome/resetSession',
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		beforeSend: function () {
			// Actions before send post
		},
		success: function (data) {
			if (data == 1) {
				$("#modal-notification").modal("hide");
				alerts.showNotification("top", "right", "La sesión se ha cerrado de todos los dispositivos.", "success");
				setTimeout(function(){
					window.location.reload(1);
				}, 2000);
			} else {
				alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
			}
		},
		error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});
