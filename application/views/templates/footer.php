            

            </div>
            <!-- End of Content Wrapper -->

            </div>
            <!-- End of Page Wrapper -->

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <!-- Logout Modal-->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap core JavaScript-->
            <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
            <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

            <script src="<?= base_url('assets/'); ?>js/datatables.min.js"></script>

            <script> 
                $('.custom-file-input').on('change', function() {
                    let fileName = $(this).val().split('\\').pop();
                    $(this).next('.custom-file-label').addClass("selected").html(fileName);
                });



                $('.form-check-input').on('click', function() {
                    const menuId = $(this).data('menu');
                    const roleId = $(this).data('role');

                    $.ajax({
                        url: "<?= base_url('admin/changeaccess'); ?>",
                        type: 'post',
                        data: {
                            menuId: menuId,
                            roleId: roleId
                        },
                        success: function() {
                            document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
                        }
                    });

                });

                $(document).ready(function () {
                    $('#table').DataTable();
                });

                function getdata(id, nama) {

                    $('#rak').html(id)

                    $.ajax({
                        type: 'post',
                        data: {
                        'no_rak': id,
                    },
                        url: "<?= base_url('user/getDataExp'); ?>",
                        dataType: 'json',
                        success: function(data) {

                            // console.log(nama)
                            let baris = '';
                            let now = new Date()
                            let dateNow = now.getDate() + '-' + now.getMonth() + '-' + now.getFullYear()
                            for (let i = 0; i < data.length; i++) {
                                let satuHari = 24*60*60*1000;

                                let xbulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

                                let tgl = new Date(data[i].tgl_expired)
                                let bulan = xbulan[tgl.getMonth()]
                                let formatTgl = tgl.getDate() + ' ' + bulan + ' ' + tgl.getFullYear()

                                let tgl_exp = new Date(data[i].tgl_expired)

                                let expired = Math.ceil((tgl_exp.getTime() - now.getTime()) / (satuHari))
                                let aksiExp = Math.ceil(Math.round((tgl_exp.getTime() - now.getTime()) / (satuHari)))
                                baris += `<tr>
                                            <td> </td> 
                                            <td> ${data[i].kode_barang}  </td> 
                                            <td> ${data[i].nama_barang}  </td> 
                                            <td> ${data[i].qty}  </td> 
                                            <td> ${formatTgl}  </td> 
                                            <td> 
                                            ${
                                                expired > -1 && expired < 1 ? `<span class='badge badge-warning'> Besok Akan Kadaluarsa </span>`
                                                : expired > 0 && expired < 8 ? `<span class='badge badge-warning'>
                                                Akan Kadaluarsa Dalam ${expired} Hari
                                                </span>`
                                                : expired < 0 ? `<span class='badge badge-danger'>
                                                Sudah Kadaluarsa
                                                </span>` 
                                                : expired > 7 ? `<span class='badge badge-success'>
                                                Expired Aman
                                                </span>`  
                                                : ' '
                                            }
                                            </td> 
                                            <td>
                                            ${ expired < 0 ? `
                                                <button onClick="retur(
                                                    '${data[i].id}',
                                                    '${data[i].nama_barang}',
                                                    '${data[i].kode_barang}',
                                                    '${data[i].qty}',
                                                    '${nama}'
                                                    )" class='badge badge-primary p-1'>
                                                Retur
                                                </button>
                                                ` : ''
                                            }
                                            </td> 
                                         </tr>`
                                
                            }
                            $('#target').html(baris)
                            }
                        });
                }

                function retur(id, nama_barang, kode_barang, qty, nama) {
                    console.log('namanya:',nama);
                    $.ajax({
                    type: 'post',
                    data: {
                        'id': id,
                        'nama_barang': nama_barang,
                        'kode_barang': kode_barang,
                        'qty': qty,
                        'nama_peretur': nama,
                    },
                    url: "<?= base_url('user/return'); ?>",
                    dataType: 'json',
                    success: function (data) {  
                        alert('Retur Berhasil')
                        window.location.reload()
                        // console.log(data)
                    }
                    })
                }
            </script>

            </body>

            </html> 