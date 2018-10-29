<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered" style="position: relative; margin-bottom:20px;margin-top:20px; height: auto !important;" id="form-preview">
            <div id="sortable_portlets" class="portlet-body">
                <form id="frm_preview">
                    
                        <div id="dragable" class="section-body form-body sortable_portlets" >
                            
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
