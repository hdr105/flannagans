<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends Admin_Controller {

    public function index() {
        $rid = $this->input->get('key')['reports.id'];
        $this->genPDF($rid,'I');
    }

    public function excsv() {
        $CI = & get_instance();
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');

        $rid = $this->input->get('id');

        $var = array();

        
        /* Get list of modules which report can be created
            this will exclude modules such as
            1. system management
            2. taxes etc
            */

       

        $rm = array();
        $a = array();
        $rtables = array();
        $joins = array();

        $this->db->select('*');
        $this->db->from('reports');
        $this->db->where('id',$rid);
        $query = $this->db->get();
        $rq = $query->row_array();

        $this->db->select('*');
        $this->db->from('crud_components');
            
        $this->db->where('id',$rq['main_module']);
            
        $query = $this->db->get();
        $get_main = $query->result_array();

        $rq['main_module'] = $get_main[0]['component_table'];



        $rtables[] = $rq['main_module'];





        
        $fields = array();
        $fex = explode(',', $rq['selected_fileds']);
        foreach ($fex as $fk => $fv) {
            $f1 = explode('|', $fv);
            $fields[] = $f1[0];
        }
        $rsql = "SELECT " . implode(',', $fields) . " FROM " . $rq['main_module'];

        $rmex = explode(',', $rq['related_modules']);



                $this->db->select('*');
                $this->db->from('crud_components');
            
                $this->db->where('component_name',$rq['main_module']);
            
                $query = $this->db->get();
                $mainModule = $query->result_array();

                $mainModuleTable = $mainModule[0]['component_table'];
                $mainModuleFields = array();

                if (!empty($mainModule)) {
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$mainModule[0]['id']). '/' . $mainModule[0]['component_table'] . '.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$mainModule[0]['id']) . '/' . $mainModule[0]['component_table'] . '.php'));
                    
                    $mainModuleConf = unserialize($content);
                    $mainModuleFields = $mainModuleConf['form_elements'];

                                
                } //form_elements


       

        foreach ($rmex as $key => $value) {
                $this->db->select('*');
                $this->db->from('crud_components');
            
                $this->db->where('component_name',$value);
            
                $query = $this->db->get();
                $relatedModule = $query->result_array();

                

                if (!empty($relatedModule)) {
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$relatedModule[0]['id']). '/' . $relatedModule[0]['component_table'] . '.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$relatedModule[0]['id']) . '/' . $relatedModule[0]['component_table'] . '.php'));
                    
                    $relatedModuleConf = unserialize($content);
                    $rm[] = $relatedModuleConf['form_elements'];

                    $rtables[] = $relatedModule[0]['component_table'];

                    
                                
                } //form_elements
        }                
        
        $auto_fields = array();

        foreach($rm as $irk => $irv) {
            foreach ($irv as $ik => $iv) {
                if ($iv['element'][1]['option_table'] == $mainModuleTable) {
                    
                    $main = $iv['element'][1]['option_table'] . '.' . $iv['element'][1]['option_key'];
                    

                    $ex_table = explode('.', $ik);

                    $rsql .= " LEFT JOIN {$ex_table[0]} ON {$main} = {$ik} ";
                    $joins[] = $ik . " = " . $main;
                }


                
                
            }

            
        }

        

     // Conditions 
        $conditions = '';
        $cfields = array();
        $cfex = explode('^', $rq['conditions']);
        foreach ($cfex as $cfk => $cfv) {
            $cf1 = explode(',', $cfv);
            if (isset($cf1[2]) && !empty($cf1[2])) {
                
                $cfn = explode('|', $cf1[0]);

                if ($conditions != '') {
                    $conditions = " AND ";
                }

                switch (strtolower($cf1[1])) {
                    case 'e':
                            

                            $conditions .= " {$cfn[0]} = '{$cf1[1]}' ";
                        break;
                     case 'e':
                            

                            $conditions .= " {$cfn[0]} = '{$cf1[1]}' ";
                        break;
                     case 'n':
                            

                            $conditions .= " {$cfn[0]} <> '{$cf1[1]}' ";
                        break;
                     case 's':
                            
                       
                            $conditions .= " {$cfn[0]} LIKE '{$cf1[2]}%'  ";
                             $a[] = $cf1[1];
                             $a[] = $conditions;
                        break;
                     case 'ew':
                            

                            $conditions .= " {$cfn[0]} LIKE '%{$cf1[1]}'  ";
                        break;                                    
                     case 'c':
                            

                            $conditions .= " {$cfn[0]} LIKE '%{$cf1[1]}%' ";
                        break;
                     case 'k':
                            

                            $conditions .= " {$cfn[0]} NOT LIKE '%{$cf1[1]}%' ";
                        break;
                     case 'y':
                            

                            $conditions .= " ({$cfn[0]} IS NULL OR {$cfn[0]} = '') ";
                        break;
                    case 'ny':
                            

                            $conditions .= " ({$cfn[0]} IS NOT NULL OR {$cfn[0]} <> '') ";
                        break;             
                    default:
                        # code...
                        break;
                }
            }
            
        }

        if ($conditions != '') {
                    $conditions = " WHERE " . $conditions;
        }
        

        
       
        $tables = $rtables;
        $fields = $rq['selected_fileds'];

                                $tbl_fields = array();
                                $fields_lbs = array();
                                $fields = explode(',', $fields);
                                $ex_fields = array();
                                foreach ($fields as $fk => $fv) {
                                    $exfv = explode('|', $fv);
                                    $fex = explode('.', $exfv[0]);
                                    $tbl_fields[] =  $exfv[0] . ' AS ' . $fex[0].'__'.$fex[1]; 
                                    $fields_lbs[] = $exfv[1];

                                    $ex_fields[] = $exfv[0];

                                }
        $all_fields = $rm;
        $all_fields[] = $mainModuleFields;
        foreach($all_fields as $irk => $irv) {

            foreach ($irv as $ik => $iv) {
                $local_arr = array();
                if ($iv['element'][0] == 'select' || $iv['element'][0] == 'autocomplete') {

                   
                        $afkey = str_replace('.', '__', $ik);
                        $auto_fields[$afkey] = $iv['element'][1];
                   
                    
                }
            }
        }
        $var['rm'] = $all_fields;
        $var['auto_fields'] = $auto_fields;                                
                                
                               
                                    $sql = '';
                                    $sql .= 'SELECT ' . implode(',', $tbl_fields);
                                    $sql .= ' FROM ' . $tables[0];

                                    if (isset($tables[1])) {
                                        $sql .= ' LEFT JOIN ' . $tables[1] . ' ON ' . $joins[0];
                                    }
                                    if (isset($tables[2])) {
                                        $sql .= ' LEFT JOIN ' . $tables[2] . ' ON ' . $joins[1];
                                    }
                                    if ($conditions != '' && !empty($conditions)) {
                                        $sql .= ' ' .$conditions;
                                    }

        $var['sql'] = $sql .'======='.$cfex[0];
        $var['fields_lbs'] = $fields_lbs;
        $var['joins'] = $joins;
        $k = array();
        $data = array();
        $query = $this->db->query($sql);
        if (!empty($query)) {
            foreach ($query->result_array() as $k1 => $row) {
                $data[] = $row;
                
            }
        }
       
        ///////////////////////
        $fdata = array();
                                    foreach ($data as $dk => $dv) {
                                        $tmp_array = array();
                                        foreach ($dv as $key => $value) {
                                            if (array_key_exists($key, $auto_fields)) {
                                                if (array_key_exists('option_table', $auto_fields[$key])) {

                                                    $this->db->select('*');
                                                    $this->db->from($auto_fields[$key]['option_table']);
                                                    $this->db->where($auto_fields[$key]['option_key'],$value);
                                                    $query = $this->db->get();
                                                    $rdata = $query->row_array();

                                                    if ($auto_fields[$key]['option_table'] == 'crud_users') {
                                                        $vv = ucwords($rdata['user_first_name']) . ' ' . ucwords($rdata['user_las_name']);
                                                    } elseif ($auto_fields[$key]['option_table'] == 'contact') {
                                                        $vv = ucwords($rdata['First_Name']) . ' ' . ucwords($rdata['Last_Name']);
                                                    } else {
                                                        $vv = $rdata[$auto_fields[$key]['option_value']];
                                                    }

                                                    $tmp_array[$key] = $vv;
                                                    
                                                } else {
                                                    $tmp_array[$key] = $auto_fields[$key][$value];
                                                    
                                                }
                                                
                                            } else {
                                                $tmp_array[$key] = $value;
                                                
                                            }
                                            
                                        }
                                        $fdata[$dk] = $tmp_array;
                                        unset($tmp_array);
                                    }
        ///////////////////////////////



        $var['rid'] = $rid;
        $var['data'] = $fdata;

        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/reports/excsv',$var,true);
        
       

        $this->load->view('layouts/admin/excsv', $var);   
    }

    public function expdf() {
        $rid = $this->input->get('id');
        $this->genPDF($rid);
    }

    public function genPDF($rid, $pdfType = 'D') 
    {
        $CI = & get_instance();
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');
        $CR = $this->session->userdata('CRUD_AUTH');

        $sid = $CR['site_id'];
        
        ////////////////////////        
                $var = array();
                $rm = array();
                $a = array();
                $rtables = array();
                $joins = array();

                $this->db->select('*');
                $this->db->from('reports');
                $this->db->where('id',$rid);
                $query = $this->db->get();
                $rq = $query->row_array();

                $this->db->select('*');
                $this->db->from('crud_components');
                $this->db->where('id',$rq['main_module']);
                $query = $this->db->get();
                $get_main = $query->result_array();



                $rq['main_module_table'] = $get_main[0]['component_table'];


                $rtables[] = $rq['main_module_table'];
               

                $fields = array();
                $labls = array();
                $header_flds = $rq['pdfHeader'];
                $fex = explode(',', $rq['selected_fileds']);
                foreach ($fex as $fk => $fv) {
                    $f1 = explode('|', $fv);
                    $fields[] = $f1[0];
                    $labls[] = $f1[1];
                }
                $var['main_table']=$get_main[0]['component_table'];
                
                $var['selected_fileds_for_report']= $fex;
                $rsql = "SELECT " . implode(',', $fields) . " FROM " . $rq['main_module_table'];

                $rmex = explode(',', $rq['related_modules']);




        ////////////////////// PM CONFIGURATION START ///////////////////////

                        $mainModuleTable = $rq['main_module_table'];
                        $mainModuleFields = array();

                        if (!empty($get_main)) {
                            if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$rq['main_module']). '/' . $rq['main_module_table'] . '.php')) {
                                        exit;
                            }
                            $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$rq['main_module']) . '/' . $rq['main_module_table'] . '.php'));
                            
                            $mainModuleConf = unserialize($content);
                            $mainModuleFields = $mainModuleConf['form_elements'];
                                        
                        } 
        /////////////////////// PM CONFIGURATION END //////////////////////
                        
                        $frmFields = array();
                        foreach ($mainModuleFields as $k => $v) {
                            foreach ($v['section_fields'] as $sk => $sv) {
                                $frmFields[$sk] = $sv;
                            }
                        }

                        $related_fieldNames = array();
                        $rltd_names = array();
                        $hidden = array();

                        
        /////////////////// GET RELATED MODULES WHICH ARE SELECTED start //////////////
                        
                        foreach ($frmFields as $fk => $fv) {


                            if($fv['element'][0] == "related_module" && in_array($fv['element'][1]['id'] , $rmex))
                            {
                                $related_fieldNames[] = $fk ;
                                $fk = explode('.', $fk);
                                $rltd_names[] = $fk[1];
                            }
                            else if($fv['element'][0] == "hidden")
                            {
                                foreach ($fv['element'][1] as $y => $e) {
                            
                                    $hidden[][$fk] = $e ;
                                    break;
                                }
                                
                            }

                        }
        /////////////////// GET RELATED MODULES WHICH ARE SELECTED end //////////////

                
        //////////////////// RM CONFIGURATION START //////////////////

                foreach ($rmex as $key => $value) {
                        $this->db->select('*');
                        $this->db->from('crud_components');
                    
                        $this->db->where('id',$value);
                    
                        $query = $this->db->get();
                        $relatedModule = $query->result_array();

                        

                        if (!empty($relatedModule)) {
                            if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$relatedModule[0]['id']). '/' . $relatedModule[0]['component_table'] . '.php')) {
                                        exit;
                            }
                            $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$relatedModule[0]['id']) . '/' . $relatedModule[0]['component_table'] . '.php'));
                            
                            $relatedModuleConf = unserialize($content);
                            $rm[] = $relatedModuleConf['form_elements'];

                ////////////// SET FIELDNAME AS KEY IN TABLES start /////////////////

                        foreach ($frmFields as $fk => $fv) {


                            if($fv['element'][0] == "related_module" && $fv['element'][1]['id'] ==$value )
                            {
                                $fk = explode('.', $fk);
                                $rk = $fk[1];
                                
                            }
                //////////// SET FIELDNAME AS KEY IN TABLES end /////////////////
                            

                        }
                            $rtables[$rk] = $relatedModule[0]['component_table'];
                                        
                        } 

                }    

                $tables = $rtables;
        //////////////////// RM CONFIGURATION END //////////////////

        //////////////////////fld_names_for_header start/////////////////////////////
                $set_fields = array();
                $header_flds = explode(',', $header_flds);
                foreach ($header_flds as $hdkey => $hdvalue) {

                    if(preg_match("/".$tables[0]."/",$hdvalue  ))
                    {
                        $set_fields[$tables[0]][] = $hdvalue;
                    }
                    else
                    {
                        foreach ($tables as $tabkey => $tabvalue)  
                        {
                            if(preg_match("/".$tabvalue."/", $hdvalue ))
                            {
                                $set_fields[$tabvalue][] = $hdvalue;
                            }
                        }
                    }
                }


                $fld_names_for_header = array();
                foreach ($set_fields as $hfkey => $hfvalue) {
                    foreach ($hfvalue as $ckey => $cvalue) {
                        $hf = explode('|', $cvalue);
                        $hf = $hf[1];
                        $fld_names_for_header[$hfkey][$ckey] =$hf;
                    }
                }
        //////////////////////fld_names_for_header end ////////////////////////////


        ///////////////// ADD HIDDEN FIELD CONDITION IN QUERY DEFAULT start /////////////////

                
                $conditions = " WHERE ";
                foreach ($hidden as $hkey => $hvalue) {
                    foreach ($hvalue as $key => $value) {
                        $conditions .= $key ."=". $value;
                    }
                }
                if(!isset($hidden) || empty($hidden))
                {
                    $conditions=' WHERE site_id='.$sid." ";
                }
                else
                {
                    $conditions .= " AND site_id=".$sid." ";
                }
        ///////////////// ADD HIDDEN FIELD CONDITION IN QUERY DEFAULT end /////////////////


        ////////////////////////// CONDITIONS START //////////////////////////////

                $rm_cond_data = array();
                $rm_cond_str = ' ';
            
                $cfields = array();

                $cfex = explode('^', $rq['conditions']);


                foreach ($cfex as $cfk => $cfv) {

                    $cf1 = explode(',', $cfv);

                    if(preg_match("/".$tables[0]."/", $cf1[0] ))
                    {
                        if (isset($cf1[1]) && !empty($cf1[1])) 
                        {

                            $cfn = explode('|', $cf1[0]);

                            if($cfn[2]=='date'){
                                $cf1[2]=date('Y-m-d',strtotime($cf1[2]));
                            }

                            
                            if ($conditions != '') 
                            {
                                if($cf1[3] != "")
                                {
                                    $conditions .= " ".$cf1[3]." ";
                                }
                                else
                                {
                                    $conditions .= " AND ";
                                }
                            }

                            switch (strtolower($cf1[1])) {
                                case 'e':
                                    $conditions .= " {$cfn[0]} = '{$cf1[2]}' ";
                                    break;
                                 case 'n':
                                    $conditions .= " {$cfn[0]} <> '{$cf1[2]}' ";
                                    break;
                                 case 's':
                                    $conditions .= " {$cfn[0]} LIKE '{$cf1[2]}%'  ";
                                    $a[] = $cf1[1];
                                    $a[] = $conditions;
                                    break;
                                 case 'ew':
                                    $conditions .= " {$cfn[0]} LIKE '%{$cf1[2]}'  ";
                                    break;                                    
                                 case 'c':
                                    $conditions .= " {$cfn[0]} LIKE '%{$cf1[2]}%' ";
                                    break;
                                 case 'k':
                                    $conditions .= " {$cfn[0]} NOT LIKE '%{$cf1[2]}%' ";
                                    break;
                                 case 'y':
                                    $conditions .= " ({$cfn[0]} IS NULL)";// OR {$cfn[0]} = '') ";
                                    break;
                                case 'ny':
                                    $conditions .= " ({$cfn[0]} IS NOT NULL)";//" OR {$cfn[0]} <> '') ";
                                    break;             
                                case 'bw':
                                    $conditions .= " ({$cfn[0]} BETWEEN {$cf1[2]} AND {$cf1[2]})";
                                    break;             
                                case 'b':
                                    $conditions .= " {$cfn[0]} < {$cf1[2]} ";
                                    break;             
                                case 'a':
                                    $conditions .= " {$cfn[0]} > {$cf1[2]} ";
                                    break;             
                                default:
                                    
                                    break;
                            }
                        }
                    }
                    else
                    {
                        foreach ($tables as $tabkey => $tabvalue)  
                        {
                            if(preg_match("/".$tabvalue."/", $cf1[0] ))
                            {
                                if (isset($cf1[1]) && !empty($cf1[1])) 
                                {
                                    $cfn = explode('|', $cf1[0]);

                                    if($cfn[2]=='date')
                                    {
                                        $cf1[2]=date('Y-m-d',strtotime($cf1[2]));
                                    }
                                    switch (strtolower($cf1[1])) {
                                        case 'e':
                                            $rm_cond_str .= " {$cfn[0]} = '{$cf1[2]}' ";
                                            break;
                                         case 'n':
                                            $rm_cond_str .= " {$cfn[0]} <> '{$cf1[2]}' ";
                                            break;
                                         case 's':
                                            $rm_cond_str .= " {$cfn[0]} LIKE '{$cf1[2]}%'  ";
                                            $a[] = $cf1[1];
                                            $a[] = $conditions;
                                            break;
                                         case 'ew':
                                            $rm_cond_str .= " {$cfn[0]} LIKE '%{$cf1[2]}'  ";
                                            break;                                    
                                         case 'c':
                                            $rm_cond_str .= " {$cfn[0]} LIKE '%{$cf1[2]}%' ";
                                            break;
                                         case 'k':
                                            $rm_cond_str .= " {$cfn[0]} NOT LIKE '%{$cf1[2]}%' ";
                                            break;
                                         case 'y':
                                            $rm_cond_str .= " ({$cfn[0]} IS NULL)";// OR {$cfn[0]} = '') ";
                                            break;
                                        case 'ny':
                                            $rm_cond_str .= " ({$cfn[0]} IS NOT NULL)";//" OR {$cfn[0]} <> '') ";
                                            break;             
                                        case 'bw':
                                            $rm_cond_str .= " ({$cfn[0]} BETWEEN {$cf1[2]} AND {$cf1[2]})";
                                            break;             
                                        case 'b':
                                            $rm_cond_str .= " {$cfn[0]} < {$cf1[2]} ";
                                            break;             
                                        case 'a':
                                            $rm_cond_str .= " {$cfn[0]} > {$cf1[2]} ";
                                            break;             
                                        default:
                                            
                                            break;
                                    }
                                }

                                
                                if($cf1[3] != "")
                                {
                                    $rm_op = $cf1[3];
                                }
                                else
                                {
                                    $rm_op = " AND ";
                                }
                                $rm_cond_data[$tabvalue][] = $rm_op." ".$rm_cond_str;
                                $rm_cond_str = '';
                            }
                        }
                    }
                }        
        ////////////////////////// CONDITIONS END //////////////////////////////

                
        /////// SEPRATION OF PRIMARY FIELDS & RELATED START //////////
                $pmFields = array();
                $rmFields = array();

                foreach ($fields as $key => $value) {

                    if(preg_match("/".$tables[0]."/", $value))
                    {   
                        $pmFields[] = $value;
                    }
                    else
                    {
                        foreach ($tables as $tabkey => $tabvalue)  
                        {
                            if(preg_match("/".$tabvalue."/", $value))
                            {
                                $rmFields[$tabvalue][] = $value;
                            }
                        }
                    }
                }
        /////// SEPRATION OF PRIMARY FIELDS & RELATED end //////////


        /////// MERGE PRIMARY FIELDS & RELATED START //////////

                $total_fields = $pmFields;

                foreach ($rmFields as $RM) {
                    foreach ($RM as $r) {
                        array_push($total_fields, $r);
                    }
                    
                }
        /////// MERGE PRIMARY FIELDS & RELATED END //////////


        /////////// GET SELECTED FIELDS & THEIR NAMES START //////////////////

                $fields = $rq['selected_fileds'];

                $tbl_fields = array();
                $fields_lbs = array();
                $fields = explode(',', $fields);
                $ex_fields = array();

                foreach ($fields as $fk => $fv) {
                    $exfv = explode('|', $fv);
                    $fex = explode('.', $exfv[0]);
                    $tbl_fields[] =  $exfv[0]; 
                    $fields_lbs[] = $exfv[1];

                    $ex_fields[] = $exfv[0];

                }
        /////////// GET SELECTED FIELDS & THEIR NAMES END //////////////////


        /////////////////// MERGE CONFIGURATIONS START ///////////////

                $auto_fields = array();
                $all_fields = $mainModuleFields;
                foreach($rm as $srm){
                    foreach($srm as $vrm){
                        $all_fields[]=$vrm;
                    }
                }


                foreach($all_fields as $irk => $irv) {

                    foreach ($irv['section_fields'] as $ik => $iv) {

                        if ($iv['element'][0] == 'select' || $iv['element'][0] == 'autocomplete' || $iv['element'][0] == 'radio')
                        {
                                $afkey = str_replace('.', '__', $ik);
                                $auto_fields[$afkey] = $iv['element'][1];
                                
                        }

                        if(isset($iv['element'][0])&& $iv['element'][0]!="")
                        {
                            $special_fields[$ik]=$iv['element'][1];
                            $special_fields_type[$ik]=$iv['element'][0];
                            $afkey = str_replace('.', '__', $ik);
                            $auto_fieldss[$afkey] = $iv['element'][1];

                        }
                        
                    }
                }
        /////////////////// MERGE CONFIGURATION ENDS //////////////////



        ///////////////// FUNCTION PERFORMED ON SQL START /////////////////////

                $flag  = "false";
                $func_str="";
                $data_func = $rq['func'];
                $data_func_arr = explode("^",$data_func);
                $pm_func_cond = array();
                $rm_func_cond = array();
                
                if(isset($data_func_arr[0])&& $data_func_arr[0]!="")
                {
                    $data_func_field=explode("|",$data_func_arr[1]);
                    
                    if(isset($data_func_field[0]) && $data_func_field[0]!="")
                    {
                        //array_push($labls, $data_func_arr[2]);
                        $flag = "true";
                        if(preg_match("/".$tables[0]."/", $data_func_field[0] ))
                        {   
                            $pm_func_cond[] = $data_func_arr[0]."(".$data_func_field[0].") AS ".$data_func_arr[2];
                            $fld_names_for_header[$tables[0]][]=$data_func_arr[2];
                        }
                        else
                        {
                            foreach ($tables as $tabkey => $tabvalue)  
                            {
                                if(preg_match("/".$tabvalue."/", $data_func_field[0]))
                                {
                                    $rm_func_cond[$tabvalue][] = $data_func_arr[0]."(".$data_func_field[0].") AS ".$data_func_arr[2];
                                    array_push($rmFields[$tabvalue], $rm_func_cond[$tabvalue][0]);
                                    $fld_names_for_header[$tabvalue][]=$data_func_arr[2];
                                }
                            }
                        }
                    }

                }

                if(isset($pm_func_cond) && ! empty($pm_func_cond))
                {
                    array_push($pmFields, $pm_func_cond[0]);
                }


                if($flag == "true")
                {
                    $total_size = count($fields)+1;
                    $flag ="false";
                }
                else
                {
                    $total_size = count($fields);
                }
        ///////////////// FUNCTION PERFORMED ON SQL START /////////////////////

                $var['rtdFields_size'] = ($total_size - count($pmFields));
                $var['tables'] = $tables;
                $var['rm'] = $all_fields;
                $var['auto_fields'] = $auto_fields; 

        /////////////////// SAME FIELDS IN PM AND RM START ////////////////

                $same = array();
                foreach ($pmFields as $pfkey => $pfvalue) {
                    foreach ($related_fieldNames as $rkey => $rvalue) {

                        if($pfvalue == $rvalue)
                        {
                            $same[] = $pfvalue;
                        }
                    }
                }

                if(count($rmFields) != 0 && count($pmFields) !=0)
                {
                    $new_f = array_merge($pmFields , $related_fieldNames);
                }
                else if(count($pmFields) != 0 && count($rmFields) == 0)
                {
                    $new_f = $pmFields;
                }
                else
                {
                    $new_f = $related_fieldNames;
                }       
        /////////////////// SAME FIELDS IN PM AND RM END ////////////////


        ////////////////////// PM FIELDS NAME START ///////////////
                $pm_names = array();
                foreach ($pmFields as $pkey => $pvalue) {
                    
                    $pvalue = explode('.', $pvalue);
                    $pm_names[] = $pvalue[1];
                }
        ////////////////////// PM FIELDS NAME END ///////////////


                $sql = '';
                $sql .= 'SELECT '.implode(',', $new_f);
                $sql .= ' FROM ' . $tables[0];
                if ($conditions != '' && !empty($conditions)) {
                    $sql .= ' ' .$conditions;
                }


        ////////////////////  CUSTOM CONDITION START /////////////////////////

                $cst_opt = array();
                $cst_cond = explode('^', $rq['custom_condition']);
                $rq['custom_condition'] = $cst_cond[0];

                if(isset($rq['custom_condition']) && $rq['custom_condition']!="")
                {
                    if(preg_match("/".$tables[0]."/", $cst_cond[2]))
                    {
                        if ( strpos($sql, 'WHERE') !== false )
                        {
                            if($cst_cond[3] != "")
                            {
                                $sql.=" ".$cst_cond[3]." ". $rq["custom_condition"]. " ";
                            }
                            else
                            {
                                $sql.=" AND ". $rq["custom_condition"]. " ";
                            }
                            
                        }
                        else
                        {
                            $sql.= " WHERE ". $rq["custom_condition"]. " ";
                        }              
                    }
                    else
                    {
                        foreach ($tables as $tabkey => $tabvalue)  
                        {
                            if(preg_match("/".$tabvalue."/", $cst_cond[2] ))
                            {
                                $rm_cst[$tabvalue][] = $rq["custom_condition"];
                                
                                if($cst_cond[3] != "")
                                {
                                    $cst_opt[$tabvalue][]= $cst_cond[3];
                                }
                                else
                                {
                                    $cst_opt[$tabvalue][]= " AND ";
                                }
                                
                            }
                        }
                    }
                    
                }
        ////////////////////  CUSTOM CONDITION START /////////////////////////


        //////////// ORDER BY AND GROUP BY  OF PM & RM START ////////////////



                $orderby_aggre = explode("^",$rq['orderby']);
                foreach($orderby_aggre as $vvvv){

                    $seperate_order=explode(",",$vvvv);
                    
                    $fld_agre=explode("|",$seperate_order[0]);   
                    if(isset($fld_agre[0])&&$fld_agre[0]!="")
                    {
                        $names[]=$fld_agre[0];
                        $order[]=$seperate_order[1];   
                    }
                }
                foreach($order as  $o){
                    if($o=="Ascending")
                        $ord[]="ASC";
                    else if($o=="Descending")
                        $ord[]="DESC";
                    else
                        $ord[]="";
                }

                $pm_orderby_cond = array();
                $pm_groupby_cond = array();
                $rm_orderby_cond = array();
                $rm_groupby_cond = array();

                $o_counte = 0;
                foreach ($names as $namkey => $namvalue) {
                    if(preg_match("/".$tables[0]."/", $namvalue))
                    {   
                        $pm_orderby_cond[] = $namvalue." ".$ord[$o_counte];
                    }
                    else
                    {
                        foreach ($tables as $tabkey => $tabvalue)  
                        {
                            if(preg_match("/".$tabvalue."/", $namvalue))
                            {
                                $rm_orderby_cond[$tabvalue][] = $namvalue." ".$ord[$o_counte];
                            }
                        }
                    }
                    $o_counte++;
                }

                $groupby_aggre = explode(",",$rq['groupby']);
                foreach ($groupby_aggre as $gkey => $gvalue) {
                    
                    $grp_flds = explode('|', $gvalue);
                    $g_arr[] = $grp_flds[0];
                }
                $g_counte = 0;
                foreach ($g_arr as $gkey => $gvalue) {
                    if(preg_match("/".$tables[0]."/", $gvalue))
                    {   
                        $pm_groupby_cond[] = $gvalue;
                    }
                    else
                    {
                        foreach ($tables as $tabkey => $tabvalue)  
                        {
                            if(preg_match("/".$tabvalue."/", $gvalue))
                            {
                                $rm_groupby_cond[$tabvalue][] = $gvalue;
                            }
                        }
                    }
                    $g_counte++;
                }

                if(! empty($pm_groupby_cond) && isset($pm_groupby_cond))
                {
                    $sql .= " GROUP BY ".implode(',', $pm_groupby_cond);
                }
                if(! empty($pm_orderby_cond) && isset($pm_orderby_cond))
                {
                    $sql .= " ORDER BY ".implode(',', $pm_orderby_cond);
                } 
        ////////////  ORDER BY AND GROUP BY  OF PM & RM END  //////////////////

        //////////// LIMIT ON RECORDS START /////////////////////////////////////
                $limit = $rq['limits'];
                $sql .= " LIMIT ".$limit;
        //////////// LIMIT ON RECORDS END /////////////////////////////////////

                
                $var['sql'] = $sql;
                $var['fields_lbs'] = $fld_names_for_header ;//$labls ;


        ////////////////////////// GET DATA FROM QUERY START //////////////////////////////
                
                $k = array();
                $data = array();
                $query = $this->db->query($sql);
                if (!empty($query)) {
                    foreach ($query->result_array() as $k1 => $row) {
                        $data[] = $row;
                        $res_data = $row;
                    }
                }
        //////////////////////// GET DATA FROM QUERY END ////////////////////////////


        ///////////////////// ADDITION OF RELATED MODULES DATA START /////////////////////////
            
                $Qdata = array();
                $myData = array();
                foreach ($data as $dkey => $dvalue) {
                    foreach ($dvalue as $ddkey => $ddvalue) {

                        if(in_array($ddkey,$rltd_names))          
                        {
                            $i = 0;
                            if( $ddvalue != "" )
                            {
                                $explode_ids = explode(',', $ddvalue);
                                foreach ($explode_ids as $exp_key => $exp_value) 
                                {
                                    $rsql = " SELECT ".implode(',', $rmFields[$tables[$ddkey]])." FROM ".$tables[$ddkey]." WHERE id=".$exp_value;
                                    
                                    if(isset($rm_cst) && !empty($rm_cst))
                                    {
                                        $rsql .= " ".$cst_opt[$tables[$ddkey]][0]." ".$rm_cst[$tables[$ddkey]][0];
                                    }
                                    if(isset($rm_cond_data) && !empty($rm_cond_data) )
                                    {
                                        $rsql .= " ".implode('', $rm_cond_data[$tables[$ddkey]]);
                                    }
                                    if(isset($rm_groupby_cond) && !empty($rm_groupby_cond))
                                    {
                                        $rsql .= " GROUP BY ".implode(',', $rm_groupby_cond[$tables[$ddkey]]);
                                    }
                                    if(isset($rm_orderby_cond) && !empty($rm_orderby_cond))
                                    {
                                        $rsql .= "  ORDER BY ".implode(',', $rm_orderby_cond[$tables[$ddkey]]);
                                    }
                                    
                                    $query_data = $this->db->query($rsql);

                                    unset($Qdata);

                                    if (!empty($query_data)) {
                                        foreach ($query_data->result_array() as $k1 => $row) {
                                            $Qdata[] = $row;
                                        }
                                    }
                                    
                                    $i=0;

                                    if(!empty($Qdata))
                                    {
                                        foreach ($Qdata as $qkey => $qvalue) {
                                            $myData[$dkey][$ddkey][$i] = $qvalue;
                                            $i++;
                                        }
                                    }
                                    else
                                    {
                                        $myData[$dkey][$ddkey][$i] = array();
                                    }
                                }
                            }
                            else 
                            {
                                $myData[$dkey][$ddkey][$i] = array();
                            }
                            $i=0;
                        }
                        else
                        {
                            $myData[$dkey][$ddkey] = $data[$dkey][$ddkey];
                        }
                    }
                }
        //////////////////// ADDITION OF RELATED MODULES DATA END //////////////////////


        /////////////////// CONVERT IDS INTO NAME ETC START /////////////////////////
                foreach ($myData as $mykey => $myvalue) {
                    foreach ($myvalue as $mkey => $mvalue) {

                        if( array_key_exists($tables[0]."__".$mkey , $auto_fields) && !is_array($mvalue) && $mvalue != "")
                        {
                            if (array_key_exists('option_table', $auto_fieldss[$tables[0]."__".$mkey])) 
                            {    

                                $id =  $mvalue;
                                $tbl_name = $auto_fields[$tables[0]."__".$mkey]['option_table'];
                                $did = $auto_fields[$tables[0]."__".$mkey]['option_key'];
                                $flds = $auto_fields[$tables[0]."__".$mkey]['option_value'];       
                                $cond1 = $auto_fields[$tables[0]."__".$mkey]['option_condition'];
                                $c2 = $auto_fields[$tables[0]."__".$mkey]['option_column'];
                                $op = $auto_fields[$tables[0]."__".$mkey]['option_action'];
                                $cust = $auto_fields[$tables[0]."__".$mkey]['option_customtext'];
                                if($c2 == "site_id")
                                {
                                    $cond2 = $sid ;
                                }

                                $qry = '';

                                if(!empty($cond1) && !empty($cond2) && !empty($op) && !empty($cust))
                                {

                                    $qry = " SELECT *  From ".$tbl_name. " WHERE ".$did." = ".$id. " AND ".$cond1." ".$op." ".$cond2." AND ".$cust;

                                    $q = $this->db->query($qry);

                                    $rd = array();

                                    if (!empty($q)) {
                                        foreach ($q->result_array() as $k1 => $row) {
                                            $rd[] = $row;
                                        }
                                    }

                                    $rdata[$flds] = $rd[0][$flds];
                                    
                                   
                                }
                                else if(!empty($cust))
                                {
                                    $qry = " SELECT *  From ".$tbl_name. " WHERE ".$did." = ".$id." AND ".$cust;

                                    $q = $this->db->query($qry);

                                    $rd = array();

                                    if (!empty($q)) {
                                        foreach ($q->result_array() as $k1 => $row) {
                                            $rd[] = $row;
                                        }
                                    }

                                    $rdata[$flds] = $rd[0][$flds];

                                }
                                else
                                {
                                    $this->db->select('*');
                                    $this->db->from($tbl_name);
                                    $this->db->where($did,$id);
                                    $query = $this->db->get();
                                    $rdata = $query->row_array();

                                }

                                if($auto_fields[$tables[0]."__".$mkey]['option_table'] == "crud_users")
                                {
                                    

                                    $vv = ucwords($rdata['user_first_name']) . ' ' . ucwords($rdata['user_las_name']);
                                    $myData[$mykey][$mkey] = $vv ;
                                }
                                else
                                {
                                    $myData[$mykey][$mkey] = $rdata[$flds];
                                } 
                            }
                            else
                            {
                                $myData[$mykey][$mkey] = $auto_fields[$tables[0]."__".$mkey][$myvalue[$mkey]];
                            }
                        }
                        else if( ! array_key_exists($tables[0]."__".$mkey , $auto_fields) && !is_array($mvalue) && $mvalue != "" )
                        {

                            if($special_fields_type[$tables[0].".".$mkey]=='date'||$special_fields_type[$tables[0].".".$mkey]=='date_simple')
                            {
                                if (is_date($mvalue))
                                {
                                    $myData[$mykey][$mkey] = date('d/m/Y',strtotime($mvalue));
                                }
                                else
                                {
                                    $myData[$mykey][$mkey] = "";
                                }

                            }
                            else if($special_fields_type[$tables[0].".".$mkey]=="datetime")
                            {
                                if (is_date($mvalue))
                                {
                                    $myData[$mykey][$mkey]= date('H:i:s',strtotime($mvalue));
                                }
                            }
                            else if($special_fields_type[$tables[0].".".$mkey]=="file")
                            {
                                if (file_exists(FCPATH . '/media/files/' . $mvalue))
                                {
                                     $myData[$mykey][$mkey]='<a href="' . base_url() . 'index.php/admin/download?file=' . $mvalue . '">' . $mvalue . '</a>';
                                } 
                                else 
                                {
                                    $myData[$mykey][$mkey]= $mvalue;
                                }
                            }
                            else if($special_fields_type[$tables[0].".".$mkey]=="currency")
                            {
                                $CI->db->select("*");
                                $CI->db->from("currencies");
                                $CI->db->where("currency_status","3");
                                $query=$CI->db->get();
                                $results_currencies=$query->result_array();
                                
                                $myData[$mykey][$mkey]= nl2br(htmlspecialchars($results_currencies[0]['currency_symbol'].' '.$mvalue));
                            }
                            else if($special_fields_type[$tables[0].".".$mkey]=="time")
                            {
                                    
                                $myData[$mykey][$mkey]= date('H:i:s',strtotime($mvalue));
                                
                            }
                        }
                        else if (is_array($mvalue) )
                        {
                            foreach ($mvalue as $rekey => $revalue) {

                                foreach ($revalue as $rkey => $rvalue) {

                                    if(array_key_exists($tables[$mkey]."__".$rkey , $auto_fields))
                                    {
                                        if (array_key_exists('option_table', $auto_fieldss[$tables[$mkey]."__".$rkey]) ) 
                                        {
                                            $id =  $rvalue;
                                            $tbl_name = $auto_fields[$tables[$mkey]."__".$rkey]['option_table'];
                                            $flds = $auto_fields[$tables[$mkey]."__".$rkey]['option_value'];
                                            $did = $auto_fields[$tables[$mkey]."__".$rkey]['option_key'];
                                            $cond1 = $auto_fields[$tables[$mkey]."__".$rkey]['option_condition'];
                                            $c2 = $auto_fields[$tables[$mkey]."__".$rkey]['option_column'];
                                            $op = $auto_fields[$tables[$mkey]."__".$rkey]['option_action'];
                                            $cust = $auto_fields[$tables[$mkey]."__".$rkey]['option_customtext'];
                                            if($c2 == "site_id")
                                            {
                                                $cond2 = $sid ;
                                            }
                                            
                                            $qry = '';

                                            if(!empty($cond1) && !empty($cond2) && !empty($op) && !empty($cust))
                                            {
                                                $qry = " SELECT *  From ".$tbl_name. " WHERE ".$did." = ".$id. " AND ".$cond1." ".$op." ".$cond2." AND ".$cust;

                                                $q = $this->db->query($qry);

                                                $rd = array();

                                                if (!empty($q)) {
                                                    foreach ($q->result_array() as $k1 => $row) {
                                                        $rd[] = $row;
                                                    }
                                                }

                                                $rdata[$flds] = $rd[0][$flds];
                                            }
                                            else if(!empty($cust))
                                            {
                                                $qry = " SELECT *  From ".$tbl_name. " WHERE ".$did." = ".$id." AND ".$cust;

                                                $q = $this->db->query($qry);

                                                $rd = array();

                                                if (!empty($q)) {
                                                    foreach ($q->result_array() as $k1 => $row) {
                                                        $rd[] = $row;
                                                    }
                                                }

                                                $rdata[$flds] = $rd[0][$flds];
                                            }
                                            else
                                            {
                                                $this->db->select('*');
                                                $this->db->from($tbl_name);
                                                $this->db->where($did,$id);
                                                $query = $this->db->get();
                                                $rdata = $query->row_array();
                                                
                                            }
                                            
                                            if ($auto_fieldss[$tables[$mkey]."__".$rkey]['option_table'] == 'contact') 
                                            {
                                                $vv = ucwords($rdata['First_Name']) . ' ' . ucwords($rdata['Last_Name']);
                                                $myData[$mykey][$mkey][$rekey][$rkey] = $vv ;

                                            }
                                            else if ($auto_fields[$tables[$mkey]."__".$mkey]['option_table'] == "crud_users")
                                            {
                                                $vv = ucwords($rdata['user_first_name']) . ' ' . ucwords($rdata['user_las_name']);
                                                $myData[$mykey][$mkey][$rekey][$rkey]= $vv;
                                            }
                                            else
                                            {
                                                $myData[$mykey][$mkey][$rekey][$rkey] = $rdata[$flds];
                                            }
                                            
                                        }
                                        else
                                        {
                                            $myData[$mykey][$mkey][$rekey][$rkey] = $auto_fields[$tables[$mkey]."__".$rkey][$revalue[$rkey]] ;
                                        }
                                    }
                                    else if(!array_key_exists($tables[$mkey]."__".$rkey , $auto_fields))
                                    {
                                        if($special_fields_type[$tables[$mkey].".".$rkey]=='date'||$special_fields_type[$tables[$mkey].".".$rkey]=='date_simple')
                                        {
                                            if (is_date($rvalue))
                                            {
                                                $myData[$mykey][$mkey][$rekey][$rkey] = date('d/m/Y',strtotime($rvalue));
                                            }
                                            else
                                            {
                                                $myData[$mykey][$mkey][$rekey][$rkey] = "";
                                            }
                                        }
                                        else if($special_fields_type[$tables[$mkey].".".$rkey]=="datetime")
                                        {
                                            if (is_date($rvalue))
                                            {
                                                $myData[$mykey][$mkey][$rekey][$rkey]= date('H:i:s',strtotime($rvalue));
                                            }
                                        }
                                        else if($special_fields_type[$tables[$mkey].".".$rkey]=="file")
                                        {
                                            if (file_exists(FCPATH . '/media/files/' . $rvalue))
                                            {
                                                 $myData[$mykey][$mkey][$rekey][$rkey]='<a href="' . base_url() . 'index.php/admin/download?file=' . $rvalue . '">' . $rvalue . '</a>';
                                            } 
                                            else 
                                            {
                                                $myData[$mykey][$mkey][$rekey][$rkey]= $rvalue;
                                            }
                                        }
                                        else if($special_fields_type[$tables[$mkey].".".$rkey]=="currency")
                                        {
                                            $CI->db->select("*");
                                            $CI->db->from("currencies");
                                            $CI->db->where("currency_status","3");
                                            $query=$CI->db->get();
                                            $results_currencies=$query->result_array();
                                            
                                            $myData[$mykey][$mkey][$rekey][$rkey]= nl2br(htmlspecialchars($results_currencies[0]['currency_symbol'].' '.$mvalue));
                                        }
                                        else if($special_fields_type[$tables[$mkey].".".$rkey]=="time")
                                        {
                                                
                                            $myData[$mykey][$mkey][$rekey][$rkey]= date('H:i:s',strtotime($rvalue));
                                            
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
        ////////////////// CONVERT IDS INTO NAME ETC END ////////////////////////

        $var['rname']=$rq['rname'];
        $var['rid'] = $rid;
        $var['pmFields_size'] =count($pmFields) ;
        $var['data'] = $data;
        $var['result_data']= $myData;
        $var['rel_fields'] = $rmFields;

        $file_name = date('d-m-Y') . "_report.pdf";
        $pdfFilePath = FCPATH."downloads/reports/".$file_name;

        if (file_exists($pdfFilePath)) {
            $x = 1; 

            do {
                $file_name = date('d-m-Y').'_'.$x . ".pdf";
                $pdfFilePath = FCPATH."downloads/reports/".$file_name;
                $x++;
            } while (file_exists($pdfFilePath));
        }

         
        $var['main_content'] = $this->load->view('admin/reports/expdf',$var,true);
        //exit;

       
        $data['page_title'] = 'Report'; // pass data to the view
         
        if (file_exists($pdfFilePath) == FALSE)
        {
            ini_set('memory_limit','256M'); // boost the memory limit if it's low <img class="emoji" draggable="false" alt="??" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
            $html = $var['main_content']; // render the view into HTML
            //  exit;
           /* $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->SetWatermarkText('Created', 0.5);
            $pdf->SetMargins(5,5,5);
            $pdf->_setPageSize('A4-L');
            $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure <img class="emoji" draggable="false" alt="??" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
            $pdf->WriteHTML($html); // write the HTML into the PDF
            $pdf->Output($pdfFilePath, 'F'); // save to file because we can*/
        //ob_clean();
            $this->load->library('m_pdf');
            header('Content-Type: application/pdf');
                //generate the PDF from the given html
            $this->m_pdf->pdf->WriteHTML($var['main_content']);
            $this->m_pdf->pdf->Output($file_name, $pdfType);

        }
        //exit;         
        //redirect(base_url() ."/downloads/reports/".$file_name);        

        $this->load->view('layouts/admin/reports', $var); 
   
    }


    public function create_report(){

        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');

        $var = array();

        
        /* Get list of modules which report can be created
            this will exclude modules such as
            1. system management
            2. taxes etc
            */

        $moduleList = array();
        $excludeModules = array(
                'company_info',
                'tex_calculation',
                'term_and_condition',
                'currencies',
                'taxes'

            );

        $rm = array();
        $a = array();
        $rtables = array();
        $joins = array();

        if($id = $this->input->get('key')['reports.id']){
            $this->db->select('*');
            $this->db->from('reports');
            $this->db->where('id',$id);
            $query = $this->db->get();
            $var['data'] = $query->result_array();
        }

        $this->db->select('*');
        $this->db->from('crud_components');
        //$this->db->where_not_in('component_table',$excludeModules);
        $this->db->order_by('component_name','asc');
        $query = $this->db->get();
        $var['coms'] = $query->result_array();


        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/reports/create_report',$var,true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->template('layouts/admin/reports', $var);                                         

                                   
    }

    // to get related modules
    public function get_related(){
        $moduleName = $this->input->post('moduleName');
        // SELECTED MODULE DATA
        $selectedModule = array();
        $this->db->select('*');
        $this->db->from('crud_components');
        $this->db->where('id',$moduleName);
        $query = $this->db->get();
        $selectedModule = $query->result_array();
        // SELECTD MODULE DATA ENDS



        $relatedModules = array();
        $this->db->select('*');
        $this->db->from('crud_components');
        //$this->db->where_not_in('component_table',$excludeModules);
        $query = $this->db->get();
        $relatedModules = $query->result_array();

        $relatedModulesList = array();
        
        if (!empty($selectedModule)) {
            if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$selectedModule[0]['id']). '/' . $selectedModule[0]['component_table'] . '.php')) {
            } else {
                $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$selectedModule[0]['id']) . '/' . $selectedModule[0]['component_table'] . '.php'));
                $moduleConf = unserialize($content);
                $form = $moduleConf['form_elements'];
                $frmFields = array();
                foreach ($form as $k => $v) {
                    foreach ($v['section_fields'] as $sk => $sv) {
                        $frmFields[$sk] = $sv;
                    }
                }

                foreach ($frmFields as $fk => $fv) {
                    switch ($fv['element'][0]) {
                        /*case 'select':
                        case 'autocomplete':
                        //case 'related_record':
                            if (array_key_exists('option_table', $fv['element'][1]) ) {

                                $rMInfo = array();
                                $this->db->select('*');
                                $this->db->from('crud_components');
                                $this->db->where('component_table',$fv['element'][1]['option_table']);
                                $query = $this->db->get();
                                $rMInfo = $query->result_array();
                                foreach ($rMInfo as $value) {
                                    $relatedModulesList[] = array(
                                        'id'=>$value['id'],
                                        'moduleName'=>$value['component_name'],
                                    );
                                }
                            }
                        break;*/
                        case 'related_module': //added by Faheem
                            if (array_key_exists('id', $fv['element'][1]) ) {

                                $rMInfo = array();
                                $this->db->select('*');
                                $this->db->from('crud_components');
                                $this->db->where('id',$fv['element'][1]['id']);
                                $query = $this->db->get();
                                $rMInfo = $query->result_array();
                                $relatedModulesList[] = array(
                                    'id'=>$rMInfo[0]['id'],
                                    'moduleName'=>$rMInfo[0]['component_name'],
                                );
                            }
                        break;
                    }
                }
            }
        }
        echo json_encode($relatedModulesList);


    }

    function relatedModFieldList(){
        $selectedModule = $this->input->post('selectedModule');
        $relatedModules = $this->input->post('relatedModules');
        //$rMArray = explode(',', $relatedModules);

        /////// faheem changes start //////////////////////
        if(isset($relatedModules)){
            $rMArray = explode(',', $relatedModules);
        }
        /////// faheem changes end //////////////////////

        $moduleFields = array();



                $this->db->select('*');
                $this->db->from('crud_components');
            
                $this->db->where('id',$selectedModule);
            
                $query = $this->db->get();
                $mainModule = $query->result_array();

                if (!empty($mainModule)) {
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$mainModule[0]['id']). '/' . $mainModule[0]['component_table'] . '.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$mainModule[0]['id']) . '/' . $mainModule[0]['component_table'] . '.php'));
                    
                    $mainModuleConf = unserialize($content);

                                
                } //form_elements
                $frmFields = array();
                foreach ($mainModuleConf['form_elements'] as $k => $v) {
                    foreach ($v['section_fields'] as $sk => $sv) {
                        ////// Added by faheem  ////////
                        if($sv['element'][0] == "empty" || $sv['element'][0] == "hidden" || $sv['element'][0] == "related_module" || $sv['alias'] == "" || $sv['alias'] == " ")
                            continue;
                        ////////////////////////////////
                        $frmFields[$sk] = $sv;
                    }
                }
                $mainFieldAlias = array();
                foreach ($frmFields as $mfkey => $mfvalue) {
                    $mainFieldAlias[] = array($mfvalue['alias'],$mfvalue['element'][0],$mfkey);
                }

                $moduleFields[0]['moduleName'] = $mainModule[0]['component_name'];
                $moduleFields[0]['moduleInfo'] = $mainFieldAlias;
                
        foreach ($rMArray as $key => $value) {

                $nkey = $key +1;
                $this->db->select('*');
                $this->db->from('crud_components');
            
                $this->db->where('id',$value);
            
                $query = $this->db->get();
                $modDetail = $query->result_array();

                if (!empty($modDetail)) {
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$modDetail[0]['id']). '/' . $modDetail[0]['component_table'] . '.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$modDetail[0]['id']) . '/' . $modDetail[0]['component_table'] . '.php'));
                    
                    $moduleConf = unserialize($content);

                                
                } //form_elements
                $frmFields = array();
                foreach ($moduleConf['form_elements'] as $k => $v) {
                    foreach ($v['section_fields'] as $sk => $sv) {
                        $frmFields[$sk] = $sv;
                    }
                }
                $moduleFields[$nkey]['moduleName'] = $modDetail[0]['component_name'];;

                $fieldAlias = array();
                foreach ($frmFields as $fkey => $fvalue) {
                    $fieldAlias[] = array($fvalue['alias'],$fvalue['element'][0],$fkey);
                }

                $moduleFields[$nkey]['moduleInfo'] = $fieldAlias;
        }

                

        echo json_encode($moduleFields);

    }

    function field_data(){
        $this->load->model('crud_auth');
        $moduleData = $this->input->post('data'); 
        $moduleSplit = explode('.', $moduleData);
        ////faheem changes start ////
                $CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
                // echo "<pre>";
                // print_r($CRUD_AUTH);
                // exit;
        ////faheem changes end ////
                $this->db->select('*');
                $this->db->from('crud_components');
            
                $this->db->where('component_table',$moduleSplit[0]);
            
                $query = $this->db->get();
                $modDetail = $query->result_array();



                $moduleConf = array();
                if (!empty($modDetail)) {
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$modDetail[0]['id']). '/' . $modDetail[0]['component_table'] . '.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$modDetail[0]['id']) . '/' . $modDetail[0]['component_table'] . '.php'));
                    
                    $moduleConf = unserialize($content);

                                
                } //form_elements

               
        ////faheem changes start ////

                //$filedInfo = $moduleConf['form_elements'][0]['section_fields'][$moduleData]['element'][1];
             
                foreach($moduleConf['form_elements'] as $modk => $modv)
               {
                    foreach ($modv['section_fields'] as $mkey => $mvalue) {

                        if($mkey == $moduleData)
                        {
                            //print_r($mvalue);
                            $filedInfo = $mvalue['element'][1];
                        }
                    }
                    
               }
               $output = array();


                if (isset($filedInfo['option_table']))
                {
                    $sql = "SELECT * FROM ".$filedInfo['option_table'];

                    if(isset($filedInfo['option_condition']) and $filedInfo['option_condition']!='')
                    {
                        $wh = " WHERE ";
                        $cond1 =$filedInfo['option_condition']." ".$filedInfo['option_action']." ".$CRUD_AUTH[$filedInfo['option_column']]." ";
                        $op = " AND ";
                    }
                    if(isset($filedInfo['option_customtext']) and $filedInfo['option_customtext']!=''){
                        $wh = " WHERE ";
                        $cond2 = $filedInfo['option_customtext'];
                    }else
                        $op = " ";

                    
                    $sql .= $wh.$cond1.$op.$cond2;
        ////faheem changes end ////
                    
                    $query = $this->db->query($sql);
                    $mdata = array();
                    
                    if (!empty($query)) {
                        foreach ($query->result_array() as $row) {

                            if ($filedInfo['option_table'] == 'crud_users') {
                                                                    // if crud user
                                $output[] = $row[$filedInfo['option_key']].'|'.ucwords($row['user_first_name']) . ' ' . ucwords($row['user_las_name']);
                            } else if($filedInfo['option_table'] == 'contact') {
                                $output[] = $row[$filedInfo['option_key']].'|'.ucwords($row['First_Name']) . ' ' . ucwords($row['Last_Name']);
                            } else {
                                $output[] = $row[$filedInfo['option_key']].'|'.$row[$filedInfo['option_value']];
                            }


                                
                        }
                    }

                    
                } else {
                    foreach ($filedInfo as $key => $value) {

                        $kk = explode('.', $key);

                       

                        $output[] = $key.'|'.$value;

                    }
                    
                }
                echo json_encode($output);
                

    }

    public function saveReport(){
        //$json = $this->input->get('jsonData');
        $json = $this->input->post('jsonData');
        $json = $json;
        //print_r($json);exit;
                
        $CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
        $mod= array();
                    
                        /*foreach ($json as $key => $value) {
                            # code...
                        $mod = json_decode($value);
                        }*/
       


        $this->db->select('*');
        $this->db->from('crud_components');
            
        $this->db->where('component_name',$json['sel_module']);
            
        $query = $this->db->get();
        $mod_info = $query->result_array();                        

        $param = array();
        $param['rname'] = $json['report_name'];
        $param['main_module'] = $json['sel_module'];
        $param['related_modules'] = implode(",", $json['related_modules']);

        $sec = $json['module_fields'];
        
        $f_fld = $json['funct'];
        $param['func']= implode('^',$f_fld);

        $pheader = implode(',', $json['pdfHeader']);//faheem
        $param['pdfHeader'] = $pheader;//faheem

        $param['selected_fileds'] = $sec;

        $param['autoEmail'] = $json['auto'];
        $param['frequency'] = $json['freq'];
        $param['email_sent_to'] = $json['email_sent_to'];
        $param['cc']= $json['cc'];
        $param['cc_email']= $json['cc_email'];

        $cust_data = $json['custom'];
        $cust_fun = $cust_data[0];
        $cust_val = $cust_data[1];
        $cust_op  = $cust_data[2];

        $cust_val = explode('|', $cust_val);
        $cust_val = $cust_val[0];
        $cust_field = $cust_data[1];


        switch ($cust_fun) {
            case 1:
                $param['custom_condition'] = "YEAR(".$cust_val.") = YEAR(NOW()) AND MONTH(".$cust_val.")=MONTH(NOW()) ^".$cust_fun." ^ ".$cust_field."^".$cust_op ;
                break;

            case 2:
                $param['custom_condition'] = "WEEKOFYEAR(".$cust_val.") = WEEKOFYEAR(NOW()) ^".$cust_fun." ^ ".$cust_field."^".$cust_op;
                break;

            case 3:
                $param['custom_condition'] = "YEAR(".$cust_val.") = YEAR(NOW()) AND MONTH(".$cust_val.") = MONTH(NOW()) AND DAY(".$cust_val.") = DAY(NOW()) ^".$cust_fun." ^ ".$cust_field."^".$cust_op;
                break;

            case 4:
                $param['custom_condition'] = "WEEKOFYEAR(".$cust_val.")=WEEKOFYEAR(NOW())-1 ^".$cust_fun." ^ ".$cust_field."^".$cust_op;
                break;

            case 5:
                $param['custom_condition'] = "YEAR(".$cust_val.") = YEAR(NOW()) ^".$cust_fun." ^ ".$cust_field."^".$cust_op;
                break;

            case 6:
                $param['custom_condition'] = "YEAR(".$cust_val.") = YEAR(NOW())-1 ^".$cust_fun." ^ ".$cust_field."^".$cust_op;
                break;

            case 7:
                $param['custom_condition'] = $cust_field." ^ ".$cust_fun." ^ ".$cust_field."^".$cust_op;
                break;

            
            default:
                $param['custom_condition'] = "";
                break;
        }

        $orderby = array();
        foreach ($json['orderby'] as $gk => $gv) {
            

                $orderby[] = implode(',', $gv);
            
        }

        $param['orderby'] = implode('^', $orderby) ; // mul dim arr
        $param['limits'] = implode(',', $json['limit']);

        $gby = $json['groupby'];
        $param['groupby'] = implode(',',$gby);

        $conditions = array();
        foreach ($json['conditions'] as $ck => $cv) {
            $conditions[] = implode(',', $cv);
        }

        $param['conditions'] = implode('^', $conditions) ;// mul dim arr
        $param['created_by'] = $CRUD_AUTH['id'];
        $param['created'] = date("Y-m-d");
        $param['site_id'] = $CRUD_AUTH['site_id'];
    

        //echo "<pre>";print_r($param);exit;
        if($id = $this->input->get('id')){
            $param['modified_by'] = $CRUD_AUTH['id'];
            $param['modified'] = date("Y-m-d");
            $this->db->where('id', $id);
            $this->db->update('reports', $param);
        }else{
            $param['created_by'] = $CRUD_AUTH['id'];
            $param['created'] = date("Y-m-d");
            $insert_id = $this->db->insert('reports', $param);
        }
        $ret = array(
               
                'param'=>$param,                
                'jval'=>$json['report_name'],
                'insert_id'=>$insert_id
               
                
                
            );
        echo json_encode($ret);exit;
    }
}