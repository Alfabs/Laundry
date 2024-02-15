<form action="<?= base_url('admin/editTransaksi/'.$transaksi['id']); ?>" method="post">
    <input type="hidden" name="id" value="<?= $transaksi['id']; ?>">
    <div class="mx-auto row">
        <div class="col-lg-5 mt-7">
            <h3 style="margin-left: 15px;">Edit Transaksi</h3>
            <div class="modal-body">
                <!-- Outlet -->
                <div class="form-group">
                    <label for="">Outlet</label>
                    <select name="id_outlet" class="custom-select" id="inputGroupSelect01" disabled>
                        <?php foreach ($optionsOutlet as $optionOutlet) : ?>
                            <?php if ((isset($input_outlet) && $input_outlet == $optionOutlet['id']) || $id_outlet['id'] == $optionOutlet['id']) : ?>
                                <option selected value="<?= $optionOutlet['id']; ?>"><?= $optionOutlet['nama']; ?></option>
                            <?php else : ?>
                                <option value="<?= $optionOutlet['id']; ?>"><?= $optionOutlet['nama']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Member -->
                <div class="form-group">
                    <label for="">Pelanggan</label>
                    <select name="id_member" class="custom-select" id="inputGroupSelect02">
                        <?php foreach ($optionsMember as $optionMember) : ?>
                            <?php if ((isset($input_member) && $input_member == $optionMember['id']) || $id_member['id'] == $optionMember['id']) : ?>
                                <option selected value="<?= $optionMember['id']; ?>"><?= $optionMember['nama']; ?></option>
                            <?php else : ?>
                                <option value="<?= $optionMember['id']; ?>"><?= $optionMember['nama']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- User -->
                <div class="form-group">
                    <label for="">User</label>
                    <select name="id_user" class="custom-select" id="inputGroupSelect03">
                        <?php foreach ($optionsUser as $optionUser) : ?>
                            <?php if ((isset($input_user) && $input_user == $optionUser['id']) || $id_user['id'] == $optionUser['id']) : ?>
                                <option selected value="<?= $optionUser['id']; ?>"><?= $optionUser['nama']; ?></option>
                            <?php else : ?>
                                <option value="<?= $optionUser['id']; ?>"><?= $optionUser['nama']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Tanggal -->
                <div class="form-group">
                    <label for="">Tanggal</label>
                    <input value="<?= $transaksi['tgl']; ?>" type="datetime-local" class="form-control" id="tgl" name="tgl">
                </div>
                <!-- Batas Waktu -->
                <div class="form-group">
                    <label for="">Batas Waktu</label>
                    <input value="<?= $transaksi['batas_waktu']; ?>" type="datetime-local" class="form-control" id="batas_waktu" name="batas_waktu">
                </div>
				<div class="form-group">
					<label for="tgl_bayar">Tanggal Bayar</label>
					<input value="<?= $transaksi['tgl_bayar']; ?>" type="datetime-local" class="form-control" id="tgl_bayar" name="tgl_bayar">
				</div>
                <!-- Status -->
                <div class="form-group">
                    <label for="">Status</label>
                    <select name="status" class="custom-select" id="inputGroupSelect04">
                        <?php foreach ($optionsStatus as $optionStatus) : ?>
                            <?php if ((isset($input_status) && $input_status == $optionStatus) || $status == $optionStatus) : ?>
                                <option selected value="<?= $optionStatus; ?>"><?= $optionStatus; ?></option>
                            <?php else : ?>
                                <option value="<?= $optionStatus; ?>"><?= $optionStatus; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Dibayar -->
                <div class="form-group">
                    <label for="">Dibayar</label>
                    <select name="dibayar" class="custom-select" id="inputGroupSelect05">
                        <?php foreach ($optionsDibayar as $optionDibayar) : ?>
                            <?php if ((isset($input_dibayar) && $input_dibayar == $optionDibayar) || $dibayar == $optionDibayar) : ?>
                                <option selected value="<?= $optionDibayar; ?>"><?= $optionDibayar; ?></option>
                            <?php else : ?>
                                <option value="<?= $optionDibayar; ?>"><?= $optionDibayar; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <a href="<?= base_url('kasir/transaksi'); ?>" class="btn btn-danger mr-auto">Back</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</form>
