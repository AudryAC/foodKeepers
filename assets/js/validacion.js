$("#my-activateaccount-form").on('submit', function (e) { // MJ: MANDA UN UPDATE O INSERT DEPENDIENDO EL TIPO DE LA TRANSACCIÓN
	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: general_base_url + 'index.php/Validacion/activeteAccount',
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		beforeSend: function () {
			// Actions before send post
		},
		success: function (data) {
			if (data == 1) {
				var elem = document.getElementById("div-general");
				elem.remove();
				alerts.showNotification("top", "right", "La cuenta ha sido activada con éxito", "success");
				$("#div-result").append('<div class="card-body px-lg-5 py-lg-5"><div class="text-center text-muted mb-4"><small>Activación exitosa.</small></div></div>');
				setTimeout(function(){
					window.location.href = general_base_url;
				}, 5000);
			} else {
				alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
			}
		},
		error: function () {
			alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
		}
	});
});
