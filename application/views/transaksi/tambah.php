<form action="<?= base_url('admin/tambahTransaksi');?>" method="post">
    <input type="hidden" name="id" value="">
    <div class="mx-auto row">
        <div class="col-lg-5 mt-7">
            <h3 style="margin-left: 15px;">Tambah Transaksi</h3>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama Outlet</label>
                    <select name="id_outlet" class="custom-select" id="inputGroupSelect01">
                        <?php foreach($outlets as $outlet):?>
                            <option value="<?= $outlet['id'];?>"><?= $outlet['nama'];?></option>
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
                <a href="<?= base_url('admin/');?>" class="btn btn-danger mr-auto">Back</a>
                <button type="submit" class="btn btn-primary">Tambahkan</button>
            </div>
        </div>
    </div>
</form>

<script>
    // Dapatkan elemen-elemen yang dibutuhkan
    const jenis = document.getElementById('jenis');
    const kiloPaket = document.getElementById('kilo_paket');
    const harga = document.getElementById('harga');

    // Logika untuk mengubah harga berdasarkan jenis dan berat cucian
    jenis.addEventListener('change', function() {
        hitungHarga();
    });

    kiloPaket.addEventListener('input', function() {
        hitungHarga();
    });

    // Fungsi untuk menghitung harga
    function hitungHarga() {
        const selectedJenis = jenis.value;
        const kilo = kiloPaket.value;
        let hargaPerKg = 0;

        // Tentukan harga per kilogram berdasarkan jenis cucian yang dipilih
        if (selectedJenis === 'Selimut') {
            hargaPerKg = 9000; // Misalnya, harga untuk jenis selimut adalah Rp 9000 per kg
        } else if (selectedJenis === 'Bed_Cover') {
            hargaPerKg = 8500; // Misalnya, harga untuk jenis bed cover adalah Rp 8500 per kg
        } else if (selectedJenis === 'Kiloan'){
            hargaPerKg = 9500;
        } else if (selectedJenis === 'Kaos'){
            hargaPerKg = 7500;
        } else if (selectedJenis === 'Lain'){
            hargaPerKg = 8000;
        }
        // Tambahkan perhitungan harga berdasarkan jenis lainnya

        // Hitung total harga berdasarkan harga per kilogram dan berat cucian
        const totalHarga = hargaPerKg * kilo;

        // Tampilkan total harga ke dalam input harga
        harga.value = totalHarga;
    }
</script>
