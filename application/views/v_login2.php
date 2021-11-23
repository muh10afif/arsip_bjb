<?php 
    $this->load->view('layout/head');
?>

    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Arsip BJB</h3></div>
                                    <div class="card-body">
                                        <form>
                                            <div class="form-group">
                                                <input class="form-control py-4" id="username" type="email" placeholder="Username" />
                                                <div class="invalid-feedback" id="invalid-username">
                                                  Kolom username harus di isi
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control py-4" id="password" type="password" placeholder="Password" />
                                                <div class="invalid-feedback" id="invalid-passoword">
                                                  Kolom passoword harus di isi
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="cek" type="checkbox" />
                                                    <label style="-webkit-user-select:none;-moz-user-select:-moz-none;
                                                    -ms-user-select:none;user-select:none" class="custom-control-label" for="cek">Ingat saya</label>
                                                    <button class="btn btn-primary float-right" id="masuk" type="button">MASUK</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

<?php $this->load->view('layout/bottom'); ?>

        <script src="<?= base_url('') ?>dist/js/form_val.js"></script>

        <script type="text/javascript" charset="utf-8" async defer>
            
            $(document).ready(function(){

                var username = $('#username');
                var password = $('#password');
                var tombol = $('#masuk');

                $(masuk).on('click', function(){
                
                    var remember = $("#cek").prop('checked');

                    if (username.val() == "") {
                        fieldReq('username');
                    }else if (password.val() == "") {
                        fieldReq('password');
                    }else{
                        console.log(username.val());
                        console.log(password.val());
                        console.log(remember);
                    }

                });


                onInput('username');
                onInput('password');

            });

        </script>

    </body>
</html>
