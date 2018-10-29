<!-- <div id="container" class="container">
	<div class="container">
		<h2>Settings: General</h2>
		<div id="tab_user_manager" class="row-fluid show-grid">
			<div class="span12">
				<ul class="nav nav-tabs" style="margin-bottom: 0px;">
					<li class="active"><a href="<?php echo base_url(); ?>index.php/admin/setting/index"><?php echo $this->lang->line('general');?></a>
					</li>
					<li class="dropdown"><a class="dropdown-toggle"
						data-toggle="dropdown" href="#"><?php echo $this->lang->line('email_templates'); ?> <b class="caret"></b>
					</a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo base_url(); ?>index.php/admin/setting/email/new_user"><?php echo $this->lang->line('new_user'); ?></a>
							</li>
							<li><a href="<?php echo base_url(); ?>index.php/admin/setting/email/reset_password"><?php echo $this->lang->line('reset_password'); ?></a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	
</div> -->

<!-- nauman code starts here-->
<?php // echo "<pre>";print_r($this->lang);exit;?>
<?php $CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); ?>





 <div class="page-content-wrapper">
              
               <div class="page-content">
                  
                   <div class="page-bar" style="background-color:#ffffff; !important">
                       <ul class="page-breadcrumb">
                           <li>
                               <a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('main'); ?></a>
                               <i class="fa fa-circle"></i>
                           </li>
                           <li>
                               <span><?php echo $this->lang->line('setting_management');?></span>
                           </li>
                       </ul>
                     
                   </div>
                    
                   <h3 class="page-title"><?php echo $this->lang->line('setting_management');?><?php //echo $this->lang->line('components');?></h3>
                   
                   



<!-- nauman code ends here-->

<div class="portlet light bordered">

    
        <div class="portlet-title" >
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
      <form accept-charset="utf-8" method="post" id="SettingSaveForm" class="form-horizontal">
      
        <input type="hidden" value="<?php echo $setting_key; ?>" name="data[setting_key]">
                     
         <div class="form-body">
            <div class="panel-group accordion" id="frm_accordion">
               <div class="panel panel-default" id="section_1">
                  <div class="panel-heading">
                     <h4 class="panel-title">
                        <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#frm_accordion" href="#frm_accordion_1" aria-expanded="true"> <?php echo $this->lang->line('general_options'); ?> </a>
                     </h4>
                    
                  </div>
                  <div id="frm_accordion_1" class="panel-collapse collapse in" aria-expanded="true">
                     <div class="panel-body">
                        <div class="row">
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                <label class="control-label col-md-12   "><?php echo $this->lang->line('admin_email'); ?></label>
                                 <div class="col-md-12  col-md-8 "><input type="text" class="input-xlarge form-control"	 placeholder="<?php echo $this->lang->line('email_address'); ?>" name="data[email_address]"  id="settingAdminEmail"
												<?php if (isset($data['email_address'])){?>
													value = "<?php echo htmlspecialchars($data['email_address']); ?>"
												<?php }?> 
												/></div>
                              </div>
                           </div>
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12   "><?php echo $this->lang->line('default_group'); ?> </label>
                                 <div class="col-md-12  col-md-8 "><select id="SettingDefaultGroup"
													name="data[default_group]" class="form-control">
													<option value=""></option>
													<?php if (!empty($groups)){?>
													<?php foreach ($groups as $group){?>
														<option value="<?php echo $group['id']; ?>"
														<?php if ((int)$group['id'] == (int)$data['default_group'] ){?>
															selected="selected"
														<?php }?>
														><?php echo htmlspecialchars($group['group_name']); ?></option>	
													<?php }?>
													<?php }?>
												</select></div>
                              </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">    
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12   ">  <?php echo $this->lang->line('disable_registrations'); ?></label>
                                 <div class="col-md-12  col-md-8 "><input type="hidden" value="0" name="data[disable_registration]" />
													<input type="checkbox" value="1" name="data[disable_registration]" id = "SettingDisableRegistration" class="form-control"
													<?php if (isset($data['disable_registration']) && (int)$data['disable_registration'] == 1){?>
														checked ="checked"
												<?php }?>
													/></div>
								                	
                              </div>
                           </div>
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12   "> <?php echo $this->lang->line('disable_reset_password'); ?></label>
                                 <div class="col-md-12  col-md-8 "><input type="hidden" value="0" name="data[disable_reset_password]" />
													<input type="checkbox" value="1" class="form-control" name="data[disable_reset_password]" id = "SettingDisableResetPassword" class="form-control"
													<?php if (isset($data['disable_reset_password']) && (int)$data['disable_reset_password'] == 1){?>
														checked ="checked"
												<?php }?>
													/>
                                 </div>
                              	
                              
                              </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12   "> <?php echo $this->lang->line('require_email_activation'); ?></label>
                                 <div class="col-md-12  col-md-8 "><input type="hidden" value="0"  name="data[require_email_activation]" />
											 <input type="checkbox" value="1" name="data[require_email_activation]" class="form-control" id = "SettingRequireEmailActivation"
											 <?php if (isset($data['require_email_activation']) && (int)$data['require_email_activation'] == 1){?>
													checked ="checked"
											<?php }?>
											 /> </div>
								
                              </div>
                           </div>
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12   "> <?php echo $this->lang->line('default_language'); ?></label>
                                 <div class="col-md-12  col-md-8 "><select id="SettingDefaultLanguage" class="form-control"
									name="data[default_language]">
									<?php if (!empty($languages)){?>
									<?php foreach ($languages as $vLanguage){?>
										<option value="<?php echo $vLanguage['language_code']; ?>"
										<?php if ($vLanguage['language_code'] == $data['default_language'] ){?>
											selected="selected"
										<?php }?>
										><?php echo htmlspecialchars($vLanguage['language_name']); ?></option>	
									<?php }?>
									<?php }?>
								</select></div>
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
                        <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#frm_accordion" href="#frm_accordion_2" aria-expanded="false"> <?php echo $this->lang->line('recaptcha_options'); ?> </a>
                     </h4>
                  </div>
                  <div id="frm_accordion_2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                     <div class="panel-body">
                        <div class="row">
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12   "> <?php echo $this->lang->line('enable'); ?></label>
                                 <div class="col-md-12  col-md-8 "><input type="hidden" value="0" name="data[enable_recaptcha]"/>
								<input type="checkbox" value="1" name="data[enable_recaptcha]" id = "SettingEnableRecaptcha" class="form-control"
								<?php if (isset($data['enable_recaptcha']) && (int)$data['enable_recaptcha'] == 1){?>
									checked ="checked"
							<?php }?>
								/> </div>
								
                              </div>
                           </div>
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12   "> <?php echo $this->lang->line('public_key'); ?></label>
                                 <div class="col-md-12  col-md-8 "><input type="text" class="input-xxlarge form-control" placeholder="<?php echo $this->lang->line('public_key'); ?>" name="data[recaptcha_public_key]"
							<?php if (isset($data['recaptcha_public_key'])){?>
								value = "<?php echo htmlspecialchars($data['recaptcha_public_key']); ?>"
							<?php }?> 
							/></div>
                              </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12   "><?php echo $this->lang->line('private_key'); ?></label>
                                 <div class="col-md-12  col-md-8 "><input type="text" class="input-xxlarge form-control" placeholder="<?php echo $this->lang->line('private_key'); ?>" name="data[recaptcha_private_key]" 
							<?php if (isset($data['recaptcha_private_key'])){?>
								value = "<?php echo htmlspecialchars($data['recaptcha_private_key']); ?>"
							<?php }?> 
							/></div>
                              </div>
                           </div>
                           
                        </div>
                        <div class="clearfix"></div>
                        
                     </div>
                  </div>
               </div>
               
               
            	


            	<div class="panel panel-default" id="section_3">
                  <div class="panel-heading">
                     <h4 class="panel-title">
                        <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#frm_accordion" href="#frm_accordion_3" aria-expanded="false"> <?php echo $this->lang->line('email'); ?> </a>
                     </h4>
                  </div>
                  <div id="frm_accordion_3" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                     <div class="panel-body">
                        <div class="row">
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12   "><?php echo $this->lang->line('smtp'); ?></label>
                                 <div class="col-md-12  col-md-8 "><input type="hidden" value="0" name="data[enable_smtp]"/>
								<input type="checkbox" value="1" name="data[enable_smtp]" id = "SettingEnableSmtp" class="form-control"
								<?php if (!empty($data['enable_smtp']) && (int)$data['enable_smtp'] == 1){?>
									checked ="checked"
							<?php }?>
								/> <?php echo $this->lang->line('enable'); ?></div>
                              </div>
                           </div>
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12   "> <?php echo $this->lang->line('smtp_host'); ?></label>
                                 <div class="col-md-12  col-md-8 "><input type="text" class="input-xlarge form-control"	placeholder="<?php echo $this->lang->line('smtp_server'); ?>" name="data[smtp_host]"  id="settingSmtpHost"
							<?php if (!empty($data['smtp_host'])){?>
								value = "<?php echo htmlspecialchars($data['smtp_host']); ?>"
							<?php }?> 
							/></div>
                              </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12   "> <?php echo $this->lang->line('smtp_port'); ?></label>
                                 <div class="col-md-12  col-md-8 "><input type="text" class="input-small form-control"	placeholder="<?php echo $this->lang->line('smtp_port'); ?>" name="data[smtp_port]"  id="settingSmtpPort"
							<?php if (!empty($data['smtp_port'])){?>
								value = "<?php echo htmlspecialchars($data['smtp_port']); ?>"
							<?php }?> 
							/></div>
                              </div>
                           </div>
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12   "> <?php echo $this->lang->line('smtp_security'); ?></label>
                                 <div class="col-md-12  col-md-8 "><select name="data[smtp_auth]" class="form-change form-control">
                            	<option value=""><?php echo $this->lang->line('nothing_default'); ?></option>
                            	<option value="ssl" <?php if (!empty($data['smtp_auth']) && $data['smtp_auth'] == 'ssl'){?>
									selected="selected"
							<?php }?> ><?php echo $this->lang->line('ssl'); ?></option>
                            	<option value="tls" <?php if (!empty($data['smtp_auth']) && $data['smtp_auth'] == 'tls'){?>
									selected="selected"
							<?php }?> ><?php echo $this->lang->line('tls'); ?></option>
                          	 </select></div>
                              </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                           <div class=" col-md-6 " id="">
                                          <div class="form-group">
                                             <label class="control-label col-md-12   "> <?php echo $this->lang->line('use_smtp_authentication'); ?></label>
                                             <div class="col-md-12  col-md-8 "><input type="hidden" value="0" name="data[enable_smtp_auth]"/>
                            								<input type="checkbox" value="1" name="data[enable_smtp_auth]" id = "SettingEnableSmtpAuth" class="form-control"
                            								<?php if (!empty($data['enable_smtp_auth']) && (int)$data['enable_smtp_auth'] == 1){?>
                        									checked ="checked"
                        							<?php }?>
                        								/> <?php echo $this->lang->line('enable'); ?></div>
                                          </div>
                                       </div>
                                       <div class=" col-md-6 " id="">
                                          <div class="form-group">
                                             <label class="control-label col-md-12   "><?php echo $this->lang->line('smtp_username'); ?></label>
                                             <div class="col-md-12  col-md-8 "><input type="text" class="input-xlarge form-control"	placeholder="<?php echo $this->lang->line('smtp_account_username'); ?>" name="data[smtp_account]"  id="settingSmtpAccount"
            							<?php if (!empty($data['smtp_account'])){?>
            								value = "<?php echo htmlspecialchars($data['smtp_account']); ?>"
            							<?php }?> 
            							/></div>
                              </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                           <div class=" col-md-6 " id="">
                              <div class="form-group">
                                 <label class="control-label col-md-12   "> <?php echo $this->lang->line('smtp_password'); ?></label>
                                 <div class="col-md-12  col-md-8 "><input type="password" class="input-xlarge form-control"	placeholder="<?php echo $this->lang->line('smtp_password'); ?>" name="data[smtp_password]"  id="settingSmtpPassword"
							<?php if (!empty($data['smtp_password'])){?>
								value = "<?php echo $data['smtp_password'];?>"
							<?php }?> 
							/></div>
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
</div></div>

 <?php echo $main_footer; ?>

</div>
    

 
<script type="text/javascript">
function save_setting(){

  //console.log($('#SettingSaveForm').serialize());
	$.post('<?php echo base_url(); ?>index.php/admin/setting/save',$('#SettingSaveForm').serialize(),function(o){
		if (o.error == 0){
			$('#settingAdminEmail').parent().parent().removeClass('error');
			var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;">'
				+ '<button data-dismiss="alert" class="close" type="button">×</button>'
				+ '<?php echo $this->lang->line('successfully_changed_setting');?>'
				+ '</div>';
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
		}else if (o.error == 1){
			$('#settingAdminEmail').parent().parent().addClass('error');
			var strAlertSuccess = '<div class="alert alert-error" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;">'
				+ '<button data-dismiss="alert" class="close" type="button">×</button>'
				+ '<strong><?php echo $this->lang->line('error'); ?>!</strong> '+o.error_message
				+ '</div>';
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
		}
	},'json');
}
$(document).ready(function(){
	$('title').html($('h2').html());
});
</script>

