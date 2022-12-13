
<style>
	.collapse a{
		text-indent:10px;
	}
	nav#sidebar{
		/*background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important*/
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-tachometer-alt "></i></span> Administrar</a>
				<a href="index.php?page=orders" class="nav-item nav-orders"><span class='icon-field'><i class="fa fa-clipboard-list "></i></span> Órdernes</a>
				<a href="billing/index.php" class="nav-item nav-takeorders"><span class='icon-field'><i class="fa fa-list-ol "></i></span> Tomar Órdenes</a>
				<a href="index.php?page=manage_gastos" class="nav-item nav-products"><span class='icon-field'><i class="fa fa-th-list "></i></span> Gastos</a>
				<?php if($_SESSION['login_type'] == 1): ?>

				<div class="mx-2 text-white">Gestión de Productos</div>
				<a href="index.php?page=categories" class="nav-item nav-categories"><span class='icon-field'><i class="fa fa-list-alt "></i></span> Categorías</a>
				<a href="index.php?page=products" class="nav-item nav-products"><span class='icon-field'><i class="fa fa-th-list "></i></span> Productos</a>
				<?php endif; ?>
				<div class="mx-2 text-white">Reportes</div>
				<a href="index.php?page=sales_report" class="nav-item nav-sales_report "><span class='icon-field'><i class="fa fa-list-alt "></i></span> Reporte de Ventas</a>
				<a href="index.php?page=gastos_report" class="nav-item nav-gastos_report"><span class='icon-field'><i class="fa fa-list-alt"></i></span> Reporte de Gastos</a>
				<a href="index.php?page=gastos_ventas_report" class="nav-item nav-gastos_ventas_report "><span class='icon-field'><i class="fa fa-list-alt"></i></span> Reporte de Gastos y Ventas</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<div class="mx-2 text-white">Sistema</div>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users "></i></span> Usuarios</a>
				<a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> Configuraciones de Sistema</a>
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
