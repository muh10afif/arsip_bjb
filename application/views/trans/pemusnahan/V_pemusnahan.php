<ol class="breadcrumb bg-transparent mt-4">
    <?php $i=0; foreach ($breadcrumb as $bc): ?>
    <li class="breadcrumb-item active"><?= $bclink[$i] ?><?=  $bc ?></a></li>
    <?php $i++; endforeach ?>
</ol>

<div class="card mb-4 shadow" id="kartu">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tabel_pemusnahan" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th  width="10%">No</th>
                        <th>Unit Kerja Pemilik</th>
                        <th>Kode Masalah</th>
                        <th>Jenis Berkas</th>
                        <th>Kode Berkas</th>
                        <th>Judul Berkas</th>
                        <th>Tanggal Usulan</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>

$(document).ready(function () {

    // dataTables pemusnahan
    var tabel_pemusnahan = $('#tabel_pemusnahan').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "<?= base_url("trans/tampil_pemusnahan") ?>",
            "type"  : "POST"
        },
        "columnDefs"        : [{
            "targets"   : [0,7],
            "orderable" : false
        }]

    })

    $('#tabel_pemusnahan').on('click', '.ubah', function () {
        
        var id_pemusnahan    = $(this).data('id');
        var aksi             = $(this).attr('aksi');

        console.log(tabel_pemusnahan);

        swal({
            title       : 'Konfirmasi',
            text        : 'Yakin data ini '+aksi+' ?',
            type        : 'warning',

            buttonsStyling      : false,
            confirmButtonClass  : "btn btn-primary",
            cancelButtonClass   : "btn btn-danger mr-3",

            showCancelButton    : true,
            confirmButtonText   : 'Ya',
            confirmButtonColor  : '#d33',
            cancelButtonColor   : '#3085d6',
            cancelButtonText    : 'Batal',
            reverseButtons      : true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url         : "<?= base_url('trans/aksi_pemusnahan') ?>",
                    method      : "POST",
                    beforeSend  : function () {
                        swal({
                            title   : 'Menunggu',
                            html    : 'Memproses Data',
                            onOpen  : () => {
                                swal.showLoading();
                            }
                        })
                    },
                    data        : {id_pemusnahan:id_pemusnahan, aksi:aksi},
                    dataType    : "JSON",
                    success     : function (data) {

                        tabel_pemusnahan.ajax.reload(null, false);

                        swal({
                            title               : 'Berhasil',
                            text                : 'Data Berhasil Disimpan',
                            buttonsStyling      : false,
                            confirmButtonClass  : "btn btn-success",
                            type                : 'success',
                            showConfirmButton   : false,
                            timer               : 800
                        }); 
                        
                        $('#modal_pemusnahan').modal('hide');
                    },
                    error       : function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.Message);
                    }

                })

                return false;
            } else if (result.dismiss === swal.DismissReason.cancel) {

                swal({
                    title               : 'Batal',
                    text                : 'Anda membatalkan aksi',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-primary",
                    type                : 'error',
                    showConfirmButton   : false,
                    timer               : 800
                }); 
            }
        })

    })
    
})

</script>