
<div class="container-fluid mb-5">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-12">
            
        <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

        <?= $this->session->flashdata('message'); ?>


        <span class="d-flex"><p class="mr-2">Nomor Rak</p> <p id="rak"></p></span>
        <?php foreach ($rak as $r) : ?> 
            <button onClick="getdata(<?= $r?> , '<?= $user['name']?>')" class="btn btn-primary py-3 px-4 mb-4"><?= $r; ?></button>
        <?php endforeach; ?>
 

            <table id="table" class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode Barang</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">QTY</th>
                        <th scope="col">Tanggal Expired</th>
                        <th scope="col">Expired</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody id="target">
                    
                
                </tbody>
            </table>

        </div>
    </div>


<!-- /.container-fluid -->

</div>

<!-- Modal Tambah User-->
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Tambah Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('user/addProduct'); ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nama Barang</label>
                        <input type="text" name="nama" class="form-control" id="exampleFormControlInput1">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control" id="exampleFormControlInput1" 
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nomor Rak</label>
                        <input type="text" name="no_rak" class="form-control" id="exampleFormControlInput1" 
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Tanggal Produksi</label>
                        <input type="date" name="tgl_produksi" class="form-control" id="exampleFormControlInput1">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Tanggal Expired</label>
                        <input type="date" name="tgl_expired" class="form-control" id="exampleFormControlInput1">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div> 


<!-- Modal Edit -->

<?php foreach ($barang as $r) : ?>
<div class="modal fade" id="editRoleModal<?= $r['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editnewRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('user/editProduct/') . $r['id']; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" value="<?= $r['kode_barang'] ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" value="<?= $r['nama_barang'] ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" value="<?= $r['no_rak'] ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" value="<?= $r['tgl_produksi'] ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" value="<?= $r['tgl_expired'] ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div> 
<?php endforeach ?>
