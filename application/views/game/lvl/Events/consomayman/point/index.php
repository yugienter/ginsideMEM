<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            getData();

            $('#create').on('click', function () {
                window.location.href = '/?control=consomayman_lvl&func=add&view=<?php echo $_GET['view'];?>&module=all';
            });
        });

        function getData() {
            $.ajax({
                url: "<?php echo $url_service; ?>/cms/consomayman/index_<?php echo $_GET['view'];?>",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        "aaData": data.rows
                        ,
                        aoColumns: [
                            {
                               sTitle: "ID",
                               mData: "id"
                           },
                             {
                                 sTitle: "Character ID",
                                 mData: "char_id"
                             },
                             {
                                sTitle: "Server ID",
                                mData: "server_id",

                            },
                            {
                                sTitle: "Character Name",
                                mData: "char_name"
                            },
                             {
                                 sTitle: "Mobo Service ID",
                                 mData: "mobo_service_id",

                             },
                            {
                                sTitle: "Điểm",
                                mData: "user_point",
                            },
                            {
                                sTitle: "Ngân lượng",
                                mData: "user_money",
                            },
                            {
                                sTitle: "Ngày cập nhật",
                                mData: "update_date",
                            },
                            {
                                sTitle: "Tùy Chọn",
                                mData: "id",
                                mRender: function (data) {
                                    return "<a class='btn btn-success btn-xs' href='/?control=consomayman_lvl&func=edit&view=<?php echo $_GET['view'];?>&module=all&id=" + data + "'>Sửa</a>\n\
                                            <a class='btn btn-danger btn-xs' onclick=\"if(!window.confirm('Bạn có muốn xóa không ?')) return false;\" href='/?control=consomayman_lvl&func=delete&view=<?php echo $_GET['view'];?>&module=all&id=" + data + "'>Xóa</a>";
                                }
                             }
                        ],
                        bProcessing: true,
                        bPaginate: true,
                        bJQueryUI: false,
                        bAutoWidth: false,
                        bSort: false,
                        bRetrieve: true,
                        bDestroy: true,
                        sPaginationType: "full_numbers"
                    });
                }
            });
        }
    </script>
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include APPPATH . 'views/game/lvl/Events/consomayman/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                         <div style="margin-top: 10px; margin-bottom: 10px;">
                            <button id="create"  class="btn btn-primary"><span>THÊM MỚI</span></button>
                        </div>                               
                        <table class="table table-striped table-bordered" id="data_table"></table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>