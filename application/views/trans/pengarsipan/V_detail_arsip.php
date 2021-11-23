<div class="modal-header bg-primary">
    <h5 class="modal-title text-white" id="judul">Detail Arsip</h5>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white;">×</button>
</div>
<div class="modal-body">
    <div class="row d-flex justify-content-center mt-3 mb-3">
        <div class="col-md-10">
            <div class="row">
                <label class="col-md-3 control-label col-form-label">Kode Masalah</label>
                <div class="col-md-9">
                    
                    <input type="text" class="form-control" value="<?= $arsip['kode_masalah'] ?>" readonly>

                </div>
            </div>
        </div>
        <div class="col-md-10 mt-3">
            <div class="row">
                <label class="col-md-3 control-label col-form-label">Jenis Berkas</label>
                <div class="col-md-9">
                    
                    <input type="text" class="form-control" value="<?= $arsip['jenis_berkas'] ?>" readonly>

                </div>
            </div>
        </div>
        <div class="col-md-10 mt-3">
            <div class="row">
                <label class="col-md-3 control-label col-form-label">Sarana Penyimpanan</label>
                <div class="col-md-9">
                    
                <input type="text" class="form-control" value="<?= $arsip['sarana_penyimpanan'] ?>" readonly>

                </div>
            </div>
        </div>
        <div class="col-md-10 mt-3">
            <div class="row">
                <label class="col-md-3 control-label col-form-label">Dokumen Unit</label>
                <div class="col-md-9">
                    
                <input type="text" class="form-control" value="<?= $arsip['dokumen_unit'] ?>" readonly>

                </div>
            </div>
        </div>
        <div class="col-md-10 mt-3">
            <div class="row">
                <label class="col-md-3 control-label col-form-label">Lemari Berkas</label>
                <div class="col-md-9">
                    
                <input type="text" class="form-control" value="<?= $arsip['lemari_berkas'] ?>" readonly>
                    
                </div>
            </div>
        </div>
        <div class="col-md-10 mt-3">
            <div class="row">
                <label class="col-md-3 control-label col-form-label">Rak Arsip</label>
                <div class="col-md-9">
                    
                <input type="text" class="form-control" value="<?= $arsip['rak_arsip'] ?>" readonly>

                </div>
            </div>
        </div>
        <div class="col-md-10 mt-3">
            <div class="row">
                <label class="col-md-3 control-label col-form-label">Kode Berkas</label>
                <div class="col-md-9">
                <input type="text" class="form-control" value="<?= $arsip['kode_berkas'] ?>" readonly>
                </div>
            </div>
        </div>
        <div class="col-md-10 mt-3">
            <div class="row">
                <label class="col-md-3 control-label col-form-label">Nomor Dokumen</label>
                <div class="col-md-9">
                <input type="text" class="form-control" value="<?= $arsip['no_dokumen'] ?>" readonly>
                </div>
            </div>
        </div>
        <div class="col-md-10 mt-3">
            <div class="row">
                <label class="col-md-3 control-label col-form-label">Judul Berkas</label>
                <div class="col-md-9">
                <input type="text" class="form-control" value="<?= $arsip['judul_berkas'] ?>" readonly>
                </div>
            </div>
        </div>
        <?php $level = $this->session->userdata('level'); ?>

        <?php if ($level == 1) : ?>
        <div class="col-md-10 mt-3">
            <div class="row">
                <label class="col-md-3 control-label col-form-label">Unit Kerja</label>
                <div class="col-md-9">
                    
                <input type="text" class="form-control" value="<?= $arsip['unit_kerja'] ?>" readonly>
                    
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="col-md-10 mt-3">
            <div class="row upload-berkas" >
                <label class="col-md-3 control-label col-form-label">Berkas</label>
                <div class="col-md-9">
                    
                    <div class="input-group sel-unit">
                        <?php $br = base64_decode($berkas['upload_berkas']); ?>
                        <input type="text" class="form-control" value="<?= $br ?>" readonly>
                        <div class="input-group-append">
                        <a target="_blank" href="<?= base_url('trans/tampil_pdf/'.str_replace('=','_',$br).'/Preview') ?>"><button class="btn btn-primary" type="button">Lihat</button></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Close</button>
</div>