<?php 
    $this->load->view('layout/head');
?>

    <body style="
      background-image: url('<?= base_url()?>dist/assets/img/bgLogin.jpg');
      background-repeat: no-repeat;
      background-size: cover;
    ">
      <div class="container ">
          <div class="row justify-content-center">
              <div class="col-lg-5 mt-lg-5">
                  <div class="card border-0 rounded-lg mt-lg-5" style="background-color: rgba(0,0,0,0);">
                      <div class="card-header text-center" style="background-color: rgba(0,0,0,0);">
                          <img src="<?= base_url('')?>dist/assets/img/logo.svg" alt="">
                          <h3 class="text-center font-weight my-4">Arsip BJB</h3>
                          <?php 
                            //if(isset($error)) { echo $error; }; 
                            

                            if($this->session->flashdata('success')){
                              echo '<div class="alert alert-success">';
                              echo $this->session->flashdata('success');
                              echo '</div>';
                            }

                            if($this->session->flashdata('warning')){
                              echo '<div class="alert alert-warning">';
                              echo $this->session->flashdata('warning');
                              echo '</div>';
                            }

                          ?>
                      </div>
                      <div class="card-body">
                          <form id="form_login" method="POST">
                              <div class="form-group">
                                  <input class="form-control form-control-sm py-4" id="username" type="text" placeholder="Username" autofocus  tabindex="1" />
                                  <div class="invalid-feedback" id="invalid-username">
                                    Kolom username harus di isi
                                  </div>
                              </div>
                              <div class="form-group">
                                  <input class="form-control form-control-sm py-4" id="password" type="password" placeholder="Password" tabindex="2" />
                                  <div class="invalid-feedback" id="invalid-passoword">
                                    Kolom passoword harus di isi
                                  </div>
                              </div>
                              
                              <div class="form-group text-center">
                                  <button  tabindex="3" class="btn btn-success" id="masuk" type="submit">MASUK</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>

<?php $this->load->view('layout/bottom'); ?>

        <!-- <script src="<?= base_url('') ?>dist/js/form_val.js"></script> -->

        <script type="text/javascript" charset="utf-8" async defer>
            
            $(document).ready(function(){

                // var username = $('#username');
                // var password = $('#password');
                // var tombol = $('#masuk');

                $('#form_login').on('submit', function(){

                    var username = $('#username');
                    var password = $('#password');
                
                    var remember = $("#cek").prop('checked');

                    if (username.val() == "") {
                        // fieldReq('username');
                        // $('#username).addClass("is-invalid");
                        // $('#username).focus();

                        swal({
                            title               : "Isi Dahulu Username",
                            type                : "warning",
                            showConfirmButton   : false,
                            timer               : 1000
                        });
                        
                        setTimeout(() => {
                                $('#username').addClass('is-invalid');
                                $('#username').focus();
                            }, 1300);

                        return false;

                       
                    }else if (password.val() == "") {

                        swal({
                            title               : "Isi Dahulu Password",
                            type                : "warning",
                            showConfirmButton   : false,
                            timer               : 1000
                        });
                        
                        setTimeout(() => {
                                $('#password').addClass('is-invalid');
                                $('#password').focus();
                            }, 1300);

                        return false;

                    }else{
                            $.ajax({
                                type        : 'POST',
                                url         : 'login/cek',
                                beforeSend  : function () {
                                    swal({
                                        title   : 'Menunggu',
                                        html    : 'Memproses Data',
                                        onOpen  : () => {
                                            swal.showLoading();
                                        }
                                    })
                                },
                                dataType    : 'json',
                                data        : {
                                    username : username.val(),
                                    password : password.val()
                                },
                                success: function(data){
                                    if(data.hasil == 'username tidak ditemukan'){
                                        swal({
                                          title: "Username tidak ditemukan",
                                          type: "error",
                                          showConfirmButton: false,
                                          timer: 1000
                                        });

                                        $('#username').val('');
                                        $('#password').val('');

                                        setTimeout(() => {
                                            $('#username').focus();
                                        }, 1300);

                                    }else if(data.hasil == 'password salah'){

                                        $('#password').val('');

                                        swal({
                                          title: "Password Salah",
                                          type: "error",
                                          showConfirmButton: false,
                                          timer: 1000
                                        });

                                        setTimeout(() => {
                                            $('#password').focus();
                                        }, 1300);
                                        

                                    }else{ 
                                        // swal({
                                        //   title: "Login Berhasil!",
                                        //   type: "success",
                                        //   showConfirmButton: false,
                                        //   timer: 1000
                                        // }, function(){
                                        //   $.ajax({
                                        //     type        : 'POST',
                                        //     url         : 'login/sign_in',
                                        //     dataType    : 'json',
                                        //     data        : {
                                        //     id_data_user : data.id_data_user,
                                        //     username : data.username,
                                        //     id_data_pegawai : data.id_data_pegawai,
                                        //     add_time : data.add_time
                                        //     }
                                        //   });
                                        //   window.location = 'dashboard';
                                        // });

                                        window.location = 'dashboard';
                                      }
                                }
                            });


                            return false;
                    }

                });


                onInput('username');
                onInput('password');

            });

        </script>

    </body>
</html>
