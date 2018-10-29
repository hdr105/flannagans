<?php 
$CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); 
global $date_format_convert;
$this_user_id = $CRUD_AUTH['id'];


if($CRUD_AUTH['group']['dashboard']==1){



?>

           <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
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
                    <div class="row">
                    
                        <div class="col-md-6 col-sm-6" id="openjobs"></div>
                        <div class="col-md-6 col-sm-6" id="deadlines"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-6 col-sm-6" id="staffholiday"></div>
                         <div class="col-md-6 col-sm-6" id="dueclientfee"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-6 col-sm-6" id="staffonbreak"></div>
                          <div class="col-md-6 col-sm-6" id="jobassignedtoeachstaff"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12" id="staffworkinghours"></div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
<script type="text/javascript">
    $(document).ready(function(){
        var this_user = '<?php echo $this_user_id; ?>';
        getOpenJobs();
        deadlines();
        staffholiday();
        dueclientfee();
        staffonbreak();
        jobassignedtoeachstaff();
        staffworkinghours();
        function getOpenJobs() {
          $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/openjobs',
                success: function(data) {    
                   $('#openjobs').html(data);
                }
            });
        }
        function deadlines(){
         $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/deadlines',
                success: function(data) {    
                   $('#deadlines').html(data);
                }
            });   
        }
        function staffholiday(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/staffholiday',
                success: function(data) {    
                   $('#staffholiday').html(data);
                }
            }); 
        }
        function dueclientfee(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/dueclientfee',
                success: function(data) {    
                   $('#dueclientfee').html(data);
                }
            }); 
        }
        function staffonbreak(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/staffonbreak',
                success: function(data) {    
                   $('#staffonbreak').html(data);
                }
            });
        }
        function jobassignedtoeachstaff(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/jobassignedtoeachstaff',
                success: function(data) {    
                   $('#jobassignedtoeachstaff').html(data);
                }
            });
        }
        function staffworkinghours(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/staffworkinghours',
                success: function(data) {    
                   $('#staffworkinghours').html(data);
                }
            });
        }
        // auto updated
        setInterval(function(){
            getOpenJobs();
            deadlines();
            staffholiday();
            dueclientfee();
            staffonbreak();
            jobassignedtoeachstaff();
            staffworkinghours();
        }, 10000);


    });
</script>
<?php
}elseif($CRUD_AUTH['group']['dashboard']==2){
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
                    
                        <div class="col-md-6 col-sm-6" id="openjobs"></div>
                        <div class="col-md-6 col-sm-6" id="deadlines"></div>
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
                                    <div class="calendar_data">
                                        <div id="external-events"></div>
                                        <div id="calendar" class="has-toolbar"> </div>
                                    </div>
                                </div>
                            </div>
                         </div>
                         <div class="col-md-6 col-sm-6" id="dueclientfee"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-6 col-sm-6" id="available_holidays"></div>
                          <div class="col-md-6 col-sm-6" id="jobassignedtoeachstaff"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12" id="staffworkinghours"></div>
                    </div>
                    
                  
                   
                  
                   
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <script type="text/javascript">
                
                    $(document).ready(function(){
                        $.ajax({
                            url: '<?php echo base_url(); ?>'+'webservices',
                            type: 'POST',
                            data: {operation:'lega_letters_list'},
                            success: function (response) { 
                                //var data = JSON.parse(response);
                                var d = response.result;
                                var html = '';
                                for (var i = 0; i < d.length; i++) {
                                    html = html + '<tr>'+
                                    '<td>'+
                                    d[i].letter_name+
                                    '</td>'+
                                    '<td>'+
                                    d[i].folder_name+
                                    '</td>'+
                                    '</tr>';
                                    
                                }
                                console.log(html);
                                $('#legal_letters_data').html(html)
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            }
                        });
                    });
            </script>
            <script type="text/javascript">
    $(document).ready(function(){
        var this_user = '<?php echo $this_user_id; ?>';
        getOpenJobs();
        deadlines();
        staffholiday();
        dueclientfee();
        available_holidays();
        jobassignedtoeachstaff();
        staffworkinghours();
        function available_holidays(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/available_holidays',
                success: function(data) {    
                   $('#available_holidays').html(data);
                }
            });
        }
        function getOpenJobs() {
          $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/openjobs',
                success: function(data) {    
                   $('#openjobs').html(data);
                }
            });
        }
        function deadlines(){
         $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/deadlines',
                success: function(data) {    
                   $('#deadlines').html(data);
                }
            });   
        }
        function staffholiday(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/staffholiday',
                success: function(data) {    
                   $('#staffholiday').html(data);
                }
            }); 
        }
        function dueclientfee(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/dueclientfee',
                success: function(data) {    
                   $('#dueclientfee').html(data);
                }
            }); 
        }
        function staffonbreak(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/staffonbreak',
                success: function(data) {    
                   $('#staffonbreak').html(data);
                }
            });
        }
        function jobassignedtoeachstaff(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/jobassignedtoeachstaff',
                success: function(data) {    
                   $('#jobassignedtoeachstaff').html(data);
                }
            });
        }
        function staffworkinghours(){
            $.ajax({
                type: 'GET',
                data : {this_user:this_user},
                url: '<?php echo base_url(); ?>'+'admin/dashboard/staffworkinghours',
                success: function(data) {    
                   $('#staffworkinghours').html(data);
                }
            });
        }
        // auto updated
        setInterval(function(){
            getOpenJobs();
            deadlines();
            staffholiday();
            dueclientfee();
            available_holidays();
            jobassignedtoeachstaff();
            staffworkinghours();
        }, 10000);


    });
</script>
<?php
}elseif($CRUD_AUTH['group']['dashboard']==3){
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
                    <!-- BEGIN DASHBOARD STATS 1-->
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat blue">
                                <div class="visual">
                                    <i class="fa fa-comments"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="1349">0</span>
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
                                        <span data-counter="counterup" data-value="12,5">0</span>M$ </div>
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
                                        <span data-counter="counterup" data-value="549">0</span>
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
                                        <span data-counter="counterup" data-value="89"></span>% </div>
                                    <div class="desc"> Brand Popularity </div>
                                </div>
                                <a class="more" href="javascript:;"> View more
                                    <i class="m-icon-swapright m-icon-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <!-- END DASHBOARD STATS 1-->
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
                                                    <div class="number"> 2460 </div>
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
                                                    <div class="number"> 719 </div>
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
                                        <span style="width: 76%;" class="progress-bar progress-bar-success green-sharp">
                                            <span class="sr-only">76% progress</span>
                                        </span>
                                    </div>
                                    <div class="status">
                                        <div class="status-title pull-left"> progress </div>
                                        <div class="status-number pull-right"> 76% </div>
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
                                            <tbody>
                                            <tr>
                                                <td>Worked</td> 
                                                <td>1</td>
                                                 <td>9</td>
                                                 <td>8</td>
                                                 <td>6</td>
                                                 <td>7</td>
                                                <td> 8 </td>
                                                <td> 9</td>
                                                <td> 10</td>
                                               
                                            </tr>
                                          <tr>
                                                <td>Meeting</td> 
                                                <td>1</td>
                                                 <td>9</td>
                                                 <td>8</td>
                                                 <td>6</td>
                                                 <td>7</td>
                                                <td> 8 </td>
                                                <td> 9</td>
                                                <td> 10</td>
                                               
                                            </tr>
                                            <tr>
                                                <td>On Lunch</td> 
                                                <td>1</td>
                                                 <td>9</td>
                                                 <td>8</td>
                                                 <td>6</td>
                                                 <td>7</td>
                                                <td> 8 </td>
                                                <td> 9</td>
                                                <td> 10</td>
                                               
                                            </tr>
                                            <tr>
                                                <td>On Break</td> 
                                                <td>1</td>
                                                 <td>9</td>
                                                 <td>8</td>
                                                 <td>6</td>
                                                 <td>7</td>
                                                <td> 8 </td>
                                                <td> 9</td>
                                                <td> 10</td>
                                               
                                            </tr>
                                          
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>
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
                $myCalIds = array();
                $sql = "SELECT * FROM calendar_types WHERE assigned_to = " . $this_user_id;
                $query = $this->db->query($sql);
                if (!empty($query)) {
                    foreach ($query->result_array() as $row) {
                        $myCalIds[] = $row['id'];
                    }
                }

        $calenars = array();
        $sql = 'SELECT * FROM calendar WHERE eventstatus IN ("'.implode('","', $myCalIds).'") ';
        $query = $this->db->query($sql);
        if (!empty($query)) {
            foreach ($query->result_array() as $row) {
                $calenars[] = $row;
            }
        }
        //print_r($calenars);

?>

                                <form method="post" action="?com_id=25&show=list" id="table" class="form-horizontal">
                                    <?php //require dirname(__FILE__) . '/search_form.php'; ?>
            <input type="hidden" name="src[page]" id="srcPage" value="1"/>
            <input type="hidden" name="src[limit]" id="srcLimit" value="9000"/>
            <input type="hidden" name="src[order_field]" id="srcOrder_field" value="calendar.id"/>
            <input type="hidden" name="src[order_type]" id="srcOrder_type" value="desc"/>
            <input type="hidden" name="selected_records_hdn" value="" />

            <input type="hidden" name="auth_token" id="auth_token" value=""/>

                                  <div class="row">
                                  </div>
                                  </form>
<script type="text/javascript">
    function availabilitySearch(){
        bootbox.dialog({
            message: availabilityFormContent(),
            title: "Search!",
            buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    search: {
                        label: 'Search ',
                        className: 'btn-success',
                        callback: function (data) {
                            crudSearch();
                            return false;
                        }
                    }
            }
        });
    }
    function availabilityFormContent(){
        var content = $("#table").clone(true);
        content.find('.row').html('');
        <?php
            $q = $this->queryString;
            $q['xtype'] = 'availabilityForm';
            if (isset($q['key']))
            unset($q['key']);
        ?>  
        $.ajax({
            type: 'GET',
            url: '?<?php echo http_build_query($q, '', '&'); ?>',
            success: function(data) {                                
                $(content).css('visibility','visible');
                $(content).attr('id','search');
                
                $(content).find('.row').html(data);
            }
        });
        return content ;
    }

   
     //RELATED MPDULE POPUP HERE STARTS
   function insertRelated(jData){
        quickCreateModal(jData);
    }
    //RELATED MODULE POPUP ENDS
    // Genereates quick create form content
    function quickCreateFormContent(jData){
        var content = $("#table").clone(true);
        content.find('.row').html('');
        var keyVal = '';
        if (jData.key != undefined) {
            keyVal = jData.key;
        }
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>'+'index.php/admin/scrud/browse?com_id='+jData.module_id+'&xtype=quickcreate'+keyVal+'&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll+'&pre_selected='+jData.pre_selected,
            success: function(data) {   
               
                var actionUrl = '<?php echo base_url(); ?>'+'index.php/admin/scrud/browse?com_id='+jData.module_id+'&xtype=quickcreateform';                            
                $(content).css('visibility','visible');
                $(content).attr('id','quickcreate');
                $(content).attr('action',actionUrl);
                $(content).find('.row').html(data);
            }
        });
        return content ;
    }
    function quickCreateModal(jData) {
        console.log('create model');
        console.log(jData);
        var modalClass = 'modal_'+jData.module_id;
        bootbox.dialog({
            className:modalClass,
            message: quickCreateFormContent(jData),
            title: "Quick Create Form!",
            buttons: {
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-warning'
                    },
                    quickcreate: {
                        label: 'Create ',
                        className: 'btn-success',
                        callback: function (data) {
                            //Serialize form data
                            var frmdata = new FormData($("#quickcreate")[0]);
                            var validatorNode = validateform();
                            if(validatorNode==1){
                                var actionUrl = '<?php echo base_url(); ?>'+'index.php/admin/scrud/browse?com_id='+jData.module_id+'&xtype=quickcreateform&module_key='+jData.module_key+'&module_value='+jData.module_value+'&hidden_controll='+jData.hidden_controll+'&visible_controll='+jData.visible_controll; 
                                $.ajax({
                                    url: actionUrl,
                                    type: $("#quickcreate").attr("method"),
                                    data: frmdata,
                                    processData: false,
                                    contentType: false,
                                    success: function (response) { 
                                        console.log(response);
                                        location.href = '<?php echo base_url(); ?>'+'admin/dashboard';
                                        //selectedRecordquickcreate(JSON.parse(response));
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                       console.log(textStatus, errorThrown);
                                    }
                                });
                                $('.'+modalClass).modal('hide');
                            }
                            return false;   
                        }
                    }
            }
        });
    }
String.prototype.capFirstChar = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}
$(document).ready(function() {
                        var data = [];
                        <?php
                            foreach ($calenars as $key => $value) {
                                $calendar = $value;

                                ?>
                                var cal = {};
                                cal['id'] = '<?php echo $calendar['id']; ?>';
                                cal['title'] = '<?php echo $calendar['subject']; ?>';
                                cal['start_date'] = '<?php echo $calendar['date_start']; ?>';
                                cal['end_date'] = '<?php echo $calendar['due_date']; ?>';
                                cal['start_time'] = '<?php echo $calendar['time_start']; ?>';
                                cal['end_time'] = '<?php echo $calendar['time_end']; ?>';
                                cal['backgroundColor'] = '#333333';
                                
                                data.push(cal);
                                <?php
                            }
                        ?>
                           console.log(data);
                        AppCalendar.init(data); 
                        $('title').html('<?php echo $this->title; ?>');
                        
                    });
</script>