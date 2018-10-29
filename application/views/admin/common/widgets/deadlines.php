<?php 
$CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); 
global $date_format_convert;
$this_user_id = $CRUD_AUTH['id'];


$postdata = http_build_query(
array(
        'operation' => 'deadlines',
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
                                        <i class="icon-bar-chart font-red"></i>
                                        <span class="caption-subject font-red bold uppercase">Deadlines</span>
                                       
                                    </div>
                                    <div class="actions">
                                          <a  class="btn  green btn-circle btn-sm" href="<?php echo base_url(); ?>admin/scrud/browse?com_id=76">View More</a>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: <?php echo $r->result->progress_of_week; ?>px;" class="progress-bar progress-bar-success green-sharp">
                                            <span class="sr-only"><?php echo $r->result->progress_of_week; ?> progress</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title pull-left"> Progress </div>
                                        <div class="status-number pull-right"> <?php echo round($r->result->progress_of_week,0); ?>% </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th> JOB </th>
                                                    <th> Assigned to </th>
                                                    <th> Site </th>
                                                    <th> Status </th>
                                                    <th> Deadlines </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($r->result->job_list as $key => $value) {
                                            ?>
                                            <tr>
                                                <td>
                                                <?php echo $value->title; ?>
                                                </td>
                                                <td>
                                                <?php echo $value->username; ?>
                                                </td>
                                                <td>
                                                <?php echo $value->sitename; ?>
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
                                                <td> 
                                                <?php
                                                if (is_date($value->expected_start_date)){
                                                    echo date($date_format_convert[__DATE_FORMAT__],strtotime($value->expected_start_date));
                                                    }else{
                                                        echo '';
                                                    }
                                                   
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

  