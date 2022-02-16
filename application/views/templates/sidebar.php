<?php
$this->load->view('templates/header');
$this->load->view("templates/common_modals");
$this->load->library(array('cart'));
$cart = new Cart;
?>

<link rel="stylesheet" href="<?= base_url("assets/css/globalStyles.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/css/sidebarStyles.css") ?>">

<body>
<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
	<div class="scrollbar-inner">
		<!-- Brand -->
		<div class="sidenav-header d-flex align-items-center">
			<a class="navbar-brand" href="">
				<img src="<?= base_url("assets/img/brand/foodkeepers.png") ?>" class="navbar-brand-img" alt="...">
			</a>
			<div class="ml-auto">
				<!-- Sidenav toggler -->
				<div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
					<div class="sidenav-toggler-inner">
						<i class="sidenav-toggler-line"></i>
						<i class="sidenav-toggler-line"></i>
						<i class="sidenav-toggler-line"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="navbar-inner">
			<!-- Collapse -->
			<div class="collapse navbar-collapse" id="sidenav-collapse-main">
				<!-- Nav items -->
				<ul class="navbar-nav" id="accordionSidebar">
					<?php
					$url = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
					$url2 = "";
					$padreVal = 0;
					$rol = $this->session->userdata('id_rol');
					if ($rol == 1 || $rol == 2 || $rol == 3 || $rol == 4 || $rol == 5 || $rol == 6) {
						$url2 = base_url() . "index.php/Home";
					}
					if (isset($datos4)) {
						foreach ($datos4 as $valor) {
							$padreVal = $valor->padre;
						}
					}
					$c = 0;
					foreach ($datos2 as $datos) {
						if ($datos->padre == 0) {
							if ($datos->hijos == 0) { ?>
								<li class="nav-item <?php if ($url == $url2 && $datos->nombre == "Inicio") {
									echo 'active';
								} ?>">
									<a class="nav-link" href="<?= base_url() . 'index.php/' . $datos->pagina ?>">
										<i class="<?= $datos->icono ?> sidebar_i_dark"></i>
										<span class="nav-link-text menu-opc"><?= $datos->nombre ?></span>
									</a>
								</li>
								<?php
							} else { ?>
								<li class="nav-item <?php
								if (isset($datos4)) {

									if ($padreVal == $datos->orden) {
										echo 'active';
									}
								} ?>">
									<a class="nav-link <?php
									if (isset($datos4)) {

										if ($padreVal == $datos->orden) {
											echo '';
										} else {
											echo 'collapsed';
										}
									} ?>" href="#" data-toggle="collapse" data-target="#collapseUtilities_<?= $c ?>"
									   aria-expanded="true" aria-controls="collapseUtilities_<?= $c ?>">
										<i class="<?= $datos->icono ?>"></i>
										<span><?= $datos->nombre ?></span></a>
									</a>

									<div id="collapseUtilities_<?= $c ?>" class="collapse <?php if (isset($datos4)) {

										if ($padreVal == $datos->orden) {
											echo 'show';
										} else {
											echo '';
										}
									} ?> " aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
										<div class="bg-white py-2 collapse-inner rounded">
											<?php
											foreach ($datos3 as $hijos) {
												if ($hijos->orden >= $datos->orden && $hijos->orden <= $datos->orden + 1) {
													?>
													<a class="collapse-item <?php if ($url == base_url() . $hijos->pagina) {
														echo 'active';
													} ?>" href="<?= base_url() . $hijos->pagina ?>">
														<?= $hijos->nombre ?>
													</a>

													<?php
												}
											}
											?>
										</div>
									</div>
								</li>
							<?php }
						}
						$c += 1; //contador para agregar a cada id de las opciones del menu
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</nav>

<!-- Main content -->
<div class="main-content" id="panel">
	<!-- Topnav -->
	<nav class="navbar navbar-top navbar-expand navbar-dark bg-red border-bottom">
		<div class="container-fluid">
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<!-- Search form -->
				<form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
					<div class="form-group mb-0">
						<div class="input-group input-group-alternative input-group-merge">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fas fa-search"></i></span>
							</div>
							<input class="form-control" placeholder="Buscar" type="text">
						</div>
					</div>
					<button type="button" class="close" data-action="search-close" data-target="#navbar-search-main"
							aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</form>
				<!-- Navbar links -->
				<ul class="navbar-nav align-items-center  ml-md-auto ">
					<li class="nav-item d-xl-none">
						<!-- Sidenav toggler -->
						<div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
							 data-target="#sidenav-main">
							<div class="sidenav-toggler-inner">
								<i class="sidenav-toggler-line"></i>
								<i class="sidenav-toggler-line"></i>
								<i class="sidenav-toggler-line"></i>
							</div>
						</div>
					</li>
					<li class="nav-item d-sm-none">
						<a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
							<i class="ni ni-zoom-split-in"></i>
						</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
						   aria-expanded="false">
							<i class="ni ni-bell-55"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
							<!-- Dropdown header -->
							<div class="px-3 py-3">
								<h6 class="text-sm text-muted m-0">You have <strong class="text-primary">13</strong>
									notifications.</h6>
							</div>
							<!-- List group -->
							<div class="list-group list-group-flush">
								<a href="#!" class="list-group-item list-group-item-action">
									<div class="row align-items-center">
										<div class="col-auto">
											<!-- Avatar -->
											<img alt="Image placeholder"
												 src="<?= base_url("assets/img/theme/team-1.jpg") ?>"
												 class="avatar rounded-circle">
										</div>
										<div class="col ml--2">
											<div class="d-flex justify-content-between align-items-center">
												<div>
													<h4 class="mb-0 text-sm"><?= $this->session->userdata('nombre') . " " . $this->session->userdata('apellido_paterno') ?></h4>
												</div>
												<div class="text-right text-muted">
													<small>2 hrs ago</small>
												</div>
											</div>
											<p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>
										</div>
									</div>
								</a>
							</div>
							<!-- View all -->
							<a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a>
						</div>
					</li>
					<li class="nav-item dropdown item">
						<span class="notify-badge-sb"><?php echo $cart->total_items(); ?></span>
						<a class="nav-link fas fa-shopping-cart" id="cart-shopping-content" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
						<div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
							<!-- Dropdown header -->
							<div class="px-3 py-3">
								<h6 class="text-sm text-muted m-0">Artículos agregados a tu carrito</h6>
							</div>
							<!-- List group -->

							<?php
							if ($cart->total_items() > 0) {
							//get cart items from session
							$cartItems = $cart->contents();
								$i = 0;
							foreach ($cartItems as $item)  {
							?>

							<div class="list-group list-group-flush">
								<a href="#!" class="list-group-item list-group-item-action">
									<div class="row align-items-center">
										<div class="col-auto">
											<img alt="Image placeholder" src="<?= base_url() ?>assets/img/products/<?php echo $item["image"]; ?>" class="avatar rounded-circle">
										</div>
										<div class="col ml--2">
											<div class="d-flex justify-content-between align-items-center div-">
												<div>
													<h4 class="mb-0 text-sm"><?php echo $item["name"]; ?> <small>(<?php echo $item["qty"]; ?>)</small></h4>
												</div>
												<div class="text-right text-muted">
													<small><?php echo '$' . $item["subtotal"]; ?></small>
												</div>
											</div>
											<p class="text-sm mb-0">Código: <?php echo $item["code"]; ?></p>
										</div>
									</div>
								</a>
							</div>
							<?php
								if(++$i > 2) break;
							}
							?>
								<a href="<?= base_url() ?>index.php/Comprar/shoppingCart" class="dropdown-item text-center text-primary font-weight-bold py-3">Ver todo</a>
								<?php
							} else { ?>
								<a href="#!" class="list-group-item list-group-item-action">
									<div class="row align-items-center">
										<div class="col ml--2 text-center">
											<h4>Tu carrito está vacío...</h4>
										</div>
									</div>
								</a>
							<?php } ?>
							<!-- View all -->
						</div>

					</li>
				</ul>
				<ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
					<li class="nav-item dropdown">
						<a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
						   aria-expanded="false">
							<div class="media align-items-center">
								<span class="avatar avatar-sm rounded-circle">
									<img alt="Image placeholder" src="<?= base_url("assets/img/theme/team-4.jpg") ?>">
								</span>
								<div class="media-body ml-2 d-none d-lg-block">
									<span class="mb-0 menu-opc"><?= $this->session->userdata('nombre') . " " . $this->session->userdata('apellido_paterno') ?></span>
								</div>
							</div>
						</a>
						<div class="dropdown-menu  dropdown-menu-right ">
							<a href="<?= base_url() ?>index.php/Usuarios/myProfile" class="dropdown-item">
								<i class="ni ni-single-02"></i>
								<span>Mi perfil</span>
							</a>
							<div class="dropdown-divider"></div>
							<a href="<?= base_url() ?>index.php/Welcome/logout" class="dropdown-item">
								<i class="ni ni-user-run"></i>
								<span>Cerrar sesión</span>
							</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- Header -->
	<div class="header bg-red pb-6">
		<div class="container-fluid">
			<div class="header-body">
				<div class="row align-items-center py-4">
					<div class="col-lg-6 col-7">
						<h6 class="h2 text-white d-inline-block mb-0"></h6>
						<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
							<ol class="breadcrumb breadcrumb-links breadcrumb-dark m-0">
								<li class="breadcrumb-item"><a href="#" class="text-white"><i
											class="fas fa-home"></i></a></li>
								<li class="breadcrumb-item"><a href="#" class="text-white">Components</a></li>
								<li class="breadcrumb-item active text-white" aria-current="page">Icons</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END Header -->
