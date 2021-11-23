
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>


<script src="<?php echo base_url() ?>assets/swa/sweetalert2.all.min.js"></script>
<script src="<?= base_url('') ?>dist/js/scripts.js"></script>
<script src="<?= base_url('') ?>dist/js/form_val.js"></script>
<script src="<?= base_url('') ?>dist/assets/demo/chart-area-demo.js"></script>
<script src="<?= base_url('') ?>dist/assets/demo/chart-bar-demo.js"></script>
<script src="<?= base_url('') ?>dist/assets/demo/datatables-demo.js"></script>

<!-- select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script src="<?= base_url() ?>assets/moment/moment.js"></script>
<script src="<?= base_url() ?>assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>

 $('select').each(function () {
    $(this).select2({
      theme: 'bootstrap4',
      width: 'style',
      placeholder: $(this).attr('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
    });
  });

  jQuery('.datepicker').datepicker({
      autoclose: true,
      todayHighlight: true,
      format      : "dd-MM-yyyy",
      orientation : "bottom"
  });
  
  $('body').tooltip({selector: '[data-toggle="tooltip"]'});
  
</script>