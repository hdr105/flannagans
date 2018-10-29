<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Report</title>

    <style type="text/css">

    ::selection{ background-color: #E13300; color: white; }
    ::moz-selection{ background-color: #E13300; color: white; }
    ::webkit-selection{ background-color: #E13300; color: white; }

    body {
        background-color: #fff;
        font-size: 9pt;
        margin-top:300px;
        color: #4F5155;
        font-family: "Arial";
    }
    .col-md-6{
        width:50%;
        padding:10px 15px;
    }
    .col-md-12{
        width:100%;
    }
    th, td {
        border: 1px solid #ddd;
    }
    th {
        background-color: #32c5d2;
        color: white;
        padding: 5px 15px;
        text-align:left;
        border-radius: 5px;
    }
    h3{
        font-weight:normal;
    }
    .form-horizontal .control-label{
        text-align: left;
        font-weight: bold;
        padding-bottom: 5px;
    }
    .clear{clear: both;}
    @page {
        background: url("<?=base_url()?>media/images/flannagans2i.jpg") center  no-repeat; background-size:cover;
        margin-top: 150px;
        margin-left: 60px;
        margin-bottom: 100px;
        margin-right: 80px;
    }
    table {
        border-collapse: collapse;
        margin-bottom:10px;
        width:100%;
    }
    </style>
</head>
<body>
	<?php $CI = & get_instance();?>
    <h2 class="page-header"> <?=$rname?> </h2>
    <table class="table table-striped table-bordered table-hover table-condensed flip-content" >
		<!-- <?php
			if (!empty($fields_lbs)) {
				?>
					<tr>
						<?php
							foreach ($fields_lbs as $lk => $lv) {
								echo '<th>' . $lv . '</th>';
							}
						?>	
					</tr>
				<?php
			}


			if (!empty($data)) {
				foreach ($data as $dk => $dv) {
					echo '<tr>';
					foreach ($dv as $key => $value) {
						echo '<td>' . $value . '</td>';
					}
					echo '</tr>';
				}
			}
		?> -->
		<?php if(!empty($rm)){
            $this->results = $data;
            $this->form=$rm;
            $this->fields=array();
            foreach($selected_fileds_for_report as $kk => $vv){
                $tempp=explode("|",$vv);
                $this->fields[]=$tempp[0];
            }

            //echo "<pre>";print_r($this->results);exit;
        }?>
        <?php if (!empty($this->results)) {
        $s = array();
       
        $formFields = array();
        foreach ($this->form as $key => $value) {
            foreach ($value['section_fields'] as $key => $value) {
                $formFields[$key] = $value;
                //echo "<pre>";print_r($value);
            }
        }
       //exit;

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
//echo "y<br/>n";print_r($__value);
            if (isset($formFields[$field]) && isset($formFields[$field]['element'][0])) {
                // echo "working";exit;

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
                                    //echo "<pre>";print_r($rs);exit;///////////////////

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
        //echo "<pre>";print_r($r);exit;
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
                        echo "something: ";print_r($formFields[$field]['element'][0]);exit;
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
                                // if (($comId==41 or $comId==42 or $comId==43 or $comId==44 or $comId==45) and $field == 'business.title'){

                                //     $__value = '<a href="javascript:void();" onclick="BusinessSummaryModal('.$b_id.');">' .  $__value . '</a>';

                                //     echo $__value;
                                // }
                                // else
                                // {
                                    echo nl2br(htmlspecialchars($__value));
                                //}

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
                
               
            </td>
        <?php } ?>
        </tr>
        <?php } ?>
    <?php } ?>
////////////////////////////
	</table>
</body>
</html>						