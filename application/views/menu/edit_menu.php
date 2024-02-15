 <form action="<?= base_url('menu/edit/'.$idMenu['id']);?>" method="post">
 <input type="hidden" name="id" value="<?= $idMenu['id'];?>">
		<div class="mx-auto row">
		<div class="col-lg-5 mt-7">	
			<h3 style="margin-left: 15px;">Edit Menu</h3>
      		<div class="modal-body">
				<div class="form-group">
					<label for="">Menu Name</label>
					<input value="<?=$idMenu['menu'];?>" type="text" class="form-control" id="menu" name="menu" placeholder="Menu Name...">
				</div>
  			   </div>
				 
				 <div class="modal-footer">
					 <a href="<?= base_url('menu');?>" class="btn btn-danger mr-auto">Back</a>
					 <button type="submit" class="btn btn-primary ">Save Changes</button>
				</div>
		</div>
		</div>
</form>
