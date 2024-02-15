                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
					<div class="row">
						<div class="col-lg-6">
							<?= $this->session->flashdata('register');?>
							<?= $this->session->unset_userdata('register');?>
						</div>
					</div>
                    <h1 style="margin-left: 10px;" class="h3 mb-4 text-gray-800"><?= $title;?></h1>

						<div class="row">
							<div class="col-lg-6">
								<?= form_open_multipart('user/edit');?>

								<div class="form-group">
									<label for="email" class="col-sm-2 col-form-label">Email</label>
									<div class="col-sm-10">
										<input type="text" value="<?= $user['email'];?>" readonly class="form-control" id="email" name="email" placeholder="">
									</div>
								</div>

								<div class="form-group">
									<label style="margin-left: 10px;" for="name" class="col-form-label">Full Name</label>
									<div class="col-sm-10">
										<?php if(form_error('name')):?>
											<input type="text" value="<?= $user['name'];?>" class="form-control is-invalid" id="name" name="name" placeholder="">
											<small class="text-danger mt-1"><?= form_error('name');?></small>
										<?php else:?>
											<input type="text" value="<?= $user['name'];?>" class="form-control" id="name" name="name" placeholder="">
										<?php endif;?>
									</div>
								</div>

								<div class="form-group">
									
									<div class="col-sm-10">
										<div class="row">
											<div class="col-sm-3">
												<img class="img-thumbnail" src="<?= base_url('assets/img/profile/'). $user['img'];?>">
											</div>
											<div class="col-sm-9">
												<h5>Picture</h5>
												<div class="custom-file">
													<input type="file" class="ml-auto custom-file-input" id="img" name="img">
													<label class="custom-file-label" for="img">Choose file</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group mt-6">
									<button type="submit" class="btn btn-primary">Save Changes</button>
								</div>
								</form>
							</div>
						</div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            
