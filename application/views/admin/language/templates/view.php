<?php 
global $date_format_convert;
$CI = & get_instance();
$lang = $CI->lang; ?>



<div class="portlet light bordered">
    <div class="portlet-title" style="height: 52px;">
    
        <div class="pull-left">
                
             
                <a href="<?php echo base_url(); ?>index.php/admin/component/builder" class="btn btn-sm green"> <?php echo $CI->lang->line('components'); ?> </a>
                <a href="<?php echo base_url(); ?>index.php/admin/component/groups" class="btn btn-sm green"> <?php echo $CI->lang->line('group_component'); ?> </a>
                <a href="<?php echo base_url(); ?>index.php/admin/table/index" class="btn btn-sm green"><?php echo $CI->lang->line('table_builder'); ?></a>
                <a href="<?php echo base_url(); ?>index.php/admin/language/index" class="btn btn-sm green"> <?php echo $CI->lang->line('language_manager'); ?> </a>


               
            
        
        </div>
        <div class="pull-right">
            <div class="btn-group">
                <a class="btn"  onclick="crudBack();">   <i class="icon-arrow-left"></i>  <?php echo $lang->line('back'); ?>  &nbsp; </a>
                <a class="btn btn-info" onclick="__edit();" > &nbsp;  <i class="icon-edit icon-white"></i>  <?php echo $lang->line('edit');?> &nbsp; </a>
            </div>
        </div>
            

    </div>



<div class="portlet-body">

<div class='x-table well <?php echo $this->conf['color']; ?>' style="background:#FBFBFB;">
    <?php $elements = $this->form; ?>
    <form method="post" action="" id="crudForm" <?php if ($this->frmType == '2') { ?>class="form-horizontal"<?php } ?>>
        <?php
        foreach ($elements as $field => $v) {
            if (empty($v['element']))
                continue;
            ?>
            		<div class="control-group">
                        <label for="crudTitle" class="control-label">
                            <b><?php echo (!empty($v['alias'])) ? $v['alias'] : $field; ?></b>
                        </label>
                        <div class="controls" style="padding-top:5px;">
                            <?php
                            $elements = (isset($v['element'])) ? $v['element'] : array();
                            switch ($elements[0]) {
                                case 'radio':
                                case 'autocomplete':
                                case 'select':
                                    $e = $elements;
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
                                    $elements[1] = $options;
                                    break;
                            }
                            switch ($elements[0]) {
                                case 'checkbox':
                                    $aryField = explode('.', $field);
                                    $data = $CI->input->post('data');
                                    $value = (isset($data[$aryField[0]][$aryField[1]]))?explode(',', $data[$aryField[0]][$aryField[1]]):array();
                                    if (!empty($value) && is_array($value) && count($value) > 0) {
                                        $tmp = array();
                                        foreach ($value as $k1 => $v1) {
                                            if (isset($elements[1][$v1])) {
                                                $tmp[] = $elements[1][$v1];
                                            }
                                        }
                                        $value = implode(', ', $tmp);
                                    } else {
                                        $value = '';
                                    }
                                    echo htmlspecialchars($value);
                                    break;
                                case 'image':
                                case 'editor':
                                    echo __value('data.' . $field, $elements);
                                    break;
                                case 'file':
                                    $value = __value('data.' . $field);
                                    if (file_exists(FCPATH . '/media/files/' . $value)) {
                                        echo '<a href="'.base_url().'index.php/admin/download?file=' . $value . '">' . $value . '</a>';
                                    } else {
                                        echo $value;
                                    }
                                    break;
                                case 'password':
                                    echo '******';
                                    break;
                                case 'textarea':
                                	echo nl2br(htmlspecialchars(__value('data.' . $field, $elements)));
                                	break;
                                case 'date':
                                	if (is_date(__value('data.' . $field, $elements))){
                                		echo date($date_format_convert[__DATE_FORMAT__],strtotime(__value('data.' . $field, $elements)));
                                	}else{
                                    		echo '';
                                    	}
                                    	break;
                                case 'datetime':
                                	if (is_date(__value('data.' . $field, $elements))){
                                		echo date($date_format_convert[__DATE_FORMAT__].' H:i:s',strtotime(__value('data.' . $field, $elements)));
                                	}else{
                                    		echo '';
                                    	}
                                    	break;
                                default:
                                    echo nl2br(htmlspecialchars(__value('data.' . $field, $elements)));
                                    break;
                            }
                            ?>
                        </div>
                     </div>
                <?php
            }
            ?>
    </form>
    <script>
    function __edit() {
    	<?php
    	$q = $this->queryString;
    	$q['xtype'] = 'form';
    	?>
    	                        window.location = "?<?php echo http_build_query($q, '', '&'); ?>";
    	                    }
                    function crudBack() {
<?php
$q = $this->queryString;
$q['xtype'] = 'index';
if (isset($q['key']))
    unset($q['key']);
?>
                        window.location = "?<?php echo http_build_query($q, '', '&'); ?>";
                    }
                    $(document).ready(function() {
                    	$('title').html($('h2').html());
                    });
    </script>
</div>