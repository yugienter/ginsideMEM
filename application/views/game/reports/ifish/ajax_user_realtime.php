<div class="line_date">
    <a href="javascript:;" onclick="fixture.changeDate('<?php echo date('Y-m-d', $prevUnixTime); ?>')" class="txt_gray">Ngày trước </a>&nbsp; | &nbsp;
    <span class="txt_green"><b>
            <?php
            $day = date('N', $currUnixTime) + 1;
            $date = date('d/m/Y', $currUnixTime);
            if ($day == 8)
                echo "Chủ nhật - $date";
            else
                echo "Thứ $day - $date";
            ?>
        </b> 
    </span> &nbsp; | &nbsp;
    <a href="javascript:;" onclick="fixture.changeDate('<?php echo date('Y-m-d', $nextUnixTime); ?>')" class="txt_gray">Ngày sau</a> <span class="icon_portal_thethao icon_view_more">&nbsp;</span>
</div>
<div class="content_table">
    <table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
        <thead>
            <tr>
                <th align="center" width="50px">STT</th>
                <th align="center" width="50px">Ngày</th>
                <th align="center" width="130px">Số lượng User mới nhận được sò</th>
                <th align="center" width="100px">Số lượng User đang có sò</th>
                <th align="center" width="110px">Tổng lượng sò phát sinh trong ngày</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if(count($listItems)>0){
                    $i=0;
                    foreach($listItems as $key=>$v){
                        $i++;
            ?>
            <tr>
                <td><?php echo $i;?></td>
                <td><?php  echo date_format(date_create($v['Date']),"d-m-Y");?></td>
                <td><?php echo $v["NewUserIngot"]>0?number_format($v['NewUserIngot']):"0";?></td>
                <td><?php echo $v["UserIngot"]>0?number_format($v['UserIngot']):"0"?></td>
                <td><?php echo $v["TotalNewIngot"]>0?number_format($v['TotalNewIngot']):"0"?></td>
            </tr>
            <?php
                    }
                }else{
            ?>
            <tr>
                <td colspan="5" style="color:red;text-align: center;">Dữ liệu không tìm thấy</td>
            </tr> 
            <?php
                }
            ?>                 
        </tbody>
    </table>
</div>


