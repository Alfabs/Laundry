<form action="<?= base_url('user/tambahUser');?>" method="post">
    <input type="hidden" name="id" value="">
    <div class="mx-auto row">
        <div class="col-lg-5 mt-7">
            <h3 style="margin-left: 15px;">Tambah User</h3>
            <div class="modal-body">
                <div class="form-group">
                    <!-- Change input name to "role" -->
                    <label for="">Nama Lengkap</label>
                    <input value="" type="text" class="form-control" id="nama" name="nama" >
                </div>
				<div class="form-group">
                    <!-- Change input name to "x" -->
                    <label for="">Username</label>
					<?php if(form_error('username')):?>
						<input value="" type="text" class="form-control" id="username" name="username" >
						<small class="form-text text-danger" role="alert"><?= form_error('username');?></small>
					<?php else:?>
						<input value="" type="text" class="form-control" id="username" name="username" >
					<?php endif;?>
                </div>
				<div class="form-group">
                    <!-- Change input name to "role" -->
                    <label for="">Password</label>
					<?php if(form_error('password1')):?>
						<input value="" type="password" class="form-control" id="password1" name="password1" >
						<small class="form-text text-danger" role="alert"><?= form_error('password1');?></small>
					<?php else:?>
						<input value="" type="password" class="form-control" id="password1" name="password1" >
					<?php endif;?>
                </div>
				<div class="form-group">
                    <!-- Change input name to "role" -->
                    <label for="">Confirm Password</label>
                    <input value="" type="password" class="form-control" id="password2" name="password2" >
                </div>
				<div class="form-group">
					<!-- Change input name to "role" -->
					<label for="">Role</label>
					<select name="role" class="custom-select" id="inputGroupSelect01">
					  <?php foreach($optionsRole as $option):?>
						<option value="<?=$option;?>"><?= $option;?></option>
					  <?php endforeach;?>
					</select>
				</div>
				<div class="form-group">
					<label for="">Outlet</label>
					<select name="idoutlet" class="custom-select" id="inputGroupSelect02">
						<!-- Output opsi outlet disini -->
						<?php foreach ($outlets as $outlet): ?>
							<option value="<?= $outlet['id']; ?>"><?= $outlet['nama']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
            </div>
            <div class="modal-footer">
                <a href="<?= base_url('user/');?>" class="btn btn-danger mr-auto">Back</a>
                <button type="submit" class="btn btn-primary">Tambahkan</button>
            </div>
        </div>
    </div>
</form>

<!-- Tambahkan script JavaScript di halaman -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.querySelector('#inputGroupSelect01[name="role"]');
        const outletSelect = document.querySelector('#inputGroupSelect02[name="idoutlet"]');

        roleSelect.addEventListener('change', function () {
            if (this.value === 'admin' || this.value === 'owner') {
                outletSelect.disabled = true;
                outletSelect.innerHTML = '<option value="">-- Pilih Outlet --</option>';
            } else {
                outletSelect.disabled = false;
                // Isi dengan opsi outlet dari PHP
                <?php foreach ($outlets as $outlet): ?>
                    outletSelect.innerHTML += `<option value="<?= $outlet['id']; ?>"><?= $outlet['nama']; ?></option>`;
                <?php endforeach; ?>
            }
        });

        // Tambahkan pengecekan pada saat halaman dimuat
        // Jika peran awalnya 'admin' atau 'owner', maka outlet dipilih dan dinonaktifkan
        if (roleSelect.value === 'admin' || roleSelect.value === 'owner') {
            outletSelect.disabled = true;
            outletSelect.innerHTML = '<option value="">-- Pilih Outlet --</option>';
        }
    });
</script>


