<?php 
$elements = $this->elements; 
$CI = & get_instance();
$formFields = array();
foreach ($this->form as $key => $value) {
    foreach ($value['section_fields'] as $key => $value) {
        $formFields[$key] = $value;
    }
}

//print_r($formFields);
$avaFields = array(
        array('alias'=>'Calendars', 'field'=>'calendar.eventstatus'),
        array('alias'=>'From', 'field'=>'calendar.date_start'),
        array('alias'=>'To', 'field'=>'calendar.due_date'),
    );
$searchFields = array();
foreach ($avaFields as $fk => $fv) {

    if (isset($formFields[$fv['field']])) {
        $searchFields[$fv['field']] = $formFields[$fv['field']];
        $searchFields[$fv['field']]['alias'] = $fv['alias'];
        
        
        
        
    }
}
$searchFields['calendar.eventstatus']['alias'] = 'Calendars';
            $searchFields['calendar.eventstatus']['element'][0] = 'select';
            $searchFields['calendar.eventstatus']['element'][1] = array(
                    'option_table'=>'calendar_types',
                    'option_key'=>'id',
                    'option_value'=>'name'
                );
             $searchFields['calendar.eventstatus']['element'][2] = array('multiple'=>'multiple');

?>
<style type="text/css">
    .select2-dropdown {  z-index: 10052; }
</style>
<div id="search_form_container">
                    <?php if (is_array($searchFields)) { ?>
                        <?php
                        foreach ($searchFields   as $fk => $fv) {
                            
                            ?>
                         <div class="form-group " style="margin: 20px;">
                        <label for="crudTitle" class="col-md-12">
                            <?php echo $fv['alias'];// echo (!empty($v['alias'])) ? $v['alias'] : $field; ?>
                             </label>
                        <div class="col-md-12">
                            <?php
                                $e = $fv['element'];

                                $field =  generateFormElementView($e,$this->da,$fk);
                                $field = str_replace("data", "src", $field);
                                echo $field;
                            ?>
                        </div>
                     </div>
                <?php
                        }
                        ?>
                            <input type="hidden" name="src[availability_search]">
                        <?php
        } else if ($this->search == 'one_field') {
            ?>
                    <?php
                    $attributes = array();
                    echo __text('src.one_field', $attributes);
                    ?>
        <?php } ?>
</div>
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



                    
});
</script>