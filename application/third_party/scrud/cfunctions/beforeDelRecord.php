<?php

    function beforeDelRecord($tbl_name){
    	
        $CI = & get_instance();
        $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
        global $date_format_convert;
        $this_user_id = $CRUD_AUTH['id'];

        switch ($tbl_name) {
            /*case 'business':
                //$CI->db->query("DELETE FROM jobs WHERE business=".$_GET['key']['business.id']);
                $CI->db->query("DELETE FROM jobs WHERE business=".$_GET['key']['business.id']);
                $CI->db->select('title,user_id,folder_id');
                $CI->db->from('business');
                $CI->db->where('id',$_GET['key']['business.id']);
                $query_b_name = $CI->db->get();
                $b_name_data = $query_b_name->row_array();
                $business_name = $b_name_data['title'];
                ////////nauman/////
                $business_doc = $b_name_data['folder_id'];
                //////nauman/////

                $CI->db->select('id');
                $CI->db->from('doc_folders');
                $CI->db->where('folder_name',$business_name);
                $query = $CI->db->get();
                $parent_folder = $query->row_array();
                $parent_folder_id = $parent_folder['id'];
                if($parent_folder_id)
                    $CI->db->query("DELETE FROM doc_folders WHERE id=".$parent_folder_id);
                    //$this->delete_business_folders_and_files($parent_folder_id);
                $CI->db->query("DELETE FROM crud_users WHERE id=".$b_name_data['user_id']);

                ////////nauman //////
                
                 if(isset($business_doc) && $business_doc!="" && $business_doc!=0){
                    $CI->db->delete('doc_folders',array('id'=> $business_doc));
                }

                //////nauman////////

                break;*/
            case 'business':
                 $busi_id = $_GET['key']['business.id'];
                
                
                $CI->db->select('title,user_id,folder_id,eventsfor');
                $CI->db->from('business');
                $CI->db->where('id',$busi_id);
                $query_b_name = $CI->db->get();
                $b_name_data = $query_b_name->row_array();
                $business_name = $b_name_data['title'];

                $CI->db->select('id,eventsfor');
                $CI->db->from('jobs');
                $CI->db->where('business',$_GET['key']['business.id']);
                $query_j_name = $CI->db->get();
                $j_name_data = $query_j_name->result_array();
                if($query_j_name->num_rows()>0)
                {
                    foreach($j_name_data as $s_job){
                       
                        if(isset($s_job['eventsfor'])&&$s_job['eventsfor']!=""){
                            $eventsfor_arr=explode(",",$s_job['eventsfor']);
                            foreach($eventsfor_arr as $single_event){
                                $temp_arr = explode("|",$single_event);
                                
                                if(isset($temp_arr[1])&& $temp_arr[1]!=""){
                                    $CI->db->select('subject');
                                    $CI->db->from('calendar');
                                    $CI->db->where('id',$temp_arr[1]);
                                    $qqq=$CI->db->get();
                                    $ppp = $qqq->result_array();
                                    if(isset($ppp[0]['subject']) && $ppp[0]['subject']!="")
                                    $CI->db->query("DELETE FROM calendar WHERE subject = '". $ppp[0]['subject']."'");
                                    
                                }
                            }
                        }


                    }

                } 
                
                if(isset($b_name_data['eventsfor'])&&$b_name_data['eventsfor']!=""){
                    //echo " its working in business". $b_name_data['eventsfor'];
                     $eventsfor_arr=explode(",",$b_name_data['eventsfor']);
                    foreach($eventsfor_arr as $single_event){
                        $temp_arr = explode("|",$single_event);
                        //echo "<br/> Its from business ".$temp_arr[1]. " ";
                        if(isset($temp_arr[1])&& $temp_arr[1]!=""){
                            $CI->db->select('subject');
                            $CI->db->from('calendar');
                            $CI->db->where('id',$temp_arr[1]);
                            $qqq=$CI->db->get();
                            $ppp = $qqq->result_array();
                            if(isset($ppp[0]['subject']) && $ppp[0]['subject']!=""){
                                $CI->db->query("DELETE FROM calendar WHERE subject = '". $ppp[0]['subject']. "'");
                            }
                        }
                    }
                }
                
                $CI->db->query("DELETE FROM jobs WHERE business=".$_GET['key']['business.id']);
                ///////deleting calendar code end///////////

                ////////nauman/////
                $business_doc = $b_name_data['folder_id'];
                //////nauman/////

                $CI->db->select('id');
                $CI->db->from('doc_folders');
                $CI->db->where('folder_name',$business_name);
                $query = $CI->db->get();
                $parent_folder = $query->row_array();
                $parent_folder_id = $parent_folder['id'];
                if($parent_folder_id)
                    $CI->db->query("DELETE FROM doc_folders WHERE id=".$parent_folder_id);
                    //$this->delete_business_folders_and_files($parent_folder_id);
                $CI->db->query("DELETE FROM crud_users WHERE id=".$b_name_data['user_id']);

                ////////nauman //////
                
                 if(isset($business_doc) && $business_doc!="" && $business_doc!=0){
                    $CI->db->delete('doc_folders',array('id'=> $business_doc));
                }



                //////nauman////////

                break;
            case 'doc_folders':
                //$CI->db->query("DELETE FROM crm_documents WHERE folder_name=".$_GET['key']['doc_folders.id']);
                $id = $_GET['key']['doc_folders.id'];
                /////////nauman///////////
                $CI->db->where('folder_id',$id);
                $CI->db->update('business' , array('folder_id'=>0));
                $CI->db->flush_cache();
                $CI->db->where('Folder',$id);
                $CI->db->update('crud_users',array('Folder'=>0));
                ///////////nauman//////////
                $Cfunction = new Cfunctions;
                $Cfunction->delete_folder_and_files($id);
                break;
            case 'crud_users':
                $id = $_GET['key']['crud_users.id'];
                /////nauman/////
                $CI->db->where('user_id',$id);
                $CI->db->update('business',array('user_id'=>0));
                /////nauman//////
                $CI->db->query("DELETE FROM calendar_types WHERE assigned_to=".$id);
                break;
            default:
                break;
        }
       
       
    }

?>