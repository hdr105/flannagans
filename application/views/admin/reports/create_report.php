<?php 

if(isset($data) and !is_null($data))
{
	
	////// NAME OF REPORT //////////////////////////////////////////
	$name = $data[0]['rname'];

	//// PRIMARY MODULE ///////////////////////////////////////////
	$main_module = $data[0]['main_module'];

	//// RELATED MODULE ///////////////////////////////////////////
	$rlt_mod = $data[0]['related_modules'];
	$rm = explode(',',$rlt_mod);

	/////AUTO EMAIL////////////////////////////////////////////////
	$atem = $data[0]['autoEmail'];
	
	/////FREQUENCY/////////////////////////////////////////////////
	$frc  = $data[0]['frequency'];

	/////EMAIL SENT TO/////////////////////////////////////////////
	$email_to = $data[0]['email_sent_to'];

	/////CC CHKBOX/////////////////////////////////////////////////
	$cc_input = $data[0]['cc'];

	/////CC EMAILS//////////////////////////////////////////////////
	$cc_emails = $data[0]['cc_email'];
	
	///// SELECTED FIELDS //////////////////////////////////////////
	$slct_fields = $data[0]['selected_fileds'];
	$f = explode(',', $slct_fields);

	///// PDF-HEADERS //////////////////////////////////////////////
	$pdfHeader_data = $data[0]['pdfHeader'];
	$pdfHdr = explode(',', $pdfHeader_data);

	///// FUNCTION FOR FIELDS AND ALIAS/////////////////////////////
	$data_of_func = $data[0]['func'];
	$data_sep = explode('^' , $data_of_func);
	$f_perf = $data_sep[0];
	$field_for_func = $data_sep[1];
	$alias = $data_sep[2];

	///// ORDER BY ///////////////////////////////////////////////////
	$ono = $data[0]['orderby'];
	$fd = explode('^', $ono);
	
	////// ORDER BY 1 ////////
	$ono_1 = $fd[0];
	$o_data_1 = explode(',', $ono_1);
	$order_by_field_1 = $o_data_1[0];
	$order_1 = $o_data_1[1];
	
	
	////// ORDER BY 2 ///////
	$ono_2 = $fd[1];
	$o_data_2 = explode(',', $ono_2);
	$order_by_field_2 = $o_data_2[0];
	$order_2 = $o_data_2[1];
	

	///// ORDER BY 3 //////
	$ono_3 = $fd[2];
	$o_data_3 = explode(',', $ono_3);
	$order_by_field_3 = $o_data_3[0];
	$order_3 = $o_data_3[1];
	
	//// GROUP BY ///////////////////////////////////////////////////////
	$gno = $data[0]['groupby'];
	$gdat = explode(',', $gno);
	
	////// GROUP BY 1 ////////
	$gno_1 = $gdat[0];
	
	////// GROUP BY 2 ///////
	$gno_2 = $gdat[1];

	///// GROUP BY 3 //////
	$gno_3 = $gdat[2];
	
	////// CONDITIONS ////////////////////////////////////////////////
	$cond = $data[0]['conditions'];
	$cond = explode('^', $cond);
	$num_c = Count($cond);

	$i=1;
	foreach ($cond as $value) {
		
		${"data_cond_" . $i} = explode(',', $value);
		
		$i++;
	}

	for ($i=1; $i < $num_c+1 ; $i++) { 

		${"cond_op_" . $i} = ${"data_cond_" . $i}[0];
		${"cond_f_" . $i} = ${"data_cond_" . $i}[1];
		${"cond_c_" . $i} = ${"data_cond_" . $i}[2];
		${"cond_v_" . $i} = ${"data_cond_" . $i}[3];
		
	}

	for ($i=1; $i < $num_c+1 ; $i++) { 
		${"chk_cond_" . $i} = explode('|', ${"cond_f_" . $i} );
		${"f_info_" . $i} = ${"chk_cond_" . $i}[2];
	}

	///////CUSTOM CONDITION /////////////////////////////////////////////////
	$cst = $data[0]['custom_condition'];
	$cst_data = explode(',', $cst);
	$cst_opt = $cst_data[0];
	$cst_val = $cst_data[1];

	//////LIMIT OF RECORDS ////////////////////////////////////////////////
	$lmt_data = $data[0]['limits'];
	$lmt_data = explode(',', $lmt_data);
	$ofs = $lmt_data[0];
	$lmt = $lmt_data[1];
}
?>
					<!--BEGIN CONTENT-->
					<div class="page-content-wrapper">
						<!--BEGIN CONTENT BODY-->
						<div class="page-content">
							<!--BEGIN PAGE HEADEB-->
							<!--BEGIN PAGE BAR-->
							<div class="page-bar">
								<ul class="page-breadcrumb">
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

								<div class="page-toolbar">
									
								</div>
							</div>
							<!--END PAGEBAR-->
							<!--BEGIN PAGE TITLE-->
							<h1 class="page-title"> CRM Repots 
								<small>Create a report</small>
							</h1>
							<!--BEGIN PAGE TITLE-->


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
								1 </span><br>
								<span class="desc">
								<i class="fa fa-check"></i> Report Details </span>
								</a>
							</li>
							<li>
								<a href="#tab2" data-toggle="tab" class="step">
								<span class="number">
								2 </span><br>
								<span class="desc">
								<i class="fa fa-check"></i> Select Columns </span>
								</a>
							</li>
							<li>
								<a href="#tab3" data-toggle="tab" class="step">
								<span class="number">
								3 </span><br>
								<span class="desc">
								<i class="fa fa-check"></i> Filters </span>
								</a>
							</li>
							<li>
								<a href="#tab4" data-toggle="tab" class="step">
								<span class="number">
								4 </span><br>
								<span class="desc">
								<i class="fa fa-check"></i> Conditions </span>
								</a>
							</li>
							<li>
								<a href="#tab5" data-toggle="tab" class="step">
								<span class="number">
								5 </span><br>
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
										<input type="text" class="form-control" value="<?php if(isset($name)){ echo $name;}?>"  name="report_name"/>
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


            if($main_module == $value['id']){

             ?>

             <option selected="true" value="<?php echo $value['id']; ?>" >
              
              <?php echo $value['component_name']; ?>

             </option>

             <?php

            }
            else
            {
             ?>

             <option value="<?php echo $value['id']; ?>" >
              
              <?php echo $value['component_name']; ?>

             </option>


             <?php
            }
           ?>

             
           <?php
           }
           ?>
										</select>
										
									</div>
								</div>
								<div class="form-group" >
									<label class="control-label col-md-3">Select Related Module 
									</label>
									<div class="col-md-4">

										<select class="form-control related_module modules select2-multiple" data-placeholder="Select..." name="related_modules" id="related_modules" multiple>
											<option></option>
											
										</select>
									</div>
								</div>

								<!-- faheem changes start -->
								
								<div class="form-group">
									<label class="control-label col-md-3">Auto Email</label>
									<div class="col-md-2" style="margin-top:5px;">
										<input type="checkbox" name="autoEmail" value="<?php if(isset($atem) ){ echo $atem; }else{ echo '0';}?>" onclick="if(this.checked){showFreq(); this.value=1;}else{hideFreq(); this.value=0;}" id="autoEmail" class="form-control"/>
									</div>
								</div>
								<div class="form-group" id="show_freq" style="display:none;" >
									<label class="control-label col-md-3"> Frequency<span class="required">
									* </span></label>
									</label>
									<div class="col-md-4">

										<select class="form-control select2" id="freq" name="freq" required="true">
												<option value=""></option>

												<?php

           
										          $option = array('Daily','Weekly','Fortnightly','Monthly','Yearly');
										           $str='';
										           $i = 1;


										           foreach($option as $o)
										           {
										           		if($frc == $i)
										           		{
										           			$str .='<option selected="selected" value="'.$i.'">'.$o.'</option>';
										           		}
										           		else
										           		{
										           			$str .='<option value="'.$i.'">'.$o.'</option>';
										           		}
														 
										            	$i++;
										           }
										           echo $str; 
										           

										          ?>

											</select>
									</div>
								</div>
								<div class="form-group" id="show_email" style="display:none;" >
									<label class="control-label col-md-3"> Email sent to <span class="required">
									* </span></label>
									</label>
									<div class="col-md-4">
										<input type="email" class="simpleText form-control" name="esto" value="<?php if(isset($email_to) ){ echo $email_to; }else{ echo 'info@flannagans.com';}?>" id="esto" required="true" />
									</div>
								</div>
								<div class="form-group" id="show_cc" style="display:none;">
									
									<div class="col-md-offset-3 col-md-2">
										<input type="checkbox" name="cc_box" value="<?php if(isset($cc_input) ){ echo $cc_input; }else{ echo '0';}?>" onclick="if(this.checked){showCC(); this.value=1;}else{hideCC(); this.value=0;}" id="cc_box" class="form-control"/> &nbsp;CC
									</div>
								</div>
								<div class="form-group" id="show_cc_em" style="display:none;" >
									<label class="control-label col-md-3"> Enter Email </label>
									</label>
									<div class="col-md-4">
										<input type="text" class="simpleText form-control" name="ccem" placeholder="email@email.com" value="<?php if(isset($cc_emails) ){ echo $cc_emails; }?>" id="ccem" />
									</div>
									<p style="margin-top:10px;"><i>Seperate with comma[,] for multiples.</i></p>
								</div>


								<!-- faheem changes end -->
								
							</div>
							<div class="tab-pane" id="tab2">
								<h3 class="block">Select columns, grouping and calculation to be applied</h3>
								
								<div class="form-group">
									<label class="control-label col-md-3">Select columns(MAX 10)<span class="required">
									* </span></label>
									<div class="col-md-4">
										<select id="module_fields" name="module_fields" class="form-control select2-multiple" multiple >
										<option value=""></option>	
										</select>

									</div>
								</div>
								
								<div class="form-group">
									<label style="margin-left:4px;" id="showLabl" class="control-label col-md-3">Rename Selected Fields</label>
									<div class="col-md-3" style="margin-top:5px;">
										<input type="checkbox" name="rnameedit" value="" onclick="if(this.checked){showflds(); this.value=1; this.required='false';}else{hideflds(); this.value=0;this.required='true';}" id="rnameedit" class="form-control"/>

										<input type="hidden" id="modules_data" name="modules_data" value="" />
<style>
	#rnameedit-error{
		display:none !important;
	}


</style>
									</div>
								</div>
								<div style="margin-left:4px; display:none;" class="form-group" id="editing_alias">
								</div>
							</div>

							<div class="tab-pane" id="tab3">
								<h3 class="block">Select grouping and calculation to be applied</h3>
								
								<div class="form-group">
									<label class="control-label col-md-3">Function</label>
									<div class="col-md-2">
										<select class="form-control select2" data-placeholder="Select..." name="funct_performed" id="funct_performed">
											<option value=""></option>
											<?php

           
           $opt = array('Sum','Max','In','Avg','Count','Distinct','Round','Mid');
           $str='';


           foreach($opt as $op)
           {
            if(isset($f_perf) && ucfirst($f_perf) == $op)
            {
             $str .='<option selected="true" value="'.$op.'">'.$op.'</option>'; 
            }
            else 
            {
             $str .='<option value="'.$op.'">'.$op.'</option>'; 
            
            }
            
           }
           echo $str; 
           

          ?>
										</select>
									</div>
									<div class="col-md-3">
										<select class="form-control select2" data-placeholder="Select..." name="funct_fields" id="funct_fields">
											<option value=""></option>
										</select>
									</div>
										<label class="control-label col-md-1">AS</label>
									<div class="col-md-3">
										<input type="text" class="simpleText
          form-control" name="alias_name" value="<?php if(isset($alias)){ echo $alias;} ?>" id="alias_name" />
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-3">Order by</label>
									<div class="col-md-3">
										<select class="form-control select2" data-placeholder="Select..." name="order_by_1" id="order_by_1">
										<option value=""></option>
											
											
											
										</select>
										
										
									</div>
									<div class="col-md-4">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="order_1" id="order_1" value="Ascending" > Ascending </label>
											<label class="radio-inline">
											<input type="radio" name="order_1" id="order_1" value="Descending"> Descending </label>
											
										</div>
										
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Order by</label>
									<div class="col-md-3">
										<select class="form-control select2" data-placeholder="Select..." name="order_by_2" id="order_by_2">
										<option value=""></option>
											
											
											
										</select>
										
										
									</div>
									<div class="col-md-4">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="order_2" id="order_2" value="Ascending" > Ascending </label>
											<label class="radio-inline">
											<input type="radio" name="order_2" id="order_2" value="Descending"> Descending </label>
											
										</div>
										
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Order by</label>
									<div class="col-md-3">
										<select class="form-control select2" data-placeholder="Select..." name="order_by_3" id="order_by_3">
										<option value=""></option>
											
										</select>
										
										
									</div>
									<div class="col-md-4">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="order_3" id="order_3" value="Ascending"> Ascending </label>
											<label class="radio-inline">
											<input type="radio" name="order_3" id="order_3" value="Descending"> Descending </label>
											
										</div>
										
									</div>
								</div>

								<!--////////////////////////////////////////////////////-->

								<div class="form-group">
									<label class="control-label col-md-3">Group by</label>
									<div class="col-md-3">
										<select class="form-control select2" data-placeholder="Select..." name="group_by_1" id="group_by_1">
										<option value=""></option>	
										</select>
										
										
									</div>
									
			
									<div class="col-md-3">
										<select class="form-control select2" data-placeholder="Select..." name="group_by_2" id="group_by_2">
										<option value=""></option>
											
											
											
										</select>
										
										
									</div>
									
									<div class="col-md-3">
										<select class="form-control select2" data-placeholder="Select..." name="group_by_3" id="group_by_3">
										<option value=""></option>
									
										</select>
									</div>
									
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Limit of Records</label>
									<div class="col-md-3">
										<input type="text" class="simpleText
									 	form-control" placeholder="Enter Offset" name="input_offset" id="input_offset" value="<?php if(isset($ofs)){ echo $ofs;}?>"/>
									</div>
												
									<div class="col-md-3">
										<select class="form-control select2 col-md-3" data-placeholder="limit..." name="limit_data" id="limit_data">
										<option value=""></option>
										<option value="10">10</option>
										<option value="25">25</option>
									    <option value="100">100</option>
									    <option value="200">200</option>
									    <option value="300">300</option>
									    <option value="400">400</option>
									    <option value="500">500</option>
									    <option value="600">600</option>
									    <option value="700">700</option>
									    <option value="800">800</option>
									    <option value="900">900</option>
									    <option value="1000">1000</option>
									    </select>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab4">
								<h3 class="block">Provide filter conditions for your report</h3>
								<div class="col-md-12">
									<div class="portlet light">
										<div class="portlet-title">
											<div class="caption">
												
												<span class="caption-subject font-green-sharp bold uppercase">All Conditions (All conditions must be met)
												<span style="margin-left:173px;">
												<a  id="add_row" class="btn btn-success">Add <i class="glyphicon glyphicon-plus-sign"></i></a>
												<a  id="remove_row" class="btn btn-danger">Remove <i class="glyphicon glyphicon-minus-sign"></i></a>
												</span>
												</span>
											</div>
											
										</div>
										<div class="portlet-body">
											<div class="1" id="myId">
												<div class="row" style="margin-left:2px;" id="filter_row_1">
													<div class="col-md-2">
														<div class="form-group">
															<select class="form-control select2" data-placeholder="Select..." name="cond_opt_1" id="cond_opt_1">
															<option value=""></option>
															<option>AND</option>
															<option>OR</option>
															</select>
														</div>
													</div> 
													<div class="col-md-3">
														<div class="form-group">
															<div class="col-md-12">
																<select class="form-control select2 filter" data-placeholder="Select..." name="filter_1" id="filter_1">
																<option value=""></option>
																</select>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<div class="col-md-12">
																<select class="form-control select2 cond cond_1" data-placeholder="Select..." name="cond_1" id="cond_1">
																<option value=""></option>
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
													</div>
													<div  class="col-md-3">
														<div class="form-group">
															<div class="col-md-12" id="dynamic_controll_1">
																<input type="text" class="simpleText
																 form-control cond_val " name="cond_val_1" id="cond_val_1" />
												<select class="sm" style="display:none;" class="form-control input-large select2 input-sm" data-placeholder="Select...">
												</select>
															</div>
														</div>
													</div>
												</div>
											</div>
											

<script type="text/JavaScript">
		

		$('#add_row').on('click', function(){

			var id_array = $('#myId').children().attr('id').split('_');
			var clas_data = $('#myId').children().attr('class'); 
			var data = $('#myId > div:first-child').clone();
			$(data).find('span').remove();
			$(data).find("select").select2();
			$(data).find('#dynamic_controll_1').find('.select2-container').remove();

			var counter = $('#myId').attr('class');
			counter = (counter*1)+1;
			var used_id_for_next_row = counter;
			var new_id = (id_array[0]+"_"+id_array[1]+"_"+counter).toString();
			$('#myId').attr('class' , counter);

			var edit = $(data).attr('id' , new_id  ).attr('class' , clas_data).css('margin-top','20px');
			$(edit).appendTo('#myId');

					var ed_1_data = $("#"+new_id).find("#cond_opt_1").attr('id');
						ed_1_data = ed_1_data.toString().split('_');
						$("#"+new_id).find("#cond_opt_1").attr('id', ed_1_data[0]+"_"+ed_1_data[1]+"_"+used_id_for_next_row).attr('name', ed_1_data[0]+"_"+ed_1_data[1]+"_"+used_id_for_next_row);
					
					var ed_2_data = $("#"+new_id).find("#filter_1").attr('id');
						ed_2_data = ed_2_data.toString().split('_');
						$("#"+new_id).find("#filter_1").attr('id',ed_2_data[0]+"_"+used_id_for_next_row).attr('name', ed_2_data[0]+"_"+used_id_for_next_row);
					
					var ed_3_data = $("#"+new_id).find("#cond_1").attr('id');
						ed_3_data = ed_3_data.toString().split('_');
						$("#"+new_id).find("#cond_1").attr('id',ed_3_data[0]+"_"+used_id_for_next_row).attr('name', ed_3_data[0]+"_"+used_id_for_next_row);

					var div_dynamic = $("#"+new_id).find("#dynamic_controll_1").attr('id');
						div_dynamic = div_dynamic.toString().split('_');
						$("#"+new_id).find("#dynamic_controll_1").attr('id',div_dynamic[0]+"_"+div_dynamic[1]+"_"+used_id_for_next_row);
					
					var ed_4_data = $("#"+new_id).find("#cond_val_1").attr('id');
						ed_4_data = ed_4_data.toString().split('_');
						$("#"+new_id).find("#cond_val_1").attr('id', ed_4_data[0]+"_"+ed_4_data[1]+"_"+used_id_for_next_row).attr('name', ed_4_data[0]+"_"+ed_4_data[1]+"_"+used_id_for_next_row);
					
		});


		$("#remove_row").on('click', function(){
			var id_r = $("#myId").attr('class');
			if(id_r != 1)
			{
				$("#filter_row_"+id_r).remove();
				$("#myId").attr('class', (id_r*1)-1);
			}
		});
</script>

											<div style="margin-top:20px;" class="form-group">
												<div>
													<label class="control-label col-md-3"> Custom Condition</label>
												</div>
											</div>

											<div class="form-group">
												
												<div class="col-md-2">
													<select id="cust_cond_opt" name="cust_cond_opt" class="form-control input-large select2 input-sm" data-placeholder="Select...">
													<option value=""></option>
													<option value="AND">AND</option>
													<option value="OR">OR</option>
													</select>
												</div>
	
												<div class="col-md-6" id="cust_dynamic_controll">
													<input type="text" class="simpleText
													 form-control cond_val " name="cust_cond_val" id="cust_cond_val" value="<?php if(isset($cst_val)){echo $cst_val;}?>" />
												</div> 

											</div>
											
										</div>
									</div>
								</div>
									
							</div>

							<div class="tab-pane" id="tab5">
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
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<script type="text/javascript">

	var chk_flag = "false";
	var existnce_of_rlt = 0;
	var rlt_flg = "false";
	$(document).ready(function(){

		<?php
		if(isset($main_module) )
		{
		?>
			$('#sel_module').val('<?=$main_module ?>' ).trigger('change');

		<?php
		}
		?>

		
		var auto_input_box = "<?=$atem?>";
		if( auto_input_box == 1 )
		{
			jQuery('span', $('#uniform-autoEmail')).addClass("checked");
			$('#autoEmail').attr('checked');
			$("#show_freq").css("display", "block");
			$("#show_cc").css("display", "block");
			$("#show_email").css("display", "block");
		}

		var cc_input_box = "<?=$cc_input?>";
		if( cc_input_box == 1 )
		{
			jQuery('span', $('#uniform-cc_box')).addClass("checked");
			$('#cc_box').attr('checked');
			$("#show_cc_em").css("display", "block");
		}

		<?php
			if(isset($lmt))
			{
		?>
				$('#limit_data').select2('val', "<?=$lmt?>" );
		<?php
			} 
		?>
		$('.required').parent().parent().find('.form-control').prop('required',true);

			$(".select2, .select2-multiple").select2({
                placeholder: "Select...",
                allowClear: true,
                width: null,
                tags: true,
				templateResult: formatOutput
            });

             $("ul.select2-selection__rendered").sortable({
		        containment: 'parent'
		    });
        


			function formatOutput (optionElement) {
				if (!optionElement.id) { return optionElement.text; }
				var $state = $('<span style="margin-left:10px;">' + optionElement.text + '</span>');
				return $state;
			};

            $(".select2-allow-clear").select2({
                allowClear: true,
                placeholder: "Select...",
                width: null
            });

		
		$('#related_modules').parent().parent().hide();

		///////////////////////////////////////////////////////////
		<?php
		if(isset($pdfHeader_data) && $pdfHeader_data != "")
		{
		?>
			jQuery('span', $('#uniform-rnameedit')).addClass("checked");
			$('#rnameedit').attr('checked');
			$("#editing_alias").css("display", "block");
			$('#module_fields').attr('disabled' , "true");
			$('#rnameedit').attr('value' , "1");
			//$("ul.select2-selection__rendered").sortable("disable");
		<?php
		}
		else
		{
			?>
			$('#rnameedit').attr('required' , true);
			<?php
		}
		?>
		var php_data   = "<?=$pdfHeader_data?>";

		var module_fields = "";

		<?php
		if(isset($pdfHeader_data))
		{
		?>
			module_fields = php_data;
		<?php
		}
		else
		{
		?>
			module_fields = "" ; 
		<?php
		}
		?>

		module_fields 		= module_fields.toString();

		var field_array 	= [];
		var alias_array 	= [];


		if (module_fields.indexOf(",") != -1 ) 
		{
			var fields_data = module_fields.split(",");

			$('#modules_data').val(fields_data);

			var i=0; 
			$.each(fields_data, function( index, value ) {

				value = value.toString();
				value = value.split("|");
				
				field_array[i] = value[0];
				alias_array[i] = value[1]; 
				i++;

			});
		}
		else
		{
			var fields_data = module_fields.split("|");
			field_array[0] = fields_data[0];
			alias_array[0] = fields_data[1];
		}

		var j=0 ;
		var html = '';
		var rows = '<div class="row">';
		var rowe = '</div>';

		html = html + rows ;
		for(; j < field_array.length ; j++)
		{
			html = html + '<div class="col-md-3" style="margin-bottom:20px;"><input type="text" class="simpleText form-control" name="'+field_array[j]+'" value="'+alias_array[j]+'" id="'+field_array[j].replace('.','_')+'" /><br><p style="font-size:10px;margin-top: -18px;margin-left:1px;">'+field_array[j]+'</p></div>';

			if((j+1)%4 == 0)
			{
				html = html+rowe;
				html = html + rows;
			}
		}

		$(html).appendTo("#editing_alias");
		chk_flag = "true";

		$('#cust_cond_opt').select2('val', "<?=$cst_opt?>" );
	}); 

	function showFreq(){

		$("#show_freq").css("display", "block");
		$("#show_email").css("display", "block");
		$("#show_cc").css("display", "block");
	} 

	function showCC(){
		$("#show_cc_em").css("display", "block");
	}

	function hideFreq(){
		$("#show_freq").css("display", "none");
		$("#show_email").css("display", "none");
		$("#show_cc").css("display", "none");
	}

	function hideCC(){
		$("#show_cc_em").css("display", "none");
	}

	function showflds(){
		$("#editing_alias").css("display", "block");
		$('#module_fields').attr('disabled' , "true");
	}

	function hideflds(){
		$("#editing_alias").css("display", "none");
		$('#module_fields').removeAttr('disabled');
	}

    function saveReport(){

    	//////////////////////////--TAB 1--////////////////////////////////

        var report_name         = $('input[name="report_name"]').val();
        var sel_module          = $('#sel_module option:selected').val();
        var related_modules     = $('#related_modules').val();
        var report_des          = $('input[name="report_des"]').val();


        var auto                = $('input[name="autoEmail"]').val();
        var freq 				= $('#freq option:selected').val();

        var email_sent_to       = $('input[name="esto"]').val();
        var cc                  = $('input[name="cc_box"]').val();
        var cc_email            = $('input[name="ccem"]').val();

        	if(auto == 0)
        	{
        		freq = "";
        		email_sent_to = "";
        		cc = 0 ;
        		cc_email = "";

        	}

        	if(cc == 0)
        	{
        		cc_email = "";
        	}


        ///////////////////////////--TAB 2-- ////////////////////////////////

        var module_fields       = $('#modules_data').val();

        var orignal_fields      = module_fields.toString();

        var value = '';

        if (orignal_fields.indexOf(",") != -1 ) 
		{
		   var fields_data = orignal_fields.split(",");
		   for(var i=0; i<fields_data.length ; i++)
		   {
		   		value = fields_data[i].toString();
			   	value = value.split("|");
			   	
			   	if($('#'+value[0].replace('.','_')).val() != value[1])
			   	{
			   		fields_data[i] = fields_data[i].toString().replace( value[1], $('#'+value[0].replace('.','_')).val());
			   	}
		   }
		}

		var pdfHeader = fields_data; 

		////////////////////////--TAB 3--/////////////////////////////////
       
        var func_perf   		=$('#funct_performed option:selected').val();
        var func_field          =$('#funct_fields option:selected').val();
        var alias_name          =$('#alias_name').val();

        /////////////////////////////////////////////////////////////////////
        
        var order_by_fld_1      = $('#order_by_1 option:selected').val();
        var order_by_fld_2      = $('#order_by_2 option:selected').val();
        var order_by_fld_3      = $('#order_by_3 option:selected').val();
        
        var order_by_1          = $('input[name="order_1"]:checked').val();
        var order_by_2          = $('input[name="order_2"]:checked').val();
        var order_by_3          = $('input[name="order_3"]:checked').val();

       ////////////////////////////////////////////////////////////////////
       
        var group_by_1          = $('#group_by_1 option:selected').val();
        var group_by_2          = $('#group_by_2 option:selected').val();
        var group_by_3          = $('#group_by_3 option:selected').val();

		////////////////////////--TAB 4--//////////////////////////////
		var i=1;
		cond_data = [];
		$("#myId").children().each(function(){

			var single_cond = [];
			var cond_opt = $("#cond_opt_"+i+" option:selected").val();
			var filter = $("#filter_"+i+" option:selected").val();
			var cond = $("#cond_"+i+" option:selected").val();
			
			var f_input_1           = $('input[name=cond_val_'+i+']').val();
	        var f_select_1          = $('#cond_val_'+i+' option:selected').val();
	        var dfrom_1             = $('#cond_drange_'+i+' > input[name=dfrom]').val();
	        var dto_1               = $('#cond_drange_'+i+' > input[name=dto]').val();
	        var cond_val          ="";

		        if(f_input_1 == undefined && f_select_1 != undefined && (dfrom_1 == undefined && dto_1 == undefined))
		        {
		         cond_val      =  f_select_1;
		        }
		        else if(f_input_1 != undefined && f_select_1 == undefined && (dfrom_1 == undefined && dto_1 == undefined))
		        {
		         cond_val     =  f_input_1;
		        }
		        else
		        {
		         cond_val = dfrom_1 + " " +dto_1 ;
		        }

		        single_cond = [cond_opt,filter,cond,cond_val];
		        cond_data.push(single_cond);
			i++;
		});
		

		///////////////////////////////////////////////////////////////////////
		var cust_cond_opt          = $('#cust_cond_opt option:selected').val();
		var cust_input_val         = $('#cust_dynamic_controll > input[name=cust_cond_val').val();
		var custom                 = [cust_cond_opt,cust_input_val];
		
		///////////////////////////////////////////////////////////////////////
		var ofset           = $('#input_offset').val();
		var limit_rang      = $('#limit_data option:selected').val();
	
		if(ofset == undefined || ofset == "")
		{
			ofset = 0;
		}
		if(limit_rang == undefined || limit_rang == "")
		{
			limit_rang = 200;
		}
		if((ofset == undefined || ofset == "") && (limit_rang == undefined || limit_rang == ""))
		{
			ofset = 0;
			limit_rang = 200;
		}
		var limit           =[ofset , limit_rang];


		var conditions    = cond_data;
		var groupby       =[group_by_1,group_by_2,group_by_3];
        var funct         =[func_perf , func_field , alias_name];
        var orderby       = [[order_by_fld_1,order_by_1],[order_by_fld_2,order_by_2],[order_by_fld_3,order_by_3]];

        var jsonData      = {report_name,sel_module, auto , freq , email_sent_to, cc, cc_email, related_modules, module_fields, pdfHeader , orderby , groupby , funct, conditions, custom , limit };


		//////faheem changes end ////////
        var json_string = JSON.stringify(jsonData);
        console.log(json_string);

        $.post('<?php echo base_url(); ?>index.php/admin/reports/saveReport?id=<?=$_GET['key']['reports.id']?>', {jsonData:jsonData}, function(data){
            console.log('returned Data: ' + data);
        });

        window.location = '<?php echo base_url(); ?>index.php/admin/scrud/browse?com_id=31';   
    }

    $(document).on('change','.filter',function(){

        var cutId           = (this.id).split('_');
        var thisId          = '#' + this.id;
        var selectedValue   = $(thisId + ' option:selected').val();
        var typeArr         = selectedValue.split('|');
        var textBoxIdExHash = 'cond_val_' + cutId[1];
        var textBoxId       = '#cond_val_' + cutId[1];
        var parentControl   = '#dynamic_controll_' + cutId[1];
        var condBox         = '#cond_' + cutId[1];
 
    	////faheem changes start ////
    	$(parentControl).html('<input type="text" class="simpleText form-control cond_val" name="'+textBoxIdExHash+'" id="'+textBoxIdExHash+'"><select  style="display:none;" data-placeholder="Select..." id=""></select>');
        ////faheem changes end ////

        // If filed type is date


        if (typeArr[2] == 'date' || typeArr[2] == 'date_simple' ) {
            $(parentControl).find('select').attr('id','');
            $(parentControl).find('div').remove();
            $(parentControl).find('input[type="text"]').addClass('date-picker').datepicker();
            $(parentControl).find('input[type="text"]').datepicker('enable');
            $(parentControl).find('input[type="text"]').datepicker({dateFormat:"dd-mm-yyyy"} );
            $(parentControl).find('input[type="text"]').attr('id',textBoxIdExHash);
            $(parentControl).find('input[type="text"]').attr('name',textBoxIdExHash);
            $(parentControl).find('input[type="text"]').attr('required',"true");
            $(parentControl).find('input[type="text"]').show();
            var dateOptions = '<option></option>'+
                        '<option value="e">equals</option>'+
                        '<option value="n">not equal to</option>'+
                        '<option value="bw">between</option>'+
                        '<option value="b">before</option>'+
                        '<option value="a">after</option>'+
                        '<option value="y">is empty</option>'+
                        '<option value="ny">is not empty</option>'+
                        '<option value="1">Current Month</option>'+
                        '<option value="2">Current Week</option>'+
                        '<option value="3">Current Day</option>'+
                        '<option value="4">Last Week</option>'+
                        '<option value="5">Current Year</option>'+
                        '<option value="6">Last Year</option>';
                        
            $(condBox).select2({
                placeholder: "select...",
                allowClear: true
            }); 
            $(condBox).each(function () { //added a each loop here
                $(this).select2('val', '')
            });
            $(condBox).html(dateOptions);
        }
        // If field type is autocomplete or select
        if (typeArr[2] == 'autocomplete' || typeArr[2] == 'select') {
            //alert('autocomplete type');
            $(parentControl).find('select').select2().attr('style' , 'width:200px;');
            $(parentControl).find('select').select2().attr('required' , "true");
            $(parentControl).find('select').show();
            $(parentControl).find('select').attr('id',textBoxIdExHash);
            $(parentControl).find('select').attr('name',textBoxIdExHash);
            $(parentControl).find('input[type="text"]').attr('id','');
            $(parentControl).find('input[type="text"]').attr('name','');
            $(parentControl).find('input[type="text"]').css('display','none');
            // Get fields from controller
            
            $.post('<?php echo base_url(); ?>index.php/admin/reports/field_data', {data:typeArr[0]}, function(output){
                var outvalues = JSON.parse(output);
                var opt = '<option></option>';
                console.log(output);
                // loop through all values of select box
                for (var i = 0; i < outvalues.length; i++) {
                    var getValue = (outvalues[i]).split('|');    
                    opt = opt + '<option value="'+getValue[0]+'">'+getValue[1]+'</option>';   
                }; // end of for  
                $(parentControl).find('select').select2({
                    placeholder: "select...",
                    allowClear: true

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
            $(parentControl).find('input[type="text"]').attr('required',"true");
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
                placeholder: "select...",
                allowClear: true
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
                placeholder: "select...",
                allowClear: true
            }); 
            $(condBox).each(function () { //added a each loop here
                $(this).select2('val', '')
            });
            $(condBox).html(numberOptions);
        }
    });

    $(document).on('change','.cond',function(){

        var breakID 		= (this.id).split('_');
        var selectedCond 	= '#cond_' + breakID[1];
        var varVal 			= $(selectedCond + ' option:selected').val();     
        var thisId          = '#filter_'+breakID[1];
        var selectedValue   = $(thisId + ' option:selected').val();
        var typeArr         = (selectedValue).split('|');
        var textBoxIdExHash = 'cond_val_'+breakID[1];
        var containerDiv 	= '#dynamic_controll_' + breakID[1];

        if ((varVal == 1 || varVal == 2 || varVal == 3 || varVal == 4 || varVal == 5 || varVal == 6 ) && (typeArr[2] == 'date' || typeArr[2] == 'date_simple' )) {
            $(containerDiv + ' .simpleText').attr('id','');
            $(containerDiv + ' .simpleText').css('display','none');
            $(containerDiv + ' select').attr('id','');
            $(containerDiv + ' select').css('display','none');
        
        }
        else if (varVal == 'bw' && (typeArr[2] == 'date' || typeArr[2] == 'date_simple')) {
            $(containerDiv + ' .simpleText').attr('id','');
            $(containerDiv + ' .simpleText').css('display','none');
            $(containerDiv + ' select').attr('id','');
            $(containerDiv + ' select').css('display','none');
            $(containerDiv + ' select').remove('div');
            $('#cond_drange_'+breakID[1]).css('display','block');
            var dateRange = '<div id="cond_drange_'+breakID[1]+'" class="input-group daterange date-picker input-daterange" data-date="10-11-2012" data-date-format="dd-mm-yyyy"><input type="text" class="form-control" name="dfrom" required style=""><span class="input-group-addon"> to </span><input type="text" class="form-control" name="dto" required style=""></div>';
            $(containerDiv).append(dateRange);
            $('input[name="dfrom"]').addClass('date-picker').datepicker();
            $('input[name="dfrom"]').datepicker('enable');
            $('input[name="dto"]').addClass('date-picker').datepicker();
            $('input[name="dto"]').datepicker('enable');
        }
        else if (varVal == 'y') {
            $(containerDiv + ' .simpleText').attr('id','');
            $(containerDiv + ' .simpleText').css('display','none');
            $(containerDiv + ' select').attr('id','');
            $(containerDiv + ' select').css('display','none');
            
        }
        else if (varVal == 'ny') {
            $(containerDiv + ' .simpleText').attr('id','');
            $(containerDiv + ' .simpleText').css('display','none');
            $(containerDiv + ' select').attr('id','');
            $(containerDiv + ' select').css('display','none');
        
        }
        else if(varVal != 'bw' && (typeArr[2] == 'date' || typeArr[2] == 'date_simple' )) {
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
                        '<option value="ny">is not empty</option>'+
                        '<option value="1">Current Month</option>'+
                        '<option value="2">Current Week</option>'+
                        '<option value="3">Current Day</option>'+
                        '<option value="4">Last Week</option>'+
                        '<option value="5">Current Year</option>'+
                        '<option value="6">Last Year</option>';
            $(this.id).select2({
                placeholder: "select...",
                allowClear: true
            }); 
            $(this.id).each(function () { //added a each loop here
                $(this).select2('val', '')
            });
            $(this.id).html(dateOptions);
        } 
    });
	
    $('#sel_module').on('change',function(){

        var selectedModule = $( "#sel_module option:selected" ).val();
        var qjson = {};
        qjson['main_table'] = selectedModule;
        $('#qjson').val(JSON.stringify(qjson));
        $.post('<?php echo base_url(); ?>admin/reports/get_related', {moduleName:selectedModule}, function(data){
            //console.log("related module : "+JSON.stringify(data));
            var obj = JSON.parse(data);

            console.log("data  : "+data);

            existnce_of_rlt = data.length;
            var html = '';
            var rm_new = <?=json_encode($rm)?>;

			for (var i = 0; i < obj.length; i++) {
				html = html + '<option value="'+obj[i].id+'">'+obj[i].moduleName+'</option>';
			}
            $('#related_modules option').remove();
            $('#related_modules').parent().find("ul li").remove();
            $('#related_modules').append(html);

            if(jQuery.isEmptyObject(obj))
            {
            	$('#related_modules').parent().parent().hide();
            }
            else
            {
            	$('#related_modules').parent().parent().show();
            }

            
			<?php 
			if(isset($rm))
			{
			?>
				$('#related_modules').select2('val',rm_new);
				//$('#related_modules').val(rm_new).trigger('change');

			<?php
			}
			?>
        });


        var rm = "";

        var selectedModule = $( "#sel_module option:selected" ).val();
        $.post('<?php echo base_url(); ?>index.php/admin/reports/relatedModFieldList', {selectedModule:selectedModule, relatedModules:rm}, function(data){
            var obj = JSON.parse(data);
        
            var innerHtml = '<option value="">Select...</option>';
            var inner_date_Html = '<option value="">Select...</option>';
            for (var i = 0; i < obj.length-1; i++) {
                var optionValues = '';
                var dateValues = '';
                var array2 = obj[i].moduleInfo;

                for (var a = 0; a < array2.length; a++) {
                	if(array2[a][1] == "date" || array2[a][1] == "date_simple")
                	{
                		dateValues = dateValues+ '<option value="'+array2[a][2]+'|'+array2[a][0]+'|'+array2[a][1]+'">' +array2[a][0] + '</option>';
                		optionValues = optionValues+ '<option value="'+array2[a][2]+'|'+array2[a][0]+'|'+array2[a][1]+'">' +array2[a][0] + '</option>';
                	}
                	else
                	{
                		optionValues = optionValues+ '<option value="'+array2[a][2]+'|'+array2[a][0]+'|'+array2[a][1]+'">' +array2[a][0] + '</option>';
                	}
	                
                }
                innerHtml = innerHtml+ '<optgroup label="'+obj[i].moduleName+'" style="color:#000;">' + optionValues + '</optgroup>';

                inner_date_Html = inner_date_Html+ '<optgroup label="'+obj[i].moduleName+'" style="color:#000;">' + dateValues + '</optgroup>';
                
            };
            $('#module_fields').html(innerHtml);
			$('#funct_fields').html(innerHtml);
            $('#order_by_1').html(innerHtml);
            $('#order_by_2').html(innerHtml);
            $('#order_by_3').html(innerHtml);
            $('#group_by_1').html(innerHtml);
            $('#group_by_2').html(innerHtml);
            $('#group_by_3').html(innerHtml);

            if(existnce_of_rlt == 2)
            {
            	rlt_flg = "true";
	            $('#filter_1').html(innerHtml);
	            var num_cond = "<?=$num_c?>";
			
				var b ={};

				<?php 

				for($sk = 1 ; $sk < $num_c+1 ; $sk++)
				{
				?>
					$('#add_row').trigger('click');
					b['c_f_' + <?=$sk?>] = '<?=${"cond_f_" . $sk}?>';
					b['c_c_' + <?=$sk?>] = '<?=${"cond_c_" . $sk}?>';
					b['c_v_' + <?=$sk?>] = '<?=${"cond_v_" . $sk}?>';
					b['c_op_' + <?=$sk?>] = '<?=${"cond_op_" . $sk}?>';
					b['info_' + <?=$sk?>] = '<?=${"f_info_" . $sk}?>';
					
				<?php
	            	if(isset(${"cond_op_" . $sk}))
	            	{
	            ?>
	            		$('#cond_opt_'+<?=$sk?>).select2('val', "<?=${"cond_op_" . $sk}?>" );
	            <?php
	           		}
					if(isset(${"cond_f_" . $sk}))
					{
				?>
						$('#filter_'+<?=$sk?>).select2('val', "<?=${"cond_f_" . $sk}?>" );
				<?php
					}
					if(isset(${"cond_c_" . $sk}))
					{
				?>
						$('#cond_'+<?=$sk?>).select2('val', "<?=${"cond_c_" . $sk}?>" );
				<?php
					}
					if(isset(${"cond_v_" . $sk}))
					{
				?>
						if(b['info_' + <?=$sk?>] == "select" || b['info_' + <?=$sk?>] == "autocomplete")
						{
							$('#cond_val_'+<?=$sk?>).select2('val' , "<?=${"cond_v_" . $sk}?>" );
						}
						
						else if(b['info_' + <?=$sk?>] == "date" && b['c_c_' + <?=$sk?>] == "bw")
						{

							var date_arr = b['c_v_' + <?=$sk?>].split(" ");
							var df = date_arr[0];
							var dt = date_arr[1];
							$("#cond_drange_"+<?=$sk?>+" > input[name=dfrom]").val(df);
							$("#cond_drange_"+<?=$sk?>+" > input[name=dto]").val(dt);

						}
						else
						{
							$('#cond_val_'+<?=$sk?>).val("<?=${"cond_v_" . $sk}?>");
						}
				<?php
					}
				}
				?>
				
				$('#remove_row').trigger('click');
				
            }
            
        });
    });

    $('#related_modules').on('change',function(){

        var valControl = $(this).val();
        var rm="";

        if(valControl != null)
        {
        	rm = valControl.join();
        }
        
        var selectedModule = $( "#sel_module option:selected" ).val();
        $.post('<?php echo base_url(); ?>index.php/admin/reports/relatedModFieldList', {selectedModule:selectedModule, relatedModules:rm}, function(data){
            var obj = JSON.parse(data);

            console.log("data : "+data);

            var innerHtml = '<option value="">Select...</option>';
			var inner_date_Html = '<option value="">Select...</option>';
			///////added by faheem////////
        	var new_f = <?=json_encode($f) ?>;

            var o1    = "<?=$order_by_field_1?>";
            var o2    = "<?=$order_by_field_2?>";
            var o3    = "<?=$order_by_field_3?>";

            var g1    = "<?=$gno_1?>";
            var g2    = "<?=$gno_2?>";
            var g3    = "<?=$gno_3?>";

            var ff 	  = "<?=$field_for_func?>";
            
            //////////////////////////////

     
            for (var i = 0; i < obj.length; i++) {

                var optionValues = '';
                var dateValues = '';
                var array2 = obj[i].moduleInfo;

                for (var a = 0; a < array2.length; a++) {
                	if(array2[a][1] == "date" || array2[a][1] == "date_simple")
                	{
                		dateValues = dateValues+ '<option value="'+array2[a][2]+'|'+array2[a][0]+'|'+array2[a][1]+'">' +array2[a][0] + '</option>';
                		optionValues = optionValues+ '<option value="'+array2[a][2]+'|'+array2[a][0]+'|'+array2[a][1]+'">' +array2[a][0] + '</option>';
                	}
                	else
                	{
                		optionValues = optionValues+ '<option value="'+array2[a][2]+'|'+array2[a][0]+'|'+array2[a][1]+'">' +array2[a][0] + '</option>';
                	}
	                
                }
                innerHtml = innerHtml+ '<optgroup label="'+obj[i].moduleName+'" style="color:#000;">' + optionValues + '</optgroup>';

                inner_date_Html = inner_date_Html+ '<optgroup label="'+obj[i].moduleName+'" style="color:#000;">' + dateValues + '</optgroup>';
                
            };

            //console.log("inner date html : "+inner_date_Html);

            $('#module_fields').html(innerHtml);
			<?php 
			if(isset($f))
			{
			?>
				$('#module_fields').select2('val',new_f);
			<?php
			}
			?>
			$('#funct_fields').html(innerHtml);
			<?php
			if(isset($field_for_func))
			{
			?>
				$('#funct_fields').select2('val',ff);
			<?php
			}
			?>
			$('#group_by_1').html(innerHtml);
			<?php
			if(isset($gno_1))
			{
			?>
				$('#group_by_1').select2('val', g1 );
			<?php
			}
			?>
            $('#group_by_2').html(innerHtml);
            <?php
			if(isset($gno_2))
			{
			?>
				$('#group_by_2').select2('val', g2 );
			<?php
			}
			?>
            $('#group_by_3').html(innerHtml);
            <?php
			if(isset($gno_3))
			{
			?>
				$('#group_by_3').select2('val', g3 );
			<?php
			}
			?>
            $('#order_by_1').html(innerHtml);
			<?php
				if(isset($order_by_field_1))
			{
			?>
				$('#order_by_1').select2('val', o1 );
			<?php
			}
			?>
			<?php
			if(isset($order_1))
			{
			?>
				$('input:radio[name="order_1"][value="<?=$order_1?>"]').parent().addClass("checked");
				$('input:radio[name="order_1"][value="<?=$order_1?>"]').prop('checked', true );
			<?php
			}
			?>
    
            $('#order_by_2').html(innerHtml);
            <?php
				if(isset($order_by_field_2))
			{
			?>
				$('#order_by_2').select2('val', o2 );
			<?php
			}
			?>
			<?php
			if(isset($order_2))
			{
			?>
				$('input:radio[name="order_2"][value="<?=$order_2?>"]').parent().addClass("checked");
				$('input:radio[name="order_2"][value="<?=$order_2?>"]').prop('checked', true );
			<?php
			}
			?>

            $('#order_by_3').html(innerHtml);
            <?php
				if(isset($order_by_field_3))
			{
			?>
				$('#order_by_3').select2('val', o3 );
			<?php
			}
			?>
			<?php
			if(isset($order_3))
			{
			?>
				$('input:radio[name="order_3"][value="<?=$order_3?>"]').parent().addClass("checked");
				$('input:radio[name="order_3"][value="<?=$order_3?>"]').prop('checked', true );
			<?php
			}
			?>
			if(rlt_flg == "false"){


				$('#filter_1').html(innerHtml);

	            var num_cond = "<?=$num_c?>";
			
				var b ={};

				<?php 

				for($sk = 1 ; $sk < $num_c+1 ; $sk++)
				{
				?>
					$('#add_row').trigger('click');
					b['c_f_' + <?=$sk?>] = '<?=${"cond_f_" . $sk}?>';
					b['c_c_' + <?=$sk?>] = '<?=${"cond_c_" . $sk}?>';
					b['c_v_' + <?=$sk?>] = '<?=${"cond_v_" . $sk}?>';
					b['c_op_' + <?=$sk?>] = '<?=${"cond_op_" . $sk}?>';
					b['info_' + <?=$sk?>] = '<?=${"f_info_" . $sk}?>';
					
				<?php
	            	if(isset(${"cond_op_" . $sk}))
	            	{
	            ?>
	            		$('#cond_opt_'+<?=$sk?>).select2('val', "<?=${"cond_op_" . $sk}?>" );
	            <?php
	           		}
					if(isset(${"cond_f_" . $sk}))
					{
				?>
						$('#filter_'+<?=$sk?>).select2('val', "<?=${"cond_f_" . $sk}?>" );
				<?php
					}
					if(isset(${"cond_c_" . $sk}))
					{
				?>
						$('#cond_'+<?=$sk?>).select2('val', "<?=${"cond_c_" . $sk}?>" );
				<?php
					}
					if(isset(${"cond_v_" . $sk}))
					{
				?>
						if(b['info_' + <?=$sk?>] == "select" || b['info_' + <?=$sk?>] == "autocomplete")
						{
							$('#cond_val_'+<?=$sk?>).select2('val' , "<?=${"cond_v_" . $sk}?>" );
						}
						
						else if(b['info_' + <?=$sk?>] == "date" && b['c_c_' + <?=$sk?>] == "bw")
						{

							var date_arr = b['c_v_' + <?=$sk?>].split(" ");
							var df = date_arr[0];
							var dt = date_arr[1];
							$("#cond_drange_"+<?=$sk?>+" > input[name=dfrom]").val(df);
							$("#cond_drange_"+<?=$sk?>+" > input[name=dto]").val(dt);

						}
						else
						{
							$('#cond_val_'+<?=$sk?>).val("<?=${"cond_v_" . $sk}?>");
						}
				<?php
					}
				}
				?>
				
				$('#remove_row').trigger('click');
			}	
        });
    });

	$('#rnameedit').click(function(){

		if(chk_flag == "false")
		{
			$('#editing_alias').empty();

			var fl = "0";
			var myVal = [];
			if(this.value == 0)
			{
				myVal=[];
			}
			
			var item = $('#module_fields').val();
			item = item.toString();
			item = item.split(',');

			if($('#module_fields-error').length == 0 )
			{
				$('#module_fields').next().children().children().children().children('li.select2-selection__choice').each(function(index) {
					var single = $(this).attr('title');
					myVal.push(single);
				});
			}
			else
			{
				$('#module_fields').next().next().children().children().children().children('li.select2-selection__choice').each(function(index) {
					var single = $(this).attr('title');
					myVal.push(single);
				});
			}

			for(var i =0 ; i < myVal.length ; i++)
			{
				for(var j =0 ; j< item.length ; j++  )
				{
					var single_data = item[j].toString().split('|');
					if(myVal[i] == single_data[1])
					{
						myVal[i] = item[j] ;
						item.splice(j,1);
					}
				}
			}
	  			
	  		$('#modules_data').val(myVal);
	  		
	  		if(myVal != "")
	  		{
				var module_fields   = myVal;

				var field_array 	= [];
				var alias_array 	= [];

				if ( module_fields.length > 1 ) 
				{
				   var i=0; 
				   $.each(module_fields, function( index, value ) {

				   	value = value.toString();
				   	value = value.split("|");
				   	
				   	field_array[i] = value[0];
				   	alias_array[i] = value[1]; 
				   	i++;
					});
				}
				else
				{
					var fields_data = module_fields[0].toString().split("|");
					field_array[0] = fields_data[0];
					alias_array[0] = fields_data[1];
				}

				var j=0 ;
				var html = '';
				var rows = '<div class="row">';
				var rowe = '</div>';

				html = html + rows ;
				for(; j < field_array.length ; j++)
				{
					html = html + '<div class="col-md-3" style="margin-bottom:20px;"><input type="text" class="simpleText form-control" name="'+field_array[j]+'" value="'+alias_array[j]+'" id="'+field_array[j].replace('.','_')+'" /><br><p style="font-size:10px;margin-top: -18px;margin-left:1px;">'+field_array[j]+'</p></div>';

					if((j+1)%4 == 0)
					{
						html = html+rowe;
						html = html + rows;
					}
				}
				$(html).appendTo("#editing_alias");	
			}
		}
		else
		{
			jQuery('span', $('#uniform-rnameedit')).removeClass("checked");
			$("#editing_alias").css("display", "none");
			$('#module_fields').removeAttr('disabled');
			$('#rnameedit').attr('value' , "0");
			$('#rnameedit').attr('checked' , false);
			chk_flag="false";
		}	
    });

</script>