<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sendmail extends Ws_Controller {
	public function __construct(){
		parent::__construct();
	
	}
	public function index() {
		$var = array();
		
		require_once FCPATH . 'application/third_party/scrud/class/PHPMailer/class.phpmailer.php';

		


			$mails_to_send = array();
			$sql = "SELECT * FROM sendmails WHERE status = 0"; 

             $query = $this->db->query($sql);
            if (!empty($query)) {
                foreach ($query->result_array() as $row) {
                   
                    $mails_to_send[] = $row;
                }
            }

            $var['arr'] = $mails_to_send;

           if (!empty($mails_to_send)) {
            	foreach ($mails_to_send as $value) {
            		switch ($value['mail_type']) {
            			case 'calendar_invite':
	            				 $this->db->select('*');
								$this->db->from('calendar');
								$this->db->where('id',$value['record_id']);
								$calendar = $this->db->get();
								$calendar_data = $calendar->row_array();
								

								$mail             = new PHPMailer();
								$mail->AddReplyTo("developer1.php@senserve.com","CRM User");

								$mail->SetFrom('developer1.php@senserve.com', 'CRM User');

								$mail->AddReplyTo("developer1.php@senserve.com","CRM User");

								$ex_inv_types = explode(',', $calendar_data['invite_calendars']);
								$cal_ids = array();
								foreach ($ex_inv_types as $ck => $cv) {
									if (!empty($cv)) {
										$sql = "SELECT calendar_types.name AS 'calendar_name', crud_users.user_email FROM calendar_types INNER JOIN crud_users ON calendar_types.assigned_to = crud_users.id WHERE calendar_types.id =  {$cv} ";
										$query = $this->db->query($sql);
							            if (!empty($query)) {
							                foreach ($query->result_array() as $row) {
							                   
							                    $mail->AddAddress($row['user_email'], $row['calendar_name']);
							                }
							            }
									}
								}
								
								$body = "You have an invitation to join an event<br><br>";
								$body .= "Click following link to view your invitations<br><br>";
								$body .=	"<a href='".base_url()."index.php/admin/accept_invitation'>".base_url()."index.php/admin/accept_invitation</a>";
								$mail->Subject    = "Event invitation";

								

								$mail->MsgHTML($body);

								

								if(!$mail->Send()) {
								  	$var['message'] 	=  "Mailer Error: " . $mail->ErrorInfo;
								} else {
								   	$var['message'] 	= "Message sent!";
								}


						            				
						    break;
            			
            			default:
            				
            				break;
            		}

            		$data = array(
					               'status' => '1',
					               
					            );

					$this->db->where('id', $value['id']);
					$this->db->update('sendmails', $data); 
            	}
            }


		
    



		$var['main_content'] = $this->load->view('sm/sendmail',$var,true);
		$this->load->view('layouts/sm/sendmail', $var);
	}

	
}