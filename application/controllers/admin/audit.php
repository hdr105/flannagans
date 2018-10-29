<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Audit extends Admin_Controller {
	// Call Index Page START
    public function index() {
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');
        $CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
        $user_id = $CRUD_AUTH['id'];
        $site_id = $CRUD_AUTH['site_id'];
        
        $query = $this->db->order_by("id", "desc")->get_where('crud_histories',array('site_id'=>$site_id))->result_array();
        
		$var['history_data'] = $query;
        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/common/audit',$var,true);
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();
        $this->load->template('layouts/admin/profile', $var);
    }
	// Call Index Page START    
}