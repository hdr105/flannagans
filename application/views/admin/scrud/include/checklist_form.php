<div class="row">
    <div class="col-md-12">
        <div id="form-preview">
            <div id="sortable_portlets" class="portlet-body">
                <form id="frm_preview">
                    
                        <div id="dragable" class="section-body form-body sortable_portlets" >
                            <div class="portlet green-sharp box portlet-sortable" id="check_list">
                                <div class="portlet-title">
                                    <div class="caption section_head">
                                        <span>Check List</span>
                                        <input type="hidden" name="sectionTitle" value="Check List">
                                        <input type="hidden" name="viewType" value="accordion">
                                        <input type="hidden" name="sizeType" value="full">
                                        <input type="hidden" name="count" id="count" value="0">
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" onclick="ScrudCForm.updateSectionTitle('check_list');" class="config" data-original-title="" title=""></a>
                                        <!-- <a href="javascript:;" class="remove" onclick="ScrudCForm.removeSection('check_list');" title=""></a> -->
                                    </div>
                                </div>
                                <div class="portlet-body elements_preview dragableArea sortable section_body">
                                    

                                </div>
                            </div>
                        </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
<script>

    $('.section_head input[name="sectionTitle"]').on('keyup',function(){
        ScrudCForm.updateSectionTitle();
    });

    $(document).ready(function(){
        $('input[name="preview_type_form"]').click(function(){
            switch ($(this).val()){
                case '1':
                    $('#frm_preview').removeClass('form-horizontal');
                    break;
                case '2':
                    $('#frm_preview').addClass('form-horizontal');
                    break;
            }
            ScrudCForm.config.frm_type=$(this).val();
            //$('#form-preview').css({height:'auto'});
            //$('#form-preview').height(900);
        });
        
        if (ScrudCForm.config.frm_type == undefined){
            ScrudCForm.config.frm_type = '2';
        }
        

        $('input[name="preview_type_form"]').each(function(){
            if ($(this).val() == ScrudCForm.config.frm_type){
                $(this).attr({checked:"checked"});
            }
        });
        
        
        var preview_type_form = $('input[name="preview_type_form"]:checked').val();
        switch(preview_type_form){
            case '1':
                $('#frm_preview').removeClass('form-horizontal');
                break;
            case '2':
                $('#frm_preview').addClass('form-horizontal');
                break;
        }
    });
</script>
