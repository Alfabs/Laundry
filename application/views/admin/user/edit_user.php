<form action="<?= base_url('user/editUser/'.$idUser['id']);?>" method="post">
    <input type="hidden" name="id" value="<?= $idUser['id'];?>">
    <div class="mx-auto row">
        <div class="col-lg-5 mt-7">
            <h3 style="margin-left: 15px;">Edit User</h3>
            <?= $this->session->flashdata('register');?>
            <?= $this->session->unset_userdata('register');?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama Lengkap</label>
                    <input value="<?= $idUser['nama'];?>" type="text" class="form-control" id="nama" name="nama" >
                </div>
                <div class="form-group">
                    <label for="">Username</label>
                    <input value="<?= $idUser['username'];?>" type="text" class="form-control" id="username" name="username" >
                </div>
				<div class="form-group">
					<label for="">Role</label>
					<select name="role" class="custom-select" id="inputGroupSelect02">
						<?php foreach($optionsRole as $optionRole) :?>
							<?php if((isset($input_role) && $input_role == $optionRole) || $idUser['role'] == $optionRole) :?>
								<option selected value="<?= $optionRole;?>"><?= $optionRole;?></option>
							<?php else:?>
								<option value="<?= $optionRole;?>"><?= $optionRole;?></option>
							<?php endif;?>
						<?php endforeach; ?>
					</select>
				</div>
                <div class="form-group">
    <label for="">Outlet</label>
    <select name="idoutlet" class="custom-select" id="inputGroupSelect01">
        <?php foreach ($outlets as $outlet) : ?>
            <?php if ($outlet['id'] == $idUser['id_outlet']) : ?>
                <option selected value="<?= $outlet['id']; ?>"><?= $outlet['nama']; ?></option>
            <?php else : ?>
                <option value="<?= $outlet['id']; ?>"><?= $outlet['nama']; ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</div>
            </div>
            <div class="modal-footer">
                <a href="<?= base_url('user/');?>" class="btn btn-danger mr-auto">Back</a>
                <button type="submit" class="btn btn-primary">Ubah</button>
            </div>
        </div>
    </div>
</form>

<script>
    // Perubahan pada JavaScript di dalam view (edit_user.php)
document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.querySelector('#inputGroupSelect02[name="role"]');
    const outletSelect = document.querySelector('#inputGroupSelect01[name="idoutlet"]');

    roleSelect.addEventListener('change', function () {
        if (this.value === 'owner') {
            outletSelect.disabled = true;
            outletSelect.innerHTML = '<option value="">-- Pilih Outlet --</option>';
        } else if (this.value === 'kasir') {
            outletSelect.disabled = false;
            // Isi dengan opsi outlet dari PHP
            <?php foreach ($outlets as $outlet): ?>
                outletSelect.innerHTML += `<option value="<?= $outlet['id']; ?>"><?= $outlet['nama']; ?></option>`;
            <?php endforeach; ?>
        } else if (this.value === 'admin') {
            // Jika role bukan 'owner' atau 'kasir'
            outletSelect.disabled = true;
            outletSelect.innerHTML = '<option value="">-- Pilih Outlet --</option>';
        }
    });

    // Tambahkan pengecekan pada saat halaman dimuat
    // Jika peran awalnya 'owner', maka outlet tidak ditampilkan
    if (roleSelect.value === 'owner') {
        outletSelect.disabled = true;
        outletSelect.innerHTML = ''; // Kosongkan opsi outlet
    }
});

</script>

