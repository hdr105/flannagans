<?php 
$CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); 
global $date_format_convert;
$this_user_id = $CRUD_AUTH['id'];

$postdata = http_build_query(
	array(
        'operation' => 'open_Tax',
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
			<i class="icon-clock font-red"></i>
			<span class="caption-subject font-red bold uppercase">Taxation Dates</span>
		</div>
	</div>
	<div class="portlet-body">
		<div class="table-scrollable table-scrollable-borderless">
			<table class="table table-hover table-light">
				<thead>
					<tr class="uppercase">
						<th> Tax Date </th>
						<th> Due Date </th>
					</tr>
				</thead>
				<tbody>
					<?php if($r->result == 'No Tax'){ ?>
						<tr>
							<td colspan="2"> <?php echo $r->result; ?> </td>
						</tr>
					<?php } else { ?>
						<tr>
							<?php foreach($r->result as $key=>$value){ ?>
								<?php if($key == 'tax_year_date' or $key == 'due_date'){ ?>
									<td> <?php if($value=='0000-00-00'){ echo " "; }else{ echo date('d-m-Y', strtotime($value)); } ?> </td>
								<?php } ?>
							<?php } ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>