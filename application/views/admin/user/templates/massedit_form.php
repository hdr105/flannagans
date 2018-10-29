<?php 
$CI = & get_instance();
?>
<div id="massedit_form_container">
<div class="form-body">
                    <?php 
                $elements = $this->form;
                $sections = array();
                if (!empty($elements)) {
                    foreach ($elements as $field => $v) {
                        $inner_section = array();

                        $inner_section['section_name'] = $v['section_name'];
                        $inner_section['section_title'] = $v['section_title'];
                        $inner_section['section_view'] = $v['section_view'];
                       
                        $inner_section['section_html'] = '';
                       
                        $fields = $v['section_fields'];
                        // Start a row
                        $inner_section['section_html'] .= '<div class="row">';
                        foreach ($fields  as $fk => $fv) {
                            if ($fv['alias']=='Role Name')
                                continue;

                          $e = $fv['element'];
                            if (!empty($e) && isset($e[0])) {
                                $inner_section['section_html'] .= '<div class="col-md-12">';
                                $inner_section['section_html'] .= '<div class="form-group">';
                                $inner_section['section_html'] .=    '<label class="control-label col-md-12">'. $fv['alias'].'</label>';
                                $inner_section['section_html'] .=     '<div class="col-md-12">';
                                $inner_section['section_html'] .=   generateFormElementView($e,$this->da,$fk);
                                $inner_section['section_html'] .=     '</div>';
                                $inner_section['section_html'] .= '</div>';
                                $inner_section['section_html'] .= '</div>';
                            }
                        }
                        $inner_section['section_html'] .=  '</div>';
                        echo $inner_section['section_html'];
                        unset($inner_section);

                    }
                } 
                ?>
                </div>
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

    });
</script>

<style type="text/css">
    .select2-dropdown {  z-index: 10052; }
</style>
