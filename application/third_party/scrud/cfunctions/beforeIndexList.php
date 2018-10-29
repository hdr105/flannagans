<?php
    function beforeIndexList($data = array()){
            $CI = & get_instance();
            $CRUD_AUTH = $CI->session->userdata('CRUD_AUTH'); 
            global $date_format_convert;
            $this_user_id = $CRUD_AUTH['id'];

            $conditions = '';
            switch ($data['comId']) {
                case '41':
                case '42':
                case '43':
                case '44':
                case '45':
                    $CI->session->set_userdata('comid',$_GET['com_id']);
                    if($_GET['com_id']==41)
                        $CI->session->set_userdata('com_name','Sole Trader');
                    elseif($_GET['com_id']==42)
                        $CI->session->set_userdata('com_name','Partnership');
                    elseif($_GET['com_id']==43)
                        $CI->session->set_userdata('com_name','Limited Company');
                    elseif($_GET['com_id']==44)
                        $CI->session->set_userdata('com_name','Limited Liabilities Company');
                    elseif($_GET['com_id']==45)
                        $CI->session->set_userdata('com_name','Charities');
                    break;
                default:
                    # code...
                    break;
            }
            return false;
    }
?>