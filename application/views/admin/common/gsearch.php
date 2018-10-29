			<div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="<?php echo base_url(); ?>">Dashboard</a><i class="fa fa-circle"></i>
                            </li>
                            <li class="active">
								 Search
							</li>
                        </ul>
                    </div>
                	<h3 class="page-title"> Global Search <small>search entire CRM</small></h3>
					<div class="row">
						<div class="col-md-12">
							<div class="portlet light bordered">
							<div class="portlet-body form">
						
							<h1>Searched for "<?php echo $search_key; ?>"</h1>
							<?php
							//echo "<pre>";print_r($module_data_full);exit;
							/*if (empty($module_data_full[0]['data'])) {
								echo 'No search results found.';
							}*/

							foreach ($module_data_full as  $m) {
								if (!empty($m['data'])) {
									$title = $m['title'];

									$keys = array();
									if (!empty($m)) {
										foreach ($m['data'][0] as $key => $value) {
											
									    	$keys[] =  $key;
									    }
									}
							?>
							<h3><?php echo $title; ?></h3>
							<table class="table table-striped table-hover">
								<thead>
							    	<tr>
										<?php
								        	$_a = 0;
								            foreach ($keys as  $key) {
									            //if ($_a != 0) {
								            	if(array_key_exists($m['table'].'.'.$key, $m['conf']['data_list'])){
													echo '<th>' .$m['conf']['data_list'][$m['table'].'.'.$key]['alias']. '</th>';
												}
												$_a = 1;
											}
										?>
							    	</tr>
								</thead>
								<tbody>
								<?php
								foreach ($m['data'] as $k => $moduel_data) {
								?>
									<tr><?php
										$_a = 0;
										foreach ($moduel_data as $field_key=>$field_val) {
											//if ($_a != 0) {
								            if(array_key_exists($m['table'].'.'.$field_key, $m['conf']['data_list'])){
												$tdvalue = str_ireplace( $search_key , '<span class="text-success"><b><i><a href="'.base_url().'admin/scrud/browse?com_id='.$m['comid'].'&xtype=view&key['.$m['table'].'.id]='.$moduel_data['id'].'">'.$search_key.'</a></i></b></span>' , $field_val );
												echo '<td>' . $tdvalue . '</td>';
											}
						                    $_a = 1;
						                }
						                ?>
						           </tr>
								<?php
								}
								?>
								</tbody>
							</table>
							<?php
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
