<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends Admin_Controller {

    public function index() {
        $this->load->model('admin/admin_common');

        $var = array();
        $var['error'] = $this->admin_common->login();
        if ($var['error']==0) {
            redirect('/admin/dashboard');
        } else {
        	$settingKey = sha1('general');
        	
        	$this->db->select('*');
        	$this->db->from('crud_settings');
        	$this->db->where('setting_key',$settingKey);
        	$query = $this->db->get();
        	$setting = $query->row_array();
        	$var['setting'] = unserialize($setting['setting_value']);

//to add logo on login page (coming from company info module)
            $comId = 1;
            $this->db->select('*');
            $this->db->from('company_info');
            $this->db->where('id',$comId);
            $query = $this->db->get();
            $var['com'] = $query->row_array();
/////////////////////////////////////////////////

        	
        	$this->db->select('*');
        	$this->db->from('crud_languages');
        	$query = $this->db->get();
        	$var['languages'] = $query->result_array();
        	
            $var['main_content'] = $this->load->view('admin/common/login', $var, true);
            $this->load->view('layouts/admin/login', $var);
        }
    }

}