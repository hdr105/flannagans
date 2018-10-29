<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends Admin_Controller {

 public function index() {
        $CI = & get_instance();
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');

        $rid = $this->input->get('key')['reports.id'];


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

        $rq['main_module_table'] = $get_main[0]['component_table'];

        $rtables[] = $rq['main_module_table'];
        
        $fields = array();
        $fex = explode(',', $rq['selected_fileds']);
        foreach ($fex as $fk => $fv) {
            $f1 = explode('|', $fv);
            $fields[] = $f1[0];
        }
        $var['main_table']=$get_main[0]['component_table'];
        //$var['main_table_id']=
        $var['selected_fileds_for_report']=$fex;
        $rsql = "SELECT " . implode(',', $fields) . " FROM " . $rq['main_module_table'];

        $rmex = explode(',', $rq['related_modules']);



                /*$this->db->select('*');
                $this->db->from('crud_components');
            
                $this->db->where('component_table',$rq['main_module']);
            
                $query = $this->db->get();
                $mainModule = $query->result_array();*/

                $mainModuleTable = $rq['main_module_table'];
                $mainModuleFields = array();

                if (!empty($get_main)) {
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$rq['main_module']). '/' . $rq['main_module_table'] . '.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$rq['main_module']) . '/' . $rq['main_module_table'] . '.php'));
                    
                    $mainModuleConf = unserialize($content);
                    $mainModuleFields = $mainModuleConf['form_elements'];
                     //echo "<pre>";print_r($mainModuleConf['']); 
                    // //print_r();
                     //exit;

                                
                } //form_elements

        foreach($mainModuleFields as $irk => $irv) {
            //echo "<pre>"; print_r($irv['section_fields']);
            foreach ($irv['section_fields'] as $ik => $iv) {
                if ($iv['element'][1]['option_table']) {
                    
                    $mainJoinTable[] = $iv['element'][1]['option_table'];
                    $mainJoinField[] = $ik;
                    $joins[] = $ik . " = " . $iv['element'][1]['option_table'].".".$iv['element'][1]['option_key'];
                }
            }
        }
        //exit;
//echo "<pre>";print_r($mainJoinField);exit;

       

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

                    $rtables[] = $relatedModule[0]['component_table'];
                    // print_r($relatedModuleConf); 
                    // //print_r();
                    // exit;
                    
                                
                } //form_elements
        }                
        
        $auto_fields = array();

/*        foreach($rm as $irk => $irv) {
            foreach ($irv as $ik1 => $iv1) {
echo "<pre>";print_r($iv1);
                foreach ($iv1['section_fields'] as $ik => $iv) {
                    if ($iv['element'][1]['option_table'] == $mainModuleTable) {
                        
                        $main = $iv['element'][1]['option_table'] . '.' . $iv['element'][1]['option_key'];
                        

                        $ex_table = explode('.', $ik);

                        $rsql .= " LEFT JOIN {$ex_table[0]} ON {$main} = {$ik} ";
                        $joins[] = $ik . " = " . $main;
                    }
                }
            }
        }
exit;*/
        

     // Conditions 
        $conditions = '';
        $cfields = array();
        $cfex = explode('^', $rq['conditions']);
        //echo "<pre>";print_r($cfex);
        foreach ($cfex as $cfk => $cfv) {
            $cf1 = explode(',', $cfv);
            if (isset($cf1[2]) && !empty($cf1[2])) {
                
                $cfn = explode('|', $cf1[0]);
                if($cfn[2]=='date'){
                    $cf1[2]=date('Y-m-d',strtotime($cf1[2]));
                }

                if ($conditions != '') {
                    $conditions .= " AND ";
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
                        $conditions .= " ({$cfn[0]} IS NULL OR {$cfn[0]} = '') ";
                        break;
                    case 'ny':
                        $conditions .= " ({$cfn[0]} IS NOT NULL OR {$cfn[0]} <> '') ";
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
            $tbl_fields[] =  $exfv[0];// . ' AS ' . $fex[0].'__'.$fex[1]; 
            $fields_lbs[] = $exfv[1];

            $ex_fields[] = $exfv[0];

        }
        //$all_fields = $rm;
        //$all_fields[] = $mainModuleFields;
        $all_fields=array_merge($rm,$mainModuleFields);
        //echo "<pre>";print_r($all_fields);exit;////////////////    
        foreach($all_fields as $irk => $irv) {

            foreach ($irv['section_fields'] as $ik => $iv) {
                //echo "<pre>key $ik";print_r($iv);
                
                    //echo "<pre>key $ik";print_r($iv['element'][0]);
                    $local_arr = array();
                    if ($iv['element'][0] == 'select' || $iv['element'][0] == 'autocomplete') {

                       
                       $afkey = str_replace('.', '__', $ik);
                            $auto_fields[$afkey] = $iv['element'][1];
                            // $special_fields[$ik]=$iv['element'][1];
                            // $special_fields_type=$iv['element'][0];
                       
                        
                    }

                    if(isset($iv['element'][0])&& $iv['element'][0]!=""){
                            $special_fields[$ik]=$iv['element'][1];
                            $special_fields_type[$ik]=$iv['element'][0];
                            $afkey = str_replace('.', '__', $ik);
                            $auto_fieldss[$afkey] = $iv['element'][1];

                    }
                
            }
        }
        //exit;
        $var['rm'] = $all_fields;
        $var['auto_fields'] = $auto_fields; 
        //echo "<pre>";print_r($auto_fieldss);print_r($special_fields_type);print_r($special_fields);//exit;////////////////                               
                                
            
/////////nauman code starts here//////////////////
        $func_str="";
        $data_func = $rq['func'];
        $data_func_arr = explode("^",$data_func);
        if(isset($data_func_arr[0])&& $data_func_arr[0]!=""){
            $data_func_field=explode("|",$data_func_arr[1]);
            if(isset($data_func_field[0]) && $data_func_field[0]!=""){
                $func_str=" , ". $data_func_arr[0] ."(".$data_func_field[0].")";

                if(isset($data_func_arr[2]) && $data_func_arr[2]!=""){
                    $func_str.= " AS ". $data_func_arr[2]. " ";
                    $count_label=count($fields_lbs);
                    $fields_lbs[$count_label]=$data_func_arr[2];
                }
            }

        }
/////////nauman ends here///////////////////
        $sql = '';
        $sql .= 'SELECT ' . implode(',', $tbl_fields);

        //////nauman///////////
        if(isset($func_str)&& $func_str!=""){
            $sql .= $func_str ;
        }
        /////nauman////////////
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



        ////////////nauman code starts here///////////////////
        $cst_cond = explode('^', $rq['custom_condition']);
        $rq['custom_condition'] = $cst_cond[0];
        if(isset($rq['custom_condition']) && $rq['custom_condition']!=""){
            if ( strpos($sql, 'WHERE') !== false       /*$sql contains 'WHERE'*/){
                $sql.=" AND ". $rq["custom_condition"]. " ";
            }else{
                $sql.= " WHERE ". $rq["custom_condition"]. " ";
            }
        }



        $group_aggre=explode("^",$rq['group_n_order']);
        foreach($group_aggre as $vvvv){

            $seperate_group=explode(",",$vvvv);
            //$fld_agre=explode("|",$seperate_group);
            //foreach($seperate_group as $avv){ 
                $fld_agre=explode("|",$seperate_group[0]);   
                if(isset($fld_agre[0])&&$fld_agre[0]!=""){
                    $names[]=$fld_agre[0];
                    $order[]=$seperate_group[1];   
                }
            //}
            // foreach($seperate_group as $av){

            // }
        }
        foreach($order as  $o){
            if($o=="Ascending")
                $ord[]="ASC";
            else if($o=="Descending")
                $ord[]="DESC";
            else
                $ord[]="";
        }

        //$group_str= " GROUP BY ";
        $group_count=count($names);
        if($group_count==1 && (isset($names[0])&&$names[0]!="")){
            $str_group=" GROUP BY ".$name[0];
            if(isset($ord[0])&&$ord[0]!=""){

              $str_order =  " ORDER BY ". $names[0]. " ".$ord[0]. " ";
            }

        }else if($group_count==2 && (isset($names[0])&&$names[0]!="") && (isset($names[1])&&$names[1]!="")){
            $str_group=" GROUP BY ".$names[0]. " , ". $names[1];
            if((isset($ord[0])&&$ord[0]!="")&&(isset($ord[1])&&$ord[1]!="")){

              $str_order =  " ORDER BY ". $names[0]. " ".$ord[0]. " , ". $names[1]. " ".$ord[1];
            }
        }else if($group_count==3 && (isset($names[0])&&$names[0]!="") && (isset($names[1])&&$names[1]!="") && (isset($names[2])&&$names[2]!="")){
            $str_group=" GROUP BY ". $names[0]. " , ". $names[1]. " , ". $names[2];
            if((isset($ord[0])&&$ord[0]!="")&&(isset($ord[1])&&$ord[1]!="")&&(isset($ord[2])&&$ord[2]!="")){

              $str_order =  " ORDER BY ". $names[0]. " ".$ord[0]. " , ". $names[1]. " ".$ord[1]. " , ". $names[2]. " ".$ord[2];
            }
        }
        if(isset($str_group)&&$str_group!="")
        $sql.= $str_group;
        if(isset($str_order)&&$str_order!="")
        $sql.= $str_order;
        
        //if()


        //jobs.assigned_to|Assigned To|select,Ascending^jobs.title|Title|text,Ascending^

        //echo "<pre>";print_r($names);print_r($order);
        /////////////nauman code ends here////////////////////////

        $var['sql'] = $sql .'======='.$cfex[0];
        $var['fields_lbs'] = $fields_lbs;
        $var['joins'] = $joins;
        $k = array();
        $data = array();

        // echo "<pre>";
        // print_r($rq);
        // print_r($sql);
        // exit;


        $query = $this->db->query($sql);
        if (!empty($query)) {
            foreach ($query->result_array() as $k1 => $row) {
                $data[] = $row;
                $res_data = $row;
            }
        }
        //echo "<pre>";//print_r($data);
        //print_r($auto_fields);//exit;
        //print_r($tables);
        ///////////////////////
        $fdata = array();
        foreach ($data as $dk => $dv) {
            $tmp_array = array();
            foreach ($dv as $key => $value) {
                //echo $tables[0]."__".$key."<br/>";
                if(!isset($value)||$value==""){$tmp_array[$key]=""; continue;}

                
                if (array_key_exists($tables[0]."__".$key, $auto_fieldss)) {
                    if (array_key_exists('option_table', $auto_fieldss[$tables[0]."__".$key])) {

                        $this->db->select('*');
                        $this->db->from($auto_fieldss[$tables[0]."__".$key]['option_table']);
                        $this->db->where($auto_fieldss[$tables[0]."__".$key]['option_key'],$value);
                        $query = $this->db->get();
                        $rdata = $query->row_array();
                        //echo "table:  ".$auto_fields[$tables[0]."__".$key]['option_table']."where: ".$auto_fields[$tables[0]."__".$key]['option_key']. " ".$value;
                        //echo "db value";print_r($rdata);
                        if ($auto_fieldss[$tables[0]."__".$key]['option_table'] == 'crud_users') {
                            $vv = ucwords($rdata['user_first_name']) . ' ' . ucwords($rdata['user_las_name']);
                        } elseif ($auto_fieldss[$tables[0]."__".$key]['option_table'] == 'contact') {
                            $vv = ucwords($rdata['First_Name']) . ' ' . ucwords($rdata['Last_Name']);
                        } else {
                            $vv = $rdata[$auto_fieldss[$tables[0]."__".$key]['option_value']];
                        }

                        $tmp_array[$key] = $vv;
                        
                    }else if($special_fields_type[$tables[0].".".$key]=='date'||$special_fields_type[$tables[0].".".$key]=='date_simple'){
                        if (is_date($value)){
                            $tmp_array[$key]= date('d/m/Y',strtotime($value));
                        }else{
                                $tmp_array[$key]= '';
                            }
                    }else if($special_fields_type[$tables[0].".".$key]=="datetime"){
                        if (is_date($value)){echo "its_working";
                            $tmp_array[$key]= date('H:i:s',strtotime($value));
                        }else{
                                $tmp_array[$key]= '';
                            }
                    }else if($special_fields_type[$tables[0].".".$key]=="file"){
                        if (file_exists(FCPATH . '/media/files/' . $value)) {
                             $tmp_array[$key]='<a href="' . base_url() . 'index.php/admin/download?file=' . $value . '">' . $value . '</a>';
                        } else {
                            $tmp_array[$key]= $value;
                        }
                    }else if($special_fields_type[$tables[0].".".$key]=="currency"){
                        $CI->db->select("*");
                        $CI->db->from("currencies");
                        $CI->db->where("currency_status","3");
                        $query=$CI->db->get();
                        $results_currencies=$query->result_array();
                        //$_curt = new ScrudDao('currencies', $this->da);
                        //$cpt = array();
                        //$cpt['conditions'] = array('currency_status="3"');
                        //$cpt_res = $_curt->find($cpt);

                        $tmp_array[$key]= nl2br(htmlspecialchars($results_currencies[0]['currency_symbol'].' '.$value));
                    }else if($special_fields_type[$tables[0].".".$key]=="time"){
                            
                            $tmp_array[$key]= date('H:i:s',strtotime($value));
                        
                    }else if($special_fields_type[$tables[0].".".$key]=="text" || $special_fields_type[$tables[0].".".$key]=="textarea"){
                        $tmp_array[$key] = $value;
                    } else {
                        $tmp_array[$key] = $auto_fieldss[$tables[0]."__".$key][$value];
                        
                    }
                    
                } else {
                    $tmp_array[$key] = $value;
                    
                }
                
            }
            $fdata[$dk] = $tmp_array;
            unset($tmp_array);
        }
    ///////////////////////////////
//echo "<pre>";print_r($fdata);exit;
        $var['rname']=$rq['rname'];
        $var['rid'] = $rid;
        $var['data'] = $fdata;
        $var['result_data']=$data;
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

       
        $data['page_title'] = 'Report'; // pass data to the view
         
        if (file_exists($pdfFilePath) == FALSE)
        {
            ini_set('memory_limit','64M'); // boost the memory limit if it's low <img class="emoji" draggable="false" alt="??" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
            $html = $var['main_content']; // render the view into HTML
             
           /* $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->SetWatermarkText('Created', 0.5);
            $pdf->SetMargins(5,5,5);
            $pdf->_setPageSize('A4-L');
            $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure <img class="emoji" draggable="false" alt="??" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
            $pdf->WriteHTML($html); // write the HTML into the PDF
            $pdf->Output($pdfFilePath, 'F'); // save to file because we can*/
$this->load->library('m_pdf');
header('Content-Type: application/pdf');
    //generate the PDF from the given html
$this->m_pdf->pdf->WriteHTML($var['main_content']);
$this->m_pdf->pdf->Output($file_name, "I");

        }
//exit;         
        //redirect(base_url() ."/downloads/reports/".$file_name);        

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

        $rq['main_module_table'] = $get_main[0]['component_table'];

        $rtables[] = $rq['main_module_table'];
        
        $fields = array();
        $fex = explode(',', $rq['selected_fileds']);
        foreach ($fex as $fk => $fv) {
            $f1 = explode('|', $fv);
            $fields[] = $f1[0];
        }
        $var['main_table']=$get_main[0]['component_table'];
        //$var['main_table_id']=
        $var['selected_fileds_for_report']=$fex;
        $rsql = "SELECT " . implode(',', $fields) . " FROM " . $rq['main_module_table'];

        $rmex = explode(',', $rq['related_modules']);



                /*$this->db->select('*');
                $this->db->from('crud_components');
            
                $this->db->where('component_table',$rq['main_module']);
            
                $query = $this->db->get();
                $mainModule = $query->result_array();*/

                $mainModuleTable = $rq['main_module_table'];
                $mainModuleFields = array();

                if (!empty($get_main)) {
                    if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$rq['main_module']). '/' . $rq['main_module_table'] . '.php')) {
                                exit;
                    }
                    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$rq['main_module']) . '/' . $rq['main_module_table'] . '.php'));
                    
                    $mainModuleConf = unserialize($content);
                    $mainModuleFields = $mainModuleConf['form_elements'];
                     //echo "<pre>";print_r($mainModuleConf['']); 
                    // //print_r();
                     //exit;

                                
                } //form_elements

        foreach($mainModuleFields as $irk => $irv) {
            //echo "<pre>"; print_r($irv['section_fields']);
            foreach ($irv['section_fields'] as $ik => $iv) {
                if ($iv['element'][1]['option_table']) {
                    
                    $mainJoinTable[] = $iv['element'][1]['option_table'];
                    $mainJoinField[] = $ik;
                    $joins[] = $ik . " = " . $iv['element'][1]['option_table'].".".$iv['element'][1]['option_key'];
                }
            }
        }
        //exit;
//echo "<pre>";print_r($mainJoinField);exit;

       

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

                    $rtables[] = $relatedModule[0]['component_table'];
                    // print_r($relatedModuleConf); 
                    // //print_r();
                    // exit;
                    
                                
                } //form_elements
        }                
        
        $auto_fields = array();

/*        foreach($rm as $irk => $irv) {
            foreach ($irv as $ik1 => $iv1) {
echo "<pre>";print_r($iv1);
                foreach ($iv1['section_fields'] as $ik => $iv) {
                    if ($iv['element'][1]['option_table'] == $mainModuleTable) {
                        
                        $main = $iv['element'][1]['option_table'] . '.' . $iv['element'][1]['option_key'];
                        

                        $ex_table = explode('.', $ik);

                        $rsql .= " LEFT JOIN {$ex_table[0]} ON {$main} = {$ik} ";
                        $joins[] = $ik . " = " . $main;
                    }
                }
            }
        }
exit;*/
        

     // Conditions 
        $conditions = '';
        $cfields = array();
        $cfex = explode('^', $rq['conditions']);
        //echo "<pre>";print_r($cfex);
        foreach ($cfex as $cfk => $cfv) {
            $cf1 = explode(',', $cfv);
            if (isset($cf1[2]) && !empty($cf1[2])) {
                
                $cfn = explode('|', $cf1[0]);
                if($cfn[2]=='date'){
                    $cf1[2]=date('Y-m-d',strtotime($cf1[2]));
                }

                if ($conditions != '') {
                    $conditions .= " AND ";
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
                        $conditions .= " ({$cfn[0]} IS NULL OR {$cfn[0]} = '') ";
                        break;
                    case 'ny':
                        $conditions .= " ({$cfn[0]} IS NOT NULL OR {$cfn[0]} <> '') ";
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
            $tbl_fields[] =  $exfv[0];// . ' AS ' . $fex[0].'__'.$fex[1]; 
            $fields_lbs[] = $exfv[1];

            $ex_fields[] = $exfv[0];

        }
        //$all_fields = $rm;
        //$all_fields[] = $mainModuleFields;
        $all_fields=array_merge($rm,$mainModuleFields);
        //echo "<pre>";print_r($all_fields);exit;////////////////    
        foreach($all_fields as $irk => $irv) {

            foreach ($irv['section_fields'] as $ik => $iv) {
                //echo "<pre>key $ik";print_r($iv);
                
                    //echo "<pre>key $ik";print_r($iv['element'][0]);
                    $local_arr = array();
                    if ($iv['element'][0] == 'select' || $iv['element'][0] == 'autocomplete') {

                       
                       $afkey = str_replace('.', '__', $ik);
                            $auto_fields[$afkey] = $iv['element'][1];
                            // $special_fields[$ik]=$iv['element'][1];
                            // $special_fields_type=$iv['element'][0];
                       
                        
                    }

                    if(isset($iv['element'][0])&& $iv['element'][0]!=""){
                            $special_fields[$ik]=$iv['element'][1];
                            $special_fields_type[$ik]=$iv['element'][0];
                            $afkey = str_replace('.', '__', $ik);
                            $auto_fieldss[$afkey] = $iv['element'][1];

                    }
                
            }
        }
        //exit;
        $var['rm'] = $all_fields;
        $var['auto_fields'] = $auto_fields; 
        //echo "<pre>";print_r($auto_fieldss);print_r($special_fields_type);print_r($special_fields);//exit;////////////////                               
                                
            
/////////nauman code starts here//////////////////
        $func_str="";
        $data_func = $rq['func'];
        $data_func_arr = explode("^",$data_func);
        if(isset($data_func_arr[0])&& $data_func_arr[0]!=""){
            $data_func_field=explode("|",$data_func_arr[1]);
            if(isset($data_func_field[0]) && $data_func_field[0]!=""){
                $func_str=" , ". $data_func_arr[0] ."(".$data_func_field[0].")";

                if(isset($data_func_arr[2]) && $data_func_arr[2]!=""){
                    $func_str.= " AS ". $data_func_arr[2]. " ";
                    $count_label=count($fields_lbs);
                    $fields_lbs[$count_label]=$data_func_arr[2];
                }
            }

        }
/////////nauman ends here///////////////////
        $sql = '';
        $sql .= 'SELECT ' . implode(',', $tbl_fields);

        //////nauman///////////
        if(isset($func_str)&& $func_str!=""){
            $sql .= $func_str ;
        }
        /////nauman////////////
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



        ////////////nauman code starts here///////////////////
        $cst_cond = explode('^', $rq['custom_condition']);
        $rq['custom_condition'] = $cst_cond[0];
        if(isset($rq['custom_condition']) && $rq['custom_condition']!=""){
            if ( strpos($sql, 'WHERE') !== false       /*$sql contains 'WHERE'*/){
                $sql.=" AND ". $rq["custom_condition"]. " ";
            }else{
                $sql.= " WHERE ". $rq["custom_condition"]. " ";
            }
        }



        $group_aggre=explode("^",$rq['group_n_order']);
        foreach($group_aggre as $vvvv){

            $seperate_group=explode(",",$vvvv);
            //$fld_agre=explode("|",$seperate_group);
            //foreach($seperate_group as $avv){ 
                $fld_agre=explode("|",$seperate_group[0]);   
                if(isset($fld_agre[0])&&$fld_agre[0]!=""){
                    $names[]=$fld_agre[0];
                    $order[]=$seperate_group[1];   
                }
            //}
            // foreach($seperate_group as $av){

            // }
        }
        foreach($order as  $o){
            if($o=="Ascending")
                $ord[]="ASC";
            else if($o=="Descending")
                $ord[]="DESC";
            else
                $ord[]="";
        }

        //$group_str= " GROUP BY ";
        $group_count=count($names);
        if($group_count==1 && (isset($names[0])&&$names[0]!="")){
            $str_group=" GROUP BY ".$name[0];
            if(isset($ord[0])&&$ord[0]!=""){

              $str_order =  " ORDER BY ". $names[0]. " ".$ord[0]. " ";
            }

        }else if($group_count==2 && (isset($names[0])&&$names[0]!="") && (isset($names[1])&&$names[1]!="")){
            $str_group=" GROUP BY ".$names[0]. " , ". $names[1];
            if((isset($ord[0])&&$ord[0]!="")&&(isset($ord[1])&&$ord[1]!="")){

              $str_order =  " ORDER BY ". $names[0]. " ".$ord[0]. " , ". $names[1]. " ".$ord[1];
            }
        }else if($group_count==3 && (isset($names[0])&&$names[0]!="") && (isset($names[1])&&$names[1]!="") && (isset($names[2])&&$names[2]!="")){
            $str_group=" GROUP BY ". $names[0]. " , ". $names[1]. " , ". $names[2];
            if((isset($ord[0])&&$ord[0]!="")&&(isset($ord[1])&&$ord[1]!="")&&(isset($ord[2])&&$ord[2]!="")){

              $str_order =  " ORDER BY ". $names[0]. " ".$ord[0]. " , ". $names[1]. " ".$ord[1]. " , ". $names[2]. " ".$ord[2];
            }
        }
        if(isset($str_group)&&$str_group!="")
        $sql.= $str_group;
        if(isset($str_order)&&$str_order!="")
        $sql.= $str_order;
        
        //if()


        //jobs.assigned_to|Assigned To|select,Ascending^jobs.title|Title|text,Ascending^

        //echo "<pre>";print_r($names);print_r($order);
        /////////////nauman code ends here////////////////////////

        $var['sql'] = $sql .'======='.$cfex[0];
        $var['fields_lbs'] = $fields_lbs;
        $var['joins'] = $joins;
        $k = array();
        $data = array();

        // echo "<pre>";
        // print_r($rq);
        // print_r($sql);
        // exit;


        $query = $this->db->query($sql);
        if (!empty($query)) {
            foreach ($query->result_array() as $k1 => $row) {
                $data[] = $row;
                $res_data = $row;
            }
        }
        //echo "<pre>";//print_r($data);
        //print_r($auto_fields);//exit;
        //print_r($tables);
        ///////////////////////
        $fdata = array();
        foreach ($data as $dk => $dv) {
            $tmp_array = array();
            foreach ($dv as $key => $value) {
                //echo $tables[0]."__".$key."<br/>";
                if(!isset($value)||$value==""){$tmp_array[$key]=""; continue;}


                if (array_key_exists($tables[0]."__".$key, $auto_fieldss)) {
                    if (array_key_exists('option_table', $auto_fieldss[$tables[0]."__".$key])) {

                        $this->db->select('*');
                        $this->db->from($auto_fieldss[$tables[0]."__".$key]['option_table']);
                        $this->db->where($auto_fieldss[$tables[0]."__".$key]['option_key'],$value);
                        $query = $this->db->get();
                        $rdata = $query->row_array();
                        //echo "table:  ".$auto_fields[$tables[0]."__".$key]['option_table']."where: ".$auto_fields[$tables[0]."__".$key]['option_key']. " ".$value;
                        //echo "db value";print_r($rdata);
                        if ($auto_fieldss[$tables[0]."__".$key]['option_table'] == 'crud_users') {
                            $vv = ucwords($rdata['user_first_name']) . ' ' . ucwords($rdata['user_las_name']);
                        } elseif ($auto_fieldss[$tables[0]."__".$key]['option_table'] == 'contact') {
                            $vv = ucwords($rdata['First_Name']) . ' ' . ucwords($rdata['Last_Name']);
                        } else {
                            $vv = $rdata[$auto_fieldss[$tables[0]."__".$key]['option_value']];
                        }

                        $tmp_array[$key] = $vv;
                        
                    }else if($special_fields_type[$tables[0].".".$key]=='date'||$special_fields_type[$tables[0].".".$key]=='date_simple'){
                        if (is_date($value)){
                            $tmp_array[$key]= date('d/m/Y',strtotime($value));
                        }else{
                                $tmp_array[$key]= '';
                            }
                    }else if($special_fields_type[$tables[0].".".$key]=="datetime"){
                        if (is_date($value)){echo "its_working";
                            $tmp_array[$key]= date('H:i:s',strtotime($value));
                        }else{
                                $tmp_array[$key]= '';
                            }
                    }else if($special_fields_type[$tables[0].".".$key]=="file"){
                        if (file_exists(FCPATH . '/media/files/' . $value)) {
                             $tmp_array[$key]='<a href="' . base_url() . 'index.php/admin/download?file=' . $value . '">' . $value . '</a>';
                        } else {
                            $tmp_array[$key]= $value;
                        }
                    }else if($special_fields_type[$tables[0].".".$key]=="currency"){
                        $CI->db->select("*");
                        $CI->db->from("currencies");
                        $CI->db->where("currency_status","3");
                        $query=$CI->db->get();
                        $results_currencies=$query->result_array();
                        //$_curt = new ScrudDao('currencies', $this->da);
                        //$cpt = array();
                        //$cpt['conditions'] = array('currency_status="3"');
                        //$cpt_res = $_curt->find($cpt);

                        $tmp_array[$key]= nl2br(htmlspecialchars($results_currencies[0]['currency_symbol'].' '.$value));
                    }else if($special_fields_type[$tables[0].".".$key]=="time"){
                            
                            $tmp_array[$key]= date('H:i:s',strtotime($value));
                        
                    }else if($special_fields_type[$tables[0].".".$key]=="text" || $special_fields_type[$tables[0].".".$key]=="textarea"){
                        $tmp_array[$key] = $value;
                    } else {
                        $tmp_array[$key] = $auto_fieldss[$tables[0]."__".$key][$value];
                        
                    }
                    
                } else {
                    $tmp_array[$key] = $value;
                    
                }
                
            }
            $fdata[$dk] = $tmp_array;
            unset($tmp_array);
        }
    ///////////////////////////////
//echo "<pre>";print_r($fdata);exit;
        $var['rname']=$rq['rname'];
        $var['rid'] = $rid;
        $var['data'] = $fdata;
        $var['result_data']=$data;
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

       
        $data['page_title'] = 'Report'; // pass data to the view
         
        if (file_exists($pdfFilePath) == FALSE)
        {
            ini_set('memory_limit','64M'); // boost the memory limit if it's low <img class="emoji" draggable="false" alt="??" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
            $html = $var['main_content']; // render the view into HTML
             
           /* $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->SetWatermarkText('Created', 0.5);
            $pdf->SetMargins(5,5,5);
            $pdf->_setPageSize('A4-L');
            $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure <img class="emoji" draggable="false" alt="??" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
            $pdf->WriteHTML($html); // write the HTML into the PDF
            $pdf->Output($pdfFilePath, 'F'); // save to file because we can*/
$this->load->library('m_pdf');
header('Content-Type: application/pdf');
    //generate the PDF from the given html
$this->m_pdf->pdf->WriteHTML($var['main_content']);
$this->m_pdf->pdf->Output($file_name, "D");

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
                        if($sv['element'][0] == "empty")
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

        $sec = implode(',', $json['module_fields']);
        // $funct = $json['funct'][0];
        // $fld = explode('|', $json['funct'][1]);
        // $als = $json['funct'][2];

        //$f = $funct.'('.$fld[0].') AS '.$als.'|'.$fld[1].'|'.$fld[2];
        $funct_aggre = $json['funct'];
        if(isset($funct_aggre[0]) && $funct_aggre[0]!=""){
            
            $param['func']=$funct_aggre[0] . "^". $funct_aggre[1]."^".$funct_aggre[2]; 

        }

        $param['selected_fileds'] = $sec;//.','.$f;

        $param['autoEmail'] = $json['auto'];
        $param['frequency'] = $json['freq'];
        //$param['custom_condition'] = $json['custom'];

        $cust_data = $json['custom'];
        $cust_fun = $cust_data[0];
        $cust_val = $cust_data[1];
        $cust_val = explode('|', $cust_val);
        $cust_val = $cust_val[0];
        $cust_field = $cust_data[1];


        switch ($cust_fun) {
            case 4:
                $param['custom_condition'] = "YEAR(".$cust_val.") = YEAR(NOW()) AND MONTH(".$cust_val.")=MONTH(NOW()) ^".$cust_fun." ^ ".$cust_field ;
                break;

            case 2:
                $param['custom_condition'] = "WEEKOFYEAR(".$cust_val.") = WEEKOFYEAR(NOW()) ^".$cust_fun." ^ ".$cust_field;
                break;

            case 1:
                $param['custom_condition'] = "YEAR(".$cust_val.") = YEAR(NOW()) AND MONTH(".$cust_val.") = MONTH(NOW()) AND DAY(".$cust_val.") = DAY(NOW()) ^".$cust_fun." ^ ".$cust_field;
                break;

            case 3:
                $param['custom_condition'] = "WEEKOFYEAR(".$cust_val.")=WEEKOFYEAR(NOW())-1 ^".$cust_fun." ^ ".$cust_field;
                break;

            case 5:
                $param['custom_condition'] = $cust_val." >= DATE_SUB(NOW(),INTERVAL 1 YEAR) ^".$cust_fun." ^ ".$cust_field;
                break;

            case 6:
                $param['custom_condition'] = $cust_val." >= DATE_SUB(NOW(),INTERVAL 1 YEAR) ^".$cust_fun." ^ ".$cust_field;
                break;

            case 7:
                $param['custom_condition'] = $cust_field." ^ ".$cust_fun." ^ ".$cust_field ;
                break;

            
            default:
                $param['custom_condition'] = "";
                break;
        }

        $groupby = array();
        foreach ($json['groupby'] as $gk => $gv) {
            

                $groupby[] = implode(',', $gv);
            
        }

        $param['group_n_order'] = implode('^', $groupby) ; // mul dim arr


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