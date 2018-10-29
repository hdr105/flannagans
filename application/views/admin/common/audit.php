			<div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="<?php echo base_url(); ?>">Dashboard</a><i class="fa fa-circle"></i>
                            </li>
                            <li>
								<span> User Audit Trail </span>   
							</li>
                        </ul>
                    </div>
                	<h3 class="page-title"> User Audit Trail </h3>
					<div class="row">
						<div class="col-md-12">
							<div class="portlet light bordered">
								<!--<div class="portlet-title">
                                    <div class="pull-left">
										<a class="btn btn-sm blue disabled" href="#"> Audit Trail </a>
                                    </div>
												
                                </div>-->
								<form action="javascript:;" id="filter_form"  class="form-horizontal"  novalidate="novalidate">
									<div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
										<table id="sample_2" class="table table-striped table-bordered">
                                            <thead>
                                                <tr id="filterrow">
													<td></td>
													<th>Date/Time</th>
													<th>Username</th>
													<th>Module Name</th>
													<th>Site Name</th>
													<th>Action</th>
												</tr>
                                                <tr>
													<th>Sr.</th>
													<th>Date/Time</th>
													<th>Username</th>
													<th>Module Name</th>
													<th>Site Name</th>
													<th>Action</th>
												</tr>
                                            </thead>
                                            <tbody>
												<?php
												$count = 1;
													if(isset($history_data)){
														foreach($history_data as $history){
												?>
												<tr>
													<td><?php echo $count++;?></td>
													<td><?php echo date('d-m-Y H:i:s', strtotime($history['history_date_time']));?></td>
													<td><?php echo $history['user_name'];?></td>
													<td><?php
														$query = $this->db->get_where('crud_components', array('id'=>$history['com_id']));
														if($query->num_rows()>0){
															echo $query->row()->component_name; 
														}
														?>
													</td>
													<td><?php
														$query_sites = $this->db->get_where('sites', array('id'=>$history['site_id']));
														if($query_sites->num_rows()>0){
															echo $query_sites->row()->sitename; 
														}
														?>
													</td>
													<td><?php echo ucwords($history['history_action']);?></td>
												</tr>
												<?php 
														}
													} 
												?>
                                            </tbody>
                                 		</table>
									</div>
								</form>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>