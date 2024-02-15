<form action="<?= base_url('paket/tambahPaket');?>" method="post">
    <input type="hidden" name="id" value="">
    <div class="mx-auto row">
        <div class="col-lg-5 mt-7">
            <h3 style="margin-left: 15px;">Tambah Paket</h3>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama Outlet</label>
                    <select class="form-control" name="id_outlet">
                        <?php foreach($outlets as $outlet): ?>
                            <option value="<?= $outlet['id']; ?>"><?= $outlet['nama']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
					<label for="">Jenis</label>
					<!-- Dropdown for jenis (gunakan enum value) -->
					<select class="form-control" name="jenis" id="jenis">
						<?php foreach($jenis as $jeniss): ?>
							<option value="<?= $jeniss; ?>"><?= $jeniss; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="kilo_paket">Kilo</label>
					<input value="" type="number" class="form-control" id="kilo_paket" name="kilo_paket" step="0.1">
				</div>
				<div class="form-group">
					<label for="nama_paket">Nama Paket</label>
					<input value="" type="text" class="form-control" id="nama_paket" name="nama_paket">
				</div>
				<div class="form-group">
					<label for="harga">Harga</label>
					<input value="" step="0.1" type="number" class="form-control" id="harga" name="harga" readonly>
					<!-- Tambahkan atribut readonly agar nilai tidak dapat diubah manual -->
				</div>
            </div>
            <div class="modal-footer">
                <a href="<?= base_url('paket/');?>" class="btn btn-danger mr-auto">Back</a>
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
        if (selectedJenis === 'selimut') {
            hargaPerKg = 9000; // Misalnya, harga untuk jenis selimut adalah Rp 9000 per kg
        } else if (selectedJenis === 'bed_cover') {
            hargaPerKg = 8500; // Misalnya, harga untuk jenis bed cover adalah Rp 8500 per kg
        } else if (selectedJenis === 'kiloan'){
			hargaPerKg = 9500;
		} else if (selectedJenis === 'kaos'){
			hargaPerKg = 7500;
		} else if (selectedJenis === 'lain'){
            hargaPerKg = 8000;
        }
        // Tambahkan perhitungan harga berdasarkan jenis lainnya

        // Hitung total harga berdasarkan harga per kilogram dan berat cucian
        const totalHarga = hargaPerKg * kilo;

        // Tampilkan total harga ke dalam input harga
        harga.value = totalHarga;
    }
</script>
