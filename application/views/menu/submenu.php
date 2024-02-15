

        

   
  

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title;?></h1>
					
						
					<div class="row">
						<div class="col-lg">
						<?php if(validation_errors()):?>
						  	
							<?= form_error('title', '<div style="" class="mt-auto alert alert-danger col-lg-8 " role="alert">', '</div>');?>
							<?= form_error('menu', '<div style="" class="mt-auto alert alert-danger col-lg-8 " role="alert">', '</div>');?>
							<?= form_error('url', '<div style="" class="mt-auto alert alert-danger col-lg-8 " role="alert">', '</div>');?>
							<?= form_error('icon', '<div style="" class="mt-auto alert alert-danger col-lg-8 " role="alert">', '</div>');?>
						  	
						<?php endif;?>	
						<?= $this->session->flashdata('register');?>
						<?= $this->session->unset_userdata('register');?>
						<a class="btn btn-primary mb-3"  href="" data-toggle="modal" data-target="#newSubMenuModal">Add New SubMenu</a>
							<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">ID</th>
									<th scope="col">SubMenu</th>
									<th scope="col">Menu</th> 
									<th scope="col">Url</th> 
									<th scope="col">Icon</th> 
									<th scope="col">Active</th> 
									<th scope="col">Options</th> 
									
								</tr>
							</thead>
							<tbody>
								<?php $i = 1;?>
								<?php foreach($submenu as $sub):?>
								<tr>
									<th scope="row"><?= $i++;?></th>
									<td><?= $sub['title'];?></td>
									<td><?= $sub['menu'];?></td>
									<td><?= $sub['url'];?></td>
									<td><?= $sub['icon'];?></td>
									<td><?= $sub['is_active'];?></td>
									
									<td>
										<a class="badge badge-success" href="<?= base_url('menu/editSub/').$sub['id'];?>">Edit</a>
										<a onclick="return confirm('This Menu Data will be removed Permanently\nAre you sure?');" class="badge badge-danger" href="<?= base_url('');?>menu/deleteSub/<?= $sub['id'];?>">Delete</a>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
							</table>

						</div>
					</div>					



                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            
<!-- Modal -->




<!-- Modal -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newSubMenuModalLabel">Add New Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('menu/submenu');?>" method="post">
      		<div class="modal-body">

				<div class="form-group">
					<input type="text" class="form-control" id="title" name="title" placeholder="SubMenu Title">
				</div>
				<div class="form-group">
					<select class="form-control" name="menu_id" id="menu_id">
						<option value="">Select Menu</option>
						<?php foreach($menu as $men):?>
							<option value="<?= $men['id'];?>"><?= $men['menu'];?></option>
						<?php endforeach;?>
					</select>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="url" name="url" placeholder="SubMenu Url">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="icon" name="icon" placeholder="SubMenu Icon">
				</div>
				<div class="form-group">
					<div class="form-check">
						<input checked class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active">
						<label class="form-check-label" for="is_active">
							Active?
						</label>
					</div>
				</div>

			
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Add</button>
			</div>
	</form>
    </div>
  </div>
</div>
