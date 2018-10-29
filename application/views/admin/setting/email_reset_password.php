<!-- <div id="container" class="container">
	<div class="container">
		<h2><?php echo $this->lang->line('setting_email_new_user'); ?></h2>
		<div id="tab_user_manager" class="row-fluid show-grid">
			<div class="span12">
				<ul class="nav nav-tabs"  style="margin-bottom: 0px;">
					<li><a href="<?php echo base_url(); ?>index.php/admin/setting/index"><?php echo $this->lang->line('general'); ?></a>
					</li>
					<li class="dropdown active"><a class="dropdown-toggle"
						data-toggle="dropdown" href="#"><?php echo $this->lang->line('email_templates');?> <b class="caret"></b>
					</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url(); ?>index.php/admin/setting/email/new_user"><?php echo $this->lang->line('new_user');?></a>
							</li>
							<li><a
								href="<?php echo base_url(); ?>index.php/admin/setting/email/reset_password"><?php echo $this->lang->line('reset_password');?></a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
</div>
</div> -->

<!-- nauman code starts here-->
<?php // echo "<pre>";print_r($this->lang);exit;?>
<?php $CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); ?>
  
           <div class="page-content-wrapper">
              
               <div class="page-content">
                  
                   <div class="page-bar">
                       <ul class="page-breadcrumb">
                           <li>
                               <a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('main'); ?></a>
                               <i class="fa fa-circle"></i>
                           </li>
                           <li>
                               <span><?php echo $this->lang->line('setting_email_reset_password');?></span>
                           </li>
                       </ul>
                     
                   </div>
                    
                   <h3 class="page-title"><?php echo $this->lang->line('setting_email_reset_password');?></h3>
                    <div>
                   <?php // echo $content; ?>






<div class="portlet light bordered">
	<div class="portlet-title">
   
        
       	<div class="pull-left">
	         
	            


	           
	        
        </div>
        	<div class="pull-right">
	        	<div class="btn-group">
	                <button onclick="save_setting();" class="btn btn-primary"
								type="button"><?php echo $this->lang->line('save_change'); ?></button>
	            </div>
        	</div>
            
        
 	</div>



   <div class="portlet-body form">
      <!--BEGIN FORM-->
      <form accept-charset="utf-8" method="post" id="SettingSaveForm"
					class="form-horizontal">
        
					<input type="hidden" id="SettingSettingKey"
					value="<?php echo $setting_key; ?>"
					name="data[setting_key]">         
         <div class="form-body">
            <div class="panel-group accordion" id="frm_accordion">
               


               
             
				<div class="panel panel-default" id="section_1">
                  <div class="panel-heading">
                     <h4 class="panel-title">
                        <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#frm_accordion" href="#frm_accordion_1" aria-expanded="true">  <?php echo $this->lang->line('request'); ?> </a>
                     </h4>
                     
                     
                     
                  </div>
                  <div id="frm_accordion_1" class="panel-collapse collapse in" aria-expanded="true" >
                     <div class="panel-body">
                        <div class="row">
                           <div class=" col-md-6 " id="title_ID">
                              <div class="form-group">
                                 <label class="control-label col-md-12   " for=""><?php echo $this->lang->line('subject');?></label>
                                 <div class="col-md-12  col-md-8 "> <input type="text" id="SettingRequestSubject"
							<?php if (isset($data['request_subject'])){?>
								value = "<?php echo htmlspecialchars($data['request_subject']); ?>"
								<?php }?>
								placeholder="Subject"
							class="form-control" name="data[request_subject]"> 
								</div>
                              </div>
                           </div>
                           
                        </div>
                        <div class="row">
                           
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12   "><?php echo $this->lang->line('message_body');?></label>
                                 <div class="col-md-12  col-md-8 "><textarea id="SettingRequestBody" placeholder="Message body"
							rows="10" class="input-xlarge" name="data[request_body]"><?php if (isset($data['request_body'])){
									echo htmlspecialchars($data['request_body']);  }?></textarea></div>
                              </div>
                           </div>
                           <div class=" col-md-6 " id="">
	                           	<div class="form-group">
	                                 <label class="control-label col-md-12  row "><?php echo $this->lang->line('short_code'); ?> </label>
			                            <div class="col-md-12  col-md-8 row style="margin: 0px; !important ">
										<p style="margin:0px !important;">
											<?php echo $this->lang->line('site_address'); ?>
											<code>{site_address}</code>
										</p>
										<p style="margin:0px !important;">
											<?php echo $this->lang->line('full_name');?>
											<code>{user_name}</code>
										</p>
										<p style="margin:0px !important;">
											<?php echo $this->lang->line('user_email'); ?>
											<code>{user_email}</code>
										</p>
									</div>
	                            </div>
                              
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        
                        
                     </div>
                  </div>
               </div>

               
               <div class="panel panel-default" id="section_2">
                  <div class="panel-heading">
                     <h4 class="panel-title">
                        <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#frm_accordion" href="#frm_accordion_2" aria-expanded="false"> Success </a>
                     </h4>
                  </div>
                  <div id="frm_accordion_2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                     <div class="panel-body">
                        <div class="row">
                           
                           <div class=" col-md-6 " id="fax_ID">
                              <div class="form-group">
                                 <label class="control-label col-md-12   "><?php echo $this->lang->line('subject');?></label>
                                 <div class="col-md-12  col-md-8 "><input type="text" id="SettingSuccessSubject"
							<?php if (isset($data['success_subject'])){?>
								value = "<?php echo htmlspecialchars($data['success_subject']); ?>"
								<?php }?>
							placeholder="Subject" class="form-control"
							name="data[success_subject]"></div>
                              </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12   "><?php echo $this->lang->line('message_body'); ?></label>
                                 <div class="col-md-12  col-md-8 "><textarea id="SettingSuccessBody" placeholder="Message body"
							rows="10" class="input-xlarge" name="data[success_body]"><?php if (isset($data['success_body'])){
									echo htmlspecialchars($data['success_body']);  }?></textarea></div>
                              </div>
                           </div>
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12  row "> <?php echo $this->lang->line('short_code'); ?></label>
                                 <div class="col-md-12  col-md-8 row">
								
								<p style="margin:0px !important;">
									<?php echo $this->lang->line('site_address'); ?>
									<code>{site_address}</code>
								</p>
								<p style="margin:0px !important;">
									<?php echo $this->lang->line('full_name');?>
									<code>{user_name}</code>
								</p>
								<p style="margin:0px !important;">
									<?php echo $this->lang->line('user_email'); ?>
									<code>{user_email}</code>
								</p>
								<p style="margin:0px !important;">
									<?php echo $this->lang->line('reset_link'); ?>
									<code>{reset_link}</code>
								</p>
							</div>
                              </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </div>
               </div>
               
               
               
            </div>



         </div>
      </form>
      <!--END FORM-->
   </div>
</div>
</div>
</div>
</div>
</div>

 <?php echo $main_footer; ?>




	<script type="text/javascript">
function save_setting(){
	$.post('<?php echo base_url(); ?>index.php/admin/setting/save',$('#SettingSaveForm').serialize(),function(o){
		var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;">'
			+ '<button data-dismiss="alert" class="close" type="button">×</button>'
			+ '<?php echo $this->lang->line('successfully_changed_setting');?>'
			+ '</div>';
		var alertSuccess = $(strAlertSuccess).appendTo('body');
		alertSuccess.show();
		setTimeout(function() {
			alertSuccess.remove();
		}, 2000);
	},'json');
}
$(document).ready(function(){
	$('title').html($('h2').html());
});
</script>
