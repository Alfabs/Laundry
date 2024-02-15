<!-- editPaket Form -->
<form action="<?= base_url('paket/editPaket/'.$paket['id']); ?>" method="post">
    <input type="hidden" name="id" value="<?= $paket['id']; ?>">
    <div class="mx-auto row">
        <div class="col-lg-5 mt-7">
            <h3 style="margin-left: 15px;">Edit Paket</h3>
            <div class="modal-body">
                <!-- Outlet -->
                <div class="form-group">
                    <label for="">Nama Outlet</label>
                    <select class="form-control" name="id_outlet">
                        <?php foreach($outlets as $outlet): ?>
                            <option value="<?= $outlet['id']; ?>" <?= ($paket['id_outlet'] == $outlet['id']) ? 'selected' : ''; ?>>
                                <?= $outlet['nama']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Jenis -->
                <!-- Jenis -->
<div class="form-group">
    <label for="jenis">Jenis</label>
    <select class="form-control" id="jenis" name="jenis">
        <?php foreach($jenis as $jeniss): ?>
            <option value="<?= $jeniss; ?>" <?= ($paket['jenis'] == $jeniss) ? 'selected' : ''; ?>>
                <?= $jeniss; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<!-- Kilo -->
<div class="form-group">
    <label for="kilo_paket">Kilo</label>
    <input value="" type="number" class="form-control" id="kilo_paket" name="kilo_paket" step="0.1">
</div>

<!-- Nama Paket -->
<div class="form-group">
    <label for="nama_paket">Nama Paket</label>
    <input value="<?= $paket['nama_paket']; ?>" type="text" class="form-control" id="nama_paket" name="nama_paket">
</div>

<!-- Harga -->
<div class="form-group">
    <label for="harga">Harga</label>
    <input value="<?= $paket['harga']; ?>" type="number" class="form-control" id="harga" name="harga" readonly>
    <!-- Tambahkan atribut readonly agar nilai tidak dapat diubah manual -->
</div>

            </div>
            <div class="modal-footer">
                <a href="<?= base_url('paket/');?>" class="btn btn-danger mr-auto">Back</a>
                <button type="submit" class="btn btn-primary">Update</button>
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
        }
        // Tambahkan perhitungan harga berdasarkan jenis lainnya

        // Hitung total harga berdasarkan harga per kilogram dan berat cucian
        const totalHarga = hargaPerKg * kilo;

        // Tampilkan total harga ke dalam input harga
        harga.value = totalHarga;
    }
</script>
