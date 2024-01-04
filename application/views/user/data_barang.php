<div class="container-fluid mb-5">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-12">
            
        <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

        <?= $this->session->flashdata('message'); ?>

        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal">Tambah Barang</a>

            <table id="table" class="table table-hover table-responsive">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode Barang</th>
                        <th scope="col">Nomor Rak</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Tanggal Produksi</th>
                        <th scope="col">Tanggal Expired</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($barang as $r) : ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $r['kode_barang']; ?></td>
                        <td><?= $r['no_rak']; ?></td>
                        <td><?= $r['nama_barang']; ?></td>
                        <td><?= $r['qty']; ?></td>
                        <td><?= date('d F Y', strtotime($r['tgl_produksi'])); ?></td>
                        <td><?= date('d F Y', strtotime($r['tgl_expired'])); ?></td>
                        <td>
                            <a href="" class="badge badge-success" data-toggle="modal" data-target="#editRoleModal<?= $r['id'] ?>">Edit</a>
                            <?php
                            $url = base_url('user/deleteProduct/').$r['id'];
                            if($user['role_id'] == 2){
                                echo "<a href='$url' class='badge badge-danger' onclick='return confirm('yakin dihapus?')'>Hapus</a>";
                            }
                            
                            ?>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
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
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <!-- <select onClick="getBarang(<?= $m['kode_barang']; ?>)" name="kode_barang" id="kode_barang" class="form-control">
                            <option value="">Kode Barang</option>
                            <?php foreach ($kode as $m) : ?>
                            <option onClick="getBarang(<?= $m['kode_barang']; ?>)" value="<?= $m['kode_barang']; ?>"><?= $m['kode_barang']; ?></option>
                            <?php endforeach; ?>
                        </select> -->
                        <input type="text" name="kode_barang" class="form-control" id="kode_barang" value="">
                    </div>

                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" id="nama_barang" value="">
                    </div>


                    <div class="mb-3">
                        <label for="no_rak" class="form-label">Nomor Rak</label>
                        <select name="no_rak" id="no_rak" class="form-control">
                            <option value="">Nomor Rak</option>
                            <?php foreach ($rak as $m) : ?>
                            <option value="<?= $m; ?>"><?= $m; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">QTY</label>
                        <input type="number" name="qty" class="form-control" id="exampleFormControlInput1">
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
                <h5 class="modal-title" id="editRoleModalLabel">Edit Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
           </div>
            <form action="<?= base_url('user/editProduct/') . $r['id']; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="<?= $r['kode_barang'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= $r['nama_barang'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="no_rak" class="form-label">No Rak</label>
                        <input type="text" class="form-control" id="no_rak" name="no_rak" value="<?= $r['no_rak'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="tgl_produksi" class="form-label">Tanggal Produksi</label>
                        <input type="date" class="form-control" id="tgl_produksi" name="tgl_produksi" value="<?= $r['tgl_produksi'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="tgl_expired" class="form-label">Tanggal Expired</label>
                        <input type="date" class="form-control" id="tgl_expired" name="tgl_expired" value="<?= $r['tgl_expired'] ?>">
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