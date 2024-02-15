<form action="<?= base_url('kasir/tambahPelanggan');?>" method="post">
    <input type="hidden" name="id" value="">
    <div class="mx-auto row">
        <div class="col-lg-5 mt-7">
            <h3 style="margin-left: 15px;">Tambah Pelanggan</h3>
            <div class="modal-body">
                <div class="form-group">
                    <!-- Change input name to "role" -->
                    <label for="">Nama</label>
                    <input value="" type="text" class="form-control" id="nama" name="nama" >
                </div>
				<div class="form-group">
                    <!-- Change input name to "role" -->
                    <label for="">Alamat</label>
                    <input value="" type="text" class="form-control" id="alamat" name="alamat" >
                </div>
				<div class="form-group">
                    <!-- Change input name to "role" -->
                    <label for="">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="custom-select" id="inputGroupSelect01">
					  <?php foreach($jk as $gender):?>
						<option value="<?=$gender;?>"><?= $gender;?></option>
					  <?php endforeach;?>
					</select>
                </div>
				<!-- Bagian terakhir form tambah pelanggan -->
				<div class="form-group">
					<label for="">Outlet</label>
					<select name="id_outlet" class="custom-select" id="inputGroupSelectOutlet" disabled>
						<?php foreach($outlets as $outlet):?>
							<option value="<?= $outlet['id'];?>" <?= ($id_outlet == $outlet['id']) ? 'selected' : '';?>><?= $outlet['nama'];?></option>
						<?php endforeach;?>
					</select>
				</div>

				<div class="form-group">
                    <!-- Change input name to "role" -->
                    <label for="">No Telepon</label>
                    <input value="" type="number" class="form-control" id="tlp" name="tlp" >
                </div>
            </div>
            <div class="modal-footer">
                <a href="<?= base_url('kasir/pelanggan/');?>" class="btn btn-danger mr-auto">Back</a>
                <button type="submit" class="btn btn-primary">Tambahkan</button>
            </div>
        </div>
    </div>
</form>
