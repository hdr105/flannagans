
<div class="page-content-wrapper">

<div class="page-content">




	<div class="page-bar" style="background-color:#ffffff; !important">
       <ul class="page-breadcrumb">
           <li>
               <a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('main'); ?></a>
               <i class="fa fa-circle"></i>
           </li>
           <li>
               <span><?php echo $this->lang->line('tool_language_manager');?></span>
           </li>
       </ul>
                     
    </div>

<h3 class="page-title"><?php echo $this->lang->line('tool_language_manager');?></h3>
<div class="portlet light bordered">

    <div class="portlet-title" style="height: 52px;">
    
    
        <div class="pull-left">
	         
	            <a href="<?php echo base_url(); ?>index.php/admin/component/builder" class="btn btn-sm green"> <?php echo $this->lang->line('components'); ?> </a>
	            <a href="<?php echo base_url(); ?>index.php/admin/component/groups" class="btn btn-sm green"> <?php echo $this->lang->line('group_component'); ?> </a>
	            <a href="<?php echo base_url(); ?>index.php/admin/table/index" class="btn btn-sm green"><?php echo $this->lang->line('table_builder'); ?></a>
	            <a href="<?php echo base_url(); ?>index.php/admin/language/index" class="btn btn-sm green"> <?php echo $this->lang->line('language_manager'); ?> </a>


	           
	        
        </div>
        <div class="pull-right">
            <div class="btn-group">
               <a class="btn"  onclick="back();">   <i class="icon-arrow-left"></i>  <?php echo $this->lang->line('back'); ?>  &nbsp; </a>
                <a class="btn btn-info" onclick="translateLanguage();" > &nbsp;  <i class="icon-ok icon-white"></i>  <?php echo $this->lang->line('save'); ?> &nbsp; </a>
            </div>
        </div>
            

    </div>






<div class="portlet-body">    
        <form id="frm_translate">
        	<input type="hidden" name="language_code" value="<?php echo $rs['language_code']; ?>" />
	        <table class="table-striped" style="width:100%;">
	        <col style="width:30%;" />
	        <thead>
	        <tr>
	        	<th style="text-align: left;">Default</th>
	        	<th style="text-align: left;"><?php echo htmlspecialchars($rs['language_name']); ?></th>
	        </tr>
	        </thead>
	        <?php foreach($lang_default as $key => $language){
	        	if ($key == 'date_text') continue;
	        	?>
	        	<tr>
	        		<td><?php echo htmlspecialchars($language);?></td>
	        		<td><input type="text" name="<?php echo htmlspecialchars($key); ?>" style="width: 98%;" value="<?php 
	        		if (isset($lang[$key])){
	        			echo str_replace('"', '&quot;', $lang[$key]);
	        		}else{
						echo '';
					} ?>"></td>
	        	</tr>
			<?php }?>
			</table>
        </form>
</div>
</div>
</div>
</div>
</div>
    
<script>
function back() {
    window.location = "<?php echo base_url(); ?>index.php/admin/language/index?xtype=index";
}

function translateLanguage(){
	$('.alert').remove();
	$.post(window.location.href,$('#frm_translate').serialize(),function(o){
		if (o.error == 0){
			var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;">' +
	        '<button data-dismiss="alert" class="close" type="button">×</button>' +
	        '<?php echo $this->lang->line('you_successfully_saved');?>' +
	        '</div>';
	        var alertSuccess = $(strAlertSuccess).appendTo('body');
	        alertSuccess.show();
	        
	        setTimeout(function(){ 
	            alertSuccess.remove();
	        },2000);
		}else{
			var strAlertSuccess = '<div class="alert alert-error" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;">' +
	        '<button data-dismiss="alert" class="close" type="button">×</button>' +
	        o.error_message +
	        '</div>';
	        var alertSuccess = $(strAlertSuccess).appendTo('body');
	        alertSuccess.show();
		}
        
	},'json');	
}

</script>