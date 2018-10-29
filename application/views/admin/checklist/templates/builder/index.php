<?php
global $date_format_convert;
$CI = & get_instance();
$lang = $CI->lang;
$clsWidth = 50;
foreach ($this->colsCustom as $k => $v) {
	if ($k == 'action') {
		$matches = array();
		preg_match_all('/<a[^>]*>([^<]*)<\/a>/iU', $this->colsCustom['action'], $matches);
		
		
		$clsWidth = $clsWidth* count($matches[0]);
		array_unshift($matches[0], '<a class="btn btn-icon-only yellow fa fa-times" onclick="removeChecklist(\'{checklists.id}\',\'{checklists.component_name}\')" ></a>');
		array_unshift($matches[0], '<a class="btn btn-icon-only grey-cascade fa fa-wrench" href="'.base_url().'index.php/admin/scrud/checklist?chklst_id={checklists.id}" ></a>');
		$clsWidth += 130;
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
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                
                    <div class="portlet-title">
                        <div class="pull-left">
                        </div>
                        <div class="pull-right">
                            <a href="javascript:;" class="btn btn-sm blue "  onclick="newRecord();"> <i class="icon-plus icon-white"></i> <?php echo $CI->lang->line('add'); ?></a>
                        </div>
                    </div>
                    <div class="portlett-body">
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

                            <input type="hidden" name="src[page]" id="srcPage" value="<?php echo $this->pageIndex; ?>"/>
                            <input type="hidden" name="src[limit]" id="srcLimit" value="<?php echo $this->limit; ?>"/>
                            <input type="hidden" name="src[order_field]" id="srcOrder_field" value="<?php echo $this->orderField; ?>"/>
                            <input type="hidden" name="src[order_type]" id="srcOrder_type" value="<?php echo $this->orderType; ?>"/>
                            <table class="table table-striped table-bordered table-hover  order-column" id="sample_1">
                                <thead>
                                    <tr>
                                        <?php foreach ($fields as $k => $field) { ?>
                                            <?php if (in_array($field, $this->fields)) { ?>
                                                <th onclick="order('<?php echo ($field) ?>');" style="<?php if (isset($this->colsWidth[$field])) { ?>width:<?php echo $this->colsWidth[$field]; ?>px; 
                                                    <?php } else if (isset($this->colsWidth[$k])) { ?>width:<?php echo $this->colsWidth[$k]; ?>px; <?php } ?>">
                                                    <?php echo htmlspecialchars((isset($this->fieldsAlias[$field])) ? $this->fieldsAlias[$field] : $field); ?>
                                                    <?php if ($this->orderField == $field) { ?>
                                                        <i class="arrow <?php echo $this->orderType; ?>"></i>
                                                    <?php } ?>
                                                </th>
                                            <?php } else { ?>
                                                <th style="<?php if (isset($this->colsWidth[$field])) { ?>width:<?php echo $this->colsWidth[$field]; ?>px; 
                                                    <?php } else if (isset($this->colsWidth[$k])) { ?>width:<?php echo $this->colsWidth[$k]; ?>px; <?php } ?>">
                                                    <?php echo htmlspecialchars((isset($this->fieldsAlias[$field])) ? $this->fieldsAlias[$field] : $field); ?>
                                                </th>
                                            <?php } ?>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                            //echo "<pre>";print_r($this->results);exit;
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


                                    $form=$this->form[0]['section_fields'];

                                    if (isset($form[$field]) && isset($form[$field]['element'][0])) {
                                        switch (trim(strtolower($form[$field]['element'][0]))) {
                                            case 'radio':
                                            case 'autocomplete':
                                            case 'select':
                                                $e = $form[$field]['element'];
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
                                                $form[$field]['element'][1] = $options;
                                                if (isset($form[$field]['element'][1]) &&
                                                        !empty($form[$field]['element'][1]) &&
                                                        is_array($form[$field]['element'][1]) &&
                                                        !empty($form[$field]['element'][1][$__value])
                                                ) {
                                                    $r[] = htmlspecialchars($form[$field]['element'][1][$__value]);
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
                                                        if (isset($form[$field]['element'][1][$v1])) {
                                                            $tmp[] = $form[$field]['element'][1][$v1];
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
                                    <?php foreach ($fields as $field) { ?>
                                        <td style="<?php if (isset($this->colsAlign[$field])) { ?>text-align:<?php echo $this->colsAlign[$field]; ?>;<?php } ?>">
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
                                                //echo "<pre>".print_r($this->form[0]['section_fields'][$field])."</pre>";
                                                if (isset($form[$field]) && isset($form[$field]['element'][0])) {
                                                    switch (trim(strtolower($form[$field]['element'][0]))) {
                                                        case 'radio':
                                                        case 'autocomplete':
                                                        case 'select':
                                                            $e = $form[$field]['element'];
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
                                                            $form[$field]['element'][1] = $options;

                                                            if (isset($form[$field]['element'][1]) &&
                                                                    !empty($form[$field]['element'][1]) &&
                                                                    is_array($form[$field]['element'][1]) &&
                                                                    !empty($form[$field]['element'][1][$__value])) {
                                                                echo nl2br(htmlspecialchars($form[$field]['element'][1][$__value]));
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
                                                                    if (isset($form[$field]['element'][1][$v1])) {
                                                                        $tmp[] = $form[$field]['element'][1][$v1];
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
                            <?php } 
                            } ?>
                            </tbody>
                        </table>
                        <div class="row">
                              <?php require dirname(__FILE__) . '/paginate.php'; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- page content ends -->
<script>

                    function searchModal() {
                        $.sModal({
                            header:'Search box',
                            animate: 'fadeDown',
                            content:'<div id="scrud_model_search"><center><img src="<?php echo __MEDIA_PATH__; ?>icons/loading.gif" /></center></div>',
                            onShow: function(id){ 
                                <?php
                                $q = $this->queryString;
                                $q['xtype'] = 'modalform';
                                if (isset($q['key']))
                                    unset($q['key']);
                                ?>
                                $('#' + id).find('#scrud_model_search').load('?<?php echo http_build_query($q, '', '&'); ?>');
                                 setTimeout(function(){
                                     $('#' + id).removeClass('fadeInDown');
                                    },1000);
                            },
                            buttons: [
                                {
                                    text: ' <i class="icon-search icon-white"></i>  Search  ',
                                    addClass: 'btn-primary',
                                    click: function(id, data) {
                                        crudSearch();
                                        $.sModal('close', id);
                                    }
                                },
                                {
                                    text: ' Cancel ',
                                    click: function(id, data) {
                                        $.sModal('close', id);
                                    }
                                }
                            ]
                        });
                    }

                    function removeChecklist(com_id,com_name){
                        /*$.sModal({
                            image: '<?php echo __MEDIA_PATH__; ?>icons/error.png',
                            animate: 'fadeDown',
                            content:"<?php echo $lang->line('you_want_to_remove'); ?> "+com_name+"'s <?php echo $lang->line('configure'); ?>?",
                            buttons: [
                                {
                                    text: ' <i class="icon-remove icon-white"></i>  Remove  ',
                                    addClass: 'btn-danger',
                                    click: function(id, data) {*/
                                        window.location='<?php echo base_url(); ?>index.php/admin/scrud/removeChecklist?chklst_id='+com_id;
                                        /*$.sModal('close', id);
                                    }
                                },
                                {
                                    text: ' Cancel ',
                                    click: function(id, data) {
                                        $.sModal('close', id);
                                    }
                                }
                            ]
                        });*/
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
                $('#crudIframe').attr({src: '<?php echo base_url(); ?>index.php/admin/scrud/exportCsv.php?table=<?php echo $this->table; ?>&xtype=exportcsv'});
            }
            function crudExportAll() {
                $('#crudIframe').attr({src: '<?php echo base_url(); ?>index.php/admin/scrud/exportCsv.php?table=<?php echo $this->table; ?>&xtype=exportcsvall'});
            }
</script>
</div>