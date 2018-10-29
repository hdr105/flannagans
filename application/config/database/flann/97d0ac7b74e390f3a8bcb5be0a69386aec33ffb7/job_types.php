<?php exit; ?>
a:14:{s:5:"title";s:9:"Job Types";s:5:"limit";s:2:"50";s:8:"frm_type";s:1:"2";s:4:"join";a:0:{}s:11:"order_field";s:15:"job_types.title";s:10:"order_type";s:3:"asc";s:11:"search_form";a:5:{i:0;a:2:{s:5:"alias";s:4:"Name";s:5:"field";s:15:"job_types.title";}i:1;a:2:{s:5:"alias";s:11:"Fee Package";s:5:"field";s:16:"job_types.fee_id";}i:2;a:2:{s:5:"alias";s:9:"Recurring";s:5:"field";s:19:"job_types.recurring";}i:3;a:2:{s:5:"alias";s:9:"Frequency";s:5:"field";s:19:"job_types.frequency";}i:4;a:2:{s:5:"alias";s:7:"Repeats";s:5:"field";s:23:"job_types.repeats_value";}}s:13:"masseidt_form";a:4:{i:0;a:2:{s:5:"alias";s:4:"Name";s:5:"field";s:15:"job_types.title";}i:1;a:2:{s:5:"alias";s:8:"Document";s:5:"field";s:14:"job_types.file";}i:2;a:2:{s:5:"alias";s:11:"Fee Package";s:5:"field";s:16:"job_types.fee_id";}i:3;a:2:{s:5:"alias";s:9:"Recurring";s:5:"field";s:19:"job_types.recurring";}}s:12:"summary_form";a:4:{i:0;a:2:{s:5:"alias";s:4:"Name";s:5:"field";s:15:"job_types.title";}i:1;a:2:{s:5:"alias";s:11:"Fee Package";s:5:"field";s:16:"job_types.fee_id";}i:2;a:2:{s:5:"alias";s:9:"Recurring";s:5:"field";s:19:"job_types.recurring";}i:3;a:2:{s:5:"alias";s:2:"No";s:5:"field";s:21:"job_types.job_typesno";}}s:16:"quickcreate_form";a:4:{i:0;a:2:{s:5:"alias";s:4:"Name";s:5:"field";s:15:"job_types.title";}i:1;a:2:{s:5:"alias";s:8:"Document";s:5:"field";s:14:"job_types.file";}i:2;a:2:{s:5:"alias";s:11:"Fee Package";s:5:"field";s:16:"job_types.fee_id";}i:3;a:2:{s:5:"alias";s:9:"Recurring";s:5:"field";s:19:"job_types.recurring";}}s:8:"validate";a:1:{s:15:"job_types.title";a:2:{s:4:"rule";s:8:"notEmpty";s:7:"message";s:44:"Please enter the value for Name in Job Type.";}}s:9:"data_list";a:6:{s:15:"job_types.title";a:1:{s:5:"alias";s:4:"Name";}s:16:"job_types.fee_id";a:1:{s:5:"alias";s:11:"Fee Package";}s:19:"job_types.recurring";a:1:{s:5:"alias";s:9:"Recurring";}s:19:"job_types.frequency";a:1:{s:5:"alias";s:9:"Frequency";}s:23:"job_types.repeats_value";a:1:{s:5:"alias";s:7:"Repeats";}s:6:"action";a:4:{s:5:"alias";s:7:"Actions";s:6:"format";s:328:"<a href="javascript:;" onclick="__view('{ppri}');" class="btn btn-icon-only blue fa fa-search"></a> <a  href="javascript:;" onclick="__edit('{ppri}'); return false;" class="btn btn-icon-only green fa fa-edit"></a> <a  href="javascript:;" onclick="__delete('{ppri}'); return false;" class="btn btn-icon-only red fa fa-trash"></a>";s:5:"width";i:85;s:5:"align";s:6:"center";}}s:13:"form_elements";a:1:{i:0;a:5:{s:12:"section_name";s:8:"job_type";s:13:"section_title";s:8:"Job Type";s:12:"section_view";s:9:"accordion";s:12:"section_size";s:7:"default";s:14:"section_fields";a:4:{s:15:"job_types.title";a:2:{s:5:"alias";s:4:"Name";s:7:"element";a:3:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:11:"width:100%;";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:14:"job_types.file";a:2:{s:5:"alias";s:8:"Document";s:7:"element";a:3:{i:0;s:4:"file";i:1;a:1:{s:5:"style";s:13:"display:none;";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:16:"job_types.fee_id";a:2:{s:5:"alias";s:11:"Fee Package";s:7:"element";a:4:{i:0;s:6:"select";i:1;a:7:{s:12:"option_table";s:11:"fee_package";s:10:"option_key";s:2:"id";s:12:"option_value";s:12:"package_name";s:16:"option_condition";s:7:"site_id";s:13:"option_column";s:5:"sites";s:13:"option_action";s:1:"=";s:17:"option_customtext";N;}i:2;a:1:{s:5:"style";s:10:"width:100%";}i:3;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:19:"job_types.recurring";a:2:{s:5:"alias";s:9:"Recurring";s:7:"element";a:3:{i:0;s:6:"custom";i:1;a:1:{s:4:"json";s:2186:"<div class="radio-list">
			<label class="radio-inline"><span><input type="radio" name="data[job_types][recurring]" id="optionsRadios1" value="Yes"></span> Yes </label>
			<label class="radio-inline"><span><input type="radio" name="data[job_types][recurring]" id="optionsRadios2" value="No" checked=""></span> No </label>
			
		</div>
<div class="clearfix"></div>
	 <div id="repeaters" style="display:none;">
		<label>Repeats</label>
		<select class="form-control input-sm" name="data[job_types][frequency]" id="frequency" disabled>
			<option value="Weekly">Weekly</option>
			<option value="Monthly">Monthly</option>
			<option value="Yearly">Yearly</option>
		</select>
	</div>
	<div id="repeating" style="display:none;">
		<label>Repeats Every</label>
		<select class="form-control input-sm" name="data[job_types][repeats_value]" id="repeats_value" disabled>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
		</select>
		<label id="typeofrepeats"></label>
	</div>
			  
<script>
	$("#optionsRadios1").click(function() {
		$("#repeaters").show();
		$("#frequency").prop('disabled', false);
		$("#repeating").show();
		$("#repeats_value").prop('disabled', false);
		$("#typeofrepeats").empty();
		$("#typeofrepeats").append('Week(s)');
	});
	
	$("#optionsRadios2").click(function() {
		$("#repeaters").hide();
		$("#frequency").prop('disabled', true);
		$("#repeating").hide();
		$("#repeating").prop('disabled', false);
	});
	
	$("#frequency").change(function() {
		$("#repeating").show();
		if($("#frequency").val()==1){
			$("#typeofrepeats").empty();
			$("#typeofrepeats").append('Week(s)');
		} else if($("#frequency").val()==2){
			$("#typeofrepeats").empty();
			$("#typeofrepeats").append('Month(s)');
		} else if($("#frequency").val()==3){
			$("#typeofrepeats").empty();
			$("#typeofrepeats").append('Year(s)');
		}
	});
</script>";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}}}}s:8:"elements";a:1:{i:0;a:5:{s:12:"section_name";s:8:"job_type";s:13:"section_title";s:8:"Job Type";s:12:"section_view";s:9:"accordion";s:12:"section_size";s:7:"default";s:14:"section_fields";a:4:{s:15:"job_types.title";a:2:{s:5:"alias";s:4:"Name";s:7:"element";a:3:{i:0;s:4:"text";i:1;a:1:{s:5:"style";s:11:"width:100%;";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:14:"job_types.file";a:2:{s:5:"alias";s:8:"Document";s:7:"element";a:3:{i:0;s:4:"file";i:1;a:1:{s:5:"style";s:13:"display:none;";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:16:"job_types.fee_id";a:2:{s:5:"alias";s:11:"Fee Package";s:7:"element";a:4:{i:0;s:6:"select";i:1;a:7:{s:12:"option_table";s:11:"fee_package";s:10:"option_key";s:2:"id";s:12:"option_value";s:12:"package_name";s:16:"option_condition";s:7:"site_id";s:13:"option_column";s:5:"sites";s:13:"option_action";s:1:"=";s:17:"option_customtext";N;}i:2;a:1:{s:5:"style";s:10:"width:100%";}i:3;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}s:19:"job_types.recurring";a:2:{s:5:"alias";s:9:"Recurring";s:7:"element";a:3:{i:0;s:6:"custom";i:1;a:1:{s:4:"json";s:2186:"<div class="radio-list">
			<label class="radio-inline"><span><input type="radio" name="data[job_types][recurring]" id="optionsRadios1" value="Yes"></span> Yes </label>
			<label class="radio-inline"><span><input type="radio" name="data[job_types][recurring]" id="optionsRadios2" value="No" checked=""></span> No </label>
			
		</div>
<div class="clearfix"></div>
	 <div id="repeaters" style="display:none;">
		<label>Repeats</label>
		<select class="form-control input-sm" name="data[job_types][frequency]" id="frequency" disabled>
			<option value="Weekly">Weekly</option>
			<option value="Monthly">Monthly</option>
			<option value="Yearly">Yearly</option>
		</select>
	</div>
	<div id="repeating" style="display:none;">
		<label>Repeats Every</label>
		<select class="form-control input-sm" name="data[job_types][repeats_value]" id="repeats_value" disabled>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
		</select>
		<label id="typeofrepeats"></label>
	</div>
			  
<script>
	$("#optionsRadios1").click(function() {
		$("#repeaters").show();
		$("#frequency").prop('disabled', false);
		$("#repeating").show();
		$("#repeats_value").prop('disabled', false);
		$("#typeofrepeats").empty();
		$("#typeofrepeats").append('Week(s)');
	});
	
	$("#optionsRadios2").click(function() {
		$("#repeaters").hide();
		$("#frequency").prop('disabled', true);
		$("#repeating").hide();
		$("#repeating").prop('disabled', false);
	});
	
	$("#frequency").change(function() {
		$("#repeating").show();
		if($("#frequency").val()==1){
			$("#typeofrepeats").empty();
			$("#typeofrepeats").append('Week(s)');
		} else if($("#frequency").val()==2){
			$("#typeofrepeats").empty();
			$("#typeofrepeats").append('Month(s)');
		} else if($("#frequency").val()==3){
			$("#typeofrepeats").empty();
			$("#typeofrepeats").append('Year(s)');
		}
	});
</script>";}i:2;a:2:{s:6:"attach";s:0:"";s:9:"fieldname";s:0:"";}}}}}}}