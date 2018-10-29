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
// //Custom Functions Calls For LIST VIEW START
// if(!empty($this->CfunctionsArray)){   
//     $Cfunctions = new Cfunctions;
//     foreach($this->CfunctionsArray as $function_name){
//         $func_name = explode(':',$function_name);
//         if($func_name[0]=='list-functions')
//             $Cfunctions->$func_name[1]();
//     }
// }
// //Custom Functions Calls For LIST VIEW START

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
                                        <div class="col-md-11">
                                            <div class="pull-left">
                                            <?php
                                            if($comId==65){
                                            ?>
                                                <a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=65" class="btn btn-sm green"><?php echo $CI->lang->line('users');?>
                                                </a>
                                                <a href="<?php echo base_url(); ?>admin/user/group" class="btn btn-sm green"><?php echo $CI->lang->line('groups');?>
                                                </a>
                                                <a href="<?php echo base_url(); ?>admin/user/permission" class="btn btn-sm green"><?php echo $CI->lang->line('permissions');?>
                                                </a>
                                            <?php
                                            }
                                            if($comId==41 || $comId==42 || $comId==43 || $comId==44 || $comid==45|| $comId==28){
                                            ?>
                                            <a class="btn btn-sm default" onclick="mass__mail();">Mass Email</a>
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
 
                                                <div class="btn-group">
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
                                                    <?php if ($comId==80 or $comId==25) { ?>
                                                        <li>
                                                        <?php
                                                        $q = $this->queryString;
                                                        if (isset($q['key']))
                                                            unset($q['key']);
                                                        if (isset($q['show']))
                                                            unset($q['show']);
                                                        ?>
                                                            <a href="?<?php echo http_build_query($q, '', '&'); ?>" >
                                                                <i class="fa fa-calendar"></i> <?php echo 'Calendar View';?> </a>
                                                        </li>
                                                    <?php } ?>
                                                    </ul>
                                                </div>
                                                
                                            </div>
                                            <!--filters Starts Here-->
                                            <div class="btn-group col-md-<?php if($comId==65){ ?>4<?php }else{ ?>6<?php } ?>">
                                                <div class="col-md-2">
                                                    <label class="control-label col-md-2" style="text-align:right; margin-top:4px;">Filter</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="form-control select2" data-placeholder="Select..." name="filters" id="filters">
                                                    <option> </option>
                                                        <?php //Nauman Code for Default Filters

                                                            $CI->db->select("id");
                                                            $CI->db->from('filters');
                                                            $CI->db->join('filters_crud_users',"filters_crud_users.filter_id=filters.id");
                                                            $CI->db->where('filters_crud_users.crud_user',$CRUD_AUTH['id']);
                                                            $qquery=$CI->db->get();
                                                            if($qquery->num_rows()>0){
                                                                $result_filter=$qquery->result_array();
                                                                $default_filter=$result_filter[0]['id'];
                                                                if(isset($default_filter)&& $default_filter!=0){
                                                                    echo '<option value="'.$default_filter.'">Default</option>';
                                                                    
                                                                }
                                                            }

                                                            ?>
                                                        <?php $f = isset($_GET['f']) ? $_GET['f'] : '';
                                                        foreach ($this->module_filters as $mfk => $mfv) {
                                                        ?>
                                                        <option value="<?php echo $mfv['id'] ?>" <?php if($f == $mfv['id']){ ?> selected <?php } ?> ><?php echo $mfv['name'] ; ?></option>
                                                        <?php } ?>
                                                        <option value="new">Create New</option>
                                                    </select>
                                                </div>
                                                    <!-- Search Code starts -->
                                                <?php 
                                                for($ii=0;$ii<(count($fields)-1);$ii++)
                                                {
                                                    $all_fields[]=$fields[$ii];
                                                }
                                                ?>


                                                    <div class="input-group">
                                                        <input type="text" class="form-control blue" placeholder="Search..."  name="fltr"><input type="hidden" class="form-control input-sm" name="flds" value="<?=implode(',',array_values($all_fields))?>" />
                                                        <span class="input-group-btn" onclick="searchForAllFields()">
                                                            <a href="javascript:;" class="btn  btn-info">
                                                                <i class="icon-magnifier"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                    <!-- Search Code ends -->
                                                    <?php if(isset($_GET['f']) && $_GET['f'] != 0 && (isset($this->right_access))&& $this->right_access==1){?>
                                                    <a class="btn btn-icon-only blue" href="<?php echo base_url(); ?>index.php/admin/filters?comid=<?php echo $comId; ?>&f=<?php echo $_GET['f'] ?>"><i class="fa fa-pencil"></i></a>
                                                    <a class="btn btn-icon-only red" href="<?php echo base_url(); ?>index.php/admin/filters/delete?comid=<?php echo $comId; ?>&f=<?php echo $_GET['f'] ?>"><i class="fa fa-trash"></i></a>
                                                    <?php } ?>
                                           </div>
                                            <!--filters Ends Here-->

                                        </div>
                                        <div class="col-md-1">
                                            <div class="btn-group pull-right">
                                                <?php
                                                if (in_array(1, $permissions)) {
                                                    if ($comId == '31') {
                                                ?>
                                                <a type="button " class="btn green" href="<?php echo base_url(); ?>index.php/admin/reports/create_report" style="    background-color: #89C4F4;"> <i class="fa fa-plus"></i></i> <?php echo $CI->lang->line('add'); ?></a>
                                                <?php
                                                    }else{
                                                ?>
                                                <button id="sample_editable_1_new" class="btn btn-sm blue  blue" onclick="newRecord();"> <?php echo $CI->lang->line('add'); ?>
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <?php
                                                    }
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
                                    $q['xtype'] = 'index';
                                    $q['src']['p'] = 1;
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
                                        <input type="hidden" name="comid" id="comid" value="<?php echo $comId; ?>">
<?php //echo "<pre>";print_r($this->conf[form_elements]);exit;?>
<?php $a_dataType=array();?>
<?php foreach($this->conf['form_elements'] as $value)
    {
        foreach($value['section_fields'] as $ke => $va){
            if(in_array($ke ,$fields)){
                $a_dataType[$ke]=$va['element'][0];
                $data_values[$ke]=$va['element'][1];
            }

        }
    }
?>

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
                                                                <th>
                                                                    <?php if($a_dataType[$field]=='select'&& !array_key_exists('option_table',$data_values[$field])):?>
                                                                    <select class="form-control input-sm select2" name="flt[]" >
                                                                    <option value="" seleted></option>
                                                                    <?php foreach($data_values[$field] as $m=> $o){
                                                                        echo "<option value='".$m."'>". $o. "</option>";
                                                                    }

                                                                    ?>
                                                                    </select>
                                                                    <?php elseif(($a_dataType[$field]=='select' || $a_dataType[$field]=='autocomplete' ) && array_key_exists('option_table',$data_values[$field])):?>
<?php 
$flg1=0;$flg2=0;
$str='';
$str.="SELECT ". $data_values[$field]['option_key'] . "  ";
if($data_values[$field]['option_table']=='crud_users'){
    $str.=", user_first_name, user_las_name " ;
}elseif($data_values[$field]['option_table']=='contact'){
    $str.=", "."First_Name". " , "."Last_Name"." ";
}else
    $str.=", ".$data_values[$field]['option_value']." ";

$str.="FROM ".$data_values[$field]['option_table']. " "; 
if((isset($data_values[$field]['option_customtext'])&&$data_values[$field]['option_customtext']!='')||(isset($data_values[$field]['option_condition'])&&$data_values[$field]['option_condition']!=''))
{   
    $str.= "WHERE ";

    if(isset($data_values[$field]['option_customtext']) && $data_values[$field]['option_customtext']!=''){
        $str.= $data_values[$field]['option_customtext'] . " ";
        
        $flg1=1;
    }
    if(isset($data_values[$field]['option_condition']) && $data_values[$field]['option_condition']!=''){
        if($flg1==1){
        $str.= " AND ";
        }
        $str.= $data_values[$field]['option_column'] . " = '". $CRUD_AUTH['site_id'] . "' " ;

    }

}
//echo $str;//exit;
?>
                                                                    <select class="form-control select2" name="flt[]" >
                                                                        <option value="" seleted></option>
                                                                    <?php 
                                                                        //echo($str);
                                                                        $query=$CI->db->query($str);

                                                                        $results=$query->result_array();
                                                                        //echo $query->num_rows();
                                                                            // echo "<pre>";
                                                                             // echo($str);
                                                                         /////nauman start/////
                                                                             foreach($results as $result){
                                                                                 echo "<option value='".$result[$data_values[$field]['option_key']]."'>";
                                                                                 if($data_values[$field]['option_table']=='crud_users'){
                                                                                    echo $result['user_first_name']." ".
                                                                                 $result['user_las_name'];
                                                                                 }else if($data_values[$field]['option_table']=='contact'){
                                                                                    echo $result['First_Name']." ".
                                                                                    $result['Last_Name'];
                                                                                 }else{
                                                                                    echo $result[$data_values[$field]['option_value']];
                                                                                    }
                                                                                 echo "</option>";
                                                                             }
                                                                             ///nauman ends////
                                                                        //exit;
                                                                    ?>
                                                                    
                                                                       
                                                                    <?php elseif ($a_dataType[$field]=='radio'):?>
                                                                    <select class="form-control input-sm select2" name="flt[]" >
                                                                    <option value="" seleted></option>
                                                                    <?php foreach($data_values[$field] as $m=> $o){
                                                                        echo "<option value='".$m."'>". $o. "</option>";
                                                                    }
                                                                    ?>
                                                                    </select>
                                                                    <?php elseif ($a_dataType[$field]=='checkbox'):?>
                                                                    <select class="form-control input-sm select2" name="flt[]" >
                                                                    <option value="" seleted></option>
                                                                    <?php foreach($data_values[$field] as $m=> $o){
                                                                        echo "<option value='".$m."'>". $o. "</option>";
                                                                    }
                                                                    ?>
                                                                    </select>
                                                                     <?php elseif($a_dataType[$field]=='autocomplete'&& !array_key_exists('option_table',$data_values[$field])):?>
                                                                    <select class="form-control input-sm select2" name="flt[]" >
                                                                    <option value="" seleted></option>
                                                                    <?php foreach($data_values[$field] as $m=> $o){
                                                                        echo "<option value='".$m."'>". $o. "</option>";
                                                                    }

                                                                    ?>
                                                                    </select>
                                                                    <?php else:?>
                                                                    <?php if($comId==78 and $field=='holiday_request.Status'){ ?>
                                                                        <select class="form-control input-sm select2 select2-hidden-accessible" name="flt[]" tabindex="-1" aria-hidden="true">
                                                                    <option value="" seleted=""></option>
                                                                    <option value="2">Approved</option><option value="1">Rejected</option><option value="0">Pending</option>                                                                    </select>
                                                                    <?php }else{?>
                                                                        <input type="text" class="form-control input-sm <?php echo ($a_dataType[$field]=='date'||$a_dataType[$field]=='date_simple')? 'daterange':'';?>" name="flt[]" />
                                                                    <?php } ?>
                                                                    <?php endif;?>

                                                                    <input type="hidden" class="form-control input-sm" name="fld[]" value="<?=$field?>|<?=$a_dataType[$field]?>" />
                                                                </th>
                                                            
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <td style="width: 30px !important;"> <div id="filter_search" class="btn btn-sm green" onclick="filterSearch();"> <?php echo "Search"; ?>
                                                    <i class="icon-magnifier"></i>
                                                </div></td>
                                                </tr>

                                                <tr>
                                                    <th style="width: 30px !important;">
                                                        <input type="checkbox" id="select_all" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                                    </th>
                                                    <?php foreach ($fields as $k => $field) { ?>
                                                    <?php $exfield = explode('.',$field);?>
                                                        <?php if (in_array($field, $this->fields)) { ?>
                                                            <th onclick="order('<?php echo ($field) ?>');" style="<?php if (isset($this->colsWidth[$field])) { ?>width:<?php echo $this->colsWidth[$field]; ?>px; 
                                                                <?php } else if (isset($this->colsWidth[$k])) { ?>width:<?php echo $this->colsWidth[$k]; ?>px; <?php } ?> background: url(<?=site_url()?>media/assets/global/plugins/datatables/images/sort_both.png) center right no-repeat; cursor:pointer;" ><?php echo htmlspecialchars((isset($this->fieldsAlias[$field])) ? $this->fieldsAlias[$field] : ucwords(str_replace("_"," ",$exfield[1]))); ?></th>
                                                        <?php } else { ?>
                                                            <th onclick="order('<?php echo ($field) ?>');" style="min-width: 160px !important; "><?php echo htmlspecialchars((isset($this->fieldsAlias[$field])) ? $this->fieldsAlias[$field] : ucwords(str_replace("_"," ",$exfield[1]))); ?></th>
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
                                                        <?php $b_id=$__value; ?>
                                                        <?php $count1=0?>
                                                        <?php foreach ($fields as $field) { ?>
                                                        <td>
                                                            <?php if (isset($this->colsCustom[$field])) { ?>
                                                                <?php echo str_replace($s, $r, $this->colsCustom[$field]); ?>
                                                            <?php } else { ?>
                                                                <?php
                                                                $__value = '';
                                                                $__aryField = explode('.', $field);
                                                                /*print_r($result);
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
                                                                            }elseif($value=='Status' and $comId==78){
                                                                                switch($__tmp[$value]){
                                                                                    case '0':
                                                                                        $__value='Pending';
                                                                                        break;
                                                                                    case '1':
                                                                                        $__value='Rejected';
                                                                                        break;
                                                                                    case '2':
                                                                                        $__value='Approved';
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
                                                                            } else if (file_exists(__IMAGE_UPLOAD_REAL_PATH__ . '/mini_thumbnail_' . $__value)) {
                                                                                echo "<img src='" . __MEDIA_PATH__ . "images/mini_thumbnail_" . $__value . "' />";
                                                                            } else {
                                                                                echo 'No Image';
                                                                            }
                                                                            break;
                                                                        case 'date_simple':
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
                                                                            /* old Code

                                                                            echo nl2br(htmlspecialchars($__value));

                                                                            */

                                                                            //Start code for business summary
                                                                            if (($comId==41 or $comId==42 or $comId==43 or $comId==44 or $comId==45) and $field == 'business.title'){

                                                                                $__value = '<a href="javascript:void();" onclick="BusinessSummaryModal('.$b_id.');">' .  $__value . '</a>';

                                                                                echo $__value;
                                                                            }
                                                                            else
                                                                            {
                                                                                echo nl2br(htmlspecialchars($__value));
                                                                            }

                                                                            //End code for business summary
                                                                            break;
                                                                    }
                                                                } else {
                                                                    //code added by nauman 
                                                                    //for calender color
                                                                    if(substr($__value,0,1)=='#'){ 
                                                                        echo "<div style='width:30px; height:30px; margin-left: 5px; border-radius: 12px; background-color:".$__value."; ' ></div>";
                                                                        //nauman code ended here.
                                                                    }else{echo nl2br(htmlspecialchars($__value));
                                                                    }
                                                                }
                                                                ?>
                                                            <?php } ?>
                                                            <?php $count1++;
                                                            if($count1==count($fields)){
                                                                if(($comId==41 or $comId==42 or $comId==43 or $comId==44 or $comId==45 or $comId==28 )){

                                                                     if($comId==41 or $comId==42 or $comId==43 or $comId==44 or $comId==45 ){
                                                                        $table_name='business';
                                                                        $table_columns="user_email";
                                                                    }else if($comId==28){
                                                                        $table_name='contact';
                                                                        $table_columns="Primary_Email";
                                                                    }
                                                                    $CI->db->select($table_columns);
                                                                    $CI->db->from($table_name);
                                                                    $CI->db->where('id',$b_id);
                                                                    $qu=$CI->db->get();
                                                                    $re=$qu->row_array();

                                                                echo '<a href="javascript:;" onclick="__mail(\''.$b_id.'\',\''.$re[$table_columns].'\'); return false;" class="btn btn-icon-only default fa fa-envelope"></a>';
                                                                }
                                                                if($comId==31)
                                                                    echo '<a href="'.base_url().'admin/reports/expdf?id='.$b_id.'" class="btn btn-icon-only default fa fa-download"></a>';
                                                            }?>
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
                                            <div class="row">
                                                  <?php require dirname(__FILE__) . '/paginate.php'; ?>
                                            </div>
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
            content.find('.table').remove();
            content.find('.row').remove();
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
            content.find('.table').remove();
            content.find('.row').remove();
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
        
    //RELATED MPDULE POPUP HERE STARTS
    function insertRelated(jData){
        quickCreateModal(jData);
    }
    //RELATED MODULE POPUP ENDS
    // Genereates quick create form content
    function quickCreateFormContent(jData){
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
                    $(content).append(data);
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


/////////////nauman code starts here////////////////////
        function emailFormContent(id){
                    //console.log("form emailFormContent: "+id);
                    var content = $("#table").clone();
                    content.find('.dataTables_wrapper').remove();
                    content.find('.table').remove();
                    content.find('.row').remove();
                    <?php
                        $q = $this->queryString;
                        $q['xtype'] = 'email';
                       
                    ?>
           
            $.ajax({
                type: 'GET',
                data : { id : id },
                url: '?<?php echo http_build_query($q, '', '&'); ?>',
                success: function(data) {   
                    //console.log(data);
                    <?php
                        $q = $this->queryString;
                        //$q['src']['p'] = 1;
                        $q['xtype'] = 'sendmail';
                        if (isset($q['xid']))
                        unset($q['xid']);
                    ?>
                    var actionUrl = '?<?php echo http_build_query($q, '', '&'); ?>';

                    //$(content).css('visibility','visible');
                    $(content).attr('id','sendmail');
                    $(content).attr('action',actionUrl);
                    $(content).append(data);
                }
            });
            return content ;
        }
////////////////////nauman code ends here///////////////////////

    /////////Business Summary code////////
    function BusinessSummaryModal(b_id) {
        var modalClass = 'modal_new' ;
        bootbox.dialog({
            message: BusinesssummaryContent(b_id),
            title: "Business Summary",
            className:modalClass,
            buttons: {
                quickcreate: {
                    label: 'OK',
                    className: 'btn-success',
                }
            }
        });
    }

  function BusinesssummaryContent(b_id){
        var content = $("#table").clone();
        content.find('.dataTables_wrapper').remove();
        content.find('.table').remove();
        content.find('.row').remove();
        <?php
        $q = $this->queryString;
        $q['xtype'] = 'business_summary';
        if (isset($q['key']))
            unset($q['key']);
        ?>


        $.ajax({
            type: 'GET',
            url: '?<?php echo http_build_query($q, '', '&'); ?>&bid='+b_id,
            success: function(data) {

                <?php
                $q = $this->queryString;
                $q['src']['p'] = 1;
                $q['xtype'] = 'business_summary';
                if (isset($q['xid']))
                    unset($q['xid']);
                ?>
                var actionUrl = '?<?php echo http_build_query($q, '', '&'); ?>';

                $(content).css('visibility','visible');
                $(content).attr('id','business_summary');
                $(content).attr('action',actionUrl);
                $(content).append(data);
            }
        });
        return content ;
    }
    ////////////////////
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

            if($comId==31){
                ?>
            window.location = "<?=base_url()?>admin/reports?" + id;
                <?php
            }else{
                ?>
            window.location = "?<?php echo http_build_query($q, '', '&'); ?>&" + id;
                <?php
            }
            ?>
        }

        function __edit(id) {
            <?php
            $q = $this->queryString;
            $q['xtype'] = 'form';
            if (isset($q['key']))
                unset($q['key']);
            if($comId==31){
            ?>
                window.location = "<?=base_url()?>admin/reports/create_report?" + id;
            <?php }else{ ?> 
                window.location = "?<?php echo http_build_query($q, '', '&'); ?>&" + id;
            <?php } ?>
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

        function __mail(id,email='a') {
          
               if(email!=='a' && email===''){
                 bootbox.alert("Email address for this record is undefined.", function() {
                  
                });return 0;
               }
                //console.log(id);

                var modalClass= 'modal_'+'<?=$_GET['com_id']?>';
                bootbox.dialog({
                    className:modalClass,
                    message: emailFormContent(id),
                    title: "Email Sending!",
                    buttons: {
                        cancel: {
                            label: 'Cancel',
                            className: 'btn-warning'
                        },
                        update: {
                        label: 'Send Email ',
                        className: 'btn-success',
                        callback: function (data) {
                            var ckContent = $('.cke_contents iframe').contents().find('body').html();
                            $('#dataEmailBody').val(ckContent);
                            //Serialize form data
                            var frmdata = new FormData($("#sendmail")[0]);
                            console.log(frmdata);
                                <?php
                                    $q = $this->queryString;
                                    //$q['src']['p'] = 1;
                                    $q['xtype'] = 'sendmail';
                                    if (isset($q['xid']))
                                    unset($q['xid']);
                                ?>
                                var actionUrl = '?<?php echo http_build_query($q, '', '&'); ?>';
                                $('#loading').show();
                                $.ajax({
                                    url: actionUrl,
                                    type: $("#sendmail").attr("method"),
                                    data: frmdata,
                                    processData: false,
                                    contentType: false,
                                    success: function (response) { 

                                        console.log( response);
                                        //var datas=JSON.parse(response);
                                        //console.log('its errors');
                                        //console.log(response['errors']);
                                        console.log(response.errors);
                                        $('#loading').hide();
                                        if(response.errors!=undefined){
                                            // for(var e in response.errors){
                                            //     console.log('message: '+e.msg);
                                            //     console.log('response: '+e.response);
                                            // }
                                            // var feedback="<table class=\"table table-bordered\">";
                                            // feedback+="<tr><th>Message</th><th>Response</th></tr>";
                                            var failed=(response.total_email*1)-(response.count_email*1);
                                             var feedback="<p>Total <b>"+response.total_email+"</b> are requested to be sent.</p><br/>";
                                            feedback+="<p><b>"+failed+"</b> emails could not be sent.</p><br/>";
                                            $.each(response.errors,function(k,v){
                                                console.log('message: '+v.msg);
                                                console.log('response: '+v.response);
                                                console.log('email: ' + v.email);
                                                console.log('name: '+v.name);


                                                feedback+="<i>"+v.name+" ";
                                                feedback+="( "+ v.email + ")</i>";
                                                feedback+="<br/>";
                                                // feedback +="<tr>";
                                                // feedback+="<td> "+v.msg + "</td>";
                                                // feedback+="<td> "+v.response + "</td>";
                                                // feedback+="</tr>";


                                            });
                                            // feedback+="<tr><th>Total Emails</th>";
                                            // feedback+="<td>" +response.total_email+ "</td></tr>";
                                            // feedback+="<tr><th>Successful Mail sent</th>";
                                            // feedback+="<td>" +response.count_email+ "</td></tr>";
                                            feedback+="</table>";
                                            $('#quickcreate_form_container').html();
                                            $('#quickcreate_form_container').html(feedback);

                                        }else if(response.yes!=undefined){
                                             var msgmail="Email has been sent.";
                                            var strAlertSuccess = '<div class="alert alert-info" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;"><button data-dismiss="alert" class="close" type="button">×</button>'+msgmail+'</div>';
                                            var alertSuccess = $(strAlertSuccess).appendTo('body');
                                            alertSuccess.show();
                                            setTimeout(function(){ 
                                            alertSuccess.remove();
                                            },5000);
                                            $('.'+modalClass).modal('hide');
                                        }else{
                                            var msgmail="Email sending Failed.";
                                            $('#errors').attr('class','alert alert-danger');
                                            $('#errors').html(msgmail);
                                           
                                        }
                                        
                                        return false;                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                       console.log(textStatus, errorThrown);
                                    }
                                });
                              
                            return false;   
                            }
                        }
  

                    }
                });

        }

        function mass__mail(){
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
            }
            else{__mail(selected_ids);}

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

        function filterSearch() {
            <?php
            $q = $this->queryString;
            $q['xtype'] = 'index';
            if (isset($q['xid']))
                unset($q['xid']);
            if (isset($q['src']) && isset($q['src']['p']))
                unset($q['src']['p']);
            if (isset($q['flt']))
                unset($q['flt']);
            ?>

 var value1 = $("[name='flt\\[\\]']").map(function(){return encodeURIComponent($(this).val());}).get();
 var value2 = $("[name='fld\\[\\]']").map(function(){return $(this).val();}).get();
            window.location = "?<?php echo http_build_query($q, '', '&'); ?>&flt=" + value1.toString()+"&fld=" + value2.toString();
        }

//////////////////////nauman code starts here.////////////////////////////////////
    function searchForAllFields(){
            <?php
            $q = $this->queryString;
            $q['xtype'] = 'index';
            if (isset($q['xid']))
                unset($q['xid']);
            if (isset($q['src']) && isset($q['src']['p']))
                unset($q['src']['p']);
            if (isset($q['flt']))
                unset($q['flt']);
            $q['s_all']=1;
            
            ?>
            var all_fields_search=<?=json_encode($all_fields)?>;
            //console.log(all_fields_search);
            var dataType=<?=json_encode($a_dataType)?>;
            //console.log(dataType);
            // console.info(dataType);
            
            var value1 = encodeURIComponent($("input[name='fltr']").val());

            for(i = 0; i < <?=count($fields)-1;?>; i++) { 
                value1 += ','+encodeURIComponent($("input[name='fltr']").val());

            }

        var arr=new Array();
        $.each(all_fields_search, function(key, val) {
            arr[key]=val+'|'+dataType[val];
           
        });
    
            var value2 =  $("input[name='flds']").val();

            window.location = "?<?php echo http_build_query($q, '', '&'); ?>&flt=" + value1+"&fld=" + arr;
        }
/////////////////////nauman code ends here///////////////////////////////////////////////


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
        var recordIds = [];
            var recordIds = [];
            $('input[name="selected_records"]').each(function(){
                if ($(this).is(':checked')) {
                    recordIds.push($(this).val());
                }  
            });
            var selected_ids = recordIds.join();
            //console.log(selected_ids);return 0;
            <?php
            $url='';
            if(isset($_GET['flt']) and isset($_GET['fld'])){
                $url.='&flt='.$_GET['flt'].'&fld='.$_GET['fld'];
            }
            ?>
        $('#crudIframe').attr({src:'<?php echo base_url(); ?>index.php/admin/scrud/exportcsv?com_id=<?php echo $comId; ?>&xtype=exportcsv<?=$url?>&sel_rec='+selected_ids});
    }
    function crudExportAll() {
        $('#crudIframe').attr({src: '<?php echo base_url(); ?>index.php/admin/scrud/exportcsv?com_id=<?php echo $comId; ?>&xtype=exportcsvall'});
    }
    </script>
    <style type="text/css">
        .modal-dialog{
            width:60%;
        }
    </style>
        <script src="<?php echo base_url(); ?>media/js/mfunctions/mfunctions.js" type="text/javascript"></script>
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

    //FILTERS STARTS
    $('#filters').change(function() {
        // set the window's location property to the value of the option the user has selected
        var new_filter = $('#filters option:selected').val();
        if (new_filter == 'new') {
            window.location = '<?php echo base_url(); ?>index.php/admin/filters?comid='+<?php echo $comId; ?>;
        } else {
            window.location = "?<?php echo http_build_query($q, '', '&'); ?>&f="+new_filter;
        }
    });  
 //FILTERS ENDS

////////////////////////nauman code starts here//////////////////////
$(document).ready(function()  {

        $('.daterange').daterangepicker({
        "opens": "left",
        timePickerIncrement: 30,
        locale: {
            format: 'DD/MM/YYYY'
        }
    }).val('');

      $(".select2, .select2-multiple").select2({
                //placeholder: "Select...",
                width: null
            });

            $(".select2-allow-clear").select2({
                allowClear: true,
                //placeholder: "Select...",
                width: null
            });  

        $("[name='flt\\[\\]']").keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#filter_search').click();//Trigger search button click event
        }
    });
});
////////////////////////nauman code ends here/////////////////////////
</script>