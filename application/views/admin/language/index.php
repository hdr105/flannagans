<?php // echo "<pre>";print_r($this->lang);exit;?>
<?php $CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); ?>
  
           <div class="page-content-wrapper">
              
               <div class="page-content">
                  
                   <div class="page-bar">
                       <ul class="page-breadcrumb">
                           <li>
                               <a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('main'); ?></a>
                               <i class="fa fa-circle"></i>
                           </li>
                           <li>
                               <span><?php echo $this->lang->line('tool_language_manager');?></span>
                           </li>
                       </ul>
                     
                   </div>
                    
                   <h3 class="page-title"><?php echo $this->lang->line('tool_language_manager');?><?php //echo $this->lang->line('components');?></h3>
                    
                   <?php echo $content; ?>

 				</div>
 			</div>
      </div>
        <?php echo $main_footer;?>