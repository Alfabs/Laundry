<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
					
                    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
					<a class="btn btn-primary mb-4" href="<?= base_url('admin/generatePDF/'.$detail_transaksi['id']); ?>" target="_blank">Generate PDF</a>


                    <!-- Detail Transaksi -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    Detail Transaksi
                                </div>
                                <div class="card-body">
                                    <p>ID Transaksi: <?= $detail_transaksi['id']; ?></p>
                                    <p>Tanggal: <?= $detail_transaksi['tgl']; ?></p>
                                    <p>Batas Waktu: <?= $detail_transaksi['batas_waktu']; ?></p>
                                    <p>Tanggal Bayar: <?= $detail_transaksi['tgl_bayar'] ?? 'Belum Ditentukan';?></p>
                                    <p>Status: <?= $detail_transaksi['status']; ?></p>
                                    <p>Dibayar: <?= $detail_transaksi['dibayar']; ?></p>
                                    <!-- Tampilkan informasi lainnya sesuai kebutuhan -->
                                    <!-- Misalnya: outlet, member, user -->
                                    <p>Outlet: <?= $detail_transaksi['nama_outlet']; ?></p>
                                    <p>Member: <?= $detail_transaksi['nama_member']; ?></p>
                                    <p>User: <?= $detail_transaksi['nama_user']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
					
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
