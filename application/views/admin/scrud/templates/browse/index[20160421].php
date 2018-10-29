<?php $CI = & get_instance();
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

global $date_format_convert;
$permissions = $auth->getPermissionType();
$comId = $CI->input->get('com_id');
$clsWidth = 50;
foreach ($this->colsCustom as $k => $v) {
    if ($k == 'action') {
        $matches = array();
        preg_match_all('/<a[^>]*>([^<]*)<\/a>/iU', $this->colsCustom['action'], $matches);
        
        if (!in_array(2, $permissions)) {
            unset($matches[0][1]);
        }
        
        if (!in_array(3, $permissions)) {
            unset($matches[0][2]);
        }
        
        $clsWidth = $clsWidth* count($matches[0]);
        $this->colsCustom[$k] = implode(' ', $matches[0]);
    }
}

foreach ($this->colsWidth as $k => $v) {
    if ($k == 'action') {
        $this->colsWidth[$k] =  $clsWidth;
    }
}
//Custom Functions Calls For LIST VIEW START
if(!empty($this->CfunctionsArray)){   
    $Cfunctions = new Cfunctions;
    foreach($this->CfunctionsArray as $function_name){
        $func_name = explode(':',$function_name);
        if($func_name[0]=='list-functions')
            $Cfunctions->$func_name[1]();
    }
}
//Custom Functions Calls For LIST VIEW START

$keyval0 = '';
$keyval1 = '';
$keyval2 = '';
$keyval3 = '';
$keyval4 = '';
$keyval5 = '';
if(isset($_GET['key']['business.id']) && $keyid = $_GET['key']['business.id']){
    $keyval0 = "&key[business.id]=".$keyid;
    $keyval1 = "&key[forms.bid]=".$keyid;
    $keyval2 = "&key[codes.bid]=".$keyid;
    $keyval3 = "&key[compliance.bid]=".$keyid;
    $keyval4 = "&key[services.bid]=".$keyid;
    $keyval5 = "&key[fee.bid]=".$keyid;
}
?>
<?php if (!empty($this->form)) { ?>

                    <!-- BEGIN DASHBOARD STATS 1-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <?php
                                            if($comId==65){
                                            ?>
                                            <div class="pull-left">
                                                   <a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=65" class="btn btn-sm green"><?php echo $CI->lang->line('users');?>
                                                    </a>
                                                     <a href="<?php echo base_url(); ?>admin/user/group" class="btn btn-sm green"><?php echo $CI->lang->line('groups');?>
                                                    </a>
                                                     <a href="<?php echo base_url(); ?>admin/user/permission" class="btn btn-sm green"><?php echo $CI->lang->line('permissions');?>
                                                    </a>
                                            <?php
                                            }else{
                                            ?>
                                            <div class="btn-group " style="min-width: 175px;">
                                            <?php
                                            }

                                            if (in_array(2, $permissions)) {
                                            ?>
                                                <a class="btn btn-sm blue" onclick="massEditModal();">Mass Edit</a>
                                            <?php
                                            }
                                            if (in_array(3, $permissions)) {
                                            ?>
                                                <a class="btn btn-sm yellow" onclick="massDelModal();">Mass Delete</a>
                                            <?php
                                            }
                                            ?>
                                                    <!-- <a class="btn btn-sm yellow" onclick="quickCreateModal();">Quick Create</a>
                                                    <a class="btn btn-sm green" onclick="searchModal();"><i class="fa fa-search"></i> <?php echo $CI->lang->line('search');?></a> -->
                                                    <?php
                                                    $q = $this->queryString;
                                                    if (isset($q['xtype']))
                                                        unset($q['xtype']);
                                                    ?>
                                                    <!-- <a class="btn btn-sm green" href="?<?php echo http_build_query($q, '', '&'); ?>"><i class="fa fa-times"></i></i></a> -->
                                            <!-- </div> -->
                                            <?php
                                                $q = $this->queryString;
                                                $q['src']['p'] = 1;
                                                $q['xtype'] = 'massdelete';
                                                if (isset($q['xid']))
                                                unset($q['xid']);
                                            ?>
                                            <!-- <form id="massdelete" method="post" action="?<?php echo http_build_query($q, '', '&'); ?>">
                                                <input type="hidden" name="selected_ids" id="selected_ids" value="">
                                            </form> -->
 
                                           <!--  <div class="btn-group"> -->
                                                    <button class="btn btn-sm green  dropdown-toggle" data-toggle="dropdown">Tools
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right">
                                                    <?php if (!empty($this->results)) { ?>
                                                        <li>
                                                            <a href="javascript:;" onclick="crudExport();">
                                                                <i class="fa fa-file-excel-o"></i> <?php echo $CI->lang->line('export_csv');?> </a>
                                                        </li>
                                                    <?php } else { ?>
                                                        <li>
                                                            <a href="javascript:;" class=" disabled" onclick="crudExport();">
                                                                <i class="fa fa-file-excel-o"></i> <?php echo $CI->lang->line('export_csv');?> </a>
                                                        </li>
                                                    <?php } ?>
                                                        <li>
                                                            <a href="javascript:;" onclick="crudExportAll();">
                                                                <i class="fa fa-file-excel-o"></i> <?php echo $CI->lang->line('export_csv_all');?> </a>
                                                        </li>
                                                    </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="btn-group pull-right">
                                                <?php
                                                if (in_array(1, $permissions)) {
                                                ?>
                                                <button id="sample_editable_1_new" class="btn btn-sm blue  blue" onclick="newRecord();"> <?php echo $CI->lang->line('add'); ?>
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
<!-- ////////////////////////////////////////////////// -->
                                            <?php
                                            if($comId==41 or $comId==42 or $comId==43 or $comId==44 or $comId==45){
                                            ?>
                                            <ul class="nav nav-tabs">
                                                <li <?php if($comId=='41'){ ?>class="active"<?php } ?>>
                                                    <a href="<?=base_url()?>index.php/admin/scrud/browse?com_id=41"> Sole Trader </a>
                                                </li>
                                                <li <?php if($comId=='42'){ ?>class="active"<?php } ?>>
                                                    <a href="<?=base_url()?>index.php/admin/scrud/browse?com_id=42"> Partnership </a>
                                                </li>
                                                <li <?php if($comId=='43'){ ?>class="active"<?php } ?>>
                                                    <a href="<?=base_url()?>index.php/admin/scrud/browse?com_id=43"> Limited Company </a>
                                                </li>
                                                <li <?php if($comId=='44'){ ?>class="active"<?php } ?>>
                                                    <a href="<?=base_url()?>index.php/admin/scrud/browse?com_id=44"> Limited Liabilities Company </a>
                                                </li>
                                                <li <?php if($comId=='45'){ ?>class="active"<?php } ?>>
                                                    <a href="<?=base_url()?>index.php/admin/scrud/browse?com_id=45"> Charities </a>
                                                </li>
                                            </ul>
                                            <div class="clearfix" style="margin-bottom: 30px;"> </div>
                                            <?php } ?>
<!-- ////////////////////////////////////////////  -->                                   
                                    <?php
                                    $q = $this->queryString;
                                    $q['src']['p'] = 1;
                                    $q['xtype'] = 'index';
                                    if (isset($q['xid']))
                                        unset($q['xid']);
                                    ?>
                                    <form method="post" action="?<?php echo http_build_query($q, '', '&'); ?>" id="table" class="form-horizontal">
                                    <?php //require dirname(__FILE__) . '/search_form.php'; ?>
                                        <input type="hidden" name="src[page]" id="srcPage" value="<?php echo $this->pageIndex; ?>"/>
                                        <input type="hidden" name="src[limit]" id="srcLimit" value="<?php echo $this->limit; ?>"/>
                                        <input type="hidden" name="src[order_field]" id="srcOrder_field" value="<?php echo $this->orderField; ?>"/>
                                        <input type="hidden" name="src[order_type]" id="srcOrder_type" value="<?php echo $this->orderType; ?>"/>
                                        <input type="hidden" name="selected_records_hdn" value="" />
                                        <input type="hidden" name="auth_token" id="auth_token" value="<?php echo $this->getToken(); ?>"/>


                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                            <thead>
                                                <tr id="filterrow">
                                                    <td style="width: 30px !important;"> </td>
                                                    <?php 
                                                        $c = count($fields);
                                                        $cc = 0;
                                                        foreach ($fields as $k => $field) { 
                                                            $cc++;
                                                            if($c==$cc)
                                                                continue;
                                                            ?>
                                                            <?php if (in_array($field, $this->fields)) { ?>
                                                                <th><?php echo htmlspecialchars((isset($this->fieldsAlias[$field])) ? $this->fieldsAlias[$field] : $field); ?></th>
                                                            <?php } else { ?>
                                                                <th><?php echo htmlspecialchars((isset($this->fieldsAlias[$field])) ? $this->fieldsAlias[$field] : $field); ?></th>
                                                            <?php } ?>
                                                        <?php } ?>
                                                </tr>

                                                <tr>
                                                    <th style="width: 30px !important;">
                                                        <input type="checkbox" id="select_all" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                                    </th>
                                                    <?php foreach ($fields as $k => $field) { ?>
                                                        <?php if (in_array($field, $this->fields)) { ?>
                                                            <th style="<?php if (isset($this->colsWidth[$field])) { ?>width:<?php echo $this->colsWidth[$field]; ?>px; 
                                                                <?php } else if (isset($this->colsWidth[$k])) { ?>width:<?php echo $this->colsWidth[$k]; ?>px; <?php } ?>"><?php echo htmlspecialchars((isset($this->fieldsAlias[$field])) ? $this->fieldsAlias[$field] : $field); ?></th>
                                                        <?php } else { ?>
                                                            <th style="min-width: 100px !important; "><?php echo htmlspecialchars((isset($this->fieldsAlias[$field])) ? $this->fieldsAlias[$field] : $field); ?></th>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (!empty($this->results)) {
                                                    $s = array();
                                                    foreach ($this->fields as $field) {
                                                        $s[] = '{' . $field . '}';
                                                    }
                                                    $s[] = '{ppri}';
                                                    $s[] = '{no}';
                                                    $offset = ($this->pageIndex - 1) * $this->limit;
                                                
                                                    $formFields = array();
                                                    foreach ($this->form as $key => $value) {
                                                        foreach ($value['section_fields'] as $key => $value) {
                                                            $formFields[$key] = $value;
                                                        }
                                                    }
                                                   
                                                    foreach ($this->results as $result) {
                                                        $r = array();
                                                       
                                                        foreach ($this->fields as $k => $field) {
                                                        $__value = '';
                                                        $__aryField = explode('.', $field);
                                                        if (count($__aryField) > 1) {
                                                            $__tmp = $result;
                                                            foreach ($__aryField as $key => $value) {
                                                                if (is_array($__tmp[$value])) {
                                                                    $__tmp = $__tmp[$value];
                                                                } else {
                                                                    $__value = $__tmp[$value];
                                                                }
                                                            }
                                                        } else if (count($__aryField) == 1) {
                                                            $__value = $result[$field];
                                                        }

                                                        if (isset($formFields[$field]) && isset($formFields[$field]['element'][0])) {
                                                            switch (trim(strtolower($formFields[$field]['element'][0]))) {
                                                                case 'radio':
                                                                case 'autocomplete':
                                                                case 'select':
                                                                    $e = $formFields[$field]['element'];
                                                                    $options = array();
                                                                    $params = array();
                                                                    if (isset($e[1]) && !empty($e[1])) {
                                                                        if (array_key_exists('option_table', $e[1])) {
                                                                            if (array_key_exists('option_key', $e[1]) &&
                                                                                    array_key_exists('option_value', $e[1])) {
                                                                                $_dao = new ScrudDao($e[1]['option_table'], $CI->db);
                                                                                

                                                                                if ($e[1]['option_table'] == 'crud_users') {
                                                                                    $params['fields'] = array($e[1]['option_key'], 'user_first_name', 'user_las_name');
                                                                                } elseif ($e[1]['option_table'] == 'contact') {
                                                                                    $params['fields'] = array($e[1]['option_key'], 'First_Name', 'Last_Name');
                                                                                } else {
                                                                                    $params['fields'] = array($e[1]['option_key'], $e[1]['option_value']);
                                                                                }
                                                                                //CUSTOM CONDITIONS STARTS HERE
                                                                               if(isset($e[1]['option_condition']) && isset($e[1]['option_column']) && isset($e[1]['option_action'])){
                                                                                $condition = $e[1]['option_condition'];
                                                                                $column = $e[1]['option_column'];
                                                                                $action = $e[1]['option_action'];
                                                                                if($condition!=0 && $condition!=''){
                                                                                 $cond_final = $column . $action . $condition;
                                                                                 $params['condition']=$cond_final;
                                                                                }
                                                                               } 
                                                                               //CUSTOM CONDITIONS ENDS HERE
                                                                                $rs = $_dao->find($params);


                                                                                if (!empty($rs)) {
                                                                                    foreach ($rs as $v) {
                                                                                        if ($e[1]['option_table'] == 'crud_users') {
                                                                                            $options[$v[$e[1]['option_key']]] = ucwords($v['user_first_name']) . ' ' . ucwords($v['user_las_name']);
                                                                                        } elseif ($e[1]['option_table'] == 'contact') {
                                                                                            $options[$v[$e[1]['option_key']]] = ucwords($v['First_Name']) . ' ' . ucwords($v['Last_Name']);
                                                                                        } else {
                                                                                            $options[$v[$e[1]['option_key']]] = $v[$e[1]['option_value']];
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        } else {
                                                                            $options = $e[1];
                                                                        }
                                                                    }
                                                                    $formFields[$field]['element'][1] = $options;
                                                                    if (isset($formFields[$field]['element'][1]) &&
                                                                            !empty($formFields[$field]['element'][1]) &&
                                                                            is_array($formFields[$field]['element'][1]) &&
                                                                            !empty($formFields[$field]['element'][1][$__value])
                                                                    ) {
                                                                        $r[] = htmlspecialchars($formFields[$field]['element'][1][$__value]);
                                                                    } else {
                                                                        $r[] = '';
                                                                    }
                                                                    break;
                                                                case 'editor':
                                                                    $r[] = $__value;
                                                                    break;
                                                                case 'checkbox':
                                                                    $value = explode(',', $__value);
                                                                    if (!empty($value) && is_array($value) && count($value) > 0) {
                                                                        $tmp = array();
                                                                        foreach ($value as $k1 => $v1) {
                                                                            if (isset($formFields[$field]['element'][1][$v1])) {
                                                                                $tmp[] = $formFields[$field]['element'][1][$v1];
                                                                            }
                                                                        }
                                                                        $value = implode(', ', $tmp);
                                                                    } else {
                                                                        $value = '';
                                                                    }

                                                                    $r[] = htmlspecialchars($value);
                                                                    break;

                                                                case 'textarea':
                                                                    $r[] = nl2br(htmlspecialchars($__value));
                                                                    break;
                                                                default:
                                                                    $r[] = htmlspecialchars($__value);
                                                                    break;
                                                            }
                                                        } else {
                                                            $r[] = htmlspecialchars($__value);
                                                        }
                                                    }
                                                    $offset++;
                                                    $ppri = "";
                                                    $_tmp = "";
                                                    foreach ($this->primaryKey as $f) {
                                                        $__value = '';
                                                        $__aryField = explode('.', $f);
                                                        if (count($__aryField) > 1) {
                                                            $__tmp = $result;
                                                            foreach ($__aryField as $key => $value) {
                                                                if (is_array($__tmp[$value])) {
                                                                    $__tmp = $__tmp[$value];
                                                                } else {
                                                                    $__value = $__tmp[$value];
                                                                }
                                                            }
                                                        } else if (count($__aryField) == 1) {
                                                            $__value = $result[$f];
                                                        }
                                                        $ppri .= $_tmp . 'key[' . $f . ']=' . htmlspecialchars($__value);
                                                        $_tmp = '&';
                                                    }
                                                    $r[] = $ppri;
                                                    $r[] = $offset;
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td>
                                                        <input type="checkbox" class="checkboxes" name="selected_records" value="<?php echo $__value; ?>" /> </td>
                                                        <?php foreach ($fields as $field) { ?>
                                                        <td>
                                                            <?php if (isset($this->colsCustom[$field])) { ?>
                                                                <?php echo str_replace($s, $r, $this->colsCustom[$field]); ?>
                                                            <?php } else { ?>
                                                                <?php
                                                                $__value = '';
                                                                $__aryField = explode('.', $field);
                                                                /*print_r($__aryField);
                                                                exit;*/
                                                                if (count($__aryField) > 1) {
                                                                    $__tmp = $result;
                                                                    foreach ($__aryField as $key => $value) {
                                                                        if (is_array($__tmp[$value])) {
                                                                            $__tmp = $__tmp[$value];
                                                                        } else {
                                                                            if($value=='legal_entity'){
                                                                                switch($__tmp[$value]){
                                                                                    case '1':
                                                                                        $__value='Sole Trader';
                                                                                        break;
                                                                                    case '2':
                                                                                        $__value='Partnership';
                                                                                        break;
                                                                                    case '3':
                                                                                        $__value='Limited Company';
                                                                                        break;
                                                                                    case '4':
                                                                                        $__value='Limited Liabilities';
                                                                                        break;
                                                                                    case '5':
                                                                                        $__value='Charities';
                                                                                        break;
                                                                                }
                                                                            }else
                                                                                $__value = $__tmp[$value];
                                                                        }
                                                                    }
                                                                } else if (count($__aryField) == 1) {
                                                                    $__value = $result[$field];
                                                                }
                                                                if (isset($formFields[$field]) && isset($formFields[$field]['element'][0])) {
                                                                    switch (trim(strtolower($formFields[$field]['element'][0]))) {
                                                                        case 'radio':
                                                                        case 'autocomplete':
                                                                        case 'select':

                                                                            $e = $formFields[$field]['element'];
                                                                            $options = array();
                                                                            $params = array();
                                                                            if (isset($e[1]) && !empty($e[1])) {
                                                                                if (array_key_exists('option_table', $e[1])) {
                                                                                    if (array_key_exists('option_key', $e[1]) &&
                                                                                            array_key_exists('option_value', $e[1])) {
                                                                                        $_dao = new ScrudDao($e[1]['option_table'], $CI->db);

                                                                                    if ($e[1]['option_table'] == 'crud_users') {
                                                                                        $params['fields'] = array($e[1]['option_key'], 'user_first_name', 'user_las_name');
                                                                                    } else {
                                                                                         $params['fields'] = array($e[1]['option_key'], $e[1]['option_value']);
                                                                                    }

                                                                                       
                                                                                        $rs = $_dao->find($params);
                                                                                        if (!empty($rs)) {
                                                                                            $rs = $rs[$e[1]['option_table']];
                                                                                            foreach ($rs as $v) {

                                                                                                if ($e[1]['option_table'] == 'crud_users') {
                                                                                                    $options[$v[$e[1]['option_key']]] = ucwords($v['user_first_name']) . ' ' . ucwords($v['user_las_name']);
                                                                                                } else {
                                                                                                    $options[$v[$e[1]['option_key']]] = $v[$e[1]['option_value']];
                                                                                                }

                                                                                                
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                } else {
                                                                                    $options = $e[1];
                                                                                }
                                                                            }
                                                                            $formFields[$field]['element'][1] = $options;

                                                                            if (array_key_exists(2, $formFields[$field]['element']) and array_key_exists('multiple', $formFields[$field]['element'][2])) {
                                                                                $mkvarr = explode(',', $__value);
                                                                                $values_as_string = array();
                                                                               foreach ($mkvarr as $key => $value) {
                                                                                    if (!empty($value) && $value != '') {
                                                                                        $values_as_string[] = nl2br(htmlspecialchars($formFields[$field]['element'][1][$value]));
                                                                                    }
                                                                                  
                                                                               }
                                                                               echo implode(',', $values_as_string);

                                                                            }else if (isset($formFields[$field]['element'][1]) &&
                                                                                    !empty($formFields[$field]['element'][1]) &&
                                                                                    is_array($formFields[$field]['element'][1]) &&
                                                                                    !empty($formFields[$field]['element'][1][$__value])) {
                                                                                echo nl2br(htmlspecialchars($formFields[$field]['element'][1][$__value]));
                                                                            }
                                                                            break;
                                                                        case 'editor':
                                                                            echo $__value;
                                                                            break;
                                                                        case 'checkbox':
                                                                            $value = explode(',', $__value);
                                                                            if (!empty($value) && is_array($value) && count($value) > 0) {
                                                                                $tmp = array();
                                                                                foreach ($value as $k1 => $v1) {
                                                                                    if (isset($formFields[$field]['element'][1][$v1])) {
                                                                                        $tmp[] = $formFields[$field]['element'][1][$v1];
                                                                                    }
                                                                                }
                                                                                $value = implode(', ', $tmp);
                                                                            } else {
                                                                                $value = '';
                                                                            }
                                                                            echo htmlspecialchars($value);
                                                                            break;
                                                                        case 'currency':
                                                                            $_curt = new ScrudDao('currencies', $this->da);
                                                                            $cpt = array();
                                                                            $cpt['conditions'] = array('currency_status="3"');
                                                                            $cpt_res = $_curt->find($cpt);

                                                                            echo nl2br(htmlspecialchars($cpt_res[0]['currency_symbol'].' '.$__value));
                                                                            break;
                                                                        case 'textarea':
                                                                            echo nl2br(htmlspecialchars($__value));
                                                                            break;
                                                                        case 'file':
                                                                        if (file_exists(FCPATH . '/media/files/' . $__value)) {
                                                                            echo '<a href="' . base_url() . 'index.php/admin/download?file=' . $__value . '">' . $__value . '</a>';
                                                                        } else {
                                                                            echo $__value;
                                                                        }
                                                                        break;
                                                                        case 'image':
                                                                            if (file_exists(__IMAGE_UPLOAD_REAL_PATH__ . '/thumbnail_' . $__value)) {
                                                                                echo "<img src='" . __MEDIA_PATH__ . "images/thumbnail_" . $__value . "' />";
                                                                            } else if (__IMAGE_UPLOAD_REAL_PATH__ . '/mini_thumbnail_' . $__value) {
                                                                                echo "<img src='" . __MEDIA_PATH__ . "images/mini_thumbnail_" . $__value . "' />";
                                                                            } else {
                                                                                echo '';
                                                                            }
                                                                            break;
                                                                        case 'date':
                                                                            if (is_date($__value)){
                                                                                echo date($date_format_convert[__DATE_FORMAT__],strtotime($__value));
                                                                            }else{
                                                                                    echo '';
                                                                                }
                                                                                break;
                                                                        case 'datetime':
                                                                            if (is_date($__value)){
                                                                                echo date($date_format_convert[__DATE_FORMAT__].' H:i:s',strtotime($__value));
                                                                            }else{
                                                                                    echo '';
                                                                                }
                                                                                break;
                                                                        default:
                                                                            echo nl2br(htmlspecialchars($__value));
                                                                            break;
                                                                    }
                                                                } else {
                                                                    echo nl2br(htmlspecialchars($__value));
                                                                }
                                                                ?>
                                                            <?php } ?>
                                                        </td>
                                                    <?php } ?>
                                                    </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                        <!-- <tfoot>
                                            <tr>
                                                <th style="width: 30px !important;">
                                                    <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /> </th>
                                                <?php foreach ($fields as $k => $field) { ?>
                                                    <?php if (in_array($field, $this->fields)) { ?>
                                                        <th style="<?php if (isset($this->colsWidth[$field])) { ?>width:<?php echo $this->colsWidth[$field]; ?>px; 
                                                            <?php } else if (isset($this->colsWidth[$k])) { ?>width:<?php echo $this->colsWidth[$k]; ?>px; <?php } ?>"><?php echo htmlspecialchars((isset($this->fieldsAlias[$field])) ? $this->fieldsAlias[$field] : $field); ?></th>
                                                    <?php } else { ?>
                                                        <th style="width: 210px !important;"><?php echo htmlspecialchars((isset($this->fieldsAlias[$field])) ? $this->fieldsAlias[$field] : $field); ?></th>
                                                    <?php } ?>
                                                <?php } ?>
                                                
                                            </tr>
                                        </tfoot> -->
                                    </table>
                                    </form>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                    <!-- END OF ROW -->
                    <div class="clearfix"></div>
                    <!-- END DASHBOARD STATS 1-->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            
        </div>
        <!-- END CONTAINER -->
<?php } ?>
    <script>
        //New Script START
        function massDelFormContent(){
            var content = $("#table").clone();
            content.find('.dataTables_wrapper').remove();
            <?php
                $q = $this->queryString;
                $q['src']['p'] = 1;
                $q['xtype'] = 'massdelete';
                if (isset($q['xid']))
                unset($q['xid']);
            ?>
            var actionUrl = '?<?php echo http_build_query($q, '', '&'); ?>';
            $(content).css('visibility','visible');
            $(content).attr('id','massdelete');
            $(content).attr('action',actionUrl);            
            $(content).append('<p>Are you sure want to delete selected records?</p>');
            return content ;
        }
        
        function massDelModal(){
            var recordIds = [];
            $('input[name="selected_records"]').each(function(){
                if ($(this).is(':checked')) {
                    recordIds.push($(this).val());
                }  
            });
            var selected_ids = recordIds.join();
            if (selected_ids == '') {
                bootbox.alert("Please select at least one record.", function() {
                  
                });
            } else {
                $('input[name="selected_records_hdn"]').val(selected_ids);
                bootbox.dialog({
                    message: massDelFormContent(),
                    title: "Delete!",
                    buttons: {
                        cancel: {
                            label: 'Cancel',
                            className: 'btn-warning'
                        },
                        update: {
                            label: 'Yes ',
                            className: 'btn-success',
                            callback: function (data) {
                                $('#massdelete').submit();
                                return false;
                            }
                        }
                    }
                }); 
                
            }
        }
        
        function massEdithFormContent(){
            var content = $("#table").clone();
            content.find('.dataTables_wrapper').remove();
            <?php
                $q = $this->queryString;
                $q['xtype'] = 'massedit';
                if (isset($q['key']))
                unset($q['key']);
            ?>  
            $.ajax({
                type: 'GET',
                url: '?<?php echo http_build_query($q, '', '&'); ?>',
                success: function(data) {   
                    <?php
                        $q = $this->queryString;
                        $q['src']['p'] = 1;
                        $q['xtype'] = 'massupdate';
                        if (isset($q['xid']))
                        unset($q['xid']);
                    ?>
                    var actionUrl = '?<?php echo http_build_query($q, '', '&'); ?>';

                    $(content).css('visibility','visible');
                    $(content).attr('id','massedit');
                    $(content).attr('action',actionUrl);
                    $(content).append(data);
                }
            });
            return content ;
        }
        
        function massEditModal() {
            var recordIds = [];
            $('input[name="selected_records"]').each(function(){
                if ($(this).is(':checked')) {
                    recordIds.push($(this).val());
                }  
            });
            var selected_ids = recordIds.join();
            if (selected_ids == '') {
                bootbox.alert("Please select at least one record.", function() {
                  
                });
            } else {
                $('input[name="selected_records_hdn"]').val(selected_ids);

                bootbox.dialog({
                    message: massEdithFormContent(),
                    title: "Update!",
                    buttons: {
                        cancel: {
                            label: 'Cancel',
                            className: 'btn-warning'
                        },
                        update: {
                            label: 'Update ',
                            className: 'btn-success',
                            callback: function (data) {
                                $('#massedit').submit();
                                return false;
                            }
                        }
                    }
                });
            }
        }
        
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
                console.log(recordValue);
                $('#'+data.hidden_controll).val(recordId);
                $('#'+data.visible_controll).val(recordValue);  
            }
            $('.'+modalClass).modal('hide');
        }
        
        function summaryView(jData){
            summaryViewModal(jData);
        }
        
        function summaryViewContent(jData){
            var content = $("#table").clone(true);
            content.find('.dataTables_wrapper').html('');
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
                    $(content).attr('action',actionUrl);
                    $(content).append('<div class="form-body"></div>');
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
                        "infoFiltered": "(filtered1 from _MAX_ total records)",
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
            var modalClass = 'modal_' + jData.module_id;
            bootbox.dialog({
                message: summaryViewContent(jData),
                title: "Select Record",
                className:modalClass,
                size:"large",
                buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    quickcreate: {
                        label: 'Select',
                        className: 'btn-success',
                        callback: function (data) {
                            
                            return false;
                        }
                    }
                }
            });
        }
        
        function quickCreateFormContent(){
            var content = $("#table").clone(true);
            content.find('.dataTables_wrapper').remove();
            <?php
                $q = $this->queryString;
                $q['xtype'] = 'quickcreate';
                if (isset($q['key']))
                unset($q['key']);
            ?>  //quickcreateform
            $.ajax({
                type: 'GET',
                url: '?<?php echo http_build_query($q, '', '&'); ?>',
                success: function(data) {   
                    <?php
                        $q = $this->queryString;
                        $q['src']['p'] = 1;
                        $q['xtype'] = 'quickcreateform';
                        if (isset($q['xid']))
                        unset($q['xid']);
                    ?>
                    var actionUrl = '?<?php echo http_build_query($q, '', '&'); ?>';                             
                    $(content).css('visibility','visible');
                    $(content).attr('id','quickcreate');
                    $(content).attr('action',actionUrl);
                    $(content).append(data);
                }
            });
            return content ;
        }
        
        function quickCreateModal() {
            bootbox.dialog({
                message: quickCreateFormContent(),
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
                            $('#quickcreate').submit();
                            return false;
                        }
                    }
                }
            });
        }
        //NEW SCRIPT END

        function delRecordsl(){  
            var recordIds = [];
            $('input[name="selected_record"]:checked').each(function(){
                recordIds.push($(this).val());  
            });
            if (recordIds.length ===0 ) {
                var strAlertSuccess = '<div class="alert alert-danger" style="position: fixed; left:40%;  top:50%; width:300px; height:60px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;">' +
                '<button data-dismiss="alert" class="close" type="button">×</button>' +
                'Please select at least one record.' +
                '</div>';
                var alertSuccess = $(strAlertSuccess).appendTo('body');
                alertSuccess.show();

                 setTimeout(function(){ 
                    alertSuccess.remove();
                },5000);
            } else {
                var prompt = confirm("Are you sure to delete selected records?");
                if (prompt) {
                    var selected_ids = recordIds.join();
                    $('#selected_ids').val(selected_ids);
                    
                    document.getElementById('massdelete').submit();
                }
            } 
        }

        function newRecord() {
            <?php
            $q = $this->queryString;
            $q['xtype'] = 'form';
            if (isset($q['key']))
                unset($q['key']);
            ?>
            window.location = "?<?php echo http_build_query($q, '', '&'); ?>";
        }

        function __view(id) {
            <?php
            $q = $this->queryString;
            $q['xtype'] = 'view';
            if (isset($q['key']))
                unset($q['key']);
            ?>
            window.location = "?<?php echo http_build_query($q, '', '&'); ?>&" + id;
        }

        function __edit(id) {
            <?php
            $q = $this->queryString;
            $q['xtype'] = 'form';
            if (isset($q['key']))
                unset($q['key']);
            ?>
            window.location = "?<?php echo http_build_query($q, '', '&'); ?>&" + id;
        }

        function __delete(id) {
            <?php
            $q = $this->queryString;
            $q['xtype'] = 'delconfirm';
            if (isset($q['key']))
                unset($q['key']);
            ?>
            window.location = "?<?php echo http_build_query($q, '', '&'); ?>&" + id;
        }

        function order(field) {
            var oldField = document.getElementById('srcOrder_field').value;
            var oldType = document.getElementById('srcOrder_type').value;
            <?php
            $q = $this->queryString;
            $q['xtype'] = 'index';
            if (isset($q['key']))
                unset($q['key']);
            ?>
            var url = "?<?php echo http_build_query($q, '', '&'); ?>";
            url += "&src[o]=" + field;
            if (field == oldField) {
                if (oldType == 'asc') {
                    url += "&src[t]=desc"
                } else {
                    url += "&src[t]=asc"
                }
            } else {
                url += "&src[t]=asc"
            }
            window.location = url;
        }
        $(document).ready(function() {
            $('title').html('<?php echo $this->title; ?>');
        });
    </script>
    <iframe src="" id="crudIframe" height="0" width="0" style="width: 0px; line-height:0px; height: 0px; border: 0px; padding: 0px; margin: 0px; display:none;"></iframe>
    <script>
    function crudSearch() {
        document.getElementById('srcPage').value = 1;
        document.getElementById('search').submit();
    }
    function crudExport(){
        $('#crudIframe').attr({src:'<?php echo base_url(); ?>index.php/admin/scrud/exportcsv?com_id=<?php echo $comId; ?>&xtype=exportcsv'});
    }
    function crudExportAll() {
        $('#crudIframe').attr({src: '<?php echo base_url(); ?>index.php/admin/scrud/exportcsv?com_id=<?php echo $comId; ?>&xtype=exportcsvall'});
    }
    </script>
    <style type="text/css">
        .modal-dialog{
            width:600px;
        }
    </style>