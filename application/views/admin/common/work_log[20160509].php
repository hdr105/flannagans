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
						<form id="password-form" action="<?php echo base_url(); ?>index.php/admin/profile/work_history?com_id=<?php echo $_GET['com_id']; ?>" method="GET" onsubmit="return validateformdates();" enctype="multipart/form-data" class="form-horizontal">
							<div class="col-md-12">
								<!--START-->
								<div class="portlet light bordered">
									<div class="portlet-title">
										<div class="pull-right">
											<button type="submit" class="btn btn-sm blue"/> SEARCH </button>
											<a class="btn btn-sm default " onclick="crudCancel();" href="<?php echo base_url().'index.php/admin/dashboard'; ?>">Cancel</a>
										</div>
									</div>
									<div class="portlet-body">
										<div class="alert alert-error col-md-12" id="error_div" style="display:none;"></div>
										<div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
											<?php 
											$var['permissions'] = $permissions;
											$var['CRUD_AUTH'] = $CRUD_AUTH;
											$this->load->view('admin/common/work_history',$var); ?>
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