<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends Admin_Controller {
	// Call Index Page START
    public function index() {
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');
        $CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
        $user_id = $CRUD_AUTH['id'];
        
        $query = $this->db->get_where('crud_users',array('id'=>$user_id))->row_array();
        
		$var['profile_data'] = $query;
        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/common/profile',$var,true);
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();
        $this->load->template('layouts/admin/profile', $var);
    }
	// Call Index Page START    
    
	public function pass_check() {
		$CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
		if(sha1($_GET['old_pass']) == $CRUD_AUTH['user_password']){
			echo 'true';
		} else {
			echo 'false';
		}
	}
	
	public function saveprofile() {
		$CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
		$user_first_name	=	$_POST['user_first_name'];
		$user_las_name		=	$_POST['user_las_name'];
		$user_email			=	$_POST['user_email'];
		if(isset($_POST['user_name']) && !empty($_POST['user_name'])){
			$user_name			=	$_POST['user_name'];
		}
		if(isset($_FILES['profile_image'])){
			$target_dir = "media/files/profile_images/";
			$target_file = $target_dir . basename(time().'-'.$_FILES["profile_image"]["name"]);
			if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
				$data = array(
					'user_first_name'	=> $user_first_name,
					'user_las_name' 	=> $user_las_name,
					'user_email'	 	=> $user_email,
					'profile_image' 	=> basename(time().'-'.$_FILES["profile_image"]["name"])
				);
				if(isset($user_name)){
					$data['user_name'] = $user_name;
				}
				$this->db->where('id', $CRUD_AUTH['id']);
				$this->db->update('crud_users', $data); 
				
				$CRUD_AUTH['user_first_name']	= $user_first_name;
				$CRUD_AUTH['user_las_name'] 	= $user_las_name;
				$CRUD_AUTH['user_email']		= $user_email;
				$CRUD_AUTH['profile_image'] 	= basename(time().'-'.$_FILES["profile_image"]["name"]);
				$this->session->set_userdata('CRUD_AUTH', $CRUD_AUTH);

			} else{
				$data = array(
					'user_first_name'	=> $user_first_name,
					'user_las_name' 	=> $user_las_name,
					'user_email'	 	=> $user_email,
				);
				if(isset($user_name)){
					$data['user_name'] = $user_name;
				}
				$this->db->where('id', $CRUD_AUTH['id']);
				$this->db->update('crud_users', $data); 
				
				$CRUD_AUTH['user_first_name']	= $user_first_name;
				$CRUD_AUTH['user_las_name'] 	= $user_las_name;
				$CRUD_AUTH['user_email']		= $user_email;
				$this->session->set_userdata('CRUD_AUTH', $CRUD_AUTH);
			}
		}
		$this->session->set_flashdata('msg', 'Profile updated successfully');
		redirect(base_url().'admin/profile','refresh');
	}
	
	public function savepassword() {
		$CRUD_AUTH	=	$this->session->userdata('CRUD_AUTH');
		$new_pass	=	sha1($_POST['new_pass']);
		
		$data = array( 'user_password' => $new_pass );
		$this->db->where('id', $CRUD_AUTH['id']);
		$this->db->update('crud_users', $data); 
		
		$this->db->select('*');
		$this->db->from('crud_users');
		$this->db->where('id', $CRUD_AUTH['id']);
		$query = $this->db->get();
		$user = $query->row_array();
			
		$this->db->select('*');
		$this->db->from('crud_settings');
		$this->db->where('setting_key',sha1('general'));
		$query = $this->db->get();
		$setting = $query->row_array();
		$setting = unserialize($setting['setting_value']);

		$this->db->select('*');
		$this->db->from('crud_settings');
		$this->db->where('setting_key',sha1('reset_password'));
		$query = $this->db->get();
		$resetPasswordEmail = $query->row_array();
		$resetPasswordEmail = unserialize($resetPasswordEmail['setting_value']);

		require_once FCPATH . 'application/third_party/scrud/class/PHPMailer/class.phpmailer.php';
		$mail = new PHPMailer();
		$mail->Encoding="base64";

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

		$mail->Subject = $resetPasswordEmail['success_subject'];

		$body = $resetPasswordEmail['success_body'];

		$siteAddress = base_url();

		$body = str_replace('{site_address}', $siteAddress, $body);
		$body = str_replace('{user_name}', $user['user_name'], $body);
		$body = str_replace('{user_email}', $user['user_email'], $body);

		$mail->Body = $body;
		$mail->Send();
		$this->session->set_userdata('reset_password_complete', 1);
		$resetFlag = true;

		$CRUD_AUTH['user_password'] = $new_pass;
		$this->session->set_userdata('CRUD_AUTH', $CRUD_AUTH);
		$this->session->set_flashdata('msg', 'Password changed successfully');
		redirect(base_url().'admin/profile?password','refresh');
	}
	
	public function deleteimage() {
		$CRUD_AUTH	=	$this->session->userdata('CRUD_AUTH');
		$data = array( 'profile_image' 	=> '' );
		$this->db->where('id', $CRUD_AUTH['id']);
		$this->db->update('crud_users', $data); 
		$CRUD_AUTH['profile_image'] 	= '';
		$this->session->set_userdata('CRUD_AUTH', $CRUD_AUTH);
		redirect(base_url().'admin/profile','refresh');
	}
	
	public function work_history() {
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');
        $CRUD_AUTH = $this->session->userdata('CRUD_AUTH');
		$group_id = $CRUD_AUTH['group']['id'];
		$com_id = $_GET['com_id'];
        $user_id = $CRUD_AUTH['id'];
        $site_id = $CRUD_AUTH['site_id'];
        
        $query = $this->db->get_where('crud_permissions',array('com_id'=>$com_id ,'group_id'=>$group_id ,'permission_type'=>'5'));
		if($query->num_rows()>0){
			$permission = 1;
		} else {
			$permission = 0;
			show_404();
			exit;
		}
		
		$users = $this->db->query('SELECT * FROM crud_users WHERE group_id!="1" AND group_id!="5" AND user_status="1" AND site_id="'.$site_id.'"');
		if($users->num_rows()>0){
			$var['users'] = $users->result_array();
		} else {
			$var['users'] = '';
		}
		
		$var['permissions'] = $permission;
		$var['CRUD_AUTH']	= $this->session->userdata('CRUD_AUTH');

		$var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/common/work_log',$var,true);
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();
        $this->load->template('layouts/admin/profile', $var);
    }
}