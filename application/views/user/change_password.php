    <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title;?></h1>

					
					<div class="row">
						<div class="col-lg-5">
							<form action="<?= base_url('user/changepassword');?>" method="post">

								<?= $this->session->flashdata('register');?>
								<?= $this->session->unset_userdata('register');?>
							<div class="form-group">
								<label for="current_password">Current Password</label>
								<div class="input-group">
									<?php if(form_error('current_password')):?>
										<input name="current_password" type="password" class="form-control is-invalid" id="current_password" placeholder="">
										<small class="text-danger"><?= form_error('current_password');?></small>
									<?php else:?>
										<input name="current_password" type="password" class="form-control" id="current_password" placeholder="">
									<?php endif;?>
									<div class="input-group-append">
										<span class="input-group-text toggle-password" data-target="current_password">
											<i class="fas fa-eye-slash" id="eyeIconCurrentPassword"></i>
										</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="new_password1">New Password</label>
								<div class="input-group">
									<?php if(form_error('new_password1')):?>
										<input name="new_password1" type="password" class="form-control is-invalid" id="new_password1" placeholder="">
										<small class="text-danger"><?= form_error('new_password1');?></small>
									<?php else:?>
										<input name="new_password1" type="password" class="form-control" id="new_password1" placeholder="">
									<?php endif;?>
									<div class="input-group-append">
										<span class="input-group-text toggle-password" data-target="new_password1">
											<i class="fas fa-eye-slash" id="eyeIconNewPassword1"></i>
										</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="new_password2">Repeat Password</label>
								<div class="input-group">
									<?php if(form_error('new_password2')):?>
										<input name="new_password2" type="password" class="form-control is-invalid" id="new_password2" placeholder="">
										<small class="text-danger"><?= form_error('new_password2');?></small>
									<?php else:?>
										<input name="new_password2" type="password" class="form-control" id="new_password2" placeholder="">
									<?php endif;?>
									<div class="input-group-append">
										<span class="input-group-text toggle-password" data-target="new_password2">
											<i class="fas fa-eye-slash" id="eyeIconNewPassword2"></i>
										</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<button class="btn btn-primary" type="submit">Save Changes</button>
							</div>

					</form>
					</div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            
