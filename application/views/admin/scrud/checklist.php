<style>
.affix .clickover{
    top: 38px !important;
}
.affix-top .clickover{
    top: 152px !important;
}

#form_toolbar .popover-content{
    max-height: 500px !important;
    overflow: auto;
    background-color: #F1F4F7;
}
.popover-title{
    font-size: 16px;
}
</style>
<script type="text/javascript">
    ScrudCForm.wpage = '<?php echo base_url(); ?>';
    ScrudCForm.urlGetOptions = '<?php echo base_url(); ?>admin/scrud/getOptions';
    ScrudCForm.urlGetFields = '<?php echo base_url(); ?>admin/scrud/getFields?table=';
    ScrudCForm.urlSaveConfig = '<?php echo base_url(); ?>admin/scrud/saveChecklist';
    ScrudCForm.table = '<?php echo $_GET['table']; ?>';
    ScrudCForm.successfully_message = '<?php echo $this->lang->line('you_successfully_saved'); ?>';
<?php
if (!empty($crudConfigTable)) {
    ?>
            ScrudCForm.config = '<?php echo $crudConfigTable; ?>';
            ScrudCForm.config = JSON.parse(ScrudCForm.config);
    <?php
}
?>
<?php if (!empty($tables)) { ?>
    <?php
    foreach ($tables as $t) {
        /*if (strpos($t, 'crud_') !== false)
            continue;*/
        ?>
                    ScrudCForm.tables[ScrudCForm.tables.length] = '<?php echo $t; ?>';
    <?php } ?>
<?php } ?>
<?php foreach ($fields as $f) { 
        if (in_array($f['Field'], array('created','created_by','modified','modified_by'))) continue;
    ?>
        ScrudCForm.fields[ScrudCForm.fields.length] = '<?php echo $f['Field']; ?>'
<?php } ?>

<?php foreach ($fieldConfig as $f => $c) { ?>
        ScrudCForm.elements['<?php echo $f; ?>'] = <?php echo $c; ?>;
<?php } ?>
</script>
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="index.html">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>admin/checklist/builder">Checklists Manager</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span><?php echo $com['component_name']; ?></span>
                            </li>
                        </ul>
                        
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"> Checklist Builder 
                        
                    </h3>
                    <!-- END PAGE TITLE-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN TAB PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="pull-left">
                                                    <a class="btn btn-primary" id="btn_field_to_form"><i class="icon-plus"></i></a> &nbsp;
                                    </div>
                                    <div class="pull-right">
                                        <a class="btn" href="<?php echo base_url(); ?>index.php/admin/checklist/builder?com_id=87"> <i class="icon-arrow-left"></i> <?php echo $this->lang->line('back'); ?></a>
                                        <a class="btn btn-primary" onclick="ScrudCForm.saveElements('<?php echo $_GET['chklst_id']; ?>');" > <i class="icon-ok icon-white"></i> <?php echo $this->lang->line('save'); ?> </a>
                                    </div>
                                    
                                </div>
                                <div class="portlet-body">
                                    
                                    <div class="tabbable tabbable-tabdrop">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="form">
                                                <div style="text-align:right;width:100%;" id="form_toolbar" >
                                                    <span id="frm_preview_opt">
                                                    

                                                     <!-- <a class="btn green sbold"  data-toggle="modal" href="#basic"> Add Block </a> -->
                                <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
                                    <div class="modal-dialog" style="text-align:left;" >
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Section Title</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control" name="setSectionTitle" placeholder="Section title" />
                                                            <input type="hidden" name="toChangeId" value="">
                                                            <span class="help-block">Only unique section title.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="closeSectionNameModal" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <button type="button" id="updateBlockBtn" class="btn green" onclick="ScrudCForm.changeBlcokTitle();" style="display: none;">Save</button>
                                                    <button type="button" id="saveBlockBtn" class="btn green" onclick="ScrudCForm.addBlockToForm();">Save</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                                       
                                                    
                                                    

                                                    </span>
                                                </div>
                                                <?php require_once 'include/checklist_form.php'; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <!-- END TAB PORTLET-->
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <script>
            $('input:radio[name="optionsRadios"]').change(function(){
                if ($(this).is(':checked')) {
                    ScrudCForm.updateFormLayout($(this).val());
                }
            });
            </script>