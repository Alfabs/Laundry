                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-3 text-gray-800"><?= $title;?></h1>
					<a href="<?= base_url('outlet/tambahoutlet');?>" class="mb-4 btn btn-primary">Tambah Outlet</a>

					
						
					<div class="row">
						<div class="col-lg-7">
						
						<?= $this->session->flashdata('register');?>
						<?= $this->session->unset_userdata('register');?>
						
							<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">ID</th>
									<th scope="col">Nama</th>
									<th style="text-align: center;" scope="col">Alamat</th>
									<th>Tlp</th>
									<th style="text-align: center;">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1;?>
								<?php foreach($outlet as $cabang):?>
								<tr>
									<td scope="row"><?=$cabang['id'];?></td>
									<td><?=$cabang['nama'];?></td>
									<td><?=$cabang['alamat'];?></td>
									<td><?=$cabang['tlp'];?></td>
									<td style="text-align: center;">
										<a class="badge badge-success" href="<?= base_url('');?>outlet/EditOutlet/<?= $cabang['id'];?>">Edit</a>
										<a onclick="return confirm('This Menu Data will be removed Permanently\nAre you sure?');" class="badge badge-danger" href="<?= base_url('');?>outlet/deleteOutlet/<?= $cabang['id'];?>">Hapus</a>
									</td>
								</tr>
								<?php endforeach;?>
								
							</tbody>
							</table>
							<!-- Tampilkan pagination -->
							<nav aria-label="Page navigation example">
								<ul class="pagination justify-content-center mt-3">
									<?php if ($pagination['total_pages'] > 1): ?>
										<?php if ($pagination['current_page'] > 1): ?>
											<li class="page-item">
												<a class="page-link" href="<?= base_url('outlet?page=' . ($pagination['current_page'] - 1)); ?>">
													<span aria-hidden="true">&laquo;</span>
												</a>
											</li>
										<?php endif; ?>
										<?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
											<li class="page-item <?= ($i == $pagination['current_page']) ? 'active' : ''; ?>">
												<a class="page-link" href="<?= base_url('outlet?page=' . $i); ?>">
													<?= $i; ?>
												</a>
											</li>
										<?php endfor; ?>
										<?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
											<li class="page-item">
												<a class="page-link" href="<?= base_url('outlet?page=' . ($pagination['current_page'] + 1)); ?>">
													<span aria-hidden="true">&raquo;</span>
												</a>
											</li>
										<?php endif; ?>
									<?php endif; ?>
								</ul>
							</nav>
							<a href="<?= base_url('outlet/');?>" class="btn btn-danger">Back</a>		
						</div>
					</div>					



                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            
