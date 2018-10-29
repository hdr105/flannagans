				<!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
									<a href="index.php">Home</a><i class="fa fa-circle"></i>
								</li>
								<li>
									<a href="#">CRM Reports</a>
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
                        <h1 class="page-title"> CRM Reports
                            <small>Create a report</small>
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
														<select class="form-control select2" data-placeholder="Select..." name="sel_module" id="sel_module">
															<option></option>
															<?php
																foreach ($coms as $key => $value) {
																	?>
																		<option value="<?php echo $value['id']; ?>"><?php echo $value['component_name']; ?></option>
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
					<!-- END CONTENT BODY -->
				</div>
				<!-- END CONTENT  -->

<script type="text/javascript">

    function saveReport(){

        var report_name         = $('input[name="report_name"]').val();
        var sel_module          = $('#sel_module option:selected').val();
        var related_modules     = $('#related_modules').val();
        var report_des          = $('input[name="report_des"]').val();
        var module_fields       = $('#module_fields').val();
        
        var group_by_1          = $('#group_by_1 option:selected').val();
        var group_by_2          = $('#group_by_2 option:selected').val();
        var group_by_3          = $('#group_by_3 option:selected').val();
        
        var order_by_1          = $('input[name="order_by_1"]:checked').val();
        var order_by_2          = $('input[name="order_by_2"]:checked').val();
        var order_by_3          = $('input[name="order_by_3"]:checked').val();

        var filter_1            = $('#filter_1 option:selected').val();
        var cond_1              = $('#cond_1 option:selected').val();
        var cond_val_1          = $('input[name="cond_val_1"]').val();
        

        var filter_2            = $('#filter_2 option:selected').val();
        var cond_2              = $('#cond_2 option:selected').val();
        var cond_val_2          = $('input[name="cond_val_2"]').val();

        var filter_3            = $('#filter_3 option:selected').val();
        var cond_3              = $('#cond_3 option:selected').val();
        var cond_val_3          = $('input[name="cond_val_3"]').val();

        //var jsonData = {};
        
        var groupby       = [[group_by_1,order_by_1],[group_by_2,order_by_2],[group_by_3,order_by_3]];
        
        var conditions     = [[filter_1,cond_1,cond_val_1],[filter_2,cond_2,cond_val_2],[filter_3,cond_3,cond_val_3]];

        
        var jsonData = {report_name,sel_module, related_modules, module_fields, groupby, conditions};
        var json_string = JSON.stringify(jsonData);
        console.log(json_string);

        $.post('<?php echo base_url(); ?>index.php/admin/reports/saveReport', {jsonData:jsonData}, function(data){
            console.log('returned Data: ' + data);

        });




        window.location = '<?php echo base_url(); ?>index.php/admin/scrud/browse?com_id=31';
        
    }

    $('.filter').on('change',function(){
        var cutId           = (this.id).split('_');
        var thisId          = '#' + this.id;
        var selectedValue   = $(thisId + ' option:selected').val();
        var typeArr         = (selectedValue).split('|');
        var textBoxIdExHash = 'cond_val_' + cutId[1];
        var textBoxId       = '#cond_val_' + cutId[1];
        var parentControl   = '#dynamic_controll_' + cutId[1];
        var condBox         = '#cond_' + cutId[1];
        // If filed type is date
        if (typeArr[2] == 'date') {
            $(parentControl).find('select').attr('id','');
            $(parentControl).find('div').remove();
            $(parentControl).find('input[type="text"]').addClass('date-picker').datepicker();
            $(parentControl).find('input[type="text"]').datepicker('enable');
            $(parentControl).find('input[type="text"]').datepicker({dateFormat:"dd-mm-yyyy"} );
            $(parentControl).find('input[type="text"]').attr('id',textBoxIdExHash);
            $(parentControl).find('input[type="text"]').attr('name',textBoxIdExHash);
            $(parentControl).find('input[type="text"]').show();
            var dateOptions = '<option></option>'+
                        '<option value="e">equals</option>'+
                        '<option value="n">not equal to</option>'+
                        '<option value="bw">between</option>'+
                        '<option value="b">before</option>'+
                        '<option value="a">after</option>'+
                        '<option value="y">is empty</option>'+
                        '<option value="ny">is not empty</option>';
            $(condBox).select2({
                placeholder: "select..."
            }); 
            $(condBox).each(function () { //added a each loop here
                $(this).select2('val', '')
            });
            $(condBox).html(dateOptions);
        }
        // If field type is autocomplete or select
        if (typeArr[2] == 'autocomplete' || typeArr[2] == 'select') {
            $(parentControl).find('select').select2();
            $(parentControl).find('select').show();
            $(parentControl).find('select').attr('id',textBoxIdExHash);
            $(parentControl).find('select').attr('name',textBoxIdExHash);
            $(parentControl).find('input[type="text"]').attr('id','');
            $(parentControl).find('input[type="text"]').attr('name','');
            $(parentControl).find('input[type="text"]').css('display','none');
            // Get fields from controller

            
            $.post('<?php echo base_url(); ?>index.php/admin/creport/field_data', {data:typeArr[0]}, function(output){
                var outvalues = JSON.parse(output);
                var opt = '<option></option>';
                console.log(output);
                // loop through all values of select box
                for (var i = 0; i < outvalues.length; i++) {
                    var getValue = (outvalues[i]).split('|');    
                    opt = opt + '<option value="'+getValue[0]+'">'+getValue[1]+'</option>';   
                }; // end of for  
                $(parentControl).find('select').select2({
                    placeholder: "select..."
                });
                $(parentControl).find('select').each(function () { //added a each loop here
                    $(this).select2('val', '')
                });
                $(parentControl).find('select').html(opt);             
            });
        }
        // if field type is text
        if (typeArr[2] == 'text') {
            $(parentControl).find('select').attr('id','');
            $(parentControl).find('div').remove();
            $(parentControl).find('input[type="text"]').removeClass('date-picker'); //
            $(parentControl).find('input[type="text"]').datepicker('remove');
            $(parentControl).find('input[type="text"]').attr('id',textBoxIdExHash);
            $(parentControl).find('input[type="text"]').show();
            $(parentControl).find('input[type="text"]').val('');
            var textOptions = '<option></option>'+
                            '<option value="e">equals</option>'+
                            '<option value="n">not equal to</option>'+
                            '<option value="s">starts with</option>'+
                            '<option value="ew">ends with</option>'+
                            '<option value="c">contains</option>'+
                            '<option value="k">does not contain</option>'+
                            '<option value="y">is empty</option>'+
                            '<option value="ny">is not empty</option>';
            $(condBox).select2({
                placeholder: "select..."
            }); 
            $(condBox).each(function () { //added a each loop here
                $(this).select2('val', '')
            });
            $(condBox).html(textOptions);
        }
        if (typeArr[2] == 'currency') {
            $(parentControl).find('select').attr('id','');
            $(parentControl).find('div').remove();
            $(parentControl).find('input[type="text"]').removeClass('date-picker'); //
            $(parentControl).find('input[type="text"]').datepicker('remove');
            $(parentControl).find('input[type="text"]').attr('id',textBoxIdExHash);
            $(parentControl).find('input[type="text"]').show();
            $(parentControl).find('input[type="text"]').val('');
            var numberOptions = '<option></option><option value="e">equals</option><option value="n">not equal to</option><option value="l">less than</option><option value="g">greater than</option><option value="m">less or equal</option><option value="h">greater or equal</option><option value="y">is empty</option><option value="ny">is not empty</option>';
            $(condBox).select2({
                placeholder: "select..."
            }); 
            $(condBox).each(function () { //added a each loop here
                $(this).select2('val', '')
            });
            $(condBox).html(numberOptions);
        }
    });
    $('.cond').on('change',function(){
        
        var breakID = (this.id).split('_');
        var selectedCond = '#cond_' + breakID[1];
        var varVal = $(selectedCond + ' option:selected').val();     
        var thisId          = '#filter_'+breakID[1];
        var selectedValue   = $(thisId + ' option:selected').val();
        var typeArr         = (selectedValue).split('|');
        var textBoxIdExHash = 'cond_val_'+breakID[1];
        var containerDiv = '#dynamic_controll_' + breakID[1];
        if (varVal == 'bw' && typeArr[2] == 'date') {
            
            $(containerDiv + ' .simpleText').attr('id','');
            $(containerDiv + ' .simpleText').css('display','none');
            $(containerDiv + ' select').attr('id','');
            $(containerDiv + ' select').css('display','none');
            $(containerDiv + ' select').remove('div');
            $('#cond_drange_'+breakID[1]).css('display','block');
            var dateRange = '<div id="cond_drange_'+breakID[1]+'" class="input-group daterange input-large date-picker input-daterange" data-date="10-11-2012" data-date-format="dd-mm-yyyy"><input type="text" class="form-control" name="dfrom"><span class="input-group-addon"> to </span><input type="text" class="form-control" name="dto"></div>';
            $(containerDiv).append(dateRange);
            $('input[name="dfrom"]').addClass('date-picker').datepicker();
            $('input[name="dfrom"]').datepicker('enable');
            $('input[name="dto"]').addClass('date-picker').datepicker();
            $('input[name="dto"]').datepicker('enable');
        } else if(varVal != 'bw' && typeArr[2] == 'date') {
            var dateRangeId = '#cond_drange_' + breakID[1];
            $(containerDiv).find('select').attr('id','');
            $(containerDiv).find('div').remove();
            
            $(containerDiv).find('input[type="text"]').addClass('date-picker').datepicker();
            $(containerDiv).find('input[type="text"]').datepicker('enable');
            $(containerDiv).find('input[type="text"]').datepicker({dateFormat:"dd-mm-yyyy"} );
            $(containerDiv).find('input[type="text"]').attr('id',textBoxIdExHash);
            $(containerDiv).find('input[type="text"]').attr('name',textBoxIdExHash);
            $(containerDiv).find('input[type="text"]').show();
            var dateOptions = '<option></option>'+
                        '<option value="e">equals</option>'+
                        '<option value="n">not equal to</option>'+
                        '<option value="bw">between</option>'+
                        '<option value="b">before</option>'+
                        '<option value="a">after</option>'+
                        '<option value="y">is empty</option>'+
                        '<option value="ny">is not empty</option>';
            $(this.id).select2({
                placeholder: "select..."
            }); 
            $(this.id).each(function () { //added a each loop here
                $(this).select2('val', '')
            });
            $(this.id).html(dateOptions);
        }
    });
   

    function add_cond(){

        var numItems = $('.filter_row').length;


        var rowId = 'filter_row_' + numItems;

        var aobjName = '#' + rowId;
        
        var newRowId = 'filter_row_' + Number(numItems+1);
        var nFilter = 'filter_' + Number(numItems+1);
        var nCond = 'cond_' + Number(numItems+1);
        var nCondVal = 'cond_val_' + Number(numItems+1);
        
        var f = $(aobjName).html();
        $(aobjName).parent().append('<tr class="filter_row" id="'+newRowId+'">'+f+'</tr>');
    
        /*var newProductRow = '#' + newRowId;
        $(newProductRow).find('.filter').attr({'id':nFilter,'name':nFilter});
        $(newProductRow).find('.cond').attr({'id':nCond,'name':nCond});
        $(newProductRow).find('.cond_val').attr({'id':nCondVal,'name':nCondVal});
        ComponentsDropdowns.init();*/
        
    }

    function add_cond2(){

        var numItems = $('.filter2_row').length;


        var rowId = 'filter2_row_' + numItems;

        var aobjName = '#' + rowId;
        
        var newRowId = 'filter2_row_' + Number(numItems+1);
        var nFilter = 'filter2_' + Number(numItems+1);
        var nCond = 'cond2_' + Number(numItems+1);
        var nCondVal = 'cond2_val_' + Number(numItems+1);
        
        var f = $(aobjName).html();
        $(aobjName).parent().append('<tr class="filter2_row" id="'+newRowId+'">'+f+'</tr>');
    
        /*var newProductRow = '#' + newRowId;
        $(newProductRow).find('.filter2').attr({'id':nFilter,'name':nFilter});
        $(newProductRow).find('.cond2').attr({'id':nCond,'name':nCond});
        $(newProductRow).find('.cond2_val').attr({'id':nCondVal,'name':nCondVal});
        ComponentsDropdowns.init();*/
    }    

     $('#sel_module').on('change',function(){
        var selectedModule = $( "#sel_module option:selected" ).val();
        
            
            var qjson = {};
            qjson['main_table'] = selectedModule;
            $('#qjson').val(JSON.stringify(qjson));
            $.post('<?php echo base_url(); ?>admin/reports/get_related', {moduleName:selectedModule}, function(data){
                console.log(JSON.stringify(data));
                var obj = JSON.parse(data);
                var control = '#related_modules';
                
                tagSelect(control, obj);
               
               
                
                
            });

       
    });
    $('#related_modules').on('change',function(){
        
        
            
           
                var valControl = $(this).val();

                var valArry = valControl.split(",");



                    var selectedModule = $( "#sel_module option:selected" ).val();


                    //var qjson = {};
                    //var pre_json = $('#qjson').val();
                    //qjson = JSON.parse(pre_json);
                    //qjson['related_modules'] = valArry;


                    //qjson['related_modules'].push(selectedModule);
                    //$('#qjson').val(JSON.stringify(qjson));

                    $.post('<?php echo base_url(); ?>index.php/admin/reports/relatedModFieldList', {selectedModule:selectedModule, relatedModules:valControl}, function(data){
                        var obj = JSON.parse(data);
                        console.log(obj);
                        var innerHtml = '';
                        for (var i = 0; i < obj.length; i++) {
                            
                             console.log('optons: ' + JSON.stringify(obj[i].moduleInfo));
                            var optionValues = '';
                            var array2 = obj[i].moduleInfo;
                            for (var a = 0; a < array2.length; a++) {
                              

                                optionValues = optionValues+ '<option value="'+array2[a][2]+'|'+array2[a][0]+'|'+array2[a][1]+'">' +array2[a][0] + '</option>';
                            }
                            console.log('optons: ' + optionValues);

                            innerHtml = innerHtml+ '<optgroup label="'+obj[i].moduleName+'">' + optionValues + '</optgroup>';
                        };
                        $('#module_fields').html(innerHtml);

                        $('#group_by_1').html(innerHtml);
                        $('#group_by_2').html(innerHtml);
                        $('#group_by_3').html(innerHtml);
                        $('#filter_1').html(innerHtml);
                        $('#filter_2').html(innerHtml);
                        $('#filter_3').html(innerHtml);
                        
                         

                    });

               
                
                 

       
    });


</script>