<?php 
$CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); 
global $date_format_convert;
$this_user_id = $CRUD_AUTH['id'];


$postdata = http_build_query(
array(
        'operation' => 'staff_on_break',
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
                                        <span class="caption-subject font-green bold  uppercase">Staff Currently on Break</span>
                                    </div>
                                    <!--<div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">View Detail</label>
                                        </div>
                                    </div>-->
                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th> Staff </th>
                                                    <th> Job</th>
                                                    <th> On Break </th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                        <?php
                                        foreach ($r->result as $key => $value) {
                                        ?>
                                            <tr>
                                                <td>
                                                <?php echo $value->username; ?>
                                                </td>
                                                <td>
                                                   <?php echo ucwords($value->status); ?>
                                                </td>
                                                <td> <?php
                                                    $date1 = new DateTime(date('H:i:s'));
                                                    $date2 = new DateTime($value->time_start);
                                                    $diff = $date1->diff($date2);
                                                    echo $diff->h .' H '. $diff->i . ' M';
                                                ?> </td>
                                                
                                               
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                            
                                          
                                          
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>

  