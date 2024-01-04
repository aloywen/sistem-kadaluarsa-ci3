<div class="container">

    <!-- Outer Row -->
    <div class="row align-items-center justify-content-center">

        <div class="col-lg-7">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">


                                <?php 
                                $kumpulanJarakWaktu = [];
                                $yangExpired = [];

                                    foreach($barang as $d){
                                        $tglHariini = date_create();
                                        $tglExpired = date_create($d['tgl_expired']);
                                        $jarakExpired = date_diff($tglHariini, $tglExpired)->format("%R%a");

                                        // memasukan data jarak expired ke varibel $kumpulanJarakWaktu
                                        $insert = array_push($kumpulanJarakWaktu, $jarakExpired);
                                        
                                    }
                                    
                                    foreach ($kumpulanJarakWaktu as $key => $value) {
                                        if($value < 0){
                                            // memasukan data yang expired ke variabel $yangExpired
                                            $insert = array_push($yangExpired, $value);
                                        }
                                    }
                                    
                                    // Menghitung total data yang expired
                                    $totalYgExpired = count($yangExpired);

                                    if( $totalYgExpired > 0 ){
                                            echo "<div class='alert alert-danger' role='alert'>
                                            <i class='fas fa-bell mr-2'></i>Ada barang yang sudah kadaluarsa!
                                            </div>";
                                        }
                            
                                ?>
                                

                                <div class="">
                                    <div class="row d-flex justify-content-center align-items-center flex-column">
                                        <div class="col-6">
                                            <div class="sidebar-brand-icon">
                                            <img src="<?= base_url('assets/img/alfa.png'); ?>" class="card-img">
                                            </div><br/>
                                        </div>
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                    </div>
                                </div>

                                <?= $this->session->flashdata('message'); ?>

                                <form class="user" method="post" action="<?= base_url('auth'); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Masukan Email Anda ..." value="<?= set_value('email'); ?>">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <button type="submit" class="btn btn-danger btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div> 