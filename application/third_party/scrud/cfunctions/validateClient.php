<?php

    function validateClient($var=array()) {
        $CI = & get_instance();
        $id = $var['id'];

        $var = array();
        $errors = array();
        //echo "<pre>";print_r($_POST);exit;
        foreach($_POST['data'] as $kkey => $vvalue){
        	$ttable=$kkey;
        	$tempp=array_values($_POST['data']);
        	$crudUser=$tempp[0];
        	break;
        }

        //echo $ttable." <pre> ";print_r($crudUser);exit;
        switch($ttable){
        	case 'business':
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
		            if(!((!isset($crudUser['user_name'])||$crudUser['user_name']=="" )&&
               (!isset($crudUser['user_password'])||$crudUser['user_password']=="" )))
              {
               

               if((isset($crudUser['user_name'])&&$crudUser['user_name']!="" )&&(!isset($crudUser['user_password'])||$crudUser['user_password'] =="" )&&(!isset($crudUser['user_email'])||$crudUser['user_email']=="" )){
                $errors[] = "Email Address and Password can not be empty with Login ID.";
               }

               if((isset($crudUser['user_name'])&&$crudUser['user_name']!="" )&&(isset($crudUser['user_password'])&&$crudUser['user_password'] !="" )&&(!isset($crudUser['user_email'])||$crudUser['user_email']=="" )){
                $errors[] = "Email Address can not be empty with Login ID and Password.";
               }


               if((isset($crudUser['user_password'])&&$crudUser['user_password']!="" )&&(isset($crudUser['user_email'])&&$crudUser['user_email'] !="" )&&(!isset($crudUser['user_name'])||$crudUser['user_name']=="" )){
                $errors[] = "Login ID can not be empty with Password and Email Address.";
               }

               if((isset($crudUser['user_password'])&&$crudUser['user_password']!="" )&&(!isset($crudUser['user_email'])||$crudUser['user_email'] =="" )&&(!isset($crudUser['user_name'])||$crudUser['user_name']=="" )){
                $errors[] = "Login ID and Email Address can not be empty with Password .";
               }

               if(((!isset($crudUser['user_password'])||$crudUser['user_password']=="" )&&(isset($crudUser['user_email'])&&$crudUser['user_email'] !="" )&&(isset($crudUser['user_name'])&&$crudUser['user_name']!="" ))&& $uid==0){
                $errors[] = "Password can not be empty with Login ID and Email Address.";
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
	                }
		            if ($errors)
		                return $errors[0];
		            else
		                return false;
		        }

    			break;

    		case 'crud_users':
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
    	
    			break;
    		case 'user_groups':
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

    			break;

    		case 'legal_letters':
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
    			break;
    		case 'legal_letters_data':
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
    			break;

    		case 'currencies':
    			$currencies=$crudUser;
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
    			break;
    		case 'jobs':
    			$jobs=$crudUser;
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
    			break;
    		case 'holiday_request':
    			////////////////////nauman code starts here...................
    			$holidays=$crudUser;
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
    	
    			break;

        	default:
        		break;
        }




        return false;
    }


?>