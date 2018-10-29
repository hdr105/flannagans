<?php 
if(isset($data) and !is_null($data))
{
 //echo "<pre>";
 //print_r($data);
 //exit;
 ////// NAME OF REPORT //////
 $name = $data[0]['rname'];

 //// PRIMARY MODULE //////
 $main_module = $data[0]['main_module'];

 //// RELATED MODULE //////
 $rlt_mod = $data[0]['related_modules'];
 $rm = explode(',',$rlt_mod);

 /////AUTO EMAIL/////////
 $atem = $data[0]['autoEmail'];
 
 /////FREQUENCY//////////
 $frc  = $data[0]['frequency'];
 
 ///// SELECTED FIELDS //////
 $slct_fields = $data[0]['selected_fileds'];
 $f = explode(',', $slct_fields);

 ///// FUNCTION FOR FIELDS AND ALIAS
 $data_of_func = $data[0]['func'];
 $data_sep = explode('^' , $data_of_func);
 $f_perf = $data_sep[0];
 $field_for_func = $data_sep[1];
 $alias = $data_sep[2];

 ///// GROUPED BY /////////
 $gno = $data[0]['group_n_order'];
 $fd = explode('^', $gno);
 
 ////// GROUP BY 1 ////////
 $gno_1 = $fd[0];
 $g_data_1 = explode(',', $gno_1);
 $group_by_field_1 = $g_data_1[0];
 $order_1 = $g_data_1[1];
 //echo "g1 : ".$group_by_field_1."<br>";
 //echo "o1 : ".$order_1."<br>";
 
 ////// GROUP BY 2 ///////
 $gno_2 = $fd[1];
 $g_data_2 = explode(',', $gno_2);
 $group_by_field_2 = $g_data_2[0];
 $order_2 = $g_data_2[1];
 //echo "g1 : ".$group_by_field_2."<br>";
 //echo "o1 : ".$order_2."<br>";

 ///// GROUP BY 3 //////
 $gno_3 = $fd[2];
 $g_data_3 = explode(',', $gno_3);
 $group_by_field_3 = $g_data_3[0];
 $order_3 = $g_data_3[1];
 //echo "g1 : ".$group_by_field_3."<br>";
 //echo "o1 : ".$order_3."<br>";
 //exit;
 
 ////// CONDITIONS //////
 $cond = $data[0]['conditions'];
 $cond = explode('^', $cond);

 ////FOR CONDITION 1 ///////////
 $data_cond_1 = explode(',', $cond[0]);
 $cond_f_1 = $data_cond_1[0];
 $cond_c_1= $data_cond_1[1];
 $cond_v_1 = $data_cond_1[2];
 /////////////////////////////////
 $chk_cond_1 = explode('|', $cond_f_1);
 $f_info_1 = $chk_cond_1[2];


 //////FOR CONDITION 2////////
 $data_cond_2 = explode(',', $cond[1]);
 $cond_f_2 = $data_cond_2[0];
 $cond_c_2= $data_cond_2[1];
 $cond_v_2= $data_cond_2[2];
 ////////////////////////////////
 $chk_cond_2 = explode('|', $cond_f_2);
 $f_info_2 = $chk_cond_2[2];


 /////// FOR CONDITION 3///////
 $data_cond_3 = explode(',', $cond[2]);
 $cond_f_3 = $data_cond_3[0];
 $cond_c_3= $data_cond_3[1];
 $cond_v_3= $data_cond_3[2];
 /////////////////////////////////
 $chk_cond_3 = explode('|', $cond_f_3);
 $f_info_3 = $chk_cond_3[2];

 ///////CUSTOM CONDITION ///////
 $cst = $data[0]['custom_condition'];
 $cst_data = explode('^', $cst);
 $cst_tag = $cst_data[0];
 $cst_val = $cst_data[1];
 $cst_fld = $cst_data[2];

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
								<div class="form-group">
									<label class="control-label col-md-3">Select Related Module 
									</label>
									<div class="col-md-4">

										<select class="form-control related_module modules select2-multiple" data-placeholder="Select..." name="related_modules" id="related_modules" multiple>
											<option></option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Auto Email</label>
									<div class="col-md-2">
										<input type="checkbox" name="autoEmail" value="<?php if(isset($atem) ){ echo $atem; }else{ echo '0';}?>" onclick="if(this.checked){showFreq(); this.value=1;}else{hideFreq(); this.value=0;}" id="autoEmail" class="form-control"/>
									</div>
									</div>
									<div class="form-group" id="show_freq" style="display:none;" >


									<label class="control-label col-md-3"> Frequency</label>
									</label>
									<div class="col-md-4">

									<select class="form-control select2" id="freq" name="freq">
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
								<!-- <div class="form-group">
									<label class="control-label col-md-3">Select Related Module 
									</label>
									<div class="col-md-4">

										<select class="form-control related_module modules select2" data-placeholder="Select..." name="related_module_3" id="related_module_3">
											<option></option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Select Related Module 
									</label>
									<div class="col-md-4">
										<select class="form-control related_module modules select2" data-placeholder="Select..." name="related_module_4" id="related_module_4">
											<option></option>
											
										</select>
									</div>
								</div> -->
								
								<!-- <div class="form-group">
									<label class="control-label col-md-3">Description 
									</label>
									<div class="col-md-4">
										<textarea name="report_des" class="form-control" cols="3"></textarea> 
										
									</div>
								</div> -->
								
							</div>
							<div class="tab-pane" id="tab2">
								<h3 class="block">Select columns, grouping and calculation to be applied</h3>
								
								<div class="form-group">
									<label class="control-label col-md-3">Select columns(MAX 25)<span class="required">
									* </span></label>
									<div class="col-md-4">
										<select id="module_fields" name="module_fields" class="form-control select2-multiple" multiple>
										<option></option>
											
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-md-3">Function</label>
									<div class="col-md-2">
										<select class="form-control select2" data-placeholder="Select..." name="funct_performed" id="funct_performed">
											<option value="">Select</option>
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
											<option value="0">Select</option>
										</select>
									</div>
										<label class="control-label col-md-1">AS</label>
									<div class="col-md-3">
										<input type="text" class="simpleText form-control" name="alias_name" value="<?php if(isset($alias)){ echo $alias;} ?>" id="alias_name" />
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-3">Group by</label>
									<div class="col-md-3">
										<select class="form-control select2" data-placeholder="Select..." name="group_by_1" id="group_by_1">
											<option value="0">Select</option>
										</select>	
									</div>
									<div class="col-md-4">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="order_by_1" id="order_by_1" value="Ascending"> Ascending </label>
											<label class="radio-inline">
											<input type="radio" name="order_by_1" id="order_by_1" value="Descending"> Descending </label>
										</div>
										
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-3">Group by</label>
									<div class="col-md-3">
										<select class="form-control select2" data-placeholder="Select..." name="group_by_2" id="group_by_2">
											<option value="0">Select</option>
										</select>
									</div>
									<div class="col-md-4">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="order_by_2" id="order_by_2" value="Ascending"> Ascending </label>
											<label class="radio-inline">
											<input type="radio" name="order_by_2" id="order_by_2" value="Descending"> Descending </label>

										</div>

									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-3">Group by</label>
									<div class="col-md-3">
										<select class="form-control select2" data-placeholder="Select..." name="group_by_3" id="group_by_3">
											<option value="0">Select</option>
										</select>
									</div>
									<div class="col-md-4">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="order_by_3" id="order_by_3" value="Ascending"> Ascending </label>
											<label class="radio-inline">
											<input type="radio" name="order_by_3" id="order_by_3" value="Descending"> Descending </label>

										</div>

									</div>
								</div>

									
								
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
<!-- ////faheem changes start //// -->

											<table>
												<tr class="filter_row" id="filter_row_1">
													<td class="col-md-3">
														<div class="form-group">
															
															<div class="col-md-12">
																<select class="form-control select2 filter" data-placeholder="Select..." name="filter_1" id="filter_1">
																	<option value="0">Select</option>
																</select>
															</div>
														</div>
													</td>
													<td class="col-md-3">
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
													</td>
													<td  class="col-md-3">
														<div class="form-group">
															
															<div class="col-md-12" id="dynamic_controll_1">
																<input type="text" class="simpleText
																 form-control cond_val " name="cond_val_1" id="cond_val_1" />
																<select class="sm" style="display:none;" class="form-control input-large select2 input-sm" data-placeholder="Select...">
																</select>
															</div>
														</div>
													</td>

													<td   class="col-md-1" style="vertical-align:top;">
													<!--<div class="btn-group">
															<a href="javascript:;" class="btn btn-icon-only red">
														<i class="fa fa-times"></i>
														</a>
														<a href="javascript:;" class="btn btn-icon-only green" onclick="addAndRow('filter_row_1');">
														<i class="fa fa-plus"></i>
														</a>
														</div>-->
													</td>
												</tr>

												<tr class="filter_row" id="filter_row_1">
													<td class="col-md-3">
														<div class="form-group">
															
															<div class="col-md-12">
																<select class="form-control select2 filter" data-placeholder="Select..." name="filter_2" id="filter_2">
																<option value="0">Select</option>
																	
																	
																	
																</select>
															</div>
														</div>
													</td>
													<td class="col-md-3">
														<div class="form-group">
															
															<div class="col-md-12">
																<select class="form-control select2 cond cond_2" data-placeholder="Select..." name="cond_2" id="cond_2">
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
													</td>
													<td  class="col-md-3">
														<div class="form-group">
															
															<div class="col-md-12" id="dynamic_controll_2">
																<input type="text" class="simpleText
																 form-control cond_val " name="cond_val_2" id="cond_val_2" />
																<select class="sm" style="display:none;" class="form-control input-large select2 input-sm" data-placeholder="Select...">
																</select>
															</div>
														</div>
													</td>

													<td   class="col-md-1" style="vertical-align:top;">
													<!--<div class="btn-group">
															<a href="javascript:;" class="btn btn-icon-only red">
														<i class="fa fa-times"></i>
														</a>
														<a href="javascript:;" class="btn btn-icon-only green" onclick="addAndRow('filter_row_1');">
														<i class="fa fa-plus"></i>
														</a>
														</div>-->
													</td>
												</tr>

												<tr class="filter_row" id="filter_row_1">
													<td class="col-md-3">
														<div class="form-group">
															
															<div class="col-md-12">
																<select class="form-control select2 filter" data-placeholder="Select..." name="filter_3" id="filter_3">
																<option value="0">Select</option>
																	
																	
																	
																</select>
															</div>
														</div>
													</td>
													<td class="col-md-3">
														<div class="form-group">
															
															<div class="col-md-12">
																<select class="form-control select2 cond cond_3" data-placeholder="Select..." name="cond_3" id="cond_3">
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
													</td>
													<td  class="col-md-3">
														<div class="form-group">
															
															<div class="col-md-12" id="dynamic_controll_3">
																<input type="text" class="simpleText
																 form-control cond_val " name="cond_val_3" id="cond_val_3" />
																<select class="sm" style="display:none;" class="form-control input-large select2 input-sm" data-placeholder="Select...">
																</select>
															</div>
														</div>
													</td>

													<td   class="col-md-1" style="vertical-align:top;">
													<!--<div class="btn-group">
															<a href="javascript:;" class="btn btn-icon-only red">
														<i class="fa fa-times"></i>
														</a>
														<a href="javascript:;" class="btn btn-icon-only green" onclick="addAndRow('filter_row_1');">
														<i class="fa fa-plus"></i>
														</a>
														</div>-->
													</td>
												</tr>
												<!-- ////faheem changes end //// -->

											</table>
											<div class="form-group" style="margin-left:3px;">
												<div>
													<label class="control-label col-md-3"> Custom Condition</label>
												</div>
											</div>

											<div class="form-group" style="margin-left:3px;">


												<div class="col-md-4">

													<select class="form-control select2" id="cond_4" name="cond_4">
														<option value=""></option>

														<?php


														$option = array('Current Day','Current Week','Last Week','Current Month','Current Year', 'Last Year' , 'Other');
														$str='';
														$i = 1;


														foreach($option as $o)
														{
															if($cst_val == $i)
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

												<div class="col-md-4" id="dynamic_controll_4">
													<input type="text" class="simpleText
												form-control cond_val " name="cond_val_4" id="cond_val_4" style="display:none;" />

													<select id="filter_4" class="form-control input-large select2 input-sm" data-placeholder="Select...">
													</select>
												</div>
											

											</div>
												
										</div>
									</div>
								</div>
									
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
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<script type="text/javascript">
	$(document).ready(function(){
		$('.required').parent().parent().find('.form-control').prop('required',true);
		$(".select2, .select2-multiple").select2({
                placeholder: "Select...",
                width: null,
            	allowClear: true,
				templateResult: formatOutput
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

        var e = "<?=$atem?>";
		if( e==1 )
		{
			jQuery('span', $('#uniform-autoEmail')).addClass("checked");
			$('#autoEmail').attr('checked');
			$("#show_freq").css("display", "block");
		}

		<?php
		if(isset($main_module) )
		{
		?>
			$('#sel_module').val('<?=$main_module ?>' ).trigger('change');
		<?php
		}
		?>  
		$("#related_modules").parent().parent().hide();

		<?php
		if( !isset($cst_data))
		{
		?>
			$("#dynamic_controll_4").css("display", "none");
		<?php
		}
		?>

	}); 

	function showFreq(){
		document.getElementById("show_freq").style.display ='block';
	} 

	function hideFreq(){
		document.getElementById("show_freq").style.display = 'none';
	} 

    function saveReport(){
        var report_name         = $('input[name="report_name"]').val();
        var sel_module          = $('#sel_module option:selected').val();
        var related_modules     = $('#related_modules').val();
        var report_des          = $('input[name="report_des"]').val();
        var module_fields       = $('#module_fields').val();
        
        var func_perf   =$('#funct_performed option:selected').val();
        var func_field          =$('#funct_fields option:selected').val();
        var alias_name          =$('#alias_name').val();

        var auto                = $('input[name="autoEmail"]').val();
        var freq     = $('#freq option:selected').val();
         
         if(auto == 0)
         {
          freq = "";
         }

        //var custom = $('#cust_cond').val();


        var group_by_1          = $('#group_by_1 option:selected').val();
        var group_by_2          = $('#group_by_2 option:selected').val();
        var group_by_3          = $('#group_by_3 option:selected').val();
        
        var order_by_1          = $('input[name="order_by_1"]:checked').val();
        var order_by_2          = $('input[name="order_by_2"]:checked').val();
        var order_by_3          = $('input[name="order_by_3"]:checked').val();

/////////////////////////////////////////////////////
        var filter_1            = $('#filter_1 option:selected').val();
        var cond_1              = $('#cond_1 option:selected').val();
        
        var f_input_1           = $('input[name="cond_val_1"]').val();
        var f_select_1          = $('#cond_val_1 option:selected').val();
        var dfrom_1    = $("#cond_drange_1 > input[name=dfrom]").val();
        var dto_1     = $("#cond_drange_1 > input[name=dto]").val();
        var cond_val_1          ="";


        if(f_input_1 == undefined && f_select_1 != undefined && (dfrom_1 == undefined && dto_1 == undefined))
        {
         cond_val_1      =  f_select_1;
        }
        else if(f_input_1 != undefined && f_select_1 == undefined && (dfrom_1 == undefined && dto_1 == undefined))
        {
         cond_val_1      =  f_input_1;
        }
        else
        {
         cond_val_1 = dfrom_1 + " " +dto_1 ;
        }

       

/////////////////////////////////////////////////////////////////
     
        var filter_2            = $('#filter_2 option:selected').val();
        var cond_2              = $('#cond_2 option:selected').val();
        var f_input_2           = $('input[name="cond_val_2"]').val();
        var f_select_2          = $('#cond_val_2 option:selected').val();
        var dfrom_2    = $("#cond_drange_2 > input[name=dfrom]").val();
        var dto_2     = $("#cond_drange_2 > input[name=dto]").val();
        var cond_val_2          ="";

        if(f_input_2 == undefined && f_select_2 != undefined && (dfrom_2 == undefined && dto_2 == undefined))
        {
         cond_val_2      =  f_select_2;
        }
        else if(f_input_2 != undefined && f_select_2 == undefined && (dfrom_2 == undefined && dto_2 == undefined))
        {
         cond_val_2      =  f_input_2;
        }
        else
        {
         cond_val_2 = dfrom_2 + " " +dto_2 ;
        }
        

////////////////////////////////////////////////////////////////

        var filter_3            = $('#filter_3 option:selected').val();
        var cond_3              = $('#cond_3 option:selected').val();
        var f_input_3           = $('input[name="cond_val_3"]').val();
        var f_select_3          = $('#cond_val_3 option:selected').val();
        var dfrom_3    = $("#cond_drange_3 > input[name=dfrom]").val();
        var dto_3     = $("#cond_drange_3 > input[name=dto]").val();
        var cond_val_3          ="";

        if(f_input_3 == undefined && f_select_3 != undefined && (dfrom_3 == undefined && dto_3 == undefined))
        {
         cond_val_3      =  f_select_3;
        }
        else if(f_input_3 != undefined && f_select_3 == undefined && (dfrom_3 == undefined && dto_3 == undefined))
        {
         cond_val_3      =  f_input_3;
        }
        else
        {
         cond_val_3 = dfrom_3 + " " +dto_3 ;
        }
        

//////////////////////////////////////////////////////////////////////

		var cust_cond = $('#cond_4').val();
		var cust_select_val = $('#filter_4').val();
		var cust_input_val = $('#dynamic_controll_4 > input[name=cond_val_4').val();
		var cust_val = "";

		if(cust_select_val == undefined || cust_select_val == '')
		{
			cust_val = cust_input_val;
		}
		else
		{
			cust_val = cust_select_val;
		}

//////////////////////////////////////////////////////

		var custom        =[cust_cond , cust_val];
        var funct         =[func_perf , func_field , alias_name];
        var groupby       = [[group_by_1,order_by_1],[group_by_2,order_by_2],[group_by_3,order_by_3]];
        var conditions     = [[filter_1,cond_1,cond_val_1],[filter_2,cond_2,cond_val_2],[filter_3,cond_3,cond_val_3]]; 
        var jsonData = {report_name,sel_module, auto , freq , related_modules, module_fields, groupby, funct, conditions, custom};
//////faheem changes end ////////
        var json_string = JSON.stringify(jsonData);
        //console.log(json_string);

        $.post('<?php echo base_url(); ?>index.php/admin/reports/saveReport?id=<?=$_GET['key']['reports.id']?>', {jsonData:jsonData}, function(data){
            //console.log('returned Data: ' + data);
        });
        window.location = '<?php echo base_url(); ?>index.php/admin/scrud/browse?com_id=31';   
    }
    
    $('.filter').on('change',function(){
        var cutId           = (this.id).split('_');
        var thisId          = '#' + this.id;
        var selectedValue   = $(thisId + ' option:selected').val();
        console.log("selectedValue: "+selectedValue);
        var typeArr         = (selectedValue).split('|');
        console.log("typeArr: "+typeArr);
        var textBoxIdExHash = 'cond_val_' + cutId[1];
        var textBoxId       = '#cond_val_' + cutId[1];
        var parentControl   = '#dynamic_controll_' + cutId[1];
        var condBox         = '#cond_' + cutId[1];
 
    	////faheem changes start ////
    	$(parentControl).html('<input type="text" class="simpleText form-control cond_val" name="'+textBoxIdExHash+'" id="'+textBoxIdExHash+'"><select  style="display:none;" data-placeholder="Select..." id=""></select>');
        ////faheem changes end ////

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
            //alert('autocomplete type');
            $(parentControl).find('select').select2().attr('style' , 'width:300px;');
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
                //console.log(output);
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
    }
    $('#sel_module').on('change',function(){
        var selectedModule = $( "#sel_module option:selected" ).val();
    
        var qjson = {};
        qjson['main_table'] = selectedModule;
        $('#qjson').val(JSON.stringify(qjson));
        $.post('<?php echo base_url(); ?>admin/reports/get_related', {moduleName:selectedModule}, function(data){
            console.log(JSON.stringify(data));
            var obj = JSON.parse(data);
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
				$('#related_modules').val(rm_new).trigger('change');

			<?php
			}
			?>
/*            $('#group_by_1').append(html);
			<?php
				if(isset($group_by_field))
			{
			?>
				$('#group_by_1').select2('val', g1 );
			<?php
				}
			?>
*/
			/*$('#filter_1').append(html);
        });*/

            ///// faheem changes start /////////////

            
        });

        //var valControl = '';

        //console.log(valControl);

        var rm = "";//valControl.join();

        var selectedModule = $( "#sel_module option:selected" ).val();
        $.post('<?php echo base_url(); ?>index.php/admin/reports/relatedModFieldList', {selectedModule:selectedModule, relatedModules:rm}, function(data){
            var obj = JSON.parse(data);
            //console.log(data);
            var innerHtml = '<option value="">Select...</option>';
            for (var i = 0; i < (obj.length-1); i++) {
                //console.log('optons: ' + JSON.stringify(obj[i].moduleInfo));
                var optionValues = '';
                var array2 = obj[i].moduleInfo;
                for (var a = 0; a < array2.length; a++) {
                    optionValues = optionValues+ '<option value="'+array2[a][2]+'|'+array2[a][0]+'|'+array2[a][1]+'">' +array2[a][0] + '</option>';
                }
                //console.log('optons: ' + optionValues);
                innerHtml = innerHtml+ '<optgroup label="'+obj[i].moduleName+'" style="color:#000;">' + optionValues + '</optgroup>';
            };
            $('#module_fields').html(innerHtml);
			$('#funct_fields').html(innerHtml);
            $('#group_by_1').html(innerHtml);
            $('#group_by_2').html(innerHtml);
            $('#group_by_3').html(innerHtml);
            $('#filter_1').html(innerHtml);
            $('#filter_2').html(innerHtml);
            $('#filter_3').html(innerHtml);
            $('#filter_4').html(innerHtml);
        });


        /////// faheem changes end //////////////////////
    });
    $('#related_modules').on('change',function(){

        var valControl = $(this).val();

        //console.log(valControl);

        //var rm = valControl.join();
        var rm="";

        if(valControl != null)
        {
        	rm = valControl.join();
        }

        var selectedModule = $( "#sel_module option:selected" ).val();
        $.post('<?php echo base_url(); ?>index.php/admin/reports/relatedModFieldList', {selectedModule:selectedModule, relatedModules:rm}, function(data){
            var obj = JSON.parse(data);
            //console.log(data);
            var innerHtml = '<option value="">Select...</option>';

            var inner_date_Html = '<option value="">Select...</option>';

            var new_f = <?=json_encode($f) ?>;//added by fahe
			
			///////added by fahe////////
            var g1 = "<?=$group_by_field_1?>";
            var g2 = "<?=$group_by_field_2?>";
            var g3 = "<?=$group_by_field_3?>";
            var ff = "<?=$field_for_func?>";
            var c_f_1 = "<?=$cond_f_1?>";
            var c_f_2 = "<?=$cond_f_2?>";
            var c_f_3 = "<?=$cond_f_3?>";
            var c_c_1 = "<?=$cond_c_1?>";
            var c_c_2 = "<?=$cond_c_2?>";
            var c_c_3 = "<?=$cond_c_3?>";

            var c_v_1 = "<?=$cond_v_1?>";
            var info_1= "<?=$f_info_1?>";

            var c_v_2 = "<?=$cond_v_2?>";
            var info_2= "<?=$f_info_2?>";

            var c_v_3 = "<?=$cond_v_3?>";
            var info_3= "<?=$f_info_3?>";

            var custom_data = "<?=$cst_fld?>";
            //////////////////////////////

            //console.log("f: "+new_f);
            for (var i = 0; i < obj.length; i++) {
                //console.log('optons: ' + JSON.stringify(obj[i].moduleInfo));
                var optionValues = '';

                var dateValues = ''; // 

                var array2 = obj[i].moduleInfo;
            	//console.log("array2: "+array2);
                for (var a = 0; a < array2.length; a++) {
	                //optionValues = optionValues+ '<option value="'+array2[a][2]+'|'+array2[a][0]+'|'+array2[a][1]+'">' +array2[a][0] + '</option>';
	                if(array2[a][1] == "date")
					{
						dateValues = dateValues+ '<option value="'+array2[a][2]+'|'+array2[a][0]+'|'+array2[a][1]+'">' +array2[a][0] + '</option>';
						optionValues = optionValues+ '<option value="'+array2[a][2]+'|'+array2[a][0]+'|'+array2[a][1]+'">' +array2[a][0] + '</option>';
					}
					else
					{
						optionValues = optionValues+ '<option value="'+array2[a][2]+'|'+array2[a][0]+'|'+array2[a][1]+'">' +array2[a][0] + '</option>';
					}
				}

                //console.log('optons: ' + optionValues);
                innerHtml = innerHtml+ '<optgroup label="'+obj[i].moduleName+'" style="color:#000;">' + optionValues + '</optgroup>';

                inner_date_Html = inner_date_Html+ '<optgroup label="'+obj[i].moduleName+'" style="color:#000;">' + dateValues + '</optgroup>';
            };
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
				if(isset($group_by_field_1))
			{
			?>
				$('#group_by_1').select2('val', g1 );
			<?php
				}
				if(isset($order_1))
			{
			?>
			$('input:radio[name="order_by_1"][value="<?=$order_1?>"]').parent().addClass("checked");
			$('input:radio[name="order_by_1"][value="<?=$order_1?>"]').prop('checked', true );
			<?php
				}
			?>
            $('#group_by_2').html(innerHtml);
            <?php
		    if(isset($group_by_field_2))
		   {
		   ?>
		    $('#group_by_2').select2('val', g2 );
		   <?php
		    }
			if(isset($order_2))
			{
			?>
			$('input:radio[name="order_by_2"][value="<?=$order_2?>"]').parent().addClass("checked");
			$('input:radio[name="order_by_2"][value="<?=$order_2?>"]').prop('checked', true );
			<?php
				}
			?>
		            $('#group_by_3').html(innerHtml);
		            <?php
		    if(isset($group_by_field_3))
		   {
		   ?>
		    $('#group_by_3').select2('val', g3 );
		   <?php
		    }
		    if(isset($order_3))
			{
			?>
			$('input:radio[name="order_by_3"][value="<?=$order_3?>"]').parent().addClass("checked");
			$('input:radio[name="order_by_3"][value="<?=$order_3?>"]').prop('checked', true );
			<?php
				}
		   ?>
            ///// faheem changes start /////////////

            $('#filter_1').html(innerHtml);
			<?php
			if(isset($cond_f_1))
			{
			?>
				$('#filter_1').select2('val', c_f_1 );

				$('#cond_1').select2('val', c_c_1  );

				if(info_1 == "select" || info_1 == "autocomplete")
			    {
			     	console.log("info_1 : "+c_v_1);
			     	$('#cond_val_1').select2('val' , c_v_1 );
			    }
			    
			    else  if (info_1 == "date" && c_c_1 != "bw")
			    {
			     	$('#cond_val_1').val(c_v_1);
			    }
			    else if(info_1 == "date" && c_c_1 == "bw")
			    {
				     var date_arr = c_v_1.split(" ");
				     var df = date_arr[0];
				     var dt = date_arr[1];
				     //console.log("df : "+df+" dto : "+dt);
				     $("#cond_drange_1 > input[name=dfrom]").val(df);
				     $("#cond_drange_1 > input[name=dto]").val(dt);
			    }
			    else
			    {
			     $('#cond_val_1').val(c_v_1);
			    }

			<?php
			}
			?>
            $('#filter_2').html(innerHtml);
			<?php
			if(isset($cond_f_2))
			{
			?>
				$('#filter_2').select2('val', c_f_2 );

				$('#cond_2').select2('val', c_c_2 );

			    if(info_2 == "select" || info_2 == "autocomplete")
			    {
			     	$('#cond_val_2').select2('val' , c_v_2 );
			    }
			    
			    else  if (info_2 == "date" && c_c_2 != "bw")
			    {
			     	$('#cond_val_2').val(c_v_2);
			    }
			    else if(info_2 == "date" && c_c_2 == "bw")
			    {
				     var date_arr = c_v_2.split(" ");
				     var df = date_arr[0];
				     var dt = date_arr[1];
				     // console.log("length : "+date_arr.length);
				     // console.log("df : "+df);
				     // console.log("dt : "+dt);
				     $("#cond_drange_2 > input[name=dfrom]").val(df);
				     $("#cond_drange_2 > input[name=dto]").val(dt);
			    }
			    else
			    {
			     $('#cond_val_2').val(c_v_2);
			    }

			<?php
			}
			?>
            $('#filter_3').html(innerHtml);
			<?php
			if(isset($cond_f_3))
			{
			?>
				$('#filter_3').select2('val', c_f_3 );

				$('#cond_3').select2('val', c_c_3 );

			    if(info_3 == "select" || info_3 == "autocomplete")
			    {
				    console.log("info_3 : "+info_3);
				    console.log($('#cond_val_3').html());
			     	$('#cond_val_3').select2('val' , c_v_3 );
			    }
			    
			    else  if (info_3 == "date" && c_c_3 != "bw")
			    {
			     	$('#cond_val_3').val(c_v_3);
			    }
			    else if(info_3 == "date" && c_c_3 == "bw")
			    {
				     var date_arr = c_v_3.split(" ");
				     var df = date_arr[0];
				     var dt = date_arr[1];
				     //console.log("df : "+df+" dto : "+dt);
				     $("#cond_drange_3 > input[name=dfrom]").val(df);
				     $("#cond_drange_3 > input[name=dto]").val(dt);
			    }
			    else
			    {
			     	$('#cond_val_3').val(c_v_3);
			    }

			<?php
			}
			?>

			$('#filter_4').html(inner_date_Html);
   
			<?php

			if(isset($cst_data))
			{
				if(trim($cst_val) == 7)
				{
				?>
					$('#cond_4').val(7).trigger('change');

					$('#dynamic_controll_4 > input[name=cond_val_4').val(custom_data);

				<?php
				}
				else
				{
				?>

					$('#filter_4').select2('val', custom_data );

			<?php
				}
			}
			?>
        });
    });

	$('#cond_4').on('change' , function(){


		$("#dynamic_controll_4").css("display", "block");
		var cfd = '<?=$cst_tag?>';

		var c = $('#cond_4 option:selected').val();
		if(c == 7)
		{
			<?php
			if(isset($cst_data))
			{
			?>
				$('#dynamic_controll_4 > input[name=cond_val_4]').val(cfd);
			<?php
			}
			?>
			$("#filter_4").css("display" , "none");//style.display ='none';
			$('#select2-filter_4-container').parent().parent().parent().css("display" , "none");
			$("#cond_val_4").css("display" , "block"); //style.display ='block';
			$("#cond_val_4").width('400px');

		}
		else
		{
			$("#filter_4").css("display" , "block"); //style.display ='block';
			$('#select2-filter_4-container').parent().parent().parent().css("display" , "block");
			$("#cond_val_4").css("display" , "none"); //style.display ='none';
		}


	});


</script>