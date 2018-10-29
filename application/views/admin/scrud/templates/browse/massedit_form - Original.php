<?php 
$elements = $this->elements; 
$CI = & get_instance();?>
<div id="massedit_form_container">
                    <?php if (is_array($this->massedit)) { ?>
                        <?php
                        foreach ($this->massedit as $v1) {
                            if (!is_array($v1)) {
                                $field = array('field' => $v1);
                            } else {
                                $field = $v1;
                            }

                            $alias = null;
                            if (isset($field['alias'])) {
                                $alias = $field['alias'];
                            }
                            $field = $field['field'];
                            if (isset($elements[$field])) {
                                $v = $elements[$field];
                            } else {
                                $v = array('alias' => $field, 'element' => array('text', array('style' => 'width:210px;')));
                            }
                            if ($alias != null) {
                                $v['alias'] = $alias;
                            }
                            ?>
                            <div class="control-group" style="margin-bottom: 10px;">
                        <label for="crudTitle" class="control-label" style="width: 80px;">
                            <b>
                            <?php echo (!empty($v['alias'])) ? $v['alias'] : $field; ?></b>
                             </label>
                        <div class="controls" style="margin-left:100px;">

                            <?php
                                $e = $v['element'];
                                if (!empty($e) && isset($e[0])) {
                                    switch (strtolower(trim($e[0]))) {
                                        case 'textarea':
                                        case 'editor':
                                            if (isset($e[1]['style'])) {
                                                unset($e[1]['style']);
                                            }
                                        case 'image':
                                        case 'file':
                                        case 'text':
                                            $attributes = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                            }
                                            echo __text('data.' . $field, $attributes);
                                            break;
                                        case 'date':
                                        	$attributes = array();
                                        	$attributes['style'] = "width:180px;";
                                        	if (isset($e[1]) && !empty($e[1])) {
                                        		$attributes = $e[1];
                                        	}
                                        	echo __date('data.' . $field, $attributes);
                                        	break;
                                        case 'datetime':
                                        	$attributes = array();
                                        	$attributes['style'] = "width:180px;";
                                        	if (isset($e[1]) && !empty($e[1])) {
                                        		$attributes = $e[1];
                                        	}
                                        	echo __datetime('data.' . $field, $attributes);
                                        	break;
                                        case 'radio':
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
                                            $attributes = array();
                                            if (isset($e[2]) && !empty($e[2])) {
                                                $attributes = $e[2];
                                            }
                                            $options['$$__src_r_all_value__$$'] = 'All';
                                            echo __radio('data.' . $field, $options, $attributes);
                                            break;
                                        case 'checkbox':
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
                                            } else {
                                                $e[1] = array(1 => 'Yes');
                                                $options = $e[1];
                                            }
                                            $attributes = array();
                                            if (isset($e[2]) && !empty($e[2])) {
                                                $attributes = $e[2];
                                            }
                                            echo __checkbox('data.' . $field, $options, $attributes);
                                            break;
                                        case 'password':
                                            $attributes = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            echo __password('data.' . $field, $attributes);
                                            break;
                                        case 'file':
                                            $attributes = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            echo __file('data.' . $field, $attributes);
                                            break;
                                        case 'autocomplete':
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
                                        	$attributes = array();
                                        	if (isset($e[2]) && !empty($e[2])) {
                                        		$attributes = $e[2];
                                        	}
                                        	echo __autocomplete('data.' . $field, $options, $attributes);
                                        	break;
                                        case 'select':
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
                                            $attributes = array();
                                            if (isset($e[2]) && !empty($e[2])) {
                                                $attributes = $e[2];
                                            }
                                            echo __select('data.' . $field, $options, $attributes);
                                            break;
                                    }
                                }
                                ?>
                 </div>
                     </div>
                <?php
            }
        } else if ($this->search == 'one_field') {
            ?>
                    <?php
                    $attributes = array();
                    echo __text('data.one_field', $attributes);
                    ?>
        <?php } ?>
</div>
