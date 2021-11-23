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
                                    <th>Kode</th>
                                    <th>Masalah</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach ($kode_masalah as $km): ?>
                                <tr>
                                    <td class="">
                                        <?php echo $no.'.' ?>
                                    </td>
                                    <td class="">
                                        <?php echo $km->kode_masalah ?>
                                    </td>
                                    <td class="">
                                        <?php echo $km->masalah ?>
                                    </td>
                                    <td class="">
                                        <?php echo $km->status ?>
                                    </td>
                                    <td class="">
                                        <a href="<?php echo site_url('manager/users/edit/'.$km->id_kode_masalah) ?>"
                                         class="btn btn-small"><i class="fas fa-edit"></i> Edit</a>
                                        <a value="<?= site_url('manager/users/delete/'.$km->id_kode_masalah) ?>"  class="btn btn-small text-danger hps"><i class="fas fa-trash"></i> Delete</a>
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
            <h5 class="modal-title" id="staticBackdropLabel">Tambah Masalah</h5>
            <button tabindex="-1" type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form>

                <div class="form-group">
                    <label class="small mb-1" for="kodeMasalah">Kode Masalah</label>
                    <input class="form-control" id="kodeMasalah" type="text" />
                    <div class="invalid-feedback" id="invalid-kodeMasalah">
                      Silahkan isi kolom Kode Masalah
                    </div>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="namaMasalah">Masalah</label>
                    <input class="form-control" id="namaMasalah" type="text" />
                    <div class="invalid-feedback" id="invalid-namaMasalah">
                      Silahkan isi kolom Nama Masalah
                    </div>
                </div>

            </form>

          </div>
          <div class="modal-footer">
            <button type="button" id="tambah" class="btn btn-primary">Simpan Data</button>
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