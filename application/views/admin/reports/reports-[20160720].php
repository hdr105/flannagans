<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>Reports wizard <small>create a report</small></h1>
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
					<a href="#">Reports</a>
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
							
							
							<!--<textarea name="qjson" id="qjson"></textarea>-->
							<a href="<?php echo base_url(); ?>index.php/admin/reports/excsv?id=<?php echo $rid; ?>" target="_blank">Export CSV</a> 
							<a href="<?php echo base_url(); ?>index.php/admin/reports/expdf?id=<?php echo $rid; ?>" target="_blank">Export PDF</a>
							
						</div>
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
											/*if (array_key_exists($key, $auto_fields)) {
												if (array_key_exists('option_table', $auto_fields[$key])) {

													$this->db->select('*');
											        $this->db->from($auto_fields[$key]['option_table']);
											        $this->db->where($auto_fields[$key]['option_key'],$value);
											        $query = $this->db->get();
											        $rdata = $query->row_array();

											        if ($auto_fields[$key]['option_table'] == 'crud_users') {
											        	$vv = ucwords($rdata['user_first_name']) . ' ' . ucwords($rdata['user_las_name']);
											        } elseif ($auto_fields[$key]['option_table'] == 'contact') {
											        	$vv = ucwords($rdata['First_Name']) . ' ' . ucwords($rdata['Last_Name']);
											        } else {
											        	$vv = $rdata[$auto_fields[$key]['option_value']];
											        }


													echo '<td>' . $vv . '</td>';
												} else {
													echo '<td>' . $auto_fields[$key][$value] . '</td>';
												}
												
											} else {*/
												echo '<td>' . $value . '</td>';
											//}
											
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
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
