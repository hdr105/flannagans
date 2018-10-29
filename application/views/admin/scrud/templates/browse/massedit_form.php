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
foreach ($this->massedit as $fk => $fv) {
    if (isset($formFields[$fv['field']])) {
        $quickCreateFields[$fv['field']] = $formFields[$fv['field']];
    }
}
?>
<div id="massedit_form_container">
                    <?php if (is_array($this->massedit)) { ?>
                        <?php
                        foreach ($quickCreateFields  as $fk => $fv) {
                            ?>
                    <div class="form-group " style="margin: 20px;">
                        <label for="crudTitle" class="col-md-12">
                            <?php echo $fv['alias'];// echo (!empty($v['alias'])) ? $v['alias'] : $field; ?>
                             </label>
                        <div class="col-md-12">
                        <?php
                        if($fk=='business.legal_entity'){
                        ?>
                            <select class="form-control select2" style="min-width: 230px; max-width:250px;" name="data[business][legal_entity]" id="dataBusinessLegal_entity" tabindex="-1" aria-hidden="true"><option value=""></option><option value="1">Sole Trader</option><option value="2">Partnership</option><option value="3">Limited Company</option><option value="4">Limited Liabilities</option><option value="5">Charities</option></select>
                        <?php
                        }else{
                            $e = $fv['element'];
                            echo generateFormElementView($e,$this->da,$fk);
                        }
                        ?>

                        </div>
                    </div>
                <?php
            }
        } else if ($this->search == 'one_field') {
            ?>
                    <?php
                    $attributes = array();
                    echo __text('data.one_field', $attributes);
                    ?>
        <?php } ?>
</div>
<script type="text/javascript">
    jQuery(document).ready(function() {   
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
            orientation: "left",
            autoclose: true
        });
    });
</script>

<style type="text/css">
    .select2-dropdown {  z-index: 10052; }
</style>
