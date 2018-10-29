<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends Admin_Controller {

    public function index() {
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
                                    $tbl_fields[] =  $exfv[0] ; 
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
                        $kk = explode('.', $ik);
                        $auto_fields[$kk[1]] = $iv['element'][1];
                   
                    
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


        $var['fullsql'] = $sql;
        $var['rid'] = $rid;
        $var['data'] = $fdata;

        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/reports/reports',$var,true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->view('layouts/admin/reports', $var);   
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

        $file_name = date('mdY') . "_report.pdf";
        $pdfFilePath = FCPATH."downloads/reports/".$file_name;

        if (file_exists($pdfFilePath)) {
            $x = 1; 

            do {
                $file_name = date('mdY').'_'.$x . ".pdf";
                $pdfFilePath = FCPATH."downloads/reports/".$file_name;
                $x++;
            } while (file_exists($pdfFilePath));
        }

         
        $var['main_content'] = $this->load->view('admin/reports/expdf',$var,true);

       
        $data['page_title'] = 'Report'; // pass data to the view
         
        if (file_exists($pdfFilePath) == FALSE)
        {
            ini_set('memory_limit','64M'); // boost the memory limit if it's low <img class="emoji" draggable="false" alt="😉" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
            $html = $var['main_content']; // render the view into HTML
             
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->SetWatermarkText('Crated', 0.5);
            $pdf->SetMargins(5,5,5);
            $pdf->_setPageSize('A4-L');
            $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure <img class="emoji" draggable="false" alt="😉" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
            $pdf->WriteHTML($html); // write the HTML into the PDF
            $pdf->Output($pdfFilePath, 'F'); // save to file because we can
        }
         
        redirect(base_url() ."/downloads/reports/".$file_name);        

       
        
       

        $this->load->view('layouts/admin/expdf', $var); 


        
        
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

        


        $this->db->select('*');
        $this->db->from('crud_components');
        $this->db->where_not_in('component_table',$excludeModules);
        $query = $this->db->get();
        $var['coms'] = $query->result_array();


        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/reports/create_report',$var,true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->view('layouts/admin/reports', $var);                                         

                                   
    }

    // to get related modules
    public function get_related(){
        $moduleName = $this->input->post('moduleName');

        $relatedModules = array();
        $this->db->select('*');
        $this->db->from('related_module_fields');
        
        $this->db->where('related_module',$moduleName);
        
        $query = $this->db->get();
        
        $relatedModules = $query->result_array();


        $relatedModuleDetails = array();

        if (!empty($relatedModules)) {
            foreach ($relatedModules as $key => $module) {
                $this->db->select('*');
                $this->db->from('crud_components');
            
                $this->db->where('component_table',$module['module_name']);
            
                $query = $this->db->get();
                $modDetail = $query->result_array();

                /* Get Field list of realted module with labels */

                if (!empty($modDetail)) {
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$modDetail[0]['id']). '/' . $modDetail[0]['component_table'] . '.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$modDetail[0]['id']) . '/' . $modDetail[0]['component_table'] . '.php'));
                    
                    $moduleConf = unserialize($content);

                                
                }                
                //* Get field list of related module with field labels */
                $relatedModules[$key] = $modDetail[0]['component_name'];
                //$relatedModules[$key]['moduleInfo'] = $moduleConf;


            }
        }

        echo json_encode($relatedModules);


    }

    function relatedModFieldList(){
        $selectedModule = $this->input->post('selectedModule');
        $relatedModules = $this->input->post('relatedModules');

        $ex_rm = explode(',', $relatedModules);

        $moduleFields = array();



                $this->db->select('*');
                $this->db->from('crud_components');
            
                $this->db->where('component_table',$selectedModule);
            
                $query = $this->db->get();
                $mainModule = $query->result_array();

                if (!empty($mainModule)) {
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$mainModule[0]['id']). '/' . $mainModule[0]['component_table'] . '.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$mainModule[0]['id']) . '/' . $mainModule[0]['component_table'] . '.php'));
                    
                    $mainModuleConf = unserialize($content);

                                
                } //form_elements
                $mainFieldAlias = array();
                foreach ($mainModuleConf['form_elements'] as $mfkey => $mfvalue) {
                    $mainFieldAlias[] = array($mfvalue['alias'],$mfvalue['element'][0],$mfkey);
                }

                $moduleFields[0]['moduleName'] = $mainModule[0]['component_name'];
                $moduleFields[0]['moduleInfo'] = $mainFieldAlias;

        foreach ($ex_rm as $key => $value) {

                $nkey = $key +1;
                $this->db->select('*');
                $this->db->from('crud_components');
            
                $this->db->where('component_name',$value);
            
                $query = $this->db->get();
                $modDetail = $query->result_array();

                if (!empty($modDetail)) {
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$modDetail[0]['id']). '/' . $modDetail[0]['component_table'] . '.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$modDetail[0]['id']) . '/' . $modDetail[0]['component_table'] . '.php'));
                    
                    $moduleConf = unserialize($content);

                                
                } //form_elements
                $moduleFields[$nkey]['moduleName'] = $value;

                $fieldAlias = array();
                foreach ($moduleConf['form_elements'] as $fkey => $fvalue) {
                    $fieldAlias[] = array($fvalue['alias'],$fvalue['element'][0],$fkey);
                }

                $moduleFields[$nkey]['moduleInfo'] = $fieldAlias;
        }

                

        echo json_encode($moduleFields);

    }


    public function saveReport(){
        $json = $this->input->post('jsonData');
        $data = json_decode($json);
        $mod= array();
                    
                        foreach ($json as $key => $value) {
                            # code...
                        $mod = json_decode($value);
                        }
       
//echo $json_encode;


        $this->db->select('*');
        $this->db->from('crud_components');
            
        $this->db->where('component_name',$json['sel_module']);
            
        $query = $this->db->get();
        $mod_info = $query->result_array();                        

        $param = array();
        $param['rname'] = $json['report_name'];
        $param['main_module'] = $mod_info[0]['id'];
        $param['related_modules'] = $json['related_modules'];

        $param['selected_fileds'] = implode(',', $json['module_fields']);

        $groupby = array();
        foreach ($json['groupby'] as $gk => $gv) {
            

                $groupby[] = implode(',', $gv);
            
        }

        $param['group_n_order'] = implode(',', $groupby) ; // mul dim arr


        $conditions = array();
        foreach ($json['conditions'] as $ck => $cv) {
            $conditions[] = implode(',', $cv);
        }

        $param['conditions'] = implode('^', $conditions) ;// mul dim arr
       


        $insert_id = $this->db->insert('reports', $param);
        $ret = array(
               
                'param'=>$param,                
                'jval'=>$json['report_name'],
                'insert_id'=>$insert_id
               
                
                
            );
        echo json_encode(($ret));
    }


    

}