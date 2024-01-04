<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-10">
            
        <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

        <?= $this->session->flashdata('message'); ?>

        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal">Tambah User</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Nik</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($userr as $r) : ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $r['name']; ?></td>
                        <td><?= $r['nik']; ?></td>
                        <td>
                            <?php
                            if($r['role_id'] == 2){
                                echo 'Kepala Toko';    
                            }if($r['role_id'] == 1){
                               echo 'Administrator';
                            }if($r['role_id'] == 3){
                                echo 'Krew Store';
                            }
                        ?>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/roleaccess/') . $r['role_id']; ?>" class="badge badge-warning">access</a>
                            <a href="" class="badge badge-success" data-toggle="modal" data-target="#editRoleModal<?= $r['id'] ?>">edit</a>
                            <a href="<?= base_url('admin/deleteUser/') . $r['id']; ?>" class="badge badge-danger" onclick="return confirm('yakin dihapus?')">delete</a>
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
                <h5 class="modal-title" id="newRoleModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/addUser'); ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nama Karyawan</label>
                        <input type="text" name="nama" class="form-control" id="exampleFormControlInput1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="exampleFormControlInput1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nik</label>
                        <input type="nik" name="nik" class="form-control" id="exampleFormControlInput1">
                    </div>

                    <div class="mb-3">
                        <label for="role_id" class="form-label">Posisi</label>
                        <select name="role_id" id="role_id" class="form-control">
                            <option value=""> </option>
                            <option value="2">Kepala Toko</option>
                            <option value="3">Krew Store</option>
                        </select>
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

<?php foreach ($userr as $r) : ?>
<div class="modal fade" id="editRoleModal<?= $r['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editnewRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/editUser/') . $r['id']; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" value="<?= $r['name'] ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nik" name="nik" value="<?= $r['nik'] ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" name="email" value="<?= $r['email'] ?>">
                    </div>
                    <div class="form-group">
                    <select class="form-control" name="role_id" aria-label="Default select example">
                        <option value="<?= $r['role_id'] ?>"><?php
                            if($r['role_id'] == 2){
                                echo 'Kepala Toko';    
                            }if($r['role_id'] == 1){
                               echo 'Administrator';
                            }if($r['role_id'] == 3){
                                echo 'Krew Store';
                            }
                            ?>
                            </option>
                        <option value="2">Kepala Toko</option>
                        <option value="3">Krew</option>
                    </select>
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