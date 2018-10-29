<?php 
$elements = $this->elements; 
$CI = & get_instance();
$formFields = array();
foreach ($this->form as $key => $value) {
	foreach ($value['section_fields'] as $key => $value) {
		$formFields[$key] = $value;
	}
}

$quickCreateFields = array();
foreach ($this->quickcreate as $fk => $fv) {
    if (isset($formFields[$fv['field']])) {
        $quickCreateFields[$fv['field']] = $formFields[$fv['field']];
    }
}

//Validation START
/* echo "<script> function validateform(){ 
	$('#errors').empty();
	$('#errors').append('Please Enter Value For ');
	var foreignkey='1';
	";
foreach ($this->quickcreate as $fk => $fv) {
    if (isset($formFields[$fv['field']])) {
        $quickCreateFields[$fv['field']] = $formFields[$fv['field']];
		if(!empty($this->validate[$fv['field']])){
			$data = explode('.',$fv['field']);
			$final = ucwords($data[0]).ucwords($data[1]);
			echo "if($('#data".$final."').val()==''){";
				echo "$('#errors').append('".$this->quickcreate[$fk]['alias'].", ');";
				echo "foreignkey = 0";
			echo "}";
		}
    }
}
echo "var data = $('#errors').text().slice(0,-2);";
echo "$('#errors').addClass('alert alert-error'); $('#errors').empty(); $('#errors').append('<strong>Error!</strong> '); $('#errors').append(data);";

echo "if(foreignkey != 0) { return 1; } else { return 0; }";
echo "}; </script>"; */
//Validation END
?>
	<div id="quickcreate_form_container">
	<div class="" id="errors" style="margin:0 20px;"></div>
		<?php 


		foreach ($this->primaryKey as $f) {
                  $ary = explode('.', $f);
                  if (isset($this->summaryData['key'][$f]) || isset($key[$ary[0]][$ary[1]])) {
                      if (isset($this->summaryData['key'][$f])) {
                          $_POST['key'][$ary[0]][$ary[1]] = $this->summaryData['key'][$f];
                          $rid = $_GET['key'][$f];
                      }
                      echo __hidden('key.' . $f);
                  }
              }
              
		if (is_array($quickCreateFields)) {
				foreach ($quickCreateFields  as $fk => $fv) { ?>
					<div class="form-group " style="margin: 20px;">
						<label for="crudTitle" class="col-md-12">
							<?php echo $fv['alias'];// echo (!empty($v['alias'])) ? $v['alias'] : $field; ?>
							 </label>
						<div class="col-md-12">
							<?php
								$e = $fv['element'];
                                
								echo generateFormElementView($e,$this->da,$fk);
							?>
						</div>
					</div>
			<?php
				}
			} else if ($this->search == 'one_field') {
				$attributes = array();
				echo __text('data.one_field', $attributes);
			} ?>
	</div>
<style>
 input[type="text"] { width: 100%;}
</style>
<script type="text/javascript">
    jQuery(document).ready(function() {   
 App.init(); // init metronic core componets
   $(".select2, .select2-multiple").select2({
                        placeholder: "Select...",
                        width: null
                    });

                    $(".select2-allow-clear").select2({
                        allowClear: true,
                        placeholder: "Select...",
                        width: null
                    });


$('.date-picker').datepicker({
                rtl: App.isRTL(),
                orientation: "right",
                autoclose: true
            });



                    
});
$('.timepicker').timepicker({
                autoclose: true,
                
                minuteStep: 1
            });
$(".form_datetime").datetimepicker({
    autoclose:!0,
    orientation: "right",
    isRTL:App.isRTL(),
    format:"dd-mm-yyyy hh:ii:ss",
    pickerPosition:App.isRTL()?"bottom-right":"bottom-left"
});

//dataCalendarTime_end 

//code added by Nauman for 1 hour difference in 2 dates of calendar
                //time
                var strt = $("#dataCalendarTime_start").val();
                var data = strt.split(':');
                var hr = parseInt(data[0]) + 1;
                var str = hr + ':' +  data[1];
                $("#dataCalendarTime_end").val(str)
//Nouman Code end

	    //Toggle Password

    (function ($) {
        $.toggleShowPassword = function (options) {
            var settings = $.extend({
                field: "#password",
                control: "#toggle_show_password",
            }, options);

            var control = $(settings.control);
            var field = $(settings.field)

            control.bind('click', function () {
                if (control.is(':checked')) {
                    field.attr('type', 'text');
                } else {
                    field.attr('type', 'password');
                }
            })
        };
    }(jQuery));

    ///////////////
<?php
if(isset($_GET['$c_id'])){
    $table = explode(".",key($_GET['key']));
}else{
    $CI->db->select('component_table');
    $CI->db->from('crud_components');
    $CI->db->where('id',$_GET['com_id']);
    $query = $CI->db->get();
    $table = $query->row_array();
    $table[0] = $table['component_table'];
}
?>
    $.toggleShowPassword({
        field: '#data<?=ucwords($table[0])?>User_password',
        control: '#toggle_data<?=ucwords($table[0])?>User_password'
    }); 

</script>

<style type="text/css">
    .select2-dropdown, .select2-search__field {  z-index: 10052; }

</style>
