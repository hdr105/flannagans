        <!-- BEGIN CONTENT -->
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
                            <?php 
                            $c_id=$_GET['com_id'];
                            if(isset($_GET['key']['business.id'])){
                                $this->db->select('title');
                                $this->db->from('business');
                                $this->db->where('id',$_GET['key']['business.id']);
                                $query = $this->db->get();
                                $busi = $query->row_array();
                                $this->session->set_userdata('bus_name',$busi['title']);
                                $_GET['bname']=$this->session->userdata('bus_name');
                            }

                            if($c_id==65){ 
                            ?>
                            <li>
                                <a href="<?="?com_id=".$c_id ?>"><?php echo $this->lang->line('user_manager');?></a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <?php 
                            }
                            ?>
                            <li>
                            <?php
                                if($c_id==58 or $c_id==62 or $c_id==63 or $c_id==64 or $c_id==70 or $c_id==74){
                                    $_GET['bname']=$this->session->userdata('bus_name');
                            ?>
                                <a href="<?="?com_id=".$this->session->userdata('comid'); ?>"><?=$this->session->userdata('com_name') ?></a>
                            <?php
                                }else{
                            ?>
                                <?php if(isset($_GET['xtype']) and $_GET['xtype']!='index'){ ?><a href="<?="?com_id=".$c_id ?>"><?=$conf['title'] ?></a><?php }else{ ?><span><?=$conf['title'] ?></span><?php } ?>
                            <?php
                                }
                            if(isset($_GET['bname']) and $_GET['bname']!=''){
                            ?>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span><?=ucwords($_GET['bname'])?></span>
                            <?php
                            }

                            if(isset($_GET['xtype']) and $_GET['xtype']=='form' and isset($_GET['key'])){
                            ?>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Edit <?php if($c_id==25 or $c_id==80){ ?>Event<?php }else{ ?>Record<?php } ?></span>
                            <?php
                            }elseif(isset($_GET['xtype']) and $_GET['xtype']=='form' and !isset($_GET['key'])){
                            ?>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Add <?php if($c_id==25 or $c_id==80){ ?>Event<?php }else{ ?>Record<?php } ?></span>
                            <?php
                            }elseif(isset($_GET['xtype']) and $_GET['xtype']=='view'){
                            ?>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>View <?php if($c_id==25 or $c_id==80){ ?>Event<?php }else{ ?>Record<?php } ?></span>
                            <?php
                            }elseif(isset($_GET['xtype']) and $_GET['xtype']=='delconfirm'){
                            ?>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Delete <?php if($c_id==25 or $c_id==80){ ?>Event<?php }else{ ?>Record<?php } ?></span>
                            <?php
                            }
                            ?>
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
                        <div class="pull-left">
                            <h3 class="page-title"> <?php echo $conf['title']; ?></h3>
                        </div>
                        <?php 
                        if($conf['title']=='Request A Holiday'){ 
                            $rs=$this->db->query("SELECT Available_Holidays FROM crud_users WHERE id=".$this->session->userdata('CRUD_AUTH')['id']);
                            $row=$rs->result_array();
                        ?>
                        <div class="pull-right">
                            <h5 style="padding-top:30px;"><strong> Available Holidays:</strong> <?=$row[0]['Available_Holidays']?></h5>
                        </div>
                        <?php } ?>
                        <div class="clearfix"></div>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
					<?php echo $content; ?>
