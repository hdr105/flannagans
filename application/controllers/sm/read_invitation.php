<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Read_invitation extends SM_Controller {
	public function __construct(){
		parent::__construct();
	
	}
	public function index() {
		$var = array();
		$var['view'] = 'read';


		$var['read'] 	= $this->input->get('read');
		$var['id']  	= $this->input->get('id');


		if (!empty($var['id'])) {

			
			


			$this->db->select('*');
			$this->db->from('sendmails');
			$this->db->where('id',$var['id']);
			$mail_row = $this->db->get();
			$mail_data = $mail_row->row_array();

           


			$this->db->select('*');
			$this->db->from('calendar');
			$this->db->where('id',$mail_data['record_id']);
			$calendar = $this->db->get();
			$calendar_data = $calendar->row_array();

			$var['calendar_data'] = $calendar_data;

		}
		


		$var['main_content'] = $this->load->view('sm/sendmail',$var,true);
		$this->load->view('layouts/sm/sendmail', $var);
	}
	
}