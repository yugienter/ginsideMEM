<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<?php
    if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
        $url_service = 'http://localhost.service.bog.mobo.vn/bog/index.php';
    }else{
        $url_service = 'http://game.mobo.vn/bog';
    }
?>
<div id="content-t" style="min-height: 500px; padding-top: 10px">
    <style>
        #loading {
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            position: fixed;
            display: block;
            z-index: 99;
        }

        #loading-image {
            position: absolute;
            top: 40%;
            left: 45%;
            z-index: 100;
        }

        label {
            width: auto !important;
            color: #f36926;
        }
        .form-group {
            float: left;
            width: 22%;
        }
        .form-group input {
            width: 70%;
        }
        .form-horizontal .form-group{
            margin-left: 0px;
            margin-right: 0px;
        }
        .form-horizontal .listItem .control-label{
            padding-right: 5px;
            width: 27% !important;
            color: green;
        }
        .form-horizontal .listItem .sublistItem .control-label{
            color: #f36926;
        }
        .form-horizontal .sublistItem{
            margin-left: 15px;
        }
        .remove_field,.remove_field_receive{
            cursor: pointer;
            color: green;
        }
        .input_fields_wrap .control-group,.input_fields_wrap_receive .control-group{
            padding-top: 15px; padding-bottom: 0px;margin-left: 0px; padding-left: 0px;border: 1px solid #ccc; padding-top:15px; padding-bottom: 15px; margin-top: 10px; margin-bottom: 10px;
        }
        .input_fields_wrap .control-group .form-group,.input_fields_wrap_receive .control-group .form-group{
            padding-bottom: 0px; margin-bottom: 0px;
        }
        .input_fields_wrap .control-group .sublistItem,.input_fields_wrap_receive .control-group .sublistItem{
            border: 0px;
            margin-bottom: 0px;
            padding-bottom: 0px;
        }
        .input_fields_wrap .control-group .sublistItem .remove_sub{
            top:4px;
        }
        .loadContent{
            text-align: center;
            color: red;
        }
        .input_fields_wrap .control-group .sublistItem .remove_sub .remove_field{
            color: #f36926 !important;
        }
        .form-horizontal .control-label{
            text-align: center;
        }
        .form-group.remove{
            width: 10%;
            position: relative;
            top:6px;
        }
        .subItems{
            margin-left: 20px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#comeback').on('click', function () {
                window.history.go(-1); return false;
            });

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "<?php echo $url_service;?>/cms/config/<?php echo $_GET['id']>0?'edit?id='.$_GET['id']:'add';?>",
                    data: $("#frmSendChest").serializeArray(),
                    beforeSend: function () {
                        $(".loading").fadeIn("fast");
                    }
                }).done(function (result) {
                    console.log(result);
                    $(".modal-body #messgage").html(result.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");

                });
            });
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/bog/Events/config/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                        <div class="well form-horizontal">
                            <h5 class="widget-name">
                            <?php
                                $end_date = gmdate('Y-m-d G:i:s',time()+7*3600);
                                if($_GET['id']>0){
                                    $end_date = $items['end_date'];
                                }
                            ?>
                            <div class="control-group">
                                <label class="control-label">Server ID:</label>
                                <div class="controls">
                                    <input name="server_id" id="server_id" value="<?php echo $items['server_id'];?>" type="text" class="span3 validate[required]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Kết thúc:</label>
                                <div class="controls">
                                    <input type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Top:</label>
                                <div class="controls">
                                    <select name="top">
                                        <option value="banghoi" <?php echo ($items['top']=='banghoi')?'selected="selected"':'';?>>Băng hội</option>
                                        <option value="dautruongcanhan" <?php echo ($items['top']=='dautruongcanhan')?'selected="selected"':'';?>>Đấu trường cá nhân</option>
                                        <option value="dautruonglienthang" <?php echo ($items['top']=='dautruonglienthang')?'selected="selected"':'';?>>Đấu trường liên thăng</option>
                                        <option value="loidaicanhan" <?php echo ($items['top']=='loidaicanhan')?'selected="selected"':'';?>>Lôi đại cá nhân</option>
                                        <option value="loidailienthang" <?php echo ($items['top']=='loidailienthang')?'selected="selected"':'';?>>Lôi đại liên thăng</option>
                                        <option value="chienluchothan" <?php echo ($items['top']=='chienluchothan')?'selected="selected"':'';?>>Chiến lực hổ thần</option>
                                        <option value="chienluc" <?php echo ($items['top']=='chienluc')?'selected="selected"':'';?>>Chiến lực</option>
                                        <option value="level" <?php echo ($items['top']=='level')?'selected="selected"':'';?>>Level</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <div style="padding-left: 20%; text-align: left;">
                                    <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                    <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                    <button id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
                                    <div style="display: inline-block">
                                        <span id="message" style="color: green"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<script>
    $('input[name=end_date]').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//HH:mm:ss
    });
</script>
