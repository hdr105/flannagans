<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once FCPATH . 'application/third_party/scrud/templates/template_functions.php';
class Webservices extends Ws_Controller {
	public function __construct(){
		parent::__construct();
	
	}
	public function cron(){
		$CI = & get_instance();
		$var 					= array();
		
		//REPEAT RECURRING CALENDARS
			// DAILY
			$repeat_daily = array();
    		$sql = "SELECT * FROM calendar WHERE recurringtype = 1";
    		$query = $this->db->query($sql);
    		if (!empty($query)) {
    			foreach ($query->result_array() as $row) {
    				$repeat_daily[] = $row;
    			}
    		}
    		foreach ($repeat_daily as $key => $value) {
    			$sdate = $value['date_start'];
    			$edate = $value['due_date'];
    			$xs = explode('-', $sdate);
    			$xe = explode('-', $edate);
    			$daysDifference = $xe[2] - $xs[2];
    			$newDay = ((int) date('d')) + $daysDifference;
    			$newStatDate = date('Y-m-d');
    			$newEndDate = date('Y') .'-'. date('m') . '-' .$newDay;
    		}
			// DAILY ENDS
		//REPEAT RECURRING CALENDARS ENDS HERE
    	// AUTO CREATE JOBS
    	$month = ((int) date('m')) +1;
    	$year = (int) date('Y');
    	$rep_services = array();
    	$sql = "SELECT * FROM services WHERE MONTH(Due_Date_1) = '{$month}' AND YEAR(Due_Date_1) = '{$year}'";
    	$query = $this->db->query($sql);
    	if (!empty($query)) {
    		foreach ($query->result_array() as $row) {
    			$rep_services[] = $row;
    		}
    	}
    	foreach ($rep_services as $key => $value) {
    		$business = array();
    		$sdDate = explode('-', $value['Due_Date_1']);
    		$sql = "SELECT business.id, business.title FROM business INNER JOIN sites ON sites.id = business.site_id WHERE business.site_id = '".$value['site_id']."' LIMIT 1";
    		if (!empty($query)) {
    		foreach ($query->result_array() as $row) {
    			$business[] = $row;
    		}
    		// Generate CRM ID
    		$moduleId = 76;
    		$c = array(
                	'module_id'=>   $moduleId,
                );
            $this->db->insert('crud_module_entity_ids',$c);
            $crmid = $this->db->insert_id();
    		
    		$expectedJobStartDate = $year .'-' . $month . '-' . $sdate[2];
    		$this->db->select('*');
            $this->db->from('crud_module_entity_num');
            $this->db->where('module_id',$moduleId);
            $query = $this->db->get();
            $mod_num = $query->row_array();
            $num = (int) $mod_num['curr_id'];


            $newRecordNumber =  ++$num;
            $newRecordNo = $mod_num['prefix'] . $newRecordNumber;
            $data = array('curr_id' => $newRecordNumber);

            $this->db->where('id', $moduleId);
            $this->db->update('crud_module_entity_num', $data);
    		$jp = array(
    			'id'=>$crmid,
    			'title'=>$business[0]['title'],
    			'business'=>$business[0]['id'],
    			'job_status'=>1,
    			'job_status'=>1,
    			'expected_start_date'=>$expectedJobStartDate,
    			'site_id'=>$value['site_id'],
    			'jobsno'=>$newRecordNo,
    		);
    		$this->db->insert('jobs',$jp);
    	}
    	}
    	// AUTO CREATE JOBS ENDS HERE	
		$json = array(
				'status'=>true,
			    'result'=>$rep_services
		    );
    			
		$var['json'] 			= json_encode($json);
    	$var['main_content'] 	= $this->load->view('ws/webservices', $var, true);
    	$this->load->view('layouts/ws/webservices', $var);
	}
    public function index(){
    	$var 					= array();    	
    	$operation 				= $this->input->post('operation');
    	$user_info				= array();

        $CI = & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
        $this_user_id = $CRUD_AUTH['id'];

    	switch ($operation) {
    		case 'post_comments':
	    		$CI = & get_instance();
	    		$CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
				$this_user_id = $CRUD_AUTH['id'];
	    		global $date_format_convert;
    			$data = $this->input->post('data');
        		if($data['comments'] != ''){
        			$c = array(
						'module_id'=>68,
					);
	        		$this->db->insert('module_entity_ids',$c);
					$crmid = $this->db->insert_id();
	        		$params = array(
	        			'id' => $crmid,
	        			'module'=>$data['module'],
	        			'record'=>$data['recordId'],
	        			'userid'=>$this_user_id,
	        			'comments_text'=>$data['comments'],
	        			'created'=>date('Y-m-d H:i:s'),
	        		);
	        		$this->db->insert('comments',$params);
        		}

        		
        		$comments_list = array();
        		$sql = "SELECT comments.comments_text AS text, comments.created AS created_on, CONCAT(crud_users.user_first_name,' ', crud_users.user_las_name) AS user_name FROM comments INNER JOIN crud_users ON comments.userid = crud_users.id WHERE comments.record = '".$data['recordId']."' ";
        		$query = $this->db->query($sql);
		        if (!empty($query)) {
		            foreach ($query->result_array() as $row) {
		                $comments_list[] = $row;
		            }
		        }
		        foreach ($comments_list as $key => $value) {
		        	if (array_key_exists('created_on', $value)) {
		        		$date = $value['created_on'];
		        		if (is_date($date)){
                            $comments_list[$key]['created_on'] = date($date_format_convert[__DATE_FORMAT__],strtotime($date));
                        }else{
                             $comments_list[$key]['created_on'] = '';
                        }
		        		
		        	}
		        	
		        }

    			$json = array(
		    		'status'=>true,
		    		'result'=>$comments_list,
		    	);
    		break;
            case 'available_holidays':
                $CI = & get_instance();
                $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
                $this_user_id = $this->input->post('this_user_id');
                $site_id = $this->input->post('site_id');
                $available = array();
                $sql = "SELECT * FROM `crud_users` WHERE id = '".$this_user_id."' ";
                $query = $this->db->query($sql);
                    if (!empty($query)) {
                        foreach ($query->result_array() as $row) {
                            $available[] = $row;
                        }
                    }
                $json = array(
                    'status'=>true,
                    'result'=>$available,
                );
                break;
            case 'staffholiday':
                $CI = & get_instance();
                $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
                $this_user_id = $CRUD_AUTH['id'];
                $site_id = $this->input->post('site_id');
                $holiday_requests = array();
                $sql = "SELECT * FROM `holiday_request` WHERE site_id = '".$site_id."' ORDER BY id DESC LIMIT 0,10";
                $query = $this->db->query($sql);
                    if (!empty($query)) {
                        foreach ($query->result_array() as $row) {
                            $holiday_requests[] = $row;
                        }
                    }
                $json = array(
                    'status'=>true,
                    'result'=>$holiday_requests,
                );
            break;
            case 'staff_on_break':
                $CI = & get_instance();
                $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
                $this_user_id = $CRUD_AUTH['id'];
                $site_id = $this->input->post('site_id');
                $onbreakstaff = array();
                $sql = "SELECT users_work_log.time_start, users_work_log.status , CONCAT(crud_users.user_first_name, ' ', crud_users.user_las_name) AS username FROM `users_work_log` INNER JOIN crud_users ON crud_users.id = users_work_log.user_id WHERE (users_work_log.status = 'break' OR users_work_log.status = 'lunch') AND (users_work_log.dated = '".date('Y-m-d')."' AND users_work_log.user_id IN (SELECT id FROM crud_users WHERE crud_users.site_id = '".$site_id."')) group by users_work_log.user_id  LIMIT 0,10";
                $query = $this->db->query($sql);
                    if (!empty($query)) {
                        foreach ($query->result_array() as $row) {
                            $onbreakstaff[] = $row;
                        }
                    }
                $json = array(
                    'status'=>true,
                    'result'=>$onbreakstaff,
                    
                );
            break;
            case 'staff_working_hours':
                $working_hours = array();
                $sql = "select CONCAT(u.user_first_name, ' ',u.user_las_name) AS username, sum(case when status = 'working' then time_spent else 0 end) as working_time, sum(case when status = 'lunch' then time_spent else 0 end) as lunch_time, sum(case when status = 'break' then time_spent else 0 end) as break_time, sum(case when status = 'meeting' then time_spent else 0 end) as meeting_time from crud_users as u left join users_work_log as t on u.id = t.user_id WHERE time_start != '00:00:00' AND DATE(dated) >= DATE(DATE_ADD(curdate(), INTERVAL - 6 DAY)) AND u.group_id!=1 AND u.group_id!=5 group by u.user_name";
                $query = $this->db->query($sql);
                    if (!empty($query)) {
                        foreach ($query->result_array() as $row) {
                            $working_hours[] = $row;
                        }
                    }
                $json = array(
                    'status'=>true,
                    'result'=>$working_hours,
                );
                break;
            case 'lega_letters_list':
                $CI = & get_instance();
                $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
                $this_user_id = $CRUD_AUTH['id'];
                $leter_list = array();
                $sql = "SELECT `legal_letters`.`letter_name`,`doc_folders`.`folder_name` FROM `legal_letters` INNER JOIN `doc_folders` ON `doc_folders`.`id` =`legal_letters`.`id`";
                $query = $this->db->query($sql);
                    if (!empty($query)) {
                        foreach ($query->result_array() as $row) {
                            $leter_list[] = $row;
                        }
                    }
                $json = array(
                    'status'=>true,
                    'result'=>$leter_list,
                );
                break;
            case 'assigned_jobs_to_staff':
                $site_id = $this->input->post('site_id');
                $this_user_id = $this->input->post('this_user_id');
                $dashboard = $this->input->post('dashboard');
                    
                $add_sql = '';
                if ($dashboard != 1) {
                    $add_sql = " AND jobs.assigned_to = '".$this_user_id."' ";
                }

                $assigned_jobs = array();
                $sql = "SELECT * FROM jobs WHERE DATE(created) >= DATE(DATE_ADD(curdate(), INTERVAL - 6 DAY)) AND site_id = '".$site_id."' ".$add_sql." LIMIT 0,10 ";
                $query = $this->db->query($sql);
                if (!empty($query)) {
                    foreach ($query->result_array() as $row) {
                        $assigned_jobs[] = $row;
                    }
                }
                $json = array(
                    'status'=>true,
                    'result'=>$assigned_jobs,
                );
                break;
            case 'deadlines':
                $site_id = $this->input->post('site_id');
                $this_user_id = $this->input->post('this_user_id');
                $dashboard = $this->input->post('dashboard');
                    
                $add_sql = '';
                if ($dashboard != 1) {
                    $add_sql = " AND jobs.assigned_to = '".$this_user_id."' ";
                }

                ///  TOTAL JOBS CRATED LAST WEEK
                $total_jobs = 0;
                $sql = "SELECT COUNT(id) AS total_last_week FROM jobs WHERE DATE(created) >= DATE(DATE_ADD(curdate(), INTERVAL - 6 DAY)) AND  site_id = '".$site_id."' ".$add_sql." ";
                $query = $this->db->query($sql);
                if (!empty($query)) {
                    foreach ($query->result_array() as $row) {
                        $total_jobs = $row['total_last_week'];
                    }
                }
                /// TOTAL JOBS CLOSED LAST WEEK
                $total_jobs_closed = 0;
                $sql = "SELECT COUNT(id) AS total_last_week FROM jobs WHERE job_status = 2 AND DATE(created) >= DATE(DATE_ADD(curdate(), INTERVAL - 6 DAY)) AND  site_id = '".$site_id."' ".$add_sql." ";
                $query = $this->db->query($sql);
                if (!empty($query)) {
                    foreach ($query->result_array() as $row) {
                        $total_jobs_closed = $row['total_last_week'];
                    }
                }
                /// TOTAL JOBS OPEN LAST WEEK
                $total_jobs_open = 0;
                $sql = "SELECT COUNT(id) AS total_last_week FROM jobs WHERE job_status = 1 AND DATE(created) >= DATE(DATE_ADD(curdate(), INTERVAL - 6 DAY)) AND  site_id = '".$site_id."' ".$add_sql." ";
                $query = $this->db->query($sql);
                if (!empty($query)) {
                    foreach ($query->result_array() as $row) {
                        $total_jobs_open = $row['total_last_week'];
                    }
                }
                /// JBOS LIST OF LAST WEEK
                $jobs_list = array();
                $sql = "SELECT jobs.title, jobs.job_status, jobs.expected_start_date, sites.sitename, CONCAT(crud_users.user_first_name, ' ', crud_users.user_las_name) AS username FROM jobs INNER JOIN sites ON jobs.site_id = sites.id INNER JOIN crud_users ON jobs.assigned_to = crud_users.id WHERE jobs.job_status = 1 AND DATE(jobs.created) >= DATE(DATE_ADD(curdate(), INTERVAL - 6 DAY)) AND jobs.site_id = '".$site_id."' ".$add_sql." ORDER BY jobs.id DESC LIMIT 0,10 ";
                $query = $this->db->query($sql);
                if (!empty($query)) {
                    foreach ($query->result_array() as $row) {
                        $jobs_list[] = $row;
                    }
                }
                $progress_of_last_week = ($total_jobs_closed/$total_jobs)*100;
                $json = array(
                    'status'=>true,
                    'result'=>array(
                        'total_jobs'=>$total_jobs,
                        'total_clsoed'=>$total_jobs_closed,
                        'total_open'=>$total_jobs_open,
                        'job_list' => $jobs_list,
                        'progress_of_week'=>$progress_of_last_week,
                        ),
                );
                break;
            case 'open_jobs':
                    $site_id = $this->input->post('site_id');
                    $this_user_id = $this->input->post('this_user_id');
                    $dashboard = $this->input->post('dashboard');
                    
                    $add_sql = '';
                    if ($dashboard != 1) {
                        $add_sql = " AND jobs.assigned_to = '".$this_user_id."' ";
                    }

                    $open_jobs = array();
                    $sql = "SELECT title, job_status FROM jobs  WHERE (jobs.job_status = '1' OR  jobs.job_status IS NULL) AND DATE(created) >= DATE(DATE_ADD(curdate(), INTERVAL - 6 DAY)) AND  site_id = '".$site_id."' ".$add_sql." ORDER BY id DESC ";
                    $no_of_weekly_jobs = $this->db->query($sql)->num_rows();
                    $sql = "SELECT title, job_status FROM jobs  WHERE (jobs.job_status = '1' OR  jobs.job_status IS NULL) AND DATE(created) >= DATE(DATE_ADD(curdate(), INTERVAL - 6 DAY)) AND  site_id = '".$site_id."' ".$add_sql." ORDER BY id DESC LIMIT 0,10 ";
                    $query = $this->db->query($sql);
                    if (!empty($query)) {
                        foreach ($query->result_array() as $row) {
                          
                            $open_jobs[] = $row;
                        }
                    }
                    $weekly_opned_jobs = array();
                    $sql = "SELECT COUNT(id) AS total_last_week, created FROM jobs WHERE (jobs.job_status = '1' OR  jobs.job_status IS NULL) AND DATE(created) >= DATE(DATE_ADD(curdate(), INTERVAL - 6 DAY)) AND  site_id = '".$site_id."' ".$add_sql." GROUP BY DATE(created)";
                    $query = $this->db->query($sql);
                    if (!empty($query)) {
                        foreach ($query->result_array() as $row) {
                            $weekly_opned_jobs[] = $row['total_last_week'];
                        }
                    }
                    $json = array(
                        'status'=>true,
                        'result'=>array(
                            'open_jobs'=>$open_jobs,
                            'weeks_count'=>$weekly_opned_jobs,
                            'weeks_count_no'=>$no_of_weekly_jobs
                            ),
                    );
                break;
            case 'client_due_fee':
                // Code edited by Tariq Mahmood: All Quries in this case are changed
                $CI = & get_instance();
                $site_id = $this->input->post('site_id');
                $this_user_id = $this->input->post('this_user_id');
                $dashboard = $this->input->post('dashboard');

                $add_sql = '';
                if ($dashboard == 2) {
                    $add_sql = " AND business.assigned_to = ".$this_user_id;
                    //$add_sql = " AND business.user_id = '".$this_user_id."' ";
                }elseif ($dashboard == 3) {
                    //$add_sql = " AND business.assigned_to = '".$this_user_id."' ";
                    $add_sql = " AND business.user_id =   " .$this_user_id;
                }

                // Old Qury for last week fee details
                /*
                $sql = "SELECT business_fee.Agreed_Fee, business_fee.Agreed_Fee_Date,
                business_fee.Fee_Status, sites.sitename, business.title
                FROM business_fee INNER JOIN sites ON sites.id = business_fee.site_id
                INNER JOIN business ON business.site_id = sites.id
                WHERE business_fee.Agreed_Fee IS NOT NULL
                AND business_fee.Fee_Status =1 AND  sites.id = '".$site_id."' ".$add_sql."
                GROUP BY business_fee.id
                ORDER BY business_fee.id DESC LIMIT 5";
                */
                // JOB FEE DATA AND STATUS
                $last_week_fee_detials = array();
                $sql = "SELECT  business_fee.Agreed_Fee, business_fee.Agreed_Fee_Date, 
                business_fee.Fee_Status, sites.sitename, business.title 

                FROM business,business_fee, sites      

                WHERE business_fee.Agreed_Fee IS NOT NULL  
                AND business.id = business_fee.id  
                AND sites.id = business.site_id 
                AND sites.id = "  .$site_id .

                $add_sql.

                " ORDER BY business_fee.id DESC LIMIT 5";

                $query = $this->db->query($sql);


                if (!empty($query)) {
                    foreach ($query->result_array() as $row) {
                        $last_week_fee_detials[] = $row;
                    }

                }
                $total_fee_rec_lw = array();

                // Old Qury for received last weak
                /*
                $sql = "SELECT business_fee.Agreed_Fee, business_fee.Agreed_Fee_Date,
                business_fee.Fee_Status, sites.sitename, business.title
                FROM business_fee INNER JOIN sites ON sites.id = business_fee.site_id
                INNER JOIN business ON business.site_id = sites.id
                WHERE business_fee.Agreed_Fee IS NOT NULL
                AND business_fee.Fee_Status =0 AND  sites.id = '".$site_id."' ".$add_sql."
                GROUP BY business_fee.id ORDER BY business_fee.id DESC LIMIT 5";
                */

                $sql = "SELECT business_fee.Agreed_Fee, business_fee.Agreed_Fee_Date, business_fee.Fee_Status, sites.sitename, business.title 

                FROM business,business_fee, sites     

                WHERE business_fee.Agreed_Fee IS NOT NULL  
                AND business_fee.Fee_Status = 1
                AND business.id = business_fee.id  
                AND sites.id = business.site_id 
                AND sites.id = "  .$site_id .
                $add_sql.
                " ORDER BY business_fee.id DESC LIMIT 5";

                $query = $this->db->query($sql);
                if (!empty($query)) {
                    foreach ($query->result_array() as $row) {
                        $total_fee_rec_lw[] = $row;
                    }
                }
                //business_fee.Fee_Status =1 AND
                $over_due_lw = array();

                // Old Qury for over due last weak
                /*
                $sql = "SELECT business_fee.Agreed_Fee, business_fee.Agreed_Fee_Date,
                business_fee.Fee_Status, sites.sitename, business.title
                FROM business_fee INNER JOIN sites ON sites.id = business_fee.site_id
                INNER JOIN business ON business.site_id = sites.id
                WHERE business_fee.Agreed_Fee IS NOT NULL
                AND  sites.id = '".$site_id."' ".$add_sql."
                GROUP BY business_fee.id
                ORDER BY business_fee.id DESC LIMIT 5"; */

                $sql = "SELECT business_fee.Agreed_Fee, business_fee.Agreed_Fee_Date, business_fee.Fee_Status, sites.sitename, business.title 
                FROM business,business_fee, sites      
                WHERE business_fee.Agreed_Fee IS NOT NULL  
                AND business_fee.Fee_Status = 0 
                AND business.id = business_fee.id  
                AND sites.id = business.site_id 
                AND sites.id = "  .$site_id .
                $add_sql.
                " ORDER BY business_fee.id DESC LIMIT 5";


                $query = $this->db->query($sql);
                if (!empty($query)) {
                    foreach ($query->result_array() as $row) {
                        $over_due_lw[] = $row;
                    }
                }
                $total_rec_lw = (count($total_fee_rec_lw)/count($last_week_fee_detials))*100;
                $total_od_lw = (count($over_due_lw)/count($last_week_fee_detials))*100;
                // JOB FEE DATA AND STATUS

                $json = array(
                'status'=>true,
                'result'=>array(

                'last_week_fee_detials'=>$last_week_fee_detials,

                'fee_rec_lw'=>round($total_rec_lw,0),
                'fee_over_due_lw'=> round($total_od_lw,0)
                )
                );

                break;
    		case 'dashboard_app':
    			$this->session_string = $this->input->post('session_string');
    			$authenticate = $this->check_auth();
    			if ($authenticate) {
    				// Total Work orders
	    			$table_work_orders = $this->db->count_all('work_orders');
	    			// Open Work Orders
	    			$this->db->select('*');
					$this->db->from('work_orders');
					$this->db->where('status', 1);
					$this->db->or_where('status', null); 
					$query = $this->db->get();
					$rowcount = $query->num_rows();
					//Over Due Work Orders
					$this->db->select('*');
	                $this->db->from('work_orders');
	                $this->db->where('priority', 1); 
	                $this->db->where("(status  = 1 OR status IS NULL)");
	                $query = $this->db->get();
	                $odwo = $query->num_rows();
	                //High Priority Work Orders
					$this->db->select('*');
	                $this->db->from('work_orders');
	                $this->db->where('req_completion_date <', date('Y-m-d')); 
	                $this->db->where("(status  = 1 OR status IS NULL)");
	                $query = $this->db->get();
	                $hpwo = $query->num_rows();
    			}
    			
    			$json = array(
		    		'status'=>true,
		    		'result'=>array('total_work_orders'=>$table_work_orders,'open_wo'=>$rowcount,'over_due_wo'=>$odwo, 'high_priority'=>$hpwo)
		    	);
    		break;
    		case 'login':
		    	$this->username 		= $this->input->post('username');
		    	$this->password 		= $this->input->post('password');
		    	$login					= $this->login();
		    	if ($login) {
		    		if ($login['user_status'] === '1') {
		    			$login['message'] = 'Login successful.';
		    			$return[] = $login;

		    			$json = array(
		    				'status'=>true,
		    				'result'=>$return);
		    		} else {		    			
		    			$return[] = array('message'=>$login['user_full_name'].' your account is not active at this time, please wait for activation contact Fort Mart Admin.');
		    			$json = array(
		    			'status'=>false,
		    			'result'=>$return);
		    		}		    		
		    	} else {
		    		$return[] = array('message'=>'Invalid username/password, please register or contact Fort Mart Admin.');
		    		$json = array(
		    			'status'=>false,
		    			'result'=>$return);
		    	}		    		
    			break;
    		
    		case 'list_options':
    			$module_name = $this->input->post('module');
    			$filed_name = $this->input->post('field');
    			$this->db->select('*');
				$this->db->from('crud_components');
				$this->db->where('component_name',strtolower($module_name));

				$module_query = $this->db->get();
				$module = $module_query->row_array();
				$pro_array = array();
				$result = array();
				$return = array();
				if (!empty($module)) {
					if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$module['id']). '/' . $module['component_table'] . '.php')) {
						exit;
					}
					$content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$module['id']) . '/' . $module['component_table'] . '.php'));
					$conf = unserialize($content);
					$form_elements = $conf['elements'];
					
					$formFields = array();
                    foreach ($form_elements as $key => $value) {
                        foreach ($value['section_fields'] as $key => $value) {
                        	$formFields[$key] = $value;
                        }
                    }
			        $arr_values = array();
					foreach ($formFields as $key => $value) {
						$e = $value['element'];	
						  	
						if($e[0] == 'select' || $e[0] == 'autocomplete' || $e[0] == 'related_record'){
							if (array_key_exists('option_table', $e[1])) {
                                	if (array_key_exists('option_key', $e[1]) &&
                                                    array_key_exists('option_value', $e[1])) {
                                		$sql = "SELECT * FROM ".$e[1]['option_table']." ";
                                		$rs = array();
								        $query = $this->db->query($sql);
								        if (!empty($query)) {
								            foreach ($query->result_array() as $row) {
								                $rs[] = $row;
								            }
								        }               
                                        if (!empty($rs)) {
                                        	foreach ($rs as $v) {
                                        		if ($e[1]['option_table'] == 'crud_users') {
                                                	// if crud user
                                                	$arr_values[] = array('id'=>$v[$e[1]['option_key']], 'display_title'=>ucwords($v['user_first_name']) . ' ' . ucwords($v['user_las_name']));
                                                } else if($e[1]['option_table'] == 'contact') {
                                                	$arr_values[] = array('id'=>$v[$e[1]['option_key']], 'display_title'=>ucwords($v['First_Name']) . ' ' . ucwords($v['Last_Name']));
                                                } else {
                                                	$arr_values[] = array('id'=>$v[$e[1]['option_key']], 'display_title'=>$v[$e[1]['option_value']]);
                                                }
                                        	}
                                        	$pro_array = array('filed_name'=>$value['alias'],'values'=>$arr_values); 
                                        	unset($arr_values);
											$result[] = $pro_array;
											unset($pro_array);
                                            
                                        }

                                	}
                            } else {
                            	foreach ($value['element'][1] as $key => $v) {
						    		$arr_values[] = array('id'=>$key,'display_title'=>$v);
							    }
								$pro_array = array('filed_name'=>$value['alias'],'values'=>$arr_values);        		
								unset($arr_values);
								$result[] = $pro_array;
								unset($pro_array);
                            }
						}
					}
					if(!empty($filed_name)){
						foreach ($result as $key => $value) {
							if ($value['filed_name'] == $filed_name) {
								$return[] = $value;
							} 
						}
					} else {
						$return = $result;
					}		
				}
    			$json = array(
    				'status'=>true,
    				'result'=>$return);
    			break;	
    		case 'resetpassword':
    			$username  			= $this->input->post('username'); 
    			$userEmail = $username;//$this->input->post('user_email');
				$var = array();
				if (!empty($userEmail)){
					$sendLink = true;

					$this->db->select('*');
					$this->db->from('crud_settings');
					$this->db->where('setting_key',sha1('general'));
					$query = $this->db->get();
					$setting = $query->row_array();
					$setting = unserialize($setting['setting_value']);
						
					if ((int)$setting['disable_reset_password'] == 1){
						exit;
					}
					
					$this->db->select('*');
					$this->db->from('crud_users');
					$this->db->where('user_email',trim($userEmail));
					$this->db->where('user_status','1');
					$query = $this->db->get();
					$user = $query->row_array();

					if (empty($user)) {
						$sendLink == false;
						$var['status'] = false;
						$var['result'] = 'Email does not exist.';
					}
					if ($sendLink == true){
						$time = time();
						$code = sha1('reset_password'.$user['user_email'].$time).'-'.$time;
						
						$user['user_code'] = $code;
						$this->db->where('id', $user['id']);
						$this->db->update('crud_users', $user);

						$this->db->select('*');
						$this->db->from('crud_settings');
						$this->db->where('setting_key',sha1('reset_password'));
						$query = $this->db->get();
						$resetPasswordEmail = $query->row_array();
						$resetPasswordEmail = unserialize($resetPasswordEmail['setting_value']);

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
							
						$mail->AddAddress($user['user_email']);
						$mail->SetFrom($setting['email_address'], $this->lang->line('please_do_not_reply'));
							
						$mail->Subject = $resetPasswordEmail['request_subject'];
							
						$body = $resetPasswordEmail['request_body'];
							
						$siteAddress = base_url();
						$resetLink = base_url().'index.php/admin/reset_password?code='.$code;
							
						$body = str_replace('{site_address}', $siteAddress, $body);
						$body = str_replace('{user_name}', $user['user_name'], $body);
						$body = str_replace('{user_email}', $user['user_email'], $body);
						$body = str_replace('{reset_link}', $resetLink, $body);
							
						$mail->Body = $body;
						$mail->Send();
					}

					if ($sendLink == true){
						$var['status'] = true;
						$var['result'] = 'Please check your email to reset password.';
					}else{
						$var['status'] = false;
						$var['result'] = 'Temporary error please try again, or contact FortMart Admin.';
					}

					//echo json_encode($var);
				} else {
					$var['status'] = false;
					$var['result'] = 'Plase provide an email address.';
				}	
				$json = array(
		    			'status'=>$var['status'],
		    			'result'=>$var['result']);	
    			break;
    		case 'register':
    			// Regiser Starts
		    	require_once FCPATH . 'application/third_party/scrud/class/recaptchalib.php';
				require_once FCPATH . 'application/third_party/scrud/class/Validation.php';
				
				$settingKey = sha1('general');

				$var = array();
				$errors = array();
				//$var['setting_key'] = $settingKey;

				$this->db->select('*');
				$this->db->from('crud_settings');
				$this->db->where('setting_key',$settingKey);
				$query = $this->db->get();
				$setting = $query->row_array();
				$setting = unserialize($setting['setting_value']);
				
				if ((int)$setting['disable_registration'] == 1){
					
				}
				
				$crudUser =  array();
				$crudUser['name'] 			= $this->input->post('username');
				$crudUser['password'] 		= $this->input->post('password');
				$crudUser['email']			= $this->input->post('username');
				$crudUser['first_name'] 	= $this->input->post('first_name');
				$crudUser['last_name'] 		= $this->input->post('last_name');
				$crudUser['mobile_number'] 	= $this->input->post('mobile_number');

				if (!empty($crudUser)){
				$validate = Validation::singleton();
					if (!$validate->notEmpty($crudUser['name'])){
						$errors[] = sprintf($this->lang->line('please_enter_value'), $this->lang->line('user_name'));
					}else{
						$this->db->select('id');
						$this->db->from('crud_users');
						$this->db->where('user_name',trim($crudUser['name']));
						$query = $this->db->get();
						$user = $query->row_array();
						if (!empty($user)){
							$errors[] = $this->lang->line('account_already_exits');
						}

					}
					if (!$validate->notEmpty($crudUser['password'])){
						$errors[] = sprintf($this->lang->line('please_enter_value'), $this->lang->line('password'));
					}
					if (!$validate->notEmpty($crudUser['email'])){
						$errors[] = sprintf($this->lang->line('please_enter_value'), $this->lang->line('email'));
					}else if (!$validate->email($crudUser['email'])){
						$errors[] = sprintf($this->lang->line('please_provide_valid_email'), $this->lang->line('email'));
					}else{
						$this->db->select('id');
						$this->db->from('crud_users');
						$this->db->where('user_email',trim($crudUser['email']));
						$query = $this->db->get();
						$user = $query->row_array();
						if (!empty($user)){
							$errors[] = $this->lang->line('email_already_exits');
						}
					}
					if (count($errors) == 0){						
						$user = array();						
						$user['user_name'] = $crudUser['name'];
						$user['user_password'] = sha1($crudUser['password']);
						$user['user_email'] = $crudUser['email'];
						$user['user_first_name'] = $crudUser['first_name'];
						$user['user_las_name'] = $crudUser['last_name'];
						$user['mobile_number'] = $crudUser['mobile_number'];
						
						if (isset($setting['require_email_activation']) && (int)$setting['require_email_activation'] == 1){
							$time = time();
							$code = sha1('activate'.$user['user_email'].$time).'-'.$time;
							$user['user_code'] = $code;
							$user['user_status'] = 0;
						}else{
							$user['user_status'] = 1;
						}						
						if (isset($setting['default_group'])){
							$user['group_id'] = 16;
						}else{
							$user['group_id'] = 0;
						}
						$this->db->insert('crud_users', $user);
						$insert_id = $this->db->insert_id();
						if (isset($setting['require_email_activation']) && (int)$setting['require_email_activation'] == 1){
							$this->db->select('*');
							$this->db->from('crud_settings');
							$this->db->where('setting_key',sha1('new_user'));
							$query = $this->db->get();
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
						
							$mail->AddAddress($user['user_email']);
							$mail->SetFrom($setting['email_address'], $this->lang->line('please_do_not_reply'));
						
							$mail->Subject = $newUserEmail['send_link_subject'];
						
							$body = $newUserEmail['send_link_body'];
						
							$siteAddress = base_url();
							$activationLink = base_url().'index.php/admin/activate?code='.$code;
						
							$body = str_replace('{site_address}', $siteAddress, $body);
							$body = str_replace('{user_name}', $user['user_name'], $body);
							$body = str_replace('{user_email}', $user['user_email'], $body);
							$body = str_replace('{activation_link}', $activationLink, $body);
						
							$mail->Body = $body;

							if ($insert_id > 0) {
								$mail->Send();			
								$json = array(
						    		'status'=>true,
						    		'result'=>'Regisgteration successful please wait for activation from FortMart Admin.');
							}
							
						}
					} else {						
						$er_msg = implode(',', $errors);						
						$json = array(
						   'status'=>false,
						    'result'=>'User could not be register because the errors, '.$er_msg);
					}
				}
    			break;
    		case 'query':
    			$this->session_string = $this->input->post('session_string');
    			$query_from_ws = $this->input->post('query');
    			$authenticate = $this->check_auth();
    			if ($authenticate) {
    				$req_module_name = $this->get_table_name($query_from_ws,'from');
					$this->db->select('*');
				    $this->db->from('crud_components');
				    $this->db->where('component_name',$req_module_name);
				    $module_query = $this->db->get();
				    $module = $module_query->row_array();
				    if (!empty($module)) {
				    	if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$module['id']). '/' . $module['component_table'] . '.php')) {
					    	exit;
					    }
					    $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$module['id']) . '/' . $module['component_table'] . '.php'));
					    $conf = unserialize($content);
					    $otherwise = array();
							// Get conidtion set out
					    	$mod_cond = '';
					        $mod_cond = $this->after_where($query_from_ws);
					        $site_dampers = array();
					        $conditions = array();
					        $conditon_string = '';
					        $cormeton_conditon_string = '';
					        $test_node = array();
					        // chek condition is not empty
					        if ($mod_cond != '') {
					        	$ex_cond_val = array();
					            $ex_cond = explode(strtolower('and'), $mod_cond);
					            $cond_array = array();
					            
					            foreach ($ex_cond as $key => $cond_val) {
					            	$ex_cond_val = explode('=', $cond_val);

					            	$conditions[] = $cond_val;
					            	if (trim($ex_cond_val[0]) == 'id') {
					            		$cond_array[] = $cond_val;
					            	} else {
					            		$remove_if_id = str_replace("_id", "", $ex_cond_val[0]);
					            		$module_name = strtolower($module['component_table']) . '_';
					            		$remove_module = str_replace($module_name, "",$remove_if_id);
						            	
						            	
						            	if (!empty($remove_module)) {
						            		$cond_array[] = $remove_module ." = '". str_replace(" ", "", $ex_cond_val[1]) ."' ";
						            	}
						            	
					            	}	
					            	
					            }
					            if (!empty($cond_array)) {
					            	$conditon_string	= implode(" AND ", $cond_array);
					            }
					            
					        }
					      
	 						if ($conditon_string != '') {
	 							$cormeton_conditon_string .= " WHERE ".$conditon_string;
	 						}
	 						$module_result = array();
					        $fquery = "SELECT * FROM "  . $module['component_table'] . $cormeton_conditon_string;
					        $test_node['after_cond'] = $mod_cond;
					        $test_node['fsql'] = $fquery ;
						    $module_data_query = $this->db->query($fquery);
						    if (!empty($module_data_query)) {
						    	foreach ($module_data_query->result_array() as $row) {
						        	$module_result[] = $row;
						        }
						    }
						    $formFields = array();
		                    foreach ($conf['elements'] as $key => $value) {
		                        foreach ($value['section_fields'] as $key => $value) {
		                        	$formFields[$key] = $value;
		                        }
		                    }
						    $db_fields = array();
					        foreach ($formFields as $key => $db_field) {
					        	$ex_key = explode('.', $key);
					            $db_fields[$ex_key[1]] = $ex_key[0]."_".$ex_key[1];
					        }
					        $ret_m_r = array();
					        if(!empty($db_fields)){
					        	foreach ($module_result as $key => $mr) {
	                        		$mod_tmp_arr = array();
	                        		foreach ($mr as $key => $value) {
	                        			if ($value == null) {
                            				$value = '';
                          				}
                          				$field_key = $module['component_table'] . '.' . $key;
                          				if (isset($formFields[$field_key]['element'][0])) {
                            				$element_type = $formFields[$field_key]['element'][0];
                          				} else {
                      						$element_type= '';
                          				}
                          				if (isset($db_fields[$key])) {
				                            $mod_tmp_arr[$db_fields[$key]] = ($value!=null) ? $value : '';;
				                        } else {
				                        	if ($key == 'id') {
					                            $mod_tmp_arr['id'] = ($value!=null) ? $value : '';   
					                        }
					                        if ($key == 'created') {
					                        	$mod_tmp_arr[$module['component_table'].'_created'] = ($value!=null) ? $value : '';
					                        }
				                        }
				                        /// if field types are autocomplte, select
										if ($element_type == 'autocomplete' || $element_type ==  'select' || $element_type ==  'related_record' || $element_type ==  'radio'  || $element_type ==  'checkbox') {
							                if (isset($formFields[$field_key]['element'][1]['option_table'])) {
							                    $db_picklist = $formFields[$field_key]['element'][1];
							                    $modid = '';
							                   
							                      $this->db->select('*');
							                        $this->db->from($db_picklist['option_table']);
							                        $this->db->where($db_picklist['option_key'],$value);
							                        $query = $this->db->get();
							                        $piclist_info = $query->row_array();
							                        $this->db->select('id');
							                        $this->db->from('crud_components');
							                        $this->db->where('component_table',$db_picklist['option_table']);
							                        $mod_info_query = $this->db->get();
							                        $mod_info = $mod_info_query->row_array();


							                        if ($db_picklist['option_table'] == 'crud_users') {
							                        	$value = isset($piclist_info[$db_picklist['option_value']]) ? ucwords($piclist_info['user_first_name']) . ' ' . $piclist_info['user_las_name'] : '';
							                        	$id = $piclist_info['id'];
							                        } else {
							                        	$value = ($piclist_info[$db_picklist['option_value']]!=null) ? $piclist_info[$db_picklist['option_value']] : '';//
							                        	$id = $piclist_info['id'];//($formFields[$field_key]['element'][1][$value]!=null) ? $formFields[$field_key]['element'][1][$value] : '';
							                        }
							                        $mod_tmp_arr[$db_fields[$key]] =  $value;
							                        $mod_tmp_arr[$db_fields[$key].'_id'] = ($id == null) ? '' : $id;
							                    //}
							                } else {
							                    $mod_tmp_arr[$db_fields[$key]] = ($formFields[$field_key]['element'][1][$value]!=null) ? $formFields[$field_key]['element'][1][$value] : '';
							                    $mod_tmp_arr[$db_fields[$key].'_id'] = ($value == null) ? '' : $value;
							                }        
							            }
	                        		}// loop for module results ends here
						        	$ret_m_r[]  = $mod_tmp_arr;
					        	}
					        }
					
						$return = array('error'=>'query result','query'=>$formFields['elements']);
				    	$json = array(
				    	'status'=>true,
				    	'result'=>$ret_m_r,
				    	'test_node'=>$test_node );
				    } else {
				    	$return[] = array('error'=> 'Invalid module name','module_name'=>$req_module_name);
						$json = array(
						'status'=>true,
						'result'=>($return));
				    } // if module is not empty ends here
					
				} else {
					
				}
			
    			break;
    		case 'post':
    			$data = $this->input->post('data_arr');
    			$module_name = $this->input->post('module');
    			$return_filed = $this->input->post('return_filed');
    			$this->db->select('*');
				$this->db->from('crud_components');
				$this->db->where('component_name',strtolower($module_name));
				$module_query = $this->db->get();
				$module = $module_query->row_array();
				$return_data_field = '';
				$mod= array();					
				
				$mod = json_decode($data);
				$a = array();
				$return = array();
				$count_insrted = array();
				$pro_array = array();
				$k = array();
				// If module is not empty
				if (!empty($module)) {
					if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$module['id']). '/' . $module['component_table'] . '.php')) {
						exit;
					}
					$content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$module['id']) . '/' . $module['component_table'] . '.php'));
					$conf = unserialize($content);
					$form_elements = $conf['elements'];
					$formFields = array();
		            foreach ($conf['elements'] as $key => $value) {
		                foreach ($value['section_fields'] as $key => $value) {
		                    $formFields[$key] = $value;
		                }
		            }
					foreach ($formFields as $key => $value) {
						$x = explode('.', $key);
						$filed_should = strtolower($module['component_table'])."_".$x[1];
						if(!empty($return_filed)){
							if ($return_filed == $value['alias']) {
								
								$return_data_field = $x[1];
							}
						}
						$e = $value['element'];
						if (!empty($e) && isset($e[0])) {
                        	switch (strtolower(trim($e[0]))) {
                        		case 'select':
                        		case 'autocomplete':
			                        if (isset($e[1]) && !empty($e[1])) {
			                           	if (array_key_exists('option_table', $e[1])) {
			                            	if (array_key_exists('option_key', $e[1]) &&
			                                	array_key_exists('option_value', $e[1])) {
			                            		if ($x[1] == 'assigned_to' || $x[1] == 'crud_users' || $e[1]['option_table'] == 'crud_users') {
			                            			$pro_array[$key] 	= $filed_should;
			                            		} else {
			                            			$pro_array[$key] 	= $filed_should . '_id';
			                            		}	
			                            	}
			                        	} else{
											$pro_array[$key] = $filed_should;
			                        	}
			                        }

                        		break;
                        		case 'datetime':
                        		case 'date':
                        			$pro_array[$key]['type'] = 'datetime';
									$pro_array[$key]['select'] = $filed_should;
                        		break;
                        		case 'image':
                        			$pro_array[$key]['type'] = 'image';
									$pro_array[$key]['select'] = $filed_should;
                        		break;
                        		default:
                        			$pro_array[$key] = $filed_should;
                        		break;
                            }
                        }
                    }// End of foreach for assigning form elements to values
					for ($i=0; $i < count($mod) ; $i++) { 
						$thisID = "";
						$thisID = $mod[$i]->{'id'};
						$newRecord = true;
						if ($thisID != "") {
							$a['id'] = $thisID;
							$newRecord = false;
						} else {
							$c = array(
								'module_id'=>	$module['id'],
							);
							$this->db->insert('module_entity_ids',$c);
							$crmid = $this->db->insert_id();
							$a['id'] = $crmid;
						}
						
						foreach ($pro_array as $key => $value) {
							if(is_array($value)){
								if($value['type'] == 'datetime'){
									$rec_val = isset($mod[$i]->{$value['select']}) ? $mod[$i]->{$value['select']} : '';
									$tirmed_val = explode('/', $rec_val);
									$a[$key] = $tirmed_val[2] . '-' . $tirmed_val[1] . '-' . $tirmed_val[0];
								} else if($value['type'] == 'image'){ //addslashes
									$rec_val = isset($mod[$i]->{$value['select']}) ? $mod[$i]->{$value['select']} : '';
						       					
						       			$a[$key] = $rec_val;
								}
							} else {
								
								if (isset($mod[$i]->{$value})) { 

								    $a[$key] = $mod[$i]->{$value};
								}
							}

						}
							if ($newRecord) {
								$this->db->select('*');
								$this->db->from('module_entity_num');
								$this->db->where('module_id',$module['id']);
								$query = $this->db->get();
								$mod_num = $query->row_array();
								$num = (int) $mod_num['curr_id'];


								$newRecordNumber =  ++$num;
								$newRecordNo = $mod_num['prefix'] . $newRecordNumber;
								$noField = $module['component_table'] . 'no';

								$a[$noField] = $newRecordNo;
								// Update module numbering
								$data = array('curr_id' => $newRecordNumber);

								$this->db->where('id', $mod_num['id']);
								$this->db->update('module_entity_num', $data);

								
								$this->db->insert($module['component_table'], $a); 
				                $inserted_id = $this->db->insert_id();
								$this->db->select('*');
								$this->db->from($module['component_table']);
								$this->db->where('id',$inserted_id);
								$ret_mod = $this->db->get();
								$return_data = $ret_mod->row_array();        				
				                $count_insrted[] = array($module['component_table']."_barcode"=>$a[$module['component_table'].'.barcode'],"id"=>$crmid);
				                unset($a);
							} else {
								$this->db->where('id',$a['id']);
								$this->db->update($module['component_table'], $a); 
								$this->db->select('*');
								$this->db->from($module['component_table']);
								$this->db->where('id',$a['id']);
								$ret_mod = $this->db->get();
								$return_data = $ret_mod->row_array();        				
				                $count_insrted[] = array($module['component_table']."_barcode"=>$a[$module['component_table'].'.barcode'],"id"=>$a['id']);
				                unset($a);
							}
							
							
						
					} // for loop ends
					$return = array(
		            	'recieved_records'=>count($mod),
		            	'saved_records'=>count($count_insrted),
		            	'saved_ids'=>$count_insrted,
		            	'test'=>$test);
				} // end of if module not empty
				$json = array(
					'status'=>true,
					'result'=>$return);	
    			break;	
			case 'open_services':
				$site_id = $this->input->post('site_id');
				$this_user_id = $this->input->post('this_user_id');
				$dashboard = $this->input->post('dashboard');
				
				$query = $this->db->get_where('business',array('user_id'=>$this_user_id));
				if($query->num_rows()>0){
					$business_id = $query->row()->id;
					$query_business = $this->db->get_where('service_sub',array('business_id'=>$business_id))->result_array();
				} else {
					$query_business = 'No Services';
				}
				$json = array(
						'status'=>true,
						'result'=>$query_business
					);
				break;
    		case 'open_Dates':
				$site_id = $this->input->post('site_id');
				$this_user_id = $this->input->post('this_user_id');
				$dashboard = $this->input->post('dashboard');
				
				$query = $this->db->get_where('business',array('user_id'=>$this_user_id));
				if($query->num_rows()>0){
					$business = $query->row();
				} else {
					$business = 'No Business';
				}
				$json = array(
						'status'=>true,
						'result'=>$business
					);
				break;
    		case 'open_Tax':
                $site_id = $this->input->post('site_id');
                $this_user_id = $this->input->post('this_user_id');
                $dashboard = $this->input->post('dashboard');

                $query = $this->db->get_where('business',array('user_id'=>$this_user_id));
                if($query->num_rows()>0){
                    $business_id = $query->row()->id;
                    $query_business = $this->db->get_where('service_sub',array('business_id'=>$business_id,'service_id'=>4))->row();
                } else {
                    $query_business = 'No Tax';
                }
                $json = array(
                        'status'=>true,
                        'result'=>$query_business
                        );
                break;
            default:
    			$return = array('error'=>'Invalid operation type');
		    	$json = array(
		    		'status'=>true,
		    		'result'=>$return);
    			break;
    	}
		$var['json'] 			= json_encode($json);
    	$var['main_content'] 	= $this->load->view('ws/webservices', $var, true);
    	$this->load->view('layouts/ws/webservices', $var);
    }
    public function get_string_between($string, $start, $end){
	    $string = " ".$string;
	    $ini = strpos($string,$start);
	    if ($ini == 0) return "";
	    $ini += strlen($start);
	    $len = strpos($string,$end,$ini) - $ini;
	    return substr($string,$ini,$len);
	}
	public function get_table_name($string, $match){
		list($a, $b) = explode(' from ', $string);
		list($c,$d) = explode(' where ', $b);
		return $c;
	}
	public function after_where($string){
		$string = strtolower($string);
		$arr = explode('where', $string);
		$important = $arr[1];
		return $important;
	}
	public function get_field_temp(){

	}

    
}

