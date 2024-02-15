

    <div class="container mt-5">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-7">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            
                            <div style="margin: 0 auto;" class="col-lg-9">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login Page</h1>
                                    </div>
									<?= $this->session->flashdata('register');?>
									<?= $this->session->unset_userdata('register'); ?>
                                    <form class="user" action="<?= base_url('auth');?>" method="post">
                                        <div class="form-group">
                                            <input value="<?= set_value('username');?>" type="text" class="form-control form-control-user"
                                                id="username" name="username" aria-describedby="usernameHelp"
                                                placeholder="Enter username ...">
											<?= form_error('username', '<small class="text text-danger pl-3">', '</small>');?>	
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="password" name="password" placeholder="Password">
											<?= form_error('password', '<small class="text text-danger pl-3">', '</small>');?>
                                        </div>
                                      
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
	
                                    </form>
                                    <hr>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

