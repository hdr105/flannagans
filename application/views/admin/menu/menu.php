<?php $CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); 

/////////// ALi Raza - Event Notification - 5 min before /////////////// 
?>
<link href="<?php echo base_url(); ?>media/assets/global/plugins/jquery-notific8/jquery.notific8.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>media/assets/pages/scripts/ui-notific8.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>media/assets/global/plugins/jquery-notific8/jquery.notific8.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>media/assets/global/plugins/date.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>media/assets/global/plugins/moment-with-locales.js" type="text/javascript"></script>
<?php
    $sql = "SELECT subject,date_start,time_start,invite_calendars,created_by,assigned_to FROM calendar WHERE assigned_to=".$CRUD_AUTH['id']." OR invite_calendars=".$CRUD_AUTH['id']."";
    $query = $this->db->query($sql); 
    $events_result = $query->result_array();

//////////////////////////////////////////////////
?>
<!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">

<?php
    $sql = "SELECT * FROM company_info";
    $query = $this->db->query($sql);

    $company_info = array();
    if (!empty($query)) {
        foreach ($query->result_array() as $row) {
            $company_info[] = $row;
        }
    }

    $sql = "SELECT id,sitename FROM sites";
    $query = $this->db->query($sql);

    $sites = array();
    if (!empty($query)) {
        foreach ($query->result_array() as $row) {
            $sites[] = $row;
        }
    }

    $sql = "SELECT time_start,time_end,status FROM users_work_log WHERE user_id=".$CRUD_AUTH['id']." AND site_id=".$CRUD_AUTH['site_id']." AND dated='".date("Y-m-d")."' ORDER BY id DESC LIMIT 1";
    //die($sql);
    $query = $this->db->query($sql);

    $working_state = array();
    if (!empty($query)) {
        foreach ($query->result_array() as $row) {
            $working_state[] = $row;
        }
    }

    //echo '<pre>',print_r($CRUD_AUTH),'</pre>';
?>
                    <a href="<?=base_url(); ?>">
                        <img src="<?=base_url() . '/media/images/thumbnail_' . $company_info[0]['company_logo']; ?>" alt="<?=$company_info[0]['company_name']; ?>" class="logo-default" />
                    </a> 
                    <div class="menu-toggler sidebar-toggler"> </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">

<?php if ($CRUD_AUTH['group_id'] != 5): ?>
                    <div class="btn btn-warning pull-left date orange" style="background:#ff7f27; border:1px solid #ff7f27; margin-right:10px; margin-top:5px;"><?=date("l, F d, Y") ?></div>
                    <div class=" btn btn-success pull-left times"  style="background:#22b14c; border:1px solid #22b14c; margin-right:10px; margin-top:5px;">Timer <input type='text' name='timer' class='form-control timer' placeholder='0 sec' style="background-color: transparent; border: none;width:80px; color: #fff; display: inline; height:15px;" /></div>
                    <div class=" btn btn-success pull-left dark times-h"  style="border:1px solid #22b14c; margin-right:10px; margin-top:5px;display: none;">Timer <input type='text' name='timer-h' class='form-control timer-h' placeholder='0 sec' style="background-color: transparent; border: none;width:80px; color: #fff; display: inline; height:15px;" /></div>
                    <div class="dropdowns" style="margin-top:5px;float: left;">
                        <div class="btn-group pull-left open" style="margin-right:5px;">
                            <select class="form-control active action" style="background:#e7505a; color:#FFF; border:0px;" id="sel1">
                                <option value="working" selected="selected">Working</option>
                                <option value="break">On Short Break</option>
                                <option value="meeting">In a Meeting</option>
                                <option value="lunch">On Lunch</option>
                            </select>    
                        </div>
                        
                        <div class="btn-group pull-left" style="margin-right:5px;">
                            <select class="form-control active green siteid" style="background:#32c5d2;  color:#FFF;" id="sel2"<?php echo ($CRUD_AUTH['site_id']!=0 and $CRUD_AUTH['group']['id']>=2 and $CRUD_AUTH['group']['id']!=11)? ' disabled="disabled"': ''; ?>>
                                <!-- <option selected="selected" value="0">Select a Site</option> -->
                                <?php
                                foreach ($sites as $key => $row) {
                                    if(($CRUD_AUTH['group']['id']==11 and $row['id']!=1) and ($CRUD_AUTH['group']['id']==11 and $row['id']!=33) and ($CRUD_AUTH['group']['id']==11 and $row['id']!=111))
                                        continue;
                                ?>
                                <option value="<?=$row['id']?>"<?php echo $CRUD_AUTH['site_id']==$row['id']? 'selected="selected"': ''; ?>><?=$row['sitename']?></option>
                                <?php
                                }
                                ?>
                            </select>          
                        </div>
                        <div class="activity"></div>
                    </div>


    <script src='<?=base_url() ?>media/assets/timer.jquery.js'></script>
    <script>
    $('.siteid').on('change', function() {
        $url = "<?=base_url() ?>index.php/admin/scrud/status?cfun=setSiteID&site_id="+$('.siteid').val()+"&url=<?=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])?>";
        window.location.href=$url;

    });

    // Init timer start
    var hasTimer = false;
    var tval;
    if(tval = Cookies.getJSON('timerval')){
        
        var hms = tval['timer'];   // your input string
        var a = hms.split(':'); // split it at the colons
        var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 

        if(tval['timerh']){
            var hms1 = tval['timerh'];   // your input string
            var a1 = hms1.split(':'); // split it at the colons
            var secondsh = (+a1[0]) * 60 * 60 + (+a1[1]) * 60 + (+a1[2]); 
            $('.action').val(tval['state']);
            $('.timer-h').timer({
                seconds: secondsh,
                format: '%H:%M:%S',
            });
            $('.timer-h').timer('start');
            $('.times-h').show();
            $cur_state=$('.action').val();
        }
    }else{
        var seconds = 0;
    }
    //console.log(seconds+','+secondsh);


    $('.timer').timer({
        seconds: seconds,
        format: '%H:%M:%S'
    });
    if(tval = Cookies.getJSON('timerval') && tval['state']!='meeting' && tval['timerh']){
        $('.timer').timer('pause');
        $('.times').hide();
    }
    $cur_state='';

    $(window).on('load ',function() {
        Cookies.set('timerval',{timerh:$('.timer-h').val(),timer:$('.timer').val(),state:$('.action').val()});
    });
    $(window).on('beforeunload ',function() {
        Cookies.set('timerval',{timerh:$('.timer-h').val(),timer:$('.timer').val(),state:$('.action').val()});
        //tval = Cookies.getJSON('timerval');
        //return tval['timer'];
    });

    function autoRefresh_div()
    {
        /////////// ALi Raza - Event Notification - 5 min before ///////////////
        var arrayFromPHP = <?php echo json_encode($events_result); ?>;
        if (arrayFromPHP.length !== 0) {
            var fullDate = new Date()
            //convert month to 2 digits
            var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
            var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
            $.each(arrayFromPHP,function(index, all_events){
                if (typeof all_events === "object") {
                    var date = new Date(all_events['date_start']);
                    var date_new_format = date.toString('dd-MM-yyyy');
                    var event_date = all_events['date_start'];
                    var event_time = all_events['time_start'];
                    var before_5_mints = moment(event_time, 'HH:mm:ss').subtract('minutes', 5).format('HH:mm:ss');
                    
                    //convert seconds to 2 digits
                    var dt = new Date();
                    var twoDigitHour = (dt.getHours() < 10)? '0'+dt.getHours() : dt.getHours();
                    var twoDigitMint = (dt.getMinutes() < 10)? '0'+dt.getMinutes() : dt.getMinutes();
                    var twoDigitSecond = (dt.getSeconds() < 10)? '0'+dt.getSeconds() : dt.getSeconds();
                    var current_time = twoDigitHour + ":" + twoDigitMint + ":" + twoDigitSecond;
                    
                    if (event_date == currentDate && before_5_mints == current_time) {
                        $.notific8('configure', {
                        life: 5000,
                        heading: 'Event Alert!',
                        theme: 'ruby',
                        icon: 'minus-circle',
                        sticky: true,
                        horizontalEdge: 'top',
                        verticalEdge: 'right',
                        zindex: 150000,
                        closeText: 'près'
                        });
                        $.notific8(all_events['subject']+' Date: '+date_new_format+' Time: '+all_events['time_start']);
                    }
                }
            });
        }
        //////////////////////////
        tval = Cookies.getJSON('timerval');
        //alert(tval['state']);

        $url = "<?=base_url() ?>index.php/admin/scrud/status?cfun=working_state";

        if(tval['state']=='break' ){
            if($cur_state=='meeting' || $cur_state=='lunch'){
                //$('.timer-h').timer('pause');
                //$('.activity').append('Time: '+$('.timer-h').val()+' was on '+$cur_state+'<br /><br />');

                $('.timer-h').timer('remove');
            }
            $('.timer-h').timer({
                seconds: 0,
                format: '%H:%M:%S',
            });
            $('.timer-h').timer('start');
            $('.times-h').show();
            $('.timer').timer('pause');
            $('.times').hide();
            $cur_state=tval['state'];
            $('.action option[value=break]').prop('selected','selected');
            Cookies.set('timerval',{timerh:$('.timer-h').val(),timer:$('.timer').val(),state:"break"});

            //$.post($url,{state:"break"});
            //$('.activity').append('Time: '+$('.timer').val()+' and reason to stop:'+tval['state']+'<br /><br />');
        } else if(tval['state']=='lunch' ){
            if($cur_state=='meeting' || $cur_state=='break'){
                //$('.timer-h').timer('pause');
                //$('.activity').append('Time: '+$('.timer-h').val()+' was on '+$cur_state+'<br /><br />');

                $('.timer-h').timer('remove');
            }
            $('.timer-h').timer({
                seconds: 0,
                format: '%H:%M:%S',
            });
            $('.timer-h').timer('start');
            $('.times-h').show();
            $('.timer').timer('pause');
            $('.times').hide();
            $cur_state=tval['state'];
            $('.action option[value=lunch]').prop('selected','selected');
            Cookies.set('timerval',{timerh:$('.timer-h').val(),timer:$('.timer').val(),state:"lunch"});

            //$.post($url,{state:"lunch"});
            //$('.activity').append('Time: '+$('.timer').val()+' and reason to stop:'+tval['state']+'<br /><br />');
        } else if(tval['state']=='meeting' ){
            if($cur_state=='break' || $cur_state=='lunch'){
                //$('.timer-h').timer('pause');
                //$('.activity').append('Time: '+$('.timer-h').val()+' was on '+$cur_state+'<br /><br />');

                $('.timer-h').timer('remove');
            }
            $('.timer-h').timer({
                seconds: 0,
                format: '%H:%M:%S',
            });
            $('.timer-h').timer('start');
            $('.times-h').show();
            $('.timer').timer('resume');
            $('.times').hide();
            $cur_state=tval['state'];
            $('.action option[value=meeting]').prop('selected','selected');
            Cookies.set('timerval',{timerh:$('.timer-h').val(),timer:$('.timer').val(),state:"meeting"});

            //$.post($url,{state:"meeting"});
            //$('.activity').append('Time: '+$('.timer').val()+' and reason to stop:'+tval['state']+'<br /><br />');
        } else if(tval['state']=='working' ){
            $('.timer-h').timer('pause');
            $('.times-h').hide();
            $('.timer').timer('resume');
            $('.times').show();
            //$('.activity').append('Time: '+$('.timer-h').val()+' was on '+$cur_state+'<br /><br />');
            $cur_state=tval['state'];
            $('.action option[value=working]').prop('selected','selected');
            Cookies.set('timerval',{timerh:$('.timer-h').val(),timer:$('.timer').val(),state:"working"});
            $('.timer-h').timer('remove');

            //$.post($url,{state:"working"});
        }
        tval = Cookies.getJSON('timerval');
        //alert(tval['state']);
    }
    setInterval('autoRefresh_div()', 1000); // refresh div after 5 secs

    $('.action').on('change', function() {
        $url = "<?=base_url() ?>index.php/admin/scrud/status?cfun=working_state";

        if($('.action').val()=='break' ){
            if($cur_state=='meeting' || $cur_state=='lunch'){
                //$('.timer-h').timer('pause');
                //$('.activity').append('Time: '+$('.timer-h').val()+' was on '+$cur_state+'<br /><br />');

                $('.timer-h').timer('remove');
            }
            $('.timer-h').timer({
                seconds: 0,
                format: '%H:%M:%S',
            });
            $('.timer-h').timer('start');
            $('.times-h').show();
            $('.timer').timer('pause');
            $('.times').hide();
            $cur_state=$('.action').val();
            $('.action option[value=break]').prop('selected','selected');
            Cookies.set('timerval',{timerh:$('.timer-h').val(),timer:$('.timer').val(),state:"break"});

            $.post($url,{state:"break"});
            //$('.activity').append('Time: '+$('.timer').val()+' and reason to stop:'+$('.action').val()+'<br /><br />');
        } else if($('.action').val()=='lunch' ){
            if($cur_state=='meeting' || $cur_state=='break'){
                //$('.timer-h').timer('pause');
                //$('.activity').append('Time: '+$('.timer-h').val()+' was on '+$cur_state+'<br /><br />');

                $('.timer-h').timer('remove');
            }
            $('.timer-h').timer({
                seconds: 0,
                format: '%H:%M:%S',
            });
            $('.timer-h').timer('start');
            $('.times-h').show();
            $('.timer').timer('pause');
            $('.times').hide();
            $cur_state=$('.action').val();
            $('.action option[value=lunch]').prop('selected','selected');
            Cookies.set('timerval',{timerh:$('.timer-h').val(),timer:$('.timer').val(),state:"lunch"});

            $.post($url,{state:"lunch"});
            //$('.activity').append('Time: '+$('.timer').val()+' and reason to stop:'+$('.action').val()+'<br /><br />');
        } else if($('.action').val()=='meeting' ){
            if($cur_state=='break' || $cur_state=='lunch'){
                //$('.timer-h').timer('pause');
                //$('.activity').append('Time: '+$('.timer-h').val()+' was on '+$cur_state+'<br /><br />');

                $('.timer-h').timer('remove');
            }
            $('.timer-h').timer({
                seconds: 0,
                format: '%H:%M:%S',
            });
            $('.timer-h').timer('start');
            $('.times-h').show();
            $('.timer').timer('resume');
            $('.times').hide();
            $cur_state=$('.action').val();
            $('.action option[value=meeting]').prop('selected','selected');
            Cookies.set('timerval',{timerh:$('.timer-h').val(),timer:$('.timer').val(),state:"meeting"});

            $.post($url,{state:"meeting"});

            //$('.activity').append('Time: '+$('.timer').val()+' and reason to stop:'+$('.action').val()+'<br /><br />');
        } else {
            $('.timer-h').timer('pause');
            $('.times-h').hide();
            $('.timer').timer('resume');
            $('.times').show();
            //$('.activity').append('Time: '+$('.timer-h').val()+' was on '+$cur_state+'<br /><br />');
            $cur_state=$('.action').val();
            $('.timer-h').timer('remove');
            $('.action option[value=working]').prop('selected','selected');
            Cookies.set('timerval',{timerh:$('.timer-h').val(),timer:$('.timer').val(),state:"working"});

            $.post($url,{state:"working"});
        }
    });
    </script>

<?php endif ?>

                    <ul class="nav navbar-nav pull-right">
                 
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle" src="<?=base_url(); ?>media/files/profile_images/<?php if($CRUD_AUTH['profile_image']!='' and $CRUD_AUTH['profile_image']!=null){ echo $CRUD_AUTH['profile_image']; }else{ ?>noimage.jpg<?php } ?>" />
                                <span class="username username-hide-on-mobile"> <?=$CRUD_AUTH['user_name']; ?> </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <?php if ($CRUD_AUTH['group']['group_name'] != 'SystemAdmin') { ?>
                                <li>
                                     <a href="<?=base_url(); ?>admin/profile"> <i class="icon-user"></i> <?=$this->lang->line('edit_profile');?></a>
                                </li>
                                <!-- <li>
                                    <a href="<?=base_url(); ?>admin/scrud/browse?com_id=25">
                                        <i class="icon-calendar"></i> My Calendar </a>
                                </li>
                                <li>
                                    <a href="app_inbox.html">
                                        <i class="icon-envelope-open"></i> My Inbox
                                        <span class="badge badge-danger"> 3 </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="app_todo.html">
                                        <i class="icon-rocket"></i> My Tasks
                                        <span class="badge badge-success"> 7 </span>
                                    </a>
                                </li> -->
                                <li>
                                    <a href="<?=base_url(); ?>admin/profile?password"> <i class="icon-pencil"></i> <?=$this->lang->line('change_password');?></a>
                                </li>
                                <li class="divider"> </li>
                            <?php } ?>
                                <!-- <li>
                                    <a href="page_user_lock_1.html">
                                        <i class="icon-lock"></i> Lock Screen </a>
                                </li> -->
                               <li>
                                <li>
                                    <a href="<?=base_url(); ?>admin/logout"> <i class="icon-key"></i> <?=$this->lang->line('log_out');?></a>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-quick-sidebar-toggler">
                            <a href="<?=base_url(); ?>admin/logout" class="dropdown-toggle">
                                <i class="icon-logout"></i>
                            </a>
                        </li>
                    </ul>
                    
                    
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
  <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->




        <!-- BEGIN CONTAINER -->
        <div class="page-container">

            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->                     
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="false" data-slide-speed="200" style="padding-top: 20px">
                        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                        <li class="sidebar-toggler-wrapper hide">
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <div class="sidebar-toggler"> </div>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                        </li>
                        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                        <li class="sidebar-search-wrapper">
                            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                            <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                            <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
<?php if ($CRUD_AUTH['group_id'] != 5): ?>
                            <form class="sidebar-search  " action="<?=base_url(); ?>admin/gsearch" method="GET">
                                <a href="javascript:;" class="remove">
                                    <i class="icon-close"></i>
                                </a>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search..." name="search">
                                    <span class="input-group-btn">
                                        <a href="javascript:;" class="btn submit">
                                            <i class="icon-magnifier"></i>
                                        </a>
                                    </span>
                                </div>
                            </form>
<?php endif; ?>
                            <!-- END RESPONSIVE QUICK SEARCH FORM -->
                        </li>
                        <li class="nav-item start ">
                            <a href="<?=base_url(); ?>admin/dashboard" class="nav-link nav-toggle">
                                <i class="fa fa-dashboard"></i>
                                <span class="title">Dashboard</span>
                            </a>
                           
                        </li>

<!-- /////////////////// Module Working  ///////////////-->

                <?php 
                        
                    $k=0;
                    foreach ($mnuGroup as $v){
                        if ($v['type']==1) continue;
                        if (empty($v['coms'])) continue;

                        $show_menu_group = false;
                        foreach ($v['coms'] as $com){
                            $permissions = $auth->getPermissionType($com['id']);
                            if(count(array_intersect($permissions, array(1,2,3,4))) == 0) continue;
                            //if (!in_array(4, $permissions)) continue;
                            $show_menu_group = true;
                        }   
                        $permissions = $auth->getPermissionType(46);

                        //if (in_array(4, $permissions)){
                        if(count(array_intersect($permissions, array(1,2,3,4))) > 0){
                            $show_menu_group = true;
                        }

                        if ($show_menu_group) {
                            $array = array('line-chart','male','calendar','users','folder','briefcase','file-text','gears','docs','social-dribble','puzzle');
                            $icom = $array[$k];
                            $k++;
                            if($icom=='')
                                $icom='diamond';
                            if(count($v['coms'])>1){

                ?>
                        <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-<?=$icom?>"></i>
                                <span class="title"><?=$v['name']; ?></span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                            <?php 
                            foreach ($v['coms'] as $com){
                                $permissions = $auth->getPermissionType($com['id']);
                                //if (!in_array(4, $permissions)) continue;
                                if(count(array_intersect($permissions, array(1,2,3,4))) == 0) continue;
                                ?>
                                <li class="nav-item  " id="sub_item_<?php echo $com['id'];  ?>">
                                    <a href="<?php echo base_url(); ?>admin/<?php if($com['id']==83){ ?>profile/work_history<?php }elseif($com['id']==84){ ?>audit<?php }elseif($com['id']==87){ ?>checklist/builder<?php }else{ ?>scrud/browse<?php } if($com['id']!=85){ ?>?com_id=<?php echo $com['id']; } ?>" class="nav-link ">
                                        <span class="title"><?php echo $com['component_name']?></span>
                                    </a>
                                </li>
                            <?php 
                            } 
                            ?>
                            </ul>
                        </li>
                        <?php 
                            }else{
                                foreach ($v['coms'] as $com){
                                    $permissions = $auth->getPermissionType($com['id']);
                                    //if (!in_array(4, $permissions)) continue;
                                    if(count(array_intersect($permissions, array(1,2,3,4))) == 0) continue;
                                    ?>
                                    <li class="nav-item  " id="sub_item_<?php echo $com['id'];  ?>">
                                        <a href="<?php echo base_url(); ?>admin/<?php if($com['id']==87){ ?>checklist/builder<?php }elseif($com['id']!=83){ ?>scrud/browse<?php }else{ ?>profile/work_history<?php } ?>?com_id=<?php echo $com['id']; ?>" class="nav-link ">
                                            <i class="fa fa-<?=$icom?>"></i>
                                            <span class="title"><?php echo $com['component_name']?></span>
                                        </a>
                                    </li>
                                <?php 
                                } 
                            }
                        } 
                    } 

                        $show_settings = false;
                        
                        foreach ($coms as $com){
                            if (in_array($com['id'], $exComs)) continue;
                            if ($com['component_name'] == 'User Groups') continue;
                            if ($com['component_name'] == 'Group Members') continue;
                            if ($com['component_name'] == 'Email Templates') continue;
                        
                            $permissions = $auth->getPermissionType($com['id']);
                            if (!in_array(4, $permissions)) continue;

                            if ($com['id'] == '28') {   
                                continue;   
                            }
                            
                            $show_settings = true;
                        }

                        $permissions = $auth->getPermissionType(40);
                        
                        if (in_array(4, $permissions)){
                            $show_settings = true;
                        }
                    
                        if ($show_settings) { 
                    ?>

                        <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-settings"></i>
                                <span class="title">Settings</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                            <?php 
                            foreach ($coms as $com){
                                if (in_array($com['id'], $exComs)) continue;
                                if ($com['component_name'] == 'User Groups') continue;
                                if ($com['component_name'] == 'Group Members') continue;
                                if ($com['component_name'] == 'Email Templates') continue;
                                $permissions = $auth->getPermissionType($com['id']);
                                if (!in_array(4, $permissions)) continue;

                                if ($com['id'] == '87') {
                                ?>
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url(); ?>admin/checklist/builder" class="nav-link ">
                                        <span class="title"><?php echo $com['component_name']?></span>
                                    </a>
                                </li>
                                <?php
                                    continue;
                                }
                                ?>
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=<?php echo $com['id']; ?>" class="nav-link ">
                                        <span class="title"><?php echo $com['component_name']?></span>
                                    </a>
                                </li>
                            <?php 
                            } 

                            $permissions = $auth->getPermissionType(40);
                            if (in_array(4, $permissions)){
                            ?>
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=40" class="nav-link ">
                                        <span class="title">Email Template</span>
                                    </a>
                                </li>
                            <?php
                                }
                            ?>
                            </ul>
                        </li>
                    <?php } ?>
<!-- /////////////////// End Module Working///////////////// -->
                        
                        <?php 
                        if ((int) $CRUD_AUTH['group']['group_manage_flag'] == 1 || (int) $CRUD_AUTH['group']['group_manage_flag'] == 3 || (int) $CRUD_AUTH['user_manage_flag'] == 1 || (int) $CRUD_AUTH['user_manage_flag'] == 3) { ?>
                        <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-user"></i>
                                <span class="title"><?php echo $this->lang->line('user_manager'); ?></span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li id="sub_item_65">
                                    <a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=65" class="nav-link">
                                        <span class="title"><?php echo $this->lang->line('users');?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/user/group" class="nav-link">
                                        <span class="title"><?php echo $this->lang->line('groups');?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/user/permission" class="nav-link">
                                        <span class="title"><?php echo $this->lang->line('permissions');?></span>
                                    </a>
                                </li>
                                <li id="sub_item_22">
                                    <a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=22" class="nav-link">
                                        <span class="title"><?php echo 'User Groups';?></span>
                                    </a>
                                </li>
                                <!-- <li>
                                    <a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=24" class="nav-link">
                                        <span class="title"><?php echo 'Group Members';?></span>
                                    </a>
                                </li> -->
                            </ul>
                        </li>
                        <?php } ?>

                        <?php 
                        //if ((int) $CRUD_AUTH['group']['group_manage_flag'] == 2 || (int) $CRUD_AUTH['group']['group_manage_flag'] == 3 || (int) $CRUD_AUTH['user_manage_flag'] == 2 || (int) $CRUD_AUTH['user_manage_flag'] == 3) { 
                        if ((int) $CRUD_AUTH['id'] == 1) { 
                        ?>
                        <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-wrench"></i>
                                <span class="title"><?php echo 'SU-Tools'; ?></span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/setting/index" class="nav-link">
                                        <span class="title"><?php echo $this->lang->line('general')?></span>
                                    </a>
                                </li>
                                <li class="heading">
                                    <a href="<?=base_url(); ?>admin/setting/email/" class="nav-link"><?=$this->lang->line('email_templates'); ?></a>
                                </li>
                                <li class="nav-item ">
                                    <a href="<?=base_url(); ?>admin/setting/email/new_user"  class="nav-link "><span class="title"><?=$this->lang->line('new_user');?></span></a>
                                </li>
                                <li class="nav-item ">
                                    <a href="<?=base_url(); ?>admin/setting/email/reset_password"  class="nav-link "><span class="title"><?=$this->lang->line('reset_password'); ?></span></a>
                                </li>
                                <li>
                                    <a href="<?=base_url(); ?>admin/component/builder" class="nav-link">
                                        <span class="title"><?='Component Builder'; ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?=base_url(); ?>admin/component/groups" class="nav-link">
                                        <span class="title"><?=$this->lang->line('groups'); ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?=base_url(); ?>admin/table/index" class="nav-link">
                                        <span class="title"><?='Table Builder'; ?></span>
                                    </a>
                                </li>
                                
                                <li>
                                    <a href="<?=base_url(); ?>admin/language/index" class="nav-link">
                                        <span class="title"><?='Language Manager'; ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>

                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
            </div>
            <!-- END SIDEBAR -->                




<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container"><a class="btn btn-navbar"
                                  data-toggle="collapse" data-target=".nav-collapse"> <span
                    class="icon-bar"></span> <span class="icon-bar"></span> <span
                    class="icon-bar"></span> </a> <a class="brand" href="<?php echo base_url(); ?>admin/dashboard"><?php echo $this->lang->line('codeigniter_admin_pro'); ?></a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li <?php if ($type == 'dashboard') { ?>class="active"<?php } ?>><a href="<?php echo base_url(); ?>admin/dashboard"><?php echo $this->lang->line('main'); ?></a></li>
                    <?php if ((int) $CRUD_AUTH['group']['group_manage_flag'] == 1 || 
		                    (int) $CRUD_AUTH['group']['group_manage_flag'] == 3 ||
		                    (int) $CRUD_AUTH['user_manage_flag'] == 1 ||
		                    (int) $CRUD_AUTH['user_manage_flag'] == 3) { ?>
                        <li class="dropdown <?php if ($type == 'user') { ?>active<?php } ?>">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $this->lang->line('users'); ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url(); ?>admin/user/user"><?php echo $this->lang->line('user_manager');?></a></li>
                                <li><a href="<?php echo base_url(); ?>admin/user/group"><?php echo $this->lang->line('groups');?></a></li>
                                <li><a href="<?php echo base_url(); ?>admin/user/permission"><?php echo $this->lang->line('permissions');?></a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    
					<li class="dropdown <?php if ($type == 'component') { ?>active<?php } ?>" id="mnu_component"><a data-toggle="dropdown"
						class="dropdown-toggle" href="#"><?php echo $this->lang->line('components'); ?> <b
							class="caret"></b> </a>
						<ul class="dropdown-menu">
							<?php foreach ($mnuGroup as $v){                                
								if (empty($v['coms'])) continue;
								?>
							<li class="dropdown-submenu">
								<a href="#" tabindex="-1" onclick="clickGroup(this); return false;"><?php echo $v['name'];?></a>
								<ul class="dropdown-menu">
									<?php foreach ($v['coms'] as $com){
										$permissions = $auth->getPermissionType($com['id']);
										if (!in_array(4, $permissions)) continue;
										?>
									<li><a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=<?php echo $com['id']; ?>"><?php echo $com['component_name']?></a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
							<?php foreach ($coms as $com){
								if (in_array($com['id'], $exComs)) continue;
								$permissions = $auth->getPermissionType($com['id']);
								if (!in_array(4, $permissions)) continue;
							?>
							<li><a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=<?php echo $com['id']; ?>"><?php echo $com['component_name']?></a></li>
							<?php }?>
						</ul>
					</li>
					<?php if ((int) $CRUD_AUTH['group']['group_manage_flag'] == 2 || 
		                    (int) $CRUD_AUTH['group']['group_manage_flag'] == 3 ||
		                    (int) $CRUD_AUTH['user_manage_flag'] == 2 ||
		                    (int) $CRUD_AUTH['user_manage_flag'] == 3) { ?>
					<li class="dropdown  <?php if ($type == 'tool') { ?>active<?php } ?>" ><a data-toggle="dropdown"
						class="dropdown-toggle" href="#"><?php echo $this->lang->line('tools'); ?><b
							class="caret"></b> </a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url(); ?>admin/component/builder"><?php echo $this->lang->line('component_builder'); ?></a></li>
							<li><a href="<?php echo base_url(); ?>admin/component/groups"><?php echo $this->lang->line('groups'); ?></a></li>
							<li class="divider"></li>
							<li><a href="<?php echo base_url(); ?>admin/table/index"><?php echo $this->lang->line('table_builder'); ?></a></li>
							<li><a href="<?php echo base_url(); ?>admin/language/index"><?php echo $this->lang->line('language_manager'); ?></a></li>
						</ul>
					</li>
					<?php } ?>
					<?php if ($auth->isSettingManagement()){?>
					<li class="dropdown <?php if ($type == 'setting') { ?>active<?php } ?>"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown"><?php echo $this->lang->line('settings');?> <b class="caret"></b>
					</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url(); ?>admin/setting/index"><?php echo $this->lang->line('general')?></a></li>
							<li class="nav-header"><?php echo $this->lang->line('email_templates'); ?></li>
							<li><a href="<?php echo base_url(); ?>admin/setting/email/new_user"><?php echo $this->lang->line('new_user');?></a></li>
							<li><a href="<?php echo base_url(); ?>admin/setting/email/reset_password"><?php echo $this->lang->line('reset_password'); ?></a></li>
						</ul></li>
					<?php } ?>
				</ul>
            </div>
        </div>
    </div>
</div>
<script>
	function clickGroup(obj){
		
		//window.location = $(obj).parent().find('ul').find('a:first').attr('href');
	}
    $(document).ready(function(){
    	$('#mnu_component > ul > li').each(function(){
			if ($(this).hasClass('dropdown-submenu')){
				if ($(this).find('li').length <= 0){
					$(this).remove();
				}
			}
       });
        
       if ($('#mnu_component').children('ul').find('li').length <= 0){
           $('#mnu_component').hide();
       }else{
           $('#mnu_component').show();
       } 

    });

    //This will auto expand the selected <ul>. 
    $("#sub_item_<?php echo @$_GET['com_id']; ?>").parent().addClass('always-open');
    $("#sub_item_<?php echo @$_GET['com_id']; ?>").parent().css('display','block');
    $("#sub_item_<?php echo @$_GET['com_id']; ?>").parent().parent().addClass('active');
    $("#sub_item_<?php echo @$_GET['com_id']; ?>").addClass('active');
    //This will convert arrow left to arrow down
    $("#sub_item_<?php echo @$_GET['com_id']; ?>").parent().prev().children('span').eq(1).addClass('open');
</script>