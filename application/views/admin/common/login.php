<?php $CI = & get_instance(); 
$crudUser = $CI->input->post('crudUser');
?>
<?php 
$_lang = $this->session->userdata('lang');
$_c_lang = $this->input->cookie('lang', true);

if(isset($_GET['lang'])){
	$defaultLang = $_GET['lang'];
}else if(!empty($_lang)){
	$defaultLang = $_lang;
}else if(!empty($_c_lang)){
	$defaultLang = $_c_lang;
}else{
	$this->db->select('*');
	$this->db->from('crud_settings');
	$this->db->where('setting_key',sha1('general'));
	$query = $this->db->get();
	$setting = $query->row_array();
	$setting = unserialize($setting['setting_value']);
	 
	if (!empty($setting['default_language']) && trim($setting['default_language']) != ''){
		$defaultLang = $setting['default_language'];
	}else{
		$defaultLang = '';
	}
}
?>
<div class="user-login-5">
	<div class="row bs-reset">
		<div class="row bs-reset">
			<div class="col-md-6 bs-reset">
                <div class="login-bg" style="background-image:url(../media/assets/pages/img/login/bg1.jpg)">
                        <img class="login-logo" src="<?=base_url(); ?>/media/images/<?=$com['company_logo']; ?>" />
                </div>
            </div>
            <div class="col-md-6 login-container bs-reset">
            	<div class="login-content">
                        <h1><?php echo $this->lang->line('sign_in_to_senserve_systme_name'); ?></h1>
                        <!-- <p> Lorem ipsum dolor sit amet, coectetuer adipiscing elit sed diam nonummy et nibh euismod aliquam erat volutpat. Lorem ipsum dolor sit amet, coectetuer adipiscing. </p> -->
                        <form class="login-form" method="post">
                            <?php if (!empty($crudUser)) { ?>
                            <div class="alert alert-danger">
                                <button class="close" data-close="alert"></button>
                                <strong>Error:</strong> <?php if($error==2){ echo $this->lang->line('incorrect_username_or_password'); }elseif($error==3){ echo $this->lang->line('activate_your_account'); } ?>
                            </div>   
                            <?php } ?>
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <span>Enter any username and password. </span>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="<?php echo $this->lang->line('user_name'); ?>" name="crudUser[name]" required value="<?php
		            if (isset($crudUser['name'])) {
		                echo htmlspecialchars($crudUser['name']);
		            }
		            ?>"/> </div>
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="<?php echo $this->lang->line('password'); ?>" name="crudUser[password]" required  value="<?php
                           if (isset($crudUser['name'])) {
                               echo htmlspecialchars($crudUser['password']);
                           }
            ?>"/> </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="rem-password">
                                        <p><?php echo $this->lang->line('remember_me'); ?>
                                        <input type="hidden" name="remember_me" value="0" />
                                            <input type="checkbox" class="rem-checkbox" name="remember_me" value="1" id="remember_me"
				<?php if (isset($_POST['remember_me']) && (int)$_POST['remember_me'] == 1){ ?>
					checked="checked"
				<?php } ?> />
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-8 text-right">
                                    <div class="forgot-password">
                                        <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
                                    </div>
                                    <button class="btn blue" type="submit">Sign In</button>
                                </div>
                            </div>
                        </form>
                        <!-- BEGIN FORGOT PASSWORD FORM -->
                        <form class="forget-form" action="javascript:;" method="post">
                            <h3 class="font-green">Forgot Password ?</h3>
                            <p> Enter your e-mail address below to reset your password. </p>
                            
                            
                            <div class="form-group">
                                <input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Email" id="user_email" name="user_email" /> </div>
                            <div class="form-actions">
                                <button type="button" id="back-btn" class="btn grey btn-default">Back</button>
                                <button type="submit" class="btn blue btn-success uppercase pull-right" onclick="resetPassword();">Submit</button>

                                
                            </div>
                        </form>
                        <!-- END FORGOT PASSWORD FORM -->
                </div>
                <div class="login-footer">
                        <div class="row bs-reset">
                            <!-- <div class="col-xs-5 bs-reset">
                                <ul class="login-social">
                                    <li>
                                        <a href="javascript:;">
                                            <i class="icon-social-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="icon-social-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="icon-social-dribbble"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div> -->
                            <div class="col-xs-7 bs-reset">
                                <div class="login-copyright text-right">
                                    <p>Copyright &copy;  <?php echo $this->lang->line('senserve_systme_name'); ?> <?php echo date('Y'); ?></p>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
		</div>
	</div>
</div>
<script>
<?php if ((int)$setting['disable_reset_password'] != 1){?>
function resetPassword() {
	var user_email = $('#user_email').val()
	
	$.post('<?php echo base_url(); ?>index.php/admin/send_reset_password_link',{user_email:user_email},function(o){
	    if (o.send_link == 1){
		
		    $('.forget-form p').html('<div class="alert alert-success" style="padding:8px; margin-top:10px;"><?php echo $this->lang->line('sent_password_reset_email'); ?></div>');
		                
	    }else{
	            			
	            			$('.forget-form').find('.alert-error').remove();
	            			$('.forget-form p').html('<div class="alert alert-error" style="padding:8px; margin-top:10px;"><?php echo $this->lang->line('please_provide_a_correct_email');?></div>');
	    }
	},'json');
            	
    $('.forget-form').find('input[type="text"]').each(function(){
		$(this).keypress(function(event){
			 if ( event.which == 13 ) {
			 	event.preventDefault();
			 }
		});
	});
}
<?php } ?>

</script>