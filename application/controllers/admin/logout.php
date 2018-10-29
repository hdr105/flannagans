<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logout extends Admin_Controller {

    public function index() {
//////////working hours logged////////////////////////////////////////    
        $CI = & get_instance();
        $CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
		$userid = $CRUD_AUTH['id'];
		$sql="SELECT id,dated,time_start FROM users_work_log WHERE user_id=".$userid." AND dated = '".date("Y-m-d")."' ORDER BY time_start Desc LIMIT 1";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
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
        $this->db->query("UPDATE users_work_log SET time_end = '".$time."', time_spent='$diff' WHERE id = $id");

//////////////////////////////////////////////////////////////////////
        $this->session->unset_userdata('CRUD_AUTH');
        redirect('/admin/login');
    }

}