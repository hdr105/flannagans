<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once FCPATH . 'application/third_party/scrud/class/Hook.php';
require_once FCPATH . 'application/third_party/scrud/class/ScrudDao.php';
require_once FCPATH . 'application/third_party/scrud/class/functions.php';

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->config->load('scrud');
        $this->load->helper('url');
        $this->load->database();

        if($this->session->userdata('TIME_ZONE'))
            date_default_timezone_set($this->session->userdata('TIME_ZONE'));
        
        $_lang = $this->session->userdata('lang');
        $_c_lang = $this->input->cookie('lang', true);

        if (!isset($_GET['lang']) && isset($_POST['lang'])){
        	$_GET['lang'] = $_POST['lang'];
        }
        if(isset($_GET['lang'])){
        	$language = $_GET['lang'];
        		
        	// register the session and set the cookie
        	$this->session->set_userdata('lang', $language);
        	
        	setcookie("lang", $language, time() + (3600 * 24 * 30),'/',false);
        		
        }else if(!empty($_lang)){
        	$language = $_lang;
        }else if(!empty($_c_lang)){
        	$language = $_c_lang;
        }else{
        	if (file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/v_1.0.txt')) {

	        	$this->db->select('*');
	        	$this->db->from('crud_settings');
	        	$this->db->where('setting_key',sha1('general'));
                
	        	$query = $this->db->get();
	        	$setting = $query->row_array();

	        	$setting = unserialize($setting['setting_value']);
	        	
	        	if (!empty($setting['default_language']) && trim($setting['default_language']) != ''){
	        		$language = $setting['default_language'];
	        	}else{
	        		$language = 'default';
	        	}
        	}else{
        		$language = 'default';
        	}
        }
        
        $this->lang->load('message', $language);
    }

}

class Admin_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->authenticate();

        $hook = Hook::singleton();

        $hook->set('SCRUD_INIT');
        $hook->set('SCRUD_BEFORE_VALIDATE');
        $hook->set('SCRUD_VALIDATE');
        $hook->set('SCRUD_ADD_FORM');
        $hook->set('SCRUD_EDIT_FORM');
        $hook->set('SCRUD_VIEW_FORM');
        $hook->set('SCRUD_ADD_CONFIRM');
        $hook->set('SCRUD_EDIT_CONFIRM');
        $hook->set('SCRUD_BEFORE_SAVE');
        $hook->set('SCRUD_BEFORE_INSERT');
        $hook->set('SCRUD_BEFORE_UPDATE');
        $hook->set('SCRUD_COMPLETE_INSERT');
        $hook->set('SCRUD_COMPLETE_UPDATE');
        $hook->set('SCRUD_COMPLETE_SAVE');
        $hook->set('SCRUD_CONFRIM_DELETE_FORM');
        $hook->set('SCRUD_COMPLETE_DELETE');
    }

    private function authenticate() {
        if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/v_1.0.txt')) {
            redirect('install/index');
        } else {
            $auth = $this->session->userdata('CRUD_AUTH');
            if (empty($auth) && $this->uri->uri_string() != 'admin/login') {
                redirect('/admin/login');
            }
        }
    }

}

/*
    Web service login method
    1- session id
    2- session string
    3- session expire timestamp
    4- session started timestamp
    5- logged_in user_id

    first hour session:
    cea4c6d980e041d773603cb19a01a357971dacc6


*/
class Ws_Controller extends MY_Controller{
    
    public static $is_loggedin  = array();
    protected $session_string   = '';
    protected $username         = '';
    protected $password         = '';
 
    public function __construct() {
        parent::__construct();
        $this->authenticate();

        $hook = Hook::singleton();

        $hook->set('SCRUD_INIT');
        $hook->set('SCRUD_BEFORE_VALIDATE');
        $hook->set('SCRUD_VALIDATE');
        $hook->set('SCRUD_ADD_FORM');
        $hook->set('SCRUD_EDIT_FORM');
        $hook->set('SCRUD_VIEW_FORM');
        $hook->set('SCRUD_ADD_CONFIRM');
        $hook->set('SCRUD_EDIT_CONFIRM');
        $hook->set('SCRUD_BEFORE_SAVE');
        $hook->set('SCRUD_BEFORE_INSERT');
        $hook->set('SCRUD_BEFORE_UPDATE');
        $hook->set('SCRUD_COMPLETE_INSERT');
        $hook->set('SCRUD_COMPLETE_UPDATE');
        $hook->set('SCRUD_COMPLETE_SAVE');
        $hook->set('SCRUD_CONFRIM_DELETE_FORM');
        $hook->set('SCRUD_COMPLETE_DELETE');
    }
    private function authenticate() {
        $this->db->select('*');
        $this->db->from('ws_session');
        $this->db->where('session_string',$this->session_string);
        $query = $this->db->get();
        $session_info = $query->row_array();
        return $session_info;
                   
    }
    protected function check_auth(){
        $is_loggedin =  $this->authenticate();
        if (!empty($is_loggedin)) {
                        $d1 = new DateTime($is_loggedin['session_started']);
                        $d2 = new DateTime($is_loggedin['session_ends']);

                        if ($d2 > $d1) {
                            return true;
                        } else {
                            return false;
                        }
        } else {
            return false;
        }

    }
    protected function login(){
        $username = $this->username;
        $password = $this->password;
        $return = false;
        $this->db->select('*');
        $this->db->from('crud_users');
        $this->db->where('user_name', $username);
        $this->db->where('user_password', sha1($password));
        
        $query = $this->db->get();
        $user_info = $query->row_array();
        
        if (!empty($user_info)) {
            $data = array(
                    'session_string'=>sha1($user_info['id'].strtotime('now')),
                    'session_started'=>date('Y-m-d H:i:s'),
                    'session_ends'=>date('Y-m-d H:i:s',strtotime('now +1 hour')),
                    'session_user_id'=>$user_info['id']
                );
            $this->db->insert('ws_session', $data);
            $insert_id = $this->db->insert_id(); 

            $this->db->select('*');
            $this->db->from('ws_session');
            $this->db->where('session_id',$insert_id);
            $query = $this->db->get();
            $session_info = $query->row_array();

            $user_full_name = ucwords($user_info['user_first_name']) . ' ' . ucwords($user_info['user_las_name']);
            if ($user_info['group_id'] == 1) {
                $user_level = 'admin';
            } else {
                $user_level = 'user';
            }
            if ($user_info['user_status'] == 1) {
                $return = array(
                    'session_string'=>$session_info['session_string'], 
                    'user_id'=>$user_info['id'],
                    'user_level'=>$user_level,
                    'user_status'=>$user_info['user_status'],
                    'user_full_name'=>$user_full_name

                    );
            } else {
                $return = array(
                    'session_string'=>$session_info['session_string'], 
                    'user_id'=>$user_info['id'],
                    'user_level'=>$user_level,
                    'user_status'=>$user_info['user_status'],
                    'user_full_name'=>$user_full_name

                    );
            }
            
            //$return = $insert_id;
        } else {
            $return = false;
        }

        return $return;
    }


}