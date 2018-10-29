<?php $CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); ?>
<!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="<?php echo base_url(); ?>">
                        <img src="<?php echo base_url(); ?>media/assets/layouts/layout/img/logo.png" alt="logo" class="logo-default" /> </a>
                    <div class="menu-toggler sidebar-toggler"> </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN NOTIFICATION DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <i class="icon-bell"></i>
                                <span class="badge badge-default"> 7 </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="external">
                                    <h3>
                                        <span class="bold">12 pending</span> notifications</h3>
                                    <a href="page_user_profile_1.html">view all</a>
                                </li>
                                <li>
                                    <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">just now</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-success">
                                                        <i class="fa fa-plus"></i>
                                                    </span> New user registered. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">3 mins</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span> Server #12 overloaded. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">10 mins</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-warning">
                                                        <i class="fa fa-bell-o"></i>
                                                    </span> Server #2 not responding. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">14 hrs</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </span> Application error. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">2 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span> Database overloaded 68%. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">3 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span> A user IP blocked. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">4 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-warning">
                                                        <i class="fa fa-bell-o"></i>
                                                    </span> Storage Server #4 not responding dfdfdfd. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">5 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </span> System Error. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">9 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span> Storage server failed. </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!-- END NOTIFICATION DROPDOWN -->
                        <!-- BEGIN INBOX DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <i class="icon-envelope-open"></i>
                                <span class="badge badge-default"> 4 </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="external">
                                    <h3>You have
                                        <span class="bold">7 New</span> Messages</h3>
                                    <a href="app_inbox.html">view all</a>
                                </li>
                                <li>
                                    <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                        <li>
                                            <a href="#">
                                                <span class="photo">
                                                    <img src="<?php echo base_url(); ?>media/assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> Lisa Wong </span>
                                                    <span class="time">Just Now </span>
                                                </span>
                                                <span class="message"> Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="photo">
                                                    <img src="<?php echo base_url(); ?>media/assets/layouts/layout3/img/avatar3.jpg" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> Richard Doe </span>
                                                    <span class="time">16 mins </span>
                                                </span>
                                                <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="photo">
                                                    <img src="<?php echo base_url(); ?>media/assets/layouts/layout3/img/avatar1.jpg" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> Bob Nilson </span>
                                                    <span class="time">2 hrs </span>
                                                </span>
                                                <span class="message"> Vivamus sed nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="photo">
                                                    <img src="<?php echo base_url(); ?>media/assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> Lisa Wong </span>
                                                    <span class="time">40 mins </span>
                                                </span>
                                                <span class="message"> Vivamus sed auctor 40% nibh congue nibh... </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="photo">
                                                    <img src="<?php echo base_url(); ?>media/assets/layouts/layout3/img/avatar3.jpg" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> Richard Doe </span>
                                                    <span class="time">46 mins </span>
                                                </span>
                                                <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!-- END INBOX DROPDOWN -->
                        <!-- BEGIN TODO DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-extended dropdown-tasks" id="header_task_bar">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <i class="icon-calendar"></i>
                                <span class="badge badge-default"> 3 </span>
                            </a>
                            <ul class="dropdown-menu extended tasks">
                                <li class="external">
                                    <h3>You have
                                        <span class="bold">12 pending</span> tasks</h3>
                                    <a href="app_todo.html">view all</a>
                                </li>
                                <li>
                                    <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                        <li>
                                            <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">New release v1.2 </span>
                                                    <span class="percent">30%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 40%;" class="progress-bar progress-bar-success" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">40% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">Application deployment</span>
                                                    <span class="percent">65%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 65%;" class="progress-bar progress-bar-danger" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">65% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">Mobile app release</span>
                                                    <span class="percent">98%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 98%;" class="progress-bar progress-bar-success" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">98% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">Database migration</span>
                                                    <span class="percent">10%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 10%;" class="progress-bar progress-bar-warning" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">10% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">Web server upgrade</span>
                                                    <span class="percent">58%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 58%;" class="progress-bar progress-bar-info" aria-valuenow="58" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">58% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">Mobile development</span>
                                                    <span class="percent">85%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 85%;" class="progress-bar progress-bar-success" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">85% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">New UI release</span>
                                                    <span class="percent">38%</span>
                                                </span>
                                                <span class="progress progress-striped">
                                                    <span style="width: 38%;" class="progress-bar progress-bar-important" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">38% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!-- END TODO DROPDOWN -->
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle" src="<?php echo base_url(); ?>media/assets/layouts/layout/img/avatar3_small.jpg" />
                                <span class="username username-hide-on-mobile"> Nick </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="page_user_profile_1.html">
                                        <i class="icon-user"></i> My Profile </a>
                                </li>
                                <li>
                                    <a href="app_calendar.html">
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
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="page_user_lock_1.html">
                                        <i class="icon-lock"></i> Lock Screen </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/logout">
                                        <i class="icon-key"></i> Log Out </a>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-quick-sidebar-toggler">
                            <a href="javascript:;" class="dropdown-toggle">
                                <i class="icon-logout"></i>
                            </a>
                        </li>
                        <!-- END QUICK SIDEBAR TOGGLER -->
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
<div class="page-sidebar-wrapper">
	<div class="page-sidebar navbar-collapse collapse">
		<ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
			<li class="sidebar-toggler-wrapper hide">
            	<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler"> </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            <li class="sidebar-search-wrapper">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                	<a href="javascript:;" class="remove">
                    	<i class="icon-close"></i>
                    </a>
                    <div class="input-group">
	                    <input type="text" class="form-control" placeholder="Search...">
	                    <span class="input-group-btn">
	                    	<a href="javascript:;" class="btn submit">
	                        	<i class="icon-magnifier"></i>
	                        </a>
	                    </span>
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            <li class="nav-item start <?php if ($type == 'dashboard') { ?>active open<?php } ?>">
                <a href="<?php echo base_url(); ?>admin/dashboard" class="nav-link nav-toggle">
                	<i class="icon-home"></i>
                    <span class="title"><?php echo $this->lang->line('main'); ?></span>
                    <span class="selected"></span>
                    
                </a>
			</li>
			<?php if ((int) $CRUD_AUTH['group']['group_manage_flag'] == 1 || 
		                    (int) $CRUD_AUTH['group']['group_manage_flag'] == 3 ||
		                    (int) $CRUD_AUTH['user_manage_flag'] == 1 ||
		                    (int) $CRUD_AUTH['user_manage_flag'] == 3) { ?>
                        <li class="nav-item <?php if ($type == 'user') { ?>active open<?php } ?>">
                        	<a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-user"></i>
                                <span class="title"><?php echo $this->lang->line('users'); ?></span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item"><a href="<?php echo base_url(); ?>admin/user/user" class="nav-link "><span class="title"><?php echo $this->lang->line('user_manager');?></span></a></li>
                                <li class="nav-item"><a href="<?php echo base_url(); ?>admin/user/group" class="nav-link "><span class="title"><?php echo $this->lang->line('groups');?></span></a></li>
                                <li class="nav-item"><a href="<?php echo base_url(); ?>admin/user/permission" class="nav-link "><span class="title"><?php echo $this->lang->line('permissions');?></span></a></li>
                            </ul>
                        </li>
            <?php }
            	//http://themindunleashed.org/2014/09/new-evidence-lost-civilizations-really-existed.html
            ?>
            			<li class="nav-item  <?php if ($type == 'component') { ?>active<?php } ?> " id="mnu_component">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-puzzle"></i>
                                <span class="title"><?php echo $this->lang->line('components'); ?></span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
	                            <?php foreach ($mnuGroup as $v){
									if (empty($v['coms'])) continue;
									?>
									<li class="nav-item">
										
										<a href="javascript:;" tabindex="-1" onclick="clickGroup(this); return false;" class="nav-link nav-toggle">
	                                        <i class="icon-check"></i>
	                                        <span class="title"><?php echo $v['name'];?></span>
	                                        <span class="arrow"></span>
                                    	</a>
										<ul class="sub-menu">
											<?php foreach ($v['coms'] as $com){
												$permissions = $auth->getPermissionType($com['id']);
												if (!in_array(4, $permissions)) continue;
												?>
											<li class="nav-item"><a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=<?php echo $com['id']; ?>" class="nav-link "><?php echo $com['component_name']?></a></li>
											<?php } ?>
										</ul>
									</li>
								<?php } ?>
	                            <?php foreach ($coms as $com){
									if (in_array($com['id'], $exComs)) continue;
									$permissions = $auth->getPermissionType($com['id']);
									if (!in_array(4, $permissions)) continue;
								?>
								<li class="nav-item  "><a href="<?php echo base_url(); ?>admin/scrud/browse?com_id=<?php echo $com['id']; ?>" class="nav-link "><span class="title"><?php echo $com['component_name']?></span></a></li>
								<?php }?>
                            </ul>
                        </li>
            <?php if ((int) $CRUD_AUTH['group']['group_manage_flag'] == 2 || 
		                    (int) $CRUD_AUTH['group']['group_manage_flag'] == 3 ||
		                    (int) $CRUD_AUTH['user_manage_flag'] == 2 ||
		                    (int) $CRUD_AUTH['user_manage_flag'] == 3) { ?>
					<li class="nav-item   <?php if ($type == 'tool') { ?>active open<?php } ?>" ><a 
						class="nav-link nav-toggle" href="javascript:;">
							<i class="icon-wrench"></i>
                            <span class="title"><?php echo $this->lang->line('tools'); ?></span>
                            <span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  "><a href="<?php echo base_url(); ?>admin/component/builder"  class="nav-link "><?php echo $this->lang->line('component_builder'); ?></a></li>
							<li class="nav-item  "><a href="<?php echo base_url(); ?>admin/component/groups"  class="nav-link "><?php echo $this->lang->line('groups'); ?></a></li>
							<li class="divider"></li>
							<li class="nav-item  "><a href="<?php echo base_url(); ?>index.php/admin/table/index"  class="nav-link "><?php echo $this->lang->line('table_builder'); ?></a></li>
							<li class="nav-item  "><a href="<?php echo base_url(); ?>index.php/admin/language/index"  class="nav-link "><?php echo $this->lang->line('language_manager'); ?></a></li>
						</ul>
					</li>
					<?php } ?>
					<?php if ($auth->isSettingManagement()){?>
					<li class="nav-item  <?php if ($type == 'setting') { ?>active<?php } ?>">
						<a class="nav-link nav-toggle" href="javascript:;">
							<i class="icon-settings"></i>
                            <span class="title"><?php echo $this->lang->line('settings');?></span>
                            <span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item "><a href="<?php echo base_url(); ?>index.php/admin/setting/index"  class="nav-link "><span class="title"><?php echo $this->lang->line('general')?></span></a></li>
							<li class="heading"><a href="javascript:;" class="uppercase nav-link"><?php echo $this->lang->line('email_templates'); ?></a></li>
							<li class="nav-item "><a href="<?php echo base_url(); ?>index.php/admin/setting/email/new_user"  class="nav-link "><span class="title"><?php echo $this->lang->line('new_user');?></span></a></li>
							<li class="nav-item "><a href="<?php echo base_url(); ?>index.php/admin/setting/email/reset_password"  class="nav-link "><span class="title"><?php echo $this->lang->line('reset_password'); ?></span></a></li>
						</ul></li>
					<?php } ?>
		</ul>
	</div>
</div>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container"><a class="btn btn-navbar"
                                  data-toggle="collapse" data-target=".nav-collapse"> <span
                    class="icon-bar"></span> <span class="icon-bar"></span> <span
                    class="icon-bar"></span> </a> <a class="brand" href="<?php echo base_url(); ?>index.php/admin/dashboard"><?php echo $this->lang->line('codeigniter_admin_pro'); ?></a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li <?php if ($type == 'dashboard') { ?>class="active"<?php } ?>><a href="<?php echo base_url(); ?>index.php/admin/dashboard"><?php echo $this->lang->line('main'); ?></a></li>
                    <?php if ((int) $CRUD_AUTH['group']['group_manage_flag'] == 1 || 
		                    (int) $CRUD_AUTH['group']['group_manage_flag'] == 3 ||
		                    (int) $CRUD_AUTH['user_manage_flag'] == 1 ||
		                    (int) $CRUD_AUTH['user_manage_flag'] == 3) { ?>
                        <li class="dropdown <?php if ($type == 'user') { ?>active<?php } ?>">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $this->lang->line('users'); ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url(); ?>index.php/admin/user/user"><?php echo $this->lang->line('user_manager');?></a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/admin/user/group"><?php echo $this->lang->line('groups');?></a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/admin/user/permission"><?php echo $this->lang->line('permissions');?></a></li>
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
									<li><a href="<?php echo base_url(); ?>index.php/admin/scrud/browse?com_id=<?php echo $com['id']; ?>"><?php echo $com['component_name']?></a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
							<?php foreach ($coms as $com){
								if (in_array($com['id'], $exComs)) continue;
								$permissions = $auth->getPermissionType($com['id']);
								if (!in_array(4, $permissions)) continue;
							?>
							<li><a href="<?php echo base_url(); ?>index.php/admin/scrud/browse?com_id=<?php echo $com['id']; ?>"><?php echo $com['component_name']?></a></li>
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
							<li><a href="<?php echo base_url(); ?>index.php/admin/component/builder"><?php echo $this->lang->line('component_builder'); ?></a></li>
							<li><a href="<?php echo base_url(); ?>index.php/admin/component/groups"><?php echo $this->lang->line('groups'); ?></a></li>
							<li class="divider"></li>
							<li><a href="<?php echo base_url(); ?>index.php/admin/table/index"><?php echo $this->lang->line('table_builder'); ?></a></li>
							<li><a href="<?php echo base_url(); ?>index.php/admin/language/index"><?php echo $this->lang->line('language_manager'); ?></a></li>
						</ul>
					</li>
					<?php } ?>
					<?php if ($auth->isSettingManagement()){?>
					<li class="dropdown <?php if ($type == 'setting') { ?>active<?php } ?>"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown"><?php echo $this->lang->line('settings');?> <b class="caret"></b>
					</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url(); ?>index.php/admin/setting/index"><?php echo $this->lang->line('general')?></a></li>
							<li class="nav-header"><?php echo $this->lang->line('email_templates'); ?></li>
							<li><a href="<?php echo base_url(); ?>index.php/admin/setting/email/new_user"><?php echo $this->lang->line('new_user');?></a></li>
							<li><a href="<?php echo base_url(); ?>index.php/admin/setting/email/reset_password"><?php echo $this->lang->line('reset_password'); ?></a></li>
						</ul></li>
					<?php } ?>
				</ul>
                <ul class="nav pull-right">
                    <!-- <li class="divider-vertical"></li> -->
                    <li class="dropdown   <?php if ($type == 'account') { ?>active<?php } ?>">
                        <a class=" dropdown-toggle" data-toggle="dropdown" href="#" > &nbsp;  <i class="icon icon-user"></i>&nbsp; <?php echo $CRUD_AUTH['user_name']; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        	<?php if ($auth->isSettingManagement()){?>
							<li><a href="<?php echo base_url(); ?>index.php/admin/setting/index"> <i class="icon-cog"></i> <?php echo $this->lang->line('settings');?></a></li>
							<?php } ?>
                            <?php if ($CRUD_AUTH['group']['group_name'] != 'SystemAdmin') { ?>
                                <li><a href="<?php echo base_url(); ?>index.php/user/editprofile"> <i class="icon-user"></i> <?php echo $this->lang->line('edit_profile');?></a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/user/changepassword"> <i class="icon-pencil"></i> <?php echo $this->lang->line('change_password');?></a></li>
                                <li class="divider"></li>
                            <?php } ?>
                            <li><a href="<?php echo base_url(); ?>index.php/admin/logout"> <i class="icon-minus-sign"></i> <?php echo $this->lang->line('log_out');?></a></li>
                        </ul>
                    </li>
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
</script>