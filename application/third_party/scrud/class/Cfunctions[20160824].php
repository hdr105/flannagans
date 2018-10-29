<?php
class Cfunctions {
    
    public function validateClient($var=array()) {
        $CI = & get_instance();
        $id = $var['id'];

        $var = array();
        $errors = array();
        $crudUser = $_POST[data][business];
        if (!empty($crudUser)){                

            ////////////////////////////////////
            /////// Business validation ////////
            ////////////////////////////////////
            if($crudUser[title]){
                $CI->db->select('id');
                $CI->db->from('business');
                $CI->db->where('title',trim($crudUser['title']));
                $CI->db->where('site_id',trim($crudUser['site_id']));
                $query = $CI->db->get();
                $busi = $query->row_array();
                if ((!empty($busi) and !isset($_GET['key']['business.id'])) or (!empty($busi) and isset($_GET['key']['business.id']) and $busi['id']!=$_GET['key']['business.id']) ){
                    $errors[] = "Business Name in Basic Information already Exists";
                }
            }
            ///////////////////////////////////



            //////////////////////////////////////////////
            /////// USER ID and EMAIL validation /////////
            //////////////////////////////////////////////
            $uid=0;
            if($id!=0){
                $sql="SELECT user_id FROM business WHERE id=".$id;
                $query = $CI->db->query($sql);
                $rs = array();
                if (!empty($query)) {
                    foreach ($query->result_array() as $key=>$row) {
                        $rs[] = $row;
                    }
                }
                $uid=$rs[0]['user_id'];
            }
            ///user validation
                $CI->db->select('id');
                $CI->db->from('crud_users');
                $CI->db->where('user_name',trim($crudUser['user_name']));
                if($uid!=0)
                    $CI->db->where('id !=',$uid);
                $query = $CI->db->get();
                $user = $query->row_array();
                if (!empty($user)){
                    $errors[] = "Login ID in Client Portal already Exists";
                }

            ///email validation
                $CI->db->select('id');
                $CI->db->from('crud_users');
                $CI->db->where('user_email',trim($crudUser['user_email']));
                if($uid!=0)
                    $CI->db->where('id !=',$uid);
                $query = $CI->db->get();
                $user = $query->row_array();
                if (!empty($user)){
                    $errors[] = "Email ID in Client Portal already Exists";
                }
            /////////////////////////////////////////////////
                
            if ($errors)
                return $errors[0];
            else
                return false;
        }

        $crudUser = $_POST[data][crud_users];
        if (!empty($crudUser)){                

            //////////////////////////////////////////////
            /////// USER ID and EMAIL validation /////////
            //////////////////////////////////////////////
            ///user validation
            $CI->db->select('id');
            $CI->db->from('crud_users');
            $CI->db->where('user_name',trim($crudUser['user_name']));
            if($id!=0)
                $CI->db->where('id !=',$id);
            $query = $CI->db->get();
            $user = $query->row_array();
            if (!empty($user)){
                $errors[] = "User ID in Basic Information already Exists";
            }

            ///email validation
            $CI->db->select('id');
            $CI->db->from('crud_users');
            $CI->db->where('user_email',trim($crudUser['user_email']));
            if($id!=0)
                $CI->db->where('id !=',$id);
            $query = $CI->db->get();
            $user = $query->row_array();
            if (!empty($user)){
                $errors[] = "Email ID in Basic Information in Client Portal already Exists";
            }
            /////////////////////////////////////////////////
                
            if ($errors)
                return $errors[0];
            else
                return false;
        }

        $crudUser = $_POST[data][user_groups];
        if (!empty($crudUser)){                

            ////////////////////////////////////
            /////// User Group validation //////
            ////////////////////////////////////
            if($crudUser[ugroup_name]){
                $CI->db->select('id');
                $CI->db->from('user_groups');
                $CI->db->where('ugroup_name',trim($crudUser['ugroup_name']));
                $CI->db->where('id !=',$id);
                $query = $CI->db->get();
                $group = $query->row_array();
                if ((!empty($group) and !isset($_GET['key']['user_groups.id'])) or (!empty($group) and isset($_GET['key']['user_groups.id']) and $group['id']!=$_GET['key']['user_groups.id']) ){
                    $errors[] = "Group Name already exists";
                }
            }
            ///////////////////////////////////

            if ($errors)
                return $errors[0];
            else
                return false;

        }

        $crudUser = $_POST[data][legal_letters];
        if (!empty($crudUser)){                

            ////////////////////////////////////
            /////// User Group validation //////
            ////////////////////////////////////
            if($crudUser[letter_name]){
                $CI->db->select('id');
                $CI->db->from('legal_letters');
                $CI->db->where('letter_name',trim($crudUser['letter_name']));
                $CI->db->where('id !=',$id);
                $query = $CI->db->get();
                $group = $query->row_array();
                if ((!empty($group) and !isset($_GET['key']['legal_letters.id'])) or (!empty($group) and isset($_GET['key']['legal_letters.id']) and $group['id']!=$_GET['key']['legal_letters.id']) ){
                    $errors[] = "Letter Title already exists";
                }
            }
            ///////////////////////////////////

            if ($errors)
                return $errors[0];
            else
                return false;

        }

        $crudUser = $_POST[data][legal_letters_data];
        if (!empty($crudUser)){                

            ////////////////////////////////////
            /////// User Group validation //////
            ////////////////////////////////////
            if($crudUser['Letter_Title']){
                $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH');
                $CI->db->select('id');
                $CI->db->from('legal_letters_data');
                $CI->db->where('Letter_Title',trim($crudUser['Letter_Title']));
                $CI->db->where('id !=',$id);
                $CI->db->where('site_id !=',$CRUD_AUTH['site_id']);
                $query = $CI->db->get();
                $group = $query->row_array();
                if ((!empty($group) and !isset($_GET['key']['legal_letters_data.id'])) or (!empty($group) and isset($_GET['key']['legal_letters_data.id']) and $group['id']!=$_GET['key']['legal_letters_data.id']) ){
                    $errors[] = "Letter Title already exists";
                }
            }
            ///////////////////////////////////

            if ($errors)
                return $errors[0];
            else
                return false;

        }

        $currencies = $_POST[data][currencies];
        if (!empty($currencies)){                

            ////////////////////////////////////
            /////// Business validation ////////
            ////////////////////////////////////
            if($currencies[currency_status]!=3){
                $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH');
                $CI->db->select('id');
                $CI->db->from('currencies');
                $CI->db->where('site_id',$CRUD_AUTH['site_id']);
                $CI->db->where('currency_status',3);
                $CI->db->where('id !=',$id);
                $query = $CI->db->get();
                if ($query->num_rows()==0){
                    $errors[] = "There is no currency as Default.";
                }
            }
            ///////////////////////////////////

            if ($errors)
                return $errors[0];
            else
                return false;
        }

        $jobs = $_POST[data][jobs];
        if (!empty($jobs)){                

            ////////////////////////////////////
            /////// Job Close validation ////////
            ////////////////////////////////////
            if($jobs[job_status]==2 AND !$_GET['key']){
                $errors[] = "Please complete checklist first to close this job.";
            }else if($jobs[job_status]==2 AND $_GET['key']){
                if(!isset($jobs['actual_end_date'] )|| $jobs['actual_end_date']==""){
                    $errors[]= "Please Complete 'Actual End Date' first";
                }
                if(!isset($jobs['actual_time_spent']) || $jobs['actual_time_spent']=="" || $jobs['actual_time_spent']=="0"){
                    $errors[]="Please Complete 'Actual Time Spent' first";
                }
                $CI->db->select('form_data');
                $CI->db->from('checklist');
                $CI->db->where('id',$id);
                $query = $CI->db->get();
                $row = $query->row_array();
                if($query->num_rows()==0)
                {
                    $errors[] = "Please complete checklist first to close this job.";
                    // echo "no record";exit;
                }else{
                    $form_data=unserialize($row['form_data']);
                    $CI->db->select('config');
                    $CI->db->from('checklists');
                    $CI->db->where('group_id',$jobs['job_sub_category']);
                    $query = $CI->db->get();
                    if($query->num_rows()==0)
                    {
                        $errors[] = "Please define checklist for payroll first";
                    }else{
                        $row = $query->row_array();
                        $configration=unserialize($row['config']);                         

                        foreach($configration['validate'] as $fld_name => $value){

                            if($form_data[$fld_name]=='' || is_null($form_data[$fld_name]))
                            {
                                $errors[]="Please complete checklist first to close this job.";
                                // echo $fld_name;
                                // echo $form_data[$fld_name]. " ";
                                // echo "no validate"; 
                                break;
                                
                            }
                        }     
                    }
                }
                
            }
            ///////////////////////////////////

            if ($errors)
                return $errors[0];
            else
                return false;
        }

        ////////////////////////nauman code starts here...............
        $holidays = $_POST[data][holiday_request];
        if (!empty($holidays)){     
        
            $asd1=explode("/",str_replace("-","/",$holidays['Start_Date']));
            $d1 = $asd1[1]."/".$asd1[0]."/".$asd1[2];
            $date1= $timestamp = strtotime($d1);
           
            $asd2=explode("/",str_replace("-","/",$holidays['End_Date']));
            $d2 = $asd2[1]."/".$asd2[0]."/".$asd2[2];
            $date2= $timestamp = strtotime($d2);

            if($date1  > $date2 ){
                $errors[] = "Ending Date can not less than Starting Date.";
            }else{
                ////////////////////////////////////
                /////// Holidays Availability validation ////////
                ////////////////////////////////////
                
                $CI->db->select('Available_Holidays');
                $CI->db->from('crud_users');
                $CI->db->where('id',$holidays['assigned_to']);
                $query = $CI->db->get();
                $row = $query->row_array();
                $available_holidays=$row['Available_Holidays'];
                $ss= date_create($d1);
                $ee= date_create($d2);
               
                $totalDiff = date_diff($ss,$ee)->format('%a')+1 ;
                if($totalDiff > $available_holidays){
                    $errors[] = "Sorry ! You only have ". $available_holidays . " holidays remaining.";
                }

            }
            
            

            if ($errors)
                return $errors[0];
            else
                return false;
        }
            ////////////////////nauman code ends here...................

        return false;
    }


    public function autocreateClient($var=array()) {
        $CI = & get_instance();
        $id = $var['id'];
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH');
        if($_POST['data']['business']['user_name'] and trim($_POST['data']['business']['user_name'])!=''){
            $sql="SELECT user_id FROM business WHERE id=".$id;
            $query = $CI->db->query($sql);
            $rs = array();
            if (!empty($query)) {
                foreach ($query->result_array() as $key=>$row) {
                    $rs[] = $row;
                }
            }
            $uid=$rs[0]['user_id'];
            if($uid==0 or $uid=='' or is_null($uid)){
                /////////////////////////////////
                require_once FCPATH . 'application/third_party/scrud/class/recaptchalib.php';
                require_once FCPATH . 'application/third_party/scrud/class/Validation.php';
                $CI->load->library('session');
                
                $settingKey = sha1('general');

                $var = array();
                $errors = array();
                $var['setting_key'] = $settingKey;

                $CI->db->select('*');
                $CI->db->from('crud_settings');
                $CI->db->where('setting_key',$settingKey);
                $query = $CI->db->get();
                $setting = $query->row_array();
                $setting = unserialize($setting['setting_value']);
                
                if ((int)$setting['disable_registration'] == 1){
                    exit;
                }
                
                $crudUser = $_POST[data][business];
                if (!empty($crudUser)){
                    $validate = Validation::singleton();
                    
                    $CI->db->select('id');
                    $CI->db->from('crud_users');
                    $CI->db->where('user_name',trim($crudUser['user_name']));
                    $query = $CI->db->get();
                    $user = $query->row_array();
                    if (!empty($user)){
                        $errors[] = "Login ID in Client Portal already exists";
                        $CI->db->query("UPDATE business SET user_id = 0,user_name=NULL,user_password=NULL WHERE id = $id");
                    }


                    $CI->db->select('id');
                    $CI->db->from('crud_users');
                    $CI->db->where('user_email',trim($crudUser['user_email']));
                    $query = $CI->db->get();
                    $user = $query->row_array();
                    if (!empty($user)){
                        $errors[] = "Email ID in Client Portal already exists";
                        $CI->db->query("UPDATE business SET user_id = 0,user_name=NULL,user_password=NULL WHERE id = $id");
                    }
                                        
                    if (count($errors) == 0){
                        $user = array();
                        
                        $user['user_first_name'] = $crudUser['title'];
                        $user['user_name'] = $crudUser['user_name'];
                        $user['user_password'] = sha1($crudUser['user_password']);
                        $user['user_email'] = $crudUser['user_email'];
                        
                        if (isset($setting['require_email_activation']) && (int)$setting['require_email_activation'] == 1){
                            $time = time();
                            $code = sha1('activate'.$user['user_email'].$time).'-'.$time;
                            $user['user_code'] = $code;
                            $user['user_status'] = 0;
                        }else{
                            $user['user_status'] = 1;
                        }
                        
                        $user['group_id'] = 5;
                        $user['site_id'] =  $CRUD_AUTH['site_id'];;
                        
                        $CI->db->insert('crud_users', $user);
                        $CI->db->select('*');
                        $CI->db->from('crud_users');
                        $CI->db->where('user_name',trim($crudUser['user_name']));
                        $query = $CI->db->get();
                        $user = $query->row_array();
                        if (!empty($user)){
                            $uid = $user['id'];
                        }
                        $CI->db->query("UPDATE business SET user_id = ".$uid." WHERE id = $id");
                        if (isset($setting['require_email_activation']) && (int)$setting['require_email_activation'] == 1){
                            $CI->db->select('*');
                            $CI->db->from('crud_settings');
                            $CI->db->where('setting_key',sha1('new_user'));
                            $query = $CI->db->get();
                            $newUserEmail = $query->row_array();
                            $newUserEmail = unserialize($newUserEmail['setting_value']);
                            require_once FCPATH . 'application/third_party/scrud/class/PHPMailer/class.phpmailer.php';
                        
                            $mail = new PHPMailer();
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
                            $mail->AddAddress($user['user_email']);
                            $mail->SetFrom($setting['email_address'], $CI->lang->line('company_name'));
                        
                            $mail->Subject = $newUserEmail['send_link_subject'];
                        
                            $body = $newUserEmail['send_link_body'];
                        
                            $siteAddress = base_url();
                            $activationLink = base_url().'index.php/admin/activate?code='.$code;
                        
                            $body = str_replace('{site_address}', $siteAddress, $body);
                            $body = str_replace('{user_name}', $user['user_name'], $body);
                            $body = str_replace('{user_email}', $user['user_email'], $body);
                            $body = str_replace('{activation_link}', $activationLink, $body);
                        
                            $mail->Body = $body;
                            $mail->Send();
                            //mail($user['user_email'],$newUserEmail['send_link_subject'],$body,"from:".$setting['email_address']);

                        }
                        
                    }
                }
                /////////////////////
            }else{
                /////////////////////////////////
                require_once FCPATH . 'application/third_party/scrud/class/recaptchalib.php';
                require_once FCPATH . 'application/third_party/scrud/class/Validation.php';
                $CI->load->library('session');
                
                $settingKey = sha1('general');

                $var = array();
                $errors = array();
                $var['setting_key'] = $settingKey;

                $CI->db->select('*');
                $CI->db->from('crud_settings');
                $CI->db->where('setting_key',$settingKey);
                $query = $CI->db->get();
                $setting = $query->row_array();
                $setting = unserialize($setting['setting_value']);
                
                if ((int)$setting['disable_registration'] == 1){
                    exit;
                }
                
                $crudUser = $_POST[data][business];
                if (!empty($crudUser)){
                    $validate = Validation::singleton();
                    
                    $CI->db->select('id');
                    $CI->db->from('crud_users');
                    $CI->db->where('user_name',trim($crudUser['user_name']));
                    $CI->db->where('id !=',$uid);
                    $query = $CI->db->get();
                    $user = $query->row_array();
                    if (!empty($user)){
                        $errors[] = "User ID in Client Portal already exists";
                        $CI->db->query("UPDATE business SET user_id = 0,user_name=NULL,user_password=NULL WHERE id = $id");
                    }


                    $CI->db->select('id');
                    $CI->db->from('crud_users');
                    $CI->db->where('user_email',trim($crudUser['user_email']));
                    $CI->db->where('id !=',$uid);
                    $query = $CI->db->get();
                    $user = $query->row_array();
                    if (!empty($user)){
                        $errors[] = "Email ID in Client Portal already exists";
                        $CI->db->query("UPDATE business SET user_id = 0,user_name=NULL,user_password=NULL WHERE id = $id");
                    }
                        
                    
                    if (count($errors) == 0){
                        $user = array();
                        
                        $user['user_first_name'] = $crudUser['title'];
                        $user['user_name'] = $crudUser['user_name'];
                        
                        if($crudUser['user_password'])
                            $user['user_password'] = sha1($crudUser['user_password']);

                        $user['user_email'] = $crudUser['user_email'];
                        $user['site_id'] =  $CRUD_AUTH['site_id'];
                        
                        $CI->db->where('id', $uid);                                       
                        $CI->db->update('crud_users', $user);
                        $CI->db->query("UPDATE business SET user_id = ".$uid." WHERE id = $id");
                    
                    }
                }
                /////////////////////

            }
        }

        return true;
    }

    public function folder_managing($data = array()){
        // echo "<pre>";
        // print_r($data);
        // exit;

        $CI= & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH');
        if(isset($data['id']) && $data['id']!=0){
            // echo "working"; exit;
            $CI->db->select('folder_id,user_id');
            $CI->db->from('business');
            $CI->db->where('id',$data['id']);
            $query= $CI->db->get();
            $result = ($query->num_rows() > 0) ? $query->row_array() : null;
            if(isset($result)){

                if($result['folder_id']==0){
                    
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
                    //$moduleTable = $table;
                    //$moduleTableField = 'doc_folders' . 'no';
                    $newId =  $rs[0]['curr_id'];
                    $newId = $newId+1;
                    $newModuleId = $rs[0]['prefix'] . $newId;
                    $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));


                    /// ASSING REMAINING VALUES TO ARRAY
                    $folder['id'] = $moduleEntityId;
                    $folder['folder_name'] = $data['business']['title'];
                    $folder['Parent_Folder'] = 0;
                    $folder['module'] = 65;
                    $folder['assigned_to'] = $data['business']['assigned_to'];
                    $folder['doc_foldersno'] = $newModuleId;
                    $folder['created_by'] = $CRUD_AUTH['user_id'];
                    $folder['created'] = date('Y-m-d');
                    $folder['site_id'] = $CRUD_AUTH['site_id'];
                    // CREATE FIRST TIME 
                    $CI->db->insert('doc_folders', $folder);
                    
                    $CI->db->flush_cache();
                    $CI->db->where('id', $result['user_id']);
                    $CI->db->update('crud_users', array('Folder' => $moduleEntityId));
                    $CI->db->flush_cache();

                    $CI->db->where('id',$data['id']);
                    $CI->db->update('business',array('folder_id'=>$moduleEntityId));
                    // echo "id ".$data['id']." <br/>";
                    // echo "unique id: ".$moduleEntityId." <br/>";
                    // echo "working";exit;


                }
            }

        }

    }

    public function legalEntityVal($var=array()) {
        $CI = & get_instance();
        $id = $var['id'];
        $c_id = $_GET['com_id'];
        $legal = 1;

        if($c_id==42){
            $legal = 2;
        }elseif($c_id==43){
            $legal = 3;
        }elseif($c_id==44){
            $legal = 4;
        }elseif($c_id==45){
            $legal = 5;
        }
        $CI->db->query("UPDATE business SET legal_entity = $legal WHERE id = $id");

        return true;
    }

//this function has been moved into afterinsernewrecord()
    public function relatedTablesEntry($var=array()) {
        /*$CI = & get_instance();
        $id = $var['id'];
        $CI->db->query("INSERT INTO forms SET id = $id");
        $CI->db->query("INSERT INTO codes SET id = $id");
        $CI->db->query("INSERT INTO compliance SET id = $id");
        $CI->db->query("INSERT INTO services SET id = $id");
        $CI->db->query("INSERT INTO business_fee SET id = $id");
        $CI->db->query("INSERT INTO legal_letters_business SET id = $id");

        return true;*/
    }

//moved into getIndexConditions() function
    public function viewEmployeesList(){
        //return "group_id!=1 AND group_id!=5";
    }

    public function setCompID($var=array()){
        /*$CI = & get_instance();
        $CI->session->set_userdata('comid',$_GET['com_id']);
        if($_GET['com_id']==41)
            $CI->session->set_userdata('com_name','Sole Trader');
        elseif($_GET['com_id']==42)
            $CI->session->set_userdata('com_name','Partnership');
        elseif($_GET['com_id']==43)
            $CI->session->set_userdata('com_name','Limited Company');
        elseif($_GET['com_id']==44)
            $CI->session->set_userdata('com_name','Limited Liabilities Company');
        elseif($_GET['com_id']==45)
            $CI->session->set_userdata('com_name','Charities');*/
        //return true;
    }

//this function has been moved into afterinsernewrecord()+afterupdaterecord()
    public function setCurrencyDefault($var=array()){
        /*$CI = & get_instance();
        $id = $var['id'];

        $var = array();
        $errors = array();
        $currencies = $_POST[data][currencies];
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH');
        if (!empty($currencies)){                

            ////////////////////////////////////
            /////// Business validation ////////
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
        }*/


        //return true;
    }


    public function setcommentspopup(){
        $CI = & get_instance();

        $exist_comments = '';
        $result_data = $CI->db->order_by("comment_id", "desc")->get_where('comments_box', array('record_id'=>$_POST['record_id'],'com_id'=>$_POST['com_id'],'control_id'=>$_POST['control_id']));
        if($result_data->num_rows>0){
            $all_comments = $result_data->result_array();
            foreach($all_comments as $comments){
                $result_user = $CI->db->get_where('crud_users', array('id'=>$comments['user_id']))->row_array();
                $username = $result_user['user_first_name'].' '.$result_user['user_las_name'];
                $exist_comments .= '<p>'.str_replace("\n", "<br>", $comments['comments']).'<br><i style="color:grey" class="pull-right">By:'.$username.' on '.date(__DATE_FORMAT_TIME__, strtotime($comments['comment_time'])).'</i></p>';
            }
        }
        echo $exist_comments;
        exit;
    }

    public function customsetcomments($var=array()){
        $CI = & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH');

        if($_GET['com_id']==85){
            foreach($var['data']['control_id'] as $key=>$value){
                $con = explode('-',$value);
                $control_id = $con[0].'-'.$con[1];
                $control = explode('[',$con[2]);
                //$table_name = substr($control[0], 5);  
                $dataControl = rtrim($control[1].'-'.$con[3], "]");
                if(!empty($var['data']['data'][$dataControl])){
                    if($var['data']['key']['checklist']['id']){
                         $record_id = $var['data']['key']['checklist']['id'];
                    } else {
                         $record_id = $var['id'];
                    }
                    $databack = array(
                     'user_id'       =>$CRUD_AUTH['id'],
                     'com_id'        =>$_GET['com_id'],
                     'control_id'    =>$control_id,
                     'record_id'     =>$record_id,
                     'comments'      =>$var['data']['data'][$dataControl],
                     'comment_time'  =>date('Y-m-d H:i:s')
                     );
                    $CI->db->insert('comments_box', $databack);
                    //echo $CI->db->last_query();exit;
                }
            //echo $dataControl;
            }
            //echo "<pre>";print_r($var);exit;
        }else{
            foreach($var['data']['control_id'] as $key=>$value){
                $con = explode('-',$value);
                $control_id = $con[0];
                $control = explode('][',$con[1]);
                $table_name = substr($control[0], 5);  
                $dataControl = rtrim($control[1], "]");
                if(!empty($var['data']['data'][$table_name][$dataControl])){
                    if($var['data']['key'][$table_name]['id']){
                         $record_id = $var['data']['key'][$table_name]['id'];
                    } else {
                         $record_id = $var['id'];
                    }
                    $databack = array(
                     'user_id'       =>$CRUD_AUTH['id'],
                     'com_id'        =>$_GET['com_id'],
                     'control_id'    =>$control_id,
                     'record_id'     =>$record_id,
                     'comments'      =>$var['data']['data'][$table_name][$dataControl],
                     'comment_time'  =>date('Y-m-d H:i:s')
                     );
                    $CI->db->insert('comments_box', $databack);
                    //echo $CI->db->last_query();exit;
                }
            }
        }
    }











//in-dependent function


	public function working_state(){
        $CI = & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH');
        $userid = $CRUD_AUTH['id'];
        $state = $CI->input->post('state');
        $sql="SELECT id,dated,time_start FROM users_work_log WHERE user_id=".$userid." AND dated = '".date("Y-m-d")."' ORDER BY time_start Desc LIMIT 1";
        $query = $CI->db->query($sql);
        $rs = array();
        if (!empty($query)) {
            foreach ($query->result_array() as $key=>$row) {
                $rs[] = $row;
            }
        }
        $id=$rs[0]['id'];
        $time1=strtotime($rs[0]['dated']." ".$rs[0]['time_start']);
        $time=date("H:i:s");
        $time2=strtotime(date("Y-m-d H:i:s"));
        $diff=abs($time2 - $time1);
        $CI->db->query("UPDATE users_work_log SET time_end = '".$time."', time_spent='$diff' WHERE id = $id");

        $dated=date("Y-m-d");
        $time_start=date("H:i:s");
        $CI->db->query("INSERT INTO users_work_log (user_id,dated,time_start,status,site_id) VALUES(".$userid.",'".$dated."','".$time_start."','".$state."',".$CRUD_AUTH['site_id'].")");

        return true;
    }

    public function setSiteID(){
        $CI = & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH');
        $CRUD_AUTH['site_id'] = $CI->input->get('site_id');
        $CI->session->set_userdata('CRUD_AUTH', $CRUD_AUTH);
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH');

        $CI->db->select('timezone');
        $CI->db->from('sites');
        $CI->db->where('id',$CRUD_AUTH['site_id']);
        $query = $CI->db->get();
        $zone = $query->row_array();
        if (!empty($zone)){
            $CI->session->set_userdata('TIME_ZONE',$zone['timezone']);
        }

        $url = $_GET['url'];
        //echo "<pre>";print_r($CRUD_AUTH);echo "</pre>";
        //return true;
        redirect($url,"refresh");
    }

    public function setLegalData(){
        $CI = & get_instance();
        $id = $_REQUEST['id'];
        $rid = $_REQUEST['rid'];
        $load = $_REQUEST['loadval'];
        $JSon = array();

        $CI->db->select('letter_name,content');
        $CI->db->from('legal_letters');
        $CI->db->where('id',$id);
        $query = $CI->db->get();
        $rs = $query->row_array();
        if (!empty($rs)){
            $JSon['Letter_Title']=$rs['letter_name'];
            $JSon['Content']=$rs['content'];
        }

        $CI->db->select('title, internal_b_id, trading_address');
        $CI->db->from('business');
        $CI->db->where('id',$rid);
        $query = $CI->db->get();
        $rs = $query->row_array();
        if (!empty($rs)){
            $JSon['Business_Name']=$rs['title'];
            $JSon['Client_ID']=$rs['internal_b_id'];
            $JSon['Business_Address']=$rs['trading_address'];
        }

        if($load!=0){
            $CI->db->select('Letter_Title, Business_Name, Client_ID, Business_Address, Content');
            $CI->db->from('legal_letters_data');
            $CI->db->where('id',$load);
            $query = $CI->db->get();
            $rs = $query->row_array();
            if (!empty($rs)){
                if(isset($rs['Business_Name']) and $rs['Business_Name']!='' and $rs['Business_Name']!=NULL)
                    $JSon['Business_Name']=$rs['Business_Name'];
                if($rs['Client_ID'] and $rs['Client_ID']!='' and $rs['Client_ID']!=NULL)
                    $JSon['Client_ID']=$rs['Client_ID'];
                if($rs['Business_Address'] and $rs['Business_Address']!='' and $rs['Business_Address']!=NULL)
                    $JSon['Business_Address']=$rs['Business_Address'];
                if($rs['Letter_Title'] and $rs['Letter_Title']!='' and $rs['Letter_Title']!=NULL)
                    $JSon['Letter_Title']=$rs['Letter_Title'];
                if($rs['Content'] and $rs['Content']!='' and $rs['Content']!=NULL)
                    $JSon['Content']=$rs['Content'];
            }
        }

        echo $JSonData = json_encode($JSon);
        return $JSonData ;
    }


    public function setcomments(){
        $CI = & get_instance();
        $data = array(
                'user_id'       =>$_POST['user_id'],
                'com_id'        =>$_POST['com_id'],
                'control_id'    =>$_POST['control_id'],
                'comments'      =>$_POST['comments'],
                'comment_time'  =>date('Y-m-d H:i:s')
                );
        $CI->db->insert('comments_box', $data);
        
        $result_user = $CI->db->get_where('crud_users', array('id'=>$_POST['user_id']))->row_array();
        $username = $result_user['user_first_name'].' '.$result_user['user_las_name'];
        echo '<p>'.$_POST['comments'].'<br><i style="color:grey" class="pull-right">By:'.$username.' on '.date(__DATE_FORMAT_TIME__, strtotime($data['comment_time'])).'</i></p>';
        exit;
    }

    public function getDetails(){
        $CI = & get_instance();
        $key=0;
        $existing_record = $_POST['exists'];
        $new_contact = $_POST['newcontact'];
        $component = $_POST['com_id'];
        $query = $CI->db->query("SELECT component_table FROM crud_components WHERE id = $component")->result_array();
        $newdata = explode(',',$existing_record);
        
        $fieldname = explode('][',$_POST['field']);

        foreach($newdata as $id){
            if(!empty($id)){
                $data = $CI->db->query("SELECT * FROM ".$query[0]['component_table']." WHERE id = $id AND ".rtrim($fieldname[1], "]")."=$new_contact");
                $CI->db->last_query();
                if($data->num_rows>0){
                 $key++;
                }
           }
        }
        if($key>0){
            echo "0";
        } else {
            echo "1";
        }
    }

/*
* given by Tariq
* for Date with calendar field
* Calendar Event Subject format  
*/

    public function findSubject($component, $key)
    {
        $CI = & get_instance();

        $i = 0;
        $isFound = false;
        foreach ($this->data['fieldtype'] as $fieldType)
        {
            foreach($fieldType as $section_key=> $section_value)
            {
                if($section_key == "section_fields")
                {
                    foreach ($section_value as $date)
                    {
                        if(strtolower($date['alias'])  == strtolower(str_replace("_"," ",$key)) )
                        {
                            $isFound = true;
                            break;
                        }
                    }
                }
                if($isFound)
                {
                    break;
                }
            }

            if($isFound)
            {
                break;
            }
            $i++;
        }
        //   59 proof of id ,60 prof of adderes,61 personal granty,74 legal addfress for bussines
        //58 forms, 63 codes, 62 complince, 75 legal letters data, 70 services, 64 fee setup

        //Emplyees 32 First name and last name

        //holidays 77 user_id se first name and last name lena ha

        $cid = $component['id'];



        $title = "";

        if ($cid == 59 || $cid == 60 || $cid == 61 || $cid == 74 || $cid == 58 || $cid == 63 ||
            $cid == 62 || $cid == 75 || $cid == 70 || $cid == 64)
        {
            $title = $CI->session->userdata('bus_name');
        }
        else if($cid == 32 || $cid == 77)
        {

            $fName = "";
            $lName = "";

            if($cid == 32)
            {
                $fName = $_POST['data']['crud_users']['user_first_name'];
                $lName = $_POST['data']['crud_users']['user_las_name'];
            }
            else if($cid == 77)
            {
                $userId = $_POST['data']['holiday_request']['assigned_to'];

                $CI->db->select("user_first_name, user_las_name");
                $CI->db->from('crud_users');
                $CI->db->where('id',$userId);
                $query = $CI->db->get();
                $busi = $query->row_array();
                if (!empty($busi))
                {
                    $fName = $busi['user_first_name'];
                    $lName = $busi['user_las_name'];
                }
            }

            $title =  $fName . " " . $lName;
        }
        else
        {
            $title = ucwords($_POST['data'][$component['component_table']]['title']);
        }

        $section_name = $CI->data['fieldtype'][$i]['section_name'];

        $module = ucwords(str_replace("_"," ",$component['component_name'])) ;
        $section = ucwords(str_replace("_"," ",$section_name)) ;
        $field = ucwords(str_replace("_"," ",$key));

        $subject = $module . " - " . $title . " - " . $section . " - " . $field;

        return $subject;
    }

    function getModuletableDetails(){
        $CI = & get_instance();
        $query = $CI->db->query("SELECT component_table FROM crud_components WHERE id = '".$_POST['module_id']."'")->row_array();
        echo $query['component_table'];
    }



    function beforeIndexList($data = array()){
            $CI = & get_instance();
            $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
            global $date_format_convert;
            $this_user_id = $CRUD_AUTH['id'];

            $conditions = '';
            switch ($data['comId']) {
                case '41':
                case '42':
                case '43':
                case '44':
                case '45':
                    $CI->session->set_userdata('comid',$_GET['com_id']);
                    if($_GET['com_id']==41)
                        $CI->session->set_userdata('com_name','Sole Trader');
                    elseif($_GET['com_id']==42)
                        $CI->session->set_userdata('com_name','Partnership');
                    elseif($_GET['com_id']==43)
                        $CI->session->set_userdata('com_name','Limited Company');
                    elseif($_GET['com_id']==44)
                        $CI->session->set_userdata('com_name','Limited Liabilities Company');
                    elseif($_GET['com_id']==45)
                        $CI->session->set_userdata('com_name','Charities');
                    break;
                default:
                    # code...
                    break;
            }
            return false;
    }
    function getIndexConditions($data = array()){
            $CI = & get_instance();
            $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
            global $date_format_convert;
            $this_user_id = $CRUD_AUTH['id'];

            $conditions = '';
            switch ($data['comId']) {
                case '81':
                   $mc = new ScrudDao('calendar_types', $CI->db);
                   $mcp['fields'] = array('id');
                   $mcp['conditions'] = array('assigned_to='.$this_user_id);
                   $mcrs = $mc->find($mcp);
                   $myCalIds = array();
                    foreach ($mcrs as $ck => $cv) {
                        $myCalIds[] = $cv['id'];
                    }

                    $conditions = ' invite_calendars IN ("'.implode('","', $myCalIds).'") ';

                break;
                case '25':
                   $mc = new ScrudDao('calendar_types', $CI->db);
                   $mcp['fields'] = array('id');
                   $mcp['conditions'] = array('assigned_to='.$this_user_id);
                   $mcrs = $mc->find($mcp);
                   $myCalIds = array();
                    foreach ($mcrs as $ck => $cv) {
                        $myCalIds[] = $cv['id'];
                    }
                   $conditions = ' eventstatus IN ("'.implode('","', $myCalIds).'") ';
                break;
                case '65':
                   $mc = new ScrudDao('crud_users', $CI->db);
                   $conditions = 'id!=1' ;
                break;
                case '32':
                   $mc = new ScrudDao('crud_users', $CI->db);
                   $conditions = "group_id!=1 AND group_id!=5" ;
                break;
                default:
                    # code...
                    break;
            }
            return $conditions;
    }

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
                $this->afterUpdateRecord($data);

                $this->autocreateClient($data);
                $this->folder_managing($data);
                $this->legalEntityVal($data);

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

    function afterDelRecord($tbl_name){
        $CI = & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
        global $date_format_convert;
        $this_user_id = $CRUD_AUTH['id'];

        switch ($tbl_name) {
            case 'business':
                //$CI->db->query("DELETE FROM jobs WHERE business=".$_GET['key']['business.id']);
                $CI->db->query("DELETE FROM jobs WHERE business=".$_GET['key']['business.id']);
                $CI->db->select('title,user_id,folder_id');
                $CI->db->from('business');
                $CI->db->where('id',$_GET['key']['business.id']);
                $query_b_name = $CI->db->get();
                $b_name_data = $query_b_name->row_array();
                $business_name = $b_name_data['title'];
                ////////nauman/////
                $business_doc = $b_name_data['folder_id'];
                //////nauman/////

                $CI->db->select('id');
                $CI->db->from('doc_folders');
                $CI->db->where('folder_name',$business_name);
                $query = $CI->db->get();
                $parent_folder = $query->row_array();
                $parent_folder_id = $parent_folder['id'];
                if($parent_folder_id)
                    $CI->db->query("DELETE FROM doc_folders WHERE id=".$parent_folder_id);
                    //$this->delete_business_folders_and_files($parent_folder_id);
                $CI->db->query("DELETE FROM crud_users WHERE id=".$b_name_data['user_id']);

                ////////nauman //////
                
                 if(isset($business_doc) && $business_doc!="" && $business_doc!=0){
                    $CI->db->delete('doc_folders',array('id'=> $business_doc));
                }

                //////nauman////////

                break;
            case 'doc_folders':
                //$CI->db->query("DELETE FROM crm_documents WHERE folder_name=".$_GET['key']['doc_folders.id']);
                $id = $_GET['key']['doc_folders.id'];
                /////////nauman///////////
                $CI->db->where('folder_id',$id);
                $CI->db->update('business' , array('folder_id'=>0));
                $CI->db->flush_cache();
                $CI->db->where('Folder',$id);
                $CI->db->update('crud_users',array('Folder'=>0));
                ///////////nauman//////////
                $this->delete_folder_and_files($id);
                break;
            case 'crud_users':
                $id = $_GET['key']['crud_users.id'];
                /////nauman/////
                $CI->db->where('user_id',$id);
                $CI->db->update('business',array('user_id'=>0));
                /////nauman//////
                $CI->db->query("DELETE FROM calendar_types WHERE assigned_to=".$id);
                break;
            default:
                break;
        }
       
       
    }

    public function delete_folder_and_files($id){
        $CI = & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
        global $date_format_convert;
        // echo "DELETE FROM crm_documents WHERE folder_name=".$id."<br>";
        $CI->db->query("DELETE FROM crm_documents WHERE folder_name=".$id);
        //echo "DELETE FROM doc_folders WHERE id=".$id."<br>";
        $CI->db->query("DELETE FROM doc_folders WHERE id=".$id);

        $CI->db->select('*');
        $CI->db->from('doc_folders');
        $CI->db->where('Parent_Folder',$id);
        $child_folder = $CI->db->get()->result();
        if (count($child_folder)>0 && !empty($child_folder)) {
            foreach ($child_folder as $child) {
                $is_sub_folder = $this->delete_folder_and_files($child->id);
                ////////////////////////////
                // if sub folder exists //
                ////////////////////////////
                if (!empty($is_sub_folder)) {
                    $this->delete_folder_and_files($child->id);
                }
            }
        }
    }

    /*public function delete_business_folders_and_files($id){
        $CI = & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
        global $date_format_convert;
        $CI->db->query("DELETE FROM doc_folders WHERE id=".$id);
        $CI->db->select('*');
        $CI->db->from('doc_folders');
        $CI->db->where('Parent_Folder',$id);
        $child_folder = $CI->db->get()->result();
        if (count($child_folder)>0 && !empty($child_folder)) {
            foreach ($child_folder as $child) {
                $is_sub_folder = $this->delete_business_folders_and_files($child->id);
                ////////////////////////////
                // if sub folder exists //
                ////////////////////////////
                if (count($is_sub_folder)>0 && !empty($is_sub_folder)) {
                    $this->delete_business_folders_and_files($child->id);
                }
                else{
                    //////////////////////////////////////
                    // delete files from current folder //
                    //////////////////////////////////////
                    $CI->db->query("DELETE FROM crm_documents WHERE folder_name=".$child->id);
                }
            }
        }
    }*/

    public function afterUpdateRecord($data = array()){
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
                $this->afterUpdateRecord($data);

                $this->autocreateClient($data);
                $this->folder_managing($data);
                $this->legalEntityVal($data);
                
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


    ///////////////////////////////////nauman code starts ////////////////
    function beforeAddForm($data=array()){
        $CI = & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH');
        
        switch($data['comId']){
            case 32:
            
                $CI->db->select('Holidays_Entitlement');
                $CI->db->from('sites');
                $CI->db->where('id',$CRUD_AUTH['site_id']);
                $query=$CI->db->get();
                $row=$query->row_array();
                $holidays_entitlement= $row['Holidays_Entitlement'];
                $_POST['data'][crud_users][holidays_entitlement]=$_POST['data'][crud_users][Available_Holidays]=$holidays_entitlement;
                $_POST['data'][crud_users][emp_start_date]=date('d-m-Y');
            break;

        default:
            break;
        }
    }

    function beforeEditForm($data=array()){

       
    }
    /////////////////////////////////nauman code ends /////////////////////







//http://www.flannagans.co.uk/crmtest/admin/scrud/status?cfun=importCSV&file=sole.csv&table=business&module_id=41&site_id=33&update=0

    /*

    http://www.flannagans.co.uk/crmtest/admin/scrud/status?cfun=importCSV&file=sole.csv&table=business&module_id=41&site_id=33

    http://www.flannagans.co.uk/crmtest/admin/scrud/status?cfun=importCSV&file=partnership.csv&table=business&module_id=42&site_id=33

    http://www.flannagans.co.uk/crmtest/admin/scrud/status?cfun=importCSV&file=limited.csv&table=business&module_id=43&site_id=33

    http://www.flannagans.co.uk/crmtest/admin/scrud/status?cfun=importCSV&file=llp.csv&table=business&module_id=44&site_id=33
    
    http://www.flannagans.co.uk/crmtest/admin/scrud/status?cfun=importCSV&file=charities.csv&table=business&module_id=45&site_id=33

-------------------------------------

    http://www.flannagans.co.uk/crmtest/admin/scrud/status?cfun=importCSV&file=Gateshead-sole.csv&table=business&module_id=41&site_id=1

    http://www.flannagans.co.uk/crmtest/admin/scrud/status?cfun=importCSV&file=Gateshead-partnership.csv&table=business&module_id=42&site_id=1

    http://www.flannagans.co.uk/crmtest/admin/scrud/status?cfun=importCSV&file=Gateshead-limited.csv&table=business&module_id=43&site_id=1

    http://www.flannagans.co.uk/crmtest/admin/scrud/status?cfun=importCSV&file=Gateshead-llp.csv&table=business&module_id=44&site_id=1
    
    http://www.flannagans.co.uk/crmtest/admin/scrud/status?cfun=importCSV&file=Gateshead-charities.csv&table=business&module_id=45&site_id=1

    */
    public function importCSV(){
        $CI = & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
        global $date_format_convert;
        $this_user_id = $CRUD_AUTH['id'];

        $file = $_GET['file'];
        $table = $_GET['table'];
        $module_id = $_GET['module_id'];
        $site_id = $_GET['site_id'];
        $update = $_GET['update'];

        // path where your CSV file is located
        define('CSV_PATH',getcwd());

        // Name of your CSV file
        $csv_file = CSV_PATH . "/".$file; 


        if (($handle = fopen($csv_file, "r")) !== FALSE) {
            fgetcsv($handle);
            $i = 1;
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {

                //if(!$update or $update==''){
                    if($table=='contact')
                        $f = 'Internal_ID';
                    elseif($table=='business')
                        $f = 'internal_b_id';

                    $CI->db->where($f,$data[0]);
                    $update = $CI->db->count_all_results($table);
                    //echo "<pre>";print_r($data);
                //}
                if($update==0){
                    $value = "";
                    $num = count($data);
                    for ($c=0; $c < $num; $c++) {
                        if($table=='contact' && $c==1){
                            switch(strtolower($data[$c])){
                                case 'mr':
                                case 'mr.':
                                    $data[$c]=1;
                                    break;
                                case 'mrs':
                                case 'mrs.':
                                    $data[$c]=2;
                                    break;
                                case 'ms':
                                case 'ms.':
                                    $data[$c]=3;
                                    break;
                                case 'miss':
                                case 'miss.':
                                    $data[$c]=4;
                                    break;
                                case 'dr':
                                case 'dr.':
                                    $data[$c]=5;
                                    break;
                            }
                        }
                        //$jobparam[$c] = $data[$c];
                        $value .= $CI->db->escape($data[$c]).",";
                    }
                    $value.=$site_id;

                    /// GENEREATE MODULE CRM ID
                    $moduleEntity = new ScrudDao('crud_module_entity_ids', $CI->db);
                    $moduleEntityParam['module_id'] = $module_id;
                    $moduleEntityId = $moduleEntity->insert($moduleEntityParam);

                    /// GET MODULE PREV RECORD NO
                    $params = array();
                    $modNum = new ScrudDao('crud_module_entity_num', $CI->db);
                    $params['fields'] = array('id,module_id','prefix','curr_id');
                    $params['conditions'] = array('module_id="'.$module_id.'"');
                    $params['order'] =  array('id');
                    $rs = $modNum->find($params);

                    /// GENERATE MODULE RECORD NO
                    $moduleTable = $table;
                    $moduleTableField = $table . 'no';
                    $newId =  $rs[0]['curr_id'];
                    $newId = $newId+1;
                    $newModuleId = $rs[0]['prefix'] . $newId;
                    $modNum->update(array('curr_id'=>$newId),array('id='.$rs[0]['id']));

                    $value.=",'".$moduleEntityId."'";
                    $value.=",'".$newModuleId."'";
                    $value.=",'76'";
                    $value.=",".$this_user_id;
                    $value.=",".date('Y-m-d');


                    if($table=='contact')
                        $fields = 'Internal_ID,Title,First_Name,Last_Name,Personal_Street,Personal_Address_2,Personal_Address_3,Personal_Town,Personal_City,Personal_State,Personal_Zip,Personal_Country,Primary_Email,Office_Phone,Mobile_Phone,Fax,site_id,id,contactno,assigned_to,created_by,created';
                    elseif($table=='business'){
                        $value.=",'Draft'";
                            switch(strtolower($module_id)){
                                case '41':
                                    $value.=",1"; 
                                    break;
                                case '42':
                                    $value.=",2"; 
                                    break;
                                case '43':
                                    $value.=",3"; 
                                    break;
                                case '44':
                                    $value.=",4"; 
                                    break;
                                case '45':
                                    $value.=",5"; 
                                    break;
                            }

                        $fields = 'internal_b_id,title,Address_1,Address_2,Address_3,Town,City,County,Post_Code,Country,user_email,phone,fax,site_id,id,businessno,assigned_to,created_by,created,Status,legal_entity';
                    }
      
                    // SQL Query to insert data into DataBase
                    $query = "INSERT INTO $table ($fields) VALUES($value)";
                    if($table=='business'){
                        //$this->relatedTablesEntry(array('id'=>$moduleEntityId));
                        $id = $moduleEntityId;
                        //////////////insert blank records for new business///////////////
                        $CI->db->query("INSERT INTO forms SET id = $id");
                        $CI->db->query("INSERT INTO codes SET id = $id");
                        $CI->db->query("INSERT INTO compliance SET id = $id");
                        $CI->db->query("INSERT INTO services SET id = $id");
                        $CI->db->query("INSERT INTO business_fee SET id = $id");
                        $CI->db->query("INSERT INTO legal_letters_business SET id = $id");
                        //////////////////////////////////////////////////////////////////
                    }
                }else{
                    $value = array();
                    $num = count($data);
                    for ($c=0; $c < $num; $c++) {
                        if($table=='contact' && $c==1){
                            switch(strtolower($data[$c])){
                                case 'mr':
                                case 'mr.':
                                    $data[$c]=1;
                                    break;
                                case 'mrs':
                                case 'mrs.':
                                    $data[$c]=2;
                                    break;
                                case 'ms':
                                case 'ms.':
                                    $data[$c]=3;
                                    break;
                                case 'miss':
                                case 'miss.':
                                    $data[$c]=4;
                                    break;
                                case 'dr':
                                case 'dr.':
                                    $data[$c]=5;
                                    break;
                            }
                        }
                        //$jobparam[$c] = $data[$c];
                        $value[] = $CI->db->escape($data[$c]);
                        //$value[] = $data[$c];
                    }
                    $value[]=$this_user_id;
                    $value[]=$site_id;


                    if($table=='contact')
                        $fields = split(",",'Internal_ID,Title,First_Name,Last_Name,Personal_Street,Personal_Address_2,Personal_Address_3,Personal_Town,Personal_City,Personal_State,Personal_Zip,Personal_Country,Primary_Email,Office_Phone,Mobile_Phone,Fax,modified_by,site_id');
                    elseif($table=='business'){
                        //$fields = split(",",'internal_b_id,title,year_end_date,accounts_due_date,ct600_due_date,vat_quarted_end_date,annual_return_due_date,Address_1,Address_2,Address_3,Town,City,County,Post_Code,Country,user_email,phone,fax,modified_by,site_id');
                        $fields = split(",",'internal_b_id,title,Address_1,Address_2,Address_3,Town,City,County,Post_Code,Country,user_email,phone,fax,modified_by,site_id');
                    }

                    $set = '';
                    $num1 = count($value);
                    for ($c1=0; $c1 < $num1; $c1++) {
                        $set .= $fields[$c1]."=".$value[$c1];
                        $set .= ",";
                    }
                    $set.="modified='".date('Y-m-d')."'";

                    // SQL Query to insert data into DataBase
                    $query = "UPDATE $table SET $set WHERE internal_b_id=".$value[0];

                    if($table=='business'){
                        //$CI->db->select('id');
                        //$CI->db->from('business');
                        //$CI->db->where('internal_b_id = '.$value[0]);
                        $qry = $CI->db->query("SELECT id FROM business WHERE internal_b_id = ".$value[0]);
                        $qid = $qry->row_array();
                        //echo $CI->db->last_query();
                        //$this->relatedTablesEntry(array('id'=>$moduleEntityId));
                        $id = $qid['id'];
                        //////////////insert blank records for new business///////////////
                        $CI->db->query("DELETE FROM forms WHERE id = $id");
                        $CI->db->query("DELETE FROM codes WHERE id = $id");
                        $CI->db->query("DELETE FROM compliance WHERE id = $id");
                        $CI->db->query("DELETE FROM services WHERE id = $id");
                        $CI->db->query("DELETE FROM business_fee WHERE id = $id");
                        $CI->db->query("DELETE FROM legal_letters_business WHERE id = $id");

                        $CI->db->query("INSERT INTO forms SET id = $id");
                        $CI->db->query("INSERT INTO codes SET id = $id");
                        $CI->db->query("INSERT INTO compliance SET id = $id");
                        $CI->db->query("INSERT INTO services SET id = $id");
                        $CI->db->query("INSERT INTO business_fee SET id = $id");
                        $CI->db->query("INSERT INTO legal_letters_business SET id = $id");
                        //////////////////////////////////////////////////////////////////
                    }


                }

                // CREATE FIRST TIME JOB
                //$CI->db->insert('contact',$jobparam);
                $CI->db->query($query);
                $i++;
            }
            fclose($handle);
        }

        echo $i." records successfully imported to database!!";

    }



    public function setJobDetails(){
        $CI = & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
        global $date_format_convert;
        $this_user_id = $CRUD_AUTH['id'];

        $bid = $_GET['bid'];
        $service = $_GET['service'];

        /// GET BUSINESS DATA OF CURRENT RECORD
        $CI->db->select('*');
        $CI->db->from('business');
        $CI->db->where('id',$bid);
        $query = $CI->db->get();
        $business_data = $query->row_array();

        // DECLARE EMPTY ARRAY FOR CREATING JOB
        $jobparam = array();

        $service_titlle = '';

        /// GET BUSINESS DATA OF CURRENT RECORD
        $CI->db->select('*');
        $CI->db->from('services');
        $CI->db->where('id',$bid);
        $query = $CI->db->get();
        $d = $query->row_array();
        switch ($service) {
            case '1':
                $service_titlle = 'Accounts';

                /// PARAMETERS TO CREATE SERVICE ENTRY
                $jobparam = array(
                        'service_id'=>$service,
                        'frequency'=>7,
                        'year_end_date'=>date( 'd-m-Y',$d['Year_End_Date_'.$service]),
                        'due_date'=>date( 'd-m-Y',$d['Due_Date_'.$service]),
                        'service_ceasor_date'=>date( 'd-m-Y',$d['Ceasure_Date_'.$service]),
                        'service_number'=>$d['VAT_NO'],
                        'site_id'=>$d['site_id'],
                    );

                /// PARAMETERS TO CREATE JOB ENTRY
                if ($business_data['legal_entity'] == 1 || $business_data['legal_entity'] == 2 || $business_data['legal_entity'] == 5) {
                    
                    /// get business commencement date
                    $xcd = explode('-', $business_data['commencement_of_trade']);
                    /// if bussiness started after april
                    if ($xcd[1] >= 4) {
                        /// EXPECTED START DATE
                        $exp_start_date = $xcd[0].'-04-06';
                        $jobparam['expected_start_date'] = date ( 'd-m-Y',strtotime ( '+1 years' , strtotime ( $exp_start_date ) ) );

                        /// EXPTECTED END DATE
                        $exp_end_date = $xcd[0].'-01-31';
                        $jobparam['expected_end_date'] = date ( 'd-m-Y',strtotime ( '+2 years' , strtotime ( $exp_end_date ) ) );
                    } else {
                        /// EXPECTED START DATE
                        $exp_start_date = $xcd[0].'-04-06';
                        $jobparam['expected_start_date'] = $exp_start_date;

                        /// EXPTECTED END DATE
                        $exp_end_date = $xcd[0].'-01-31';
                        $jobparam['expected_end_date'] = date ( 'd-m-Y',strtotime ( '+1 years' , strtotime ( $exp_end_date ) ) );
                    }

                } else if ($business_data['legal_entity'] == 3 || $business_data['legal_entity'] == 4) {

                    /// CREATE JOB FOR RIGHT AFTER 1 YEAR OF COMMENCEMENT DATE
                    $expected_start_date = date ( 'd-m-Y',strtotime ( '+1 years' , strtotime ( $business_data['commencement_of_trade'] ) ) );

                    $jobparam['expected_start_date'] =  $expected_start_date;
                    $jobparam['expected_end_date'] = date ( 'd-m-Y',strtotime ( '+9 months' , strtotime ( $expected_start_date ) ) );
                }
                break;
            case '2':
                $service_titlle = 'Annual Return';
                $jobparam = array(
                        'service_id'=>$service,
                        'frequency'=>5,
                        'due_date'=>date( 'd-m-Y',$d['Due_Date_'.$service]),
                        'actual_submission_date'=>date( 'd-m-Y',$d['Submission_Date']),
                        'status'=>$d['Status_'.$service],
                        'status_date'=>date( 'd-m-Y',$d['Status_Date_'.$service]),
                        
                        'service_ceasor_date'=>date( 'd-m-Y',$d['Ceasure_Date_'.$service]),
                        'service_number'=>$d['VAT_NO'],
                        'site_id'=>$d['site_id'],
                    );
                if ($business_data['legal_entity'] == 3 || $business_data['legal_entity'] == 4) {
                    /// CREATE JOB FOR RIGHT AFTER 1 YEAR OF COMMENCEMENT DATE
                    $expected_start_date = date ( 'd-m-Y',strtotime ( '+1 years' , strtotime ( $business_data['commencement_of_trade'] ) ) );

                    $jobparam['expected_start_date'] =  $expected_start_date;
                    //$jobparam['expected_end_date'] = date ( 'Y-m-d',strtotime ( '+9 months' , strtotime ( $expected_start_date ) ) );
                }
                break;
            case '3':
                $service_titlle = 'VAT';
                $jobparam = array(
                        'service_id'=>$service,
                        'frequency'=>5,
                        'date_of_registration'=>date( 'd-m-Y',$d['Date_of_Register_'.$service]),
                        'qe_date'=>date( 'd-m-Y',$d['QE_Date_'.$service]),
                        'ec_list'=>$d['EC_List_'.$service],
                        'scheme'=>$d['Scheme_'.$service],
                        'payment_method'=>$d['Payment_Method_'.$service],
                        'service_ceasor_date'=>date( 'd-m-Y',$d['Ceasure_Date_'.$service]),
                        'service_number'=>$d['VAT_NO'],
                        'site_id'=>$d['site_id'],
                    );
                /// EXPECTED START DATE
                $expected_start_date = date ( 'd-m-Y',strtotime ( '+3 months' , strtotime ( $business_data['commencement_of_trade'] ) ) );

                $jobparam['expected_start_date'] =  $expected_start_date;
                /// EXPECTED END DATE
                $jobparam['expected_end_date'] = date ( 'd-m-Y',strtotime ( '+35 days' , strtotime ( $expected_start_date ) ) );
                break;
            case '4':
                $service_titlle = 'Tax';
                 /// PARAMETERS TO CREATE SERVICE ENTRY
                $jobparam = array(
                        'service_id'=>$service,
                        'frequency'=>5,
                        'year_end_date'=>date( 'd-m-Y',$d['Year_End_'.$service]),
                        'tax_year_date'=>date( 'd-m-Y',$d['Tax_Year_End']),
                        'due_date'=>date( 'd-m-Y',$d['Due_Date_'.$service]),
                        'service_ceasor_date'=>date( 'd-m-Y',$d['Ceasure_Date_'.$service]),
                        'service_number'=>$d['VAT_NO'],
                        'site_id'=>$d['site_id'],
                    );

                /// PARAMETERS TO CREATE JOB ENTRY
                if ($business_data['legal_entity'] == 1 || $business_data['legal_entity'] == 2 || $business_data['legal_entity'] == 5) {
                    
                    /// get business commencement date
                    $xcd = explode('-', $business_data['commencement_of_trade']);
                    /// if bussiness started after april
                    if ($xcd[1] >= 4) {
                        /// EXPECTED START DATE
                        $exp_start_date = $xcd[0].'-04-06';
                        $jobparam['expected_start_date'] = date ( 'd-m-Y',strtotime ( '+1 years' , strtotime ( $exp_start_date ) ) );

                        /// EXPTECTED END DATE
                        $exp_end_date = $xcd[0].'-01-31';
                        $jobparam['expected_end_date'] = date ( 'd-m-Y',strtotime ( '+2 years' , strtotime ( $exp_end_date ) ) );
                    } else {
                        /// EXPECTED START DATE
                        $exp_start_date = $xcd[0].'-04-06';
                        $jobparam['expected_start_date'] = $exp_start_date;

                        /// EXPTECTED END DATE
                        $exp_end_date = $xcd[0].'-01-31';
                        $jobparam['expected_end_date'] = date ( 'd-m-Y',strtotime ( '+1 years' , strtotime ( $exp_end_date ) ) );
                    }

                } else if ($business_data['legal_entity'] == 3 || $business_data['legal_entity'] == 4) {

                    /// CREATE JOB FOR RIGHT AFTER 1 YEAR OF COMMENCEMENT DATE
                    $expected_start_date = date ( 'd-m-Y',strtotime ( '+1 years' , strtotime ( $business_data['commencement_of_trade'] ) ) );

                    $jobparam['expected_start_date'] =  $expected_start_date;
                    $jobparam['expected_end_date'] = date ( 'd-m-Y',strtotime ( '+9 months' , strtotime ( $expected_start_date ) ) );
                }
                break;
            case '5':
                $service_titlle = 'Payroll';
                $jobparam = array(
                        'service_id'=>$service,
                        'frequency'=>$d['Frequency'],
                        'acc_ref'=>$d['Account_Ref'],
                        'staging_date'=>date( 'd-m-Y',$d['Staging_Date']),
                        'payroll_no'=>$d['Payroll_No'],
                        'service_ceasor_date'=>date( 'd-m-Y',$d['Ceasure_Date_'.$service]),
                        'service_number'=>$d['VAT_NO'],
                        'site_id'=>$d['site_id'],
                    );
                /// EXPECTED START DATE
                $expected_start_date = date ( 'd-m-Y',strtotime ( '+1 months' , strtotime ( date('Y-m-01') ) ) );

                $jobparam['expected_start_date'] =  $expected_start_date;
                /// EXPECTED END DATE
                $jobparam['expected_end_date'] = date ( 'd-m-Y',strtotime ( '+4 days' , strtotime ( $expected_start_date ) ) );
                break;

            default:
                # code...
                break;

        }
        echo json_encode($jobparam);
        return $jobparam;
                
    }

    /**
     * For getting folders sub folders and files tree 
     * @param  integer  $current_user_id [for current user id]  
     * @param  integer $id              [parent id]
     * @return [array]                   [multidimentional array of folders and files]
     */
    public function get_folder_dir($current_user_id, $id = 0){
        $CI = & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
        $CI->load->model('crud_auth');
        $auth = $CI->crud_auth;
        ////////////////////////////
        // Checking global access //
        ////////////////////////////
        $globalAccess = 0;
        $permissions = $auth->getPermissionType();
        if (in_array(5, $permissions)) {
            $globalAccess = 1;
        }

        //////////////////////////////////////////////////////
        // Getting folder and files with recursive function //
        //////////////////////////////////////////////////////
        $CI->db->select('*');
        $CI->db->from('doc_folders');
        if ( $globalAccess == 0 && !empty($CRUD_AUTH) && isset($CRUD_AUTH['id']) ){
            $CI->db->where('created_by',$current_user_id);
            $CI->db->or_where('assigned_to',$current_user_id);
        }
        $CI->db->where('site_id',$CRUD_AUTH['site_id']);
        $CI->db->where('Parent_Folder',$id);
        $result = $CI->db->get()->result();
        
        $folder = array();
        foreach ($result as $mainFolder) {
            $folder_array = array();
            $folder_array['id'] = $mainFolder->id;
            $folder_array['folder_name'] = $mainFolder->folder_name;
            $folder_array['Parent_Folder'] = $mainFolder->Parent_Folder;
            $is_sub_folder = $this->get_folder_dir($current_user_id,  $mainFolder->id);
            ////////////////////////////
            // if sub folder exists //
            ////////////////////////////
            if (!empty($is_sub_folder)) {
                $folder_array['sub_folder'] = $this->get_folder_dir($current_user_id, $mainFolder->id);
            }
            else{
                /////////////////////////
                // getting files array //
                /////////////////////////
                $CI->db->select('*');
                $CI->db->from('crm_documents');
                $CI->db->where('site_id',$CRUD_AUTH['site_id']);
                $CI->db->where('folder_name',$mainFolder->id);
                $files_result = $CI->db->get()->result_array();
                $folder_array['files'] = $files_result;
            }
            $folder[$mainFolder->id] = $folder_array;
        }
      return $folder;
    }

    /**
     * Convertting php array to jstree usable data using recursive function
     * @param  multildimentional array $folder 
     * @return jstree array         
     */
    function array2jstree($folder){
        $out = '';
        foreach($folder as $first_level){
            $out .= "<li  data-jstree='{ ".'"folder_id"'." : ".$first_level['id']." }'>".$first_level['folder_name'];            
            if(isset($first_level['sub_folder']) && is_array($first_level['sub_folder'])){
                $out .= $this->array2jstree($first_level['sub_folder']);
            }else{
                if(isset($first_level['files']) && !empty($first_level['files'])){
                    foreach($first_level['files'] as $file){
                        if (!empty($file['description'])) {
                            $out .= "<ul><li data-jstree='{ \"icon\" : \"fa fa-file icon-state-success\", \"file_id\" : ".$file['id'].", \"file_orginal_id\" : ".$file['description']." }' class=\"jstree-nochildren\">".$file['file']."</li></ul>";
                        }else{
                            $out .= "<ul><li data-jstree='{ \"icon\" : \"fa fa-file icon-state-success\", \"file_id\" : ".$file['id'].", \"file_name\" : \"".$file['file']."\" }' class=\"jstree-nochildren\">".$file['file']."</li></ul>";
                        }
                    }
                }
            }
            $out .= '</li>';
        }
        return "<ul>$out</ul>";
    }

/////// Business Summary /////////////
public function modalBusinessSummaryView(){
        $CI = & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
        
        $bid = $_GET['bid'];
        $site_id = $CRUD_AUTH['site_id'];
        //print_r($_GET);exit;

        ////////nauman code starts here/////////

        $result_job=$CI->db->query("SELECT  SUM(IF(job_status = 1 , 1 , 0)) AS 'open_jobs',SUM(IF(job_status= 2, 1, 0)) AS 'close_jobs',SUM(IF(job_status=3, 1, 0)) AS 'in_progress',SUM(IF(job_status= 4, 1, 0)) AS 'on_hold' FROM jobs WHERE business= ".$bid ." and site_id= ".$site_id );
        $result=$result_job->result_array();
        // echo "<pre>";
        // print_r($result_job->result_array());
        // exit;
        
        $open_jobs=($result[0]['open_jobs']!=''?$result[0]['open_jobs']:'0');
        $close_jobs=($result[0]['close_jobs']!=''?$result[0]['close_jobs']:'0');
        $in_progress=($result[0]['in_progress']!=''?$result[0]['in_progress']:'0');
        $on_hold=($result[0]['on_hold']!=''?$result[0]['on_hold']:'0');

        // echo $open_jobs . "<br/>";
        // echo $close_jobs . "<br/>";
        // echo $in_progress . "<br/>";
        // echo $on_hold . "<br/>";
        // exit;

        $CI->db->select('*');
        $CI->db->from('business_fee');
        $CI->db->where('id',$bid);
        $CI->db->where('site_id',$site_id);
        $query=$CI->db->get();
        $result=$query->result_array();
        $business_fee=$result[0];

        $CI->db->select('currency_symbol');
        $CI->db->from('currencies');
        $CI->db->where('currency_status',3);
        $CI->db->where('site_id',$site_id);
        $query=$CI->db->get();
        $result=$query->result_array();
        $currency_symbol=$result[0]['currency_symbol'];
        // echo "<pre>";
        // print_r($result);exit;



        if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database . '/' .sha1('com_'.$_GET['com_id']). '/' . $_GET['table'] . '.php')) {
                    exit;
        }
        $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $CI->db->database. '/' .sha1('com_'.$_GET['com_id']) . '/' . $_GET['table'] . '.php'));
        
        $mainModuleConf = unserialize($content);

        $mainModuleFields = $mainModuleConf['form_elements'];
        //echo "<pre>";
        //print_r($mainModuleConf);exit;

        $CI->db->select('*');
        $CI->db->from('business');
        $CI->db->where('id',$bid);
        $CI->db->where('site_id',$site_id);
        $query=$CI->db->get();
        $result=$query->result_array();
        $business_data=$result[0];
        // echo "<pre>";
        // print_r($result);exit;
        $business_d_info=array();
        foreach ($mainModuleFields[4]['section_fields'] as $key => $value) {
            //echo $key. "<br/>";
            $parse=explode('.',$key);
            //echo "name: ".$parse[1] . "<br/>";
            if(!isset($business_data[$parse[1]]))
                continue;
            $business_d_info[]=array(0=>$business_data[$parse[1]],
                                    1=>$value['alias']);

        }
        // echo "<pre>";
        // print_r($business_d_info);exit;

        $business_name=$business_data['title'];

        //echo $business_data['contact'];exit;
        $contact_info=array();
        $contact_info['com_id']=$_GET['com_id'];
        if($_GET['com_id']==41){
            $CI->db->select(array('First_Name','Last_Name','Office_Phone'));
            $CI->db->from('contact');
            $CI->db->where('id',$business_data['contact']);
            $query=$CI->db->get();
            $result=$query->result_array();
            $contact_info['contacts'][]=$result[0];
             // echo "<pre>";
             // print_r($contact_info);exit;
        }
        else if($_GET['com_id']==42 || $_GET['com_id']==43
         || $_GET['com_id']==44 || $_GET['com_id']==45 )
        {
            $partner_ids=explode(',',$business_data['contact']);
            foreach ($partner_ids as $s_id){
                $CI->db->select('contact');
                $CI->db->from('partners');
                $CI->db->where('id',$s_id);
                $query=$CI->db->get();
                $result=$query->result_array();
                $con=$result[0]['contact'];

                $CI->db->select(array('First_Name','Last_Name','Office_Phone'));
                $CI->db->from('contact');
                $CI->db->where('id',$con);
                $query=$CI->db->get();
                $result=$query->result_array();
                $contact_info['contacts'][]=$result[0];
            }
        }
        // echo "<pre>";
        // print_r($contact_info);
        // exit;

        ////////nauman code ends here/////////



        if (is_file(FCPATH . 'application/views/admin/scrud/templates/browse/business_summary_view.php')) {
            require_once FCPATH . 'application/views/admin/scrud/templates/browse/business_summary_view.php';
            exit;
        } else {
            die(FCPATH . 'application/views/admin/scrud/templates/browse/business_summary_view.php is not found.');
        }
    }
//////////////////////////////////////////////

}
