<?php

class Admin_common extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function login() {
        $return = false;

        $sysUser = $this->config->item('sysUser');
        $crudUser = $this->input->post('crudUser', true);
        if (!empty($crudUser) && isset($crudUser['name']) && isset($crudUser['password'])) {
            if ($sysUser['enable'] == true) {
                if ($crudUser['name'] == $sysUser['name'] &&
                        $crudUser['password'] == $sysUser['password']) {
                    $auth = array();
                    $auth['user_name'] = $sysUser['name'];
                    
                    $group = array('group_name' => 'SystemAdmin',
                    		'group_manage_flag' => 3,
                    		'group_setting_management' => 1,
                    		'group_global_access' => 1
                    );
                    
                    $auth['group'] = $group;
                    $auth['__system_admin__'] = 1;

                    $this->session->set_userdata('CRUD_AUTH', $auth);
                    $return = true;
                }
            }
            $this->db->select('id,group_id,user_name,user_password,user_email,user_first_name,user_las_name,user_info,user_code,user_status,user_manage_flag,user_setting_management,user_global_access,site_id,profile_image,user_status');
            $this->db->from('crud_users');
            $this->db->where('user_name', $crudUser['name']);
            $this->db->where('user_password', sha1($crudUser['password']));

            $query = $this->db->get();
            $rs = $query->row_array();

            if (!empty($rs)) {
                if($rs['user_status']==1){
                    $this->db->select('*');
                    $this->db->from('crud_groups');
                    $this->db->where('id', $rs['group_id']);

                    $query = $this->db->get();
                    $rs1 = $query->row_array();

                    if (!empty($rs1)) {
                        $rs['group'] = $rs1;
                    } else {
                        $rs['group'] = array('group_name' => 'None',
    							'group_manage_flag' => 0,
    							'group_setting_management' => 0,
    							'group_global_access' => 0
    					);
                    }
                    //unset($rs['group']['id']);
                    if($rs['group_id']==0 or is_null($rs['group_id']))
                        $rs['group_id']=1;
                    /*unset($rs['user_password']);
                    unset($rs['user_info']);*/
                    $rs['__system_admin__'] = 0;
                    $this->session->set_userdata('CRUD_AUTH', $rs);

                    $this->db->select('timezone');
                    $this->db->from('sites');
                    $this->db->where('id',$rs['site_id']);
                    $query = $this->db->get();
                    $zone = $query->row_array();
                    if (!empty($zone)){
                        $this->session->set_userdata('TIME_ZONE',$zone['timezone']);
                        date_default_timezone_set($this->session->userdata('TIME_ZONE'));
                    }

    //////////working hours logged////////////////////////////////////////    
                    $dated=date("Y-m-d");
                    $time_start=date("H:i:s");
                    //check for previous open session of today
                    $sql = 'SELECT id,time_start,dated FROM users_work_log WHERE `site_id`="'.$rs['site_id'].'" AND `dated`="'.$dated.'" AND `time_end`="00:00:00" ORDER BY id DESC LIMIT 1';
                    $query = $this->db->query($sql);
                    if($results = $query->result_array()){
                        $result = $results[0];
                        $time1  =   strtotime($result['dated']." ".$result['time_start']);
                        $time2  =   strtotime(date("Y-m-d ".$time_start));
                        $diff   =   abs($time2 - $time1);
                        $this->db->query("UPDATE users_work_log SET time_end='".$time_start."', time_spent='".$diff."' WHERE id = ".$result['id']);
                    }

                    //Insert new session value 
                    $this->db->query("INSERT INTO users_work_log (user_id,dated,time_start,status,site_id) VALUES(".$rs['id'].",'".$dated."','".$time_start."','working',".$rs['site_id'].")");
    //////////////////////////////////////////////////////////////////////
                    $return = 0;
                    require_once FCPATH . 'application/third_party/scrud/class/Cookie.php';
                    if (isset($_POST['remember_me']) && (int)$_POST['remember_me'] == 1){
                    	Cookie::Set('CRUD_AUTH', serialize(array(base64_encode($crudUser['name']), base64_encode(sha1($crudUser['password'])))),Cookie::SevenDays);
                    }else{
                    	Cookie::Delete('CRUD_AUTH');
                    }
                }else{
                    $return = 3;
                }
            }else{
                $return = 2;
            }
        }else{
            $return = 1;
        }

        return $return;
    }

}