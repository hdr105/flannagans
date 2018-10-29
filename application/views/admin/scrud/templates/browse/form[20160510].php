<?php $CI = & get_instance();

///////////Condition in Field types////////////
$CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
foreach($CRUD_AUTH as $key => $value){
 if(is_array($value)){
  foreach($value as $inkey => $invalue){
   $$inkey = $invalue;
  }
 } else {
  $$key = $value;
 }
}
///////////////////////////////////////////////////

$key = $CI->input->post('key');
$lang = $CI->lang; 
$c_id = $_GET['com_id'];
$sess_cid = $CI->session->userdata('comid');
$keyval0 = '';
$keyval1 = '';
$keyval2 = '';
$keyval3 = '';
$keyval4 = '';
$keyval5 = '';
$keyval6 = '';
if((isset($_GET['key']['business.id']) && $keyid = $_GET['key']['business.id']) or (isset($_GET['key']['forms.id']) && $keyid = $_GET['key']['forms.id']) or (isset($_GET['key']['codes.id']) && $keyid = $_GET['key']['codes.id']) or (isset($_GET['key']['compliance.id']) && $keyid = $_GET['key']['compliance.id']) or (isset($_GET['key']['services.id']) && $keyid = $_GET['key']['services.id']) or (isset($_GET['key']['business_fee.id']) && $keyid = $_GET['key']['business_fee.id']) or (isset($_GET['key']['legal_letters_business.id']) && $keyid = $_GET['key']['legal_letters_business.id'])){
    $keyval0 = "&key[business.id]=".$keyid;
    $keyval1 = "&key[forms.id]=".$keyid;
    $keyval2 = "&key[codes.id]=".$keyid;
    $keyval3 = "&key[compliance.id]=".$keyid;
    $keyval4 = "&key[services.id]=".$keyid;
    $keyval5 = "&key[business_fee.id]=".$keyid;
    $keyval6 = "&key[legal_letters_business.id]=".$keyid;
}
?>
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                            <?php
                                            if($c_id==41 or $c_id==42 or $c_id==43 or $c_id==44 or $c_id==45 or $c_id==58 or $c_id==62 or $c_id==63 or $c_id==64 or $c_id==70 or $c_id==74){
                                            ?>
                                                <div class="pull-left">
                                                    <a href="<?=base_url(); ?>admin/scrud/browse?com_id=<?=$sess_cid?>&xtype=form<?=$keyval0?>" class="btn btn-sm <?php if($c_id==41 or $c_id==42 or $c_id==43 or $c_id==44 or $c_id==45){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?>">Business Setup
                                                    </a>
                                                     <a href="<?=base_url(); ?>admin/scrud/browse?com_id=58&xtype=form<?=$keyval1?>" class="btn btn-sm <?php if($c_id=='58'){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval1==''){ ?> disabled<?php } ?>">Forms
                                                    </a>
                                                     <a href="<?=base_url(); ?>admin/scrud/browse?com_id=63&xtype=form<?=$keyval2?>" class="btn btn-sm <?php if($c_id=='63'){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval2==''){ ?> disabled<?php } ?>">Codes
                                                    </a>
                                                     <a href="<?=base_url(); ?>admin/scrud/browse?com_id=62&xtype=form<?=$keyval3?>" class="btn btn-sm <?php if($c_id=='62' or $c_id=='74'){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval3==''){ ?> disabled<?php } ?>">Compliance Section
                                                    </a>
                                                     <a href="<?=base_url(); ?>admin/scrud/browse?com_id=70&xtype=form<?=$keyval4?>" class="btn btn-sm <?php if($c_id=='70'){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval4==''){ ?> disabled<?php } ?>">Services
                                                    </a>
                                                     <a href="<?=base_url(); ?>admin/scrud/browse?com_id=64&xtype=form<?=$keyval5?>" class="btn btn-sm <?php if($c_id=='64'){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval5==''){ ?> disabled<?php } ?>">Fee Setup
                                                    </a>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                                <div class="pull-right">
                                                    <a href="javascript:;" onclick="crudConfirm();" class="btn btn-sm blue "><?php echo $CI->lang->line('save');?> <i class="fa fa-save"></i>
                                                    </a>
                                                <?php
                                                if($c_id==41 or $c_id==42 or $c_id==43 or $c_id==44 or $c_id==45 or $c_id==58 or $c_id==62 or $c_id==63 or $c_id==64 or $c_id==70 or $c_id==74){
                                                ?>
                                                    <a href="javascript:;" onclick="crudDraft();" class="btn btn-sm green ">Save as Draft <i class="fa fa-edit"></i></a>
                                                <?php
                                                }
                                                ?>
                                                    <a href="javascript:;" onclick="crudCancel();" class="btn btn-sm default "><?php echo $CI->lang->line('cancel');?>
                                                    </a>
                                                </div> 
                                            </div>
                                            <div class="portlet-body form">

                                            <?php
                                            if($c_id==62 or $c_id==74){
                                            ?>
                                            <ul class="nav nav-tabs">
                                                <li <?php if($c_id=='62'){ ?>class="active"<?php } ?>>
                                                    <a href="<?=base_url(); ?>admin/scrud/browse?com_id=62&xtype=form<?=$keyval3?>"> Money Laundering Check </a>
                                                </li>
                                                <li <?php if($c_id=='74'){ ?>class="active"<?php } ?>>
                                                    <a href="<?=base_url(); ?>admin/scrud/browse?com_id=74&xtype=form<?=$keyval6?>"> Legal Letters </a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"> </div>
                                            <?php 
                                            } 

                                            if($c_id==41 or $c_id==42 or $c_id==43 or $c_id==44 or $c_id==45){
                                            ?>
                                            <!-- <ul class="nav nav-tabs">
                                                <li <?php if($c_id=='41'){ ?>class="active"<?php } ?>>
                                                    <a href="<?=base_url(); ?>admin/scrud/browse?com_id=41&xtype=form<?=$keyval0?>"> Sole Trader </a>
                                                </li>
                                                <li <?php if($c_id=='42'){ ?>class="active"<?php } ?>>
                                                    <a href="<?=base_url(); ?>admin/scrud/browse?com_id=42&xtype=form<?=$keyval0?>"> Partnership </a>
                                                </li>
                                                <li <?php if($c_id=='43'){ ?>class="active"<?php } ?>>
                                                    <a href="<?=base_url(); ?>admin/scrud/browse?com_id=43&xtype=form<?=$keyval0?>"> Limited Company </a>
                                                </li>
                                                <li <?php if($c_id=='44'){ ?>class="active"<?php } ?>>
                                                    <a href="<?=base_url(); ?>admin/scrud/browse?com_id=44&xtype=form<?=$keyval0?>"> Limited Liabilities Company </a>
                                                </li>
                                                <li <?php if($c_id=='45'){ ?>class="active"<?php } ?>>
                                                    <a href="<?=base_url(); ?>admin/scrud/browse?com_id=45&xtype=form<?=$keyval0?>"> Charities </a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"> </div> -->
                                            <?php } ?>
<?php
    $q = $this->queryString;
    $q['xtype'] = 'confirm';
    if (isset($q['key']))
        unset($q['key']);

?>
                                                <!-- BEGIN FORM-->
                                                <form method="post" action="?<?php echo http_build_query($q, '', '&'); ?>"  enctype="multipart/form-data"
          id="crudForm" style="padding: 0; margin: 0;" <?php if ($this->frmType == '2') { ?>class="form-horizontal"<?php } ?> >
          <input type="hidden" name="auth_token" id="auth_token" value="<?php echo $this->getToken(); ?>"/>
          <?php
              $elements = $this->form;
              foreach ($this->primaryKey as $f) {
                  $ary = explode('.', $f);
                  if (isset($_GET['key'][$f]) || isset($key[$ary[0]][$ary[1]])) {
                      if (isset($_GET['key'][$f])) {
                          $_POST['key'][$ary[0]][$ary[1]] = $_GET['key'][$f];
                      }
                      echo __hidden('key.' . $f);
                  }
              }
              ?>
              <?php if (!empty($this->errors)) { ?>
            <div class="alert alert-error">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <?php foreach ($this->errors as $error) { ?>
                    <?php if (count($error) > 0) { ?>
                        <strong>Error!</strong>
                        <?php echo implode('<br />', $error); ?>
                        <br />
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
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
                                                                $counter = 0;

                                                                $total_fields = count($fields);
                                                                foreach ($fields as $fk => $f) {
                                                                    if (empty($f['element']))
                                                                        continue;

                                                                    $e = $f['element'];

                                                                    ////////////if block given by kamran
                                                                    if ($v['section_size'] == 'full') {
                                                                        $section_size = ' col-md-12 ';
                                                                        $label_class =  ' hidden ';
                                                                        $field_class = ' col-md-12 ';
                                                                    } else {
                                                                        $section_size = ' col-md-6 ';
                                                                        $label_class =  '  ';
                                                                        $field_class = ' col-md-8 ';
                                                                    }
                                                                    /////////////////////////////////

                                                                    if (!empty($e) && isset($e[0])) {
                                                                        if($e[0]=='related_module' or $e[0]=='editor'){
                                                                            $section_size = ' col-md-12 ';
                                                                            $field_class = ' col-md-12 ';
                                                                        }
                                                                        if($e[0]=='empty'){
                                                                           $inner_section['section_html'] .= '<div class="col-md-6">';
                                                                           $inner_section['section_html'] .= '<div class="form-group">';
                                                                           $inner_section['section_html'] .=    '<label class="control-label col-md-4"></label>';
                                                                           $inner_section['section_html'] .=     '<div class="col-md-8">';
                                                                           $inner_section['section_html'] .=   generateFormElementView($e,$this->da,$fk);
                                                                           $inner_section['section_html'] .=     '</div>';
                                                                           $inner_section['section_html'] .= '</div>';
                                                                           $inner_section['section_html'] .= '</div>';
                                                                        } else if($e[0]!='hidden'){
                                                                            /*
                                                                            $inner_section['section_html'] .= '<div class="col-md-6">';
                                                                            $inner_section['section_html'] .= '<div class="form-group">';
                                                                            $inner_section['section_html'] .=    '<label class="control-label col-md-4">'. $f['alias'].'</label>';
                                                                            $inner_section['section_html'] .=     '<div class="col-md-8">';
                                                                            $inner_section['section_html'] .=   generateFormElementView($e,$this->da,$fk);
                                                                            */
                                                                            
                                                                
                                                                            ////////////if block given by kamran
                                                                            $unique=explode(".",$fk);
                                                                            $inner_section['section_html'] .= '<div class="'.$section_size.'" id="'.$unique[1].'_ID">';
                                                                            $inner_section['section_html'] .= '<div class="form-group">';

                                                                            /////////
                                                                            if(array_key_exists('attach', $e[1]))
                                                                                $ev=$e[1];
                                                                            elseif(array_key_exists('attach', $e[2]))
                                                                                $ev=$e[2];
                                                                            elseif(array_key_exists('attach', $e[3]))
                                                                                $ev=$e[3];
                                                                            elseif(array_key_exists('attach', $e[4]))
                                                                                $ev=$e[4];

                                                                            $attach=trim($ev['attach']);

                                                                            if(isset($attach) and $attach=='attached'){
                                                                                $table = explode('.',$fk);
                                                                                if(isset($_GET['key'])){
                                                                                    $column = explode('.',key($_GET['key']));
                                                                                    $dataforcheckbox = $CI->db->get_where($table[0],array($column[1]=>$_GET['key'][key($_GET['key'])]))->row_array();
                                                                                    if($dataforcheckbox[$ev['fieldname']]==1){
                                                                                        $checked = '<input class="form-control" onclick="changevalues(this.id);" type="checkbox" id="get-data'.ucwords($table[0]).ucwords($ev['fieldname']).'" checked="checked">';
                                                                                        $checked .= '<input type="hidden" id="data'.ucwords($table[0]).ucwords($ev['fieldname']).'" name="data['.$table[0].']['.$ev['fieldname'].']" value="1">';
                                                                                    } else{
                                                                                        $checked = '<input class="form-control" onclick="changevalues(this.id);" type="checkbox" id="get-data'.ucwords($table[0]).ucwords($ev['fieldname']).'">';
                                                                                        $checked .= '<input type="hidden" id="data'.ucwords($table[0]).ucwords($ev['fieldname']).'" name="data['.$table[0].']['.$ev['fieldname'].']" value="0">';
                                                                                    } 
                                                                                } else {
                                                                                    $checked = '<input class="form-control" onclick="changevalues(this.id);" type="checkbox" id="get-data'.ucwords($table[0]).ucwords($ev['fieldname']).'">';
                                                                                    $checked .= '<input type="hidden" id="data'.ucwords($table[0]).ucwords($ev['fieldname']).'" name="data['.$table[0].']['.$ev['fieldname'].']" value="0">';
                                                                                }
                                                                            } else{
                                                                                $checked = '';
                                                                            }
                                                                            $inner_section['section_html'] .=    ' <label class="control-label col-md-12 '.$label_class.'">'.$checked .' '. ucwords(str_replace('_', ' ', $f['alias'])) .'</label>';
                                                                            ///////////////////////
                                                                            //$inner_section['section_html'] .=    '<label class="control-label col-md-12 '.$label_class.'">'. $f['alias'].'</label>';
                                                                            $inner_section['section_html'] .=     '<div class="col-md-12 '.$field_class.'">';
                                                                            $inner_section['section_html'] .=   generateFormElementView($e,$this->da,$fk);
                                                                            ///////////////////////////////////
                                                                            $inner_section['section_html'] .=     '</div>';
                                                                            $inner_section['section_html'] .= '</div>';
                                                                            $inner_section['section_html'] .= '</div>';
                                                                        } else {
                                                                            $inner_section['section_html'] .= '<div class="col-md-6" style="display:none;">';
                                                                            $inner_section['section_html'] .= '<div class="form-group">';
                                                                            $inner_section['section_html'] .=    '<label class="control-label col-md-12">'. $f['alias'].'</label>';
                                                                            $inner_section['section_html'] .=     '<div class="col-md-12">';
                                                                            $inner_section['section_html'] .=   generateFormElementView($e,$this->da,$fk);
                                                                            $inner_section['section_html'] .=     '</div>';
                                                                            $inner_section['section_html'] .= '</div>';
                                                                            $inner_section['section_html'] .= '</div>';
                                                                            continue;
                                                                        }

                                                                    }

                                                                    if($e[0]=='related_module'){
                                                                        $counter++;
                                                                    }                        

                                                                    if($counter == 1){
                                                                        $inner_section['section_html'] .=  '</div>';
                                                                        $inner_section['section_html'] .= '<div class="clearfix"></div>';
                                                                        $inner_section['section_html'] .=  '<div class="row">';
                                                                        $counter = 0;
                                                                    } else {
                                                                        $counter++;
                                                                    }
                                                                    
                                                                    
                                                                }
                                                                $inner_section['section_html'] .=  '</div>';
                                                                $sections[] = $inner_section;
                                                                unset($inner_section);
                                                            }
                                                        }
                                                        $total_sectoins =  count($sections);
                                                        $form_html = '';
                                                        $tab_li = '';
                                                        $tab_main_div = '';
                                                        $tab_ul_start = '';
                                                        $active_class = '';
                                                        // Table UL
                                                        $tab_ul_end = '';
                                                        $tab_content_div = '';
                                                        $tab_content_start = '';
                                                        $tab_content_end = '';
                                                        $tab_main_div_close = '';
                                                        // Test
                                                        $test = array();
                                                        $scounter = 1;
                                                        $tcounter = 1;
                                                        foreach ($sections as $sk => $sv) {
                                                            if ($sv['section_view'] == 'outer') {
                                                                $form_html .= '<h3 class="form-section">'.$sv['section_title'].'</h3>';
                                                                $form_html .= $sv['section_html'];
                                                            } elseif ($sv['section_view'] == 'accordion') {
                                                                // Codding for accordion
                                                                $toggle_class = '';
                                                                if ($tcounter ==1) {
                                                                    $tab_main_div = '<div class="panel-group accordion" id="frm_accordion">';
                                                                    $active_class = 'in';
                                                                } else {
                                                                    $toggle_class = 'collapsed';
                                                                    $active_class = 'collapse';
                                                                }
                                                                $tab_content_div .= '<div class="panel panel-default">
                                                                    <div class="panel-heading">
                                                                        <h4 class="panel-title">
                                                                            <a class="accordion-toggle accordion-toggle-styled '.$toggle_class.'" data-toggle="collapse" data-parent="#frm_accordion" href="#frm_accordion_'.$scounter.'"> '.$sv['section_title'].' </a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="frm_accordion_'.$scounter.'" class="panel-collapse '.$active_class.'">
                                                                        <div class="panel-body">
                                                                            '.$sv['section_html'].'
                                                                        </div>
                                                                    </div>
                                                                </div>';
                                                                $last_tab = $scounter - $total_sectoins;
                                                                if ($last_tab== 0) {
                                                                    $tab_main_div_close = '</div>';
                                                                }
                                                                $active_class = '';
                                                                $tcounter++;
                                                                // codign for accordtion ends here
                                                            } else if ($sv['section_view'] == 'tabbed') {
                                                                // Coding for tabbed view
                                                                if ($tcounter ==1) {
                                                                    $test['counter_is_one'][] = 'yes';
                                                                    $tab_main_div = '<div class="tabbable tabbable-tabdrop">';
                                                                    $tab_ul_start = '<ul class="nav nav-tabs">';
                                                                    $tab_content_start = '<div class="tab-content">';
                                                                    $active_class = 'active';

                                                                }
                                                                $test['counter_is_number'][] = $scounter;
                                                                $tab_li .= '<li class="'.$active_class.'"><a href="#'.$sv['section_name'].'" data-toggle="tab">'.$sv['section_title'].'</a></li>';
                                                                $tab_content_div .= '<div class="tab-pane '.$active_class.'" id="'.$sv['section_name'].'">'.$sv['section_html'].'</div>';
                                                                $last_tab = $scounter - $total_sectoins;
                                                                if ($last_tab== 0) {
                                                                    $test['counter_is_last'][] = 'yes';
                                                                    $tab_content_end = '</div>';
                                                                    $tab_ul_end = '</ul>';
                                                                    $tab_main_div_close = '</div>';
                                                                }
                                                                $active_class = '';
                                                                $tcounter++;
                                                            }
                                                            $scounter++;
                                                        }
                                                        $form_html .= $tab_main_div;
                                                            $form_html .= $tab_ul_start;
                                                                $form_html .= $tab_li;
                                                            $form_html .= $tab_ul_end;
                                                            $form_html .= $tab_content_start;
                                                                $form_html .= $tab_content_div;
                                                            $form_html .= $tab_content_end;
                                                        $form_html .= $tab_main_div_close;
                                                        echo $form_html;
                                                        ?>


                                                    </div>
                                                    
                                                </form>
                                                <!-- END FORM-->
                                            </div>
                                        </div>
<script>
// GET JSON FROM DATA START
  function selectedRecordArray(jsondata) {
   $.each(jsondata, function (i, elem) {
    selectedRecordquickcreate(elem);
   });
  }
  // GET JSON FROM DATA END

        /*$('data[business][sage]').click(function(){
            var thisVal = $(this).val();
            //var rowId = $('dataBusinessDate_added_sage').parent().parent().parent().parent().parent().attr("id");
            alert(thisVal);
        });*/
        /**/
        //CHNAGES BY KAMRAN SAB START
        function selectedRecord(data){
            if (data.module_value == '') {
                showRelatedTabularData(data)
            } else {
                var recordId = data.selected_id;
                var recordValue = $('input[name="record_viewfield_'+data.selected_id+'"]').val();
                $('#'+data.hidden_controll).val(recordId);
                $('#'+data.visible_controll).val(recordValue);
                $('.modal_'+data.module_id).modal('hide');
            }
            
        }
        
        function showRelatedTabularData(jData){
            
            if($('#'+jData.hidden_controll).val()){
                var preSelectedRecords = $('#'+jData.hidden_controll).val();
                var selectedRecords = preSelectedRecords.split(',');
                selectedRecords.push(jData.selected_id);
                $('#'+jData.hidden_controll).val(selectedRecords.join());
                $.ajax({
                    type: 'POST',
                    url: '?com_id='+jData.module_id+'&xtype=summary_view_datalist',
                    data:{module_id:jData.module_id, module_key:'id', module_value:'', hidden_controll:jData.hidden_controll, visible_controll:jData.visible_controll, selected_id:selectedRecords},
                    success: function(data) {       
                        $('#'+jData.visible_controll).html(data);
                        //$('.'+modalClass).modal('hide');
                    }
                });
                
                var uniqueNames = [];
                $.each(selectedRecords, function(i, el){
                    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                });
                $('#'+jData.hidden_controll).val(uniqueNames.join());
            } else {
                var selectedRecords = [];
                selectedRecords.push(jData.selected_id);
                $('#'+jData.hidden_controll).val(selectedRecords.join());
                $.ajax({
                    type: 'POST',
                    url: '?com_id='+jData.module_id+'&xtype=summary_view_datalist',
                    data:{module_id:jData.module_id, module_key:'id', module_value:'', hidden_controll:jData.hidden_controll, visible_controll:jData.visible_controll, selected_id:selectedRecords},
                    success: function(data) { 
                        $('#'+jData.visible_controll).append(data);
                        console.log(data);                 
                         //$('.'+modalClass).modal('hide');
                    }
                });
                var uniqueNames = [];
                $.each(selectedRecords, function(i, el){
                    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                });
                $('#'+jData.hidden_controll).val(uniqueNames.join());
            }
        }

        function summaryView(jData){
            summaryViewModal(jData);
        }
        // Summary View
        // Genereates quick create form content
        function summaryViewContent(jData){
            var content = $("#crudForm").clone(true);
            content.find('.form-body').html('');
            <?php
                $q = $this->queryString;
                $q['xtype'] = 'summary';
                if (isset($q['key']))
                unset($q['key']);
            ?>  //quickcreateform
            $.ajax({
                type: 'GET',
                url: '?com_id='+jData.module_id+'&xtype=summary&module_key='+jData.module_key+'&module_value='+jData.module_value+'&condition='+jData.condition+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll,
                success: function(data) {   
                    <?php
                        $q = $this->queryString;
                        $q['src']['p'] = 1;
                        $q['xtype'] = 'summary';
                        $q['com_id'] = 'id';
                        if (isset($q['xid']))
                        unset($q['xid']);
                    ?>
                    var actionUrl = '?com_id='+jData.module_id+'&xtype=summary';                             
                    $(content).css('visibility','visible');
                    $(content).attr('id','quickcreate');
                    $(content).find(".alert").hide();
                    $(content).attr('action',actionUrl);
                    $(content).find('.form-body').html(data);
                    
                    var table = $('#dtbl_'+jData.hidden_controll);
                    table.dataTable({
                    // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                    "language": {
                        "aria": {
                            "sortAscending": ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        },
                        "emptyTable": "No data available in table",
                        "info": "Showing _START_ to _END_ of TOTAL records",
                        "infoEmpty": "No records found",
                        "infoFiltered": "(filtered1 from MAX total records)",
                        "lengthMenu": "Show _MENU_",
                        "search": "Search:",
                        "zeroRecords": "No matching records found",
                        "paginate": {
                            "previous":"Prev",
                            "next": "Next",
                            "last": "Last",
                            "first": "First"
                        }
                    },
                    "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
                    
                    "columnDefs": [ {
                        "targets": 0,
                        "orderable": false,
                        "searchable": false
                    }],

                    "lengthMenu": [
                        [5, 15, 20, -1],
                        [5, 15, 20, "All"] // change per page values here
                    ],
                    // set the initial value
                    "pageLength": 5,            
                    "pagingType": "bootstrap_full_number",
                    "columnDefs": [{  // set default column settings
                        'orderable': false,
                        'targets': [0],
                        "autoWidth":true
                    }, {
                        "searchable": true,
                        "targets": [0]
                    }],
                    "order": [
                        [0, "asc"]
                    ] // set first column as a default sort by asc
                });
                // Apply the search

                    }
                });
            return content ;
        }
        function summaryViewModal(jData) {
            var modalClass = 'modal_'+jData.module_id;
            bootbox.dialog({
                className:modalClass,
                message: summaryViewContent(jData),
                title: "Select Record",
                size:"large",
                buttons: {
                        cancel: {
                            label: 'Close',
                            className: 'btn-warning'
                        }/*,
                        quickcreate: {
                            label: 'Select',
                            className: 'btn-success',
                            callback: function (data) {
                                
                                return false;
                            }
                        }*/
                }
            });
        }
    // Summary View Ends
    
    //RELATED MPDULE POPUP HERE STARTS
    function insertRelated(jData){
        quickCreateModal(jData);
    }
    //RELATED MODULE POPUP ENDS
    // Genereates quick create form content
    function quickCreateFormContent(jData){
        var content = $("#crudForm").clone(true);
        content.find('.form-body').html('');
        <?php
            $q = $this->queryString;
            $q['xtype'] = 'quickcreate';
            if (isset($q['key']))
            unset($q['key']);
        ?>  //quickcreateform
        $.ajax({
            type: 'GET',
            url: '?com_id='+jData.module_id+'&xtype=quickcreate&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll,
            success: function(data) {   
                <?php
                    $q = $this->queryString;
                    $q['src']['p'] = 1;
                    $q['xtype'] = 'quickcreateform';
                    $q['com_id'] = 23;
                    if (isset($q['xid']))
                    unset($q['xid']);
                ?>
                var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateform';                            
                $(content).css('visibility','visible');
                $(content).attr('id','quickcreate');
                $(content).attr('action',actionUrl);
                $(content).find('.form-body').html(data);
            }
        });
        return content ;
    }
    function quickCreateModal(jData) {
        var modalClass = 'modal_'+jData.module_id;
        bootbox.dialog({
            className:modalClass,
            message: quickCreateFormContent(jData),
            title: "Quick Create Form!",
            buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    quickcreate: {
                        label: 'Create ',
                        className: 'btn-success',
                        callback: function (data) {
                            //Serialize form data
                            var frmdata = new FormData($("#quickcreate")[0]);
                            var validatorNode = validateform();
                            if(validatorNode==1){
                                var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll; 
                                $.ajax({
                                    url: actionUrl,
                                    type: $("#quickcreate").attr("method"),
                                    data: frmdata,
                                    processData: false,
                                    contentType: false,
                                    success: function (response) { 
                                        console.log(response);
                                        selectedRecordquickcreate(JSON.parse(response));
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                       console.log(textStatus, errorThrown);
                                    }
                                });
                                $('.'+modalClass).modal('hide');
                            }
                            return false;   
                        }
                    }
            }
        });
    }
    
    function selectedRecordquickcreate(data){
        if (data.module_value == '') {
            showRelatedTabularData(data)
        } else {
            var recordId = data.selected_id;//Sbah Changes here
            var recordValue = data.module_value;
            $('#'+data.hidden_controll).val(recordId);
            $('#'+data.visible_controll).val(recordValue);
             //$('.'+modalClass).modal('hide');
             console.log(data);
        }
    }
    //CHNAGES BY KAMRAN SAB END

    function crudCancel() {
        <?php
        $q = $this->queryString;

        if($c_id==41 or $c_id==42 or $c_id==43 or $c_id==44 or $c_id==45 or $c_id==58 or $c_id==62 or $c_id==63 or $c_id==64 or $c_id==70 or $c_id==74)
            $q['com_id']=$sess_cid;
        $q['xtype'] = 'index';
        if (isset($q['key']))
            unset($q['key']);
        ?>
        window.location = "?<?php echo http_build_query($q, '', '&'); ?>";
    }
    
    function crudConfirm() {
        <?php
        $q = $this->queryString;
        $q['xtype'] = 'update';
        if (isset($q['xid']))
            unset($q['xid']);

        ?>
        $('#crudForm').attr({action: '?<?php echo http_build_query($q, '', '&'); ?>'});
        $('#crudForm').submit();
    }
    function crudDraft() {
        <?php
        $q = $this->queryString;
        $q['xtype'] = 'updateDraft';
        if (isset($q['xid']))
            unset($q['xid']);

        ?>
        $('#crudForm').attr({action: '?<?php echo http_build_query($q, '', '&'); ?>'});
        $('#crudForm').submit();
    }
    
    $(document).ready(function() {
        $('title').text('<?php echo $this->title; ?>');
    });
    
    //------------------------------------------------RELATED MODULE BY SALMAN STARTS HERE-------------------------------------------------------------//
    function insertRelatedModule(jData){
        quickCreateModalModule(jData);
    }
    
    function quickCreateModalModule(jData) {
        if(jData.module_id=='75' || jData.module_id=='59' || jData.module_id=='60' || jData.module_id=='61' || jData.module_id=='48' || jData.module_id=='49' || jData.module_id=='47'){
            var modalClass = 'modal_'+jData.module_id;
            bootbox.dialog({
                className:modalClass,
                message: quickCreateFormContentModule(jData),
                buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    quickcreateModule: {
                        label: 'Create ',
                        className: 'btn-success',
                        callback: function (data) {
                            var lEdior = $('dataLegal_letters_dataContent');
                            if (lEdior != undefined) {
                                var ckContent = $('#cke_1_contents iframe').contents().find('body').html();
                                $('#dataLegal_letters_dataContent').val(ckContent);
                            }
                            // Serialize the data in the form
                            if(jData.existing!=''){
                               $('#existing').val(jData.existing);
                              }
                            var frmdata = new FormData($("#quickcreateModule")[0]);
                            var validatorNode = validateform();
                            if(validatorNode==1){
                                var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll+'&status=Active'; 
                                $.ajax({
                                    url: actionUrl,
                                    type: $("#quickcreateModule").attr("method"),
                                    data: frmdata,
                                    processData: false,
                                    contentType: false,
                                    success: function (response) { 
                                    console.log(response);
                                    selectedRecordquickcreate(JSON.parse(response));
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                       console.log(textStatus, errorThrown);
                                    }
                                });
                                $('.'+modalClass).modal('hide');                            
                           }
                            return false;
                        }
                    },
                    quickcreateModuleDraft: {
                        label: 'Save As Draft ',
                        className: 'btn-success',
                        callback: function (data) {
                            var lEdior = $('dataLegal_letters_dataContent');
                            if (lEdior != undefined) {
                                var ckContent = $('#cke_1_contents iframe').contents().find('body').html();
                                $('#dataLegal_letters_dataContent').val(ckContent);
                            }
                            // Serialize the data in the form
                            if(jData.existing!=''){
                               $('#existing').val(jData.existing);
                              }
                            var frmdata = new FormData($("#quickcreateModule")[0]);
                            var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll+'&status=Draft'; 
                            $.ajax({
                                url: actionUrl,
                                type: $("#quickcreateModule").attr("method"),
                                data: frmdata,
                                processData: false,
                                contentType: false,
                                success: function (response) { 
                                console.log(response);
                                selectedRecordquickcreate(JSON.parse(response));
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                   console.log(textStatus, errorThrown);
                                }
                            });
                            $('.'+modalClass).modal('hide');                            
                            return false;
                        }
                    }
                }
            });
        } else {
            var modalClass = 'modal_'+jData.module_id;
            bootbox.dialog({
                className:modalClass,
                message: quickCreateFormContentModule(jData),
                buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    quickcreateModule: {
                        label: 'Create ',
                        className: 'btn-success',
                        callback: function (data) {
                            var lEdior = $('dataLegal_letters_dataContent');
                            if (lEdior != undefined) {
                                var ckContent = $('#cke_1_contents iframe').contents().find('body').html();
                                $('#dataLegal_letters_dataContent').val(ckContent);
                            }
                            // Serialize the data in the form
                            if(jData.existing!=''){
                               $('#existing').val(jData.existing);
                              }
                            var frmdata = new FormData($("#quickcreateModule")[0]);
                            var validatorNode = validateform();
                            if(validatorNode==1){
                                var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll; 
                                $.ajax({
                                    url: actionUrl,
                                    type: $("#quickcreateModule").attr("method"),
                                    data: frmdata,
                                    processData: false,
                                    contentType: false,
                                    success: function (response) { 
                                    console.log(response);
                                    selectedRecordquickcreate(JSON.parse(response));
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                       console.log(textStatus, errorThrown);
                                    }
                                });
                                $('.'+modalClass).modal('hide');                            
                           }
                            return false;
                        }
                    }
                }
            });
        }
    }
    
    
    function quickCreateFormContentModule(jData){
        var content = $("#crudForm").clone(true);
        content.find('.form-body').html('');
        <?php
            $q = $this->queryString;
            $q['xtype'] = 'quickcreateModule';
            if (isset($q['key']))
            unset($q['key']);
        ?> 
        //quickcreateModuleform
        $.ajax({
            type: 'GET',
            url: '?com_id='+jData.module_id+'&xtype=quickcreateModule&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll,
            success: function(data) {   
                <?php
                    $q = $this->queryString;
                    $q['src']['p'] = 1;
                    $q['xtype'] = 'quickcreateModuleform';
                    $q['com_id'] = 23;
                    if (isset($q['xid']))
                    unset($q['xid']);
                ?>
                var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform';                            
                $(content).css('visibility','visible');
                $(content).attr('id','quickcreateModule');
                $(content).attr('action',actionUrl);
                $(content).find('.form-body').html(data);
            }
        });
        return content ;
    }
    //------------------------------------------------RELATED MODULE BY SALMAN STARTS HERE-------------------------------------------------------------//
    </script>
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

            $('.timepicker').timepicker({
                autoclose: true,
                minuteStep: 1
            });


        });
        
        
    function remoRelModRecord(jData){
        var preSelectedRecords = $('#'+jData.hidden_controll).val();
        var selectedRecords = preSelectedRecords.split(',');
        var index = selectedRecords.indexOf(jData.selected_id);
        if (index >= 0) {
          selectedRecords.splice( index, 1 );
        }
        $('#'+jData.hidden_controll).val(selectedRecords.join());
        var preSelectedRecords = $('#'+jData.hidden_controll).val();
        if(preSelectedRecords==''){
            $('#'+jData.visible_controll).empty();
        }

        for (var i = 0; i < selectedRecords.length; i++) {
            jData.selected_id = selectedRecords[i];
            selectedRecord(jData);
        }   
    }

    //VIEW RELATED DATA START
    function ViewRelModRecord(jData){
        bootbox.dialog({
            message: ViewRelContentModule(jData),
            buttons: {
                cancel: {
                    label: 'Close',
                    className: 'btn-warning'
                }
            }
        });
    }
    
    function ViewRelContentModule(jData){
        var content = $("#crudForm").clone(true);
        content.find('.form-body').html('');
        $.ajax({
            type: 'POST',
            data    : jData,
            url     : 'status?cfun=getModuletableDetails',
            success: function(tablename) {   
                $.ajax({
                    type: 'GET',
                    url: '?com_id='+jData.module_id+'&xtype=viewRelatedModuleData&key['+tablename+'.'+jData.module_key+']='+jData.selected_id,
                    success: function(data) {   
                        var actionUrl = '?com_id='+jData.module_id+'&xtype=view';                            
                        $(content).css('visibility','visible');
                        $(content).attr('id','quickcreateModule');
                        $(content).attr('action',actionUrl);
                        $(content).find('.form-body').html(data);
                    }
                });
            }
        });
        
        return content ;
    }
    //VIEW RELATED DATA START
    
    //EDIT RELATED MODULE DATA CODE START
    function EditRelModRecord(jData){
        quickCreateModalModuleEdit(jData);
    }
    function quickCreateModalModuleEdit(jData) {
        if(jData.module_id=='75' || jData.module_id=='59' || jData.module_id=='60' || jData.module_id=='61' || jData.module_id=='48' || jData.module_id=='49' || jData.module_id=='47'){
            var modalClass = 'modal_'+jData.module_id;
            bootbox.dialog({
                className:modalClass,
                message: quickCreateFormContentModuleEdit(jData),
                buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    quickcreateModule: {
                        label: 'Update ',
                        className: 'btn-success',
                        callback: function (data) {
                            var lEdior = $('dataLegal_letters_dataContent');
                            if (lEdior != undefined) {
                                var ckContent = $('#cke_1_contents iframe').contents().find('body').html();
                                $('#dataLegal_letters_dataContent').val(ckContent);
                            }
                            // Serialize the data in the form
                            if(jData.existing!=''){
                               $('#existing').val(jData.existing);
                              }
                            var frmdata = new FormData($("#quickcreateModule")[0]);
                            var validatorNode = validateform();
                            if(validatorNode==1){
                                var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll; 
                                $.ajax({
                                    url: actionUrl,
                                    type: $("#quickcreateModule").attr("method"),
                                    data: frmdata,
                                    processData: false,
                                    contentType: false,
                                    success: function (response) { 
                                    console.log(response);
                                    selectedRecordquickcreate(JSON.parse(response));
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                       console.log(textStatus, errorThrown);
                                    }
                                });
                                $('.'+modalClass).modal('hide');                            
                           }
                            return false;
                        }
                    },
                    quickcreateModuleDraft: {
                        label: 'Save As Draft ',
                        className: 'btn-success',
                        callback: function (data) {
                            var lEdior = $('dataLegal_letters_dataContent');
                            if (lEdior != undefined) {
                                var ckContent = $('#cke_1_contents iframe').contents().find('body').html();
                                $('#dataLegal_letters_dataContent').val(ckContent);
                            }
                            // Serialize the data in the form
                            if(jData.existing!=''){
                               $('#existing').val(jData.existing);
                              }
                            var frmdata = new FormData($("#quickcreateModule")[0]);
                            var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll; 
                            $.ajax({
                                url: actionUrl,
                                type: $("#quickcreateModule").attr("method"),
                                data: frmdata,
                                processData: false,
                                contentType: false,
                                success: function (response) { 
                                console.log(response);
                                selectedRecordquickcreate(JSON.parse(response));
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                   console.log(textStatus, errorThrown);
                                }
                            });
                            $('.'+modalClass).modal('hide');                            
                            return false;
                        }
                    }
                }
            });
        } else {
            var modalClass = 'modal_'+jData.module_id;
            bootbox.dialog({
                className:modalClass,
                message: quickCreateFormContentModuleEdit(jData),
                buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    quickcreateModule: {
                        label: 'Update ',
                        className: 'btn-success',
                        callback: function (data) {
                            var lEdior = $('dataLegal_letters_dataContent');
                            if (lEdior != undefined) {
                                var ckContent = $('#cke_1_contents iframe').contents().find('body').html();
                                $('#dataLegal_letters_dataContent').val(ckContent);
                            }
                            // Serialize the data in the form
                            if(jData.existing!=''){
                               $('#existing').val(jData.existing);
                              }
                            var frmdata = new FormData($("#quickcreateModule")[0]);
                            var validatorNode = validateform();
                            if(validatorNode==1){
                                var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll; 
                                $.ajax({
                                    url: actionUrl,
                                    type: $("#quickcreateModule").attr("method"),
                                    data: frmdata,
                                    processData: false,
                                    contentType: false,
                                    success: function (response) { 
                                    console.log(response);
                                    selectedRecordquickcreate(JSON.parse(response));
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                       console.log(textStatus, errorThrown);
                                    }
                                });
                                $('.'+modalClass).modal('hide');                            
                           }
                            return false;
                        }
                    }
                }
            });
        }
    }

    
    function quickCreateFormContentModuleEdit(jData){
        var content = $("#crudForm").clone(true);
        content.find('.form-body').html('');
        //quickcreateModuleform
        $.ajax({
            type: 'POST',
            data    : jData,
            url     : 'status?cfun=getModuletableDetails',
            success: function(tablename) {   
                $.ajax({
                    type: 'GET',
                    url: '?com_id='+jData.module_id+'&xtype=quickcreateModule&key['+tablename+'.'+jData.module_key+']='+jData.selected_id+'&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll,
                    success: function(data) {   
                        var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform';                            
                        $(content).css('visibility','visible');
                        $(content).attr('id','quickcreateModule');
                        $(content).attr('action',actionUrl);
                        $(content).find('.form-body').html(data);
                    }
                });
            }
        });
        return content ;
    }
    //EDIT RELATED MODULE DATA CODE END
    
    </script>
    <script src="<?php echo base_url(); ?>media/js/mfunctions/mfunctions.js" type="text/javascript"></script>
</div>
<style>
.FixedHeightContainer
    {
        max-height: 150px;
        padding:10px;
        overflow:auto;
        background:#fff;
    }
</style>
<script>
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


 

    //Unique data in Related Module
    function getExistingData(existcontact,newcontact,com_id,field){
        var resp = null;
        $.ajax({
            type: 'POST',
            'async': false,
            data : { exists : existcontact, newcontact : newcontact, com_id:com_id, field:field },
            url: 'status?cfun=getDetails',
            success: function(data) {   
                resp = data;
            }
        });
        return resp;
    };   


    //Related Module Function
    function showdivsbelow(id,loadval=0){
        if($('#'+id).val() != ''){
            var key_value = '<?php echo $_GET['key'][key($_GET['key'])];?>';
            var control_value = $('#'+id).val();
            $('#'+id).parent().parent().parent().parent().nextAll().show();
            $.ajax({
                type: 'GET',
                data : { rid : key_value, id : control_value, loadval: loadval },
                url: 'status?cfun=setLegalData',
                success: function(data) {    
                    var obj = jQuery.parseJSON(data);
                    $('#dataLegal_letters_dataLetter_Title').val(obj.Letter_Title);
                    $('#dataLegal_letters_dataContent').text(obj.Content);
                    $('#dataLegal_letters_dataBusiness_Name').val(obj.Business_Name);
                    $('#dataLegal_letters_dataClient_ID').val(obj.Client_ID);
                    $('#dataLegal_letters_dataBusiness_Address').val(obj.Business_Address);
                    CKEDITOR.instances.dataLegal_letters_dataContent.setData(obj.Content);
                }
            });
        } else {
            $('#'+id).parent().parent().parent().parent().nextAll().hide();
        }
    }; 

    //Related Module Function
    function downloadPDF(jdata){
        var key_value = '<?php echo $_GET['key'][key($_GET['key'])];?>';
        window.location="<?=base_url()?>admin/pdfs?id="+jdata.selected_id+"&bid="+key_value+"&com_id="+jdata.module_id;

    }; 
    function viewPDF(jdata){
        var key_value = '<?php echo $_GET['key'][key($_GET['key'])];?>';
        window.open("<?=base_url()?>admin/pdfs?id="+jdata.selected_id+"&bid="+key_value+"&com_id="+jdata.module_id+"&action=view",'_blank')
    }; 
</script>