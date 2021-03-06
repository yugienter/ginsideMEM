<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <?php include_once 'include/toolbar.php'; ?>
        <div class="filter">
            <select name="game">
                <option value="" <?php echo ($arrFilter['game']=='')?'selected="selected"':'';?>>Chọn game</option>
                <?php
                    if(empty($slbGame) !== TRUE){
                        foreach($slbGame as $v){
                            if((@in_array($v['app_name'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2) || (@in_array($v['app_name'], $_SESSION['permission']) && $_SESSION['account']['id_group']==3) || $_SESSION['account']['id_group']==1){
                ?>
                <option value="<?php echo $v['app_name'];?>" <?php echo ($arrFilter['game']==$v['app_name'])?'selected="selected"':'';?>><?php echo $v['app_fullname'];?></option>
                <?php
                            }
                        }
                    }
                ?>
            </select>
            <?php 
                $lnkFilter = "onSubmitForm('appForm','".base_url()."?control=".$_GET['control']."&func=".$_GET['func']."&module=all&type=filter')";
            ?>
            <input type="button" onclick="<?php echo $lnkFilter; ?>" value="Tìm" class="btnB btn-primary"/>   
        </div>
        
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th align="center">Game</th>
                    <th align="center" width="150px">Ngày bắt đầu</th>
                    <th align="center" width="150px">Ngày kết thúc</th>
					<th align="center" width="70px">Trạng thái</th>
					<th align="center" width="70px">Duyệt Test</th>
					<th align="center" width="70px">Hoàn tất</th>
                    <th align="center" width="70px">Duyệt public</th>
                    <th align="center" width="100px">Chức năng</th>
                    <th align="center" width="70px">ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($listItems) !== TRUE){
                        foreach($listItems as $i=>$v){
                ?>
                <tr>
                    <td><?php echo $v['app_fullname'];?></td>
                    <td><?php echo date_format(date_create($v['start']),"d-m-Y G:i:s"); ?></td>
                    <td><?php echo date_format(date_create($v['end']),"d-m-Y G:i:s"); ?></td>
                    
                    <td>
                        <?php
                            $imgActive = ($v['status']==1)?'active.png':'inactive.png';
                            echo '<a title="Duyệt">
                                    <img border="0" title="Duyệt" src="'.base_url().'assets/img/'.$imgActive.'"> 
                                </a>';
                        ?>
                        
                    </td>
                    <td>
                        <?php
                            $imgActive = ($v['publisher']==1)?'active.png':'inactive.png';
                            echo '<a title="Publisher">
                                    <img border="0" title="Publisher" src="'.base_url().'assets/img/'.$imgActive.'"> 
                                </a>';
                        ?>
                        
                    </td>
					<td>
                        <?php
                            $imgActive = ($v['doned']==1)?'active.png':'inactive.png';
                            echo '<a title="Doned">
                                    <img border="0" title="Doned" src="'.base_url().'assets/img/'.$imgActive.'"> 
                                </a>';
                        ?>
                        
                    </td>
					<td>
                        <?php
                            $imgActive = ($v['approved']==1)?'active.png':'inactive.png';
                            echo '<a title="Approved">
                                    <img border="0" title="Approved" src="'.base_url().'assets/img/'.$imgActive.'"> 
                                </a>';
                        ?>
                        
                    </td>
                    <td>
                        <?php
                            if($_GET['page']>1){
                                $page  = '&page='.$_GET['page'];
                            }
                            $btnEdit = '
                                <a href="'.base_url()."?control=".$_GET['control']."&func=edit&id=".$v['id'].$page.'" title="Sửa">
                                    <img border="0" title="Sửa" src="'.base_url().'assets/img/icon_edit.png"> 
                                </a>';
                            $btnInfo = '<a href="'.base_url()."?control=".$_GET['control']."&func=edit&id=".$v['id'].$page.'" title="Sửa">
                                    <img border="0" title="Sửa" src="'.base_url().'assets/img/info.png"> 
                                </a>';
                            $btnDelete ='
                                <a onclick="if(!window.confirm(\'Bạn có muốn xóa này không ?\')) return false;" href="'.base_url()."?control=".$_GET['control']."&func=delete&id=".$v['id'].'" title="Xóa">
                                    <img border="0" title="Xóa" src="'.base_url().'assets/img/icon_del.png"> 
                                </a>';
                            //($_SESSION['account']['id_group']==3 && $v['approved']==0) || ($_SESSION['account']['id_group']==2 && $v['approved']==0) ||
                            if((@in_array('approved_gapi', $_SESSION['permission']) && $v['approved']==0 && $_SESSION['account']['id_group']==2) ||  $_SESSION['account']['id_group']==1){
                                echo $btnEdit;
                            }else{
                                echo $btnInfo;
                            }
                            
                        ?>
                        
                        
                    </td>
                    <td><?php echo $v['id'];?></td>
                </tr>
                <?php
                        }
                    }else{
                ?>
                <tr>
                    <td colspan="11" class="emptydata">Dữ liệu không tìm thấy</td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
        <?php echo $pages?>
    </form>
</div>