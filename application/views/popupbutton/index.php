<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<script type="text/javascript">
    function loadPage(area, url){
        $(area).load(url);
    }
</script>
<style>
@media (min-width:320px){
	.divmobile table{
		width:260px !important;
		margin-left:0px !important;
	}
	#div_msg table{
		margin-left:0px;
	}
	.td_mobile{
		display:none !important;
	}
	.table1 tr td input[type='text']{
		width:250px !important;
	}
	.rows{
		padding-top:5px;
	}
}
</style>
<div class="loading_warning"></div>

<script language="javascript" type="text/javascript">
$(document).ready(function() {
                $('#top').css('display','none');
				$('#footer').css('display','none');
				$('#left').css('display','none');
				
				/*if(document.getElementById('melogin_off').checked==true){
					document.getElementById('link').readOnly=false;
					document.getElementById('message').readOnly=false;
				}*/
				if(document.getElementById('cbo_state').value=='NORMAL_STATE'){
					document.getElementById('link').readOnly=false;
					document.getElementById('message').readOnly=false;
				}
            });
</script>
<form name="frm" enctype="multipart/form-data" method="post" action="<?php echo base_url()."?control=popupbutton&func=add&id=".$_GET['id']."&mebutton=".$_GET['mebutton']."&mechat=".$_GET['mechat']."&meevent=".$_GET['meevent']."&megame=".$_GET['megame']."&melogin=".$_GET['melogin']."&memsg=".$_GET['memsg'];?>">
<div class="divmobile">
<table width="100%" height="100px" class="table_mobile">
	<tr style="border-bottom:groove 1px #000000;">
    	<td><strong>Me Button</strong></td>
        <td><strong>Me Chat</strong></td>
        <td><strong>Me Event</strong></td>
        <td><strong>Me Game</strong></td>
       <!-- <td><strong>Me Login</strong></td>-->
        <td><strong>Me <br />GM</strong></td>
    </tr>
    <tr style="border-bottom:groove 1px #000000;">
    	<td><input type="radio" name="mebutton" id="mebutton_on" value="on"/> On 
<input type="radio" name="mebutton" id="mebutton_off" value="off"/> Off</td>
<td><input type="radio" name="mechat" id="mechat_on" value="on"/> On 
<input type="radio" name="mechat" id="mechat_off" value="off"/> Off</td>
<td><input type="radio" name="meevent" id="meevent_on" value="on"/> On 
<input type="radio" name="meevent" id="meevent_off" value="off" /> Off</td>
<td><input type="radio" name="megame" id="megame_on" value="on"/> On 
<input type="radio" name="megame" id="megame_off" value="off" /> Off</td>
<!--<td><input type="radio" name="melogin" id="melogin_on" value="on" onchange="showtextbox(true);"/> On 
<input type="radio" name="melogin" id="melogin_off" value="off" onchange="showtextbox(false);" /> Off</td>-->
<td><input type="radio" name="megm" id="megm_on" value="on"/> On 
<input type="radio" name="megm" id="megm_off" value="off" /> Off</td>
    </tr>
</table>
</div> <!--divmobile-->
<div id="div_msg" style="margin-top:15px;">
<table class="table1">
	<tr>
    	<td colspan="5">Nếu State khác NORMAL_STATE<br />( Vui lòng nhập thông tin bên dưới)</td>
    </tr>
    <tr class="cls_l">
    	<td class="td_mobile">Link:</td>
        <td colspan="4"><input type="text" name="link" id="link" style="width:500px;" value="<?php echo $_POST['link'] ?>" maxlength="125" placeholder="http(s)://your_url/?channel={channel}" /></td>
    </tr>
    <tr class="cls_l">
    	<td class="td_mobile">Message:</td>
        <td colspan="4"><input type="text" name="message" id="message" style="width:500px;" value="<?php echo $_POST['message'] ?>" maxlength="125" placeholder="Nhập nội dung" /></td>
    </tr>
</table>
</div>
<div class="rows">	
    <label for="menu_group_id">Chọn State</label><br />
    <select name="cbo_state" id="cbo_state" onchange="showtextbox(this.value)">
        <option value="NORMAL_STATE" <?php echo $api_view_msv['data'][0]['state']=="NORMAL_STATE"?"selected":""; ?> >NORMAL_STATE</option>
        <option value="FORCE_UPDATE_STATE" <?php echo $api_view_msv['data'][0]['state']=="FORCE_UPDATE_STATE"?"selected":""; ?> >FORCE_UPDATE_STATE</option>
        <option value="INFORMATION_UPDATE_STATE" <?php echo $api_view_msv['data'][0]['state']=="INFORMATION_UPDATE_STATE"?"selected":""; ?> >INFORMATION_UPDATE_STATE</option>
    </select>
    <div class="option_error"></div>
</div>
<div class="rows">	
    <label for="menu_group_id">Chọn Status</label><br />
    <select name="cbo_status" id="cbo_status">
        <?php
            if(count($loadstatus)>0){
                foreach($loadstatus as $key=>$value){
        ?>
        <option value="<?php echo $key;?>" <?php echo $api_view_msv['data'][0]['status']==$key?"selected":""; ?> ><?php echo $value;?></option>
        <?php
                }
            }
        ?>
    </select>
    <div class="option_error"></div>
</div>
<input type="hidden" class="type_game" value="<?php echo $_GET['type_game'];?>"/>
<div id="div_button" style="text-align:center;padding-top:30px;">
<input type="button" class="btnB btn-primary" name="btnsubmit" value="Save" onclick="actionAjax('<?php echo $_GET['id']; ?>',document.getElementById('mebutton_on').checked,document.getElementById('mechat_on').checked,document.getElementById('megame_on').checked,document.getElementById('meevent_on').checked,'login',document.getElementById('megm_on').checked,document.getElementById('link').value,document.getElementById('message').value,document.getElementById('cbo_status').value,document.getElementById('cbo_state').value);">
<strong style="color:#F00;font-size:16px">
        <?php echo $error;?>
        </strong>
        <div id="infomess">
</div>
</div>

</form>
<script language="javascript">
function showtextbox(val){
	if(val=='NORMAL_STATE'){
		$('#div_msg').css('display','none');
	}else{
		$('#div_msg').css('display','block');
	}
	document.getElementById('link').readOnly=checkval;
	document.getElementById('message').readOnly=checkval;
}
/*function showtextbox(checkval){
	if(checkval==true){
		$('#div_msg').css('display','none');
	}else{
		$('#div_msg').css('display','block');
	}
	document.getElementById('link').readOnly=checkval;
	document.getElementById('message').readOnly=checkval;
}*/
check_button();
function check_button(){
	   me_button='<?php echo $api_view_msv['data'][0]['me_button'];?>';
	   me_chat='<?php echo $api_view_msv['data'][0]['me_chat'];?>';
	   me_event='<?php echo $api_view_msv['data'][0]['me_event'];?>';
	   me_game='<?php echo $api_view_msv['data'][0]['me_game'];?>';
	   //me_login='<?php echo $api_view_msv['data'][0]['me_login'];?>';
	   me_msg='<?php echo $api_view_msv['data'][0]['msg_login'];?>';
	   me_gm='<?php echo $api_view_msv['data'][0]['me_gm'];?>';
	   state='<?php echo $api_view_msv['data'][0]['state'];?>';
	   <?php
	   if(!empty($api_view_msv['data'][0]['msg_login']) || $api_view_msv['data'][0]['msg_login']!=''){
	   		$arrjson=$api_view_msv['data'][0]['msg_login'];
	   }else{
		    $arrjson="{\"link\":\"\",\"message\":\"\"}";
	   }
	   ?>
	   var obj = JSON.parse('<?php echo $arrjson; ?>');
	   document.getElementById('link').value=obj.link;
	   document.getElementById('message').value=obj.message;
	 
	   if(me_button=='on'){
		   document.getElementById('mebutton_on').checked=true;
	   }else{
		   document.getElementById('mebutton_off').checked=true;
	   }
	   if(me_chat=='on'){
		   document.getElementById('mechat_on').checked=true;
	   }else{
		   document.getElementById('mechat_off').checked=true;
	   }
	   if(me_event=='on'){
		   document.getElementById('meevent_on').checked=true;
	   }else{
		   document.getElementById('meevent_off').checked=true;
	   }
	   if(me_game=='on'){
		   document.getElementById('megame_on').checked=true;
	   }else{
		   document.getElementById('megame_off').checked=true;
	   }
	   if(state=='NORMAL_STATE'){
		   $('#div_msg').css('display','none');
		   //document.getElementById('melogin_on').checked=true;
	   }else{
		   $('#div_msg').css('display','block');
		   //document.getElementById('melogin_off').checked=true;
	   }
	   /*if(me_login=='on'){
		   $('#div_msg').css('display','none');
		   document.getElementById('melogin_on').checked=true;
	   }else{
		   $('#div_msg').css('display','block');
		   document.getElementById('melogin_off').checked=true;
	   }*/
	   if(me_gm=='on'){
		   document.getElementById('megm_on').checked=true;
	   }else{
		   document.getElementById('megm_off').checked=true;
	   }
	   
     }
	 
	 function actionAjax(id,mebutton,mechat,megame,meevent,melogin,megm,_linktext,_mess,status,state){
		 me_b=mebutton==true?'on':'off';
		 me_c=mechat==true?'on':'off';
		 me_g=megame==true?'on':'off';
		 me_e=meevent==true?'on':'off';
		 //me_l=melogin==true?'on':'off';
		 me_l='off';
		 me_gm=megm==true?'on':'off';
		 _state=state;
		 if(_state!='NORMAL_STATE'){
			 _lnk=document.getElementById('link').value;
			 _msg=document.getElementById('message').value;
			 if(_lnk==''){
				  document.getElementById('link').focus();
				 Lightboxt.showemsg('Thông báo', 'Vui lòng nhập Url', 'Đóng');
				 return false;
			 }
			 if(_msg==''){
				  document.getElementById('message').focus();
				 Lightboxt.showemsg('Thông báo', 'Vui lòng nhập Message', 'Đóng');
				 return false;
			 }
			 //force update
		     _st=$('#cbo_status').val();
		     if(_st=='approving'){
				 Lightboxt.showemsg('Thông báo', 'Vui lòng chọn tình trạng là Approved', 'Đóng');
				 return false;
		     }
		 }else{
			 _lnk=document.getElementById('link').value;
			 _msg=document.getElementById('message').value;
			 
		 }
		service_id='<?php echo $_GET['service_id'] ?>';
                type_game = '<?php echo $_GET['type_game'];?>';
        $.ajax({
            url:'<?php echo base_url(); ?>?control=popupbutton&func=actionajax&',
            type:"POST",
            data:{type_game:type_game,service_id:service_id,id:id,mebutton:me_b,mechat:me_c,megame:me_g,meevent:me_e,melogin:me_l,megm:me_gm,linktext:_lnk,mess:_msg,status:status,state:_state},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
				//Lightboxt.showemsg('Thông báo', '<b>Vui lòng chờ ....</b>', 'Đóng');
            },
            success:function(f){
                $('#infomess').html(f.messg);
				Lightboxt.showemsg('Thông báo', '<b>'+f.messg+'</b>', 'Đóng');
				$('.loading_warning').hide();
            }
        });
    }
	
</script>
