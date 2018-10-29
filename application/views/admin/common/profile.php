			<?php
				//SESSION DATA STARTS HERE // GROUPS : 1 FOR ADMIN, 2 FOR EMPLOYEE, 3 FOR CLIENT
				$CRUD_AUTH			= 	$this->session->userdata('CRUD_AUTH');
				$group_name 		= 	$CRUD_AUTH['group']['dashboard'];
				//SESSION DATA ENDS HERE
				
				//DATA FROM THE TABLE FOR THIS USER STARTS
				$user_first_name	=	$profile_data['user_first_name'];
				$user_las_name		=	$profile_data['user_las_name'];
				$user_email			=	$profile_data['user_email'];
				$profile_image		=	$profile_data['profile_image'];
				$user_name			=	$profile_data['user_name'];
				$group_id			=	$profile_data['group_id'];
				//DATA FROM THE TABLE FOR THIS USER ENDS
				
				//GET CONFIGURATION DATA STARTS
				$table_name = 'crud_users';
				$emp_module_id = '32';
				//GET CONFIGURATION DATA ENDS
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
					<?php if(!isset($_GET['password']) && !isset($_GET['workHistory'])){?>
						<form id="profile-form" action="<?php echo base_url(); ?>index.php/admin/profile/saveprofile" method="POST" onsubmit="return validateformprofile();" enctype="multipart/form-data" class="form-horizontal">
					<?php } else if(isset($_GET['password'])){ ?>
						<form id="password-form" action="<?php echo base_url(); ?>index.php/admin/profile/savepassword" method="POST" onsubmit="return validateformpassword();" enctype="multipart/form-data" class="form-horizontal">
					<?php } else if(isset($_GET['workHistory'])){ ?>					
						<form id="password-form" action="<?php echo base_url(); ?>index.php/admin/profile?workHistory" method="POST" onsubmit="return validateformdates();" enctype="multipart/form-data" class="form-horizontal">
					<?php } ?>					
							<div class="col-md-12">
								<!--START-->
								<div class="portlet light bordered">
									<div class="portlet-title">
										<div class="pull-left col-md-5">
											<a class="btn btn-sm  <?php if(!isset($_GET['password']) && !isset($_GET['workHistory'])){ echo " blue disabled"; } else { echo "red"; }?>" href="<?php echo base_url(); ?>index.php/admin/profile"> Edit Profile </a>
											<a class="btn btn-sm  <?php if(isset($_GET['password'])){ echo " blue disabled"; } else { echo "red"; }?>" href="<?php echo base_url(); ?>index.php/admin/profile?password"> Change Password </a>
											<?php if($group_name == '2'){ ?>
												<a class="btn btn-sm  <?php if(isset($_GET['workHistory'])){ echo " blue disabled"; } else { echo "red"; }?>" href="<?php echo base_url(); ?>index.php/admin/profile?workHistory"> Working Hours </a>
											<?php } ?>
										</div>
										<div class="pull-right col-md-7">
											<?php if(isset($_GET['workHistory'])){ ?>
                                                <div class="col-md-4">
													<div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy">
														<input type="text" class="form-control" readonly name="date_from" id="date_from" value="<?php if(isset($_POST['date_from'])){ echo $_POST['date_from']; } ?>" style="width:120px;"/>
														<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
													</div>
                                                </div>
												<label class="control-label col-md-1" style="white-space: nowrap;">TO</label>
												<div class="col-md-4">
                                                    <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy">
														<input type="text" class="form-control date-picker" readonly name="date_to" id="date_to" value="<?php if(isset($_POST['date_to'])){ echo $_POST['date_to']; } ?>" style="width:120px;"/>
														<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
													</div>
													<input type="hidden" class="form-control date-picker" name="com_id" id="com_id" value="<?php if(isset($_POST['com_id'])){ echo $_POST['com_id']; } ?>"/>
												</div>
												<div class="col-md-2">
													<button type="submit" class="btn btn-sm blue" name="workHistory"/> SEARCH </button>
												</div>
											<?php } else { ?>
												<a class="btn btn-sm default pull-right" onclick="crudCancel();" href="<?php echo base_url().'index.php/admin/dashboard'; ?>">Cancel</a>
												<button type="submit" class="btn btn-sm blue pull-right" name="submit"/> Save <i class="fa fa-save"></i></button>
											<?php } ?>
										</div>
									</div>
									<div class="portlet-body">
										<div class="alert alert-error col-md-12" id="error_div" style="display:none;"></div>
										<div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
											<?php if(!isset($_GET['password']) && !isset($_GET['workHistory'])  ){?>
												<div class="row col-md-6">
													<div class=" col-md-12 ">
														<div class="form-group">
															<label class="control-label col-md-4">First Name</label>
															<div class="col-md-12  col-md-8 ">
																<input type="text" class="form-control" name="user_first_name" id="user_first_name" value="<?php echo $user_first_name;?>"/>
															</div>
														</div>
													</div>
													<div class=" col-md-12 ">
														<div class="form-group">
															<label class="control-label col-md-4">Last Name</label>
															<div class="col-md-12  col-md-8 ">
																<input type="text" class="form-control" name="user_las_name" id="user_las_name" value="<?php echo $user_las_name;?>"/>
															</div>
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label col-md-6"> Email Address </label>
															<div class="col-md-12  col-md-8">
																<input type="text" class="form-control" name="user_email" id="user_email" value="<?php echo $user_email;?>"/>
															</div>
														</div>
													</div>
												</div>
												<div class="row col-md-6">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label col-md-12 pull-right"> Profile Picture </label>
															<div class="col-md-12 pull-right">
																<?php if(isset($profile_image) && !empty($profile_image)){ ?>
																	<img src="<?php echo base_url() . 'media/files/profile_images/' . $profile_image; ?>" alt="Profile Image"  style="width:200px; height:200px;">
																	<br />
																	<a href="<?php echo base_url(); ?>index.php/admin/profile/deleteimage" class="btn btn-sm red" style="width:200px; margin-top:5px;">REMOVE</a>
																<?php } else { ?>
																	<img src="http://placehold.it/200x200" alt="Profile Image">
																<?php } ?><br />
																<a href="#" onclick="choosefile();" class="btn btn-sm blue" style="width:200px; margin-top:5px;">Browse</a>
																<input type="file" style="display:none;" accept="image/*" class="form-control" name="profile_image" id="profile_image" style="width:200px; margin-top:5px;"/>
															</div>
														</div>
													</div>
												</div>
												
												<!--EMPLOYEE DETAIL SECTION STARTS-->
												<?php if($group_name == '2'){ ?>
												<div class="row col-md-12">
													<div class=" col-md-6">
														<div class="form-group">
															<label class="control-label col-md-12">Line Manager</label>
															<div class="col-md-12  col-md-8 ">
																<?php 
																	if($profile_data['line_manager']!=0){
																		$query_manager = $this->db->get_where('crud_users',array('id'=>$profile_data['line_manager']))->row_array();
																		echo $query_manager['user_first_name']. " " .$query_manager['user_las_name'];
																	}
																	
																?>
															</div>
														</div>
													</div>
													<div class=" col-md-6">
														<div class="form-group">
															<label class="control-label col-md-12">Employment Start Date </label>
															<div class="col-md-12  col-md-8 ">
																<?php if($profile_data['emp_start_date']!='0000-00-00'){ echo date('d-m-Y',strtotime($profile_data['emp_start_date'])); } ?>
															</div>
														</div>
													</div>
													<div class=" col-md-6">
														<div class="form-group">
															<label class="control-label col-md-12">Employment End Date </label>
															<div class="col-md-12  col-md-8 ">
																<?php if($profile_data['emp_end_date']!='0000-00-00'){ echo date('d-m-Y',strtotime($profile_data['emp_end_date'])); } ?>
															</div>
														</div>
													</div>
													<div class=" col-md-6">
														<div class="form-group">
															<label class="control-label col-md-12">Holidays Entitlements </label>
															<div class="col-md-12  col-md-8 ">
																<?php echo $profile_data['holidays_entitlement']; ?>
															</div>
														</div>
													</div>
													<div class=" col-md-12">
														<div class="form-group">
															<label class="control-label col-md-12">Working Hours Schedule </label>
															<div class="col-md-12  col-md-8 ">
															<?php if(!empty($profile_data['working_hours'])){ ?>
																<div id="dataCrud_usersWorking_hours_v">
																	<div id="summary_view_container">
																		<div class="portlet box green">
																			<div class="portlet-title">
																				<div class="caption"> Working Hours </div>
																			</div>
																			<div class="portlet-body">
																				<div>
																					<table class="table table-striped table-bordered table-hover ">
																						<thead>
																							<tr>
																								<th>Working Day Start</th>
																								<th>Working Day End</th>
																								<th>Working Time Start</th>
																								<th>Working Time End</th>
																							</tr>
																						</thead>
																						<tbody>
																							<?php
																							$wrking_hours = explode(',',$profile_data['working_hours']);
																							foreach($wrking_hours as $wrking_hour){
																								if(!empty($wrking_hour)){
																									$result = $this->db->get_where('working_hrs_data',array('id'=>$wrking_hour))->row_array();
																							?>
																							<tr class="odd gradeX">
																								<td><?php echo date("l",$result['Working_Day_Start']); ?></td>
																								<td><?php if(!empty($result['Working_Day_End'])) echo date("l",$result['Working_Day_End']); ?></td>
																								<td><?php echo $result['Working_Time_Start']; ?></td>
																								<td><?php echo $result['Working_Time_End']; ?></td>
																							<tr>
																							<?php
																								}
																							}
																							?>
																						</tbody>
																					</table>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															<?php } ?>
															</div>
														</div>
													</div>
													<div class=" col-md-6">
														<div class="form-group">
															<label class="control-label col-md-12">Holidays Entitlements Start Date </label>
															<div class="col-md-12  col-md-8 ">
																<?php if($profile_data['holidays_start_date']!='0000-00-00'){ echo date('d-m-Y',strtotime($profile_data['holidays_start_date'])); } ?>
															</div>
														</div>
													</div>
													<div class=" col-md-6">
														<div class="form-group">
															<label class="control-label col-md-12">Holidays Entitlements End Date </label>
															<div class="col-md-12  col-md-8 ">
																<?php if($profile_data['holidays_end_date']!='0000-00-00'){ echo date('d-m-Y',strtotime($profile_data['holidays_end_date'])); } ?>
															</div>
														</div>
													</div>
													<div class=" col-md-6">
														<div class="form-group">
															<label class="control-label col-md-12">Employment Contract </label>
															<div class="col-md-12  col-md-8 ">
																<a href="<?php echo base_url(); ?>index.php/admin/download?file=<?php echo $profile_data['contract_file']; ?>"><?php echo $profile_data['contract_file']; ?></a>
															</div>
														</div>
													</div>
													<div class=" col-md-6">
														<div class="form-group">
															<label class="control-label col-md-12">Additional Entitlements </label>
															<div class="col-md-12  col-md-8 ">
																<?php echo $profile_data['additional_entitlements']; ?>
															</div>
														</div>
													</div>
													<div class=" col-md-6">
														<div class="form-group">
															<label class="control-label col-md-12">Special Notes </label>
															<div class="col-md-12  col-md-8 ">
																<?php echo $profile_data['notes']; ?>
															</div>
														</div>
													</div>
													<div class=" col-md-6">
														<div class="form-group">
															<label class="control-label col-md-12">Employee Type</label>
															<div class="col-md-12  col-md-8 ">
															<?php
																if($profile_data['emp_type']!=''){
																	$content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$emp_module_id) . '/'.$table_name.'.php'));
																	$conf = unserialize($content);
																	foreach($conf['elements'] as $element){
																		if(isset($element['section_fields']['crud_users.emp_type']['element'][1])){
																			$data = $element['section_fields']['crud_users.emp_type']['element'][1];
																			foreach($data as $key=>$values){
																				if($key == $profile_data['emp_type']){
																					echo $values;	
																				}
																			}
																		}
																	}
																} ?>
															</div>
														</div>
													</div>
													<div class=" col-md-6">
														<div class="form-group">
															<label class="control-label col-md-12">NI No</label>
															<div class="col-md-12  col-md-8 ">
																<?php echo $profile_data['ni_no']; ?>
															</div>
														</div>
													</div>
													<div class=" col-md-6">
														<div class="form-group">
															<label class="control-label col-md-12">Tax ID</label>
															<div class="col-md-12  col-md-8 ">
																<?php echo $profile_data['tax_id']; ?>
															</div>
														</div>
													</div>
													<div class=" col-md-6">
														<div class="form-group">
															<label class="control-label col-md-12">ID Document Type</label>
															<div class="col-md-12  col-md-8 ">
																<?php
																if($profile_data['id_doc_type']!=0){
																	$content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$emp_module_id) . '/'.$table_name.'.php'));
																	$conf = unserialize($content);
																	foreach($conf['elements'] as $element){
																		if(isset($element['section_fields']['crud_users.id_doc_type']['element'][1])){
																			$data = $element['section_fields']['crud_users.id_doc_type']['element'][1];
																			foreach($data as $key=>$values){
																				if($key == $profile_data['id_doc_type']){
																					echo $values;	
																				}
																			}
																		}
																	}
																} ?>
															</div>
														</div>
													</div>
													<div class=" col-md-6">
														<div class="form-group">
															<label class="control-label col-md-12">ID Expiry Date</label>
															<div class="col-md-12  col-md-8 ">
																<?php if($profile_data['id_expiry_date']!='0000-00-00'){ echo date('d-m-Y',strtotime($profile_data['id_expiry_date'])); } ?>
															</div>
														</div>
													</div>
												</div>
												<?php } ?>
												<!--EMPLOYEE DETAIL SECTION ENDS-->
												
											<?php } else if(isset($_GET['password'])) { ?>
												<div class="panel-body">
													<div class="row">
														<div class=" col-md-6 ">
															<div class="form-group">
																<label class="control-label col-md-4">Old Password</label>
																<div class="col-md-12  col-md-8 ">
																	<input type="password" class="form-control" name="old_pass" id="old_pass" value=""/>
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
																	<input type="password" class="form-control" name="new_pass" id="new_pass" value=""/>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label col-md-6"> Confirm Password </label>
																<div class="col-md-12  col-md-8">
																	<input type="password" class="form-control" name="con_pass" id="con_pass" value=""/>
																</div>
															</div>
														</div>
													</div>
													<div class="clearfix"></div>
												</div>
											<?php } else if(isset($_GET['workHistory']) && ($group_name == '2')){?>
												<?php 
												$var['CRUD_AUTH'] = $CRUD_AUTH;
												$this->load->view('admin/common/work_history',$var); ?>
											<?php } ?>
										</div>
									</div>
								</div>
								<!--END-->
							</div>
						</form>
					</div>
				</div>
			</div>
			<script>
				function validateformprofile(){
					var user_first_name 	= $('#user_first_name').val();
					var user_las_name	 	= $('#user_las_name').val();
					var user_email		 	= $('#user_email').val();
					//var user_name		 	= $('#user_name').val();
					
					/* if(user_name == ''){
						$('#error_div').empty();
						$('#error_div').show();
						$('#error_div').append('<a href="#" class="close" onclick="closeerror();">×</a><strong>Error!</strong> Please Enter Username.');
						return false;
					} */
					
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
						$('#error_div').empty();
						$('#error_div').show();
						$('#error_div').append('<a href="#" class="close" onclick="closeerror();">×</a><strong>Error!</strong> Please Enter Email Address.');
						return false;
					}

					if(!user_email.match(/^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i)){
						$('#error_div').empty();
						$('#error_div').show();
						$('#error_div').append('<a href="#" class="close" onclick="closeerror();">×</a><strong>Error!</strong> Please Enter Valid Email Address.');
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
						$('#error_div').empty();
						$('#error_div').show();
						$('#error_div').append('<a href="#" class="close" onclick="closeerror();">×</a><strong>Error!</strong> Please Enter Old Password.');
						return false;
					}
					
					if(old_pass_check != '1'){
						$('#error_div').empty();
						$('#error_div').show();
						$('#error_div').append('<a href="#" class="close" onclick="closeerror();">×</a><strong>Error!</strong> Old Password Does Not Match.');
						return false;
					}
					
					if(new_pass == ''){
						$('#error_div').empty();
						$('#error_div').show();
						$('#error_div').append('<a href="#" class="close" onclick="closeerror();">×</a><strong>Error!</strong> Please Enter New Password.');
						return false;
					}
					
					if(con_pass == ''){
						$('#error_div').empty();
						$('#error_div').show();
						$('#error_div').append('<a href="#" class="close" onclick="closeerror();">×</a><strong>Error!</strong> Please Enter Confirm Password.');
						return false;
					}
					
					if(con_pass != new_pass){
						$('#error_div').empty();
						$('#error_div').show();
						$('#error_div').append('<a href="#" class="close" onclick="closeerror();">×</a><strong>Error!</strong> Password Does Not match.');
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
				
				function choosefile(){
					$('#profile_image').click();
				}
				
				function closeerror(){
					$("#error_div").hide();
				}
				
				$('.date-picker').datepicker({
					format:"dd-mm-yyyy",
					rtl: App.isRTL(),
					orientation: "left",
					autoclose: true
				});
			
			<?php if($this->session->flashdata('msg')){ ?>
			var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;"><button data-dismiss="alert" class="close" type="button">×</button><?php echo $this->session->flashdata('msg'); ?></div>';
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function(){ 
				alertSuccess.remove();
			},2000);
			<?php } ?>
			
			// DataTable
			var table = $('#sample_profile').DataTable({
				"order": [
					[1, "desc"]
				] // set first column as a
			});
			
			function validateformdates(){
				var date_from 		= $('#date_from').val();
				var date_to 		= $('#date_to').val();
					if(date_from == ''){
						$('#error_div').empty();
						$('#error_div').show();
						$('#error_div').append('<a href="#" class="close" onclick="closeerror();">×</a><strong>Error!</strong> Please Enter Date From.');
						return false;
					}
					
					if(date_to == ''){
						$('#error_div').empty();
						$('#error_div').show();
						$('#error_div').append('<a href="#" class="close" onclick="closeerror();">×</a><strong>Error!</strong> Please Enter Date To.');
						return false;
					}
				
			}
			</script>