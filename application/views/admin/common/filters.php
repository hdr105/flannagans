<?php 
$comid = $_GET['comid'];
if(isset($_GET['f'])){
	$filter_id = $_GET['f'];
	//Name Block Start
	$data_existing = $this->db->get_where('filters',array('id'=>$filter_id))->row_array();
	//Filter Name
	$filter_name 		= $data_existing['name'];
	
	//Name Block END
	
	//COLUMNS Block Start
	$details = $data_existing['details'];
	$all_details = explode(',',$details);
	$data = json_decode($details);
	$fields = $data->fields;
	$field = explode(',',$fields);
	
	$this->db->select('*');
	$this->db->from('crud_components');
	$this->db->where('id',$comid);
	$query = $this->db->get();
	$com = $query->row_array();
	$_GET['table'] = $com['component_table'];
	
	if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$comid). '/' . $com['component_table'] . '.php')) {
		exit;
	}
	
	$content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$comid) . '/' . $com['component_table'] . '.php'));
	
	$conf = unserialize($content);
	
	foreach($field as $value){
		foreach($conf['form_elements'] as $fk => $fv){
			foreach($fv['section_fields'] as $fki => $fvi){
				if($value == $fki){
					$final_fields[] = $value . "|" .$fv['section_fields'][$fki]['alias'] . "|" .$fv['section_fields'][$fki]['element'][0];
				}
			}
		}
	}
	//COLUMNS Block END
	
	//CONDITION Block STARTS
	if(empty($data->cond)){
		$final_fields_cond = '';
		$condition_operator = '';
		$condition_text = '';
	} else {
		$final_fields_cond = $data->cond_field;
		$condition_operator = $data->cond_operator;
		$condition_text = $data->cond_value;
	}
	//COLUMNS Block END
} else {
	$filter_id = '';
	$filter_name = '';
	$final_fields = '';
	$final_fields_cond = '';
	$condition_operator = '';
	$condition_text = '';
}
?>
			<div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="<?php echo base_url(); ?>">Dashboard</a><i class="fa fa-circle"></i>
                            </li>
                            <li>
							<?php if(isset($_GET['f'])){?>
								<span> Edit Filter</span>   
							<?php } else { ?>
								<span> Add Filter</span>   
							<?php } ?>
							</li>
                        </ul>
                    </div>
                	<h3 class="page-title"> Filters</h3>
					<div class="row">
						<div class="col-md-12">
							<div class="portlet light bordered">
								<form action="javascript:;" id="filter_form"  class="form-horizontal"  novalidate="novalidate">
									<div id="frm_accordion" class="panel-group accordion">
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a href="#frm_accordion_1" data-parent="#frm_accordion" data-toggle="collapse" class="accordion-toggle accordion-toggle-styled" aria-expanded="true"> Provide basic details for filter </a>
												</h4>
											</div>
											<div class="panel-collapse collapse in" id="frm_accordion_1" aria-expanded="true" style="">
												<div class="panel-body">
													<div class="row">
														<div class=" col-md-6 ">
															<div class="form-group">
																<label class="control-label col-md-4">Filter Name <span class="required"> * </span></label>
																<div class="col-md-12  col-md-8 ">
																	<input type="hidden" name="comid" id="comid" value="<?php echo $comid; ?>">
																	<input type="text" class="form-control" name="report_name" value="<?php echo $filter_name; ?>"/>
																	<input type="hidden" id="filter_name"/>
																	<span class="help-block"> Provide your filter name </span>
																</div>
															</div>
														</div>
														<div class=" col-md-6 ">
															<div class="form-group">
																<label class="control-label col-md-4">Primary Module <span class="required"> * </span></label>
																<div class="col-md-12  col-md-8 ">
																	<select class="form-control select2" data-placeholder="Select..." name="sel_module" id="sel_module">
																		<option></option>
																		<?php foreach ($coms as $key => $value) { ?>
																				<option value="<?php echo $key; ?>" <?php if($comid == $key){?> selected <?php } ?>><?php print_r($value['title']); ?></option>
																		<?php } ?>
																	</select>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label col-md-6"> Select Columns (MIN 2, MAX 8)<span class="required"> * </span></label>
																<div class="col-md-12  col-md-8">
																	<select id="module_fields" name="module_fields" class="form-control select2" multiple></select>
																</div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label col-md-6"> Select as Default</label>
																<div class="col-md-12  col-md-8">
																	<input id="defaultcheck" class="form-control"  name="defaultcheck" type="checkbox">
																</div>
															</div>
														</div>
													</div>

													<div class="row">
														
														<div class="col-md-6">
															<div class="form-group">
															   <label class="control-label col-md-12   "> Access</label>
															   <div class="col-md-12  col-md-8 ">
															      <div class="radio-list">
															         <label class="radio-inline" style="margin-bottom:9px;">
															            <div class="radio" id=""><input name="filter_access" id="filter_access" checked value="2" type="radio" ></div>
															            Public
															         </label>
															      </div>
															      <div class="radio-list">
															         <label class="radio-inline" style="margin-bottom:9px;">
															            <div class="radio" id=""><input name="filter_access" id="filter_access" value="1" type="radio" ></div>
															            Private
															         </label>
															      </div>
															      
															   </div>
															</div>													
														</div>
													</div>
													<div class="row">
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
																						<select class="form-control select2 filter" data-placeholder="Select..." name="fileds_for_cond" id="filter_1">
																						<option></option>
																						</select>
																					</div>
																				</div>
																			</td>
																			<td class="col-md-3">
																				<div class="form-group">
																					<div class="col-md-12">
																						<select class="form-control select2 cond cond_1" data-placeholder="Select..." name="cond_1" id="cond_1">
																							<option></option>
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
																					<div class="col-md-12">
																						<div id="dynamic_controll_1">
																							<input type="text" class="form-control cond_val simpleText" name="cond_val_1" id="cond_val_1" />
																							<select class="form-control input-large select2 input-sm" data-placeholder="Select...">
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
														<div class=" col-md-12">
															<div class="form-actions">
																<div class="row">
																	<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right;">
																		 <button type="submit" class="btn green" onclick="saveFilter();"><span class="md-click-circle md-click-animate" style="height: 73px; width: 73px; top: -17.5px; left: -16.5px;"></span>Save Filter</button>
																		 <a class="btn btn-info" onclick="goBack()"  > &nbsp;  <i class="icon-ok icon-white"></i>  <?php echo "Cancel"; ?> &nbsp; </a>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="clearfix"></div>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		<script>
			// AUTO LOAD MODULE TYPE DATA START
			$( document ).ready(function() {
				$('#module_fields').select2({
					placeholder: "Select Fields",
					allowClear: true
				});
				
				var comid = $('input[name="comid"]').val();
				if (comid != '') {
					loadFields();
				}
				
				$('#dynamic_controll_1 select').hide();
				$('#dynamic_controll_1 span').hide();
				
				$('input[name="report_name"]').keyup(function(){
					var filter_name = $('input[name="report_name"]').val();
					$.post('<?php echo base_url(); ?>index.php/admin/filters/existing_filter', {filter_name:filter_name , comid:comid}, function(data){
						if(data > 0){
							$('#filter_name').val('1');
						} else {
							$('#filter_name').val('');
						}
					});
				}); 
		    });
			// AUTO LOAD MODULE TYPE DATA END

			//LOAD FIELDS DATA OF TABLES START
			$('#sel_module').on('change',function(){
				loadFields();
			});
			
			function loadFields(){
				var selectedModule = $( "#sel_module option:selected" ).val();
				$.post('<?php echo base_url(); ?>index.php/admin/filters/get_fields', {moduleName:selectedModule}, function(data){
					var obj = JSON.parse(data);
					//console.log(data);
					var jarr = obj['fields'][0]['moduleInfo'][0];
					var innerHtml = '';
					for (var i = 0; i < obj['fields'][0]['moduleInfo'].length; i++) {
						var optionValues = '';
						var final_fields 		= <?php echo json_encode($final_fields); ?>;
						var final_fields_cond 	= <?php echo json_encode($final_fields_cond); ?>;
						//console.log(final_fields[i]);
						var array2 = obj['fields'][0]['moduleInfo'][i];
						if(array2[1]=='hidden' || array2[1]=='empty' || array2[1]=='password'){
							continue;
						}
						optionValues = optionValues+ '<option value="'+array2[2]+'|'+array2[0]+'|'+array2[1]+'">' +array2[0] + '</option>';
						innerHtml = innerHtml + optionValues;
					};
					$('#module_fields').html(innerHtml);
					$('#filter_1').html(innerHtml);
					$('#module_fields').select2('val', final_fields);
					$('#filter_1').select2('val', final_fields_cond);
				});
			}
			
			// get filter field types 
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
					$(parentControl+' select').hide();
					$(parentControl+' span').hide();
					$(parentControl).find('select').attr('id','');
					$(parentControl).find('div').remove();
					$(parentControl).find('input[type="text"]').addClass('date-picker').datepicker({ format: 'dd-mm-yyyy' });
					$(parentControl).find('input[type="text"]').datepicker('enable');
					$(parentControl).find('input[type="text"]').datepicker({ format: 'dd-mm-yyyy' });
					$(parentControl).find('input[type="text"]').attr('id',textBoxIdExHash);
					$(parentControl).find('input[type="text"]').attr('name',textBoxIdExHash);
					$(parentControl).find('input[type="text"]').show();
					var dateOptions = '<option></option>'+
								'<option value="e">equals</option>'+
								'<option value="n">not equal to</option>'+
								//'<option value="bw">between</option>'+
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
					var condition_text = '<?php echo $condition_text; ?>';
					$(parentControl).find('input[type="text"]').val(condition_text);
				} else 
				// If field type is autocomplete or select
				if (typeArr[2] == 'autocomplete' || typeArr[2] == 'select' || typeArr[2] == 'radio' || typeArr[1]=='checkbox') {
					$(parentControl+' select').show();
					$(parentControl+' span').show();
					$(parentControl).find('select').select2();
					$(parentControl).find('select').show();
					$(parentControl).find('select').attr('id',textBoxIdExHash);
					$(parentControl).find('select').attr('name',textBoxIdExHash);
					$(parentControl).find('input[type="text"]').attr('id','');
					$(parentControl).find('input[type="text"]').attr('name','');
					$(parentControl).find('input[type="text"]').css('display','none');
					// console.log(selectedValue);return 0;
					// Get fields from controller
					$.post('<?php echo base_url(); ?>index.php/admin/filters/field_data', {data:typeArr[0]}, function(output){
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
						var condition_text = '<?php echo $condition_text; ?>';
						$(parentControl).find('select').html(opt);             
						$(parentControl).find('select').select2('val', condition_text);
					});
				} else
				// if field type is text
				if (typeArr[2] == 'image') {
					$(parentControl+' select').hide();
					$(parentControl+' span').hide();
					$(parentControl).find('select').attr('id','');
					$(parentControl).find('div').remove();
					$(parentControl).find('input[type="text"]').removeClass('date-picker'); //
					$(parentControl).find('input[type="text"]').datepicker('remove');
					$(parentControl).find('input[type="text"]').attr('id',textBoxIdExHash);
					$(parentControl).find('input[type="text"]').show();
					$(parentControl).find('input[type="text"]').val('');
					var textOptions = '<option></option>'+
									'<option value="y">is empty</option>'+
									'<option value="ny">is not empty</option>';
					$(condBox).select2({
						placeholder: "select..."
					}); 
					$(condBox).each(function () { //added a each loop here
						$(this).select2('val', '')
					});
					$(condBox).html(textOptions);
					var condition_text = '<?php echo $condition_text; ?>';
					$(parentControl).find('input[type="text"]').val(condition_text);
				} else
				// if field type is text
				if (typeArr[2] == 'text') {
					$(parentControl+' select').hide();
					$(parentControl+' span').hide();
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
					var condition_text = '<?php echo $condition_text; ?>';
					$(parentControl).find('input[type="text"]').val(condition_text);
				} else
				if (typeArr[2] == 'currency') {
					$(parentControl+' select').hide();
					$(parentControl+' span').hide();
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
					var condition_text = '<?php echo $condition_text; ?>';
					$(parentControl).find('input[type="text"]').val(condition_text);
				} else {
					$(parentControl+' select').hide();
					$(parentControl+' span').hide();
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
					var condition_text = '<?php echo $condition_text; ?>';
					$(parentControl).find('input[type="text"]').val(condition_text);
				}
				
				var condition_text = '<?php echo $condition_text; ?>';
				var condition_operator = '<?php echo $condition_operator; ?>';
				
				/* if(/^[a-zA-Z0-9- ]*$/.test(condition_operator) == true){
					condition_operator_final = condition_operator + ' ' +condition_text;
				} else {
				} */
				
				condition_operator_final = condition_operator;
				
				if(condition_operator_final=='='){
					$(condBox).select2('val', 'e');
				} else if(condition_operator_final=='!='){
					$(condBox).select2('val', 'n');
				} else if(condition_operator_final=='ENDSWITH'){
					$(condBox).select2('val', 'ew');
				} else if(condition_operator_final=='STARTSWITH'){
					$(condBox).select2('val', 's');
				} else if(condition_operator_final=='NOTIN'){
					$(condBox).select2('val', 'k');
				} else if(condition_operator_final=='=""'){
					$(condBox).select2('val', 'y');
				} else if(condition_operator_final=='!=""'){
					$(condBox).select2('val', 'ny');
				} else if(condition_operator_final=='<'){
					$(condBox).select2('val', 'b');
				} else if(condition_operator_final=='>'){
					$(condBox).select2('val', 'a');
				} else if(condition_operator_final=='>'){
					$(condBox).select2('val', 'l');
				} else if(condition_operator_final=='<='){
					$(condBox).select2('val', 'm');
				} else if(condition_operator_final=='>='){
					$(condBox).select2('val', 'h');
				} else if(condition_operator_final=='CONTAINS'){
					$(condBox).select2('val', 'c');
				}
			});
			//LOAD FIELDS DATA OF TABLES END

			//working for Auto_Complete and Select
			//////nauman code starts here//////////////////////

/*			$('#filter_1').on('change',function(){

        var cutId           = (this.id).split('_');
        var thisId          = '#' + this.id;
        var selectedValue   = $(thisId + ' option:selected').val();
        var typeArr         = selectedValue.split('|');
        var textBoxIdExHash = 'cond_val_' + cutId[1];
        var textBoxId       = '#cond_val_' + cutId[1];
        var parentControl   = '#dynamic_controll_' + cutId[1];
        var condBox         = '#cond_' + cutId[1];
 	console.log(selectedValue);return 0;
    	////faheem changes start ////
    	$(parentControl).html('<input type="text" class="simpleText form-control cond_val" name="'+textBoxIdExHash+'" id="'+textBoxIdExHash+'"><select  style="display:none;" data-placeholder="Select..." id=""></select>');
        ////faheem changes end ////

        
     
        // If field type is autocomplete or select
        if (typeArr[2] == 'autocomplete' || typeArr[2] == 'select') {
            //alert('autocomplete type');
            $(parentControl).find('select').select2().attr('style' , 'width:300px;');
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
    });*/

			//////nauman code ende here//////////////





			//Back To THE MODULE PAGE START
			function goBack(){
				var comid = $('input[name="comid"]').val();
				window.location = '<?php echo base_url(); ?>index.php/admin/scrud/browse?com_id=' + comid;
			}
			//Back To THE MODULE PAGE END
			
			function saveFilter(){
				var fname         = $('input[name="report_name"]').val();
				
				if(fname == ''){
					bootbox.alert('Please provide filter name.');
				} else if($('#filter_name').val() == '1'){
					bootbox.alert('Filter name already exists.');
				} else if($('#module_fields').val()==null){
					bootbox.alert('Please Select Module Fields');	
				} else {
					var comid               = $('#sel_module option:selected').val();
					
					var module_fields       = $('#module_fields').val();
					var filter_1            = $('#filter_1 option:selected').val();
					var cond_1              = $('#cond_1 option:selected').val();
					var elementType         = $('#cond_val_1').prop('nodeName');
					var cond_val_1          = '';
					if (elementType == 'SELECT') {
						cond_val_1          = $('#cond_val_1 option:selected').val();
					} else {
						cond_val_1          = $('#cond_val_1').val();
					}

					if(!filter_1){
						filter_1 = '|';
					}
					
					var str = module_fields.length;
					if(str < 2 || str > 8){
						bootbox.alert('Selected Columns must be Minimum 2 and Maximum 8.');
					} else {
						var select_field =  [];
						for (var i = 0; i < str && i < 7; i++) {
							field_ = module_fields[i].split("|");
							select_field[i] = field_[0];
						};

						field_f = filter_1.split("|");
						var energy = select_field.join();
						var text = '';
						//alert(comid);
						$('input[name="comid"]').val(comid);
						switch (cond_1) {
							case 'e':
								if (cond_val_1 != '' && cond_val_1 != ' ' && cond_val_1 != null && cond_val_1 != 'undefined') {
									text = field_f[0]+ ' = "'+cond_val_1+ '"';
									var cond_field = filter_1;
									var cond_operator = '=';
									var cond_value = cond_val_1;
								}
								break; 
							case 'n':
								if (cond_val_1 != '' && cond_val_1 != ' ' && cond_val_1 != null && cond_val_1 != 'undefined') {
									text = field_f[0]+' !=  "'+cond_val_1+ '"';
									var cond_field = filter_1;
									var cond_operator = '!=';
									var cond_value = cond_val_1;
								};
								break;
							case 's':
								if (cond_val_1 != '' && cond_val_1 != ' ' && cond_val_1 != null && cond_val_1 != 'undefined') {
									text = field_f[0]+' LIKE "'+cond_val_1+'%"';
									var cond_field = filter_1;
									var cond_operator = 'STARTSWITH';
									var cond_value = cond_val_1;
								};
								break; 
							case 'ew':
								if (cond_val_1 != '' && cond_val_1 != ' ' && cond_val_1 != null && cond_val_1 != 'undefined') {
									text = field_f[0]+' LIKE "%'+cond_val_1+'"';
									var cond_field = filter_1;
									var cond_operator = 'ENDSWITH';
									var cond_value = cond_val_1;
								};
								break;
							case 'k':
								if (cond_val_1 != '' && cond_val_1 != ' ' && cond_val_1 != null && cond_val_1 != 'undefined') {
								text = field_f[0]+' NOT IN ("'+cond_val_1+'")';
									var cond_field = filter_1;
									var cond_operator = 'NOTIN';
									var cond_value = cond_val_1;
								};
								break; 
							case 'y':
								text = field_f[0]+' =""';
									var cond_field = filter_1;
									var cond_operator = '=""';
									var cond_value = '';
								break;         
							case 'ny': 
								text = field_f[0]+' !=""';
									var cond_field = filter_1;
									var cond_operator = '!=""';
									var cond_value = cond_val_1;
								break;
							case 'c': 
								if (cond_val_1 != '' && cond_val_1 != ' ' && cond_val_1 != null && cond_val_1 != 'undefined') {
									text = field_f[0]+' LIKE "%'+cond_val_1+'%" '; 
									var cond_field = filter_1;
									var cond_operator = 'CONTAINS';
									var cond_value = cond_val_1;
								};
								break;
							case 'bw':
								var dfrom = '';
								var dto = '';
								var rdfrom = $('input[name="dfrom"]').val();
								var fromdate = rdfrom.split('/');
								dfrom = fromdate[2] +'-'+ fromdate[0] +'-'+ fromdate[1];

								var rdto = $('input[name="dto"]').val();
								var todate = rdto.split('/');
								dto = todate[2] +'-'+ todate[0] +'-'+ todate[1];

								if (dfrom != '' && dfrom != 'undefined--undefined' && dto != '' && dto != 'undefined--undefined') {
									text = field_f[0]+' BETWEEN ' +  dfrom + ' AND ' + dto;
								};
								break;
							case 'b':
								if (cond_val_1 != '' && cond_val_1 != ' ' && cond_val_1 != null && cond_val_1 != 'undefined') {
									var todate = cond_val_1.split('/');
									dto = todate[2] +'-'+ todate[0] +'-'+ todate[1];
									text = field_f[0]+' < "'+dto+'"';
									var cond_field = filter_1;
									var cond_operator = '<';
									var cond_value = cond_val_1;
								};
								break;
							case 'a':
								if (cond_val_1 != '' && cond_val_1 != ' ' && cond_val_1 != null && cond_val_1 != 'undefined') {
									var todate = cond_val_1.split('/');
									dto = todate[2] +'-'+ todate[0] +'-'+ todate[1];
									text = field_f[0]+' > "'+dto+'"';
									var cond_field = filter_1;
									var cond_operator = '>';
									var cond_value = cond_val_1;
								};
								break;
							case 'l':
								if (cond_val_1 != '' && cond_val_1 != ' ' && cond_val_1 != null && cond_val_1 != 'undefined') {
									text = field_f[0]+' < '+cond_val_1+'';
									var cond_field = filter_1;
									var cond_operator = '<';
									var cond_value = cond_val_1;
								};
								break;
							case 'g':
								if (cond_val_1 != '' && cond_val_1 != ' ' && cond_val_1 != null && cond_val_1 != 'undefined') {
									text = field_f[0]+' > '+cond_val_1+'';
									var cond_field = filter_1;
									var cond_operator = '>';
									var cond_value = cond_val_1;
								};
								break;
							case 'm':
								if (cond_val_1 != '' && cond_val_1 != ' ' && cond_val_1 != null && cond_val_1 != 'undefined') {
									text = field_f[0]+' <= '+cond_val_1+'';
									var cond_field = filter_1;
									var cond_operator = '<=';
									var cond_value = cond_val_1;
								};
								break;
							case 'h':
								if (cond_val_1 != '' && cond_val_1 != ' ' && cond_val_1 != null && cond_val_1 != 'undefined') {
									text = field_f[0]+' >= '+cond_val_1+'';
									var cond_field = filter_1;
									var cond_operator = '>=';
									var cond_value = cond_val_1;
								};
								break;  
						}
						var q = {};
						var query_string = 'SELECT '+energy+' FROM '+comid+' WHERE  '+text+' ';
						console.log(query_string);
						
						q['module'] = comid;
						q['fields'] = energy;
						q['cond'] = text;
						q['cond_field'] = cond_field;
						q['cond_operator'] = cond_operator;
						q['cond_value'] = cond_value;
						var defaultcheck = $('#defaultcheck').is(':checked') ? true:false;
						var filter_access = $('input[name=filter_access]:checked').val();
						//console.log($('input[name=filter_access]:checked').val());
						//console.log("the value is: " + defaultcheck); return 0;
						var query_string = JSON.stringify(q);
						console.log(query_string);
						var f_id = '<?php echo $filter_id; ?>';
						var comid = $('input[name="comid"]').val();
						if(f_id != ''){
							$.post('<?php echo base_url(); ?>index.php/admin/filters/save_filter', {fname:fname , comid:comid,details:query_string ,f_id: f_id ,f_default:defaultcheck,f_access:filter_access}, function(data){ console.log(data);
								window.location = '<?php echo base_url(); ?>index.php/admin/scrud/browse?com_id=' + comid;
							});
						} else {
							$.post('<?php echo base_url(); ?>index.php/admin/filters/save_filter', {fname:fname , comid:comid,details:query_string,f_default:defaultcheck,f_access:filter_access}, function(data){ console.log(data);
								window.location = '<?php echo base_url(); ?>index.php/admin/scrud/browse?com_id=' + comid;
							});
						}
					}
				}   
			}

			//UNKNOWN FUNCTIONS YET START
			$('#cond_1').on('change',function(){
				var varVal = $('#cond_1 option:selected').val();     
				var thisId          = '#filter_1';
				var selectedValue   = $(thisId + ' option:selected').val();
				var typeArr         = (selectedValue).split('|');
				var textBoxIdExHash = 'cond_val_1';
				
				if(varVal == 'y' || varVal == 'ny'){
					document.getElementById('dynamic_controll_1').style.display='none';
				} else {
					document.getElementById('dynamic_controll_1').style.display='block';
				}
				if (varVal == 'bw' && typeArr[2] == 'date') {
					$('#dynamic_controll_1 .simpleText').attr('id','');
					$('#dynamic_controll_1 .simpleText').hide();
					$('#dynamic_controll_1 select').attr('id','');
					$('#dynamic_controll_1 select').hide();
					$('#dynamic_controll_1 select').remove('div');
					$('#cond_drange_1').css('display','block');
					var dateRange = '<div id="cond_drange_1" class="input-group input-large date-picker input-daterange" data-date="10-11-2012" data-date-format="dd-mm-yyyy"><input type="text" class="form-control" name="dfrom"><span class="input-group-addon"> to </span><input type="text" class="form-control" name="dto"></div>';
					$('#dynamic_controll_1').html(dateRange);
					$('input[name="dfrom"]').addClass('date-picker').datepicker({ format: 'dd-mm-yyyy' } );
					$('input[name="dfrom"]').datepicker('enable');
					$('input[name="dto"]').addClass('date-picker').datepicker({ format: 'dd-mm-yyyy' } );
					$('input[name="dto"]').datepicker('enable');
				};
			});

			$('#field_val').on('change', function(){
				$('#cond_val_1').val('');
				var varVal = $('#field_val option:selected').val();
				$('#cond_val_1').val(varVal);
			});
			//UNKNOWN FUNCTIONS YET END
		</script>