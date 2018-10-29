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
$keyval10 = '';
$keyval11 = '';
if(isset($_GET['key']) && ($keyid = $_GET['key']['business.id'] or $keyid = $_GET['key']['forms.id'] or $keyid = $_GET['key']['codes.id'] or $keyid = $_GET['key']['compliance.id'] or $keyid = $_GET['key']['services.id'] or $keyid = $_GET['key']['business_fee.id'] or $keyid = $_GET['key']['legal_letters_business.id'])){
    $keyval0 = "&key[business.id]=".$keyid;
    $keyval1 = "&key[forms.id]=".$keyid;
    $keyval2 = "&key[codes.id]=".$keyid;
    $keyval3 = "&key[compliance.id]=".$keyid;
    $keyval4 = "&key[services.id]=".$keyid;
    $keyval5 = "&key[business_fee.id]=".$keyid;
    $keyval6 = "&key[legal_letters_business.id]=".$keyid;
}elseif(isset($_GET['key']) && ($keyid = $_GET['key']['jobs.id'] or $keyid = $_GET['key']['checklist.id'])){
    $keyval10 = "&key[jobs.id]=".$keyid;
    $keyval11 = "&key[checklist.id]=".$keyid;
}


if($c_id==85){
    if($_GET['key']){
        $CI->db->select('job_sub_category');
        $CI->db->from('jobs');
        $CI->db->where('id',$_GET['key']['checklist.id']);
        $query = $CI->db->get();
        $chk = $query->row_array();
        $chkid = $chk['job_sub_category'];

        $CI->db->select('*');
        $CI->db->from('checklists');
        $CI->db->where('group_id',$chkid);
        $query = $CI->db->get();
        $chk = $query->row_array();
        $this->form = unserialize($chk['config']); 
        $this->form = $this->form['elements'];

        $CI->db->select('form_data');
        $CI->db->from('checklist');
        $CI->db->where('id',$_GET['key']['checklist.id']);
        $query = $CI->db->get();
        $chk = $query->row_array();
        $rs = unserialize($chk['form_data']); 
        if (!empty($rs))
            $_POST = array_merge($_POST, array('data' => $rs));

        //$this->form = json_decode($chk['build_config']); 
        //$this->form = json_decode($chk['section_config'], true); 
    }
}
                //echo "<pre>";print_r($this->form);print_r($_POST); echo "</pre>";exit;

?>
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                            <?php
                                            if($c_id==41 or $c_id==42 or $c_id==43 or $c_id==44 or $c_id==45 or $c_id==58 or $c_id==62 or $c_id==63 or $c_id==64 or $c_id==70 or $c_id==74){
                                            ?>
                                                <div class="pull-left">
                                                    <a href="<?=base_url(); ?>admin/scrud/browse?com_id=<?=$sess_cid?>&xtype=form<?=$keyval0?>" class="btn btn-sm <?php if($c_id==41 or $c_id==42 or $c_id==43 or $c_id==44 or $c_id==45){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?>">Business Setup
                                                    </a>
                                                     <a href="<?=base_url(); ?>admin/scrud/browse?com_id=58&xtype=form<?=$keyval1?>" class="btn btn-sm <?php if($c_id=='58' or $c_id=='63'){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval1==''){ ?> disabled<?php } ?>">Forms & Codes
                                                    </a>
                                                    <!--<a href="<?=base_url(); ?>admin/scrud/browse?com_id=63&xtype=form<?=$keyval2?>" class="btn btn-sm <?php if($c_id=='63'){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval2==''){ ?> disabled<?php } ?>">Codes
                                                    </a>-->
                                                     <a href="<?=base_url(); ?>admin/scrud/browse?com_id=62&xtype=form<?=$keyval3?>" class="btn btn-sm <?php if($c_id=='62' or $c_id=='74'){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval3==''){ ?> disabled<?php } ?>">Compliance Section
                                                    </a>
                                                     <a href="<?=base_url(); ?>admin/scrud/browse?com_id=70&xtype=form<?=$keyval4?>" class="btn btn-sm <?php if($c_id=='70'){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval4==''){ ?> disabled<?php } ?>">Services
                                                    </a>
                                                    <?php
                                                    $permissions = $CI->crud_auth->getPermissionType(64);
                                                    if(count(array_intersect($permissions, array(1,2))) != 0){
                                                    ?>
                                                     <a href="<?=base_url(); ?>admin/scrud/browse?com_id=64&xtype=form<?=$keyval5?>" class="btn btn-sm <?php if($c_id=='64'){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval5==''){ ?> disabled<?php } ?>">Fee Setup
                                                    </a>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            <?php
                                            }
                                            else if($c_id==76 or $c_id==85){
                                            ?>
                                                <div class="pull-left">
                                                    <a href="<?=base_url(); ?>admin/scrud/browse?com_id=76&xtype=form<?=$keyval10?>" class="btn btn-sm <?php if($c_id==76){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?>">Job
                                                    </a>
                                                     <a href="<?=base_url(); ?>admin/scrud/browse?com_id=85&xtype=form<?=$keyval11?>" class="btn btn-sm <?php if($c_id==85){ ?>blue disabled<?php }else{ ?>red-intense<?php } ?><?php if($keyval11==''){ ?> disabled<?php } ?>">Checklist
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
                                                    <a href="javascript:;" onclick="crudDraft();" class="btn btn-sm green ">Draft <i class="fa fa-edit"></i></a>
                                                <?php
                                                }
                                                ?>
                                                    <?php if (isset($_GET['key'])) { ?>
                                                        <a target="_blank" href="<?=base_url()?>admin/scrud/browse?com_id=<?php echo $_GET['com_id']; ?>&xtype=view_pdf&key[<?php echo $this->table;?>.id]=<?php echo $_GET['key'][$this->table.'.id']; ?>"  class="btn btn-sm red" ><i class="fa fa-download"></i>PDF
                                                        </a>
                                                    <?php } ?>
                                                    
                                                    <a href="javascript:;" onclick="crudCancel();" class="btn btn-sm default "><?php echo $CI->lang->line('cancel');?>
                                                    </a>
                                                </div> 
                                            </div>
                                            <div class="portlet-body form">

                                            <?php
                                            if($c_id==58 or $c_id==63){
                                            ?>
                                            <ul class="nav nav-tabs">
                                                <li <?php if($c_id=='58'){ ?>class="active"<?php } ?>>
                                                    <a href="<?=base_url(); ?>admin/scrud/browse?com_id=58&xtype=form<?=$keyval1?>"> Forms </a>
                                                </li>
                                                <li <?php if($c_id=='63'){ ?>class="active"<?php } ?>>
                                                    <a href="<?=base_url(); ?>admin/scrud/browse?com_id=63&xtype=form<?=$keyval2?>"> Codes </a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"> </div>
                                            <?php 
                                            } 
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
                                                                        if($c_id==85)
                                                                            $label_class =  '  ';
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
                                                                $tab_content_div .= '<div class="panel panel-default" id="section_'.$scounter.'">
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
        /* function selectedRecord(data){
            if (data.module_value == '') {
                showRelatedTabularData(data)
            } else {
                var recordId = data.selected_id;
                var recordValue = $('input[name="record_viewfield_'+data.selected_id+'"]').val();
                $('#'+data.hidden_controll).val(recordId);
                $('#'+data.visible_controll).val(recordValue);
                $('.modal_'+data.module_id).modal('hide');
            }
            
        } */
        
		function selectedRecord(data){
			var modalClass = 'modal_' + data.module_id;
			if (data.module_value == '') {
				showRelatedTabularData(data)
			} else {
				var recordId = data.selected_id;
				var recordValue = '';
				if (data.record_view_value == undefined) {
					recordValue = $('input[name="record_viewfield_'+data.selected_id+'"]').val();
				} else {
					recordValue = data.record_view_value;
				}
				
				console.log(data);
				$('#'+data.hidden_controll).val(recordId);
				$('#'+data.visible_controll).val(recordValue);
				
			}
			$('.'+modalClass).modal('hide');
			
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
                        "info": "Showing _START_ to _END_ of _TOTAL_ records",
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
                            var url = '?com_id='+jData.module_id+'&xtype=quickcreateform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll;
                            var frmdata = new FormData($("#quickcreate")[0]);
                                $('#loading').show();
                            $.ajax({
                                    url: url,
                                    type: $("#quickcreate").attr("method"),
                                    dataType: "JSON",
                                    data: frmdata,
                                    processData: false,
                                    contentType: false,
                                    success: function (data, status)
                                    {
										$('#loading').hide();
                                        $('.form-group ').each(function(){
                                            $(this).removeClass('has-error');
                                            $('.help-block').empty();
                                        });
                                        
                                        
                                        if (data.errors != undefined) {

                                            
                                            var errors = data.errors;
                                            
                                            for (var i = 0; i < errors.length; i++) {
                                                console.log(errors[i][1][0]);
                                                var fieldFullName = (errors[i][0]).split('.');
                                                var fieldId = 'data' + fieldFullName[0].capFirstChar() + fieldFullName[1].capFirstChar();
                                                var parentDiv = $('#'+fieldId).parent().parent();
                                                parentDiv.addClass('has-error');
                                                
                                                var errMsg = '<span class="help-block pull-right" style=" padding-right: 20px;"> '+errors[i][1][0]+' </span>';
                                                parentDiv.append(errMsg);
                                            }
                                            
                                        } else {
											selectedRecord(data.return_data);
                                            //$('.'+modalClass).modal('hide');
                                        }
                                    },
                                    error: function (xhr, desc, err)
                                    {
									$('#loading').hide();

                                    }
                            });        

                            return false;
                        }
                    },
                    fullform: {
                         label: 'Full Form',
                         className: 'btn-success',
                         callback: function (data) {
                            $('.'+modalClass).modal('hide'); 
                            insertRelatedModule(jData);
                        }
                    }

            }
        });
    }
    
	String.prototype.capFirstChar = function() {
		return this.charAt(0).toUpperCase() + this.slice(1);
	}

    function selectedRecordquickcreate(data){
        if (data.module_value == '') {
            showRelatedTabularData(data)
        } else {
            var recordId = data.selected_id;//Sbah Changes here
            if(data.module_id==28)
                var recordValue = data.record_view_value;
            else    
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
        if($c_id==85)
            $q['com_id']=76;
        if($c_id==30)
            $q['com_id']=29;        
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
        if($c_id==85)
            $q['xtype'] = 'updateChecklist';
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
                                var ckContent = $('.cke_contents iframe').contents().find('body').html();
                                $('#dataLegal_letters_dataContent').val(ckContent);
                            }
                            // Serialize the data in the form
                            if(jData.existing!=''){
                               $('#existing').val(jData.existing);
                              }
                            var frmdata = new FormData($("#quickcreateModule")[0]);
                            var validatorNode = validateform();
							
							if(validatorNode==1){
                                var frmdata = new FormData($("#quickcreateModule")[0]);
								var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll+'&status=Active'; 
								$('#loading').show();
								$.ajax({
									url: actionUrl,
									type: $("#quickcreateModule").attr("method"),
									data: frmdata,
									processData: false,
									contentType: false,
									success: function (response) { 
										$('#loading').hide();
										$('.form-group ').each(function(){
											$(this).removeClass('has-error');
											$('.help-block').empty();
										});
										if (response.errors != undefined) {
											var errors = response.errors;
											for (var i = 0; i < errors.length; i++) {
												console.log(errors[i][1][0]);
												var fieldFullName = (errors[i][0]).split('.');
												var fieldId = 'data' + fieldFullName[0].capFirstChar() + fieldFullName[1].capFirstChar();
												var parentDiv = $('#'+fieldId).parent().parent();
												parentDiv.addClass('has-error');
												
												var errMsg = '<span class="help-block pull-right" style=" padding-right: 20px;"> '+errors[i][1][0]+' </span>';
												parentDiv.append(errMsg);
											}
										} else {
											selectedRecordquickcreate(response.return_data);
											$('.'+modalClass).modal('hide');
										}
										console.log(response);
										/* selectedRecordquickcreate(JSON.parse(response)); */
									},
									error: function(jqXHR, textStatus, errorThrown) {
										$('#loading').hide();
									   console.log(textStatus, errorThrown);
									}
								});
								return false;
							} else {
								var parentDiv = $('#unique_contact').parent();
								parentDiv.addClass('has-error');
								var errMsg = '<span class="help-block pull-right" style=" padding-right: 20px;"> Contact Already Exists!</span>';
								parentDiv.find('.help-block').empty();
								//parentDiv.$('.help-block').empty();
								parentDiv.append(errMsg);
								return false;
							}
                        }
                    },
                    quickcreateModuleDraft: {
                        label: 'Save As Draft ',
                        className: 'btn-success',
                        callback: function (data) {
                            var lEdior = $('dataLegal_letters_dataContent');
                            if (lEdior != undefined) {
                                var ckContent = $('.cke_contents iframe').contents().find('body').html();
                                $('#dataLegal_letters_dataContent').val(ckContent);
                            }
                            // Serialize the data in the form
                            if(jData.existing!=''){
                               $('#existing').val(jData.existing);
                              }
                            var frmdata = new FormData($("#quickcreateModule")[0]);
                            var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll+'&status=Draft'; 
                            $('#loading').show();
							$.ajax({
                                url: actionUrl,
                                type: $("#quickcreateModule").attr("method"),
                                data: frmdata,
                                processData: false,
                                contentType: false,
                                success: function (response) { 
								$('#loading').hide();
                                console.log(response);
                                selectedRecordquickcreate(JSON.parse(response));
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
									$('#loading').hide();
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
                                var ckContent = $('.cke_contents iframe').contents().find('body').html();
                                $('#dataLegal_letters_dataContent').val(ckContent);
                            }
                            // Serialize the data in the form
                            if(jData.existing!=''){
                               $('#existing').val(jData.existing);
                              }
                            var frmdata = new FormData($("#quickcreateModule")[0]);
                            var validatorNode = validateform();
							
							if(validatorNode==1){
                                var frmdata = new FormData($("#quickcreateModule")[0]);
								var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll+'&status=Active'; 
								$('#loading').show();
								$.ajax({
									url: actionUrl,
									type: $("#quickcreateModule").attr("method"),
									data: frmdata,
									processData: false,
									contentType: false,
									success: function (response) { 
										$('#loading').hide();
										$('.form-group ').each(function(){
											$(this).removeClass('has-error');
											$('.help-block').empty();
										});
										if (response.errors != undefined) {
											var errors = response.errors;
											for (var i = 0; i < errors.length; i++) {
												console.log(errors[i][1][0]);
												var fieldFullName = (errors[i][0]).split('.');
												var fieldId = 'data' + fieldFullName[0].capFirstChar() + fieldFullName[1].capFirstChar();
												var parentDiv = $('#'+fieldId).parent().parent();
												parentDiv.addClass('has-error');
												
												var errMsg = '<span class="help-block pull-right" style=" padding-right: 20px;"> '+errors[i][1][0]+' </span>';
												parentDiv.append(errMsg);
											}
										} else {
											selectedRecordquickcreate(response.return_data);
											$('.'+modalClass).modal('hide');
										}
										console.log(response);
										/* selectedRecordquickcreate(JSON.parse(response)); */
									},
									error: function(jqXHR, textStatus, errorThrown) {
										$('#loading').hide();
									   console.log(textStatus, errorThrown);
									}
								});
								return false;
							} else {
								var parentDiv = $('#unique_contact').parent();
								parentDiv.addClass('has-error');
								var errMsg = '<span class="help-block pull-right" style=" padding-right: 20px;"> Contact Already Exists!</span>';
								parentDiv.find('.help-block').empty();
								//parentDiv.$('.help-block').empty();
								parentDiv.append(errMsg);
								return false;
							}
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

            //new code added by nauman
                // for diffrence in time of 1 hour

            <?php
            if($c_id==80 or $c_id==25) {
            ?>
                //time
                var strt = $("#dataCalendarTime_start").val();
                var data = strt.split(':');
                var hr = parseInt(data[0]) + 1;
                var str = hr + ':' +  data[1];
                $("#dataCalendarTime_end").val(str);
            <?php } ?>
                
              
                //creating date Object.
                date = new Date();

                //for date
                if(date.getDate()<10){
                d='0'+date.getDate();
                }else{d=date.getDate();}

                //for month
                if(date.getMonth()<10){
                m='0'+(date.getMonth()+1);
                }else{d=date.getMonth()+1;}


                
                /*
                   pre-populated date fields.
                */
                $("input[name='data[calendar][date_start]']").val(d+'-'+m+'-'+date.getFullYear());
                $("input[name='data[calendar][due_date]']").val(d+'-'+m+'-'+date.getFullYear());
                    //nauman code ended here.

            var ttt = "<?php echo isset($_GET['key']['crud_users.id']) ? $_GET['key']['crud_users.id']: "" ;?>";
        
            if(ttt ==""){
                $("[name='data[crud_users][holidays_entitlement]'],[name='data[crud_users][emp_start_date]']").trigger("keyup");
            }
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
                                var ckContent = $('.cke_contents iframe').contents().find('body').html();
                                $('#dataLegal_letters_dataContent').val(ckContent);
                            }
                            // Serialize the data in the form
                            if(jData.existing!=''){
                               $('#existing').val(jData.existing);
                              }
                            var frmdata = new FormData($("#quickcreateModule")[0]);
                            var validatorNode = validateform();
							$('#loading').show();
							if(validatorNode==1){
                                var frmdata = new FormData($("#quickcreateModule")[0]);
								var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll+'&status=Active'; 
								$.ajax({
									url: actionUrl,
									type: $("#quickcreateModule").attr("method"),
									data: frmdata,
									processData: false,
									contentType: false,
									success: function (response) { 
									$('#loading').hide();
									console.log(response);
									selectedRecordquickcreate(JSON.parse(response));
									},
									error: function(jqXHR, textStatus, errorThrown) {
										$('#loading').hide();
									   console.log(textStatus, errorThrown);
									}
								});
								$('.'+modalClass).modal('hide');
								return false;
							} 
                        }
                    },
                    quickcreateModuleDraft: {
                        label: 'Save As Draft ',
                        className: 'btn-success',
                        callback: function (data) {
                            var lEdior = $('dataLegal_letters_dataContent');
                            if (lEdior != undefined) {
                                var ckContent = $('.cke_contents iframe').contents().find('body').html();
                                $('#dataLegal_letters_dataContent').val(ckContent);
                            }
                            // Serialize the data in the form
                            if(jData.existing!=''){
                               $('#existing').val(jData.existing);
                            }
							$('#loading').show();
                            var frmdata = new FormData($("#quickcreateModule")[0]);
                            var actionUrl = '?com_id='+jData.module_id+'&xtype=quickcreateModuleform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll; 
                            $.ajax({
                                url: actionUrl,
                                type: $("#quickcreateModule").attr("method"),
                                data: frmdata,
                                processData: false,
                                contentType: false,
                                success: function (response) { 
								$('#loading').hide();
                                console.log(response);
                                selectedRecordquickcreate(JSON.parse(response));
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
									$('#loading').hide();
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
                                var ckContent = $('.cke_contents iframe').contents().find('body').html();
                                $('#dataLegal_letters_dataContent').val(ckContent);
                            }
                            // Serialize the data in the form
                            if(jData.existing!=''){
                               $('#existing').val(jData.existing);
                              }
							$('#loading').show();
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
									$('#loading').hide();
                                    console.log(response);
                                    selectedRecordquickcreate(JSON.parse(response));
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
										$('#loading').hide();
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
    ////////////nauman code starts here/////////////////////
    function emailLegalLetter(jdata){
        var key_value = '<?php echo $_GET['key'][key($_GET['key'])];?>';
        $('#loading').show();
        $.ajax({
                type: 'GET',
                data : { id : jdata.selected_id , bid : key_value,com_id : jdata.module_id , action : 'email'},
                url: "<?=base_url()?>admin/pdfs?",
                success: function(data) {    
                    console.log(data);
                    var obj = jQuery.parseJSON(data);
                    console.log(obj);
                    ////////
                        var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;"><button data-dismiss="alert" class="close" type="button">×</button>'+obj['message']+'</div>';
                        var alertSuccess = $(strAlertSuccess).appendTo('body');
                        $('#loading').hide();
                        alertSuccess.show();
                        setTimeout(function(){ 
                            alertSuccess.remove();
                        },5000);
                    
                    ////////
                }
            });
        //window.location="<?=base_url()?>admin/pdfs?id="+jdata.selected_id+"&bid="+key_value+"&com_id="+jdata.module_id+"&action=email";

    }; ////////////////nauman code ends here///////////////



    <?php if($CI->session->flashdata('msg')){ ?>
            var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;"><button data-dismiss="alert" class="close" type="button">×</button><?php echo $CI->session->flashdata('msg'); ?></div>';
            var alertSuccess = $(strAlertSuccess).appendTo('body');
            alertSuccess.show();
            setTimeout(function(){ 
                alertSuccess.remove();
            },2000);
            <?php } ?>

</script>
<script type="text/javascript">
//set accounts due date in businesses
function setDate(){
    var data = $("[name='data[business][year_end_date]']").val();
    var legal_entity = $("[name='data[business][legal_entity]']").val();
    var accounts_end_date;
    var xcd = [];
    var seperator = "-";
    xcd = data.split('-');

    if(xcd.length==1){
        xcd = data.split('/');
        seperator = "/";
    }

    var newdate = xcd[1]+seperator+xcd[0]+seperator+xcd[2];
    if(legal_entity == 1 || legal_entity == 2 || legal_entity == 5){
        accounts_end_date = '31'+seperator+'01'+seperator+(parseInt(xcd[2])+1);
    } else if (legal_entity == 3 || legal_entity == 4) {
        var data = new Date(newdate);
        var date=new Date(data.setMonth(data.getMonth()+9));
        accounts_end_date = ( '0' + date.getDate() ).slice( -2 )+seperator+( '0' + (date.getMonth()+1) ).slice( -2 ) +seperator+date.getFullYear();
        var date=new Date(data.setMonth(data.getMonth()+3));
        $("[name='data[business][ct600_due_date]']").val(( '0' + date.getDate() ).slice( -2 )+seperator+( '0' + (date.getMonth()+1) ).slice( -2 ) +seperator+date.getFullYear());
    }

    $("[name='data[business][accounts_due_date]']").val(accounts_end_date);

}

//holidays management
    $("[name='data[crud_users][Available_Holidays]']").prop( "disabled", true );
    $("[name='data[crud_users][holidays_entitlement]'],[name='data[crud_users][emp_start_date]']").on('keyup change',function() { 
        var sd=$("[name='data[crud_users][emp_start_date]']").val();
        <?php
                    
                    $CI->db->select('Holidays_End_Month');
                    $CI->db->from('sites');
                    $CI->db->where('id',$CRUD_AUTH['site_id']);
                    $query=$CI->db->get();
                    $row = $query->row_array();
                    $ed = $row['Holidays_End_Month']; 
        ?>
        var ed='<?=$ed?>';
        sd=  sd.split("-").join("/"); 
         
        var data = sd.split('/');
        sd=data[1];
        sd=sd*1;
        ed=ed*1;

        if((ed-sd)<0){
            month_diff=(12+(ed-sd))+1;
        }else{
            month_diff=(ed-sd)+1;
        }

        var h_d=$("[name='data[crud_users][holidays_entitlement]']").val();
        var h_d_m=h_d/12;
        avail_h_days=(month_diff*h_d_m);
        avail_h_days=avail_h_days.toFixed();

        $("[name='data[crud_users][Available_Holidays]']").val(avail_h_days);
 });
</script>
<style>
	#loading {
		width: 100%;
		height: 100%;
		top: 0px;
		left: 0px;
		position: fixed;
		display: none;
		opacity: 0.7;
		background-color: #fff;
		z-index: 10052;
		text-align: center;
	}
</style>
<div id="loading">
	<img src="<?php echo base_url(); ?>media/assets/pages/img/index.gif" id="gif">
</div>