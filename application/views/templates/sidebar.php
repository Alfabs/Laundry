<?php
$userRole = $user['role'];

?>


 
 <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
			  <?php if($userRole === "admin"):?>	
                <div class="sidebar-brand-icon">
                    <i class="fas fa-user-lock"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin</div>
			  <?php elseif($userRole === "owner"):?>
				<div class="sidebar-brand-icon">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Owner</div>
			  <?php elseif($userRole === "kasir"):?>
				<div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-cash-register"></i>
                </div>
                <div class="sidebar-brand-text mx-3">kasir</div>
			  <?php endif;?>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
 	<!-- Divider -->
    <hr class="sidebar-divider">

    <?php
    // Ambil peran pengguna dari database, misalnya $userRole merupakan peran pengguna yang didapat dari database
    // Ganti dengan nilai yang sesuai dari database

    if ($userRole === "owner") {
        ?>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('owner/');?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
		<!-- Divider -->
            <hr class="sidebar-divider my-0">
        <?php
    	} elseif ($userRole === "admin") {
        ?>
        <!-- Nav Item - Dashboard -->
        <li class="list-group nav-item">
            <a class="nav-link" href="<?= base_url('admin/');?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

		<!-- Divider -->
            <hr class="sidebar-divider my-0">

		<!-- Nav Item - Pengguna -->
		<li class="nav-item">
			<a class="nav-link" href="<?= base_url('user/');?>">
				<i class="fas fa-fw fa-users"></i>
				<span>Pengguna</span>
			</a>
		</li>

		<!-- Divider -->
            <hr class="sidebar-divider my-0">
        <!-- Nav Item - Outlet -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('outlet/');?>">
                <i class="fas fa-fw fa-store"></i>
                <span>Outlet</span>
            </a>
        </li>
		<!-- Divider -->
            <hr class="sidebar-divider my-0">

		<!-- Nav Item - Pelanggan -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('pelanggan/');?>">
                <i class="fas fa-fw fa-users"></i>
                <span>Pelanggan</span>
            </a>
        </li>
		<!-- Divider -->
            <hr class="sidebar-divider my-0">

		<!-- Nav Item - Transaksi -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/transaksi');?>">
                <i class="fas fa-fw fa-money-bill"></i>
                <span>Transaksi</span>
            </a>
        </li>
		<!-- Divider -->
            <hr class="sidebar-divider my-0">

        <!-- Nav Item - Laporan -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('paket/');?>">
                <i class="fas fa-fw fa-box"></i>
                <span>Paket</span>
            </a>
        </li>
		<!-- Divider -->
            <hr class="sidebar-divider my-0">


        <!-- Tambahkan item lainnya untuk admin seperti paket cucian, pelanggan, user, transaksi, dan laporan -->
        <!-- ... -->

        <?php
    	} elseif ($userRole === "kasir") {
        ?>

		<!-- Nav Item - Dashboard -->
        <li class="list-group nav-item">
            <a class="nav-link" href="<?= base_url('kasir/');?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
		<!-- Divider -->
        <hr class="sidebar-divider my-0">
        <!-- Nav Item - Pelanggan -->
        <li class="nav-item">
            <a class="nav-link" href="<?=base_url("kasir/pelanggan");?>">
                <i class="fas fa-fw fa-users"></i>
                <span>Pelanggan</span>
            </a>
        </li>
		<!-- Divider -->
        <hr class="sidebar-divider my-0">
        <!-- Nav Item - Transaksi -->
        <li class="nav-item">
            <a class="nav-link" href="<?=base_url('kasir/transaksi');?>">
                <i class="fas fa-fw fa-money-bill"></i>
                <span>Transaksi</span>
            </a>
        </li>
		<!-- Divider -->
            <hr class="sidebar-divider my-0">
        <!-- Nav Item - Laporan -->
        
		<!-- Divider -->
            <hr class="sidebar-divider my-0">
        <?php
    } elseif (empty($userRole)) {
		redirect('auth');
	}
    ?>

    <!-- ... (Bagian lain dari sidebar) ... -->

</ul>
<!-- End of Sidebar -->
