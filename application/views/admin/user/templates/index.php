<?php $CI = & get_instance();
$lang = $CI->lang; ?>
<?php
global $date_format_convert;
$clsWidth = 50;
foreach ($this->colsCustom as $k => $v) {
	if ($k == 'action') {
		$matches = array();
		preg_match_all('/<a[^>]*>([^<]*)<\/a>/iU', $this->colsCustom['action'], $matches);
		
		
		$clsWidth = $clsWidth* count($matches[0]);
		$this->colsCustom[$k] = implode(' ', $matches[0]);
	}
}

foreach ($this->colsWidth as $k => $v) {
	if ($k == 'action') {
		$this->colsWidth[$k] =  $clsWidth;
	}
}

?>
<?php if (!empty($this->form)) { ?>
   <!-- BEGIN DASHBOARD STATS 1-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                            <div class="portlet-title">
                                                <div class="pull-left">
                                                   <a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=65" class="btn btn-sm green"><?php echo $CI->lang->line('users');?>
                                                    </a>
                                                     <a href="<?php echo base_url(); ?>admin/user/group" class="btn btn-sm green"><?php echo $CI->lang->line('groups');?>
                                                    </a>
                                                     <a href="<?php echo base_url(); ?>admin/user/permission" class="btn btn-sm green"><?php echo $CI->lang->line('permissions');?>
                                                    </a>

                                                    <a class="btn btn-sm blue" onclick="massEditModal();">Mass Edit</a>
                                                    <a class="btn btn-sm yellow" onclick="massDelModal();">Mass Delete</a>

                                                <div class="btn-group " style="min-width: 175px;">
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
                                                <div class="pull-right">
                                                    <a href="javascript:;" class="btn btn-sm blue " onclick="newRecord();"><?php echo $CI->lang->line('add');?>
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            
                                        </div>
                                    </div>
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
                                                        <th style="<?php if (isset($this->colsWidth[$field])) { ?>width:<?php echo $this->colsWidth[$field]; ?>px !important; 
                                                            <?php } else if (isset($this->colsWidth[$k])) { ?>width:<?php echo $this->colsWidth[$k]; ?>px !important; <?php } ?>"><?php echo htmlspecialchars((isset($this->fieldsAlias[$field])) ? $this->fieldsAlias[$field] : $field); ?></th>
                                                    <?php } else { ?>
                                                        <th style="width: 250px !important;"><?php echo htmlspecialchars((isset($this->fieldsAlias[$field])) ? $this->fieldsAlias[$field] : $field); ?></th>
                                                    <?php } ?>
                                                <?php } ?>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if (!empty($this->results)) {
                                                $s = array();
                                                foreach ($this->fields as $field) {
                                                    $s[] = '{' . $field . '}';
                                                }
                                                $s[] = '{ppri}';
                                                $s[] = '{no}';
                                                $offset = ($this->pageIndex - 1) * $this->limit;
                                            ?>
                                                <?php
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
                                                    if (isset($this->form[$field]) && isset($this->form[$field]['element'][0])) {
                                                        switch (trim(strtolower($this->form[$field]['element'][0]))) {
                                                            case 'radio':
                                                            case 'autocomplete':
                                                            case 'select':
                                                                $e = $this->form[$field]['element'];
                                                                $options = array();
                                                                $params = array();
                                                                if (isset($e[1]) && !empty($e[1])) {
                                                                    if (array_key_exists('option_table', $e[1])) {
                                                                        if (array_key_exists('option_key', $e[1]) &&
                                                                                array_key_exists('option_value', $e[1])) {
                                                                            $_dao = new ScrudDao($e[1]['option_table'], $CI->db);
                                                                            $params['fields'] = array($e[1]['option_key'], $e[1]['option_value']);
                                                                            $rs = $_dao->find($params);
                                                                            if (!empty($rs)) {
                                                                                foreach ($rs as $v) {
                                                                                    $options[$v[$e[1]['option_key']]] = $v[$e[1]['option_value']];
                                                                                }
                                                                            }
                                                                        }
                                                                    } else {
                                                                        $options = $e[1];
                                                                    }
                                                                }
                                                                $this->form[$field]['element'][1] = $options;
                                                                if (isset($this->form[$field]['element'][1]) &&
                                                                        !empty($this->form[$field]['element'][1]) &&
                                                                        is_array($this->form[$field]['element'][1]) &&
                                                                        !empty($this->form[$field]['element'][1][$__value])
                                                                ) {
                                                                    $r[] = htmlspecialchars($this->form[$field]['element'][1][$__value]);
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
                                                                        if (isset($this->form[$field]['element'][1][$v1])) {
                                                                            $tmp[] = $this->form[$field]['element'][1][$v1];
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
                                                if (isset($this->form[$field]) && isset($this->form[$field]['element'][0])) {
                                                    switch (trim(strtolower($this->form[$field]['element'][0]))) {
                                                        case 'radio':
                                                        case 'autocomplete':
                                                        case 'select':
                                                            $e = $this->form[$field]['element'];
                                                            $options = array();
                                                            $params = array();
                                                            if (isset($e[1]) && !empty($e[1])) {
                                                                if (array_key_exists('option_table', $e[1])) {
                                                                    if (array_key_exists('option_key', $e[1]) &&
                                                                            array_key_exists('option_value', $e[1])) {
                                                                        $_dao = new ScrudDao($e[1]['option_table'], $CI->db);
                                                                        $params['fields'] = array($e[1]['option_key'], $e[1]['option_value']);
                                                                        $rs = $_dao->find($params);
                                                                        if (!empty($rs)) {
                                                                            $rs = $rs[$e[1]['option_table']];
                                                                            foreach ($rs as $v) {
                                                                                $options[$v[$e[1]['option_key']]] = $v[$e[1]['option_value']];
                                                                            }
                                                                        }
                                                                    }
                                                                } else {
                                                                    $options = $e[1];
                                                                }
                                                            }
                                                            $this->form[$field]['element'][1] = $options;

                                                            if (isset($this->form[$field]['element'][1]) &&
                                                                    !empty($this->form[$field]['element'][1]) &&
                                                                    is_array($this->form[$field]['element'][1]) &&
                                                                    !empty($this->form[$field]['element'][1][$__value])) {
                                                                echo nl2br(htmlspecialchars($this->form[$field]['element'][1][$__value]));
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
                                                                    if (isset($this->form[$field]['element'][1][$v1])) {
                                                                        $tmp[] = $this->form[$field]['element'][1][$v1];
                                                                    }
                                                                }
                                                                $value = implode(', ', $tmp);
                                                            } else {
                                                                $value = '';
                                                            }
                                                            echo htmlspecialchars($value);
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
            <!-- BEGIN QUICK SIDEBAR -->
            <a href="javascript:;" class="page-quick-sidebar-toggler">
                <i class="icon-login"></i>
            </a>
            <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
                <div class="page-quick-sidebar">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"> Users
                                <span class="badge badge-danger">2</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                               <i class="icon-settings"></i> Settings 
                            </a>
                        </li>                        
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                            <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                                <h3 class="list-heading">Staff</h3>
                                <ul class="media-list list-items">
                                    <li class="media">
                                        <div class="media-status">
                                            <span class="badge badge-success">8</span>
                                        </div>
                                        <img class="media-object" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar3.jpg" alt="...">
                                        <div class="media-body">
                                            <h4 class="media-heading">Bob Nilson</h4>
                                            <div class="media-heading-sub"> Project Manager </div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <img class="media-object" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar1.jpg" alt="...">
                                        <div class="media-body">
                                            <h4 class="media-heading">Nick Larson</h4>
                                            <div class="media-heading-sub"> Art Director </div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-status">
                                            <span class="badge badge-danger">3</span>
                                        </div>
                                        <img class="media-object" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar4.jpg" alt="...">
                                        <div class="media-body">
                                            <h4 class="media-heading">Deon Hubert</h4>
                                            <div class="media-heading-sub"> CTO </div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <img class="media-object" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar2.jpg" alt="...">
                                        <div class="media-body">
                                            <h4 class="media-heading">Ella Wong</h4>
                                            <div class="media-heading-sub"> CEO </div>
                                        </div>
                                    </li>
                                </ul>
                                <h3 class="list-heading">Customers</h3>
                                <ul class="media-list list-items">
                                    <li class="media">
                                        <div class="media-status">
                                            <span class="badge badge-warning">2</span>
                                        </div>
                                        <img class="media-object" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar6.jpg" alt="...">
                                        <div class="media-body">
                                            <h4 class="media-heading">Lara Kunis</h4>
                                            <div class="media-heading-sub"> CEO, Loop Inc </div>
                                            <div class="media-heading-small"> Last seen 03:10 AM </div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-status">
                                            <span class="label label-sm label-success">new</span>
                                        </div>
                                        <img class="media-object" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar7.jpg" alt="...">
                                        <div class="media-body">
                                            <h4 class="media-heading">Ernie Kyllonen</h4>
                                            <div class="media-heading-sub"> Project Manager,
                                                <br> SmartBizz PTL </div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <img class="media-object" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar8.jpg" alt="...">
                                        <div class="media-body">
                                            <h4 class="media-heading">Lisa Stone</h4>
                                            <div class="media-heading-sub"> CTO, Keort Inc </div>
                                            <div class="media-heading-small"> Last seen 13:10 PM </div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-status">
                                            <span class="badge badge-success">7</span>
                                        </div>
                                        <img class="media-object" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar9.jpg" alt="...">
                                        <div class="media-body">
                                            <h4 class="media-heading">Deon Portalatin</h4>
                                            <div class="media-heading-sub"> CFO, H&D LTD </div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <img class="media-object" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar10.jpg" alt="...">
                                        <div class="media-body">
                                            <h4 class="media-heading">Irina Savikova</h4>
                                            <div class="media-heading-sub"> CEO, Tizda Motors Inc </div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-status">
                                            <span class="badge badge-danger">4</span>
                                        </div>
                                        <img class="media-object" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar11.jpg" alt="...">
                                        <div class="media-body">
                                            <h4 class="media-heading">Maria Gomez</h4>
                                            <div class="media-heading-sub"> Manager, Infomatic Inc </div>
                                            <div class="media-heading-small"> Last seen 03:10 AM </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="page-quick-sidebar-item">
                                <div class="page-quick-sidebar-chat-user">
                                    <div class="page-quick-sidebar-nav">
                                        <a href="javascript:;" class="page-quick-sidebar-back-to-list">
                                            <i class="icon-arrow-left"></i>Back</a>
                                    </div>
                                    <div class="page-quick-sidebar-chat-user-messages">
                                        <div class="post out">
                                            <img class="avatar" alt="" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar3.jpg" />
                                            <div class="message">
                                                <span class="arrow"></span>
                                                <a href="javascript:;" class="name">Bob Nilson</a>
                                                <span class="datetime">20:15</span>
                                                <span class="body"> When could you send me the report ? </span>
                                            </div>
                                        </div>
                                        <div class="post in">
                                            <img class="avatar" alt="" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar2.jpg" />
                                            <div class="message">
                                                <span class="arrow"></span>
                                                <a href="javascript:;" class="name">Ella Wong</a>
                                                <span class="datetime">20:15</span>
                                                <span class="body"> Its almost done. I will be sending it shortly </span>
                                            </div>
                                        </div>
                                        <div class="post out">
                                            <img class="avatar" alt="" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar3.jpg" />
                                            <div class="message">
                                                <span class="arrow"></span>
                                                <a href="javascript:;" class="name">Bob Nilson</a>
                                                <span class="datetime">20:15</span>
                                                <span class="body"> Alright. Thanks! :) </span>
                                            </div>
                                        </div>
                                        <div class="post in">
                                            <img class="avatar" alt="" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar2.jpg" />
                                            <div class="message">
                                                <span class="arrow"></span>
                                                <a href="javascript:;" class="name">Ella Wong</a>
                                                <span class="datetime">20:16</span>
                                                <span class="body"> You are most welcome. Sorry for the delay. </span>
                                            </div>
                                        </div>
                                        <div class="post out">
                                            <img class="avatar" alt="" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar3.jpg" />
                                            <div class="message">
                                                <span class="arrow"></span>
                                                <a href="javascript:;" class="name">Bob Nilson</a>
                                                <span class="datetime">20:17</span>
                                                <span class="body"> No probs. Just take your time :) </span>
                                            </div>
                                        </div>
                                        <div class="post in">
                                            <img class="avatar" alt="" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar2.jpg" />
                                            <div class="message">
                                                <span class="arrow"></span>
                                                <a href="javascript:;" class="name">Ella Wong</a>
                                                <span class="datetime">20:40</span>
                                                <span class="body"> Alright. I just emailed it to you. </span>
                                            </div>
                                        </div>
                                        <div class="post out">
                                            <img class="avatar" alt="" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar3.jpg" />
                                            <div class="message">
                                                <span class="arrow"></span>
                                                <a href="javascript:;" class="name">Bob Nilson</a>
                                                <span class="datetime">20:17</span>
                                                <span class="body"> Great! Thanks. Will check it right away. </span>
                                            </div>
                                        </div>
                                        <div class="post in">
                                            <img class="avatar" alt="" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar2.jpg" />
                                            <div class="message">
                                                <span class="arrow"></span>
                                                <a href="javascript:;" class="name">Ella Wong</a>
                                                <span class="datetime">20:40</span>
                                                <span class="body"> Please let me know if you have any comment. </span>
                                            </div>
                                        </div>
                                        <div class="post out">
                                            <img class="avatar" alt="" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar3.jpg" />
                                            <div class="message">
                                                <span class="arrow"></span>
                                                <a href="javascript:;" class="name">Bob Nilson</a>
                                                <span class="datetime">20:17</span>
                                                <span class="body"> Sure. I will check and buzz you if anything needs to be corrected. </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="page-quick-sidebar-chat-user-form">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Type a message here...">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn green">
                                                    <i class="icon-paper-plane"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane page-quick-sidebar-settings" id="quick_sidebar_tab_3">
                            <div class="page-quick-sidebar-settings-list">
                                <h3 class="list-heading">General Settings</h3>
                                <ul class="list-items borderless">
                                    <li> Enable Notifications
                                        <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                    <li> Allow Tracking
                                        <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                    <li> Log Errors
                                        <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                    <li> Auto Sumbit Issues
                                        <input type="checkbox" class="make-switch" data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                    <li> Enable SMS Alerts
                                        <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                </ul>
                                <h3 class="list-heading">System Settings</h3>
                                <ul class="list-items borderless">
                                    <li> Security Level
                                        <select class="form-control input-inline input-sm input-small">
                                            <option value="1">Normal</option>
                                            <option value="2" selected>Medium</option>
                                            <option value="e">High</option>
                                        </select>
                                    </li>
                                    <li> Failed Email Attempts
                                        <input class="form-control input-inline input-sm input-small" value="5" /> </li>
                                    <li> Secondary SMTP Port
                                        <input class="form-control input-inline input-sm input-small" value="3560" /> </li>
                                    <li> Notify On System Error
                                        <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                    <li> Notify On SMTP Error
                                        <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                </ul>
                                <div class="inner-content">
                                    <button class="btn btn-success">
                                        <i class="icon-settings"></i> Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END QUICK SIDEBAR -->
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
                url: '?com_id='+jData.module_id+'&xtype=summary&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll,
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
                    	$('title').html($('h2').html());
                    });
</script>
<iframe src="" id="crudIframe" height="0" width="0" style="width: 0px; line-height:0px; height: 0px; border: 0px; padding: 0px; margin: 0px; display:none;"></iframe>
<script>
            function crudSearch() {
                document.getElementById('srcPage').value = 1;
                document.getElementById('table').submit();
            }
            function crudExport() {
                $('#crudIframe').attr({src: '<?php echo base_url() ?>index.php/admin/scrud/exportCsv?table=<?php echo $_GET['table']; ?>&xtype=exportcsv'});
            }
            function crudExportAll() {
                $('#crudIframe').attr({src: '<?php echo base_url() ?>index.php/admin/scrud/exportCsv?table=<?php echo $_GET['table']; ?>&xtype=exportcsvall'});
            }
</script>
<script src="<?php echo base_url(); ?>media/js/mfunctions/mfunctions.js" type="text/javascript"></script>