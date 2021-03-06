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
			$('#create_boxitem').on('click', function () {
                window.location.href ='?control=fish_buycard&func=add&view=item';
            });
           
        });

        function getData() {
            $.ajax({
                url: "<?php echo $url;?>/event/buycard/getlistitem?type=item",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        "aaData": data.data.rows
                        ,
                        aoColumns: [
                            {
                                sTitle: "Id",
                                mData: "idx"
                            },
                            {
                                sTitle: "Mệnh Giá",
                                mData: "menhgia"
                            },
                            {
                                sTitle: "Sò",
                                mData: "so",
                            },
							{
                                sTitle: "Order",
                                mData: "order"
                            },
                            {
                                sTitle: "Status",
                                mData: "status",
                                mRender: function(data){
                                    return (data == 1) ? "<span style='color:green'>Enable</span>" : "<span style='color:red'>Disable</span>";
                                }

                            },
							<?php
								if((@in_array($_GET['control'].'-edit', $_SESSION['permission']) && $_SESSION['account']['id_group']==2) || $_SESSION['account']['id_group']==1){
							?>
                            {
                                sTitle: "Action",
                                mData: "idx",
                                mRender: function(data){
                                    return "<a href='?control=fish_buycard&func=edit&view=item&ids="+data+"'>Edit</a> <span style='padding-left:10px'></span>";
                                }
                            }
							<?php
								}
							?>
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
            <?php include APPPATH . 'views/game/fish/Events/toolbuycard/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">    
					<?php
						if((@in_array($_GET['control'].'-add', $_SESSION['permission']) && $_SESSION['account']['id_group']==2) || $_SESSION['account']['id_group']==1){
					?>
					<div style="margin-top: 10px; margin-bottom: 10px;">
                        <button id="create_boxitem"  class="btn btn-primary"><span>THÊM MỚI ITEMS</span></button>
                    </div> 
					<?php } ?>
                    <table class="table table-striped table-bordered" id="data_table">      
                    </table>
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