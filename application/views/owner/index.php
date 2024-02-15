<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Cucian Baru</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_status_baru;?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Selesai</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_status_selesai;?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sedang Proses
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$jumlah_status_proses;?></div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Requests</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$jumlah_status_diambil;?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   <!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800">Data Transaksi</h1>


    <div class="row">
        <div class="col-lg-12">

            <?= $this->session->flashdata('register'); ?>
            <?= $this->session->unset_userdata('register'); ?>

            <table class="align-center table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Outlet</th>
                        <th scope="col">Pelanggan</th>
                        <th scope="col">User</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Batas Waktu</th>
                        <th scope="col">Status</th>
                        <th scope="col">Dibayar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transaksi as $data) : ?>
                        <tr>
                            <td><?= $data['id']; ?></td>
                            <td><?= $data['nama_outlet']; ?></td>
                            <td><?= $data['nama_member']; ?></td>
                            <td><?= $data['nama_user']; ?></td>
                            <td><?= $data['tgl']; ?></td>
                            <td><?= $data['batas_waktu']; ?></td>
                            <td><?= $data['status']; ?></td>
                            <td><?= $data['dibayar']; ?></td>
                            <td class="text-center">
                                <a class="badge badge-primary" href="<?= base_url('owner/detailTransaksi/'.$data['id']); ?>">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
				<!-- Tampilkan pagination -->
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center mt-3">
						<?php if ($pagination_transaksi['total_pages'] > 1): ?>
							<?php if ($pagination_transaksi['current_page'] > 1): ?>
								<li class="page-item">
									<a class="page-link" href="<?= base_url('owner?page=' . ($pagination_transaksi['current_page'] - 1)); ?>">
										<span aria-hidden="true">&laquo;</span>
									</a>
								</li>
							<?php endif; ?>
							<?php for ($i = 1; $i <= $pagination_transaksi['total_pages']; $i++): ?>
								<li class="page-item <?= ($i == $pagination_transaksi['current_page']) ? 'active' : ''; ?>">
									<a class="page-link" href="<?= base_url('owner?page=' . $i); ?>">
										<?= $i; ?>
									</a>
								</li>
							<?php endfor; ?>
							<?php if ($pagination_transaksi['current_page'] < $pagination_transaksi['total_pages']): ?>
								<li class="page-item">
									<a class="page-link" href="<?= base_url('owner?page=' . ($pagination_transaksi['current_page'] + 1)); ?>">
										<span aria-hidden="true">&raquo;</span>
									</a>
								</li>
							<?php endif; ?>
						<?php endif; ?>
					</ul>
				</nav>


            
        </div>
    </div>



</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
