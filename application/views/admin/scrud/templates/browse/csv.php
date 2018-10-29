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
$csv = array();
$aryHeader = array();
$aryAlias = array();

////////////////exclude table columns fcrom CSV///////////////////////////
$exclude = array($this->conf['table'].'.id', $this->conf['table'].'.site_id',$this->conf['table'].'.created_by',$this->conf['table'].'.modified_by',$this->conf['table'].'.created',$this->conf['table'].'.modified',$this->conf['table'].'.eventsfor',$this->conf['table'].'.contactno');
foreach($exclude as $excval){
    unset($this->fields[array_search($excval,$this->fields)]);
}
//////////////////////////////////////////////////////////////////////////

foreach ($fields as $field) {
    if (!in_array($field, $this->fields))
        continue;
    $aryHeader[] = $field;
    if (!array_key_exists($field, $this->fieldsAlias)) {
        $__aryField = explode('.', $field);
        $aryAlias[] = ucwords(str_replace('_', ' ', $__aryField[1]));
    } else {
        $aryAlias[] = $this->fieldsAlias[$field];
    }
}
$csv[] = $aryAlias;

if (!empty($this->results)) {
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




        $tmp = array();
        foreach ($aryHeader as $field) { 
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
            if (!isset($formFields[$field])) {
                $formFields[$field]['element'][0] = '';
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
                                    $values_as_string[] = $formFields[$field]['element'][1][$value];
                                }
                              
                           }
                           $tmp[] = implode(',', $values_as_string);

                        }else if (isset($formFields[$field]['element'][1]) &&
                                !empty($formFields[$field]['element'][1]) &&
                                is_array($formFields[$field]['element'][1]) &&
                                !empty($formFields[$field]['element'][1][$__value])) {
                            $tmp[] = $formFields[$field]['element'][1][$__value];
                        }else
                            $tmp[]=' ';
                        break;
                    case 'editor':
                        $tmp[] = $__value;
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
                        $tmp[] = htmlspecialchars($value);
                        break;
                    case 'currency':
                        $_curt = new ScrudDao('currencies', $this->da);
                        $cpt = array();
                        $cpt['conditions'] = array('currency_status="3"');
                        $cpt_res = $_curt->find($cpt);

                        $tmp[] = $cpt_res[0]['currency_symbol'].' '.$__value;
                        break;
                    case 'textarea':
                        $tmp[] = $__value;
                        break;
                    case 'file':
                    if (file_exists(FCPATH . '/media/files/' . $__value)) {
                        $tmp[] = '<a href="' . base_url() . 'index.php/admin/download?file=' . $__value . '">' . $__value . '</a>';
                    } else {
                        $tmp[] = $__value;
                    }
                    break;
                    case 'image':
                        if (file_exists(__IMAGE_UPLOAD_REAL_PATH__ . '/thumbnail_' . $__value)) {
                            $tmp[] = "<img src='" . __MEDIA_PATH__ . "images/thumbnail_" . $__value . "' />";
                        } else if (__IMAGE_UPLOAD_REAL_PATH__ . '/mini_thumbnail_' . $__value) {
                            $tmp[] = "<img src='" . __MEDIA_PATH__ . "images/mini_thumbnail_" . $__value . "' />";
                        } else {
                            $tmp[] = '';
                        }
                        break;
                    case 'date':
                        if (is_date($__value)){
                            $tmp[] = date($date_format_convert[__DATE_FORMAT__],strtotime($__value));
                        }else{
                                $tmp[] = '';
                            }
                            break;
                    case 'datetime':
                        if (is_date($__value)){
                            $tmp[] = date($date_format_convert[__DATE_FORMAT__].' H:i:s',strtotime($__value));
                        }else{
                                $tmp[] = '';
                            }
                            break;
                    default:
                        $tmp[] = $__value;
                        break;
                }
            } else {
                $tmp[] = $__value;
            }
        }
        $csv[] = $tmp;
    }

}

$content='';
foreach ($csv as $v) {
    $content.= arrayToCsv($v) . "\n";
}

header("Content-type: text/csv");
header('Content-Length: ' + strlen($content) + 3);
header("Content-Disposition: attachment; filename=" . $_GET['table'] . "-" . date("YmdHis") . ".csv");
header("Pragma: no-cache");
header("Expires: 0");
echo "\xef\xbb\xbf";
echo $content;