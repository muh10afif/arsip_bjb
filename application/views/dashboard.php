
    <ol class="breadcrumb bg-transparent mt-2">
      <?php $i=0; foreach ($breadcrumb as $bc): ?>
        <li class="breadcrumb-item active"><?= $bclink[$i] ?><?=  $bc ?></a></li>
      <?php $i++; endforeach ?>
    </ol>

    <div class="row my-2 mx-1">

      <div class="col py-2">
          <div class="card text-white bg-primary shadow">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h1 class="card-title"><i class="fas fa-home"></i></h1>
                </div>
                <div class="col text-right">
                  <!-- SUM DATABASE -->
                  <h1><?= $tot_gudang_arsip ?></h1>
                </div>
              </div>
              <p class="card-text">Gudang Arsip</p>
            </div>
            <div class="card-footer text-right">
              <a href="<?= base_url() ?>master_kearsipan/gudang_arsip" title="" class="text-white" class="text-white">Detail  <i class="fas fa-caret-right"></i></a>
            </div>
          </div>
      </div>

      <div class="col py-2">
          <div class="card bg-danger text-white shadow">
            <div class="card-body">
              <div class="row">
                <div class="col-sm">
                  <h1 class="card-title"><i class="fas fa-building"></i></h1>
                </div>
                <div class="col-sm text-right">
                  <!-- SUM DATABASE -->
                  <h1><?= $tot_lemari_berkas ?></h1>
                </div>
              </div>
              <p class="card-text">Lemari Berkas</p>
            </div>
            <div class="card-footer text-muted  text-right">
              <a href="<?= base_url() ?>master_kearsipan/lemari_berkas" title="" class="text-white">Detail  <i class="fas fa-caret-right"></i></a>
            </div>
          </div>
      </div>

      <div class="col py-2">
          <div class="card bg-success text-white shadow">
            <div class="card-body">
              <div class="row">
                <div class="col-sm">
                    <h1 class="card-title"><i class="fab fa-dropbox"></i></h1>
                </div>
                <div class="col-sm text-right">
                  <!-- SUM DATABASE -->
                  <h1><?= $tot_rak_arsip ?></h1>
                </div>
              </div>
                <p class="card-text">Rak Arsip</p>
            </div>
            <div class="card-footer text-muted  text-right">
              <a href="<?= base_url() ?>master_kearsipan/rak_arsip" title="" class="text-white">Detail  <i class="fas fa-caret-right"></i></a>
            </div>
          </div>
      </div>

        <div class="col py-2">
            <div class="card bg-warning text-white shadow">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm">
                    <h1 class="card-title"><i class="fas fa-file-archive"></i></h1>
                  </div>
                  <div class="col-sm text-right">
                    <!-- SUM DATABASE -->
                    <h1><?= $tot_dokumen_unit ?></h1>
                  </div>
                </div>
                <p class="card-text">Dokumen Arsip</p>
              </div>
              <div class="card-footer text-muted  text-right">
                <a href="<?= base_url() ?>master_kearsipan/dok_unit" title="" class="text-white">Detail  <i class="fas fa-caret-right"></i></a>
              </div>
            </div>
        </div>

    </div>
