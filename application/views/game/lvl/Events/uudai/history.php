<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
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
    </style>
    <script type="text/javascript">
        
        $(document).ready(function () {
            getData();
			$('#create').on('click', function () {
					window.location.href = '/?control=uudai_lvl&func=excel&module=all';
			});
        });
		
        function getData() {
            $("#loading_img").show();
            $.ajax({
                url: "http://game.mobo.vn/volam/cms/tooluudai/get_exchange_history",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table_send').dataTable({
                        "aaData": data.rows
                        ,
                        aoColumns: [
                                 {
                                     sTitle: "Mã GD",
                                     mData: "id"
                                 },                              
                                {
                                    sTitle: "Server Id",
                                    mData: "server_id",

                                },
                                {
                                    sTitle: "Character ID",
                                    mData: "character_id",

                                },
                                {
                                    sTitle: "MSI",
                                    mData: "mobo_service_id",

                                },
                                {
                                    sTitle: "Tên Nhân Vật",
                                    mData: "character_name",
                                },
                                {
                                    sTitle: "KNB",
                                    mData: "cardvalue",
                                },
								{
                                    sTitle: "Mệnh giá",
                                    mData: "amount",
                                },
								{
                                    sTitle: "KNB Nhận",
                                    mData: "items",
                                },
                                {
                                    sTitle: "Trạng Thái",
                                    mData: "status_send",
                                    mRender: function (data) {
                                        return (data == 1) ? "<span style='color:green'>Thành Công</span>" : "<span style='color:red'>Thất Bại</span>";
                                    }
                                },
                                {
                                    sTitle: "Thời Gian",
                                    mData: "createDate",
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
            
            $(".loading").fadeOut("fast");
        }

        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/lvl/Events/uudai/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
					<div style="margin-top: 10px; margin-bottom: 10px;">
                            <button id="create"  class="btn btn-primary"><span>Xuất Excel</span></button>
                        </div>
                    <div class="table-overflow">
                        <table class="table table-striped table-bordered" id="data_table_send">
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<script type="text/javascript">
    (new TableDnD).init("tblsort");
</script>
