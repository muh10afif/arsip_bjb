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
                                                <th>Kode Masalah</th>
                                                <th>Jenis Berkas</th>
                                                <th>Kode Berkas</th>
                                                <th>Judul Berkas</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php $no=1; foreach ($pengarsipan as $peng): ?>
                                          <tr>
                                              <td class="">
                                                  <?php echo $no.'.' ?>
                                              </td>
                                              <td class="">
                                                  <?php echo '-' ?>
                                              </td>
                                              <td class="">
                                                  <?php echo '-' ?>
                                              </td>
                                              <td class="">
                                                  <?php echo $peng->kode_berkas ?>
                                              </td>
                                              <td class="">
                                                  <?php echo $peng->judul_berkas ?>
                                              </td>
                                              <td class="">
                                                  <?php echo '-' ?>
                                              </td>
                                              <td class="">
                                                  <a href="<?php echo site_url('manager/users/edit/'.$peng->id_pengarsipan) ?>"
                                                   class="btn btn-small"><i class="fas fa-edit"></i> Edit</a>
                                                  <a value="<?= site_url('manager/users/delete/'.$peng->id_pengarsipan) ?>"  class="btn btn-small text-danger hps"><i class="fas fa-trash"></i> Delete</a>
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
                                  <label class="small mb-1" for="selectKodeMasalah">Kode Masalah</label>
                                  <select name="selectKodeMasalah" id="selectKodeMasalah" class="form-control form-control-sm">
                                    <option value=""></option>
                                  </select>
                              </div>
                            </div>

                            <div class="col">
                              <div class="form-group">
                                  <label class="small mb-1" for="selectJenisBerkas">Jenis Berkas</label>
                                  <select name="selectJenisBerkas" id="selectJenisBerkas" class="form-control form-control-sm">
                                    <option value=""></option>
                                  </select>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                  <label class="small mb-1" for="selectSaranaPenyimpanan">Sarana Penyimpanan</label>
                                  <select name="selectSaranaPenyimpanan" id="selectSaranaPenyimpanan" class="form-control form-control-sm">
                                    <option value=""></option>
                                  </select>
                              </div>
                            </div>

                            <div class="col">
                              <div class="form-group">
                                  <label class="small mb-1" for="selectDokumenUnit">Dokumen Unit</label>
                                  <select name="selectDokumenUnit" id="selectDokumenUnit" class="form-control form-control-sm">
                                    <option value=""></option>
                                  </select>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                  <label class="small mb-1" for="selectLemariBerkas">Lemari Berkas</label>
                                  <select name="selectLemariBerkas" id="selectLemariBerkas" class="form-control form-control-sm">
                                    <option value=""></option>
                                  </select>
                              </div>
                            </div>

                            <div class="col">
                              <div class="form-group">
                                  <label class="small mb-1" for="selectRakArsip">Rak Arsip</label>
                                  <select name="selectRakArsip" id="selectRakArsip" class="form-control form-control-sm">
                                    <option value=""></option>
                                  </select>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <label class="small mb-1" for="kodeBerkas">Kode Berkas</label>
                                <input type="kodeBerkas" name="" id="kodeBerkas" class="form-control form-control-sm">
                              </div>
                            </div>

                            <div class="col">
                              <div class="form-group">
                                <label class="small mb-1" for="nomorDokumen">Nomor Dokumen</label>
                                <input type="nomorDokumen" name="" id="nomorDokumen" class="form-control form-control-sm">
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <label class="small mb-1" for="judulBerkas">Judul Berkas</label>
                                <input type="judulBerkas" name="" id="judulBerkas" class="form-control form-control-sm">
                              </div>
                            </div>

                            <div class="col">
                              <div class="form-group">
                                <label class="small mb-1" for="unitKerja">Unit Kerja Pemilik Arsip</label>
                                <input type="unitKerja" name="" id="unitKerja" class="form-control form-control-sm">
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <div class="custom-file">
                                <label class="custom-file-label" for="uploadBerkas">Upload Berkas</label>
                                <input type="file" class="custom-file-input" id="uploadBerkas">
                              </div>
                            </div>
                            </div>

                            <div class="col">
                              <div class="form-group">
                                <input type="fileName" name="fileName" id="fileName" class="form-control form-control" readonly>
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
