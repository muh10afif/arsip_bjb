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
                                    <th>Kode Sarana Penyimpanan</th>
                                    <th>Sarana Penyimpanan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach ($sarana_penyimpanan as $sp): ?>
                                <tr>
                                    <td class="">
                                        <?php echo $no.'.' ?>
                                    </td>
                                    <td class="">
                                        <?php echo $sp->kode_sarana_penyimpanan ?>
                                    </td>
                                    <td class="">
                                        <?php echo $sp->sarana_penyimpanan ?>
                                    </td>
                                    <td class="">
                                        <?php echo $sp->status ?>
                                    </td>
                                    <td class="">
                                        <a href="<?php echo site_url('manager/users/edit/'.$sp->id_sarana_penyimpanan) ?>"
                                         class="btn btn-small"><i class="fas fa-edit"></i> Edit</a>
                                        <a value="<?= site_url('manager/users/delete/'.$sp->id_sarana_penyimpanan) ?>"  class="btn btn-small text-danger hps"><i class="fas fa-trash"></i> Delete</a>
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
            <h5 class="modal-title" id="staticBackdropLabel">Tambah Sarana Penyimpanan</h5>
            <button tabindex="-1" type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form>

                <div class="form-group">
                    <label class="small mb-1" for="kodeSaranaPenyimpanan">Kode Sarana Penyimpanan</label>
                    <input class="form-control" id="kodeSaranaPenyimpanan" type="text" />
                    <div class="invalid-feedback" id="invalid-kodeSaranaPenyimpanan">
                      Silahkan isi kolom Kode Sarana Penyimpanan
                    </div>
                </div>
                <div class="form-group">
                    <label class="small mb-1" for="saranaPenyimpanan">Sarana Penyimpanan</label>
                    <input class="form-control" id="saranaPenyimpanan" type="text" />
                    <div class="invalid-feedback" id="invalid-saranaPenyimpanan">
                      Silahkan isi kolom Sarana Penyimpanan
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
