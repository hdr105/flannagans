                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="index.html">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
									<a href="#">Reports</a>
									<i class="fa fa-circle"></i>
								</li>
								<li class="active">
									 Create a report
								</li>
                            </ul>			
                            
							<div class="page-toolbar">
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"> Actions
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
											<a href="<?php echo base_url(); ?>index.php/admin/reports/excsv?id=<?php echo $rid; ?>" target="_blank">
                                            <i class="icon-bell"></i> Export CSV</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>index.php/admin/reports/expdf?id=<?php echo $rid; ?>" target="_blank">
                                            <i class="icon-shield"></i> Export PDF</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> Reports Wizard
                            <small>create a report</small>
                        </h1>
                        <!-- END PAGE TITLE-->

			            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
						<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h4 class="modal-title">Modal title</h4>
									</div>
									<div class="modal-body">
										 Widget settings form goes here
									</div>
									<div class="modal-footer">
										<button type="button" class="btn blue">Save changes</button>
										<button type="button" class="btn default" data-dismiss="modal">Close</button>
									</div>
								</div>
								<!-- /.modal-content -->
							</div>
							<!-- /.modal-dialog -->
						</div>
						<!-- /.modal -->
						<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->


						<div class="portlet light bordered" id="form_wizard_1">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class=" icon-layers font-red"></i>
                                    <span class="caption-subject font-red bold uppercase"> Form Wizard -
                                        <span class="step-title"> Step 1 of 4 </span>
                                    </span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-cloud-upload"></i>
                                    </a>
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-wrench"></i>
                                    </a>
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-trash"></i>
                                    </a>
                                </div>
                            </div>


							<!-- //////////////////////////////// -->
							<!-- BEGIN PAGE CONTENT INNER -->
							<div class="row">
								<div class="col-md-12">
									<div class="portlet light" id="form_wizard_1">
										<div class="portlet-body">
											<table class="table table-striped table-bordered table-hover table-condensed flip-content" >
											<?php
												if (!empty($fields_lbs)) {
													?>
														<tr>
															<?php
																foreach ($fields_lbs as $lk => $lv) {
																	echo '<th>' . $lv . '</th>';
																}
															?>	
														</tr>
													<?php
												}


												if (!empty($data)) {
													foreach ($data as $dk => $dv) {
														echo '<tr>';
														foreach ($dv as $key => $value) {
																echo '<td>' . $value . '</td>';
														}
														echo '</tr>';
													}
												}
											?>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!-- END PAGE CONTENT INNER -->
							<!-- ///////////////////////////// -->
						</div>
					</div>
				</div>
