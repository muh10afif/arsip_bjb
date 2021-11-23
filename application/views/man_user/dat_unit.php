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
                                                <th>Kode Unit Kerja</th>
                                                <th>Nama Unit Kerja</th>
                                                <th>Lokasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; foreach ($unit as $un): ?>
                                            <tr>
                                                <td class="">
                                                    <?php echo $no.'.' ?>
                                                </td>
                                                <td class="">
                                                    <?php echo $un->kode_unit_kerja ?>
                                                </td>
                                                <td class="">
                                                    <?php echo $un->unit_kerja ?>
                                                </td>
                                                <td class="">
                                                    <?php echo $un->lokasi ?>
                                                </td>
                                                <td class="">
                                                    <a value="<?= $un->id_unit_kerja?>"class="btn btn-small edit"><i class="fas fa-edit"></i> Edit</a>
                                                    <a value="<?= site_url('man_user/deleteUnit/'.$un->id_unit_kerja) ?>"  class="btn btn-small text-danger hps"><i class="fas fa-trash"></i> Delete</a>
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
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Unit Kerja</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" tabindex="-1">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">

                        <form>

                            <div class="form-group">
                                <label class="small mb-1" for="kodeUnit">Kode Unit Kerja</label>
                                <input class="form-control" id="kodeUnit" type="text" />
                                <div class="invalid-feedback" id="invalid-kodeUnit">
                                  Silahkan isi kolom Unit Kerja
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="namaUnit">Nama Unit Kerja</label>
                                <input class="form-control" id="namaUnit" type="text" />
                                <div class="invalid-feedback" id="invalid-namaUnit">
                                  Silahkan isi kolom Nama Unit
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="lokasiUnit">Lokasi</label>
                                <input class="form-control" id="lokasiUnit" type="text" />
                                <div class="invalid-feedback" id="invalid-lokasiUnit">
                                  Silahkan isi kolom Lokasi Unit
                                </div>
                            </div>
                            <div class="form-group">
                              <label class="small mb-1" for="selectLevel">Level</label>
                              <select name="selectLevel" id="selectLevel" class="custom-select">
                                <option value="">-pilih-</option>
                                <?php $no=1; foreach ($level as $lev): ?>
                                  <option value="<?= $lev->id_data_level ?>"><?= $lev->nama_level ?></option>
                                <?php $no+=1; endforeach; ?>
                              </select>
                                <div class="invalid-feedback" id="invalid-selectLevel">
                                  Silahkan isi kolom Level
                                </div>
                            </div>

                        </form>

                      </div>
                      <div class="modal-footer">
                        <button type="button" id="tambah" class="btn btn-primary">Simpan Data</button>
                        <button type="button" id="editBTN" class="btn btn-primary" hidden />Update Data</button>
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

              //TAMBAH START
              $('#tambah').on('click', function(){
                $('#namaUnit').val();
                $('#kodeUnit').val();
                $('#lokasiUnit').val();
                $('#selectLevel').val();
                $.ajax({
                  type:"POST",
                  url:"<?= base_url() ?>man_user/addUnit",
                  data:{
                    kodeUnit : $('#kodeUnit').val(),
                    namaUnit : $('#namaUnit').val(),
                    lokasiUnit : $('#lokasiUnit').val(),
                    selectLevel : $('#selectLevel').val()
                        },
                  success:function (data) {
                    if (data.includes("Kode") && data.includes("Nama") && data.includes("Lokasi")) {

                      $('#kodeUnit').addClass('is-invalid');
                      $('#namaUnit').addClass('is-invalid');
                      $('#lokasiUnit').addClass('is-invalid');
                      $('#kodeUnit').focus();
                    
                    }else if (data.includes("Nama") && data.includes("Lokasi")) {
                      $('#namaUnit').addClass('is-invalid');
                      $('#lokasiUnit').addClass('is-invalid');
                      $('#namaUnit').focus();
                    }else if (data.includes("Kode")) {
                      fieldReq('kodeUnit');
                    }else if (data.includes("Nama")) {
                      fieldReq('namaUnit');
                    }else if (data.includes("Lokasi")) {
                      fieldReq('lokasiUnit');
                    }else if (data == 'Sukses') {

                      //FUNGSI BERHASIL
                      swal({
                        title: "Data Tersimpan!",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1000
                      }, function(){
                        swal.close();
                        $('#staticBackdrop').modal('hide');
                        location.reload();
                      });
                    }else{
                      console.log(data);
                    }
                  }
                  });
              });
              //TAMBAH END

              //HAPUS START
              $('.hps').click(function(event){
                  var href = $(this).attr("value");
                  var row = this;

                  swal({
                      title: 'Are you sure want to Delete data?',
                      text: "It can't be undone",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Delete'

                  },function () {
                      $.ajax({
                        type: "GET",
                        url: href,
                        success: function(response) {
                          console.log(response);
                          if (response == "Success")
                          {
                              $(row).closest('tr').fadeOut("slow");
                              swal({
                                  title: "Deleted a row of data!",
                                  type: "success",
                                  showConfirmButton: false,
                                  timer: 800
                              },function(){
                                  // container.load('users');
                              setTimeout(function(){ location.reload(); }, 500);
                              });
                          }
                          else
                          {
                            alert("Error");
                          }

                        }
                      });
                  });
              });
              //HAPUS END

              $('.edit').on('click',function(){
                var href = $(this).attr("value");
                $.ajax({
                  type : "POST",
                  url : "getUnit/"+href,
                  dataType: 'json',
                  success: function(res){
                    var inp_id = '<input type="text" name="id" id="id" value="'+res.id_unit_kerja+'" hidden>';
                    var inp_date = '<input type="text" name="date" id="date" value="'+res.add_time+'" hidden>';

                    $('#staticBackdropLabel').html('Edit Unit Kerja '+res.unit_kerja);
                    $('form').append(inp_id);
                    $('form').append(inp_date);
                    $('#kodeUnit').val(res.kode_unit_kerja);
                    $('#namaUnit').val(res.unit_kerja);
                    $('#lokasiUnit').val(res.lokasi);
                    $('#tambah').attr('hidden','true');
                    $('#editBTN').removeAttr('hidden');
                    
                    $('#staticBackdrop').modal();


                    //RESET MODAL BA'DA DITUTUP
                    $('#staticBackdrop').on('hidden.bs.modal', function (e) {

                      $('#staticBackdropLabel').html('Tambah Level');
                      $('#kodeUnit').val("");
                      $('#namaUnit').val("");
                      $('#lokasiUnit').val("");
                      $('#editBTN').attr('hidden','true');
                      $('#tambah').removeAttr('hidden');
                    
                    })

                  }
                });
              });

              //EDIT START
              $('#editBTN').on('click', function(){
                $.ajax({
                  type:"POST",
                  url:"<?= base_url() ?>man_user/editUnit",
                  data:{
                    kodeUnit : $('#kodeUnit').val(),
                    namaUnit : $('#namaUnit').val(),
                    lokasiUnit : $('#lokasiUnit').val(),
                    id        : $('#id').val(),
                    date      : $('#date').val()
                        },
                  success:function (data) {
                    if (data.includes("Kode") && data.includes("Nama") && data.includes("Lokasi")) {

                      $('#kodeUnit').addClass('is-invalid');
                      $('#namaUnit').addClass('is-invalid');
                      $('#lokasiUnit').addClass('is-invalid');
                      $('#kodeUnit').focus();
                    
                    }else if (data.includes("Nama") && data.includes("Lokasi")) {
                      $('#namaUnit').addClass('is-invalid');
                      $('#lokasiUnit').addClass('is-invalid');
                      $('#namaUnit').focus();
                    }else if (data.includes("Kode")) {
                      fieldReq('kodeUnit');
                    }else if (data.includes("Nama")) {
                      fieldReq('namaUnit');
                    }else if (data.includes("Lokasi")) {
                      fieldReq('lokasiUnit');
                    }else if (data == 'Sukses') {

                      //FUNGSI BERHASIL
                      swal({
                        title: "Data Diupdate!",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1000
                      }, function(){
                        swal.close();
                        $('#staticBackdrop').modal('hide');
                        location.reload();
                      });
                    }else{
                      console.log(data);
                    }
                  }
                  });
              });
              // EDIT END

              onInput('kodeUnit');
              onInput('namaUnit');
              onInput('lokasiUnit');

            });
        </script>

    </body>
</html>
