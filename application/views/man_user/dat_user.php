<?php $this->load->view('layout/head'); ?>
    <body class="sb-nav-fixed">
<?php $this->load->view('layout/topbar'); ?>
        <div id="layoutSidenav">
<?php $this->load->view('layout/sidenav'); ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <ol class="breadcrumb bg-transparent mt-4">
                          <?php $i=0; foreach ($breadcrumb as $bc): ?>
                            <li class="breadcrumb-item active"><?= $bclink[$i] ?><?=  $bc ?></a></li>
                          <?php $i++; endforeach ?>
                        </ol>
                        <div class="card mb-4" style="background-color: rgba(0,0,0,0);">
                            <div class="card-header">
                                <button class="btn btn-primary" id="tbh" type="button" data-toggle="modal" data-target="#staticBackdrop"><i class="fas fa-plus mr-1"></i>Tambah Data</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered bg-light" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Req Employee</th>
                                                <th>Nama Pegawai</th>
                                                <th>Level</th>
                                                <th>Username</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php $no=1; foreach ($user as $us): ?>
                                          <tr>
                                              <td class="">
                                                  <?php echo $no.'.' ?>
                                              </td>
                                              <td class="">
                                                  -
                                              </td>
                                              <td class="">
                                                  -
                                              </td>
                                              <td class="">
                                                  -
                                                  <!-- <?php echo $us->jabatan ?> -->
                                              </td>
                                              <td class="">
                                                  <?php echo $us->username ?>
                                              </td>
                                              <td class="">
                                                  <a href="<?php echo site_url('manager/users/edit/'.$us->id_data_user) ?>"
                                                   class="btn btn-small"><i class="fas fa-edit"></i> Edit</a>
                                                  <a value="<?= site_url('manager/users/delete/'.$us->id_data_user) ?>"  class="btn btn-small text-danger hps"><i class="fas fa-trash"></i> Delete</a>
                                              </td>
                                          </tr>
                                          <?php $no+=1; endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                <!-- Modal Input -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah User</h5>
                        <button tabindex="-1" type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">

                        <form>

                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                  <label class="small mb-1" for="selectUnit">Unit Kerja</label>
                                  <select name="selectUnit" id="selectUnit" class="form-control form-control-sm">
                                    <option value=""></option>
                                  </select>
                              </div>
                            </div>

                            <div class="col">
                              <div class="form-group">
                                  <label class="small mb-1" for="jabatan">Jabatan</label>
                                  <input type="text" name="" id="jabatan" class="form-control form-control-sm">
                                <div class="invalid-feedback" id="invalid-kodeLevel">
                                  Silahkan isi kolom Jabatan
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                  <label class="small mb-1" for="selectNamaPegawai">Nama Pegawai</label>
                                  <select name="" id="selectNamaPegawai" class="form-control form-control-sm">
                                    <option value=""></option>
                                  </select>
                              </div>
                            </div>

                            <div class="col">
                              <div class="form-group">
                                  <label class="small mb-1" for="username">Username</label>
                                  <input type="text" name="" id="username" class="form-control form-control-sm">
                                <div class="invalid-feedback" id="invalid-kodeLevel">
                                  Silahkan isi kolom Username
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                  <label class="small mb-1" for="regEmployee">Reg Employee</label>
                                  <input type="text" name="" id="regEmployee" class="form-control form-control-sm">
                                <div class="invalid-feedback" id="invalid-kodeLevel">
                                  Silahkan isi kolom Req Employee
                                </div>
                              </div>
                            </div>

                            <div class="col">
                              <div class="form-group">
                                  <label class="small mb-1" for="password">Passowrd</label>
                                  <input type="password" name="" id="password" class="form-control form-control-sm">
                                <div class="invalid-feedback" id="invalid-kodeLevel">
                                  Silahkan isi kolom Password
                                </div>
                              </div>
                            </div>
                          </div>

                        </form>

                      </div>
                      <div class="modal-footer">
                        <button type="button" id="simpan" class="btn btn-primary">Simpan Data</button>
                      </div>
                    </div>
                  </div>
                </div>


<?php $this->load->view('layout/footer'); ?>

            </div>
        </div>

<?php $this->load->view('layout/bottom'); ?>

        <script type="text/javascript" charset="utf-8" async defer>
            $(document).ready(function(){
              
            });
        </script>

    </body>
</html>
