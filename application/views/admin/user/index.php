                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-3 text-gray-800"><?= $title;?></h1>
					<a href="<?= base_url('user/tambahUser');?>" class="mb-4 btn btn-primary">Tambah User</a>

					
						
					<div class="row">
						<div class="col-lg-8">
						
						<?= $this->session->flashdata('register');?>
						<?= $this->session->unset_userdata('register');?>
						
							<table class="table table-hover">
								<thead>
									<tr>
										<th scope="col">ID</th>
										<th scope="col">Nama</th>
										<th style="text-align: center;" scope="col">Username</th>
										<th>Role</th>
										<th>Outlet</th>
										<th style="text-align: center;">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;?>
									<?php foreach($users as $pengguna):?>
									<tr>
										<td scope="row"><?=$pengguna['id'];?></td>
										<td><?=$pengguna['nama'];?></td>
										<td><?=$pengguna['username'];?></td>
										<td><?=$pengguna['role'];?></td>
										<td><?= $pengguna['nama_outlet'] ?? 'Tidak ada outlet'; ?></td>
										<td class="text-center">
											<a class="badge badge-success" href="<?= base_url('');?>user/editUser/<?= $pengguna['id'];?>">Edit</a>
											<a onclick="return confirm('This Menu Data will be removed Permanently\nAre you sure?');" class="badge badge-danger" href="<?= base_url('');?>user/deleteUser/<?= $pengguna['id'];?>">Hapus</a>
										</td>
									</tr>
									<?php endforeach;?>
								</tbody>

								<!-- Tampilkan pagination -->


								
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
												<a class="page-link" href="<?= base_url('user?page=' . ($pagination['current_page'] - 1)); ?>">
													<span aria-hidden="true">&laquo;</span>
												</a>
											</li>
										<?php endif; ?>
										<?php for ($i = $start_page; $i <= $end_page; $i++): ?>
											<li class="page-item <?= ($i == $pagination['current_page']) ? 'active' : ''; ?>">
												<a class="page-link" href="<?= base_url('user?page=' . $i); ?>">
													<?= $i; ?>
												</a>
											</li>
										<?php endfor; ?>
										<?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
											<li class="page-item">
												<a class="page-link" href="<?= base_url('user?page=' . ($pagination['current_page'] + 1)); ?>">
													<span aria-hidden="true">&raquo;</span>
												</a>
											</li>
										<?php endif; ?>
									<?php endif; ?>
								</ul>
							</nav>

							<a href="<?= base_url('user/');?>" class="btn btn-danger">Back</a>		
						</div>
					</div>					



                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



            
