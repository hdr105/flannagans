<?php 
$CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); 
global $date_format_convert;
$this_user_id = $CRUD_AUTH['id'];
if($CRUD_AUTH['group']['dashboard']==1){

$postdata = http_build_query(
array(
        'operation' => 'admin_dashboard',
        'this_user_id'=>$this_user_id,
        'auth_token' =>$auth
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

            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN THEME PANEL -->
                 
                    <!-- END THEME PANEL -->
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="<?php echo base_url(); ?>">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Dashboard</span>
                            </li>
                        </ul>
                        <div class="pull-right setingicon" style="padding-top:15px;">
                            <a href="#"><i class="icon-settings fa-2x"></i></a>
                        </div>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"> Dashboard 
                        <small>dashboard & statistics</small>
                    </h3>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                    <!-- <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat blue">
                                <div class="visual">
                                    <i class="fa fa-comments"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="1349">1349</span>
                                    </div>
                                    <div class="desc"> New Feedbacks </div>
                                </div>
                                <a class="more" href="javascript:;"> View more
                                    <i class="m-icon-swapright m-icon-white"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat red">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="12,5">12,5</span>M$ </div>
                                    <div class="desc"> Total Profit </div>
                                </div>
                                <a class="more" href="javascript:;"> View more
                                    <i class="m-icon-swapright m-icon-white"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat green">
                                <div class="visual">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="549">549</span>
                                    </div>
                                    <div class="desc"> New Orders </div>
                                </div>
                                <a class="more" href="javascript:;"> View more
                                    <i class="m-icon-swapright m-icon-white"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat purple">
                                <div class="visual">
                                    <i class="fa fa-globe"></i>
                                </div>
                                <div class="details">
                                    <div class="number"> +
                                        <span data-counter="counterup" data-value="89">89</span>% </div>
                                    <div class="desc"> Brand Popularity </div>
                                </div>
                                <a class="more" href="javascript:;"> View more
                                    <i class="m-icon-swapright m-icon-white"></i>
                                </a>
                            </div>
                        </div>
                    </div> -->
                   <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-red"></i>
                                        <span class="caption-subject font-red bold uppercase">Open Jobs</span>
                                        
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">Today</label>
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm">
                                                <input type="radio" name="options" class="toggle" id="option2">Week</label>
                                          
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                
                                <script type="text/javascript">
                                    var week_count_all = [];
                                                    <?php
                                                        foreach ($r->result->week_count_all as $ck => $c) {
                                                            ?>
                                                            var val = '<?php echo $c->count; ?>';
                                                           
                                                            week_count_all.push(val);
                                                           
                                                            <?php
                                                        }
                                                    ?>
                                </script>
                                    <div class="row number-stats margin-bottom-30">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="stat-left">
                                                <div class="stat-chart">
                                                    <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                    <div id="open_jobs_all"><canvas width="113" height="55" style="display: inline-block; width: 113px; height: 55px; vertical-align: top;"></canvas></div>
                                                    <script type="text/javascript">
                                                        $("#open_jobs_all").sparkline(week_count_all, {
                                                            type: 'bar',
                                                            width: '100',
                                                            barWidth: 5,
                                                            height: '55',
                                                            barColor: '#35aa47',
                                                            negBarColor: '#e02222'
                                                        });
                                                    </script>
                                                </div>
                                                <div class="stat-number">
                                                    <div class="title"> Total </div>
                                                    <div class="number"> <?php echo count($r->result->open_jobs); ?> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="stat-right">
                                                <div class="stat-chart">
                                                    <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                    <div id="open_jobs_new"><canvas width="107" height="55" style="display: inline-block; width: 107px; height: 55px; vertical-align: top;"></canvas></div>
                                                </div>
                                                <script type="text/javascript">
                                                    

                                                    $("#open_jobs_new").sparkline(week_count_all, {
                                                        type: 'bar',
                                                        width: '100',
                                                        barWidth: 5,
                                                        height: '55',
                                                        barColor: '#ffb848',
                                                        negBarColor: '#e02222'
                                                    });
                                                </script>
                                                <div class="stat-number">
                                                    <div class="title"> New </div>
                                                    <div class="number"> <?php echo count($r->result->open_jobs); ?> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th colspan="4"> JOB </th>
                                                    <th> STATUS </th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                             <?php
                                                foreach ($r->result->open_jobs as $key => $value) {
                                                    
                                                    ?>
                                                    <tr class="uppercase">
                                                        <td colspan="4"> <?php echo $value->title; ?> </td>
                                                        <td>  <span class="bold theme-font"><?php echo $value->job_status; ?></span> </td>
                                                      
                                                    </tr>
                                                    <?php
                                                }
                                            ?>
                                            
                                         
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                          
                          <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-red"></i>
                                        <span class="caption-subject font-red bold uppercase">Deadlines</span>
                                       
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">Today</label>
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm">
                                                <input type="radio" name="options" class="toggle" id="option2">Week</label>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: <?php echo $r->result->progress_of_last_week; ?>;" class="progress-bar progress-bar-success green-sharp">
                                            <span class="sr-only"><?php echo $r->result->progress_of_last_week; ?> progress</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title pull-left"> progress </div>
                                        <div class="status-number pull-right"> <?php echo $r->result->progress_of_last_week; ?> </div>
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
                                            foreach ($r->result->job_progress_list as $key => $value) {
                                            ?>
                                            <tr>
                                                <td>
                                                <?php echo $value->title; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $this->db->select('user_first_name,user_las_name');
                                                    $this->db->from('crud_users');
                                                    $this->db->where('id',$value->assigned_to);
                                                    $query = $this->db->get();
                                                    $user = $query->row_array();
                                                    $uf = ucwords($user['user_first_name']).' '.ucwords($user['user_las_name']);
                                                    echo $uf;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $this->db->select('sitename');
                                                    $this->db->from('sites');
                                                    $this->db->where('id',$value->site_id);
                                                    $query = $this->db->get();
                                                    $site = $query->row_array();
                                                    
                                                    echo $site['sitename'];
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
                                               
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                          
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-md-6 col-sm-6">
                         <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-red"></i>
                                        <span class="caption-subject font-red bold uppercase">Staff Holidays Requests </span>
                                       
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">View Detail</label>
                                           
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th> Name </th>
                                                    <th> Job </th>
                                                    <th> Duration </th>
                                                    <th> Request </th>
                                                
                                                </tr>
                                            </thead>
                                            <tbody><tr>
                                                <td>
                                                John Petter
                                                </td>
                                                <td>
                                                    Accounts Handling
                                                </td>
                                               <td> 09/03/2016 </td>
                                                <td><div class="mt-action-buttons ">
                                                                <div class="btn-group btn-group-circle">
                                                                    <button type="button" class="btn btn-outline green btn-sm">Appove</button>
                                                                    <button type="button" class="btn btn-outline red btn-sm">Reject</button>
                                                                </div>
                                                            </div> </td>
                                                
                                               
                                            </tr>
                                          
                                          
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>
                         </div>
                         <div class="col-md-6 col-sm-6">
                         <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-cursor font-purple"></i>
                                        <span class="caption-subject font-purple bold uppercase">Due Client Fee</span>
                                    </div>
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm btn-circle green easy-pie-chart-reload">
                                             View Detail </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="easy-pie-chart">
                                                <div class="number transactions" data-percent="<?php echo $r->result->fee_over_due_lw?> ">
                                                    <span>+<?php echo $r->result->fee_over_due_lw?></span>% <canvas height="75" width="75"></canvas></div>
                                                <a class="title" href="javascript:;"> Over Due
                                                    <i class="icon-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="margin-bottom-10 visible-sm"> </div>
                                        <div class="col-md-6">
                                            <div class="easy-pie-chart">
                                                <div class="number visits" data-percent="<?php echo $r->result->fee_rec_lw?>">
                                                    <span>+<?php echo $r->result->fee_rec_lw?></span>% <canvas height="75" width="75"></canvas></div>
                                                <a class="title" href="javascript:;"> Received
                                                    <i class="icon-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                      
                                       <div class="col-md-12">
                                        <div class="portlet-body">
                                    
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th> Client </th>
                                                    <th> FEE </th>
                                                    <th> Due Date </th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($r->result->last_week_fee_detials as $key => $value) {

                                            
                                            ?>
                                            <tr>
                                                <td>
                                                <?php echo $value->title; ?>
                                                </td>
                                                <td>
                                                   £ <?php echo $value->Agreed_Fee;  ?>
                                                </td>
                                                
                                                <td> 
                                                <?php    
                                                if (is_date($value->Agreed_Fee_Date)){
                                                    echo date($date_format_convert[__DATE_FORMAT__],strtotime($value->Agreed_Fee_Date));
                                                    }else{
                                                        echo '';
                                                    }
                                                    //echo $value->expected_end_date;
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
                                    </div>
                                </div>
                            </div>
                         </div>
                    </div>
                  <div class="row">
                         <div class="col-md-6 col-sm-6">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-green"></i>
                                        <span class="caption-subject font-green bold  uppercase">Staff Currently on Break</span>
                                       
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">View Detail</label>
                                          
                                            
                                        </div>
                                    </div>
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
                                            <tbody><tr>
                                                <td>
                                                Walton Hames
                                                </td>
                                                <td>
                                                   Data Analyst
                                                </td>
                                                <td> 10 Minutes </td>
                                                
                                               
                                            </tr>
                                          
                                          
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>
                         </div>
                          <div class="col-md-6 col-sm-6">
                          <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">Assigned Job to Each Staff </span>
                                       
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">View Detail</label>
                                           
                                            
                                        </div>
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
                                            foreach ($r->result->job_progress_list as $key => $value) {
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
                          </div>
                  </div>
                    <div class="row">
                        <div class="col-xs-12">
                              <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-red"></i>
                                        <span class="caption-subject font-red bold uppercase">Staff working Hours</span>
                                       
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">View Detail</label>
                                           
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th> Staff </th>
                                                    <th> Status </th>
                                                    <th> 20 March,16 </th>
                                                    <th> 22 March,16 </th>
                                                    <th> 23 March,16 </th>
                                                    <th> 24 March,16 </th>
                                                    <th> 25 March,16 </th>
                                                    <th> 26 March,16 </th>
                                                    <th> 27 March,16 </th>
                                                </tr>
                                            </thead>
                                            <tbody><tr>
                                                <td>
                                                Services JOb
                                                </td> <td>
                                                Services JOb
                                                </td>
                                                 <td>
                                                Services JOb
                                                </td>
                                                 <td>
                                                Services JOb
                                                </td>
                                                 <td>
                                                Services JOb
                                                </td>
                                                
                                                <td>
                                                    Kate Penny
                                                </td>
                                                <td> North East </td>
                                                <td> Closed </td>
                                                <td> 09/03/2016 </td>
                                               
                                            </tr>
                                          
                                          
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                  
                   
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->

<?php
}elseif($CRUD_AUTH['group']['dashboard']==2){
?>

            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN THEME PANEL -->
                    <div class="theme-panel hidden-xs hidden-sm">
                        <div class="toggler"> </div>
                        <div class="toggler-close"> </div>
                        <div class="theme-options">
                            <div class="theme-option theme-colors clearfix">
                                <span> THEME COLOR </span>
                                <ul>
                                    <li class="color-default current tooltips" data-style="default" data-container="body" data-original-title="Default"> </li>
                                    <li class="color-darkblue tooltips" data-style="darkblue" data-container="body" data-original-title="Dark Blue"> </li>
                                    <li class="color-blue tooltips" data-style="blue" data-container="body" data-original-title="Blue"> </li>
                                    <li class="color-grey tooltips" data-style="grey" data-container="body" data-original-title="Grey"> </li>
                                    <li class="color-light tooltips" data-style="light" data-container="body" data-original-title="Light"> </li>
                                    <li class="color-light2 tooltips" data-style="light2" data-container="body" data-html="true" data-original-title="Light 2"> </li>
                                </ul>
                            </div>
                            <div class="theme-option">
                                <span> Theme Style </span>
                                <select class="layout-style-option form-control input-sm">
                                    <option value="square" selected="selected">Square corners</option>
                                    <option value="rounded">Rounded corners</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Layout </span>
                                <select class="layout-option form-control input-sm">
                                    <option value="fluid" selected="selected">Fluid</option>
                                    <option value="boxed">Boxed</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Header </span>
                                <select class="page-header-option form-control input-sm">
                                    <option value="fixed" selected="selected">Fixed</option>
                                    <option value="default">Default</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Top Menu Dropdown</span>
                                <select class="page-header-top-dropdown-style-option form-control input-sm">
                                    <option value="light" selected="selected">Light</option>
                                    <option value="dark">Dark</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Sidebar Mode</span>
                                <select class="sidebar-option form-control input-sm">
                                    <option value="fixed">Fixed</option>
                                    <option value="default" selected="selected">Default</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Sidebar Menu </span>
                                <select class="sidebar-menu-option form-control input-sm">
                                    <option value="accordion" selected="selected">Accordion</option>
                                    <option value="hover">Hover</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Sidebar Style </span>
                                <select class="sidebar-style-option form-control input-sm">
                                    <option value="default" selected="selected">Default</option>
                                    <option value="light">Light</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Sidebar Position </span>
                                <select class="sidebar-pos-option form-control input-sm">
                                    <option value="left" selected="selected">Left</option>
                                    <option value="right">Right</option>
                                </select>
                            </div>
                            <div class="theme-option">
                                <span> Footer </span>
                                <select class="page-footer-option form-control input-sm">
                                    <option value="fixed">Fixed</option>
                                    <option value="default" selected="selected">Default</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- END THEME PANEL -->
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="index.html">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Dashboard</span>
                            </li>
                        </ul>
                       <div class="pull-right setingicon" style="padding-top:15px;">
                            <a href="#"><i class="icon-settings fa-2x"></i></a>
                        </div>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"> Dashboard 
                        <small>dashboard & statistics</small>
                    </h3>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                           
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            
                        </div>
                    </div>
                   <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-red"></i>
                                        <span class="caption-subject font-red bold uppercase">Legel Letters And Other Document</span>
                                        
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">Today</label>
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm">
                                                <input type="radio" name="options" class="toggle" id="option2">Week</label>
                                          
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                   
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th colspan="4"> Name </th>
                                                    <th> Folder Name </th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                              
                                                    
                                               
                                                <td colspan="4"> Legel Letter </td>
                                               
                                                <td>
                                                    Letters
                                                </td>
                                            </tr>
                                           <tr>
                                              
                                                    
                                               
                                                <td colspan="4">Contract </td>
                                               
                                                <td>
                                                   Contract  Data
                                                </td>
                                            </tr>
                                         
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                      
                                        <span class="caption-subject font-orange bold uppercase">Payment Dues</span>
                                    </div>
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm btn-circle green easy-pie-chart-reload">
                                             View Detail </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                       
                                        
                                        <div class="margin-bottom-10 visible-sm"> </div>
                                        <div class="col-md-12">
                                        <div class="row">
                                            <div class="easy-pie-chart">
                                                <div class="number visits" data-percent="85">
                                                    <span>+85</span>% <canvas height="75" width="75"></canvas><canvas height="75" width="75"></canvas></div>
                                                <a class="title" href="javascript:;"> Dues
                                                    <i class="icon-arrow-right"></i>
                                                </a>
                                            </div>
                                            <div class="portlet-body">
                                   
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th colspan="4"> Title </th>
                                                    <th> Due Date </th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                              
                                                    
                                               
                                                <td colspan="4"> Vat Services</td>
                                               
                                                <td>
                                                    22/03/2016                                                </td>
                                            </tr>
                                           <tr>
                                              
                                                    
                                               
                                                <td colspan="4">Payroll </td>
                                               
                                                <td>
                                                  22/03/2016 
                                                </td>
                                            </tr>
                                         
                                        </tbody></table>
                                    </div>
                                </div>
                                </div>
                                        </div>
                                      
                                       
                                    </div>
                                </div>
                            </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        
                                        <span class="caption-subject font-red bold uppercase">Taxation Dues</span>
                                    </div>
                                    <div class="actions">
                                        <a href="javascript:;" class="btn btn-sm btn-circle green easy-pie-chart-reload">
                                             View Detail </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                       
                                        
                                        <div class="margin-bottom-10 visible-sm"> </div>
                                        <div class="col-md-12">
                                        <div class="row">
                                            <div class="easy-pie-chart">
                                                <div class="number bounce" data-percent="46">
                                                    <span>-46</span>% <canvas height="75" width="75"></canvas></div>
                                                <a class="title" href="javascript:;"> Dues
                                                    <i class="icon-arrow-right"></i>
                                                </a>
                                            </div>
                                            <div class="portlet-body">
                                   
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th colspan="4"> Title </th>
                                                    <th> Due Date </th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                              
                                                    
                                               
                                                <td colspan="4"> Services Tax</td>
                                               
                                                <td>22/03/2016</td>
                                            </tr>
                                          
                                         
                                        </tbody></table>
                                    </div>
                                </div>
                                </div>
                                        </div>
                                      
                                       
                                    </div>
                                </div>
                            </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                          
                        
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-red"></i>
                                        <span class="caption-subject font-red bold uppercase">My Engagement  Letters </span>
                                        
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">Today</label>
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm">
                                                <input type="radio" name="options" class="toggle" id="option2">Week</label>
                                          
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                   
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th colspan="4"> Name </th>
                                                    <th> Folder Name </th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                              
                                                    
                                               
                                                <td colspan="4"> Basic Letter </td>
                                               
                                                <td>
                                                    Letters
                                                </td>
                                            </tr>
                                           <tr>
                                              
                                                    
                                               
                                                <td colspan="4">Contract </td>
                                               
                                                <td>
                                                   Contract  Data
                                                </td>
                                            </tr>
                                         
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>
                       
                    </div>
                    <div class="row">
                        
                         <div class="col-md-6 col-sm-6">
                            <div class="portlet light calendar bordered">
                                <div class="portlet-title ">
                                    <div class="caption">
                                        <i class="icon-calendar font-green-sharp"></i>
                                        <span class="caption-subject font-green-sharp bold uppercase">Feeds</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="calendar" class="fc fc-ltr fc-unthemed"><div class="fc-toolbar"><div class="fc-left"><h2>March 2016</h2></div><div class="fc-right"><div class="fc-button-group"><button type="button" class="fc-prev-button fc-button fc-state-default fc-corner-left"><span class="fc-icon fc-icon-left-single-arrow"></span></button><button type="button" class="fc-next-button fc-button fc-state-default"><span class="fc-icon fc-icon-right-single-arrow"></span></button><button type="button" class="fc-today-button fc-button fc-state-default fc-state-disabled" disabled="disabled">today</button><button type="button" class="fc-month-button fc-button fc-state-default fc-state-active">month</button><button type="button" class="fc-agendaWeek-button fc-button fc-state-default">week</button><button type="button" class="fc-agendaDay-button fc-button fc-state-default fc-corner-right">day</button></div></div><div class="fc-center"></div><div class="fc-clear"></div></div><div class="fc-view-container" style=""><div class="fc-view fc-month-view fc-basic-view"><table><thead class="fc-head"><tr><td class="fc-widget-header"><div class="fc-row fc-widget-header"><table><thead><tr><th class="fc-day-header fc-widget-header fc-sun">Sun</th><th class="fc-day-header fc-widget-header fc-mon">Mon</th><th class="fc-day-header fc-widget-header fc-tue">Tue</th><th class="fc-day-header fc-widget-header fc-wed">Wed</th><th class="fc-day-header fc-widget-header fc-thu">Thu</th><th class="fc-day-header fc-widget-header fc-fri">Fri</th><th class="fc-day-header fc-widget-header fc-sat">Sat</th></tr></thead></table></div></td></tr></thead><tbody class="fc-body"><tr><td class="fc-widget-content"><div class="fc-day-grid-container"><div class="fc-day-grid"><div class="fc-row fc-week fc-widget-content"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-other-month fc-past" data-date="2016-02-28"></td><td class="fc-day fc-widget-content fc-mon fc-other-month fc-past" data-date="2016-02-29"></td><td class="fc-day fc-widget-content fc-tue fc-past" data-date="2016-03-01"></td><td class="fc-day fc-widget-content fc-wed fc-past" data-date="2016-03-02"></td><td class="fc-day fc-widget-content fc-thu fc-past" data-date="2016-03-03"></td><td class="fc-day fc-widget-content fc-fri fc-past" data-date="2016-03-04"></td><td class="fc-day fc-widget-content fc-sat fc-past" data-date="2016-03-05"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-other-month fc-past" data-date="2016-02-28">28</td><td class="fc-day-number fc-mon fc-other-month fc-past" data-date="2016-02-29">29</td><td class="fc-day-number fc-tue fc-past" data-date="2016-03-01">1</td><td class="fc-day-number fc-wed fc-past" data-date="2016-03-02">2</td><td class="fc-day-number fc-thu fc-past" data-date="2016-03-03">3</td><td class="fc-day-number fc-fri fc-past" data-date="2016-03-04">4</td><td class="fc-day-number fc-sat fc-past" data-date="2016-03-05">5</td></tr></thead><tbody><tr><td rowspan="2"></td><td rowspan="2"></td><td class="fc-event-container" rowspan="2"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable" style="background-color:#F8CB00"><div class="fc-content"><span class="fc-time">12a</span> <span class="fc-title">All Day</span></div></a></td><td class="fc-event-container" colspan="3"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable" style="background-color:#89C4F4"><div class="fc-content"><span class="fc-time">12a</span> <span class="fc-title">Long Event</span></div></a></td><td rowspan="2"></td></tr><tr><td></td><td></td><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable" style="background-color:#F3565D"><div class="fc-content"><span class="fc-time">4p</span> <span class="fc-title">Repeating Event</span></div></a></td></tr></tbody></table></div></div><div class="fc-row fc-week fc-widget-content"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-past" data-date="2016-03-06"></td><td class="fc-day fc-widget-content fc-mon fc-today fc-state-highlight" data-date="2016-03-07"></td><td class="fc-day fc-widget-content fc-tue fc-future" data-date="2016-03-08"></td><td class="fc-day fc-widget-content fc-wed fc-future" data-date="2016-03-09"></td><td class="fc-day fc-widget-content fc-thu fc-future" data-date="2016-03-10"></td><td class="fc-day fc-widget-content fc-fri fc-future" data-date="2016-03-11"></td><td class="fc-day fc-widget-content fc-sat fc-future" data-date="2016-03-12"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-past" data-date="2016-03-06">6</td><td class="fc-day-number fc-mon fc-today fc-state-highlight" data-date="2016-03-07">7</td><td class="fc-day-number fc-tue fc-future" data-date="2016-03-08">8</td><td class="fc-day-number fc-wed fc-future" data-date="2016-03-09">9</td><td class="fc-day-number fc-thu fc-future" data-date="2016-03-10">10</td><td class="fc-day-number fc-fri fc-future" data-date="2016-03-11">11</td><td class="fc-day-number fc-sat fc-future" data-date="2016-03-12">12</td></tr></thead><tbody><tr><td></td><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable" style="background-color:#95a5a6"><div class="fc-content"><span class="fc-time">2p</span> <span class="fc-title">Lunch</span></div></a></td><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable" style="background-color:#9b59b6"><div class="fc-content"><span class="fc-time">7p</span> <span class="fc-title">Birthday</span></div></a></td><td></td><td></td><td></td><td></td></tr></tbody></table></div></div><div class="fc-row fc-week fc-widget-content"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-future" data-date="2016-03-13"></td><td class="fc-day fc-widget-content fc-mon fc-future" data-date="2016-03-14"></td><td class="fc-day fc-widget-content fc-tue fc-future" data-date="2016-03-15"></td><td class="fc-day fc-widget-content fc-wed fc-future" data-date="2016-03-16"></td><td class="fc-day fc-widget-content fc-thu fc-future" data-date="2016-03-17"></td><td class="fc-day fc-widget-content fc-fri fc-future" data-date="2016-03-18"></td><td class="fc-day fc-widget-content fc-sat fc-future" data-date="2016-03-19"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-future" data-date="2016-03-13">13</td><td class="fc-day-number fc-mon fc-future" data-date="2016-03-14">14</td><td class="fc-day-number fc-tue fc-future" data-date="2016-03-15">15</td><td class="fc-day-number fc-wed fc-future" data-date="2016-03-16">16</td><td class="fc-day-number fc-thu fc-future" data-date="2016-03-17">17</td><td class="fc-day-number fc-fri fc-future" data-date="2016-03-18">18</td><td class="fc-day-number fc-sat fc-future" data-date="2016-03-19">19</td></tr></thead><tbody><tr><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable" style="background-color:#1bbc9b"><div class="fc-content"><span class="fc-time">4p</span> <span class="fc-title">Repeating Event</span></div></a></td><td></td><td></td><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable"><div class="fc-content"><span class="fc-time">10:30a</span> <span class="fc-title">Meeting</span></div></a></td><td></td><td></td><td></td></tr></tbody></table></div></div><div class="fc-row fc-week fc-widget-content"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-future" data-date="2016-03-20"></td><td class="fc-day fc-widget-content fc-mon fc-future" data-date="2016-03-21"></td><td class="fc-day fc-widget-content fc-tue fc-future" data-date="2016-03-22"></td><td class="fc-day fc-widget-content fc-wed fc-future" data-date="2016-03-23"></td><td class="fc-day fc-widget-content fc-thu fc-future" data-date="2016-03-24"></td><td class="fc-day fc-widget-content fc-fri fc-future" data-date="2016-03-25"></td><td class="fc-day fc-widget-content fc-sat fc-future" data-date="2016-03-26"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-future" data-date="2016-03-20">20</td><td class="fc-day-number fc-mon fc-future" data-date="2016-03-21">21</td><td class="fc-day-number fc-tue fc-future" data-date="2016-03-22">22</td><td class="fc-day-number fc-wed fc-future" data-date="2016-03-23">23</td><td class="fc-day-number fc-thu fc-future" data-date="2016-03-24">24</td><td class="fc-day-number fc-fri fc-future" data-date="2016-03-25">25</td><td class="fc-day-number fc-sat fc-future" data-date="2016-03-26">26</td></tr></thead><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table></div></div><div class="fc-row fc-week fc-widget-content"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-future" data-date="2016-03-27"></td><td class="fc-day fc-widget-content fc-mon fc-future" data-date="2016-03-28"></td><td class="fc-day fc-widget-content fc-tue fc-future" data-date="2016-03-29"></td><td class="fc-day fc-widget-content fc-wed fc-future" data-date="2016-03-30"></td><td class="fc-day fc-widget-content fc-thu fc-future" data-date="2016-03-31"></td><td class="fc-day fc-widget-content fc-fri fc-other-month fc-future" data-date="2016-04-01"></td><td class="fc-day fc-widget-content fc-sat fc-other-month fc-future" data-date="2016-04-02"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-future" data-date="2016-03-27">27</td><td class="fc-day-number fc-mon fc-future" data-date="2016-03-28">28</td><td class="fc-day-number fc-tue fc-future" data-date="2016-03-29">29</td><td class="fc-day-number fc-wed fc-future" data-date="2016-03-30">30</td><td class="fc-day-number fc-thu fc-future" data-date="2016-03-31">31</td><td class="fc-day-number fc-fri fc-other-month fc-future" data-date="2016-04-01">1</td><td class="fc-day-number fc-sat fc-other-month fc-future" data-date="2016-04-02">2</td></tr></thead><tbody><tr><td></td><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable" href="http://google.com/" style="background-color:#F8CB00"><div class="fc-content"><span class="fc-time">12a</span> <span class="fc-title">Click for Google</span></div></a></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table></div></div><div class="fc-row fc-week fc-widget-content"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-other-month fc-future" data-date="2016-04-03"></td><td class="fc-day fc-widget-content fc-mon fc-other-month fc-future" data-date="2016-04-04"></td><td class="fc-day fc-widget-content fc-tue fc-other-month fc-future" data-date="2016-04-05"></td><td class="fc-day fc-widget-content fc-wed fc-other-month fc-future" data-date="2016-04-06"></td><td class="fc-day fc-widget-content fc-thu fc-other-month fc-future" data-date="2016-04-07"></td><td class="fc-day fc-widget-content fc-fri fc-other-month fc-future" data-date="2016-04-08"></td><td class="fc-day fc-widget-content fc-sat fc-other-month fc-future" data-date="2016-04-09"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-other-month fc-future" data-date="2016-04-03">3</td><td class="fc-day-number fc-mon fc-other-month fc-future" data-date="2016-04-04">4</td><td class="fc-day-number fc-tue fc-other-month fc-future" data-date="2016-04-05">5</td><td class="fc-day-number fc-wed fc-other-month fc-future" data-date="2016-04-06">6</td><td class="fc-day-number fc-thu fc-other-month fc-future" data-date="2016-04-07">7</td><td class="fc-day-number fc-fri fc-other-month fc-future" data-date="2016-04-08">8</td><td class="fc-day-number fc-sat fc-other-month fc-future" data-date="2016-04-09">9</td></tr></thead><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table></div></div></div></div></td></tr></tbody></table></div></div> </div>
                                </div>
                            </div>
                         </div>
                    </div>
                  <div class="row">
                         <div class="col-md-6 col-sm-6">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-green"></i>
                                        <span class="caption-subject font-green bold  uppercase">Staff Currently on Break</span>
                                       
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">View Detail</label>
                                          
                                            
                                        </div>
                                    </div>
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
                                            <tbody><tr>
                                                <td>
                                                Walton Hames
                                                </td>
                                                <td>
                                                   Data Analyst
                                                </td>
                                                <td> 10 Minutes </td>
                                                
                                               
                                            </tr>
                                          
                                          
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>
                         </div>
                          <div class="col-md-6 col-sm-6">
                          <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">Assigned Job to Each Staff </span>
                                       
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">View Detail</label>
                                           
                                            
                                        </div>
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
                                            <tbody><tr>
                                                <td>
                                                 Kames Bush
                                                </td>
                                                <td>
                                                    Accounts Handling
                                                </td>
                                                <td> 09/03/2016 </td>
                                                <td> William Hennry</td>
                                                <td> Open </td>
                                               
                                            </tr>
                                          
                                          
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>
                          </div>
                  </div>
                    <div class="row">
                        <div class="col-xs-12">
                              <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-red"></i>
                                        <span class="caption-subject font-red bold uppercase">Staff working Hours</span>
                                       
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">View Detail</label>
                                           
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th> Staff </th>
                                                    <th> Status </th>
                                                    <th> 20 March,16 </th>
                                                    <th> 22 March,16 </th>
                                                    <th> 23 March,16 </th>
                                                    <th> 24 March,16 </th>
                                                    <th> 25 March,16 </th>
                                                    <th> 26 March,16 </th>
                                                    <th> 27 March,16 </th>
                                                </tr>
                                            </thead>
                                            <tbody><tr>
                                                <td>
                                                Services JOb
                                                </td> <td>
                                                Services JOb
                                                </td>
                                                 <td>
                                                Services JOb
                                                </td>
                                                 <td>
                                                Services JOb
                                                </td>
                                                 <td>
                                                Services JOb
                                                </td>
                                                
                                                <td>
                                                    Kate Penny
                                                </td>
                                                <td> North East </td>
                                                <td> Closed </td>
                                                <td> 09/03/2016 </td>
                                               
                                            </tr>
                                          
                                          
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                  
                   
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->

<?php
}elseif($CRUD_AUTH['group']['dashboard']==3){
?>
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="index.html">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Dashboard</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"> Dashboard
                        <small>dashboard & statistics</small>
                    </h3>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <!-- BEGIN PORTLET-->
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-red"></i>
                                        <span class="caption-subject font-red bold uppercase">Open Jobs</span>
                                        
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">Today</label>
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm">
                                                <input type="radio" name="options" class="toggle" id="option2">Week</label>
                                          
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="row number-stats margin-bottom-30">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="stat-left">
                                                <div class="stat-chart">
                                                    <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                    <div id="sparkline_bar"><canvas width="113" height="55" style="display: inline-block; width: 113px; height: 55px; vertical-align: top;"></canvas></div>
                                                </div>
                                                <div class="stat-number">
                                                    <div class="title"> Total </div>
                                                    <div class="number"> 10 </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="stat-right">
                                                <div class="stat-chart">
                                                    <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                    <div id="sparkline_bar2"><canvas width="107" height="55" style="display: inline-block; width: 107px; height: 55px; vertical-align: top;"></canvas></div>
                                                </div>
                                                <div class="stat-number">
                                                    <div class="title"> New </div>
                                                    <div class="number"> 7 </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th colspan="4"> JOB </th>
                                                    <th> STATUS </th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                              
                                                    
                                               
                                                <td colspan="4"> client Fee Structure </td>
                                               
                                                <td>
                                                    <span class="bold theme-font">open</span>
                                                </td>
                                            </tr>
                                           <tr>
                                              
                                                    
                                               
                                                <td colspan="4">Arrange a client Meeting </td>
                                               
                                                <td>
                                                    <span class="bold theme-font">open</span>
                                                </td>
                                            </tr>
                                         
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>
                            <!-- END PORTLET-->
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <!-- BEGIN PORTLET-->
                                    <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-red"></i>
                                        <span class="caption-subject font-red bold uppercase">Deadlines</span>
                                       
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">Today</label>
                                            <label class="btn btn-transparent green btn-outline btn-circle btn-sm">
                                                <input type="radio" name="options" class="toggle" id="option2">Week</label>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: 16%;" class="progress-bar progress-bar-success green-sharp">
                                            <span class="sr-only">16% progress</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title pull-left"> progress </div>
                                        <div class="status-number pull-right"> 16% </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th> JOB </th>
                                                    <th> Status</th>
                                                    <th> Deadlines </th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody><tr>
                                                <td>
                                                
                                                Services Job
                                                </td>
                                                <td>
                                                    Closed
                                                </td>
                                                <td> 03/07/2016 </td>
                                                
                                               
                                            </tr>
                                          
                                          
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- END PORTLET-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <!-- BEGIN PORTLET-->
                            <div class="portlet light calendar bordered">
                                <div class="portlet-title ">
                                    <div class="caption">
                                        <i class="icon-calendar font-green-sharp"></i>
                                        <span class="caption-subject font-green-sharp bold uppercase">My Calendar</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="calendar"> </div>
                                </div>
                            </div>
                            <!-- END PORTLET-->
                        </div>
                        <div class="col-md-6 col-sm-6">
                          <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-red"></i>
                                        <span class="caption-subject font-red bold uppercase">Awaiting Client Response</span>
                                       
                                    </div>
                                </div>
                                
                                <div class="portlet-body">
                                    
                                    <div class="table-scrollable table-scrollable-borderless">
                                          <table class="table table-hover table-light">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th> JOB </th>
                                                    <th> Client</th>
                                                    <th> Status </th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody><tr>
                                                <td>
                                                Accounts Management
                                                </td>
                                                <td>
                                                    Goldfield
                                                </td>
                                                <td> On Hold </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
<?php
}
?>