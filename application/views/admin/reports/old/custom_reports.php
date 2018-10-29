<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>Cormeton Reports <small>Create a report</small></h1>
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
					<a href="<?php echo base_url(); ?>">Home</a><i class="fa fa-circle"></i>
				</li>
				<li>
					Cormeton Reports
					
				</li>
				
			</ul>
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light" id="form_wizard_1">
						<div class="portlet-title">
							
							
							
						</div>
						<div class="portlet-body">
							<?php

  	echo $sql;
  $data = json_decode($data);
  
?>

						<form method="post" id="genReport" accept="" target="_blank">
						<table>
							<tr class="filter_row" id="filter_row_1">
								<td class="col-md-4">
									<div class="form-group">
										<div class="col-md-12">
                                        <label class="ftitle">Select Site / Organisation:</label>
											
										
										</div>
									</div>
								</td>
								<td class="col-md-4">
									<div class="form-group">
										<div class="col-md-12">
												<select class="form-control select2me filter" data-placeholder="Select..." name="filter_1" id="filter_1">
												<option></option>
												<?php
													foreach ($data as $key => $value) {
												
													echo '<option value="'.$key.'">'.$value.'</option>';
													}
														
												?>
											</select>
										</div>
									</div>
								</td>
								<td  class="col-md-4">
									<div class="form-group">
										<div class="col-md-12" id="dynamic_controll_1">
											
											<select style="display:none;" class="form-control input-large select2me input-sm" data-placeholder="Select...">
								            
								            </select>
										</div>
									</div>
								</td>
								
							</tr>
                            <tr style="height:15px;">
                            	<td></td><td></td><td></td>
                            </tr>
                            <tr>
								<td class="col-md-4">
									<div class="form-group">
                                    	<div class="col-md-12">
                                    <label class="stitle">Select Damper Test Date Range:</label>
                                    </div>
                                    </div>
								</td>
								<td class="col-md-4">
									<div class="form-group">
										<div class="col-md-12">




											<div class="input-group input-large date-picker input-daterange" data-date="10-11-2012" data-date-format="dd-mm-yyyy" >
												<input type="text" class="form-control" name="dfrom">
												<span class="input-group-addon">
												to </span>
												<input type="text" class="form-control" name="dto">
											</div>
										</div>
									</div>
								</td>
                                <td class="col-md-4">
                                </td>
							</tr>
						</table>
						<!-- Conditions set for and two -->
						
						
						<!-- conditions set for and two -->
						
						<p>&nbsp;</p>
						<?php /*?><table>
							<tr>
								<td class="col-md-6">
									<label class="stitle">Select Damper Test Date Range</label>
								</td>
								<td class="col-md-6">
									<div class="form-group">
										<div class="col-md-12">




											<div class="input-group input-large date-picker input-daterange" data-date="10-11-2012" data-date-format="dd-mm-yyyy" >
												<input type="text" class="form-control" name="dfrom">
												<span class="input-group-addon">
												to </span>
												<input type="text" class="form-control" name="dto">
											</div>
										</div>
									</div>
								</td>
							</tr>
						</table><?php */?>
						<p>&nbsp;</p>
						<div style="float:right;">
						<a href="<?php echo base_url(); ?>index.php/admin/creport" class="btn default red-stripe">Reload
													</a>
							<button type="button" id="all" class="btn btn-primary">Overview All results</button>
							<button type="button" id="individual" class="btn btn-success">Individual Detailed</button>
						</div>
						<p>&nbsp;</p>
						</form>
						<!-- conditions set for OR 1 --
						<table>
							<tr class="filter_row" id="filter_row_4">
								<td class="col-md-3">
									<div class="form-group">
										<div class="col-md-12">
											<select class="form-control select2me filter" data-placeholder="Select..." name="filter_4" id="filter_4">
												<?php
													foreach ($data as $key => $value) {
														echo '<optgroup label="'.$value->moduleName.'">';
															foreach ($value->moduleInfo as $mk => $mv) {
																echo '<option value="'.implode(",",$mv ).'">'.$mv[0].'</option>';
															}
														echo '</optgroup>';
													}
												?>
											</select>
										</div>
									</div>
								</td>
								<td class="col-md-3">
									<div class="form-group">
										<div class="col-md-12">
											<select class="form-control select2me cond cond_4" data-placeholder="--NONE--" name="cond_4" id="cond_4">
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
										<div class="col-md-12" id="dynamic_controll_4">



											<input type="text" class="form-control cond_val" name="cond_val_4" id="cond_val_4" />
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
						<!-- condition set for OR 2 --
						<table>
							<tr class="filter_row" id="filter_row_5">
								<td class="col-md-3">
									<div class="form-group">
										<div class="col-md-12">
											<select class="form-control select2me filter" data-placeholder="Select..." name="filter_5" id="filter_5">
												<?php
													foreach ($data as $key => $value) {
														echo '<optgroup label="'.$value->moduleName.'">';
															foreach ($value->moduleInfo as $mk => $mv) {
																echo '<option value="'.implode(",",$mv ).'">'.$mv[0].'</option>';
															}
														echo '</optgroup>';
													}
												?>
											</select>
										</div>
									</div>
								</td>
								<td class="col-md-3">
									<div class="form-group">
										<div class="col-md-12">
											<select class="form-control select2me cond cond_5" data-placeholder="--NONE--" name="cond_5" id="cond_5">
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
										<div class="col-md-12" id="dynamic_controll_5">
											<input type="text" class="form-control cond_val" name="cond_val_5" id="cond_val_5" />
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
						<!-- condition set for OR 3 --
						<table>
							<tr class="filter_row" id="filter_row_6">
								<td class="col-md-3">
									<div class="form-group">
										<div class="col-md-12">
											<select class="form-control select2me filter" data-placeholder="Select..." name="filter_6" id="filter_6">
												<?php
													foreach ($data as $key => $value) {
														echo '<optgroup label="'.$value->moduleName.'">';
															foreach ($value->moduleInfo as $mk => $mv) {
																echo '<option value="'.implode(",",$mv ).'">'.$mv[0].'</option>';
															}
														echo '</optgroup>';
													}
												?>
											</select>
										</div>
									</div>
								</td>
								<td class="col-md-3">
									<div class="form-group">
										<div class="col-md-12">
											<select class="form-control select2me cond cond_6" data-placeholder="--NONE--" name="cond_6" id="cond_6">
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
										<div class="col-md-12" id="dynamic_controll_6">
											<input type="text" class="form-control cond_val" name="cond_val_6" id="cond_val_6" />
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
						</table>-->
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
<style>
ul#select2-results-1 li {
    width: 100%;
}
.ftitle, .stitle{float:right;}
.stitle{ }
</style>