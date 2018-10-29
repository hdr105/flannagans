<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Accept_invitation extends Admin_Controller {

    public function index() {
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');
        $var = array();

        $CRUD_AUTH = $this->session->userdata('CRUD_AUTH');


        $this_user = $CRUD_AUTH['id'];
        
       
            $mycalendars_ids = array();
        
       
            $sql = "SELECT * FROM calendar_types WHERE assigned_to = " . $this_user;
            $query = $this->db->query($sql);
            if (!empty($query)) {
                foreach ($query->result_array() as $row) {
                    $mycalendars_ids[] = $row['id'];
                }
            }
       

        $invitations = array();
        ////SELECT * FROM calendar WHERE find_in_set('".$fusr."',invite_calendars) <> 0

        foreach ($mycalendars_ids as $value) {
             $isql = "SELECT calendar.id, calendar.subject, calendar.date_start, calendar.due_date, calendar.time_start, calendar.time_end, calendar.eventstatus, calendar.visibility, calendar.location AS location, crud_users.id AS  'user_id', CONCAT( crud_users.user_first_name,  ' ', crud_users.user_las_name ) AS  'user_full_name' FROM calendar INNER JOIN crud_users ON calendar.created_by = crud_users.id WHERE FIND_IN_SET( '{$value}', invite_calendars ) <>0 AND calendar.created_by <> {$this_user}";

            $query = $this->db->query($isql);
            if (!empty($query)) {
                foreach ($query->result_array() as $row) {


                    $this->db->select('*');
                    $this->db->from('calendar_types');
                    $this->db->where('id',$value);
                    $calendar = $this->db->get();
                    $ctype = $calendar->row_array();



                        $conditions = array(
                            'eventstatus'=>$ctype['id'],
                            'date_start'=>$row['date_start'],
                            'time_start'=>$row['time_start']
                        );
                    $this->db->select('*');
                    $this->db->from('calendar');
                    $this->db->where($conditions);
                    $avail = $this->db->get();
                    $availc = $avail->row_array();
                    $avail = false;
                    if(!empty($availc)){
                        $avail = false;
                    } else {
                        $avail = true;
                    }
           

                    $invitations[] =array(
                            'calendar'=>$ctype,
                            'cdata'=>$row,
                            
                            'available'=>$avail
                        ) ;
                    
                }
            }
        }

       
        /// end of invited events

        
        $var['invitations'] = $invitations;

        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/mycalendar/accept_invitation',$var,true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->view('layouts/admin/mycalendar', $var);
    }
    public function reject_inv(){
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');
                $var = array();
         $CRUD_AUTH = $this->session->userdata('CRUD_AUTH');


        $this_user = $CRUD_AUTH['id'];

        $cid = $this->input->post('cid');
        $ctid = $this->input->post('ctid');

         $this->db->select('*');
        $this->db->from('calendar');
        $this->db->where('id',$cid);
        $calendar = $this->db->get();
        $cdata = $calendar->row_array();

        $inids = explode(',', $cdata['invite_calendars']);

        $icids = array();
        foreach ($inids as $value) {
            if (trim($value) != $ctid) {
                 $icids[] = $value;
            }
        }

        
        

        $ucdata['invite_calendars'] = implode(',', $icids);
        $this->db->where('id', $cdata['id']);
        $this->db->update('calendar', $ucdata); 
    }
    public function accept_inv(){
         $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');
                $var = array();
         $CRUD_AUTH = $this->session->userdata('CRUD_AUTH');


        $this_user = $CRUD_AUTH['id'];

        $cid = $this->input->post('cid');
        $ctid = $this->input->post('ctid');



        $this->db->select('*');
        $this->db->from('calendar');
        $this->db->where('id',$cid);
        $calendar = $this->db->get();
        $cdata = $calendar->row_array();


        $this->db->select('*');
        $this->db->from('module_num');
        $this->db->where('module_name','calendar');
        $cnumd = $this->db->get();
        $cnum = $cnumd->row_array();


        $ncalendar = $cdata;
        $ncalendar['id'] = null;
        $ncalendar['calendarno'] = $cnum['prefix'] . ($cnum['curr_id']+1);
        $ncalendar['eventstatus'] = $ctid;
        $ncalendar['assigned_to'] = $this_user;
        $ncalendar['created_by'] = $this_user;
        $ncalendar['modified_by'] = $this_user;
        $ncalendar['created'] = date('Y-m-d H:i:s');
        $ncalendar['modified'] = date('Y-m-d H:i:s');
        $ncalendar['invite_calendars'] = '';
        $ncalendar['parentid'] = $cid;

        $this->db->insert('calendar', $ncalendar);

        $inids = explode(',', $cdata['invite_calendars']);

        $icids = array();
        foreach ($inids as $value) {
            if (trim($value) != $ctid) {
                 $icids[] = $value;
            }
        }

        
        

        $ucdata['invite_calendars'] = implode(',', $icids);
        $this->db->where('id', $cdata['id']);
        $this->db->update('calendar', $ucdata); 

        $ncnum['curr_id'] = $cnum['curr_id']+1;
        $this->db->where('num_id', $cnum['num_id']);
        $this->db->update('module_num', $ncnum);

        $arrayName = array($icids, $ctid,$inids);
        echo json_encode($arrayName);

    }

    
}