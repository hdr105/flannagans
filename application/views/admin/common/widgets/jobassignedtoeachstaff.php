<?php 
$CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); 
global $date_format_convert;
$this_user_id = $CRUD_AUTH['id'];


$postdata = http_build_query(
array(
        'operation' => 'assigned_jobs_to_staff',
        'this_user_id'=>$this_user_id,
        'auth_token' =>$auth,
        'site_id'=>$CRUD_AUTH['site_id'],
        'dashboard'=>$CRUD_AUTH['group']['dashboard'],
    )
);
$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);
$context  = stream_context_create($opts);
$result = file_get_contents(base_url().'index.php/webservices/', false, $context);
$r = json_decode($result);



?>
<div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">Assigned Job to Each Staff </span>
                                    </div>
                                    <div class="actions">
                                       
                                            
                                                <a  href="<?php echo base_url(); ?>admin/scrud/browse?com_id=76" class="btn  green  btn-circle btn-sm " >View More</a>
                                        
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th> Staff </th>
                                                    <th> Job </th>
                                                    <th> Deadline </th>
                                                    <th> Manager </th>
                                                    <th> Status </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($r->result as $key => $value) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    $this->db->select('user_first_name,user_las_name','line_manager');
                                                    $this->db->from('crud_users');
                                                    $this->db->where('id',$value->assigned_to);
                                                    $query = $this->db->get();
                                                    $user = $query->row_array();
                                                    $uf = ucwords($user['user_first_name']).' '.ucwords($user['user_las_name']);
                                                    echo $uf;

                                                    ?>
                                                </td>
                                                <td>
                                                <?php echo $value->title; ?>
                                                </td>
                                                <td> 
                                                <?php
                                                if (is_date($value->expected_end_date)){
                                                    echo date($date_format_convert[__DATE_FORMAT__],strtotime($value->expected_end_date));
                                                    }else{
                                                        echo '';
                                                    }
                                                    //echo $value->expected_end_date;
                                                ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $this->db->select('user_first_name,user_las_name');
                                                    $this->db->from('crud_users');
                                                    $this->db->where('id',$user['line_manager']);
                                                    $query = $this->db->get();
                                                    $lm = $query->row_array();
                                                    $lmuf = ucwords($lm['user_first_name']).' '.ucwords($lm['user_las_name']);
                                                    echo $lmuf;
                                                    ?>
                                                </td>
                                               
                                                <td> 
                                                    <?php
                                                    $job_status = array(
                                                        '1'=>'Open',
                                                        '2'=>'Close',
                                                        '3'=>'In Progress',
                                                        '4'=> 'On Hold',
                                                    );
                                                    echo $job_status[$value->job_status];
                                                    ?>
                                                 </td>
                                                
                                               
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                          
                                          
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>

  