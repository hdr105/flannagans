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
    ScrudCForm.wpage = '<?php echo base_url(); ?>index.php';
    ScrudCForm.urlGetOptions = '<?php echo base_url(); ?>index.php/admin/scrud/getOptions';
    ScrudCForm.urlGetFields = '<?php echo base_url(); ?>index.php/admin/scrud/getFields?table=';
    ScrudCForm.urlSaveConfig = '<?php echo base_url(); ?>index.php/admin/scrud/saveConfig';
    ScrudCForm.table = '<?php echo $_GET['table']; ?>';
    ScrudCForm.successfully_message = '<?php echo $this->lang->line('you_successfully_saved'); ?>';
<?php
if (!empty($crudConfigTable)) {
    ?>
            ScrudCForm.config = <?php echo $crudConfigTable; ?>;
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
<?php //update by kamran sb 30-3-16 ?>
<?php if (!empty($modules)) { ?>
    <?php
        foreach ($modules as $m) {
            ?>
                ScrudCForm.modules['<?php echo $m['id']; ?>'] = '<?php echo $m['component_name']; ?>';
            <?php
        }
    ?>
<?php } ?>
<?php //update by kamran sb 30-3-16 ?>
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
                                <a href="<?php echo base_url(); ?>admin/component/builder"><?php echo $this->lang->line('components');?></a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span><?php echo $this->lang->line('tool_configure'); ?> <?php echo $com['component_name']; ?></span>
                            </li>
                        </ul>
                        
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"> <?php echo $this->lang->line('tool_component_builder');?> 
                        
                    </h3>
                    <!-- END PAGE TITLE-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN TAB PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="pull-left">
                                        <a href="<?php echo base_url(); ?>admin/component/builder" class="btn btn-sm green"><?php echo $this->lang->line('components');?></a>
                                        <a href="<?php echo base_url(); ?>admin/component/groups" class="btn btn-sm green"><?php echo $this->lang->line('group_component');?></a>
                                        <a href="<?php echo base_url(); ?>admin/table/index" class="btn btn-sm green"><?php echo $this->lang->line('table_builder'); ?></a>
                                        <!--<a href="<?php echo base_url(); ?>admin/language/index" class="btn btn-sm green"> <?php echo $this->lang->line('language_manager'); ?> </a>-->
                                    </div>
                                    <div class="pull-right">
                                        <a class="btn" href="<?php echo base_url(); ?>index.php/admin/component/builder?xtype=index"> <i class="icon-arrow-left"></i> <?php echo $this->lang->line('back'); ?></a>
                                        <a class="btn btn-primary" onclick="ScrudCForm.saveElements('<?php echo $_GET['table']; ?>','<?php echo $_GET['com_id']; ?>');" > <i class="icon-ok icon-white"></i> <?php echo $this->lang->line('save'); ?> </a>
                                    </div>
                                    
                                </div>
                                <div class="portlet-body">
                                    <p><span ><?php echo $this->lang->line('tool_configure'); ?> <?php echo $com['component_name']; ?></span></p>
                                    <div class="tabbable tabbable-tabdrop">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#form" data-toggle="tab" onclick="$('#frm_preview_opt').show();"><?php echo $this->lang->line('form'); ?></a>
                                            </li>
                                            <li>
                                                <a  data-toggle="tab" href="#searchList" onclick="__clickList();$('#frm_preview_opt').hide();"><?php echo $this->lang->line('list'); ?></a>
                                            </li>
                                            <li>
                                                <a  data-toggle="tab" href="#formLayout" onclick="__clickList();$('#frm_preview_opt').hide();">Form Layout</a>
                                            </li>
                                            <!-- <li>
                                                <a  data-toggle="tab" href="#searchListFunctions" onclick="__clickList();$('#frm_preview_opt').hide();">Functions</a>
                                            </li> -->
                                            
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="form">
                                                <div style="text-align:right;width:100%;" id="form_toolbar" >
                                                    <span id="frm_preview_opt">
                                                    

                                                     <a class="btn green sbold"  data-toggle="modal" href="#basic"> Add Block </a>
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
                                                    <a class="btn" id="btn_field_to_form"><i class="icon-plus"></i></a> &nbsp;
                                                       
                                                    
                                                    

                                                    </span>
                                                </div>
                                                <?php require_once 'include/config_form.php'; ?>
                                            </div>
                                            <div class="tab-pane" id="searchList">
                                                <?php require_once 'include/config_data_list.php'; ?>
                                            </div>
                                            <div class="tab-pane" id="formLayout">
                                                <p>&nbsp;</p>
                                                <div class="form-body">
                                                   <div class="form-group">
                                                        <label class="col-md-3 control-label">Section Configuration</label>
                                                        <div class="col-md-9">
                                                            <div class="radio-list">
                                                                <label>
                                                                    <input type="radio" name="optionsRadios" id="optionsRadios22" value="1" checked> All section open </label>
                                                                <label>
                                                                    <input type="radio" name="optionsRadios" id="optionsRadios23" value="2"> First open, other tabbed </label>
                                                                <label>
                                                                    <input type="radio" name="optionsRadios" id="optionsRadios24" value="3" > First open, other accordion </label>
                                                                <label>
                                                                    <input type="radio" name="optionsRadios" id="optionsRadios24" value="4" > All accordion </label>
                                                                <label>
                                                                    <input type="radio" name="optionsRadios" id="optionsRadios24" value="5" > All tabbed </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <!--Salman Code Starts Here -->
                                            <div class="tab-pane" id="searchListFunctions">
                                                <!--Fetch data from file start-->
                                                <?php 
                                                $string = file_get_contents(base_url()."media/js/cfunctions/cfunctionslist.json");
                                                $functions = json_decode($string, true);
                                                $i= $j = $k = $l = $m = 0;
                                                //LOOP For Functions TO Exwcute Category WIse
                                                //echo "<pre>";print_r($functions);echo "</pre>";
                                                //exit;
                                                echo "List View Functions: <br />";
                                                foreach($functions as $function){
                                                    foreach($function as $list){
                                                        foreach($list as $value){
                                                            $i++;
                                                            echo "<span class=''><input type='checkbox' class='form-control' name='list-functions' id='list-functions-$i' value='".$value['value']."'></span>".$value['name'];
                                                        }
                                                    }
                                                }
                                                //LOOP For Functions TO Exwcute Category WIse
                                                echo "<br /><br /> Edit Before : <br />";
                                                foreach($functions as $function){
                                                    foreach($function as $list){
                                                        foreach($list as $value){
                                                            $i++;
                                                            echo "<span class=''><input type='checkbox' class='form-control' name='edit-pre-functions' id='edit-pre-functions-$i' value='".$value['value']."'></span>".$value['name'];
                                                        }
                                                    }
                                                }
                                                //LOOP For Functions TO Exwcute Category WIse
                                                echo "<br /><br />Edit After: <br />";
                                                foreach($functions as $function){
                                                    foreach($function as $list){
                                                        foreach($list as $value){
                                                            $i++;
                                                            echo "<span class=''><input type='checkbox' class='form-control' name='edit-post-functions' id='edit-post-functions-$i' value='".$value['value']."'></span>".$value['name'];
                                                        }
                                                    }
                                                }
                                                //LOOP For Functions TO Exwcute Category WIse
                                                echo "<br /><br />Add Before: <br />";
                                                foreach($functions as $function){
                                                    foreach($function as $list){
                                                        foreach($list as $value){
                                                            $i++;
                                                            echo "<span class=''><input type='checkbox' class='form-control' name='add-pre-functions' id='add-pre-functions-$i' value='".$value['value']."'></span>".$value['name'];
                                                        }
                                                    }
                                                }
                                                //LOOP For Functions TO Exwcute Category WIse
                                                echo "<br /><br />Add After: <br />";
                                                foreach($functions as $function){
                                                    foreach($function as $list){
                                                        foreach($list as $value){
                                                            $i++;
                                                            echo "<span class=''><input type='checkbox' class='form-control' name='add-post-functions' id='add-post-functions-$i' value='".$value['value']."'></span>".$value['name'];
                                                        }
                                                    }
                                                }
                                                ?>
                                                <!--Fetch data from file END-->
                                            </div>
                                            <!--Salman Code Ends Here -->
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
                function __clickList(){
                    $('#filter_elements > li:first > a > a').trigger('click');
                    $('#column_elements > li:first > a > a').trigger('click');
                    //Updated By KAMRAN SB START
                    $( "#quickcreate_elements" ).sortable({forcePlaceholderSize: true,placeholder: "ui-state-highlight"});
                    $( "#massedit_elements" ).sortable({forcePlaceholderSize: true,placeholder: "ui-state-highlight"});
                    $( "#summary_elements" ).sortable({forcePlaceholderSize: true,placeholder: "ui-state-highlight"});
                    //Updated By KAMRAN SB END
                };
            </script>