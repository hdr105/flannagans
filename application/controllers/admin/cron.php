<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends MY_Controller {

    public function index() {

        $var = array();
        	
    }

    function backup_tables() 
    {   
      
      $tables = '*';
      //get all of the tables 
      if($tables == '*') 
      { 
        $tables = array();
        
        $result = $this->db->query('SHOW TABLES');
       
        
        $return='';
        foreach($result->result_array() as $row_n ) 
        { 
          $row=array_values($row_n);
          $tables[] = $row[0];
        } 
      } 
      else 
      { 
        $tables = is_array($tables) ? $tables : explode(',',$tables);
      } 
      //cycle through 
      set_time_limit(0); 
      foreach($tables as $table) 
      { 

        $res=$this->db->list_fields($table);
        //echo "<pre>";print_r($res[0]);echo "</pre>";exit;
        $result = $this->db->query("SELECT * FROM `".$table. "` ORDER BY `" . $res[0] ."` DESC LIMIT 50 ");
        $num_fields = $result->num_fields();
        


        
         
       $return.= 'DROP TABLE IF EXISTS '.$table.';';
        
        $row2 = $this->db->query('SHOW CREATE TABLE `'.$table. '`')->result_array();
        
        
        $row3 = array_values($row2[0]);
        

        $return.= "\n\n".$row3[1].";\n\n";
        
       
          foreach($result->result_array() as $row_m) 
          {   $row=array_values($row_m);
            

            $return.= 'INSERT INTO '.$table.' VALUES(';
            for($j=0; $j<$num_fields; $j++) 
            { 
              $row[$j] = addslashes($row[$j]);
              $row[$j] = str_replace("\n","\\n",$row[$j]);
              if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; } 
              if ($j<($num_fields-1)) { $return.= ','; } 
            } 
            $return.= ");\n";
          } 
        //} 
        $return.="\n\n\n";
        flush();
        sleep(1);
        set_time_limit(0); // if PHP_CLI SAPI and having error messages

      } 
      
      //save file 
      $file = 'backup/'.date('Y-m-d').'.sql';/*-'.time().'-'.(md5(implode(',',$tables))).'*/
      $handle = fopen($file,'w+');
      fwrite($handle,$return);
      fclose($handle);
    }

    function createCronJob(){
       
        $query = $this->db->query('SELECT id, timezone FROM sites'); //Timezone for each site.
        foreach($query->result_array() as $timezones){
            
            $selected_timezone = $timezones['timezone'];
            $system_timezone = date_default_timezone_get();
            $default_hosting_timezone =  ini_get('date.timezone');
            
            $date = new DateTime(date('H:i:s'), new DateTimeZone($default_hosting_timezone));
            $site_time = $date->format('H:i:s');
            $date->format('H:i');
            $date->setTimezone(new DateTimeZone($selected_timezone));
            /*echo strtotime($date->format('H:i'))."<br>";
            echo strtotime(date('23:00'))."<br>";
            echo strtotime(date('23:59'))."<br>";*/
            if((strtotime($date->format('H:i')) >= strtotime(date('23:00'))) && (strtotime($date->format('H:i')) <= strtotime(date('23:59')))){

                $sql = 'SELECT tt.* FROM users_work_log tt INNER JOIN (SELECT user_id,MAX(id) as MaxID FROM users_work_log WHERE site_id="'.$timezones['id'].'" AND dated="'.$date->format('Y-m-d').'" AND time_end="00:00:00" GROUP BY user_id) groupedtt ON tt.user_id = groupedtt.user_id AND tt.id = groupedtt.MaxID';
                $query = $this->db->query($sql);
                foreach($query->result_array() as $result){
                    //if($results = $query->result_array()){
                    //echo "<pre>";print_r($results);
                    //$result = $results[0];
                    $work_hrs = 'SELECT working_hours FROM crud_users WHERE id='.$result['user_id'];
                    //echo $work_hrs."<br>";
                    $query_hrs = $this->db->query($work_hrs);
                    if($result_hrs = $query_hrs->row_array()){
                        $ind_w_ids = explode(',',$result_hrs['working_hours']);
                        foreach($ind_w_ids as $ids){
                            $get_hr_detail ='SELECT * FROM working_hrs_data WHERE id="'.$ids.'"';
                            //echo ">> ".$get_hr_detail."<br>";
                            $query_hr_detail = $this->db->query($get_hr_detail);
                            if($result_details = $query_hr_detail->row_array()){
                                if($result_details['Working_Day_End']=='')
                                    $result_details['Working_Day_End']=0;
                                $i=$result_details['Working_Day_Start'];
                                do{
                                    if($i == $date->format('N')){
                                        $id     =   $result['id'];
                                        $time1  =   strtotime($result['dated']." ".$result['time_start']);
                                        $time   =   $result_details['Working_Time_End'];
                                        $time2  =   strtotime(date("Y-m-d ".$result_details['Working_Time_End']));
                                         $diff   =   abs($time2 - $time1);
                                        $this->db->query("UPDATE users_work_log SET time_end = '".$time."', time_spent='$diff' WHERE id = $id");
                                        //echo ">>>> UPDATE users_work_log SET time_end = '".$time."', time_spent='$diff' WHERE id = $id<br>";
                                    }
                                    $i++;
                                }while($i<=$result_details['Working_Day_End']);
                            }
                        }
                    }
                }
            }
        }
    }

        function sendReport(){

      $this->db->select('*');
      $this->db->from('reports');
      $this->db->where('autoEmail', '1');
      $query = $this->db->get();
      $report_data = $query->result_array();


      foreach ($report_data as $redatakey => $redatavalue) {

          $this->db->select('*');
          $this->db->from('report_email_history');
          $this->db->where('report_id',$redatavalue['id']);
          $this->db->order_by('date_sent', 'desc');
          $this->db->limit(1,0);
          $query=$this->db->get();
          $individual_email_info = $query->row_array();
        
          if(!empty($individual_email_info) ) 
          { 
            $freq_for_email = $redatavalue['frequency'];
            
            switch($freq_for_email){
              
              case 1 :
                $freq = '+1 days';
                break;
              case 2 :
                $freq = '+1 weeks';
                break;
              case 3 :
                $freq = '+2 weeks';
                break;
              case 4 :
                $freq = '+1 months';
                break;
              case 5 :
                $freq = '+1 years';
                break;
              default:
                break;
            }
            
            $mailing_time =   date ( 'Y-m-d',strtotime ( $freq , strtotime ( $individual_email_info['date_sent'] )));

            $current_date = date('Y-m-d');
            //$mailing_time_str = strtotime($mailing_time);
            //$current_date_str = strtotime($current_date);

            //$subTime = $mailing_time_str - $current_date_str;

            //$d = ($subTime/(60*60*24));

            //if($d==0){
            if($current_date == $mailing_time )
            {
              $this->emailPdfReport($redatavalue);
            }
          }
          else
          {
            $this->emailPdfReport($redatavalue);
          }

      }


    }

    function emailPdfReport($repvalue )
    {

        $var = array();
        $rm = array();
        $a = array();
        $rtables = array();
        $joins = array();

        $rq = $repvalue;
        $sid = $rq['site_id'];
        $this->db->select('*');
        $this->db->from('crud_components');
        $this->db->where('id',$rq['main_module']);
        $query = $this->db->get();
        $get_main = $query->result_array();



        $rq['main_module_table'] = $get_main[0]['component_table'];


        $rtables[] = $rq['main_module_table'];
       

        $fields = array();
        $labls = array();
        $header_flds = $rq['selected_fileds'];
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
                if (isset($cf1[2]) && !empty($cf1[2])) 
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
                        if (isset($cf1[2]) && !empty($cf1[2])) 
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
                                    $rm_cond_str .= " ({$cfn[0]} IS NULL OR {$cfn[0]} = '') ";
                                    break;
                                case 'ny':
                                    $rm_cond_str .= " ({$cfn[0]} IS NOT NULL OR {$cfn[0]} <> '') ";
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
      ////////////////// MERGE CONFIGURATIONS START ///////////////

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
                            $myData[$mykey][$mkey] = date('d/m/Y',strtotime($value));
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
                            $myData[$mykey][$mkey]= date('H:i:s',strtotime($value));
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
                        $this->db->select("*");
                        $this->db->from("currencies");
                        $this->db->where("currency_status","3");
                        $query=$this->db->get();
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
                                    $this->db->select("*");
                                    $this->db->from("currencies");
                                    $this->db->where("currency_status","3");
                                    $query=$this->db->get();
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
      
         
        $var['main_content'] = $this->load->view('admin/reports/expdf',$var,true);
        //exit;

       
        $data['page_title'] = 'Report'; // pass data to the view
       
        ini_set('memory_limit','64M'); 
        $html = $var['main_content']; // render the view into HTML
        

        $this->load->library('m_pdf');
        header('Content-Type: application/pdf');
        
        $this->m_pdf->pdf->WriteHTML($var['main_content']);
        $emailAttachment = $this->m_pdf->pdf->Output($file_name, "S");

        header('Content-Type: text/plain');


        try{
          require_once FCPATH . 'application/third_party/scrud/class/PHPMailer/class.phpmailer.php';
          $mail = new PHPMailer(true);
          //////////////////////////
          $settingKey = sha1('general');

          $var = array();
          $errors = array();
          $var['setting_key'] = $settingKey;

          $this->db->select('*');
          $this->db->from('crud_settings');
          $this->db->where('setting_key',$settingKey);
          $query = $this->db->get();
          $setting = $query->row_array();
          $setting = unserialize($setting['setting_value']);

      
          if ((int)$setting['enable_smtp'] == 1){
              $mail->IsSMTP();
              if (isset($setting['smtp_auth']) && !empty($setting['smtp_auth'])){
                  $mail->SMTPSecure = $setting['smtp_auth'];
              }
              $mail->Host       = $setting['smtp_host']; // SMTP server
              $mail->Port       = $setting['smtp_port'];  // set the SMTP port for the GMAIL server
              if ((int)$setting['enable_smtp_auth'] == 1){
                  $mail->SMTPAuth   = true;                  // enable SMTP authentication
                  $mail->Username   = $setting['smtp_account']; // SMTP account username
                  $mail->Password   = $setting['smtp_password'];        // SMTP account password
              }
          }
          //echo $user['user_email'];
          $emailAddressForPdf = $rq['email_sent_to'];
          $mail->AddAddress($emailAddressForPdf);

          //cc email addressess////
          $cc_data = $rq['cc_email'];
          
          if( !empty($cc_data))
          {
              $cc_data = explode(',', $cc_data);

              foreach($cc_data as $single_cc)
              {
                $mail->AddCC($single_cc, $single_cc);
              }
          }
          
           $mail->SetFrom($setting['email_address'], $this->lang->line('company_name'));
      
          $mail->Subject = 'Frequent Report from Flannagans Accountants';
          $mail->AddStringAttachment($emailAttachment, $file_name,
            $encoding = 'base64',
            $type = 'application/pdf');
          
          $body=' ';
          //$mail->Body = $body;
          $mail->Body = $body;

          $mail->Send();
     
          $params_email['report_id']=$rq['id'];
          $params_email['date_sent']= date('Y-m-d');
          $this->db->insert('report_email_history',$params_email);
          

        } catch (phpmailerException $e) {
            echo $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            echo $e->getMessage(); //Boring error messages from anything else!
        }

    }


}