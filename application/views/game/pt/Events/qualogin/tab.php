<script type="text/javascript" src="/libraries/jqwidgets32/jqx-all.js"></script>
<link href='/libraries/jqwidgets32/styles/jqx.base.css' rel='stylesheet' type='text/css'>
<link href='/libraries/jqwidgets32/styles/jqx.classic.css' rel='stylesheet' type='text/css'>
<link href='/libraries/pannonia/pannonia/css/plugins.css' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validation.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="/libraries/cms/jquery.form.js"></script>
<script>
    $(document).ready(function () {
    // Javascript to enable link to tab
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href=#' + url.split('#')[1] + ']').tab('show');
    }

    // Change hash for page-reload
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    });
    });

    $(function () {        
        $('#home').on('click', function (e) {
            window.location.href = "?control=qualogin&func=index&view=item";
        });

        $('#giaidau').on('click', function (e) {
            window.location.href = "?control=qualogin&func=index&view=wheel";
        });

        $('#trandau').on('click', function (e) {
            window.location.href = "?control=qualogin&func=index&view=filter";
        });
    });
</script>
<style>
.loading {display: none;position: fixed;top: 0;left: 0;right: 0;bottom: 0;background-color: rgba(0,0,0,.7);z-index: 1000;text-align: center;padding-top: 20%;}
.control-group input[type="text"] {
border-radius: 0;
box-shadow: none;
width: 90%;
}
.form-horizontal .controls {
position: relative;
margin-left: 0%;
}
.form-horizontal .control-label { float: none; 
}
.control-group{padding:0;}
.control-group label {
font-weight: bold;
}.group1 .control-group {
float: left;
}
</style>
<div class="loading"><img src="/assets/img/loading.gif" /></div>
<h4 class="widget-name">QUẢN LÝ EVENT TÍCH LŨY</h4>
<!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="<?php  echo $_GET['view']=='item'?'active':'';?>"><a id="home" href="#home" aria-controls="home" role="tab" data-toggle="tab">ITEMS MANAGER</a></li>
    <li role="presentation" class="<?php  echo $_GET['view']=='wheel'?'active':'';?>"><a id="giaidau"  href="#giaidau" aria-controls="giaidau" role="tab" data-toggle="tab">WHEEL MANAGER</a></li>
    <li role="presentation" class="<?php  echo $_GET['view']=='filter'?'active':'';?>"><a id="trandau" href="#trandau" aria-controls="trandau" role="tab" data-toggle="tab">FILTER MANAGER</a></li>
  </ul>

 <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="mySmallModalLabel">Thông báo</h4>
        </div>
        <div class="modal-body"><div id="messgage" style="text-align: center;"></div></div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->