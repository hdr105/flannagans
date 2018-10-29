			<?php
				$user_first_name	=	$profile_data['user_first_name'];
				$user_las_name		=	$profile_data['user_las_name'];
				$user_email			=	$profile_data['user_email'];
				$profile_image		=	$profile_data['profile_image'];
				$user_name			=	$profile_data['user_name'];
				$group_id			=	$profile_data['group_id'];
			?>
			<div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="<?php echo base_url(); ?>">Dashboard </a><i class="fa fa-circle"></i>
                            </li>
                            <li>
								<span>Edit Profile</span>   
							</li>
                        </ul>
                    </div>
                	<h3 class="page-title"> Edit Profile</h3>
					<div class="row">
						<div class="col-md-12">
							<div class="portlet light bordered">
								<div id="frm_accordion" class="panel-group accordion">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a href="#frm_accordion_1" data-parent="#frm_accordion" data-toggle="collapse" class="accordion-toggle accordion-toggle-styled <?php if(isset($_GET['p'])) echo "collapsed";?>" aria-expanded="<?php if(!isset($_GET['p'])) echo "false"; else echo "true";?>"> Edit Profile </a>
											</h4>
										</div>
										<form action="<?php echo base_url(); ?>index.php/admin/profile/saveprofile" method="POST" onsubmit="return validateformprofile();" enctype="multipart/form-data" class="form-horizontal">
											<div class="panel-collapse collapse <?php if(!isset($_GET['p'])) echo "in"; ?>" id="frm_accordion_1" aria-expanded="<?php if(!isset($_GET['p'])) echo "false"; else echo "true";?>" style="">
												<div class="panel-body">
													<div class="row">
													<?php if($group_id=='1'){ ?>
														<div class=" col-md-6 ">
															<div class="form-group">
																<label class="control-label col-md-4">Username</label>
																<div class="col-md-12  col-md-8 ">
																	<input type="text" class="form-control" name="user_name" id="user_name" value="<?php echo $user_name;?>"/>
																</div>
															</div>
														</div>
													<?php } ?>
														<div class=" col-md-6 ">
															<div class="form-group">
																<label class="control-label col-md-4">First Name</label>
																<div class="col-md-12  col-md-8 ">
																	<input type="text" class="form-control" name="user_first_name" id="user_first_name" value="<?php echo $user_first_name;?>"/>
																</div>
															</div>
														</div>
														<div class=" col-md-6 ">
															<div class="form-group">
																<label class="control-label col-md-4">Last Name</label>
																<div class="col-md-12  col-md-8 ">
																	<input type="text" class="form-control" name="user_las_name" id="user_las_name" value="<?php echo $user_las_name;?>"/>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label col-md-6"> Email Address </label>
																<div class="col-md-12  col-md-8">
																	<input type="text" class="form-control" name="user_email" id="user_email" value="<?php echo $user_email;?>"/>
																</div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label col-md-6"> Profile Picture </label>
																<div class="col-md-8">
																	<input type="file" accept="image/*" class="form-control" name="profile_image"/>
																</div>
																<div class="col-md-4">
																	<?php if(isset($profile_image) && !empty($profile_image)){ ?>
																		<img src="<?php echo base_url() . 'media/files/profile_images/' . $profile_image; ?>" alt="Profile Image"  style="width:100px; height:100px;">
																		<a href="<?php echo base_url(); ?>index.php/admin/profile/deleteimage" class="btn btn-sm red" style="width:100px; margin-top:5px;">REMOVE</a>
																	<?php } else { ?>
																		<img src="http://placehold.it/100x100" alt="Profile Image" style="width:100px; height:100px;">
																	<?php } ?>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-2 pull-right">
															<input type="submit" class="btn btn-sm blue pull-right" name="submit" value="Save Profile"/>
														</div>
													</div>
													<div class="clearfix"></div>
												</div>
											</div>
										</form>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a href="#frm_accordion_2" data-parent="#frm_accordion" data-toggle="collapse" class="accordion-toggle accordion-toggle-styled <?php if(!isset($_GET['p'])) echo "collapsed";?>" aria-expanded="<?php if(isset($_GET['p'])) echo "false"; else echo "true";?>"> Change Password</a>
											</h4>
										</div>
										<div class="panel-collapse collapse <?php if(isset($_GET['p'])) echo "in"; ?>" id="frm_accordion_2" aria-expanded="<?php if(isset($_GET['p'])) echo "false"; else echo "true";?>" style="">
											<form action="<?php echo base_url(); ?>index.php/admin/profile/savepassword" method="POST" onsubmit="return validateformpassword();" enctype="multipart/form-data" class="form-horizontal">
												<div class="panel-body">
													<div class="row">
														<div class=" col-md-6 ">
															<div class="form-group">
																<label class="control-label col-md-4">Old Password</label>
																<div class="col-md-12  col-md-8 ">
																	<input type="text" class="form-control" name="old_pass" id="old_pass" value=""/>
																	<input type="hidden" class="form-control" name="old_pass_check" id="old_pass_check" value="0"/>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class=" col-md-6 ">
															<div class="form-group">
																<label class="control-label col-md-4">New Password</label>
																<div class="col-md-12  col-md-8 ">
																	<input type="text" class="form-control" name="new_pass" id="new_pass" value=""/>
																</div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label col-md-6"> Confirm Password </label>
																<div class="col-md-12  col-md-8">
																	<input type="text" class="form-control" name="con_pass" id="con_pass" value=""/>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-2 pull-right">
															<input type="submit" class="btn btn-sm blue" name="submit" value="Change Password"/>
														</div>
													</div>
													<div class="clearfix"></div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<script>
				function validateformprofile(){
					var user_first_name 	= $('#user_first_name').val();
					var user_las_name	 	= $('#user_las_name').val();
					var user_email		 	= $('#user_email').val();
					var user_name		 	= $('#user_name').val();
					
					if(user_name == ''){
						bootbox.alert('Please Enter Username.');
						return false;
					}
					
					/* if(user_first_name == ''){
						bootbox.alert('Please Enter First Name.');
						return false;
					}
					
					if(!user_first_name.match(/^[a-zA-Z ]*$/)){
						bootbox.alert('Please Enter Valid First Name.');
						return false;
					}
					 
					if(user_las_name == ''){
						bootbox.alert('Please Enter Last Name');
						return false;
					}
					
					if(!user_las_name.match(/^[a-zA-Z ]*$/)){
						bootbox.alert('Please Enter Valid Last Name');
						return false;
					}
					*/
					
					if(user_email == ''){
						bootbox.alert('Please Enter Email Address');
						return false;
					}

					if(!user_email.match(/^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i)){
						bootbox.alert('Please Enter Valid Email Address');
						return false;
					}
					return true;
				}
	
				function validateformpassword(){
					var old_pass 		= $('#old_pass').val();
					var old_pass_check 	= $('#old_pass_check').val();
					var new_pass		= $('#new_pass').val();
					var con_pass		= $('#con_pass').val();
					
					if(old_pass == ''){
						bootbox.alert('Please Enter Old Password.');
						return false;
					}
					
					if(old_pass_check != '1'){
						bootbox.alert('Old Password Donot Match.');
						return false;
					}
					
					if(new_pass == ''){
						bootbox.alert('Please Enter New Password.');
						return false;
					}
					
					if(con_pass == ''){
						bootbox.alert('Please Enter Confirm Password.');
						return false;
					}
					
					if(con_pass != new_pass){
						bootbox.alert('Password do not match.');
						return false;
					}
					return true;
				}
				
				$( "#old_pass" ).keyup(function() {
					$.post('<?php echo base_url(); ?>index.php/admin/profile/pass_check?old_pass='+$( "#old_pass" ).val(), function(data){
						if(data == 'false'){
							$('#old_pass_check').val('0');
						} else {
							$('#old_pass_check').val('1');
						}
					});
				});
			</script>