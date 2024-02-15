<form action="<?= base_url('kasir/tambahTransaksi');?>" method="post">
    <input type="hidden" name="id" value="">
    <div class="mx-auto row">
        <div class="col-lg-5 mt-7">
            <h3 style="margin-left: 15px;">Tambah Transaksi</h3>
            <div class="modal-body">
                <div class="form-group">
					<label for="">Outlet</label>
					<select name="id_outlet" class="custom-select" id="inputGroupSelectOutlet" disabled>
						<?php foreach($outlets as $outlet):?>
							<option value="<?= $outlet['id'];?>" <?= ($id_outlet == $outlet['id']) ? 'selected' : '';?>><?= $outlet['nama'];?></option>
						<?php endforeach;?>
					</select>
				</div>
                <div class="form-group">
                    <label for="">Nama Member</label>
                    <select name="id_member" class="custom-select" id="inputGroupSelect02">
                        <?php foreach($members as $member):?>
                            <option value="<?= $member['id'];?>"><?= $member['nama'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Nama User</label>
                    <select name="id_user" class="custom-select" id="inputGroupSelect03">
                        <?php foreach($users as $user):?>
                            <option value="<?= $user['id'];?>"><?= $user['nama'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Tanggal</label>
                    <input type="datetime-local" class="form-control" id="tgl" name="tgl">
                </div>
                <div class="form-group">
                    <label for="">Batas Waktu</label>
                    <input type="datetime-local" class="form-control" id="batas_waktu" name="batas_waktu">
                </div>
				<div class="form-group">
					<label for="tgl_bayar">Tanggal Bayar</label>
					<input value="" type="datetime-local" class="form-control" id="tgl_bayar" name="tgl_bayar">
				</div>
                <div class="form-group">
                    <label for="">Status</label>
                    <select name="status" class="custom-select" id="inputGroupSelect04">
                        <?php foreach($statuses as $status):?>
                            <option value="<?= $status;?>"><?= $status;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Dibayar</label>
                    <select name="dibayar" class="custom-select" id="inputGroupSelect05">
                        <?php foreach($dibayar_options as $dibayar):?>
                            <option value="<?= $dibayar;?>"><?= $dibayar;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <a href="<?= base_url('kasir/transaksi');?>" class="btn btn-danger mr-auto">Back</a>
                <button type="submit" class="btn btn-primary">Tambahkan</button>
            </div>
        </div>
    </div>
</form>
