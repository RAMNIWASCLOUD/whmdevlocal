 <footer class="main-footer">
    <div class="pull-right hidden-xs">
    </div>
    {{-- <strong>Copyright &copy; {{date('Y')}} <a href="https://hohtechlabs.com/">HOH TECH LABS</a>.</strong> All rights
    reserved. --}}
  </footer>

  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



<!-- jQuery UI 1.11.4 -->
<script src="{{url('/')}}/css_and_js/admin/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
//  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url('/')}}/css_and_js/admin/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="{{url('/')}}/css_and_js/admin/raphael/raphael.min.js"></script>
<script src="{{url('/')}}/css_and_js/admin/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="{{url('/')}}/css_and_js/admin/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="{{url('/')}}/css_and_js/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{url('/')}}/css_and_js/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{url('/')}}/css_and_js/admin/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- ChartJS -->
<script src="{{url('/')}}/css_and_js/admin/chart.js/Chart.js"></script>
<!-- daterangepicker -->
<script src="{{url('/')}}/css_and_js/admin/moment/min/moment.min.js"></script>
<script src="{{url('/')}}/css_and_js/admin/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="{{url('/')}}/css_and_js/admin/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{url('/')}}/css_and_js/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="{{url('/')}}/css_and_js/admin/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{url('/')}}/css_and_js/admin/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{url('/')}}/css_and_js/admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('/')}}/css_and_js/admin/dist/js/pages/dashboard.js"></script>
<script src="{{url('/')}}/css_and_js/admin/dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('/')}}/css_and_js/admin/dist/js/demo.js"></script>
<!-- Parsley -->
<script src="{{ url('/')}}/css_and_js/admin/parsley.js"></script>

 <script src="{{ url('/')}}/css_and_js/admin/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="{{ url('/')}}/css_and_js/admin/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="{{url('/')}}/css_and_js/admin/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script src="{{url('/')}}/css_and_js/admin/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
{{-- <script src="{{url('/')}}/css_and_js/admin/jquery/dist/jquery.min.js"></script> --}}


<script src='{{url('/')}}/css_and_js/admin/select2/dist/js/select2.min.js' type='text/javascript'></script>

  <script>
    $(function () {
      //$("#datepicker").datepicker({ format: "dd/mm/yyyy" }).val();
      //$("#datepicker1").datepicker({ format: "dd/mm/yyyy" }).val();
      $("#datepicker_today").datepicker({ format: "yyyy-mm-dd",startDate:'today' }).val();
      $("#datepicker_today1").datepicker({ format: "yyyy-mm-dd",startDate:'today' }).val();

      $("#datepicker").datepicker({ format: "yyyy-mm-dd",autoclose: true}).val();
      $("#datepicker1").datepicker({ format: "yyyy-mm-dd",autoclose: true}).val();
      $("#datepicker2").datepicker({ format: "yyyy-mm-dd",autoclose: true}).val();
   
      $('#example1').DataTable();
      $('#example3').DataTable();
      $('#example4').DataTable();
      $('#example5').DataTable();

      $('#example2').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
      });

      $('.timepicker').timepicker({
        showInputs: false
      });


       // AREA CHART
    var area = new Morris.Bar({
      element: 'bar-chart',
      resize: true,
      data: [
        {y: '2021-Apr', a: (1971+777+1302)},
        {y: '2021-May', a: (103+855+683)},
        {y: '2021-June', a: (3100+793+6328)},
        {y: '2021-July', a: (17056+812+9236)},
        {y: '2021-Aug', a: (10823+1069+2852)},
        {y: '2021-Sep', a: (57144+5738+2035)},
        {y: '2021-Oct', a: (41921+2057+6125)/*, item2: 3597*/},
        {y: '2021-Nov', a: (15956+1676+3191)/*, item2: 3597*/},
        {y: '2021-Dec', a: (42811+4288+6693)/*, item2: 3597*/},
        {y: '2022-Jan', a: (57395+3197+7059)/*, item2: 1969*/},
        {y: '2022-Feb', a: (67133+3593+6760)/*, item2: 2294*/},
        {y: '2022-Mar', a: (74748+3502+7516)/*, item2: 2666*/},

     
      ],
      barColors: ['#a0d0e0'],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Installation'],
      hideHover: 'auto'
    });
    })
  </script>
  <script type="text/javascript">
    

const channel = new BroadcastChannel('tab');
let isOriginal = true;

channel.postMessage('another-tab');
// note that listener is added after posting the message

channel.addEventListener('message', (msg) => {
    if (msg.data === 'another-tab' && isOriginal) {
        // message received from 2nd tab
        // reply to all new tabs that the website is already open
        channel.postMessage('already-open');
    }
    if (msg.data === 'already-open') {
        isOriginal = false;
        // message received from original tab
        // replace this with whatever logic you need
        alert('Cannot open multiple instances');
        close();
    }
});
  </script>
   <script type="text/javascript">
 $(document).ready(function(){
  //$(".alert-danger").hide('fade',5000);
  $(".alert-success").hide('fade',5000);
  $("#datepicker").change(function(){
      var startDate = new Date($('#datepicker').val());
      var endDate = new Date($('#datepicker1').val());

      if (startDate > endDate)
      {
        $('#datepicker1_error').text("End date can't be less than start date.");
        $('.parsley-required').text('');
        return false;
      }
      else
      {
        $('#datepicker1_error').text("");
        return true;
      }
  });
  $("#selUser").select2();
  $("#selUser1").select2();

  $("#datepicker1").change(function(){
      var startDate = new Date($('#datepicker').val());
      var endDate = new Date($('#datepicker1').val());

      if (startDate > endDate)
      {
        $('.parsley-required').text('');
        $('#datepicker1_error').text("End date can't be less than start date.");
      }
      else
      {
        $('#datepicker1_error').text("");
      }
  });
  $(function() {
    $(".preload").fadeOut(1500, function() { });
    //$(".preload").fadeIn(1000);
  });

});
 </script>
   
</body>
</html>
