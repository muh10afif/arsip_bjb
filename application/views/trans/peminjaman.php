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
                                                <th>Instansi Peminjam</th>
                                                <th>Unit Kerja Pemilik</th>
                                                <th>Kode Masalah</th>
                                                <th>Jenis Berkas</th>
                                                <th>Judul Berkas</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                                <th>Dokumen</th>
                                                <th>Pengembalian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php $no=1; foreach ($peminjaman as $pinjam): ?>
                                          <tr>
                                              <td class="">
                                                  <?php echo $no.'.' ?>
                                              </td>
                                              <td class="">
                                                  <?php echo $pinjam->instansi_peminjam ?>
                                              </td>
                                              <td class="">
                                                  <?php echo '-' ?>
                                              </td>
                                              <td class="">
                                                  <?php echo '-' ?>
                                              </td>
                                              <td class="">
                                                  <?php echo '-' ?>
                                              </td>
                                              <td class="">
                                                  <?php echo '-' ?>
                                              </td>
                                              <td class="">
                                                  <?php echo '-' ?>
                                              </td>
                                              <td class="">
                                                  <a href="<?php echo site_url('manager/users/edit/'.$pinjam->id_peminjaman) ?>"
                                                   class="btn btn-small"><i class="fas fa-edit"></i> Edit</a>
                                                  <a value="<?= site_url('manager/users/delete/'.$pinjam->id_peminjaman) ?>"  class="btn btn-small text-danger hps"><i class="fas fa-trash"></i> Delete</a>
                                              </td>
                                              <td class="">
                                                  <?php echo '-' ?>
                                              </td>
                                              <td class="">
                                                  <?php echo '-' ?>
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
                                <label class="small mb-1" for="kodeLevel">Instansi Peminjam</label>
                                <input class="form-control" id="kodeLevel" type="text" />
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <label class="small mb-1" for="namaLevel">Unit Kerja Pemilik</label>
                                <input class="form-control" id="namaLevel" type="text" />
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <label class="small mb-1" for="kodeLevel">Kode Masalah</label>
                                <input class="form-control" id="kodeLevel" type="text" />
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <label class="small mb-1" for="namaLevel">Jenis Berkas</label>
                                <input class="form-control" id="namaLevel" type="text" />
                              </div>
                            </div>
                          </div>
                          
                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <label class="small mb-1" for="namaLevel">Kode Berkas</label>
                                <input class="form-control" id="namaLevel" type="text" />
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <label class="small mb-1" for="kodeLevel">Nomor Dokumen</label>
                                <input class="form-control" id="kodeLevel" type="text" />
                              </div>
                            </div>
                          </div>
                          
                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <label class="small mb-1" for="namaLevel">Judul Berkas</label>
                                <input class="form-control" id="namaLevel" type="text" />
                              </div>
                            </div>
                            <div class="col">

                            </div>
                          </div>

                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <div class="custom-file">
                                <label class="custom-file-label small" for="uploadBerkas">Surat Peminjam</label>
                                <input type="file" class="custom-file-input" id="uploadBerkas">
                              </div>
                            </div>
                            </div>

                            <div class="col">
                              <div class="form-group">
                                <input type="fileName" name="fileName" id="fileName" class="form-control form-control small" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <div class="custom-file">
                                <label class="custom-file-label small" for="uploadBerkas">Identitas Peminjam</label>
                                <input type="file" class="custom-file-input" id="uploadBerkas">
                              </div>
                            </div>
                            </div>

                            <div class="col">
                              <div class="form-group">
                                <input type="fileName" name="fileName" id="fileName" class="form-control form-control small" readonly>
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
              $('#uploadBerkas').on('change', function(){
                var isi = $('#uploadBerkas').val();
                isi = isi.substring(isi.lastIndexOf("\\") + 1, isi.length);
                $('#fileName').val(isi);
              });
            });
        </script>

    </body>
</html>
