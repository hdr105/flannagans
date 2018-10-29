			<div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="<?php echo base_url(); ?>">Dashboard </a><i class="fa fa-circle"></i>
                            </li>
                            <li>
								<span>Work History</span>   
							</li>
                        </ul>
                    </div>
                	<h3 class="page-title"> Work History</h3>
					<div class="row">
						<!--onsubmit="return validateformdates();"-->
						<form id="password-form" action="<?php echo base_url(); ?>index.php/admin/profile/work_history?com_id=<?php echo $_GET['com_id']; ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
							<div class="col-md-12">
								<!--START-->
								<div class="portlet light bordered">
									<div class="portlet-title col-md-12">
										<label class="control-label col-md-1" style="white-space: nowrap;">Users </label>
										<div class="col-md-3">
											<select class="form-control select2" name="users_filter">
												<option value=""> Please Select</option>
												<?php if(!empty($users)) { ?>
													<?php foreach($users as $res){ ?>
														<option value="<?php echo $res['id']; ?>" <?php if(isset($_POST['users_filter']) && $_POST['users_filter']==$res['id']) echo "selected"; ?>><?php echo $res['user_first_name']. '' . $res['user_las_name']; ?></option>
													<?php } ?>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-3">
											<div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy">
												<input type="text" class="form-control" readonly name="date_from" id="date_from" value="<?php if(isset($_POST['date_from'])){ echo $_POST['date_from']; } ?>" style="width:190px;"/>
												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button> 
											</div>
										</div>
										<label class="control-label col-md-1" style="white-space: nowrap;">TO</label>
										<div class="col-md-3" style="margin-left:-45px;">
											<div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy">
												<input type="text" class="form-control date-picker" readonly name="date_to" id="date_to" value="<?php if(isset($_POST['date_to'])){ echo $_POST['date_to']; } ?>" style="width:190px;"/>
												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
											</div>
											<input type="hidden" class="form-control date-picker" name="com_id" id="com_id" value="<?php if(isset($_POST['com_id'])){ echo $_POST['com_id']; } ?>"/>
										</div>
										<div class=" pull-right col-md-1">
											<button type="submit" class="btn btn-sm blue pull-right" name="workHistory"/> <i class="fa fa-search"></i> SEARCH </button>
										</div>
									</div>
									<div class="portlet-body">
										<div class="alert alert-error col-md-12" id="error_div" style="display:none;"></div>
										<div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
											<?php 
												$var['permissions'] = $permissions;
												$var['CRUD_AUTH'] = $CRUD_AUTH;
												$this->load->view('admin/common/work_history',$var);
											?>
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
				function closeerror(){
					$("#error_div").hide();
				}
				
				$('.date-picker').datepicker({
					format:"dd-mm-yyyy",
					rtl: App.isRTL(),
					orientation: "left",
					autoclose: true
				});
			
				// DataTable
				/* var table = $('#sample_profile').DataTable({
					"order": [
						[1, "desc"]
					] // set first column as a
				});
				 */
				/* function validateformdates(){
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
				} */
			</script>