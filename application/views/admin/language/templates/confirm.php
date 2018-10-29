<?php $CI = & get_instance(); 
$key = $CI->input->post('key');
$lang = $CI->lang; ?>



<div class="portlet light bordered">

    
        <div class="portlet-title" >
                    <div class="pull-left">
             
                <a href="<?php echo base_url(); ?>index.php/admin/component/builder" class="btn btn-sm green"> <?php echo $CI->lang->line('components'); ?> </a>
                <a href="<?php echo base_url(); ?>index.php/admin/component/groups" class="btn btn-sm green"> <?php echo $CI->lang->line('group_component'); ?> </a>
                <a href="<?php echo base_url(); ?>index.php/admin/table/index" class="btn btn-sm green"><?php echo $CI->lang->line('table_builder'); ?></a>
                <a href="<?php echo base_url(); ?>index.php/admin/language/index" class="btn btn-sm green"> <?php echo $CI->lang->line('language_manager'); ?> </a>


               
            
        </div>
            <div class="pull-right">
                <div class="btn-group">
                    <a class="btn"  onclick="crudBack();">   <i class="icon-arrow-left"></i>  <?php echo $lang->line('back'); ?>  &nbsp; </a>
                <a class="btn btn-info" onclick="crudUpdate();" > &nbsp;  <i class="icon-ok icon-white"></i>  <?php echo $lang->line('save'); ?> &nbsp; </a>
                </div>
            </div>
                
        </div>


<div class="portlet-body">
<div class='x-table well <?php echo $this->conf['color']; ?>' style="background:#FBFBFB;">
    <form method="post" action="" id="crudForm" <?php if ($this->frmType == '2') { ?>class="form-horizontal"<?php } ?>>
        <input type="hidden" name="auth_token" id="auth_token" value="<?php echo $this->getToken(); ?>"/>
        <?php
        $elements = $this->form;
        foreach ($this->primaryKey as $f) {
            $ary = explode('.', $f);
            if (isset($key[$ary[0]][$ary[1]])) {
                echo __hidden('key.' . $f);
            }
        }
        ?>
        <?php if (!empty($elements)) { ?>
                <?php
                foreach ($elements as $field => $v) {
                    if (empty($v['element']))
                        continue;
                    ?>
                    	<div class="control-group">
                            <label for="crudTitle"	class="control-label"><b><?php echo (!empty($v['alias'])) ? $v['alias'] : $field; ?></b></label>
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
                                echo __hidden('data.' . $field);
                                switch ($elements[0]) {
                                    case 'image':
                                    case 'editor':
                                        echo __value('data.' . $field, $elements);
                                        break;
                                    case 'file':
                                        $value = __value('data.' . $field);
                                        if (file_exists(FCPATH.'/media/files/'.$value)){
                                                    echo '<a href="'.base_url().'index.php/admin/download?file='.$value.'">'.$value.'</a>';
                                                }else{
                                                    echo $value;
                                                }
                                        break;
                                    case 'textarea':
                                        echo nl2br(htmlspecialchars(__value('data.' . $field, $elements)));
                                        break;
                                    case 'password':
                                        echo '******';
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
            }
            ?>
        
    </form>
    <script>
                    function crudBack() {
<?php
$q = $this->queryString;
$q['xtype'] = 'form';
if (isset($q['xid']))
    unset($q['xid']);
?>
                        $('#crudForm').attr({action: '?<?php echo http_build_query($q, '', '&'); ?>'});
                        $('#crudForm').submit();
                    }
                    function crudUpdate() {
<?php
$q = $this->queryString;
$q['xtype'] = 'update';
if (isset($q['xid']))
    unset($q['xid']);
?>
                        $('#crudForm').attr({action: '?<?php echo http_build_query($q, '', '&'); ?>'});
                        $('#crudForm').submit();
                    }
                    $(document).ready(function() {
                    	$('title').html($('h2').html());
                    });
    </script>
</div>