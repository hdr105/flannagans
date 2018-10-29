<?php

/**
 *
 * @param $fieldName
 * @param $options
 */

//CURRENCY START 
function __currency($fieldName, $attributes = array()) {
    $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    
    $html = '<div class="input-icon"><i class="fa">'.$attributes['currency_symbol'].'</i><input type="text" class="form-control" name="' . $name . '" id="' . $id . '" ' . $strAttr . '></div>';
    
    return $html;
}
//CURRENCY END

//TIME ZONE CODE HERE
  function generate_timezone_list()
{
    static $regions = array(
        DateTimeZone::AFRICA,
        DateTimeZone::AMERICA,
        DateTimeZone::ANTARCTICA,
        DateTimeZone::ASIA,
        DateTimeZone::ATLANTIC,
        DateTimeZone::AUSTRALIA,
        DateTimeZone::EUROPE,
        DateTimeZone::INDIAN,
        DateTimeZone::PACIFIC,
    );

    $timezones = array();
    foreach( $regions as $region )
    {
        $timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
    }

    $timezone_offsets = array();
    foreach( $timezones as $timezone )
    {
        $tz = new DateTimeZone($timezone);
        $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
    }

    // sort timezone by offset
    asort($timezone_offsets);

    $timezone_list = array();
    foreach( $timezone_offsets as $timezone => $offset )
    {
        $offset_prefix = $offset < 0 ? '-' : '+';
        $offset_formatted = gmdate( 'H:i', abs($offset) );

        $pretty_offset = "GMT${offset_prefix}${offset_formatted}";

        $timezone_list[$timezone] = "(${pretty_offset}) $timezone";
    }

    return $timezone_list;
}

function __timezone($fieldName, $attributes = array()) {
 $arr = generate_timezone_list();
 $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    
    
    //$html = '<input type="text" class="form-control" name="' . $name . '" id="' . $id . '" ' . $strAttr . ' />';
 $html = "";
 $html .= '<select class="form-control" style="min-width: 230px; max-width:250px;" name="' . $name . '" id="' . $id . '" ' . $strAttr . '>';
  foreach( $arr as $key => $value){ 
  if($v==$key){
   $html .= '<option value="'.$key.'" selected>'.$value.'</option>';
  }else {
   $html .= '<option value="'.$key.'">'.$value.'</option>';
  }
  }
 $html .= '</select>';
 $html .= '<script>jQuery(document).ready(function() {$("#'.$id.'").select2({
           
            allowClear: true
        });});</script>';
    return $html;
}
//TIME ZONE CODE HERE

//Time
function __time($fieldName, $attributes = array()) {
    $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    
    $html = '                                            <div class="input-group input-medium date">
                                                <input type="text" class="form-control timepicker timepicker-no-seconds" readonly name="' . $name . '" id="' . $id . '" ' . $strAttr . '>
                                                <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
                                                </span>
                                            </div>';
    
    //$html = '<input type="text" class="form-control" name="' . $name . '" id="' . $id . '" ' . $strAttr . ' />';
    /*$html = '<div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" id="' . $id . '">
                <input type="text" class="form-control" readonly name="' . $name . '" ' . $strAttr . '   />
                <span class="input-group-btn">
                <button class="btn default" type="button">
                <i class="fa fa-calendar"></i>
                </button>
                </span>
              </div>';*/
    return $html;
}
//Time
function __multiple_add($fieldName, $attributes = array()){
    $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    $html = '<input type="text" class="form-control" name="' . $name . '" id="' . $id . '" ' . $strAttr . ' /><a id="btn_' . $id . '" >Add more</a>
        <script>
$("#btn_' . $id . '").click(function(){
    alert($("#' . $id . '").val());
});

</script>
    ';

    return $html;
}
/*function __related_module($fieldName, $attributes = array()){
    $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    $html = '<input type="text" class="form-control" name="' . $name . '" id="' . $id . '" ' . $strAttr . ' />';


    $html = '<!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet box red">
                                <div class="portlet-title">
                                    <div class="caption">
                                        Table </div>
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-default btn-sm">
                                            <i class="fa fa-plus"></i> Add </a>
                                        <a href="javascript:;" class="btn btn-default btn-sm">
                                            <i class="fa fa-print"></i> Print </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_3">
                                        <thead>
                                            <tr>
                                                <th class="table-checkbox">
                                                    <input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes" /> </th>
                                                <th> Username </th>
                                                <th> Email </th>
                                                <th> Status </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="odd gradeX">
                                                <td>
                                                    <input type="checkbox" class="checkboxes" value="1" /> </td>
                                                <td> shuxer </td>
                                                <td>
                                                    <a href="mailto:shuxer@gmail.com"> shuxer@gmail.com </a>
                                                </td>
                                                <td>
                                                    <span class="label label-sm label-success"> Approved </span>
                                                </td>
                                            </tr>
                                            
                                            <tr class="odd gradeX">
                                                <td>
                                                    <input type="checkbox" class="checkboxes" value="1" /> </td>
                                                <td> coop </td>
                                                <td>
                                                    <a href="mailto:userwow@gmail.com"> good@gmail.com </a>
                                                </td>
                                                <td>
                                                    <span class="label label-sm label-success"> Approved </span>
                                                </td>
                                            </tr>
                                            <tr class="odd gradeX">
                                                <td>
                                                    <input type="checkbox" class="checkboxes" value="1" /> </td>
                                                <td> pppol </td>
                                                <td>
                                                    <a href="mailto:userwow@gmail.com"> good@gmail.com </a>
                                                </td>
                                                <td>
                                                    <span class="label label-sm label-success"> Approved </span>
                                                </td>
                                            </tr>
                                            <tr class="odd gradeX">
                                                <td>
                                                    <input type="checkbox" class="checkboxes" value="1" /> </td>
                                                <td> test </td>
                                                <td>
                                                    <a href="mailto:userwow@gmail.com"> test@gmail.com </a>
                                                </td>
                                                <td>
                                                    <span class="label label-sm label-success"> Approved </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->';

    return $html;
}*/
function __text($fieldName, $attributes = array()) {
    $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    $html = '<input type="text" class="form-control" name="' . $name . '" id="' . $id . '" ' . $strAttr . ' />';

    return $html;
}

/**
 *
 * @param $fieldName
 * @param $options
 */
function __image($fieldName, $attributes = array()) {
    $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $fname = '';
    $fid = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $fid = 'img_' . $fieldName;
        $name = $fieldName;
        $fname = 'img_' . $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
                $fname = 'img_' . $v;
                $fid = 'img_' . $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);

                $fname .= '[' . $v . ']';
                $fid .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            if ($k == 'thumbnail')
                continue;
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }  
    $html = '
                 <input class="form-control" type="file" name="' . $fname . '" id="' . $fid . '" ' . $strAttr . '/>
                 <input class="form-control" type="hidden" name="' . $name . '" id="' . $id . '" ' . $strAttr . '/>
                     
                 <input id="f_text_' . $id . '" class="input disabled form-control" readonly=" readonly" type="text"> 
		 <input class="btn" value="Choose..."  type="button" id="f_button_' . $id . '">
			
<script>
$("#f_button_' . $id . '").click(function(){
    $("#' . $fid . '").trigger("click");
});
$("#' . $fid . '").change(function(){
    $("#f_text_' . $id . '").val($(this).val());
});
</script>
                ';
    if (!empty($attributes['value']) && is_file(FCPATH . '/media/images/' . $attributes['value'])) {
        if (file_exists(__IMAGE_UPLOAD_REAL_PATH__.'/thumbnail_'. $attributes['value'])) {
            $imgFile = __MEDIA_PATH__ . "images/thumbnail_" . $attributes['value'];
        }else{
            $imgFile = __MEDIA_PATH__ . "images/mini_thumbnail_" . $attributes['value'];
        }
        $html .= " <div style='display:inline-block;'><img src='" . $imgFile . "' />
            <input type='button' class='btn btn-mini btn-danger' value='delete' id='del_img_btn_" . $id . "' style='vertical-align: bottom;' /></div>
";
        $queryString = '';
        if (!empty($_SERVER['QUERY_STRING'])) {
            parse_str($_SERVER['QUERY_STRING'], $queryString);
        }
        $q = $queryString;
        unset($q['wp']);
        $q['xtype'] = 'delFile';
        $html .= "
<script>
    $('#del_img_btn_" . $id . "').click(function(){
        var delBtn = this;
        $.post('" . base_url() . "index.php/admin/scrud/delfile?fileType=img&table=" . $_GET['table'] . "&" . http_build_query($q, '', '&') . "',{src:{file:'" . $attributes['value'] . "',field:'" . $fieldName . "'}},function(){
            $(delBtn).parent().remove();
            $('#" . $id . "').val('');
        });
    });
</script>
";
    }

    return $html;
}

/*function __date($fieldName, $attributes = array()) {
    $CI = & get_instance();
    global $date_format_convert;
    $strAttr = '';
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
    	if (isset($attributes['value'])){
    		if (is_date($attributes['value'])){
    			if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
    				$attributes['value'] = str_replace('/','-',$attributes['value']);
    			}
    			$attributes['value'] = str2mysqltime($attributes['value'],'Y-m-d');
    			$attributes['value'] = date($date_format_convert[__DATE_FORMAT__],strtotime($attributes['value']));
    		}else{
    			$attributes['value'] = '';
    		}
    	}
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    
    $html = '<div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" id="' . $id . '">
				<input type="text" class="form-control" readonly name="' . $name . '" ' . $strAttr . '   />
				<span class="input-group-btn">
                <button class="btn default" type="button">
                <i class="fa fa-calendar"></i>
                </button>
                </span>
			  </div>';

    return $html;
}*/

function __date($fieldName, $attributes = array()) {
    $CI = & get_instance();
    global $date_format_convert;
    $strAttr = '';
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        if (isset($attributes['value'])){
            if (is_date($attributes['value'])){
                if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
                    $attributes['value'] = str_replace('/','-',$attributes['value']);
                }
                $attributes['value'] = str2mysqltime($attributes['value'],'Y-m-d');
                $attributes['value'] = date($date_format_convert[__DATE_FORMAT__],strtotime($attributes['value']));
            }else{
                $attributes['value'] = '';
            }
        }
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    
    $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH');
    $query = $CI->db->get_where('calendar_types',array('assigned_to'=>$CRUD_AUTH['id']))->result_array();
    
    $html = '';
    $calendar_type = '';
    $field = '';
    if(isset($_GET['key'])){
        $module_data = $CI->db->get_where('crud_components',array('id'=>$_GET['com_id']))->result_array(); 
        $id_data = $module_data[0]['component_table'].'.id';
        $dataforedit = $_GET['key'][$id_data];
        $entry_data = $CI->db->get_where($module_data[0]['component_table'],array('id'=>$dataforedit))->result_array(); 
        $explo = explode(',',$entry_data[0]['eventsfor']);
            foreach($explo as $val){
                if(!empty($val)){
                    $exploded_data = explode('|',$val);
                    $field = "data[".$module_data[0]["component_table"]."][".$exploded_data[0]."]";
                    $calendar_type = $CI->db->get_where('calendar',array('id'=>$exploded_data[1]))->result_array();
                    $calendar = $calendar_type[0]['eventstatus'];
                }
            }
            
            if($field == $name){
                $html = '
                <div class="row">
                        <div class="col1">
                            <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" id="' . $id . '">
                                <input type="text" class="form-control" readonly name="' . $name . '" ' . $strAttr . '   />
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col2">
                            <div class="input-group">
                                Add To Calendar
                                <input type="checkbox" name="calendar_' . $name . '" checked="checked">
                                <select name="calander_for_' . $name . '">'; ?>
                                    <?php foreach($query as $option){
                                        if($calendar == $option['id']){ 
                                            $html .= '<option value="'.$option['id'].'" selected="selected">'.$option['name'].'</option>';
                                        }else{
                                            $html .= '<option value="'.$option['id'].'">'.$option['name'].'</option>';
                                        }
                                    ?>
                                    <?php } 
                                $html .= '</select>
                            </div>
                        </div>
                    </div>';
            } else {
                $html = '
                    <div class="row">
                        <div class="col1">
                            <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" id="' . $id . '">
                                <input type="text" class="form-control" readonly name="' . $name . '" ' . $strAttr . '   />
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col2">
                            <div class="input-group">
                                Add To Calendar
                                <input type="checkbox" name="calendar_' . $name . '">
                                <select name="calander_for_' . $name . '">'; ?>
                                    <?php foreach($query as $option){
                                        $html .= '<option value="'.$option['id'].'">'.$option['name'].'</option>';
                                    ?>
                                    <?php } 
                                $html .= '</select>
                            </div>
                        </div>
                    </div>';
            }       
    } else {
        
        $html = '
        <div class="row">
            <div class="col1">
                <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" id="' . $id . '">
                    <input type="text" class="form-control" readonly name="' . $name . '" ' . $strAttr . '   />
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="col2">
                <div class="input-group">
                    Add To Calendar
                    <input type="checkbox" name="calendar_' . $name . '">
                    <select name="calander_for_' . $name . '">'; ?>
                        <?php foreach($query as $option){
                            $html .= '<option value="'.$option['id'].'">'.$option['name'].'</option>';
                        ?>
                        <?php } 
                    $html .= '</select>
                </div>
            </div>
        </div>';
    }   
    return $html;
}

function __datetime($fieldName, $attributes = array()) {
	global $date_format_convert;
	$strAttr = '';
	$name = '';
	$id = '';
	$f = explode('.', trim($fieldName));
	if (count($f) == 1) {
		if (isset($_POST[$fieldName])) {
			$attributes['value'] = $_POST[$fieldName];
		}
		$id = $fieldName;
		$name = $fieldName;
	} else if (count($f) > 1) {
		$tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
		$attributes['value'] = $_POST;
		foreach ($f as $k => $v) {
			if ($k == 0) {
				$name = $v;
				$id = $v;
			} else {
				$name .= '[' . $v . ']';
				$id .= ucfirst($v);
			}
		}
		foreach ($f as $k => $v) {
			if (isset($attributes['value'][$v])) {
				$attributes['value'] = $attributes['value'][$v];
			} else {
				if (empty($tmpValue)) {
					unset($attributes['value']);
				} else {
					$attributes['value'] = $tmpValue;
				}
				break;
			}
		}
	}
	if (!empty($attributes)) {
		if (isset($attributes['value'])){
			if (is_date($attributes['value'])){
				if (__DATE_FORMAT__ == 'dd/MM/yyyy'){
					$attributes['value'] = str_replace('/','-',$attributes['value']);
				}
				$attributes['value'] = str2mysqltime($attributes['value']);
				$attributes['value'] = date($date_format_convert[__DATE_FORMAT__].' H:i:s',strtotime($attributes['value']));
			}else{
				$attributes['value'] = '';
			}
		}
		foreach ($attributes as $k => $v) {
			$strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
		}
	}
	$html = '<div class="input-append date" id="' . $id . '">
				<input type="text"  name="' . $name . '" ' . $strAttr . '  data-format="'.__DATE_FORMAT__.' hh:mm:ss" />
				<span class="add-on"><i class="icon-calendar"></i></span>
			  </div>
<script>
$(document).ready(function(){
   	$(\'#' . $id . '\').datetimepicker();
});
</script>';

	return $html;
}

/**
 *
 * @param $fieldName
 * @param $options
 * @param $attributes
 */
function __radio($fieldName, $options = array(), $attributes = array()) {
    $CI = & get_instance();
    $html = '';
    $strAttr = '';
    $value = null;
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (isset($attributes['value'])) {
        $value = $attributes['value'];
        unset($attributes['value']);
    }
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }

    foreach ($options as $k => $v) {
        if ($value == $k && $value != "") {
            $html .= '<div class="radio-list"><label class="radio-inline" style="margin-bottom:9px;">';
            $html .= '<input name="' . $name . '" id="' . $id . ucfirst($k) . '" value="' . htmlspecialchars($k) . '" type="radio" checked="checked" ' . $strAttr . '>';
            $html .= htmlspecialchars($v);
            $html .= '</label></div>';
        } else {
            $html .= '<div class="radio-list"><label class="radio-inline" style="margin-bottom:9px;">';
            $html .= '<input name="' . $name . '" id="' . $id . ucfirst($k) . '" value="' . htmlspecialchars($k) . '" type="radio" ' . $strAttr . '>';
            $html .= htmlspecialchars($v);
            $html .= '</label></div>';
        }
    }

    return $html;
}

/**
 *
 * @param $fieldName
 * @param $options
 */
function __checkbox($fieldName, $options = array(), $attributes = array()) {
    $CI = & get_instance();
    $html = '';
    $strAttr = '';
    $value = null;
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (isset($attributes['value'])) {
        $value = $attributes['value'];
        unset($attributes['value']);
    }
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    if (!is_array($value)) {
        $value = explode(',', $value);
    }
    $tmp = array();
    foreach ($value as $v) {
        if (!empty($v)) {
            $tmp[] = $v;
        }
    }
    $value = $tmp;
    foreach ($options as $k => $v) {
        if (in_array($k, $value)) {
            $html .= '<label class="checkbox inline" style="margin-bottom:9px;">';
            $html .= '<input name="' . $name . '[' . $k . ']" id="' . $id . ucfirst($k) . '" value="' . htmlspecialchars($k) . '" type="checkbox" checked="checked" ' . $strAttr . '>';
            $html .= htmlspecialchars($v);
            $html .= '</label>';
        } else {
            $html .= '<label class="checkbox inline" style="margin-bottom:9px;">';
            $html .= '<input name="' . $name . '[' . $k . ']" id="' . $id . ucfirst($k) . '" value="' . htmlspecialchars($k) . '" type="checkbox" ' . $strAttr . '>';
            $html .= htmlspecialchars($v);
            $html .= '</label>';
        }
    }

    return $html;
}

/**
 *
 * @param $fieldName
 * @param $attributes
 */
function __password($fieldName, $attributes = array()) {
    $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            if (strtolower(trim($k)) == 'value')
                continue;
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    $html = '<input class="form-control" type="password" name="' . $name . '" id="' . $id . '" ' . $strAttr . ' />';

    return $html;
}

/**
 *
 * @param $fieldName
 * @param $attributes
 */
function __hidden($fieldName, $attributes = array()) {
    $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        
        foreach ($attributes as $k => $v) {
            if (is_array($v)) {
                $v = ',' . implode(",", $v) . ',';
            }
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    $html = '<input type="hidden" name="' . $name . '" id="' . $id . '" ' . $strAttr . ' />';

    return $html;
}
/*function __hidden($fieldName, $attributes = array()) {
    $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            if (is_array($v)) {
                $v = ',' . implode(",", $v) . ',';
            }
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    $html = '<input type="hidden" name="' . $name . '" id="' . $id . '" ' . $strAttr . ' />';

    return $html;
}*/

/**
 *
 * @param $fieldName
 * @param $attributes
 */
function __file($fieldName, $attributes = array()) {
    $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $fname = '';
    $fid = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $fid = 'file_' . $fieldName;
        $name = $fieldName;
        $fname = 'file_' . $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
                $fname = 'file_' . $v;
                $fid = 'file_' . $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);

                $fname .= '[' . $v . ']';
                $fid .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    $html = '
                 <input type="file" name="' . $fname . '" id="' . $fid . '" ' . $strAttr . '/>
                 <input type="hidden" name="' . $name . '" id="' . $id . '" ' . $strAttr . '/>
                     
                 <input id="f_text_' . $id . '" class="input disabled" readonly="readonly" type="text"> 
		 <input class="btn" value="Choose..."  type="button" id="f_button_' . $id . '">
			
<script>
$("#f_button_' . $id . '").click(function(){
    $("#' . $fid . '").trigger("click");
});
$("#' . $fid . '").change(function(){
    $("#f_text_' . $id . '").val($(this).val());
});
</script>
                ';
    if (!empty($attributes['value']) && is_file(FCPATH . '/media/files/' . $attributes['value'])) {
        $html .= " <div style='display:inline-block;'>
            <span><a href='".base_url()."index.php/admin/download?file=" . $attributes['value'] . "'>" . $attributes['value'] . "</a></span>
            <input type='button' class='btn btn-mini btn-danger' value='delete' id='del_file_btn_" . $id . "' style='vertical-align: bottom;' /></div>
";
        $queryString = '';
        if (!empty($_SERVER['QUERY_STRING'])) {
            parse_str($_SERVER['QUERY_STRING'], $queryString);
        }
        $q = $queryString;
        unset($q['wp']);
        $q['xtype'] = 'delFile';
        $html .= "
<script>
    $('#del_file_btn_" . $id . "').click(function(){
        var delBtn = this;
        $.post('" . base_url() . "index.php/admin/scrud/delfile?table=" . $_GET['table'] . "&" . http_build_query($q, '', '&') . "',{src:{file:'" . $attributes['value'] . "',field:'" . $fieldName . "'}},function(){
            $(delBtn).parent().remove();
            $('#" . $id . "').val('');
        });
    });
</script>
";
    }

    return $html;
}

/**
 *
 * @param $attributes
 */
function __button($attributes = array()) {
    $CI = & get_instance();
    $strAttr = '';
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    $html = '<input type="button" ' . $strAttr . ' />';

    return $html;
}

/**
 *
 * @param $attributes
 */
function __submit($attributes = array()) {
    $CI = & get_instance();
    $strAttr = '';
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    $html = '<input type="submit" ' . $strAttr . ' />';

    return $html;
}

/**
 *
 * @param $attributes
 */
function __textarea($fieldName, $attributes = array()) {
    $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $value = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        $value = '';
        if (!empty($attributes['value'])) {
            $value = $attributes['value'];
        }
        unset($attributes['value']);
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    $html = '<textarea class="form-control" name="' . $name . '" id="' . $id . '" ' . $strAttr . ' >' . htmlspecialchars($value) . '</textarea>';

    return $html;
}

function __editor($fieldName, $attributes = array()) {
    $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        $value = '';
        if (!empty($attributes['value'])) {
            $value = $attributes['value'];
        }
        unset($attributes['value']);
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    $html = '<textarea  class="ckeditor form-control" name="' . $name . '" id="' . $id . '" ' . $strAttr . ' >' . htmlspecialchars($value) . '</textarea>';

    return $html;
}

//FUNCTION FOR RELATED MODULE START
// New function for tempalte functions
function __related_module($fieldName, $options = array() ,$attributes = array()){
    $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    $html = '<input type="text" class="form-control" name="' . $name . '" id="' . $id . '" ' . $strAttr . ' />';

    $mid = array_key_exists('module_id', $options) ? $options['module_id'] : 0;
    $jsonData = array(
            'module_id' => $mid,
            'module_name' => '',
            'module_key'=> '',
            'module_value'=> '',
            'hidden_controll' => $id,
            'visible_controll' => $id .'_v'
        );
    $html  = '<input type="hidden" name="' . $name . '" id="' . $id . '"  />';
    $html .= '<a href="javascript:;" onclick=\'insertRelatedModule('.json_encode($jsonData).');\' class="btn btn-sm blue">Add</a>&nbsp;';
    //$html .= '<a href="javascript:;" onclick=\'insertRelated('.json_encode($jsonData).');\' class="btn btn-sm blue">Add</a>&nbsp;';
    //$html .= '<a href="javascript:;" onclick=\'summaryView('.json_encode($jsonData).');\' class="btn btn-sm green">Select</a>';

//TABLE START
    if(isset($_POST)){
        $alldata = $CI->input->post('data');
        $data_field = explode('.',$fieldName);
        //print_r($data_field);
        $table_entity = explode(',',$alldata[$data_field[1]][$data_field[2]]);
        //print_r($table_entity);  
        foreach($table_entity as $table_ent){
            if($table_ent!=''){
                $hidden = "data".$data_field[1].$data_field[2];
                $visible = "data".$data_field[1].$data_field[2]."_v";
                $json[] = array(
                    'module_id' => $mid,
                    'module_name' => '',
                    'selected_id' => $table_ent,
                    'module_key'=> '',
                    'module_value'=> '',
                    'hidden_controll' => $id,
                    'visible_controll' => $id .'_v'
                );
            }
        }
    } else {
        $json[] = '';
    }
     if(isset($json)){
    $html .= '<script>
            $(document).ready(function(){ selectedRecordArray('.json_encode($json).'); }); </script>';
    }
 //TABLE END
    $divContainer = '<!-- BEGIN EXAMPLE TABLE PORTLET-->
            <p>&nbsp;</p>
            <div  id="' . $id . '_v">
               
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->';
    $html .= $divContainer;

    return $html;
}
//FUNCTION FOR RELATED MODULE END

function __related_module_view($fieldName, $options = array() ,$attributes = array()){
    $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    $html = '<input type="text" class="form-control" name="' . $name . '" id="' . $id . '" ' . $strAttr . ' />';

    $mid = array_key_exists('module_id', $options) ? $options['module_id'] : 0;
    $jsonData = array(
            'module_id' => $mid,
            'module_name' => '',
            'module_key'=> '',
            'module_value'=> '',
            'hidden_controll' => $id,
            'visible_controll' => $id .'_v'
        );
    $html  = '<input type="hidden" name="' . $name . '" id="' . $id . '"  />';
    //$html .= '<a href="javascript:;" onclick=\'insertRelatedModule('.json_encode($jsonData).');\' class="btn btn-sm blue">Add</a>&nbsp;';
    //$html .= '<a href="javascript:;" onclick=\'insertRelated('.json_encode($jsonData).');\' class="btn btn-sm blue">Add</a>&nbsp;';
    //$html .= '<a href="javascript:;" onclick=\'summaryView('.json_encode($jsonData).');\' class="btn btn-sm green">Select</a>';

//TABLE START
    if(isset($_POST)){
        $alldata = $CI->input->post('data');
        $data_field = explode('.',$fieldName);
        //print_r($data_field);
        $table_entity = explode(',',$alldata[$data_field[1]][$data_field[2]]);
        //print_r($table_entity);  
        foreach($table_entity as $table_ent){
            if($table_ent!=''){
                $hidden = "data".$data_field[1].$data_field[2];
                $visible = "data".$data_field[1].$data_field[2]."_v";
                $json[] = array(
                    'module_id' => $mid,
                    'module_name' => '',
                    'selected_id' => $table_ent,
                    'module_key'=> '',
                    'module_value'=> '',
                    'hidden_controll' => $id,
                    'visible_controll' => $id .'_v'
                );
            }
        }
    } else {
        $json[] = '';
    }
     if(isset($json)){
    $html .= '<script>
            $(document).ready(function(){ selectedRecordArray('.json_encode($json).'); }); </script>';
    }
 //TABLE END
    $divContainer = '<!-- BEGIN EXAMPLE TABLE PORTLET-->
            <p>&nbsp;</p>
            <div  id="' . $id . '_v">
               
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->';
    $html .= $divContainer;

    return $html;
}
//FUNCTION FOR RELATED MODULE END

function __comments($fieldName, $attributes = array()) {
    $CI = & get_instance();
    $strAttr = '';
    $name = '';
    $id = '';
    $value = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    if (!empty($attributes)) {
        $value = '';
        if (!empty($attributes['value'])) {
            $value = $attributes['value'];
        }
        unset($attributes['value']);
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    
    $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH');
    $user_id = $CRUD_AUTH['id'];
    $com_id = $_GET['com_id'];
    $control_id = $id;
    
    if(isset($_POST['data'])){
  $record_id = $_POST['data'][key($_POST['key'])]['id'];
 } else {
  $record_id = '';
 }
 
 $datatojs = array(
                'user_id'       =>  $user_id,
                'com_id'        =>  $com_id,
                'control_id'    =>  $control_id,
                'record_id'    =>  $record_id
                );
    
    $html = '<div class="form-group">
                <div class="col-md-12">
                    <textarea class="form-control autosizeme" rows="3" placeholder="Comment here..." data-autosize-on="true" style="overflow: hidden; word-wrap: break-word; resize: horizontal;" name="' . $name . '" id="' . $id . '" ' . $strAttr . '></textarea>
                </div>
            </div>';
            
    $html .='<div class="FixedHeightContainer comments-'.$control_id.'">';
    //EXISTING COMMENTS HERE START
    $exist_comments = '';
    $result_data = $CI->db->order_by("comment_id", "desc")->get_where('comments_box', array('record_id'=>$record_id,'com_id'=>$com_id,'user_id'=>$user_id,'control_id'=>$control_id),'1');
    if($result_data->num_rows>0){
        $all_comments = $result_data->result_array();
        foreach($all_comments as $comments){
            $result_user = $CI->db->get_where('crud_users', array('id'=>$comments['user_id']))->row_array();
            $username = $result_user['user_first_name'].' '.$result_user['user_las_name'];
            $exist_comments .= '<p>'.$comments['comments'].'<br><i style="color:grey" class="pull-right">By:'.$username.' on '.date(__DATE_FORMAT_TIME__, strtotime($comments['comment_time'])).'</i></p>';
        }
    }
    $html .= $exist_comments;
    //EXISTING COMMENTS HERE END
    $html .='</div>'; 
    $html .='<div class="pull-right error_comments-'.$control_id.'"></div>'; 
    
 $html .='<p class="pull-right" onclick=\'getComments('.json_encode($datatojs).');\'>View All</p>';
    /* $html .='<div class="form-actions">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" ' . $strAttr . ' onclick=\'postComments('.json_encode($datatojs).');\' class="btn blue pull-right commnet_btn">
                            <i class="fa fa-check"></i> Submit</button>
                    </div>
                </div>
            </div>'; */
 $html .='<input type="hidden" name="control_id[]" value="'.$control_id.'-'.$name.'">';
    return $html;
}

/**
 *
 * @param $fieldName
 * @param $options
 * @param $attributes
 */
function __select($fieldName, $options = array(), $attributes = array()) {
    $CI = & get_instance();
    $multiple = '';
    $strAttr = '';
    $name = '';
    $id = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
    } else if (count($f) > 1) {
        $tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
        $attributes['value'] = $_POST;
        foreach ($f as $k => $v) {
            if ($k == 0) {
                $name = $v;
                $id = $v;
            } else {
                $name .= '[' . $v . ']';
                $id .= ucfirst($v);
            }
        }
        foreach ($f as $k => $v) {
            if (isset($attributes['value'][$v])) {
                $attributes['value'] = $attributes['value'][$v];
            } else {
                if (empty($tmpValue)) {
                    unset($attributes['value']);
                } else {
                    $attributes['value'] = $tmpValue;
                }
                break;
            }
        }
    }
    $value = '';
    if (!empty($attributes)) {
        if (!empty($attributes['value'])) {
            $value = $attributes['value'];
        }
        unset($attributes['value']);
        foreach ($attributes as $k => $v) {
            $strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
        }
    }
    $strOpt = '<option value=""></option>';
    if (array_key_exists('multiple', $attributes) && !is_array($value)){
    	$tmp = explode(',', $value);
    	$value = array();
    	foreach ($tmp as $mv){
    		if (!empty($mv)){
    			$value[] = $mv;
    		}
    	}
    }
    if (!is_array($value)){
	    foreach ($options as $k => $v) {
	        if ($value == $k && $value != "") {
	            $strOpt .= '<option value="' . htmlspecialchars($k) . '" selected="selected">' . htmlspecialchars($v) . '</option>';
	        } else {
	            $strOpt .= '<option value="' . htmlspecialchars($k) . '">' . htmlspecialchars($v) . '</option>';
	        }
	    }
    }else{
    	foreach ($options as $k => $v) {
    		if (in_array($k, $value)) {
    			$strOpt .= '<option value="' . htmlspecialchars($k) . '" selected="selected">' . htmlspecialchars($v) . '</option>';
    		} else {
    			$strOpt .= '<option value="' . htmlspecialchars($k) . '">' . htmlspecialchars($v) . '</option>';
    		}
    	}
    }
    if (array_key_exists('multiple', $attributes)){
    	$name = $name.'[]';
        $multiple = 'multiple';
    }
    
    //$html = '<select class="form-control"  name="' . $name . '" id="' . $id . '" ' . $strAttr . ' >' . $strOpt . '</select>';

$multipleClass = ($multiple == '') ? '' : '-'.$multiple;
    $html = '<select class="form-control select2'.$multipleClass.'" '.$multiple.' style="min-width: 230px; max-width:250px;" name="' . $name . '" id="' . $id . '" ' . $strAttr . ' >' . $strOpt . '</select>';

    $html .= '<script>jQuery(document).ready(function() {$("#'.$id.'").select2({
           
            allowClear: true
        });});</script>';
    return $html;
}

function __autocomplete($fieldName, $options = array(), $attributes = array()) {
	$CI = & get_instance();
	$strAttr = '';
	$name = '';
	$id = '';
	$f = explode('.', trim($fieldName));
	if (count($f) == 1) {
		$_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $attributes['value'] = $_tmpValue;
        }
        $id = $fieldName;
        $name = $fieldName;
	} else if (count($f) > 1) {
		$tmpValue = (isset($attributes['value'])) ? $attributes['value'] : null;
		$attributes['value'] = $_POST;
		foreach ($f as $k => $v) {
			if ($k == 0) {
				$name = $v;
				$id = $v;
			} else {
				$name .= '[' . $v . ']';
				$id .= ucfirst($v);
			}
		}
		foreach ($f as $k => $v) {
			if (isset($attributes['value'][$v])) {
				$attributes['value'] = $attributes['value'][$v];
			} else {
				if (empty($tmpValue)) {
					unset($attributes['value']);
				} else {
					$attributes['value'] = $tmpValue;
				}
				break;
			}
		}
	}
	$value = '';
	if (!empty($attributes)) {
		if (!empty($attributes['value'])) {
			$value = $attributes['value'];
		}
		unset($attributes['value']);
		foreach ($attributes as $k => $v) {
			$strAttr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '" ';
		}
	}
	$strOpt = '<option value="">&nbsp;</option>';
	foreach ($options as $k => $v) {
		if ($value == $k && $value != "") {
			$strOpt .= '<option value="' . htmlspecialchars($k) . '" selected="selected">' . htmlspecialchars($v) . '</option>';
		} else {
			$strOpt .= '<option value="' . htmlspecialchars($k) . '">' . htmlspecialchars($v) . '</option>';
		}
	}
	//UPDATE BY KAMRAN SB START
    $jsonData = array(
            'module_id' => $options['module_id'],
            'module_name' => $options['module_name'],
            'module_key'=> $options['module_key'],
            'module_value'=> $options['module_value'],
            'hidden_controll' => $id,
            'visible_controll' => $id .'_v'
        );


    $html  = '<input type="hidden" name="' . $name . '" id="' . $id . '"  />';
    $html .= '<div class="input-group input-medium "style="width:100% !important;">
                <input type="text"  id="' . $id . '_v" class="form-control" readonly="" style="">
                <span class="input-group-btn">
                <button class="btn green" type="button" onclick=\'summaryView('.json_encode(($jsonData)).');\'>
                <i class="fa fa-search"></i>
                </button>
                <button class="btn green" type="button" onclick=\'insertRelated('.json_encode(($jsonData)).');\'>
                <i class="fa fa-plus"></i>
                </button>
                </span>
              </div>';

    return $html;
    //UPDATE BY KAMRAN SB END
}

function __value($fieldName, $e = array()) {
    $CI = & get_instance();
    $value = '';
    $f = explode('.', trim($fieldName));
    if (count($f) == 1) {
        $_tmpValue = $CI->input->post($fieldName);
        if (!empty($_tmpValue)) {
            $value = $_tmpValue;
        }
    } else if (count($f) > 1) {
        $value = $_POST;
        foreach ($f as $k => $v) {
            if (isset($value[$v])) {
                $value = $value[$v];
            } else {
                $value = '';
                break;
            }
        }
    }
    if (!empty($e) && isset($e[0])) {
        switch (trim(strtolower($e[0]))) {
            case 'image':
                $value = "<img src='" . __MEDIA_PATH__ . 'images/thumbnail_' . $value . "'/>";
                break;
            case 'radio':
            case 'autocomplete':
            	if (!is_array($value)){
            		if (isset($e[1]) && !empty($value)) {
            			$value = (isset($e[1][$value])) ? $e[1][$value] : $value;
            		}
            	}else{
            		$tmp = '';
            		$sp = '';
            		foreach ($value as $sv){
            			$tmp .= $sp.((isset($e[1][$sv])) ? $e[1][$sv] : $sv);
            			$sp = ',';
            		}
            		$value = $tmp;
            	}
            	break;
            case 'select':
        		if (isset($e[2]) && array_key_exists('multiple', $e[2]) && !is_array($value)){
            		$tmp = explode(',', $value);
            		$value = array();
            		foreach ($tmp as $mv){
            			if (!empty($mv)){
            				$value[] = $mv;
            			}
            		}
            	}
            	if (!is_array($value)){
	                if (isset($e[1]) && !empty($value)) {
	                    $value = (isset($e[1][$value])) ? $e[1][$value] : $value;
	                }
            	}else{
            		$tmp = '';
            		$sp = '';
            		foreach ($value as $sv){
            			$tmp .= $sp.((isset($e[1][$sv])) ? $e[1][$sv] : $sv);
            			$sp = ',';
            		}
            		$value = $tmp;
            	}
                break;
            case 'checkbox':
                if (!empty($value) && is_array($value) && count($value) > 0) {
                    $tmp = array();
                    foreach ($value as $k1 => $v1) {
                        if (isset($e[1][$v1])) {
                            $tmp[] = $e[1][$v1];
                        }
                    }
                    $value = implode(', ', $tmp);
                } else {
                    $value = '';
                }

                break;
            //hidden case
            case 'hidden':
                //Here
                break;
            //hidden case
        }
    }

    return $value;
}

function __html($html = '') {
    return $html;
}

function arrayToCsv(array &$fields, $delimiter = ',', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false) {
    $delimiter_esc = preg_quote($delimiter, '/');
    $enclosure_esc = preg_quote($enclosure, '/');

    $output = array();
    foreach ($fields as $field) {
        if ($field === null && $nullToMysqlNull) {
            $output[] = 'NULL';
            continue;
        }

        // Enclose fields containing $delimiter, $enclosure or whitespace
        if ($encloseAll || preg_match("/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field)) {
            $output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
        } else {
            $output[] = $field;
        }
    }

    return implode($delimiter, $output);
}

//FUNCTION FOR CUSTOM START
function __custom_fields($data_to_convert){
    return $data_to_convert;
}
//FUNCTION FOR CUSTOM END

function generateViewElementView($e = array(),$db, $field,$date_format_convert){
    $return = '';


                            $elements = $e;
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
                                                $_dao = new ScrudDao($e[1]['option_table'], $db);
                                                //$params['fields'] = array($e[1]['option_key'], $e[1]['option_value']);
                                                $tarr = array('contact', 'crud_users');

                                                if (in_array($e[1]['option_table'],$tarr)) {
                                                    if ($e[1]['option_table'] == 'contact') {
                                                        $params['fields'] = array($e[1]['option_key'], 'First_Name', 'Last_Name');
                                                    } else if($e[1]['option_table'] == 'crud_users'){
                                                        $params['fields'] = array($e[1]['option_key'], 'user_first_name', 'user_las_name');
                                                    }
                                                } else {
                                                    $params['fields'] = array($e[1]['option_key'], $e[1]['option_value']);
                                                }
                                                ///////////
                                                $rs = $_dao->find($params);
                                                if (!empty($rs)) {
                                                    foreach ($rs as $v) {
                                                        //$options[$v[$e[1]['option_key']]] = $v[$e[1]['option_value']];
                                                        if (in_array($e[1]['option_table'],$tarr)) {
                                                            if ($e[1]['option_table'] == 'contact') {

                                                                $options[$v[$e[1]['option_key']]] = ucwords($v['First_Name']) . ' ' . ucwords($v['Last_Name']);

                                                            } else if($e[1]['option_table'] == 'crud_users'){

                                                                $options[$v[$e[1]['option_key']]] = ucwords($v['user_first_name']) . ' ' . ucwords($v['user_las_name']);

                                                            }
                                                        } else {
                                                            $options[$v[$e[1]['option_key']]] = $v[$e[1]['option_value']];
                                                        }
                                                        //////////////////////


                                                    }
                                                }
                                            }
                                        } else {
                                            $options = $e[1];
                                        }

                                    }
                                    $elements[1] = $options;
                                    break;
                                //TIMEZONE CODE HERE START
                                case 'timezone':
                                    $e = $elements;
                                    $options = array();
                                    $params = array();
                                    if (isset($e[1]) && !empty($e[1])) {
                                        if (array_key_exists('option_table', $e[1])) {
                                            if (array_key_exists('option_key', $e[1]) &&
                                                    array_key_exists('option_value', $e[1])) {
                                                $_dao = new ScrudDao($e[1]['option_table'], $db);
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
                                //TIMEZONE CODE HERE END
                            }
                            switch ($elements[0]) {
                                //HIDDEN CODE HERE
                                case 'hidden':
                                    $attributes = array();
                                    $CI = & get_instance();
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
                                    if (isset($e[1]) && !empty($e[1])) {
                                        if(isset($e[1]['choice']) && ($e[1]['choice']=='predefined')){
                                            $value = $$e[1]['value'];
                                            $attributes = array(
                                                'value' => $value,
                                                'choice' => $e[1]['choice']
                                            );
                                        } else {
                                            $attributes = $e[1];
                                        }
                                        
                                    }
                                    $return =  __hidden('data.' . $field, $attributes);
                                    break;
                                //HIDDEN CODE HERE 
                                case 'radio':
                                case 'autocomplete':
                                case 'select':                               
                                case 'checkbox':
                                    $aryField = explode('.', $field);
                                    $CI = & get_instance();
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
                                    $return =  htmlspecialchars($value);
                                    break;
                                case 'image':
                                    $return =  __value('data.' . $field, $elements);
                                    break;
                                case 'editor':
                                    $return =  nl2br(htmlspecialchars(__value('data.' . $field, $elements)));
                                    break;
                                case 'file':
                                    $value = __value('data.' . $field);
                                    if (file_exists(FCPATH . '/media/files/' . $value)) {
                                        $return =  '<a href="'.base_url().'index.php/admin/download?file=' . $value . '">' . $value . '</a>';
                                    } else {
                                        $return =  $value;
                                    }
                                    break;
                                case 'password':
                                    $return =  '******';
                                    break;
                                case 'comments':
                                    $return =  __comments('data.' . $field, $elements);
                                    break;                                
                                case 'textarea':
                                    $return =  nl2br(htmlspecialchars(__value('data.' . $field, $elements)));
                                    break;
                                case 'date':
                                    if (is_date(__value('data.' . $field, $elements))){
                                        $return =  date($date_format_convert[__DATE_FORMAT__],strtotime(__value('data.' . $field, $elements)));
                                    }else{
                                            $return =  '';
                                        }
                                        break;
                                case 'time': //time
                                    if (is_date(__value('data.' . $field, $elements))){
                                        $return =  date(' H:i:s',strtotime(__value('data.' . $field, $elements)));
                                    }else{
                                            $return =  '';
                                        }
                                        break;
                                case 'datetime':
                                    if (is_date(__value('data.' . $field, $elements))){
                                        $return =  date($date_format_convert[__DATE_FORMAT__].' H:i:s',strtotime(__value('data.' . $field, $elements)));
                                    }else{
                                            $return =  '';
                                        }
                                        break;
                                //RELATED MODULE START 
                                case 'related_module':
                                    $attributes = array();
                                    $options = array();
                                    if (isset($e[1]) && !empty($e[1])) {
                                        $attributes = $e[1];
                                    }
                                    if (array_key_exists('id', $e[1])) {
                                        $options['module_id'] = $e[1]['id'];
                                    }

                                    $return =  __related_module_view('data.' . $field, $options, $attributes);
                                    break;
                                //RELATED MODULE END
                                default:
                                    $return =  nl2br(htmlspecialchars(__value('data.' . $field, $elements)));
                                    break;
                            }
                                    return $return;
}
function generateFormElementView($e = array(),$db, $field){
    $return = '';
$CI = & get_instance();
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
   
                                    switch (strtolower(trim($e[0]))) {
                                        case 'empty':
                                           return "";
                                           break;
                                        case 'image':
                                            $attributes = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $attributes['style'] = 'display:none;';
                                            $return =  __image('data.' . $field, $attributes);
                                            break;
                                        case 'text':
                                            $attributes = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $return =  __text('data.' . $field, $attributes);
                                            break;
                                        /*case 'related_module':
                                            $attributes = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $return =  __related_module('data.' . $field, $attributes);
                                            break;*/
                                        //RELATED MODULE START 
                                        case 'related_module':
                                            $attributes = array();
                                            $options = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            if (array_key_exists('id', $e[1])) {
                                                $options['module_id'] = $e[1]['id'];
                                            }

                                            $return =  __related_module('data.' . $field, $options, $attributes);
                                            break;
                                        //RELATED MODULE END
                                        case 'multiple_add':
                                            $attributes = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $return =  __multiple_add('data.' . $field, $attributes);
                                            break;
                                        case 'timezone':
                                            $attributes = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $return =  __timezone('data.' . $field, $attributes);
                                            break;
                                        case 'date':
                                            $attributes = array();
                                            $attributes['style'] = "width:180px;";
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $return =  __date('data.' . $field, $attributes);
                                            break;
                                        case 'time':
                                            $attributes = array();
                                            $attributes['style'] = "width:180px;";
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $return =  __time('data.' . $field, $attributes);
                                            break;
                                        case 'datetime':
                                            $attributes = array();
                                            $attributes['style'] = "width:180px;";
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $return =  __datetime('data.' . $field, $attributes);
                                            break;
                                        case 'comments':
                                            $attributes = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $return =  __comments('data.' . $field, $attributes);
                                            break;                                
                                        case 'textarea':
                                            $attributes = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $return =  __textarea('data.' . $field, $attributes);
                                            break;
                                        case 'editor':
                                            $attributes = array();
                                            $attributes['style'] = 'width:680px; height:400px;';
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $return =  __editor('data.' . $field, $attributes);
                                            break;
                                        //CURRENCY START
                                        case 'currency':
                                            $attributes = array();

                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $_curt = new ScrudDao('currencies', $db);
                                            $cpt = array();
                                            $cpt['conditions'] = array('currency_status="3"');
                                            $cpt_res = $_curt->find($cpt);
                                            if (!empty($cpt_res)) {
                                                $attributes['currency_symbol'] = $cpt_res[0]['currency_symbol'];
                                            }
                                            
                                            $return = __currency('data.' . $field, $attributes);
                                            break;    
                                        //CURRENCY END
                                        //CUSTOM FIELD CODE HERE
                                        case 'custom':
                                            $return =  __custom_fields($e[1]['json']);
                                            break;
                                        //CUSTOM FIELD CODE HERE
                                        //HIDDEN CODE HERE
                                        case 'hidden':
                                            $attributes = array();
                                            $CI = & get_instance();
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
                                            if (isset($e[1]) && !empty($e[1])) {
                                                if(isset($e[1]['choice']) && ($e[1]['choice']=='predefined')){
                                                    $value = $$e[1]['value'];
                                                    $attributes = array(
                                                        'value' => $value,
                                                        'choice' => $e[1]['choice']
                                                    );
                                                } else {
                                                    $attributes = $e[1];
                                                }
                                                
                                            }
                                            $return =  __hidden('data.' . $field, $attributes);
                                            break;
                                        //HIDDEN CODE HERE
                                        case 'radio':
                                            $options = array();
                                            $params = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                if (array_key_exists('option_table', $e[1])) {
                                                    if (array_key_exists('option_key', $e[1]) &&
                                                            array_key_exists('option_value', $e[1])) {
                                                        $_dao = new ScrudDao($e[1]['option_table'], $db);
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
                                            $return =  __radio('data.' . $field, $options, $attributes);
                                            break;
                                        case 'checkbox':
                                            $options = array();
                                            $params = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                if (array_key_exists('option_table', $e[1])) {
                                                    if (array_key_exists('option_key', $e[1]) &&
                                                            array_key_exists('option_value', $e[1])) {
                                                        $_dao = new ScrudDao($e[1]['option_table'], $db);
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
                                            $return =  __checkbox('data.' . $field, $options, $attributes);
                                            break;
                                        case 'password':
                                            $attributes = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $return =  __password('data.' . $field, $attributes);
                                            break;
                                        case 'file':
                                            $attributes = array();
                                            $attributes['style'] = 'display:none;';
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $return =  __file('data.' . $field, $attributes);
                                            break;
                                        case 'select':
                                            $options = array();
                                            $params = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                if (array_key_exists('option_table', $e[1])) {
                                                    if (array_key_exists('option_key', $e[1]) &&
                                                            array_key_exists('option_value', $e[1])) {
                                                        $_dao = new ScrudDao($e[1]['option_table'], $db);
                                                        if($e[1]['option_table']=='crud_users'){
                                                            $params['fields'] = array($e[1]['option_key'], $e[1]['option_value'], 'user_las_name');
                                                        } else {
                                                            $params['fields'] = array($e[1]['option_key'], $e[1]['option_value']);  
                                                        }
                                                        //conditions
                                                        if(isset($e[1]['option_condition']) && isset($e[1]['option_column']) && isset($e[1]['option_action'])){
                                                            $condition = $e[1]['option_condition'];
                                                            $column = $e[1]['option_column'];
                                                            $action = $e[1]['option_action'];
                                                            if($condition!=0 && $condition!=''){
                                                                $cond_final = $column . $action . $condition;
                                                                $params['condition']=$cond_final;
                                                            }
                                                        } 
                                                        //conditions
                                                        $rs = $_dao->find($params);
                                                        
                                                        if (!empty($rs) && $e[1]['option_table']=='crud_users') {
                                                            foreach ($rs as $v) {
                                                                $options[$v[$e[1]['option_key']]] = $v[$e[1]['option_value']].' '.$v['user_las_name'];
                                                            }
                                                        } else if (!empty($rs) && $e[1]['option_table']!='crud_users') {
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
                                            $return =  __select('data.' . $field, $options, $attributes);
                                            break;
                                        //TIMEZONE START HERE
                                        case 'timezone':
                                            $options = array();
                                            $params = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                if (array_key_exists('option_table', $e[1])) {
                                                    if (array_key_exists('option_key', $e[1]) &&
                                                            array_key_exists('option_value', $e[1])) {
                                                        $_dao = new ScrudDao($e[1]['option_table'], $db);
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
                                            $return =  __timezone('data.' . $field, $options, $attributes);
                                            break;
                                        //TIMEZONE END HERE
                                        //NEW AUTOCOMPLETE BY KAMRAN SB
                                        case 'autocomplete':
                                            $options = array();
                                            $params = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                if (array_key_exists('option_table', $e[1])) {
                                                    if (array_key_exists('option_key', $e[1]) &&
                                                    array_key_exists('option_value', $e[1])) {
                                                        $_m = new ScrudDao('crud_components', $db);
                                                        $_p['fields'] = array('id','component_name');
                                                        $_p['conditions'] = array('component_table="'.$e[1]['option_table'].'"');
                                                        //conditions
                                                        if(isset($e[1]['option_condition']) && isset($e[1]['option_column']) && isset($e[1]['option_action'])){
                                                            $condition = $e[1]['option_condition'];
                                                            $column = $e[1]['option_column'];
                                                            $action = $e[1]['option_action'];
                                                            if($condition!=0 && $condition!=''){
                                                                $cond_final = $column . $action . $condition;
                                                                $params['condition']=$cond_final;
                                                            }
                                                        } 
                                                        //conditions

                                                        $mrs = $_m->find($_p);
                                                        $options['module_id'] = $mrs[0]['id'];
                                                        $options['module_name'] = $mrs[0]['component_name'];
                                                        $options['module_key'] = $e[1]['option_key'];
                                                        $options['module_value'] = $e[1]['option_value'];
                                                    }
                                                } else {
                                                    $options = $e[1];
                                                }
                                            }
                                            $attributes = array();
                                            if (isset($e[2]) && !empty($e[2])) {
                                                $attributes = $e[2];
                                            }
                                            
                                            $return =  __autocomplete('data.' . $field, $options, $attributes);
                                            break;
                                        //NEW AUTOCOMPLETE BY KAMRAN SB
                                        case 'button':
                                            $attributes = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $return =  __button($attributes);
                                            break;
                                        case 'submit':
                                            $attributes = array();
                                            if (isset($e[1]) && !empty($e[1])) {
                                                $attributes = $e[1];
                                            }
                                            $return =  __submit($attributes);
                                            break;
                                    }

                                    return $return;
}
