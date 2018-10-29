<?php

    function afterInsertNewRecord($data = array()){
        $CI = & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
        global $date_format_convert;
        $this_user_id = $CRUD_AUTH['id'];

        $tbl_name = '';
        $tbl_data = array();
        /*foreach ($data as $key => $value) {
            $tbl_name = $key;
            $tbl_data = $value;          
        }*/
        switch ($data['comId']) {
            case '23':
                $id = $data['id'];

                $var = array();
                $errors = array();
                $currencies = $_POST[data][currencies];
                if (!empty($currencies)){                

                    ////////////////////////////////////
                    /////// Currency validation ////////
                    ////////////////////////////////////
                    if($currencies[currency_status]==3){
                        $CI->db->select('id');
                        $CI->db->from('currencies');
                        $CI->db->where('site_id',$CRUD_AUTH['site_id']);
                        $CI->db->where('currency_status',3);
                        $CI->db->where('id !=',$id);
                        $query = $CI->db->get();
                        if ($query->num_rows()>=1){
                            $CI->db->query("UPDATE currencies SET currency_status=1 WHERE id!=$id AND currency_status!=0 AND site_id=".$CRUD_AUTH['site_id']);
                        }
                    }
                    ///////////////////////////////////
                }
                break;
            case '80':
            case '25':

                foreach ($data as $key => $value) {
                    $tbl_name1 = $key;
                    $tbl_data1 = $value;    
                    if(is_array($tbl_data1) && $tbl_name1=='calendar'){
                        foreach($tbl_data1 as $nk => $nv) {
                            $tbl_data[$nk]=$nv;
                        }
                    }
                }
            
                $ct = new ScrudDao('calendar_types', $CI->db);
                $ctp['fields'] = array('id','color');
                $ctp['conditions'] = array('assigned_to='.$tbl_data['assigned_to'].' AND status=3');
                $ctrs = $ct->find($ctp);
                if(!$ctrs){
                    $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                    $moduleEntityParam['module_id'] = 27;
                    $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                    $cnp['id']=$moduleEntityId;
                    $cnp['type']=1;

                    $ca = new ScrudDao('crud_users', $CI->db);
                    $cp['fields'] = array('user_first_name','user_las_name','user_email');
                    $cp['conditions'] = array('id='.$tbl_data['assigned_to']);
                    $cts = $ca->find($cp);

                    $cnp['name']=$cts[0]['user_first_name'].' '.$cts[0]['user_las_name'].' ('.$cts[0]['user_email'].')';
                    $cnp['status']=3;
                    $cnp['created_by']=1;
                    $cnp['assigned_to']=$tbl_data['assigned_to'];
                    $ct->insert($cnp);
                }
                $ctrs = $ct->find($ctp);
                $assignedDefaultCalId = $ctrs[0]['id'];
                $c = new ScrudDao('calendar', $CI->db);
                $c->update(array('color'=>$ctrs[0]['color'],'eventstatus'=>$assignedDefaultCalId),array('id='.$tbl_data['id']));

                $ct = new ScrudDao('calendar_types', $CI->db);
                $ctp['fields'] = array('id');
                $ctp['conditions'] = array('assigned_to='.$tbl_data['assigned_to']);
                $ctrs = $ct->find($ctp);
                $myCalIds = array();
                foreach ($ctrs as $ck => $cv) {
                    $myCalIds[] = $cv['id'];
                }
                

                $invitedUsers = explode(",", $tbl_data['invite_calendars']);
                foreach ($invitedUsers as $key => $value) {
                    if (empty($value)) {
                        unset($invitedUsers[$key]);
                    }
                    if ($value == $assignedDefaultCalId) {
                        unset($invitedUsers[$key]);
                    }
                }
                $v = array();
                foreach ($invitedUsers as $key => $value) {
                    if (in_array($value, $myCalIds)) {
                        $cn = new ScrudDao('calendar',$CI->db);
                        $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                        $moduleEntityParam['module_id'] = 25;
                        $moduleEntityId = $moduleEntity->insert($moduleEntityParam);
                        $cnp = $tbl_data;
                        $cnp['id'] = $moduleEntityId;
                        $cnp['invite_calendars'] = '';
                        $cnp['eventstatus'] = $value;
                        $cnp['parentid'] = $tbl_data['id'];
                        //$cnp['invitation_status'] = $tbl_data['id'];
                        $cn->insert($cnp);
                    } else {
                        $cn = new ScrudDao('cal_invitations',$CI->db);
                        $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                        $moduleEntityParam['module_id'] = 81;
                        $moduleEntityId = $moduleEntity->insert($moduleEntityParam);
                        $cnp = $tbl_data;
                        $cnp['id'] = $moduleEntityId;
                        $cnp['invite_calendars'] = $value;
                        $cn->insert($cnp);
                    }
                }
                
                break;
            case '76':
                $jobparam['id'] = $data[$data['table']]['id'];
                $jobparam['chklst_id'] = $data[$data['table']]['id'];
                $jobparam['site_id'] = $CRUD_AUTH['site_id'];
                $jobparam['assigned_to'] = $data[$data['table']]['assigned_to'];
                $jobparam['created_by'] = $this_user_id;
                $jobparam['created'] = date('Y-m-d');

                $CI->db->insert('checklist',$jobparam);

                break;
            case '41':
            case '42':
            case '43':
            case '44':
            case '45':
                $id = $data['id'];
                //////////////insert blank records for new business///////////////
                $CI->db->query("INSERT INTO forms SET id = $id");
                $CI->db->query("INSERT INTO codes SET id = $id");
                $CI->db->query("INSERT INTO compliance SET id = $id");
                $CI->db->query("INSERT INTO services SET id = $id");
                $CI->db->query("INSERT INTO business_fee SET id = $id");
                $CI->db->query("INSERT INTO legal_letters_business SET id = $id");
                //////////////////////////////////////////////////////////////////

                $service=',';
                $params = array();
                if($data[$data['table']]['year_end_date']){
                    $service.='1,';
                    $service.='4,';
                    $params['Year_End_4'] = $params['Tax_Year_End'] = $data['business']['year_end_date'];

                    $params['Year_End_Date_1'] =  $data[$data['table']]['year_end_date'];
                    if ($data['business']['legal_entity'] == 1 || $data['business']['legal_entity'] == 2 || $data['business']['legal_entity'] == 5) {
                        /// get business commencement date
                        $xcd = explode('-', $data['business']['year_end_date']);
                        /// if bussiness started after april
                        /*if ($xcd[1] >= 4) {
                            /// EXPTECTED END DATE
                            $exp_end_date = $xcd[0].'-01-31';
                            $params['Due_Date_1'] = $params['Due_Date_4'] = date ( 'Y-m-d',strtotime ( '+2 years' , strtotime ( $exp_end_date ) ) );
                        } else {*/
                            /// EXPTECTED END DATE
                            $exp_end_date = $xcd[0].'-01-31';
                            $params['Due_Date_1'] = $params['Due_Date_4'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $exp_end_date ) ) );
                        //}

                    } else if ($data['business']['legal_entity'] == 3 || $data['business']['legal_entity'] == 4) {

                        /// CREATE JOB FOR RIGHT AFTER 1 YEAR OF COMMENCEMENT DATE
                        $params['Due_Date_1'] = date ( 'Y-m-d',strtotime ( '+9 months' , strtotime ( $data['business']['year_end_date'] ) ) );

                        //TAX
                        
                        $params['Due_Date_4'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $params['Tax_Year_End']) ) );                                        

                    }
                }
                /*if($data[$data['table']]['ct600_due_date']){
                    if ($data['business']['legal_entity'] == 3 || $data['business']['legal_entity'] == 4) {
                        $service.='4,';
                        $params['Tax_Year_End'] = $data['business']['ct600_due_date'];
                        /// CREATE JOB FOR RIGHT AFTER 1 YEAR OF COMMENCEMENT DATE
                        $opening_date = $data['business']['ct600_due_date'];
                        $current_date = date("Y-m-d");

                        if ($opening_date > $current_date)
                        {
                            $expected_start_date = date ( 'Y-m-d',strtotime ($opening_date) );
                        }else{
                            $expected_start_date = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $opening_date) ) );                                        
                        }

                        $params['Due_Date_4'] = date ( 'Y-m-d',strtotime ( '+9 months' , strtotime ( $expected_start_date ) ) );
                    }
                }*/

                if($data[$data['table']]['vat_quarted_end_date']){
                    $service.='3,';
                    $params['QE_Date_3']=$data['business']['vat_quarted_end_date'];
                }


                if($data[$data['table']]['date_of_incorporation'] && ($data['business']['legal_entity'] == 3 || $data['business']['legal_entity'] == 4)) {
                    $service.='2,';
                    $params['Due_Date_2']=date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ($data['business']['date_of_incorporation'] ) ) );
                }

                if($data[$data['table']]['self_assesment_due_date']) {
                    $service.='6,';
                    $xcd = explode('-', $data[$data['table']]['self_assesment_due_date']);

                    /// EXPECTED START DATE
                    $exp_start_date = $xcd[0].'-04-06';
                    $params['self_assesment_date'] = $exp_start_date;

                    /// EXPTECTED END DATE
                    $exp_end_date = $xcd[0].'-01-31';
                    $params['self_assesment_due_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $exp_end_date ) ) );
                }

                $params['Servi'] = $service;
                $CI->db->where('id',$id);
                $CI->db->update('services',$params);

                $data['table']='services';
                $data[$data['table']]['Servi'] = $service;
                $data['comId']='70';
                $data[$data['table']]['Year_End_Date_1']=$params['Year_End_Date_1'];
                $data[$data['table']]['Due_Date_1']=$params['Due_Date_1'];
                $data[$data['table']]['Ceasure_Date_1']=$params['Ceasure_Date_1'];
                $data[$data['table']]['VAT_NO']=$params['VAT_NO'];
                $data[$data['table']]['site_id']=$CRUD_AUTH['site_id'];
                $data[$data['table']]['Due_Date_2']=$params['Due_Date_2'];
                $data[$data['table']]['Submission_Date']=$params['Submission_Date'];
                $data[$data['table']]['Status_2']=$params['Status_2'];
                $data[$data['table']]['Status_Date_2']=$params['Status_Date_2'];
                $data[$data['table']]['Ceasure_Date_2']=$params['Ceasure_Date_2'];
                $data[$data['table']]['Date_of_Register_3']=$params['Date_of_Register_3'];
                $data[$data['table']]['QE_Date_3']=$params['QE_Date_3'];
                $data[$data['table']]['EC_List_3']=$params['EC_List_3'];
                $data[$data['table']]['Scheme_3']=$params['Scheme_3'];
                $data[$data['table']]['Payment_Method_3']=$params['Payment_Method_3'];
                $data[$data['table']]['Ceasure_Date_3']=$params['Ceasure_Date_3'];
                $data[$data['table']]['Year_End_4']=$params['Year_End_4'];
                $data[$data['table']]['Tax_Year_End']=$params['Tax_Year_End'];
                $data[$data['table']]['Due_Date_4']=$params['Due_Date_4'];
                $data[$data['table']]['Ceasure_Date_4']=$params['Ceasure_Date_4'];
                $data[$data['table']]['self_assesment_date']= $params['self_assesment_date'];
                $data[$data['table']]['self_assesment_due_date']= $params['self_assesment_due_date'];                //echo "<pre>";print_r($data);exit;
                $Cfunction= new Cfunctions;
                $Cfunction->afterUpdateRecord($data);

                $Cfunction->autocreateClient($data);
                $Cfunction->folder_managing($data);
                $Cfunction->legalEntityVal($data);

                break;

            //////////////code add by nauman for automatic add calendar for new employee/////
            case 32:
            case 65:

                if($data['crud_users']['group_id']!=5){
                    $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
                    
                    $cn = new ScrudDao('calendar_types',$CI->db);
                    $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                    $moduleEntityParam['module_id'] = 32;
                    $moduleEntityId = $moduleEntity->insert($moduleEntityParam);
                   
                    $cnp['id'] = $moduleEntityId;
                    $cnp['name'] = $data['crud_users']['user_first_name'] . ' ' . $data['crud_users']['user_las_name'] . ' ( '.$data['crud_users']['user_name'] . ' )';
                    $cnp['status'] = 3;
                    $cnp['type'] = 1;

                    $cnp['created_by'] = $CRUD_AUTH['id'];
                    $cnp['created'] = date('Y-m-d');
                    $cnp['assigned_to'] = $data['id'];
                    $cnp['site_id'] = $data['crud_users']['site_id'];
                                    
                    $cn->insert($cnp);
                }
                //////////////////////////////////new code nauman starts here.........
                if($data['crud_users']['group_id']!=5){
                    if (isset($data['crud_users']['holidays_entitlement']) && is_numeric($data['crud_users']['holidays_entitlement']) && ($data['crud_users']['holidays_entitlement'] > 1)) 
                    {        
                        
                        $asd1=explode("/",str_replace("-","/",$data['crud_users']['emp_start_date']));
                        $starting_month=$asd1[1];
                        
                        $CI->db->select('Holidays_End_Month');
                        $CI->db->from('sites');
                        $CI->db->where('id',$data['crud_users']['site_id']);
                        $query=$CI->db->get();
                        $row = $query->row_array();
                        $ending_month=$row['Holidays_End_Month'];

                        if(($ending_month-$starting_month)<0){
                            $month_diff=(12+($ending_month-$starting_month))+1;
                        }else{
                            $month_diff=($ending_month-$starting_month)+1;
                        }

                        $h_d=$data['crud_users']['holidays_entitlement'];
                        //getting per month holidays in a variable
                        $h_d_m=$h_d/12;
                        
                        //getting value of available holidays by multiple months & pr month holidays
                        $avail_h_days=ceil($month_diff*$h_d_m);
                           
                        $aa = new ScrudDao('crud_users',$CI->db);
                        $aa->update(array('Available_Holidays'=>$avail_h_days),array('id='.$data['crud_users']['id']));
                    }
                }
                ///////////////////////////////new code nauman ends here..............
                break;
            /////////////////////nauman code ended//////////////////////////

            ////////////////////nauman code starts/////////////////////
            case 77:
                if ($data['holiday_request']['Status']==2) {
                    $asd1=explode("/",str_replace("-","/",$data['holiday_request']['Start_Date']));
                    $d1 = $asd1[1]."/".$asd1[2]."/".$asd1[0];
                    $date1= $timestamp = strtotime($d1);

                    $asd2=explode("/",str_replace("-","/",$data['holiday_request']['End_Date']));
                    $d2 = $asd2[1]."/".$asd2[2]."/".$asd2[0];
                    $date2= $timestamp = strtotime($d2);
                        
                    $ss= date_create($d1);
                    $ee= date_create($d2);

                    $totalDiff = date_diff($ss,$ee)->format('%a')+1 ;

                    $CI->db->select('Available_Holidays');
                    $CI->db->where('id',$data['holiday_request']['assigned_to']);
                    $CI->db->from('crud_users');
                    $query = $CI->db->get();
                    $row = $query->row_array();
                    $avail_holidays=$row['Available_Holidays'];
                    
                    if($avail_holidays > $totalDiff){
                        $remaining_holidays= $avail_holidays- $totalDiff;
                    }
                    
                    if(isset($remaining_holidays)){
                        $data_n = array('Available_Holidays' => $remaining_holidays);
                        $CI->db->where('id', $data['holiday_request']['assigned_to']);
                        $CI->db->update('crud_users', $data_n);
                    }
                }
                break;
            ////////////////////nauman code ends///////////////////////

            default:
                break;
        }
       
       
    }

?>