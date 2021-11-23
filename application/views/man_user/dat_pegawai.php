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
                                                <th>Jabatan</th>
                                                <th>Telepon</th>
                                                <th>E-mail</th>
                                                <th>Detail</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php $no=1; foreach ($pegawai as $peg): ?>
                                          <tr>
                                              <td class="">
                                                  <?php echo $no.'.' ?>
                                              </td>
                                              <td class="">
                                                  <?php echo $peg->reg_employee ?>
                                              </td>
                                              <td class="">
                                                  <?php echo $peg->nama_pegawai ?>
                                              </td>
                                              <td class="">
                                                  -
                                                  <!-- <?php echo $peg->jabatan ?> -->
                                              </td>
                                              <td class="">
                                                  <?php echo $peg->no_telp ?>
                                              </td>
                                              <td class="">
                                                  <?php echo $peg->email ?>
                                              </td>
                                              <td class="">
                                                -
                                              </td>
                                              <td class="">
                                                  <a href="<?php echo site_url('manager/users/edit/'.$peg->id_data_jabatan) ?>"
                                                   class="btn btn-small"><i class="fas fa-edit"></i> Edit</a>
                                                  <a value="<?= site_url('manager/users/delete/'.$peg->id_data_jabatan) ?>"  class="btn btn-small text-danger hps"><i class="fas fa-trash"></i> Delete</a>
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
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Pegawai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">

                        <form>

                          <div class="row mb-3">
                            <div class="col">
                              <label class="small mb-1" for="selectUnit">Unit Kerja</label>
                              <select name="selectUnit" id="selectUnit" class="custom-select">
                                <option value=""></option>
                              </select>

                              <input class="form-control" id="tambahUnit" type="text" hidden/>

                            </div>
                            <div id="tbUnit" class="col- mt-4 mr-3">
                              <button type="button" id="btUnit" class="btn btn-primary">
                                  <i class="fas fa-plus"></i>
                              </button>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <div class="col">
                                <label class="small mb-1" for="regEmployee">Reg Employee</label>
                                <input class="form-control" id="regEmployee" type="text" />
                            </div>
                          </div>
                            
                            <div class="row mb-3">
                                <div class="col">
                                  <label class="small mb-1" for="nik">NIK</label>
                                  <input class="form-control" id="nik" type="text" />
                                </div>
                                <div class="col">
                                  <label class="small mb-1" for="email">Email</label>
                                  <input class="form-control" id="email" type="text" />
                                </div>
                            </div>
                            
                            <div class="row mb-1">
                                <div class="col">
                                  <label class="small mb-1" for="nik">Nama Pegawai</label>
                                  <input class="form-control" id="namaPegawai" type="text" />
                                </div>
                                <div class="col">
                                  <div class="row mb-3">
                                    <div class="col">
                                        <label class="small mb-1" for="selectJabatan">Jabatan</label>
                                        <select name="selectJabatan" id="selectJabatan" class="custom-select">
                                          <option value=""></option>
                                        </select>
                                        <input class="form-control" id="tambahJabatan" type="text" hidden/>
                                    </div>
                                    <div id="tbJabatan" class="col- mt-4 mr-3">
                                      <button type="button" id="btJabatan" class="btn btn-primary">
                                          <i class="fas fa-plus"></i>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                  <div class="row">
                                    <div class="col">
                                      <label class="small mb-1" for="tanggalLahir">Tanggal Lahir</label>
                                      <input class="form-control" id="tanggalLahir" type="date" />
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <label class="small mb-1" for="telepon">Telepon</label>
                                      <input class="form-control" id="telepon" type="text" />
                                    </div>
                                  </div>

                                </div>
                                <div class="col">
                                  <label class="small mb-1" for="alamat">Alamat</label>
                                  <textarea class="form-control" name="" style="height:6.5rem;"></textarea>
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

              $('#btUnit').on('click',function(){
                $('#selectUnit').hide();
                $('#tbUnit').hide();
                $('#tambahUnit').removeAttr('hidden');
              });

              $('#btJabatan').on('click',function(){
                $('#selectJabatan').hide();
                $('#tbJabatan').hide();
                $('#tambahJabatan').removeAttr('hidden');
              });

              

            });
        </script>

    </body>
</html>
