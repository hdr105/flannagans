<?php 
$CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); 
global $date_format_convert;
$this_user_id = $CRUD_AUTH['id'];

$postdata = http_build_query(
	array(
        'operation' => 'open_services',
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
			<i class="icon-wrench font-red"></i>
			<span class="caption-subject font-red bold uppercase">Services</span>
		</div>
	</div>
	<div class="portlet-body">
		<div class="slimScrollDiv">
			<div class="scroller">
				<ul class="feeds">
				<?php if($r->result == 'No Services'){ ?>
					<li>
						<div class="col1">
							<div class="cont">
								<div class="cont-col1">
									<div class="label label-sm label-danger">
										<i class="fa fa-times"></i>
									</div>
								</div>
								<div class="cont-col2">
									<div class="desc"> No Services </div>
								</div>
							</div>
						</div>
					</li>
				<?php } else { ?>
					<?php foreach($r->result as $data){ ?>
					<li>
						<div class="col1">
							<div class="cont">
								<div class="cont-col1">
									<div class="label label-sm label-success">
										<i class="fa fa-check"></i>
									</div>
								</div>
								<div class="cont-col2">
									<div class="desc">
										<?php 
											if($data->service_id == '1'){ 
												echo 'Accounts';
											} else if($data->service_id == '2'){ 
												echo 'Annual Return';
											} else if($data->service_id == '3'){ 
												echo 'VAT';
											} else if($data->service_id == '4'){ 
												echo 'TAX';
											} else if($data->service_id == '5'){ 
												echo 'Payroll';
											}
										?>
									</div>
								</div>
							</div>
						</div>
					</li>
					<?php } ?>
				<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>