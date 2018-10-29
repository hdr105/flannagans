<?php

    function afterUpdateRecord($data = array()){
        $CI = & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
        global $date_format_convert;
        $this_user_id = $CRUD_AUTH['id'];
        /*
            frequency:
            daily: 1 
            weekly: 2
            fortnightly: 3
            monthly: 4
            quarterly: 5
            halfyearly: 6
            yearly: 7
            biyearly:8

        */
        $d = $data[$data['table']];
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
            case '41':
            case '42':
            case '43':
            case '44':
            case '45':
                $id = $data['id'];
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
            case '70':
                //echo "<pre>";print_r($data);exit;
                    $service_ids = explode(',', ltrim(rtrim($data[$data['table']]['Servi'],','),','));

                    /// GET BUSINESS DATA OF CURRENT RECORD
                    $CI->db->select('*');
                    $CI->db->from('business');
                    $CI->db->where('id',$data['id']);
                    $query = $CI->db->get();
                    $business_data = $query->row_array();

                    // DECLARE EMPTY ARRAY FOR CREATING JOB
                    $jobparam = array();
                    $CI->db->where('business_id', $data['id']);
                    $CI->db->delete('service_sub');

                    foreach ($service_ids as $key => $value) {
                        $service_titlle = '';
                        switch ($value) {
                            case '1':
                                $service_titlle = 'Accounts';
                                $serviceID = 9;

                                /// PARAMETERS TO CREATE SERVICE ENTRY
                                $params = array(
                                        'service_id'=>$value,
                                        'frequency'=>7,
                                        'year_end_date'=>$d['Year_End_Date_'.$value],
                                        'due_date'=>$d['Due_Date_'.$value],
                                        'service_ceasor_date'=>$d['Ceasure_Date_'.$value],
                                        'service_number'=>$d['VAT_NO'],
                                        'site_id'=>$d['site_id'],
                                    );

                                /// PARAMETERS TO CREATE JOB ENTRY
                                if ($business_data['legal_entity'] == 1 || $business_data['legal_entity'] == 2 || $business_data['legal_entity'] == 5) {
                                    
                                    /// get business commencement date
                                    $xcd = explode('-', $business_data['year_end_date']);
                                    /// if bussiness started after april
                                    if ($xcd[1] >= 4) {
                                        /// EXPECTED START DATE
                                        $exp_start_date = $xcd[0].'-04-06';
                                        $jobparam['expected_start_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $exp_start_date ) ) );

                                        /// EXPTECTED END DATE
                                        $exp_end_date = $xcd[0].'-01-31';
                                        $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+2 years' , strtotime ( $exp_end_date ) ) );
                                    } else {
                                        /// EXPECTED START DATE
                                        $exp_start_date = $xcd[0].'-04-06';
                                        $jobparam['expected_start_date'] = date ( 'Y-m-d',strtotime ( $exp_start_date ) );

                                        /// EXPTECTED END DATE
                                        $exp_end_date = $xcd[0].'-01-31';
                                        $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $exp_end_date ) ) );
                                    }

                                } else if ($business_data['legal_entity'] == 3 || $business_data['legal_entity'] == 4) {

                                    /// CREATE JOB FOR RIGHT AFTER 1 YEAR OF COMMENCEMENT DATE
                                    $expected_start_date = date ( 'Y-m-d',strtotime ( '+1 days' , strtotime ( $business_data['year_end_date'] ) ) );

                                    $jobparam['expected_start_date'] =  $expected_start_date;
                                    $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+9 months' , strtotime ( $business_data['year_end_date'] ) ) );
                                }
                                break;
                            case '2':
                                $service_titlle = 'Annual Return';
                                $serviceID = 8;
                                $params = array(
                                        'service_id'=>$value,
                                        'frequency'=>5,
                                        'due_date'=>$d['Due_Date_'.$value],
                                        'actual_submission_date'=>$d['Submission_Date'],
                                        'status'=>$d['Status_'.$value],
                                        'status_date'=>$d['Status_Date_'.$value],
                                        
                                        'service_ceasor_date'=>$d['Ceasure_Date_'.$value],
                                        'service_number'=>$d['VAT_NO'],
                                        'site_id'=>$d['site_id'],
                                    );
                                if ($business_data['legal_entity'] == 3 || $business_data['legal_entity'] == 4) {
                                    $expected_start_date = date ( 'Y-m-d',strtotime ( '+1 days' , strtotime ( $business_data['date_of_incorporation'])));

                                    $jobparam['expected_start_date'] =  $expected_start_date;
                                    $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $business_data['date_of_incorporation'] ) ) );
                                }
                                break;
                            case '3':
                                $service_titlle = 'VAT';
                                $serviceID = 6;
                                $params = array(
                                        'service_id'=>$value,
                                        'frequency'=>5,
                                        'date_of_registration'=>$d['Date_of_Register_'.$value],
                                        'qe_date'=>$d['QE_Date_'.$value],
                                        'ec_list'=>$d['EC_List_'.$value],
                                        'scheme'=>$d['Scheme_'.$value],
                                        'payment_method'=>$d['Payment_Method_'.$value],
                                        'service_ceasor_date'=>$d['Ceasure_Date_'.$value],
                                        'service_number'=>$d['VAT_NO'],
                                        'site_id'=>$d['site_id'],
                                    );
                                $expected_start_date = date ( 'Y-m-d',strtotime ( '+1 days' , strtotime ( $business_data['vat_quarted_end_date'] ) ) );
                                $jobparam['expected_start_date'] =  $expected_start_date;
                                /// EXPECTED END DATE
                                $expected_end_date = date ( 'Y-m-d',strtotime ( '+2 months' , strtotime ( $business_data['vat_quarted_end_date'] ) ) );
                                $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+37 days' , strtotime ( $expected_end_date ) ) );
                                break;
                            case '4':
                                $service_titlle = 'Tax';
                                $serviceID = 10;
                                 /// PARAMETERS TO CREATE SERVICE ENTRY
                                $params = array(
                                        'service_id'=>$value,
                                        'frequency'=>5,
                                        'year_end_date'=>$d['Year_End_'.$value],
                                        'tax_year_date'=>$d['Tax_Year_End'],
                                        'due_date'=>$d['Due_Date_'.$value],
                                        'service_ceasor_date'=>$d['Ceasure_Date_'.$value],
                                        'service_number'=>$d['VAT_NO'],
                                        'site_id'=>$d['site_id'],
                                    );

                                /// PARAMETERS TO CREATE JOB ENTRY
                                if ($business_data['legal_entity'] == 1 || $business_data['legal_entity'] == 2 || $business_data['legal_entity'] == 5) {
                                    
                                    /// get business commencement date
                                    $xcd = explode('-', $business_data['year_end_date']);
                                    /// if bussiness started after april
                                    if ($xcd[1] >= 4) {
                                        /// EXPECTED START DATE
                                        $exp_start_date = $xcd[0].'-04-06';
                                        $jobparam['expected_start_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $exp_start_date ) ) );

                                        /// EXPTECTED END DATE
                                        $exp_end_date = $xcd[0].'-01-31';
                                        $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+2 years' , strtotime ( $exp_end_date ) ) );
                                    } else {
                                        /// EXPECTED START DATE
                                        $exp_start_date = $xcd[0].'-04-06';
                                        $jobparam['expected_start_date'] = date ( 'Y-m-d',strtotime ( $exp_start_date ) );

                                        /// EXPTECTED END DATE
                                        $exp_end_date = $xcd[0].'-01-31';
                                        $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $exp_end_date ) ) );
                                    }

                                } else if ($business_data['legal_entity'] == 3 || $business_data['legal_entity'] == 4) {

                                    $service_titlle = 'CT600';
                                    $serviceID = 11;

                                    $expected_start_date = date ( 'Y-m-d',strtotime ( '+1 days' , strtotime ( $business_data['year_end_date'] ) ) );

                                    $jobparam['expected_start_date'] =  $expected_start_date;
                                    $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $business_data['year_end_date'] ) ) );
                                }
                                break;
                            case '5':
                                $service_titlle = 'Payroll';
                                $serviceID = 7;
                                ////////////Nouman code////////////
                                $fre=array();
                                $fre[0]=array('Frequency'=>$d['Frequency'], 
                                    'Start_Date'=>$d['Start_Date']);
                                if(isset($d['Frequency_2']) && isset($d['Sart_Date_2']))
                                    $fre[1]=array('Frequency'=>$d['Frequency_2'], 
                                    'Start_Date'=>$d['Sart_Date_2']);
                                if(isset($d['Frequency_3']) && isset($d['Sart_Date_3']))
                                    $fre[2]=array('Frequency'=>$d['Frequency_3'], 
                                    'Start_Date'=>$d['Sart_Date_3']);
                                /////////////////////////////////////
                                $params = array(
                                        'service_id'=>$value,
                                        'frequency'=>$d['Frequency'],
                                        'acc_ref'=>$d['Account_Ref'],
                                        'staging_date'=>$d['Staging_Date'],
                                        'payroll_no'=>$d['Payroll_No'],
                                        'service_ceasor_date'=>$d['Ceasure_Date_'.$value],
                                        'service_number'=>$d['VAT_NO'],
                                        'site_id'=>$d['site_id'],
                                    );
                                /// EXPECTED START DATE
                                /* 
                                daily: 1 
                                weekly: 2
                                fortnightly: 3
                                monthly: 4
                                quarterly: 5
                                halfyearly: 6
                                yearly: 7
                                biyearly:8
                                */
                                if($d['Frequency']==1)
                                    $freq = '+1 days';
                                elseif($d['Frequency']==2)
                                    $freq = '+1 weeks';
                                elseif($d['Frequency']==3)
                                    $freq = '+2 weeks';
                                elseif($d['Frequency']==4)
                                    $freq = '+1 months';
                                elseif($d['Frequency']==5)
                                    $freq = '+1 years';
                                else
                                    $freq = '+1 weeks';

                                $expected_start_date = date ( 'Y-m-d',strtotime ( '+1 days' , strtotime ( $d['Start_Date'] ) ) );

                                $jobparam['expected_start_date'] =  $expected_start_date;
                                /// EXPECTED END DATE
                                $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( $freq , strtotime ( $expected_start_date ) ) );
                                break;
                            case '6':
                                $service_titlle = 'Self-Assesment';
                                $serviceID = 12;
                                 /// PARAMETERS TO CREATE SERVICE ENTRY
                                $params = array(
                                        'service_id'=>$value,
                                        'frequency'=>6,
                                        'year_end_date'=>$d['Year_End_'.$value],
                                        'tax_year_date'=>$d['Tax_Year_End'],
                                        'due_date'=>$d['self_assesment_due_date'],
                                        'service_ceasor_date'=>$d['Ceasure_Date_'.$value],
                                        'service_number'=>$d['VAT_NO'],
                                        'site_id'=>$d['site_id'],
                                    );

                                /// PARAMETERS TO CREATE JOB ENTRY
                                    
                                /// get business commencement date
                                $xcd = explode('-', $d['self_assesment_due_date']);

                                /// EXPECTED START DATE
                                $exp_start_date = $xcd[0].'-04-06';
                                $jobparam['expected_start_date'] = $exp_start_date;

                                /// EXPTECTED END DATE
                                $exp_end_date = $xcd[0].'-01-31';
                                $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $exp_end_date ) ) );

                                break;
                            default:
                                # code...
                                break;

                        }
                                
                        /// SELECT PREVIOUS ENTRY OF SAME SERVICE 
                        $CI->db->from('service_sub');
                        $CI->db->where('business_id',$data['id']);
                        $CI->db->where('service_id',$value);
                        $query = $CI->db->get();
                        $sub_service = $query->row_array();
                        
                        /// CHECK IF SERVICE SUBSCRIPTION ENTRY NOT ALREADY CRATED
                        if (empty($sub_service)) {
                            $params['business_id'] = $data['id'];

                            ////////////////////////////nauman code starts here////////////////////////////////////////////////
                            if($params['service_id']==5){
                                for($iii=0;$iii<count($fre);$iii++){

                                    //echo '<pre>';echo "<br/>";
                                    //echo "this time.............". $iii ."<br/>";
                                    //print_r($fre);echo count($fre);echo "<br/>";
                                    if($fre[$iii]['Frequency']==1)
                                    {   
                                        $freqForJob='Daily';
                                        $freq = '+1 days';
                                    }
                                    elseif($fre[$iii]['Frequency']==2)
                                    {
                                        $freqForJob='Weekly';
                                        $freq = '+1 weeks';
                                    }
                                    elseif($fre[$iii]['Frequency']==3)
                                    {
                                        $freqForJob='Fortnightly';
                                        $freq = '+2 weeks';
                                    }
                                    elseif($fre[$iii]['Frequency']==4)
                                    {
                                        $freqForJob='Monthly';
                                        $freq = '+1 months';
                                    }
                                    elseif($fre[$iii]['Frequency']==5)
                                    {
                                        $freqForJob='Yearly';
                                        $freq = '+1 years';
                                    }
                                    else
                                    {
                                        $freqForJob='Weekly';
                                        $freq = '+1 weeks';
                                    }
                                    $expected_start_date = date ( 'Y-m-d',strtotime ( '+1 days' , strtotime ( $fre[$iii]['Start_Date'] ) ) );

                                    $jobparam['expected_start_date'] =  $expected_start_date;
                                    /// EXPECTED END DATE
                                    $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( $freq , strtotime ( $fre[$iii]['Start_Date'] ) ) );
                                    $params['frequency']=$fre[$iii]['Frequency'];
                                    $params['start_date']=$fre[$iii]['Start_Date'];
                                    //echo "this time smid.............". $iii ."<br/>";
                                    //print_r($params);
                                    $CI->db->insert('service_sub',$params);
                                    //echo "this time mid.............". $iii ."<br/>";

                                    /// GENEREATE MODULE CRM ID
                                    $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                    $moduleEntityParam['module_id'] = '76';
                                    $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                                    /// GET MODULE PREV RECORD NO
                                    $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                                    $params2['fields'] = array('id,module_id','prefix','curr_id');
                                    $params2['conditions'] = array('module_id="76"');
                                    $params2['order'] =  array('id');
                                    $rs = $modNum->find($params2);

                                    /// GENERATE MODULE RECORD NO
                                    $moduleTable = $table;
                                    $moduleTableField = 'jobs' . 'no';
                                    $newId =  $rs[0]['curr_id'];
                                    $newId = $newId+1;
                                    $newModuleId = $rs[0]['prefix'] . $newId;
                                    $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));

                                    /// ASSING REMAINING VALUES TO JOB ARRAY
                                    $jobparam['id'] = $moduleEntityId;
                                    //$jobparam['title'] = $business_data['title'] . ' - ' .$service_titlle. ' - ' .date ( 'Y',strtotime ( '+1 years' , strtotime ( $jobparam['expected_start_date'] ) ) );
                                    $jobparam['title'] = $business_data['title'] . ' - ' .$service_titlle. ' - ' .date ( 'Y',strtotime ( $jobparam['expected_start_date'] ) ) . '-' . $freqForJob;
                                    $jobparam['business'] = $data['id'];
                                    $jobparam['job_type'] = 2;
                                    $jobparam['priority'] = 3;
                                    $jobparam['job_category'] = 2;
                                    $jobparam['job_sub_category'] = $serviceID;
                                    $jobparam['job_status'] = 1;
                                    $jobparam['assigned_to'] = $business_data['assigned_to'];
                                    $jobparam['Job_Assigned_Date'] = date('Y-m-d');
                                    $jobparam['jobsno'] = $newModuleId;
                                    $jobparam['created_by'] = $this_user_id;
                                    $jobparam['created'] = date('Y-m-d');
                                    $jobparam['site_id'] = $params['site_id'];
                                    $jobparam['frequency'] = $params['frequency'];

                                    //check old job
                                    $CI->db->where('title',$jobparam['title']);
                                    $oldjob = $CI->db->count_all_results('jobs');
                                    if($oldjob>0){
                                        $CI->db->query("DELETE FROM jobs WHERE title='".$jobparam['title']."'");
                                    }

                                    //print_r($jobparam);
                                    // CREATE FIRST TIME JOB
                                    $CI->db->insert('jobs',$jobparam);

                                    //unset($jobparam);
                                    $jobparam1['id'] = $moduleEntityId;
                                    $jobparam1['chklst_id'] = $moduleEntityId;
                                    $jobparam1['site_id'] = $CRUD_AUTH['site_id'];
                                    $jobparam1['assigned_to'] = $business_data['assigned_to'];
                                    $jobparam1['created_by'] = $this_user_id;
                                    $jobparam1['created'] = date('Y-m-d');

                                    $CI->db->insert('checklist',$jobparam1);
                                }

                            }
                                ////////////////////////////nauman code ends here////////////////////////////////////////////////
                            else{

                                /// CREATE SERVICE SUBSCRIPTION 
                                $CI->db->insert('service_sub',$params);
                                
                                /// GENEREATE MODULE CRM ID
                                $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                $moduleEntityParam['module_id'] = '76';
                                $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                                /// GET MODULE PREV RECORD NO
                                $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                                $params['fields'] = array('id,module_id','prefix','curr_id');
                                $params['conditions'] = array('module_id="76"');
                                $params['order'] =  array('id');
                                $rs = $modNum->find($params);

                                /// GENERATE MODULE RECORD NO
                                $moduleTable = $table;
                                $moduleTableField = 'jobs' . 'no';
                                $newId =  $rs[0]['curr_id'];
                                $newId = $newId+1;
                                $newModuleId = $rs[0]['prefix'] . $newId;
                                $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));

                                /// ASSING REMAINING VALUES TO JOB ARRAY
                                $jobparam['id'] = $moduleEntityId;
                                //$jobparam['title'] = $business_data['title'] . ' - ' .$service_titlle. ' - ' .date ( 'Y',strtotime ( '+1 years' , strtotime ( $jobparam['expected_start_date'] ) ) );
                                $jobparam['title'] = $business_data['title'] . ' - ' .$service_titlle. ' - ' .date ( 'Y',strtotime ( $jobparam['expected_start_date'] ) );
                                $jobparam['business'] = $data['id'];
                                $jobparam['job_type'] = 2;
                                $jobparam['priority'] = 3;
                                $jobparam['job_category'] = 2;
                                $jobparam['job_sub_category'] = $serviceID;
                                $jobparam['job_status'] = 1;
                                $jobparam['assigned_to'] = $business_data['assigned_to'];
                                $jobparam['Job_Assigned_Date'] = date('Y-m-d');
                                $jobparam['jobsno'] = $newModuleId;
                                $jobparam['created_by'] = $this_user_id;
                                $jobparam['created'] = date('Y-m-d');
                                $jobparam['site_id'] = $params['site_id'];
                                $jobparam['frequency'] = $params['frequency'];

                                //check old job
                                $CI->db->where('title',$jobparam['title']);
                                $oldjob = $CI->db->count_all_results('jobs');
                                if($oldjob>0){
                                    $CI->db->query("DELETE FROM jobs WHERE title='".$jobparam['title']."'");
                                }


                                // CREATE FIRST TIME JOB
                                $CI->db->insert('jobs',$jobparam);

                                unset($jobparam);
                                $jobparam['id'] = $moduleEntityId;
                                $jobparam['chklst_id'] = $moduleEntityId;
                                $jobparam['site_id'] = $CRUD_AUTH['site_id'];
                                $jobparam['assigned_to'] = $business_data['assigned_to'];
                                $jobparam['created_by'] = $this_user_id;
                                $jobparam['created'] = date('Y-m-d');

                                $CI->db->insert('checklist',$jobparam);
                            }

                            if(isset($jobparam))unset($jobparam);

                        }
  
                                
                    }

                break;
            case '76':
                $job_catagory = $data[$data['table']]['job_sub_category'];
                $d = $data[$data['table']];
                /// GET BUSINESS DATA OF CURRENT RECORD
                $CI->db->select('*');
                $CI->db->from('business');
                $CI->db->where('id',$data[$data['table']]['business']);
                $query = $CI->db->get();
                $business_data = $query->row_array();
                /// LAST JOB EXPECTED START DATE
                $pre_exp_start_date = $data[$data['table']]['expected_start_date'];
                /// LAST JOB EEXPECTED END DATE 
                $pre_exp_end_date = $data[$data['table']]['expected_end_date'];
                // DECLARE EMPTY ARRAY FOR CREATING JOB
                //$jobparam = $data[$data['table']];
                $jobparam['business'] = $data[$data['table']]['business'];
                $jobparam['job_type'] = $data[$data['table']]['job_type'];
                $jobparam['contact'] = $data[$data['table']]['contact'];
                $jobparam['job_category'] = $data[$data['table']]['job_category'];
                $jobparam['job_sub_category'] = $data[$data['table']]['job_sub_category'];
                $jobparam['priority'] = $data[$data['table']]['priority'];
                $jobparam['site_id'] = $data[$data['table']]['site_id'];

                switch ($job_catagory) {
                    case '1':
                        $service_titlle = 'Letter/Official Document';
                        break;
                    case '2':
                        $service_titlle = 'Tax Planning';
                        break;
                    case '3':
                        $service_titlle = 'Inheritance';
                        break;
                    case '4':
                        $service_titlle = 'General Advice';
                        break;
                    case '5':
                        $service_titlle = 'Other';
                        break;
                    case '6':
                        $service_titlle = 'VAT';
                        $expected_start_date = date ( 'Y-m-d',strtotime ( '+1 days' , strtotime ( $pre_exp_end_date ) ) );
                        $jobparam['expected_start_date'] =  $expected_start_date;
                        /// EXPECTED END DATE
                        $expected_end_date = date ( 'Y-m-d',strtotime ( '+2 months' , strtotime ( $pre_exp_end_date ) ) );
                        $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+37 days' , strtotime ( $expected_end_date ) ) );
                        break;
                    case '7':
                        $service_titlle = 'Payroll';
                        if($d['frequency']==1){
                            $freqForJob = 'Daily';
                            $freq = '+1 days';
                        }
                        elseif($d['frequency']==2){
                            $freqForJob = 'Weekly';
                            $freq = '+1 weeks';
                        }
                        elseif($d['frequency']==3){
                            $freqForJob='Fortnightly';
                            $freq = '+2 weeks';
                        }
                        elseif($d['frequency']==4){
                            $freqForJob = 'Monthly';
                            $freq = '+1 months';
                        }
                        elseif($d['frequency']==5){
                            $freqForJob = 'Yearly';
                            $freq = '+1 years';
                        }
                        else{
                            $freqForJob = 'Weekly';
                            $freq = '+1 weeks';
                        }

                        $expected_start_date = date ( 'Y-m-d',strtotime ( '+1 days' , strtotime ( $pre_exp_end_date ) ) );

                        $jobparam['expected_start_date'] =  $expected_start_date;
                        /// EXPECTED END DATE
                        $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( $freq , strtotime ( $pre_exp_end_date ) ) );
                        break;
                    case '8':
                        $service_titlle = 'Annual Return';
                        if ($business_data['legal_entity'] == 3 || $business_data['legal_entity'] == 4) {
                            $expected_start_date = date ( 'Y-m-d',strtotime ( '+1 days' , strtotime ( $pre_exp_end_date)));

                            $jobparam['expected_start_date'] =  $expected_start_date;
                            $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $pre_exp_end_date ) ) );
                        }
                        break;
                    case '9':
                        $service_titlle = 'Accounts';

                        /// PARAMETERS TO CREATE JOB ENTRY

                        /// CREATE JOB FOR RIGHT AFTER 1 YEAR OF COMMENCEMENT DATE
                        $expected_start_date = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $pre_exp_start_date ) ) );

                        $jobparam['expected_start_date'] =  $expected_start_date;
                        $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $pre_exp_end_date ) ) );
                        break;
                    case '10':
                        $service_titlle = 'Tax';
                        if ($business_data['legal_entity'] == 1 || $business_data['legal_entity'] == 2 || $business_data['legal_entity'] == 5) {
                                                
                            /// EXPECTED START DATE
                            $jobparam['expected_start_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $pre_exp_start_date ) ) );
                            $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $pre_exp_end_date ) ) );
                        }  
                        break;
                    case '11':
                        $service_titlle = 'CT600';
                        if ($business_data['legal_entity'] == 3 || $business_data['legal_entity'] == 4) {

                            /// EXPECTED START DATE
                            $jobparam['expected_start_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $pre_exp_start_date ) ) );
                            $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $pre_exp_end_date ) ) );
                        }
                        break;
                    case '12':
                        $service_titlle = 'Self-Assesment';
                            
                        /// EXPECTED START DATE
                        $jobparam['expected_start_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $pre_exp_start_date ) ) );
                        $jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( $pre_exp_end_date ) ) );

                        break;
                    default:
                        # code...
                        break;
                }
                if ($data[$data['table']]['job_status'] == 2) {
                    /// GENEREATE MODULE CRM ID
                    $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                    $moduleEntityParam['module_id'] = '76';
                    $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                    /// GET MODULE PREV RECORD NO
                    $params = array();
                    $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                    $params['fields'] = array('id,module_id','prefix','curr_id');
                    $params['conditions'] = array('module_id="76"');
                    $params['order'] =  array('id');
                    $rs = $modNum->find($params);

                    /// GENERATE MODULE RECORD NO
                    $moduleTable = $table;
                    $moduleTableField = 'jobs' . 'no';
                    $newId =  $rs[0]['curr_id'];
                    $newId = $newId+1;
                    $newModuleId = $rs[0]['prefix'] . $newId;
                    $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));

                    /// ASSING REMAINING VALUES TO JOB ARRAY
                    $jobparam['id'] = $moduleEntityId;
                    if($freqForJob)
                        $jobparam['title'] = $business_data['title'] . ' - ' .$service_titlle.' - '.$freqForJob. ' - ' . date('Y', strtotime($jobparam['expected_start_date']));
                    else
                        $jobparam['title'] = $business_data['title'] . ' - ' .$service_titlle.' - ' . date('Y', strtotime($jobparam['expected_start_date']));

                    $CI->db->from('jobs');
                    $CI->db->where('title',$jobparam['title']);
                    $query=$CI->db->get();
                    if($query->num_rows()<1){
                        $jobparam['job_status'] = 1;
                        $jobparam['assigned_to'] = $business_data['assigned_to'];
                        $jobparam['Job_Assigned_Date'] = date('Y-m-d');
                        $jobparam['jobsno'] = $newModuleId;
                        $jobparam['created_by'] = $this_user_id;
                        $jobparam['created'] = date('Y-m-d');
                        unset($jobparam['actual_start_date'],$jobparam['actual_end_date'],$jobparam['actual_time_spent']);

                        //die(print_r($jobparam));
                        // CREATE FIRST TIME JOB
                        $CI->db->insert('jobs',$jobparam);

                        unset($jobparam);
                        $jobparam['id'] = $moduleEntityId;
                        $jobparam['chklst_id'] = $moduleEntityId;
                        $jobparam['site_id'] = $CRUD_AUTH['site_id'];
                        $jobparam['assigned_to'] = $business_data['assigned_to'];
                        $jobparam['created_by'] = $this_user_id;
                        $jobparam['created'] = date('Y-m-d');

                        $CI->db->insert('checklist',$jobparam);
                    }
                }
                break;
            case '59':
            case '60':
            case '61':
            case '62':
                /**
                 * For documents uploaded by ajax and models in comId=62
                 * For Documents and Folders 
                 * Management
                 * @param business_name
                 *        for getting business-folde-id from doc_folder table
                 *        for getting assigned_to-id from doc_folder table
                 * @param site_id
                 * @param comId
                 */
                    $new_data = array();
                         /*echo '<pre>';
                         print_r($data);
                         die;*/
                         if($data['business_name']=='' or is_null($data['business_name']) or !isset($data['business_name'])){
                            $CI->db->select('title');
                            $CI->db->from('business');
                            $CI->db->where('id',$data['id']);
                            $query = $CI->db->get();
                            $business = $query->row_array();
                            $data['business_name'] = $business['title'];
                         }
                    foreach ($data['compliance'] as $key => $value) {
                        if ($key === 'proof_of_address' && !empty($value)) {
                            $table = $key;
                            $ids = explode(',', $value);
                            foreach ($ids as $id) {
                                $CI->db->select('*');
                                $CI->db->from($table);
                                $CI->db->where('id',$id);
                                $query = $CI->db->get();
                                $new_data[] = $query->row_array();
                            }
                            $file_no = 0;
                            foreach ($new_data as $value) {
                                $file_name = $value['attached_document'];
                                $file_name;
                                if (!empty($file_name)) {
                                    /**
                                     * Getting business folder_id form doc_folder table by using business name
                                     * Getting business assigned_to form doc_folder table by using business name
                                     */
                                    $CI->db->select('*');
                                    $CI->db->from('doc_folders');
                                    $CI->db->where('folder_name',$data['business_name']);
                                    $query = $CI->db->get();
                                    $parent_folder = $query->row_array();
                                    $parent_folder_id = $parent_folder['id'];
                                    $assigned_to = $parent_folder['assigned_to'];
                                    
                                    ///////////////////////////////////////////////////////
                                    // Detecting if file being updating or new uploading //
                                    ///////////////////////////////////////////////////////
                                    $CI->db->select('*');
                                    $CI->db->from('doc_folders');
                                    $CI->db->where('Parent_Folder', $parent_folder_id);
                                    $CI->db->where('folder_name',$data['fieldtype'][0]['section_title']);
                                    $query = $CI->db->get();
                                    $foler_exists = $query->row_array();
                                        
                                    if (!(count($foler_exists) >0)) {

                                        /////////////////////////////////
                                        // If new file being uploading //
                                        /////////////////////////////////
                                        
                                        /*GENERATE moduleEntity id for folder*/
                                        $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                        $moduleEntityParam['module_id'] = '29';
                                        $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                                        /// GET MODULE PREV RECORD NO
                                        $params = array();
                                        $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                                        $params['fields'] = array('id,module_id','prefix','curr_id');
                                        $params['conditions'] = array('module_id="'.$data['comId'].'"');
                                        $params['order'] =  array('id');
                                        $rs = $modNum->find($params);

                                        /// GENERATE MODULE RECORD NO
                                        $moduleTable = $table;
                                        $moduleTableField = $table . 'no';
                                        $newId =  $rs[0]['curr_id'];
                                        $newId = $newId+1;
                                        $newModuleIdForFolder = $rs[0]['prefix'] . $newId;
                                        $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));
                                        $newModuleIdForFolder;

                                        /////////////////////////////
                                        // Folder table parameters //
                                        /////////////////////////////
                                        
                                        $folder_param['id'] = $moduleEntityId;
                                        $folder_param['folder_name'] = $data['fieldtype'][0]['section_title'];
                                        $folder_param['Parent_Folder'] = $parent_folder_id;
                                        $folder_param['site_id'] = $CRUD_AUTH['site_id'];
                                        $folder_param['module'] = $data['comId'];
                                        $folder_param['created_by'] = $data['user_id'];
                                        $folder_param['created']= date('Y-m-d H:i:s');
                                        $folder_param['assigned_to'] = $assigned_to;
                                        $folder_param['doc_foldersno'] = $newModuleIdForFolder;
                                           
                                        /*Inser into Folder table*/
                                        $CI->db->insert('doc_folders',$folder_param);
                                        $folder_id = $moduleEntityId;
                                    }else{
                                        $folder_id = $foler_exists['id'];
                                    }
                                    ////////////////////////////
                                    // If file being updating //
                                    ////////////////////////////
                                    $CI->db->select('*');
                                    $CI->db->from('crm_documents');
                                    $CI->db->where('folder_name', $folder_id);
                                    $query = $CI->db->get();
                                    $file_exists = $query->result_array();
                                    if (isset($file_exists[$file_no])) {
                                        $doc_param['file'] = $file_name;
                                        $doc_param['modified_by'] = $data['user_id'];
                                        $doc_param['modified']= date('Y-m-d H:i:s');
                                        $CI->db->where('id', $file_exists[$file_no]['id']);
                                        $CI->db->update('crm_documents', $doc_param);
                                    }else{
                                        /*GENERATE moduleEntity id for Docs*/
                                        $moduleEntityForDoc = new ScrudDao('crud_module_entity_ids', $CI->db);
                                        $moduleEntityForDocParam['module_id'] = '30';
                                        $moduleEntityForDocId = $moduleEntityForDoc->insert($moduleEntityForDocParam);

                                        /// GET MODULE PREV RECORD NO
                                        $params = array();
                                        $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                                        $params['fields'] = array('id,module_id','prefix','curr_id');
                                        $params['conditions'] = array('module_id="'.$data['comId'].'"');
                                        $params['order'] =  array('id');
                                        $rs = $modNum->find($params);

                                        /// GENERATE MODULE RECORD NO
                                        $moduleTable = $table;
                                        $moduleTableField = $table . 'no';
                                        $newId =  $rs[0]['curr_id'];
                                        $newId = $newId+1;
                                        $newModuleIdForDoc = $rs[0]['prefix'] . $newId;
                                        $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));
                                        $newModuleIdForDoc;
                                        
                                        /*Docs table parameters*/
                                        $doc_param['id'] = $moduleEntityForDocId;
                                        $doc_param['subject'] = $data['fieldtype'][0]['section_title'];
                                        $doc_param['folder_name'] = $folder_id;
                                        $doc_param['file'] = $file_name;
                                        $doc_param['site_id'] = $CRUD_AUTH['site_id'];
                                        $doc_param['status'] = 1;
                                        $doc_param['created_by'] = $data['user_id'];
                                        $doc_param['created']= date('Y-m-d H:i:s');
                                        $doc_param['assigned_to'] = $assigned_to;
                                        $doc_param['crm_documentsno'] = $newModuleIdForDoc;

                                        /*Inser into Docs table*/
                                        $CI->db->insert('crm_documents',$doc_param);
                                    }
                                    $file_no++;
                                }
                            }
                        }
                        if ($key === 'proof_of_garantee' && !empty($value)) {
                            $table = $key;
                            $ids = explode(',', $value);
                            if (!empty($ids)) {
                                foreach ($ids as $id) {
                                    $CI->db->select('*');
                                    $CI->db->from('proof_garranty');
                                    $CI->db->where('id',$id);
                                    $query = $CI->db->get();
                                    $new_data[] = $query->row_array();
                                }
                                $file_no = 0;
                                foreach ($new_data as $value) {
                                    $file_name = $value['attached_document'];
                                    $file_name;
                                    if (!empty($file_name)) {
                                        /**
                                         * Getting business folder_id form doc_folder table by using business name
                                         * Getting business assigned_to form doc_folder table by using business name
                                         */
                                        $CI->db->select('*');
                                        $CI->db->from('doc_folders');
                                        $CI->db->where('folder_name',$data['business_name']);
                                        $query = $CI->db->get();
                                        $parent_folder = $query->row_array();
                                        $parent_folder_id = $parent_folder['id'];
                                        $assigned_to = $parent_folder['assigned_to'];
                                        
                                        ///////////////////////////////////////////////////////
                                        // Detecting if file being updating or new uploading //
                                        ///////////////////////////////////////////////////////
                                        $CI->db->select('*');
                                        $CI->db->from('doc_folders');
                                        $CI->db->where('Parent_Folder', $parent_folder_id);
                                        $CI->db->where('folder_name',$data['fieldtype'][2]['section_title']);
                                        $query = $CI->db->get();
                                        $foler_exists = $query->row_array();
                                            
                                        if (!(count($foler_exists) >0)) {

                                            /////////////////////////////////
                                            // If new file being uploading //
                                            /////////////////////////////////
                                            
                                            /*GENERATE moduleEntity id for folder*/
                                            $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                            $moduleEntityParam['module_id'] = '29';
                                            $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                                            /// GET MODULE PREV RECORD NO
                                            $params = array();
                                            $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                                            $params['fields'] = array('id,module_id','prefix','curr_id');
                                            $params['conditions'] = array('module_id="'.$data['comId'].'"');
                                            $params['order'] =  array('id');
                                            $rs = $modNum->find($params);

                                            /// GENERATE MODULE RECORD NO
                                            $moduleTable = $table;
                                            $moduleTableField = $table . 'no';
                                            $newId =  $rs[0]['curr_id'];
                                            $newId = $newId+1;
                                            $newModuleIdForFolder = $rs[0]['prefix'] . $newId;
                                            $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));
                                            $newModuleIdForFolder;

                                            /////////////////////////////
                                            // Folder table parameters //
                                            /////////////////////////////
                                            
                                            $folder_param['id'] = $moduleEntityId;
                                            $folder_param['folder_name'] = $data['fieldtype'][2]['section_title'];
                                            $folder_param['Parent_Folder'] = $parent_folder_id;
                                            $folder_param['site_id'] = $CRUD_AUTH['site_id'];
                                            $folder_param['module'] = $data['comId'];
                                            $folder_param['created_by'] = $data['user_id'];
                                            $folder_param['created']= date('Y-m-d H:i:s');
                                            $folder_param['assigned_to'] = $assigned_to;
                                            $folder_param['doc_foldersno'] = $newModuleIdForFolder;
                                               
                                            /*Inser into Folder table*/
                                            $CI->db->insert('doc_folders',$folder_param);
                                            $folder_id = $moduleEntityId;
                                        }else{
                                            $folder_id = $foler_exists['id'];
                                        }
                                        ////////////////////////////
                                        // If file being updating //
                                        ////////////////////////////
                                        $CI->db->select('*');
                                        $CI->db->from('crm_documents');
                                        $CI->db->where('folder_name', $folder_id);
                                        $query = $CI->db->get();
                                        $file_exists = $query->result_array();
                                        if (isset($file_exists[$file_no])) {
                                            $doc_param['file'] = $file_name;
                                            $doc_param['modified_by'] = $data['user_id'];
                                            $doc_param['modified']= date('Y-m-d H:i:s');
                                            $CI->db->where('id', $file_exists[$file_no]['id']);
                                            $CI->db->update('crm_documents', $doc_param);
                                        }else{
                                            /*GENERATE moduleEntity id for Docs*/
                                            $moduleEntityForDoc = new ScrudDao('crud_module_entity_ids', $CI->db);
                                            $moduleEntityForDocParam['module_id'] = '30';
                                            $moduleEntityForDocId = $moduleEntityForDoc->insert($moduleEntityForDocParam);

                                            /// GET MODULE PREV RECORD NO
                                            $params = array();
                                            $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                                            $params['fields'] = array('id,module_id','prefix','curr_id');
                                            $params['conditions'] = array('module_id="'.$data['comId'].'"');
                                            $params['order'] =  array('id');
                                            $rs = $modNum->find($params);

                                            /// GENERATE MODULE RECORD NO
                                            $moduleTable = $table;
                                            $moduleTableField = $table . 'no';
                                            $newId =  $rs[0]['curr_id'];
                                            $newId = $newId+1;
                                            $newModuleIdForDoc = $rs[0]['prefix'] . $newId;
                                            $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));
                                            $newModuleIdForDoc;
                                            
                                            /*Docs table parameters*/
                                            $doc_param['id'] = $moduleEntityForDocId;
                                            $doc_param['subject'] = $data['fieldtype'][2]['section_title'];
                                            $doc_param['folder_name'] = $folder_id;
                                            $doc_param['file'] = $file_name;
                                            $doc_param['site_id'] = $CRUD_AUTH['site_id'];
                                            $doc_param['status'] = 1;
                                            $doc_param['created_by'] = $data['user_id'];
                                            $doc_param['created']= date('Y-m-d H:i:s');
                                            $doc_param['assigned_to'] = $assigned_to;
                                            $doc_param['crm_documentsno'] = $newModuleIdForDoc;

                                            /*Inser into Docs table*/
                                            $CI->db->insert('crm_documents',$doc_param);
                                        }
                                        $file_no++;
                                    }
                            }
                            }
                        }
                        if ($key === 'proof_of_id' && !empty($value)) {
                            $table = $key;
                            $ids = explode(',', $value);
                            if (!empty($ids)) {
                                foreach ($ids as $id) {
                                    $CI->db->select('*');
                                    $CI->db->from($table);
                                    $CI->db->where('id',$id);
                                    $query = $CI->db->get();
                                    $new_data[] = $query->row_array();
                                }
                                $file_no = 0;
                                foreach ($new_data as $value) {
                                    $file_name = $value['attached_document'];
                                    $file_name;
                                    if (!empty($file_name)) {
                                        /**
                                         * Getting business folder_id form doc_folder table by using business name
                                         * Getting business assigned_to form doc_folder table by using business name
                                         */
                                        $CI->db->select('*');
                                        $CI->db->from('doc_folders');
                                        $CI->db->where('folder_name',$data['business_name']);
                                        $query = $CI->db->get();
                                        $parent_folder = $query->row_array();
                                        $parent_folder_id = $parent_folder['id'];
                                        $assigned_to = $parent_folder['assigned_to'];
                                        
                                        ///////////////////////////////////////////////////////
                                        // Detecting if file being updating or new uploading //
                                        ///////////////////////////////////////////////////////
                                        $CI->db->select('*');
                                        $CI->db->from('doc_folders');
                                        $CI->db->where('Parent_Folder', $parent_folder_id);
                                        $CI->db->where('folder_name',$data['fieldtype'][1]['section_title']);
                                        $query = $CI->db->get();
                                        $foler_exists = $query->row_array();

                                        if (!(count($foler_exists) >0)) {
                                            /////////////////////////////////
                                            // If new file being uploading //
                                            /////////////////////////////////
                                            
                                            /*GENERATE moduleEntity id for folder*/
                                            $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                                            $moduleEntityParam['module_id'] = '29';
                                            $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                                            /// GET MODULE PREV RECORD NO
                                            $params = array();
                                            $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                                            $params['fields'] = array('id,module_id','prefix','curr_id');
                                            $params['conditions'] = array('module_id="'.$data['comId'].'"');
                                            $params['order'] =  array('id');
                                            $rs = $modNum->find($params);

                                            /// GENERATE MODULE RECORD NO
                                            $moduleTable = $table;
                                            $moduleTableField = $table . 'no';
                                            $newId =  $rs[0]['curr_id'];
                                            $newId = $newId+1;
                                            $newModuleIdForFolder = $rs[0]['prefix'] . $newId;
                                            $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));
                                            $newModuleIdForFolder;

                                            /////////////////////////////
                                            // Folder table parameters //
                                            /////////////////////////////
                                            
                                            $folder_param['id'] = $moduleEntityId;
                                            $folder_param['folder_name'] = $data['fieldtype'][1]['section_title'];
                                            $folder_param['Parent_Folder'] = $parent_folder_id;
                                            $folder_param['site_id'] = $CRUD_AUTH['site_id'];
                                            $folder_param['module'] = $data['comId'];
                                            $folder_param['created_by'] = $data['user_id'];
                                            $folder_param['created']= date('Y-m-d H:i:s');
                                            $folder_param['assigned_to'] = $assigned_to;
                                            $folder_param['doc_foldersno'] = $newModuleIdForFolder;
                                               
                                            /*Inser into Folder table*/
                                            $CI->db->insert('doc_folders',$folder_param);
                                            $folder_id = $moduleEntityId;
                                        }else{
                                            $folder_id = $foler_exists['id'];
                                        }
                                        ////////////////////////////
                                        // If file being updating //
                                        ////////////////////////////
                                        $CI->db->select('*');
                                        $CI->db->from('crm_documents');
                                        $CI->db->where('folder_name', $folder_id);
                                        $query = $CI->db->get();
                                        $file_exists = $query->result_array();
                                        if (isset($file_exists[$file_no])) {
                                            $doc_param['file'] = $file_name;
                                            $doc_param['modified_by'] = $data['user_id'];
                                            $doc_param['modified']= date('Y-m-d H:i:s');
                                            $CI->db->where('id', $file_exists[$file_no]['id']);
                                            $CI->db->update('crm_documents', $doc_param);
                                        }else{
                                            /*GENERATE moduleEntity id for Docs*/
                                            $moduleEntityForDoc = new ScrudDao('crud_module_entity_ids', $CI->db);
                                            $moduleEntityForDocParam['module_id'] = '30';
                                            $moduleEntityForDocId = $moduleEntityForDoc->insert($moduleEntityForDocParam);

                                            /// GET MODULE PREV RECORD NO
                                            $params = array();
                                            $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                                            $params['fields'] = array('id,module_id','prefix','curr_id');
                                            $params['conditions'] = array('module_id="'.$data['comId'].'"');
                                            $params['order'] =  array('id');
                                            $rs = $modNum->find($params);

                                            /// GENERATE MODULE RECORD NO
                                            $moduleTable = $table;
                                            $moduleTableField = $table . 'no';
                                            $newId =  $rs[0]['curr_id'];
                                            $newId = $newId+1;
                                            $newModuleIdForDoc = $rs[0]['prefix'] . $newId;
                                            $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));
                                            $newModuleIdForDoc;
                                            
                                            /*Docs table parameters*/
                                            $doc_param['id'] = $moduleEntityForDocId;
                                            $doc_param['subject'] = $data['fieldtype'][1]['section_title'];
                                            $doc_param['folder_name'] = $folder_id;
                                            $doc_param['file'] = $file_name;
                                            $doc_param['site_id'] = $CRUD_AUTH['site_id'];
                                            $doc_param['status'] = 1;
                                            $doc_param['created_by'] = $data['user_id'];
                                            $doc_param['created']= date('Y-m-d H:i:s');
                                            $doc_param['assigned_to'] = $assigned_to;
                                            $doc_param['crm_documentsno'] = $newModuleIdForDoc;

                                            /*Inser into Docs table*/
                                            $CI->db->insert('crm_documents',$doc_param);
                                        }
                                        $file_no++;
                                    }
                                }
                            }
                        }
                    }
            break; 
            /**
             * Case for comId 64
             * For Documents and Folders 
             * Management
             * @param business_name     
             *        for getting business-folde-id from doc_folder table
             *        for getting assigned_to-id from doc_folder table
             * @param site_id
             * @param comId
             */
            case '64':
                if (! empty($data['business_fee']['Payment_Form']) ) {
                    /**
                     * Getting business folder_id form doc_folder table by using business name
                     * Getting business assigned_to form doc_folder table by using business name
                     */
                    $CI->db->select('*');
                    $CI->db->from('doc_folders');
                    $CI->db->where('folder_name',$data['business_name']);
                    $query = $CI->db->get();
                    $parent_folder = $query->row_array();
                    $parent_folder_id = $parent_folder['id'];
                    if(!$parent_folder_id){
                        //Auto-create FOlder

                        $CI->db->select('title,user_id');
                        $CI->db->from('business');
                        $CI->db->where('title',$data['business_name']);
                        $query = $CI->db->get();
                        $business_data = $query->row_array();

                        /// GENEREATE MODULE CRM ID
                        $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                        $moduleEntityParam['module_id'] = '29';
                        $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                        /// GET MODULE PREV RECORD NO
                        $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                        $params['fields'] = array('id,module_id','prefix','curr_id');
                        $params['conditions'] = array('module_id="29"');
                        $params['order'] =  array('id');
                        $rs = $modNum->find($params);

                        /// GENERATE MODULE RECORD NO
                        $moduleTable = $table;
                        $moduleTableField = 'doc_folders' . 'no';
                        $newId =  $rs[0]['curr_id'];
                        $newId = $newId+1;
                        $newModuleId = $rs[0]['prefix'] . $newId;
                        $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));

                        /// ASSING REMAINING VALUES TO JOB ARRAY
                        $folder['id'] = $moduleEntityId;
                        $folder['folder_name'] = $business_data['title'];
                        $folder['Parent_Folder'] = 0;
                        $folder['module'] = 65;
                        $folder['assigned_to'] = $business_data['user_id'];
                        $folder['doc_foldersno'] = $newModuleId;
                        $folder['created_by'] = $CRUD_AUTH['user_id'];
                        $folder['created'] = date('Y-m-d');
                        $folder['site_id'] = $CRUD_AUTH['site_id'];
                        // CREATE FIRST TIME JOB

                        $CI->db->insert('doc_folders', $folder);

                        $data = array('Folder' => $moduleEntityId);
                        $CI->db->where('id', $business_data['user_id']);
                        $CI->db->update('crud_users', $data);
                    
                    }

                    $CI->db->select('*');
                    $CI->db->from('doc_folders');
                    $CI->db->where('folder_name',$data['business_name']);
                    $query = $CI->db->get();
                    $parent_folder = $query->row_array();
                    $parent_folder_id = $parent_folder['id'];
                    $assigned_to = $parent_folder['assigned_to'];
                    
                    /////////////////////////////////////////////////////
                    // Detecting if file being updated or new uploaded //
                    /////////////////////////////////////////////////////
                    $CI->db->select('*');
                    $CI->db->from('doc_folders');
                    $CI->db->where('Parent_Folder',$parent_folder_id);
                    $CI->db->where('folder_name',$data['fieldtype'][0]['section_title']);
                    $query = $CI->db->get();
                    $image_data = $query->row_array();

                    if (count($image_data) >0) {
                        ///////////////////////////
                        // if file being updated //
                        ///////////////////////////
                        $doc_param['file'] = $data['business_fee']['Payment_Form'];
                        $doc_param['modified_by'] = $data['user_id'];
                        $doc_param['modified']= date('Y-m-d H:i:s');
                        $CI->db->where('folder_name', $image_data['id']);
                        $CI->db->update('crm_documents', $doc_param);
                    }else{
                        ////////////////////////////////
                        // if file being new uploaded //
                        ////////////////////////////////
                        
                        /*GENERATE moduleEntity id for folder*/
                        $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                        $moduleEntityParam['module_id'] = '29';
                        $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                        /// GET MODULE PREV RECORD NO
                        $params = array();
                        $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                        $params['fields'] = array('id,module_id','prefix','curr_id');
                        $params['conditions'] = array('module_id=29');
                        $params['order'] =  array('id');
                        $rs = $modNum->find($params);

                        /// GENERATE MODULE RECORD NO
                        $moduleTable = $table;
                        $moduleTableField = $table . 'no';
                        $newId =  $rs[0]['curr_id'];
                        $newId = $newId+1;
                        $newModuleIdForFolder = $rs[0]['prefix'] . $newId;
                        $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));
                        $newModuleIdForFolder;

                        /////////////////////////////
                        // Folder table parameters //
                        /////////////////////////////
                        $folder_param['id'] = $moduleEntityId;
                        $folder_param['folder_name'] = $data['module_name'];
                        $folder_param['Parent_Folder'] = $parent_folder_id;
                        $folder_param['module'] = $data['comId'];
                        $folder_param['site_id'] = $data['business_fee']['site_id'];
                        $folder_param['created_by'] = $data['user_id'];
                        $folder_param['created']= date('Y-m-d H:i:s');
                        $folder_param['assigned_to'] = $assigned_to;
                        $folder_param['doc_foldersno'] = $newModuleIdForFolder;
                        /*Inser into Folder table*/
                        $CI->db->insert('doc_folders',$folder_param);

                        /*GENERATE moduleEntity id for Docs*/
                        $moduleEntityForDoc = new ScrudDao('crud_module_entity_ids', $CI->db);
                        $moduleEntityForDocParam['module_id'] = '30';
                        $moduleEntityForDocId = $moduleEntityForDoc->insert($moduleEntityForDocParam);

                        /// GET MODULE PREV RECORD NO
                        $params = array();
                        $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                        $params['fields'] = array('id,module_id','prefix','curr_id');
                        $params['conditions'] = array('module_id=30');
                        $params['order'] =  array('id');
                        $rs = $modNum->find($params);

                        /// GENERATE MODULE RECORD NO
                        $moduleTable = $table;
                        $moduleTableField = $table . 'no';
                        $newId =  $rs[0]['curr_id'];
                        $newId = $newId+1;
                        $newModuleIdForDoc = $rs[0]['prefix'] . $newId;
                        $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));
                        $newModuleIdForDoc;
                        
                        ///////////////////////////
                        // Docs table parameters //
                        ///////////////////////////
                        $doc_param['id'] = $moduleEntityForDocId;
                        $doc_param['subject'] = $data['fieldtype'][0]['section_title'];
                        $doc_param['folder_name'] = $folder_param['id'];
                        $doc_param['file'] = $data['business_fee']['Payment_Form'];
                        $doc_param['site_id'] = $data['business_fee']['site_id'];
                        $doc_param['status'] = 1;
                        $doc_param['created_by'] = $data['user_id'];
                        $doc_param['created']= date('Y-m-d H:i:s');
                        $doc_param['assigned_to'] = $assigned_to;
                        $doc_param['crm_documentsno'] = $newModuleIdForDoc;
                        /*Inser into Docs table*/
                        $CI->db->insert('crm_documents',$doc_param);
                    }
                }
            break;

            /**
             * Case for comId 58
             * For Documents and Folders 
             * Management
             * @param business_name     
             *        for getting business-folde-id from doc_folder table
             *        for getting assigned_to-id from doc_folder table
             * @param site_id
             * @param comId
             */
            case '58':
                for ($i = 1; $i <= 5; $i++) {
                    if (! empty($data['forms']['Upload_Scanned_From_'.$i]) ) {
                        /**
                         * Getting business folder_id form doc_folder table by using business name
                         * Getting business assigned_to form doc_folder table by using business name
                         */
                        $CI->db->select('*');
                        $CI->db->from('doc_folders');
                        $CI->db->where('folder_name',$data['business_name']);
                        $query = $CI->db->get();
                        $parent_folder = $query->row_array();
                        ///////////////////////Auto-create Business FOlder if not exist
                        if (count($parent_folder) ==0) {
                            $CI->db->select('title,user_id');
                            $CI->db->from('business');
                            $CI->db->where('title',$data['business_name']);
                            $CI->db->where('site_id',$CRUD_AUTH['site_id']);
                            $query = $CI->db->get();
                            $business_data = $query->row_array();

                            /// GENEREATE MODULE CRM ID
                            $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                            $moduleEntityParam['module_id'] = '29';
                            $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                            /// GET MODULE PREV RECORD NO
                            $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                            $params['fields'] = array('id,module_id','prefix','curr_id');
                            $params['conditions'] = array('module_id="29"');
                            $params['order'] =  array('id');
                            $rs = $modNum->find($params);

                            /// GENERATE MODULE RECORD NO
                            $moduleTable = $table;
                            $moduleTableField = 'doc_folders' . 'no';
                            $newId =  $rs[0]['curr_id'];
                            $newId = $newId+1;
                            $newModuleId = $rs[0]['prefix'] . $newId;
                            $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));

                            /// ASSING REMAINING VALUES TO ARRAY
                            $folder['id'] = $moduleEntityId;
                            $folder['folder_name'] = $business_data['title'];
                            $folder['Parent_Folder'] = 0;
                            $folder['module'] = 58;
                            $folder['assigned_to'] = $business_data['user_id'];
                            $folder['doc_foldersno'] = $newModuleId;
                            $folder['created_by'] = $CRUD_AUTH['user_id'];
                            $folder['created'] = date('Y-m-d');
                            $folder['site_id'] = $CRUD_AUTH['site_id'];

                            $CI->db->insert('doc_folders', $folder);

                            $data = array('Folder' => $moduleEntityId);
                            $CI->db->where('id', $business_data['user_id']);
                            $CI->db->update('crud_users', $data);

                            $CI->db->select('*');
                            $CI->db->from('doc_folders');
                            $CI->db->where('folder_name',$data['business_name']);
                            $query = $CI->db->get();
                            $parent_folder = $query->row_array();
                        }
                        //////////////////////
                        $parent_folder_id = $parent_folder['id'];
                        $assigned_to = $parent_folder['assigned_to'];

                        /////////////////////////////////////////////////////
                        // Detecting if file being updated or new uploaded //
                        /////////////////////////////////////////////////////
                        $CI->db->select('*');
                        $CI->db->from('doc_folders');
                        $CI->db->where('Parent_Folder',$parent_folder_id);
                        $CI->db->where('folder_name',$data['fieldtype'][$i-1]['section_title']);
                        $query = $CI->db->get();
                        $image_data = $query->row_array();

                        if (count($image_data) >0) {
                            ///////////////////////////
                            // if file being updated //
                            ///////////////////////////
                            $doc_param['file'] = $data['forms']['Upload_Scanned_From_'.$i];
                            $doc_param['modified_by'] = $data['user_id'];
                            $doc_param['modified']= date('Y-m-d H:i:s');
                            $CI->db->where('folder_name', $image_data['id']);
                            $CI->db->update('crm_documents', $doc_param);
                        }else{
                            //////////////////////////
                            // if new file uploaded //
                            //////////////////////////
                            /*GENERATE moduleEntity id for folder*/
                            $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                            $moduleEntityParam['module_id'] = '29';
                            $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                            /// GET MODULE PREV RECORD NO
                            $params = array();
                            $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                            $params['fields'] = array('id,module_id','prefix','curr_id');
                            $params['conditions'] = array('module_id=29');
                            $params['order'] =  array('id');
                            $rs = $modNum->find($params);

                            /// GENERATE MODULE RECORD NO
                            $moduleTable = $table;
                            $moduleTableField = $table . 'no';
                            $newId =  $rs[0]['curr_id'];
                            $newId = $newId+1;
                            $newModuleIdForFolder = $rs[0]['prefix'] . $newId;
                            $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));
                            $newModuleIdForFolder;

                            /////////////////////////////
                            // Folder table parameters //
                            /////////////////////////////
                            $folder_param['id'] = $moduleEntityId;
                            $folder_param['folder_name'] = $data['fieldtype'][$i-1]['section_title'];
                            $folder_param['Parent_Folder'] = $parent_folder_id;
                            $folder_param['module'] = $data['comId'];
                            $folder_param['site_id'] = $d['site_id'];
                            $folder_param['created_by'] = $data['user_id'];
                            $folder_param['created']= date('Y-m-d H:i:s');
                            $folder_param['assigned_to'] = $assigned_to;
                            $folder_param['doc_foldersno'] = $newModuleIdForFolder;
                            /*Inser into Folder table*/
                            $CI->db->insert('doc_folders',$folder_param);

                            /*GENERATE moduleEntity id for Docs*/
                            $moduleEntityForDoc = new ScrudDao('crud_module_entity_ids', $CI->db);
                            $moduleEntityForDocParam['module_id'] = '30';
                            $moduleEntityForDocId = $moduleEntityForDoc->insert($moduleEntityForDocParam);

                            /// GET MODULE PREV RECORD NO
                            $params = array();
                            $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                            $params['fields'] = array('id,module_id','prefix','curr_id');
                            $params['conditions'] = array('module_id=30');
                            $params['order'] =  array('id');
                            $rs = $modNum->find($params);

                            /// GENERATE MODULE RECORD NO
                            $moduleTable = $table;
                            $moduleTableField = $table . 'no';
                            $newId =  $rs[0]['curr_id'];
                            $newId = $newId+1;
                            $newModuleIdForDoc = $rs[0]['prefix'] . $newId;
                            $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));
                            $newModuleIdForDoc;
                            
                            ///////////////////////////
                            // Docs table parameters //
                            ///////////////////////////
                            $doc_param['id'] = $moduleEntityForDocId;
                            $doc_param['subject'] = $data['fieldtype'][$i-1]['section_title'];
                            $doc_param['folder_name'] = $folder_param['id'];
                            $doc_param['file'] = $data['forms']['Upload_Scanned_From_'.$i];
                            $doc_param['site_id'] = $d['site_id'];
                            $doc_param['status'] = 1;
                            $doc_param['created_by'] = $data['user_id'];
                            $doc_param['created']= date('Y-m-d H:i:s');
                            $doc_param['assigned_to'] = $assigned_to;
                            $doc_param['crm_documentsno'] = $newModuleIdForDoc;
                            /*Inser into Docs table*/
                            $CI->db->insert('crm_documents',$doc_param);
                        }
                    }
                }
            break;

            /////////////////code added by nauman for automatically add calendar//////////////////
            case 32:
            case 65:
                if($data['crud_users']['group_id']!=5){
                    $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
              
                
                    $CI->db->select('*');
                    $CI->db->where('assigned_to',$data['id']); 
                    $CI->db->where(name ,  $data['crud_users']['user_first_name'] . ' ' . $data['crud_users']['user_las_name'] . ' ( '. $data['crud_users']['user_name'] . " )" );
                    $query =$CI->db->get('calendar_types');
                    $num=$query->num_rows();
                    
                    if($num== 0){
                    
                        $cn = new ScrudDao('calendar_types',$CI->db);
                        $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                        $moduleEntityParam['module_id'] = 32;
                        $moduleEntityId = $moduleEntity->insert($moduleEntityParam);
                       
                        $cnp['id'] = $moduleEntityId;
                        $cnp['name'] = $data['crud_users']['user_first_name'] . ' ' . $data['crud_users']['user_las_name'] . ' ( '.
                        $data['crud_users']['user_name'] . ' )';
                        $cnp['status'] = 3;
                        $cnp['type'] = 1;

                        $cnp['created_by'] = $CRUD_AUTH['id'];
                        $cnp['created'] = date('Y-m-d');
                        $cnp['assigned_to'] = $data['id'];
                        $cnp['site_id'] = $data['crud_users']['site_id'];
                                        
                        $cn->insert($cnp);

                    }
                }
                ////////////////nauman code ended//////////////////////
                break;

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
                    
                    if($avail_holidays >= $totalDiff){
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

            ////////////////// nauman code starts for Calendar Invitation /////////////////
            case 81:
                //$CI = & get_instance();
                $key = $CI->input->post('key');
                $crudAuth = $CI->session->userdata('CRUD_AUTH'); 
                $this_user_id = $crudAuth['id'];

                $tbl = '';
                $id = 0;
                foreach ($key as $k => $v) {
                    $tbl = $k;
                    $id = $v['id'];
                }
                //echo '<pre>';print_r($_POST);print_r($id);print_r($tbl);exit;//////////////
                if($_POST['data'][$tbl]['status']==2){
                    $cal = new ScrudDao('cal_invitations', $CI->db);   
                    $caltp['conditions'] = array('id='.$id);
                    $ctrs = $cal->find($caltp);
               
                    $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                    $moduleEntityParam['module_id'] = 25;
                    $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                    $c = new ScrudDao('calendar',$CI->db);
                    $cp = $ctrs[0];
                    $cp['id'] = $moduleEntityId;
                    $cp['eventstatus'] = $ctrs[0]['invite_calendars'];
                    $cp['assigned_to'] = $this_user_id;
                    $c->insert($cp);
                    
                    $dc = new ScrudDao('cal_invitations', $CI->db);
                    $dcp['conditions'] = array('id='.$id);
                    $dc->remove($dcp['conditions']);
                }
                break;    
            ////////////////////nauman code ends///////////////////////

            default:
                
                break;

        }
        
        
    }







?>