 <form action="<?= base_url('menu/editSub/'.$id_sub_menu['id']);?>" method="post">
 <input type="hidden" name="id" value="<?= $id_sub_menu['id'];?>">
		<div class="mx-auto row">
		<div style="margin-left: 15px;" class="col-lg-5">	
			<h3 style="margin-left: 0px;">Edit SubMenu</h3>
      		
				<div class="form-group">
					<label for="">Sub Menu Name</label>
					<input value="<?=$id_sub_menu['title'];?>" type="text" class="form-control" id="menu" name="title" placeholder="Menu Name...">
				</div>

				<div class="form-group">
					<label for="">Menu Access</label>
					<select class="form-control" name="menu_id" id="menu_id">
						<option value="">Select Menu</option>
						<?php foreach($menu as $men):?>
							<?php if($men['id'] == $id_sub_menu['menu_id']):?>
								<option value="<?= $men['id'];?>" selected><?= $men['menu'];?></option>
								<?php else:?>
								<option value="<?= $men['id'];?>"><?= $men['menu'];?></option>
							<?php endif;?>
						<?php endforeach;?>
					</select>
				</div>

				<div class="form-group">
					<label for="">Url</label>
					<input value="<?= $id_sub_menu['url']; ?>" type="text" class="form-control" id="url" name="url" placeholder="URL...">
				</div>

				<div class="form-group">
					<label for="">Icon</label>
					<input value="<?= $id_sub_menu['icon']; ?>" type="text" class="form-control" id="icon" name="icon" placeholder="Icon...">
				</div>
  			   
				<div class="form-group">
					<div class="form-check">
						<label for="">Availability</label><br>
						<input checked class="form-check-input" type="checkbox" value="<?=$id_sub_menu['is_active'];?>" id="is_active" name="is_active">
						<label class="form-check-label" for="is_active">
							Active?
						</label>
					</div>
				</div>
				 
				 <div class="modal-footer">
					 <a href="<?= base_url('menu/submenu');?>" class="btn btn-danger mr-auto">Back</a>
					 <button type="submit" class="btn btn-primary ">Save Changes</button>
				</div>
		</div>
		</div>
</form>
