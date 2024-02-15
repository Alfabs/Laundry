<form action="<?= base_url('outlet/tambahOutlet');?>" method="post">
    <input type="hidden" name="id" value="">
    <div class="mx-auto row">
        <div class="col-lg-5 mt-7">
            <h3 style="margin-left: 15px;">Tambah Outlet</h3>
            <div class="modal-body">
                <div class="form-group">
                    <!-- Change input name to "role" -->
                    <label for="">Nama Outlet</label>
                    <input value="" type="text" class="form-control" id="nama" name="nama" >
                </div>
				<div class="form-group">
                    <!-- Change input name to "role" -->
                    <label for="">Alamat Outlet</label>
                    <input value="" type="text" class="form-control" id="alamat" name="alamat" >
                </div>
				<div class="form-group">
                    <!-- Change input name to "role" -->
                    <label for="">No Telepon</label>
                    <input value="" type="number" class="form-control" id="tlp" name="tlp" >
                </div>
            </div>
            <div class="modal-footer">
                <a href="<?= base_url('outlet/');?>" class="btn btn-danger mr-auto">Back</a>
                <button type="submit" class="btn btn-primary">Tambahkan</button>
            </div>
        </div>
    </div>
</form>
