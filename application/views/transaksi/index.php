<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
	
    <h1 class="h3 mb-3 text-gray-800"><?= $title; ?></h1>
    <a href="<?= base_url('admin/tambahTransaksi'); ?>" class="mb-4 btn btn-primary">Tambah Transaksi</a>

	

    <div class="row">
        <div class="col-lg-12">
			





            <?= $this->session->flashdata('register'); ?>
            <?= $this->session->unset_userdata('register'); ?>

            <table class="align-center table table-hover mt-4">
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
                                <a class="badge badge-success" href="<?= base_url('admin/editTransaksi/'.$data['id']); ?>">Edit</a>
                                <a class="badge badge-primary" href="<?= base_url('admin/detailTransaksi/'.$data['id']); ?>">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
				<!-- Tampilkan pagination -->
							<nav aria-label="Page navigation example">
								<ul class="pagination justify-content-center mt-3">
									<?php if ($pagination['total_pages'] > 1): ?>
										<?php 
											$start_page = max($pagination['current_page'] - 2, 1);
											$end_page = min($start_page + 4, $pagination['total_pages']);
											if ($end_page - $start_page < 4) {
												$start_page = max($end_page - 4, 1);
											}
										?>
										<?php if ($pagination['current_page'] > 1): ?>
											<li class="page-item">
												<a class="page-link" href="<?= base_url('admin/transaksi?page=' . ($pagination['current_page'] - 1)); ?>">
													<span aria-hidden="true">&laquo;</span>
												</a>
											</li>
										<?php endif; ?>
										<?php for ($i = $start_page; $i <= $end_page; $i++): ?>
											<li class="page-item <?= ($i == $pagination['current_page']) ? 'active' : ''; ?>">
												<a class="page-link" href="<?= base_url('admin/transaksi?page=' . $i); ?>">
													<?= $i; ?>
												</a>
											</li>
										<?php endfor; ?>
										<?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
											<li class="page-item">
												<a class="page-link" href="<?= base_url('admin/transaksi?page=' . ($pagination['current_page'] + 1)); ?>">
													<span aria-hidden="true">&raquo;</span>
												</a>
											</li>
										<?php endif; ?>
									<?php endif; ?>
								</ul>
							</nav>


            <a href="<?= base_url('kasir/'); ?>" class="btn btn-danger">Back</a>
        </div>
    </div>



</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<script>
	$(document).ready(function() {
    $('#filterOutlet').change(function() {
        var outletId = $(this).val();

        $.ajax({
            url: 'localhost/laundry/admin/filterTransaksi', // Ganti URL_anda dengan URL yang sesuai
            type: 'POST',
            data: {
                outlet_id: outletId
            },
            success: function(response) {
                // Lakukan sesuatu dengan respons dari AJAX, seperti mengganti isi tabel transaksi
                $('#tabelTransaksi').html(response); // Ganti #tabelTransaksi dengan ID dari tabel transaksi
            },
            error: function(xhr, status, error) {
                // Tangani kesalahan jika ada
                console.error(xhr.responseText);
            }
        });
    });
});

</script>
