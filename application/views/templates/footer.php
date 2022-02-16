<!-- Argon Scripts -->
<!-- Core -->
<script src="<?= base_url("assets/vendor/jquery/dist/jquery.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/js-cookie/js.cookie.js") ?>"></script>
<script src="<?= base_url("assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js") ?>"></script>
<!-- Optional JS -->
<script src="<?= base_url("assets/vendor/clipboard/dist/clipboard.min.js") ?>"></script>
<!-- Charts JS -->
<script src="<?= base_url("assets/vendor/chart.js/dist/Chart.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/chart.js/dist/Chart.extension.js") ?>"></script>
<!-- Argon JS -->
<script src="<?= base_url("assets/js/argon.js?v=1.2.0") ?>"></script>

<!-- DataTables-->
<script src="<?= base_url("assets/vendor/datatables.net/js/jquery.dataTables.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/datatables.net/js/jquery.dataTables.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/datatables.net-select/js/dataTables.select.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/added/js/jquery.validate.min.js") ?>"></script>

<script src="<?= base_url("assets/vendor/added/js/jszip.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/added/js/pdfmake.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/added/js/vfs_fonts.js") ?>"></script>
<script src="<?= base_url("assets/vendor/added/js/buttons.html5.min.js") ?>"></script>
<script src="<?= base_url("assets/vendor/added/js/buttons.print.min.js") ?>"></script>

<!-- Notification -->
<script src="<?= base_url("assets/vendor/bootstrap-notify/bootstrap-notify.min.js") ?>"></script>
<script src="<?= base_url("assets/js/alerts.js") ?>"></script>
<!--<script src="--><? //= base_url("assets/js/jquery.validate.min.js")?><!--"></script>-->
<!-- Global functions -->
<script src="<?= base_url("assets/js/general_functions.js") ?>"></script>
<script src="<?= base_url() ?>assets/vendor/select2/dist/js/select2.min.js"></script>

<script>
	$(document).ready(function () {
		<?php if ($this->session->userdata('restablecer_contrasena') == 1) {
		echo '$("#modal-form-reset-pass").modal("toggle");';
		echo 'console.log(' . $this->session->userdata('restablecer_contrasena') . ')';
	}
		?>
	});

	var general_base_url = '<?= base_url("index.php/")?>';
	var base_url = '<?=base_url()?>';
</script>
