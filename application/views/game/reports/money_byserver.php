<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>" media="all"/>
<script src="<?php echo base_url('assets/datetime/js/submit.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/ajax.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>

<script src="<?php echo base_url('assets/datetime/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datetime/js/jquery-ui-timepicker-addon.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/jquery-ui-timepicker-addon.css') ?>"/>

<script src="<?php echo base_url('assets/popup/bootstrap-modal.js') ?>"></script>
<script src="<?php echo base_url('assets/popup/bootstrap-transition.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.table2excel.js') ?>"></script>
<style>
.loadserver .textinput{
    width:205px;
	margin-top:-10px;
}
.filter span{
    position: relative;
    top: -4px;
}
.content_tab{
    margin-top: 15px;
}
.filter span.loadExport{
    top:0px;
}
</style>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <?php include_once 'tab.php'; ?>
    <div class="content_tab">
        <div class="filter">
            <span>Máy chủ :</span>
            <select name="server">
                <option value="0">Chọn server</option>
                <?php
                    if(count($listServer)>0){
                        foreach($listServer as $v){
                ?>
                <option value="<?php echo $v['server_id'];?>"><?php echo $v['server_name'];?></option>
                <?php
                        }
                    }
                ?>
            </select>
            <span>Từ ngày :</span> <input type="text" name="date_from" placeholder="Ngày bắt đầu" value="<?php echo (!empty($arrFilter['date_from']))?$arrFilter['date_from']:date('d-m-Y',  strtotime('-25 day'));?>"/>
            <span>Đến ngày :</span> <input type="text" name="date_to" placeholder="Ngày kết thúc" value="<?php echo (!empty($arrFilter['date_to']))?$arrFilter['date_to']:date('d-m-Y');?>"/>    
            <input type="button" onclick="onSubmit('<?php echo base_url().'?control='.$_GET['control'].'&func=ajax_'.$_GET['func'].'&game='.$_GET['game'];?>')" value="Tìm" class="btn btn-primary"/>
            <span class="loadExport">
                <input type="button" value="Xuất Excel" class="disableExport btn"/>
            </span>
        </div>
        <form id="appForm" action="" method="post" name="appForm">
            <div class="loadData">
                <?php
                    if($_GET['game']=='bog'){
                ?>
                <table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th align="center" width="100px">Date</th>
                            <th align="center" width="100px">ServerID</th>
                            <th align="center" width="100px">Lam Ngọc(Balance)</th>
                            <th align="center" width="100px">Hồng Ngọc(BindBalance)</th>
                            <th align="center" width="100px">Gold(Money)</th>
                            <th align="center" width="100px">Matinh(EnergyP)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="emptydata">Dữ liệu không tìm thấy</td>
                        </tr>                     
                    </tbody>
                </table>
                <?php
                    }else{
                ?>
                <table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th align="center" width="100px">ServerID</th>
                            <th align="center" width="100px">Diamond</th>
                            <th align="center" width="100px">Gold</th>
                            <th align="center" width="100px">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="12" class="emptydata">Dữ liệu không tìm thấy</td>
                        </tr>                     
                    </tbody>
                </table>
                <?php
                    }
                ?>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    function onExport(){
        jQuery("#table2excel").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name"
        });
    }
    $('input[name=date_from]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: ''//HH:mm:ss
    });
    $('input[name=date_to]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: '',//HH:mm:ss
        /*onSelect: function(date){
            var date2 = $('input[name=date_to]').datetimepicker('getDate');
            date2.setDate(date2.getDate()+1);
            $('input[name=date_to]').datetimepicker('setDate', date2);
        }*/
    });
    
    /*$('input[name=date_to]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'HH:mm:ss',
        /*onSelect: function(date){
            var date2 = $('input[name=date_to]').datetimepicker('getDate');
            date2.setDate(date2.getDate()+1);
            $('input[name=date_to]').datetimepicker('setDate', date2);
        }
    });*/
    function onSubmit(url){
        var date_from = $("input[name=date_from]").val();
        var date_to = $("input[name=date_to]").val();
        var server = $("select[name=server]").val();
        if(server==0){
            Lightboxt.showemsg('Thông báo','<b>Vui lòng chọn máy chủ</b>', 'Đóng');
        }
        $.ajax({
            url:url,
            type:"POST",
            data:{server:server,date_from:date_from,date_to:date_to},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                if(typeof f.error!="undefined"&&f.error==0){
                    $(".loadData").html(f.html);
                    $('.loading_warning').hide();
                    $(".loadExport").html('<input type="button" value="Xuất Excel" class="btn btn-primary" onclick="onExport();"/>');
                }else{
                    Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
                    $(".loadData").html(f.html);
                    $('.loading_warning').hide();
                }
            }
        });
    }
</script>