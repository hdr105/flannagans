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
                                <span>Checklists Manager</span>
                            </li>
                        </ul>
                        <!--<div class="page-toolbar">
                            <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                                <i class="icon-calendar"></i>&nbsp;
                                <span class="thin uppercase hidden-xs"></span>&nbsp;
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </div>-->
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title">Checklists Manager</h3>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                    <?php echo $content; ?>  