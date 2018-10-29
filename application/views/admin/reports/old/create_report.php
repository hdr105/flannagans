<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>CRM Repots <small>Create a report</small></h1>
			</div>
			
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
					<a href="index.php">Home</a><i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="#">CRM Repots</a>
					<i class="fa fa-circle"></i>
				</li>
				<li class="active">
					 Create a report
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
							<form action="javascript:;" class="form-horizontal" id="submit_form" method="POST">
								<div class="form-wizard">
									<div class="form-body">
										<ul class="nav nav-pills nav-justified steps">
											<li>
												<a href="#tab1" data-toggle="tab" class="step">
												<span class="number">
												1 </span>
												<span class="desc">
												<i class="fa fa-check"></i> Report Details </span>
												</a>
											</li>
											<li>
												<a href="#tab2" data-toggle="tab" class="step">
												<span class="number">
												2 </span>
												<span class="desc">
												<i class="fa fa-check"></i> Select Columns </span>
												</a>
											</li>
											<li>
												<a href="#tab3" data-toggle="tab" class="step active">
												<span class="number">
												3 </span>
												<span class="desc">
												<i class="fa fa-check"></i> Filters </span>
												</a>
											</li>
											<li>
												<a href="#tab4" data-toggle="tab" class="step">
												<span class="number">
												4 </span>
												<span class="desc">
												<i class="fa fa-check"></i> Confirm </span>
												</a>
											</li>
										</ul>
										<div id="bar" class="progress progress-striped" role="progressbar">
											<div class="progress-bar progress-bar-success">
											</div>
										</div>
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

												<h3 class="block">Provide basic details for report</h3>
												<div class="form-group">
													<label class="control-label col-md-3">Report name <span class="required">
													* </span>
													</label>
													<div class="col-md-4">
														<input type="text" class="form-control" name="report_name"/>
														<span class="help-block">
														Provide your report name </span>
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
																		<option value="<?php echo $value['component_table']; ?>"><?php echo $value['component_name']; ?></option>
																	<?php
																}
															?>
															
															
														</select>
														
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">Select Related Modules 
													</label>
													<div class="col-md-4">
														<input type="hidden" id="related_modules" name="related_modules" class="form-control select2" >
														<span class="help-block">
														Max 2. </span>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">Description 
													</label>
													<div class="col-md-4">
														<textarea name="report_des" class="form-control" cols="3"></textarea> 
														
													</div>
												</div>
												
											</div>
											<div class="tab-pane" id="tab2">
												<h3 class="block">Select columns, grouping and calculation to be applied</h3>
												
												<div class="form-group">
													<label class="control-label col-md-3">Select columns(MAX 25)c<span class="required">
													* </span></label>
													<div class="col-md-4">
														<select id="module_fields" name="module_fields" class="form-control select2" multiple>
															
														</select>
													</div>
												</div>
												
												<div class="form-group">
													<label class="control-label col-md-3">Group by</label>
													<div class="col-md-3">
														<select class="form-control select2me" data-placeholder="Select..." name="group_by_1" id="group_by_1">
														<option value="0">Select</option>
															
															
															
														</select>
														<p>&nbsp;</p>
														<select class="form-control select2me" data-placeholder="Select..." name="group_by_2" id="group_by_2">
														<option value="0">Select</option>
															
															
															
														</select>
														<p>&nbsp;</p>
														<select class="form-control select2me" data-placeholder="Select..." name="group_by_3" id="group_by_3">
														<option value="0">Select</option>
															
															
															
														</select>
														
													</div>
													<div class="col-md-3">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="order_by_1" id="order_by_1" value="Ascending" checked> Ascending </label>
															<label class="radio-inline">
															<input type="radio" name="order_by_1" id="order_by_1" value="Descending"> Descending </label>
															
														</div>
														<p>&nbsp;</p>
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="order_by_2" id="order_by_2" value="Ascending" checked> Ascending </label>
															<label class="radio-inline">
															<input type="radio" name="order_by_2" id="order_by_2" value="Descending"> Descending </label>
															
														</div>
														<p>&nbsp;</p>
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="order_by_3" id="order_by_3" value="Ascending" checked> Ascending </label>
															<label class="radio-inline">
															<input type="radio" name="order_by_3" id="order_by_3" value="Descending"> Descending </label>
															
														</div>
													</div>
												</div>
												<!--<div class="form-group">
													<label class="control-label col-md-3">Calculations</label>
													<div class="col-md-8">
														<table class="table table-striped table-bordered table-advance table-hover">
														<thead>
														<tr>
															<th>
																Column
															</th>
															<th class="hidden-xs">
																Sum
															</th>
															<th>
																Average
															</th>
															<th>
																Lowest Value
															</th>
															<th>
																Highest Value
															</th>
														</tr>
														</thead>
														<tbody>
														<tr>
															<td>
																<label class="checkbox-inline">
																	<input type="checkbox" id="inlineCheckbox1" value="option1"> </label>
															</td>
															<td>
																 <label class="checkbox-inline">
																	<input type="checkbox" id="inlineCheckbox1" value="option1"> </label>
															</td>
															<td>
																<label class="checkbox-inline">
																	<input type="checkbox" id="inlineCheckbox1" value="option1"> </label>
															</td>
															<td>
																<label class="checkbox-inline">
																	<input type="checkbox" id="inlineCheckbox1" value="option1"> </label>
															</td>
															<td>
																<label class="checkbox-inline">
																	<input type="checkbox" id="inlineCheckbox1" value="option1"> </label>
															</td>
														</tr>
														<tr>
															<td>
																<label class="checkbox-inline">
																	<input type="checkbox" id="inlineCheckbox1" value="option1"> </label>
															</td>
															<td>
																 <label class="checkbox-inline">
																	<input type="checkbox" id="inlineCheckbox1" value="option1"> </label>
															</td>
															<td>
																<label class="checkbox-inline">
																	<input type="checkbox" id="inlineCheckbox1" value="option1"> </label>
															</td>
															<td>
																<label class="checkbox-inline">
																	<input type="checkbox" id="inlineCheckbox1" value="option1"> </label>
															</td>
															<td>
																<label class="checkbox-inline">
																	<input type="checkbox" id="inlineCheckbox1" value="option1"> </label>
															</td>
														</tr>
														
														</tbody>
														</table>
													</div>
												</div>-->
												
											</div>
											<div class="tab-pane" id="tab3">
												<h3 class="block">Provide filter conditions for your report</h3>
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
																				<select class="form-control select2me filter" data-placeholder="Select..." name="filter_1" id="filter_1">
																				<option value="0">Select</option>
																					
																					
																					
																				</select>
																			</div>
																		</div>
																	</td>
																	<td class="col-md-3">
																		<div class="form-group">
																			
																			<div class="col-md-12">
																				<select class="form-control select2me cond cond_1" data-placeholder="Select..." name="cond_1" id="cond_1">
									<option value="e">equals</option>
                    <option value="n">not equal to</option>
                    <option value="s">starts with</option>
                    <option value="ew">ends with</option>
                    <option value="c">contains</option>
                    <option value="k">does not contain</option>
                    <option value="y">is empty</option>
                    <option value="ny">is not empty</option>
																					
																					
																					
																				</select>
																			</div>
																		</div>
																	</td>
																	<td  class="col-md-3">
																		<div class="form-group">
																			
																			<div class="col-md-12" id="dynamic_controll_1">
																				<input type="text" class="simpleText
																				 form-control cond_val " name="cond_val_1" id="cond_val_1" />
																				<select style="display:none;" class="form-control input-large select2me input-sm" data-placeholder="Select...">
																				</select>
																			</div>
																		</div>
																	</td>
																	<td   class="col-md-1">
																		<!--<div class="form-group">
																			<a href="javascript:;" class="btn btn-icon-only red">
																		<i class="fa fa-times"></i>
																		</a>
																		</div>-->
																	</td>
																</tr>
																
															</table>

															<table>
																<tr class="filter_row" id="filter_row_1">
																	<td class="col-md-3">
																		<div class="form-group">
																			
																			<div class="col-md-12">
																				<select class="form-control select2me filter" data-placeholder="Select..." name="filter_2" id="filter_2">
																				<option value="0">Select</option>
																					
																					
																					
																				</select>
																			</div>
																		</div>
																	</td>
																	<td class="col-md-3">
																		<div class="form-group">
																			
																			<div class="col-md-12">
																				<select class="form-control select2me cond cond_1" data-placeholder="--NONE--" name="cond_2" id="cond_2">
					<option value="e">equals</option>
                    <option value="n">not equal to</option>
                    <option value="s">starts with</option>
                    <option value="ew">ends with</option>
                    <option value="c">contains</option>
                    <option value="k">does not contain</option>
                    <option value="y">is empty</option>
                    <option value="ny">is not empty</option>
																					
																					
																				</select>
																			</div>
																		</div>
																	</td>
																	<td  class="col-md-3">
																		<div class="form-group">
																			
																			<div class="col-md-12" id="dynamic_controll_2">
																				<input type="text" class="form-control simpleText
																				 cond_val" name="cond_val_2" id="cond_val_2" />
																				<select style="display:none;" class="form-control input-large select2me input-sm" data-placeholder="Select...">
																				</select>
																			</div>
																		</div>
																	</td>
																	<td   class="col-md-1">
																		
																	</td>
																</tr>
																
															</table>

															<table>
																<tr class="filter_row" id="filter_row_1">
																	<td class="col-md-3">
																		<div class="form-group">
																			
																			<div class="col-md-12">
																				<select class="form-control select2me filter" data-placeholder="Select..." name="filter_3" id="filter_3">
																				<option value="0">Select</option>
																					
																					
																					
																				</select>
																			</div>
																		</div>
																	</td>
																	<td class="col-md-3">
																		<div class="form-group">
																			
																			<div class="col-md-12">
																				<select class="form-control select2me cond cond_1" data-placeholder="--NONE--" name="cond_3" id="cond_3">
					<option value="e">equals</option>
                    <option value="n">not equal to</option>
                    <option value="s">starts with</option>
                    <option value="ew">ends with</option>
                    <option value="c">contains</option>
                    <option value="k">does not contain</option>
                    <option value="y">is empty</option>
                    <option value="ny">is not empty</option>
																					
																					
																					
																				</select>
																			</div>
																		</div>
																	</td>
																	<td  class="col-md-3">
																		<div class="form-group">
																			
																			<div class="col-md-12" id="dynamic_controll_3">
																				<input type="text" class="form-control simpleText
																				 cond_val" name="cond_val_3" id="cond_val_3" />
																				<select style="display:none;" class="form-control input-large select2me input-sm" data-placeholder="Select...">
											</select>
																			</div>
																		</div>
																	</td>
																	<td   class="col-md-1">
																		<!--<div class="form-group">
																			<a href="javascript:;" class="btn btn-icon-only red">
																		<i class="fa fa-times"></i>
																		</a>
																		</div>-->
																	</td>
																</tr>
																
															</table>
															<!--<table>
																<tr>
																	<td  class="col-md-3">
																		<div class="form-group">
																		<div class="col-md-12">
																			<button type="button" class="btn btn-default" onclick="add_cond();">Add Condition</button>
																		</div>
																		</div>
																	</td>
																</tr>
															</table>-->
																
														</div>
													</div>
												</div>
												


												<!--<div class="col-md-12">
													<div class="portlet light">
														<div class="portlet-title">
															<div class="caption">
																
																<span class="caption-subject font-green-sharp bold uppercase">Any Conditions (At least one of the Conditions must be met)</span>
															</div>
															
														</div>
														<div class="portlet-body">

															<table>
																<tr class="filter2_row" id="filter2_row_1">
																	<td class="col-md-3">
																		<div class="form-group">
																			
																			<div class="col-md-12">
																				<select class="form-control select2me filter2" data-placeholder="Select..." name="filter2_1" id="filter2_1">
																				<option value="0">Select</option>
																					
																					
																					
																				</select>
																			</div>
																		</div>
																	</td>
																	<td class="col-md-3">
																		<div class="form-group">
																			
																			<div class="col-md-12">
																				<select class="form-control select2me cond2" data-placeholder="--NONE--" name="cond2_1" id="cond2_1">
																				<option value="0">Select</option>
																					
																					
																					
																				</select>
																			</div>
																		</div>
																	</td>
																	<td  class="col-md-3">
																		<div class="form-group">
																			
																			<div class="col-md-12">
																				<input type="text" class="form-control cond2_val" name="cond2_val_1" id="cond2_val_1" />
																				
																			</div>
																		</div>
																	</td>
																	<td   class="col-md-1">
																		<div class="form-group">
																			<a href="javascript:;" class="btn btn-icon-only red">
																		<i class="fa fa-times"></i>
																		</a>
																		</div>
																	</td>
																</tr>
																
															</table>
															
																
														</div>
													</div>
												</div>-->


												
											</div>
											<div class="tab-pane" id="tab4">
												<h3 class="block">Confirm your report</h3>
												
											</div>
										</div>
									</div>
									<div class="form-actions">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<a href="javascript:;" class="btn default button-previous">
												<i class="m-icon-swapleft"></i> Back </a>
												<a href="javascript:;" class="btn blue button-next">
												Continue <i class="m-icon-swapright m-icon-white"></i>
												</a>
												<a onclick="saveReport()"  class="btn green button-submit">
												Submit <i class="m-icon-swapright m-icon-white"></i>
												</a>

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
