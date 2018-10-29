<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pdfs extends Admin_Controller {

    public function index() {
        $CI = & get_instance();
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');

        $rid = $this->input->get('id');
        $bid = $this->input->get('bid');
        $cid = $this->input->get('com_id');

        $data = array();


        if(!isset($cid)){
           $comId = 0;
        }else{
           $comId = $cid;
        }
        
        $this->db->select('*');
        $this->db->from('crud_components');
        $this->db->where('id',$comId);
        $query = $this->db->get();
        $com = $query->row_array();
        
        $_GET['table'] = $com['component_table'];
        
        if (!file_exists(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database . '/' .sha1('com_'.$comId). '/' . $com['component_table'] . '.php')) {
            exit;
        }
        
        $content = str_replace("<?php exit; ?>\n", "", file_get_contents(__DATABASE_CONFIG_PATH__ . '/' . $this->db->database. '/' .sha1('com_'.$comId) . '/' . $com['component_table'] . '.php'));
        
        $conf = unserialize($content);
//echo "<pre>";print_r($conf);echo "</pre>";exit;

        $this->db->select('*');
        $this->db->from('legal_letters_data');
        $this->db->where('id',$rid);
        $query = $this->db->get();
        $data = $query->row_array();
        if($data['Dear'])
            $data['Dear']=$conf['form_elements'][0]['section_fields']['legal_letters_data.Dear']['element'][1][$data['Dear']];
        

        $this->db->select('title,user_email,user_id');
        $this->db->from('business');
        $this->db->where('id',$bid);
        $query = $this->db->get();
        $rs = $query->row_array();

        $this->db->select('user_email,user_first_name,user_las_name');
        $this->db->from('crud_users');
        $this->db->where('id',$rs['user_id']);
        $query=$CI->db->get();
        $result=$query->row_array();

        //load the view and saved it into $html variable
        $html=$this->load->view('admin/pdfs/legal_letter_business', $data, true);
 
        //this the the PDF filename that user will get to download
        $pdfFilePath = str_replace(' ','_',$rs['title'])."_".str_replace(' ','_',$data['Letter_Title'])."_".date('dmY').".pdf";
 
        //load mPDF library
        $this->load->library('m_pdf');
        header('Content-Type: application/pdf');
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        if($this->input->get('action')=="view"){
            $this->m_pdf->pdf->Output($pdfFilePath, "I");
        }
        //Noman code starts
        elseif($this->input->get('action')=="email"){
            // echo "something";
            // exit;
            $emailAttachment =  $this->m_pdf->pdf->Output($pdfFilePath, "S");;
            $flg1=0;
            if(isset($rs['user_email'])&&$rs['user_email']!=""){
                $flg=1;
                $emailAddressForPdf=$rs['user_email'];
            }else if(isset($rs['user_id'])&&$rs['user_id']!=0){

                if(isset($result['user_email']) && $result['user_email']!=''){
                    $emailAddressForPdf=$result['user_email'];
                    $flg=1;
                }
            }

            try{

                /*if (!isset($emailAddressForPdf) && $emailAddressForPdf=='') {
                    throw new Exception("The Email Address is undefined."); 
                }*/
                require_once FCPATH . 'application/third_party/scrud/class/PHPMailer/class.phpmailer.php';
                $mail = new PHPMailer(true);
                //////////////////////////
                $settingKey = sha1('general');

                $var = array();
                $errors = array();
                $var['setting_key'] = $settingKey;

                $CI->db->select('*');
                $CI->db->from('crud_settings');
                $CI->db->where('setting_key',$settingKey);
                $query = $CI->db->get();
                $setting = $query->row_array();
                $setting = unserialize($setting['setting_value']);
                
                if ((int)$setting['disable_registration'] == 1){
                    exit;
                }
                if (isset($setting['require_email_activation']) && (int)$setting['require_email_activation'] == 1){
                            $CI->db->select('*');
                            $CI->db->from('crud_settings');
                            $CI->db->where('setting_key',sha1('new_user'));
                            $query = $CI->db->get();
                            $newUserEmail = $query->row_array();
                            $newUserEmail = unserialize($newUserEmail['setting_value']);
                
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
                    //echo $user['user_email'];
                    $mail->AddAddress($emailAddressForPdf);
                    //$mail->AddAddress('smak.group@gmail.com');
                    $mail->SetFrom($setting['email_address'], $CI->lang->line('company_name'));
                
                    $mail->Subject = 'Legal Letter from Flannagans Accountants';
                    $mail->AddStringAttachment($emailAttachment, $filename = $pdfFilePath,
                      $encoding = 'base64',
                      $type = 'application/pdf');
                    
                    $body=' ';
                    //$mail->Body = $body;
                    $mail->Body = $body;
                    //$mail->MsgHTML("*** File attached! Please see the attached File(.pdf).");
                    $mail->Send();
                    //echo "<div style='margin-left:4%;'>Message Sent OK</div>\n";
                    //mail($emailAddressForPdf,'Legal Letter',$body,"from:".$setting['email_address']);
                    $arr=array();
                    $arr['response']='Mail Sent';
                    $arr['message']=$rs['title'].' has been sent on '.$emailAddressForPdf;
                    echo json_encode($arr);

                }

            } catch (phpmailerException $e) {
                echo $e->errorMessage(); //Pretty error messages from PHPMailer
            } catch (Exception $e) {
                echo $e->getMessage(); //Boring error messages from anything else!
            }

                
        }/// Noman Code Ends
        else{
            $this->m_pdf->pdf->Output($pdfFilePath, "D");            
        }
        
       
    }

}