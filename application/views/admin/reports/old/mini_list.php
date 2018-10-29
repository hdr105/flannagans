<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>Mini List <small>Create a widget</small></h1>
			</div>
			<!-- END PAGE TITLE -->
			
		</div>
	</div>
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
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
			<!-- BEGIN PAGE BREADCRUMB -->
			<ul class="page-breadcrumb breadcrumb">
				<li>
					<a href="<?php echo base_url(); ?>">Home</a><i class="fa fa-circle"></i>
				</li>
				<li class="active">
					Mini List
					<i class="fa fa-circle"></i>
				</li>
				<li class="active">
					 Create a widget
				</li>
			</ul>
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light" id="form_wizard_1">
						<div class="portlet-title">
							
						</div>
						<div class="portlet-body form">
						
							<form action="javascript:;" class="form-horizontal" id="mini_list" method="POST">
								<div class="form-wizard">
									<div class="form-body">
									
										<div class="tab-content">
											<div class="alert alert-danger display-none">
												<button class="close" data-dismiss="alert"></button>
												You have some form errors. Please check below.
											</div>
											<div class="alert alert-success display-none">
												<button class="close" data-dismiss="alert"></button>
												Your form validation is successful!
											</div>
											<div class="tab-pane active" id="tab1">

												<h3 class="block">Provide basic details for filter</h3>
												<div class="form-group">
													<label class="control-label col-md-3">Filter name <span class="required">
													* </span>
													</label>
													<?php
														$comid = '';
														$comid = $_GET['comid'];
															
													?>
													<div class="col-md-4">
														<input type="hidden" name="comid" id="comid" value="<?php echo $comid; ?>">
														<input type="text" class="form-control" name="report_name"/>
														<span class="help-block">
														Provide your filter name </span>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">Primary Module <span class="required">
													* </span></label>
													<div class="col-md-3">

														<select class="form-control select2me" data-placeholder="Select..." name="sel_module" id="sel_module">
														<option></option>
															<?php



																foreach ($coms as $key => $value) {
																	?>
																		<option value="<?php echo $value['id']; ?>" <?php if($comid == $value['id']){?>
																			 selected
																		<?php } ?>><?php echo $value['component_name']; ?></option>
																	<?php
																}
															?>
															
															
														</select>
														
													</div>
												</div>

														

												<h3 class="block">Select columns for filter</h3>
												<div class="form-group">
													<label class="control-label col-md-3">Select columns<span class="required">
													* </span></label>
													<div class="col-md-4">
														<select id="module_fields" name="module_fields" class="form-control select2" multiple>
															
														</select>
                                                        <label>Choose only three columns</label>
													</div>
												</div>
													<h3 class="block">Provide conditions for your filter</h3>
												<div class="col-md-12">
													<div class="portlet light">
														<div class="portlet-title">
															<div class="caption">
																
																<span class="caption-subject font-green-sharp bold uppercase">All Conditions (All conditions must be met)</span>
															</div>
															
														</div>
														<div class="portlet-body">

												<table>
																<tr class="filter_row" id="filter_row_1">
																	<td class="col-md-3">
																		<div class="form-group">
																			
																			<div class="col-md-12">
																				<select class="form-control select2me filter" data-placeholder="Select..." name="fileds_for_cond" id="filter_1">
																				<option></option>
																					
																					
																					
																				</select>
																			</div>
																		</div>
																	</td>
																	<td class="col-md-3">
																		<div class="form-group">
																			
																			<div class="col-md-12">
																				<select class="form-control select2me cond cond_1" data-placeholder="Select..." name="cond_1" id="cond_1">
									<option></option>
									<option value="e">equals</option>
				                    <option value="n">not equal to</option>
				                    <option value="s">starts with</option>
				                    <option value="ew">ends with</option>
				                    <option value="c">contains</option>
				                    <option value="k">does not contain</option>
				                    <option value="y">is empty</option>
				                    <option value="ny">is not empty</option>
				                    <!--
				                     '<option value="e">equals</option>'+
                        '<option value="n">not equal to</option>'+
                        '<option value="bw">between</option>'+
                        '<option value="b">before</option>'+
                        '<option value="a">after</option>'+
                        '<option value="y">is empty</option>'+
                        '<option value="ny">is not empty</option>';


							<option value="e">equals</option>
							<option value="n">not equal to</option>
							<option value="l">less than</option>
							<option value="g">greater than</option>
							<option value="m">less or equal</option>
							<option value="h">greater or equal</option>
							<option value="y">is empty</option>
							<option value="ny">is not empty</option>
                        -->
																					
																					
																					
																				</select>
																			</div>
																		</div>
																	</td>
																	<td  class="col-md-3">
																		<div class="form-group">
																			
																			<div class="col-md-12">
																			<div id="dynamic_controll_1">
																				
										


										<input type="text" class="form-control cond_val simpleText" name="cond_val_1" id="cond_val_1" />
											<select style="display:none;" class="form-control input-large select2me input-sm" data-placeholder="Select...">
											</select>
																				</div>
																			</div>
																		</div>
																	</td>
																	
																</tr>
																
															</table>
														</div>
													</div>


													</div>
													<div class="form-actions">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right;">
               									 <button type="submit" class="btn green"><span class="md-click-circle md-click-animate" style="height: 73px; width: 73px; top: -17.5px; left: -16.5px;"></span>Save Filter</button>
               									 <a class="btn btn-info" onclick="goBack()"  > &nbsp;  <i class="icon-ok icon-white"></i>  <?php echo "Cancel"; ?> &nbsp; </a>
            								</div>
										</div>
									</div>
											</div>										
										</div>
									</div>
									
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
