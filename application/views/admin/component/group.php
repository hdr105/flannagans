<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('main'); ?></a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span><?php echo $this->lang->line('tool_group_component');?></span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title"><?php echo $this->lang->line('tool_group_component');?></h3>
        <!-- END PAGE TITLE-->
         <!-- END PAGE HEADER-->
         <?php echo $content; ?>  
