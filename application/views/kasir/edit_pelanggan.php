<form action="<?= base_url('kasir/editPelanggan/'.$idPelanggan['id']);?>" method="post">
    <input type="hidden" name="id" value="<?= $idPelanggan['id'];?>">
    <div class="mx-auto row">
        <div class="col-lg-5 mt-7">
            <h3 style="margin-left: 15px;">Edit User</h3>
			<?= $this->session->flashdata('register');?>
			<?= $this->session->unset_userdata('register');?>
            <div class="modal-body">
                <div class="form-group">
                    <!-- Change input name to "role" -->
                    <label for="">Nama </label>
                    <input value="<?= $idPelanggan['nama'];?>" type="text" class="form-control" id="nama" name="nama" >
                </div>
				<div class="form-group">
                    <!-- Change input name to "role" -->
                    <label for="">Alamat</label>
                    <input value="<?= $idPelanggan['alamat'];?>" type="text" class="form-control" id="alamat" name="alamat" >
                </div>
				<div class="form-group">
                    <!-- Change input name to "role" -->
                    <label for="">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="custom-select" id="inputGroupSelect01">
						<?php foreach($gender as $jenisK) :?>
							<?php if((isset($input_jk) && $input_jk == $jenisK) || $idPelanggan['jenis_kelamin'] == $jenisK) :?>
								<option selected value="<?= $jenisK;?>"><?= $jenisK;?></option>
							<?php else:?>
								<option value="<?= $jenisK;?>"><?= $jenisK;?></option>
							<?php endif;?>
						<?php endforeach; ?>
					</select>
                </div>
				<!-- ... kode sebelumnya ... -->
				<div class="form-group">
					<label for="">Outlet</label>
					<select name="id_outlet" class="custom-select" id="inputGroupSelectOutlet">
						<?php foreach($outlets as $outlet):?>
							<?php if($idPelanggan['id_outlet'] == $outlet['id']) : ?>
								<option selected value="<?= $outlet['id'];?>"><?= $outlet['nama'];?></option>
							<?php else : ?>
								<option value="<?= $outlet['id'];?>"><?= $outlet['nama'];?></option>
							<?php endif; ?>
						<?php endforeach;?>
					</select>
				</div>
				<div class="form-group">
                    <!-- Change input name to "role" -->
                    <label for="">No Telepon</label>
                    <input value="<?= $idPelanggan['tlp'];?>" type="number" class="form-control" id="idoutlet" name="tlp" >
                </div>
            </div>
            <div class="modal-footer">
                <a href="<?= base_url('pelanggan/');?>" class="btn btn-danger mr-auto">Back</a>
                <button type="submit" class="btn btn-primary">Ubah</button>
            </div>
        </div>
    </div>
</form>
