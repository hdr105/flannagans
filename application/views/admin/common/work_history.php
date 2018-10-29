												<?php 
												if (isset($permissions) && $permissions == 1){
													$user = ' AND t.site_id="'.$CRUD_AUTH['site_id'].'"';
													if(isset($_POST['users_filter']) && !empty($_POST['users_filter'])){
														$user .= ' AND user_id ="'.$_POST['users_filter'].'"';
													}
												} else {
													$user = 'AND user_id="'.$CRUD_AUTH['id'].'"';
												}
												?>
												<div class="panel-body">
													<div class="row">
														<table class="table table-striped table-bordered table-hover" id="sample_2">
															<thead>
																<tr id="filterrow">
																	<td></td>
																	<th style="width:150px">Date</th>
																	<?php if(isset($permissions) && $permissions == 1){ ?>
																		<th>User</th>
																	<?php } ?>
																	<th>Working</th>
																	<th>Lunch</th>
																	<th>Break</th>
																	<th>Meeting</th>
																	<th>Total</th>
																</tr>
																<tr>
																	<th>Sr.</th>
																	<th style="width:150px">Date</th>
																	<?php if(isset($permissions) && $permissions == 1){ ?>
																		<th>User</th>
																	<?php } ?>
																	<th>Working</th>
																	<th>Lunch</th>
																	<th>Break</th>
																	<th>Meeting</th>
																	<th>Total</th>
																</tr>
															</thead>
															<tbody>
															<?php
																if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
																	if(!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])){
																		function returnDates($fromdate, $todate) {
																			$fromdate = \DateTime::createFromFormat('d-m-Y', $fromdate);
																			$todate = \DateTime::createFromFormat('d-m-Y', $todate);
																			return new \DatePeriod(
																				$fromdate,
																				new \DateInterval('P1D'),
																				$todate->modify('+1 day')
																			);
																		}

																		$datePeriod = returnDates($_REQUEST['date_from'], $_REQUEST['date_to']);
																		foreach($datePeriod as $date) {
																			$dates[] = $date->format('Y-m-d');
																		}
																	} else {
																		for($i = date('d'); $i >= 1; $i--){
																			$dates[] = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
																		}
																	}
																	
																} else {
																	for($i = date('d'); $i >= 1; $i--){
																	   $dates[] = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
																	}
																}
																	
																$count = 0;
																foreach($dates as $date){
																	$result_working = $this->db->query("select u.user_name, sum(case when status = 'working' then time_spent else 0 end) as working_time, sum(case when status = 'lunch' then time_spent else 0 end) as lunch_time, sum(case when status = 'break' then time_spent else 0 end) as break_time, sum(case when status = 'meeting' then time_spent else 0 end) as meeting_time from crud_users as u left join users_work_log as t on u.id = t.user_id WHERE time_start != '00:00:00' AND dated='".$date."' AND u.group_id NOT IN (1,5) ".$user ." group by u.user_name");
																	foreach($result_working->result_array() as $results){
																		$count++;
																		$total_time = $results['working_time'] + $results['lunch_time'] + $results['break_time'];
																		if(isset($permissions) && $permissions == 1){
																			echo "<tr><td>".$count."</td><td>".date('d-m-Y',strtotime($date))."</td><td>".$results['user_name']."</td><td>".gmdate("H:i:s", $results['working_time'] - $results['meeting_time'])."</td><td>".gmdate("H:i:s", $results['lunch_time'])."</td><td>".gmdate("H:i:s", $results['break_time'])."</td><td>".gmdate("H:i:s", $results['meeting_time'])."</td><td>".gmdate("H:i:s", $total_time)."</td></tr>";
																		} else {
																			echo "<tr><td>".$count."</td><td>".date('d-m-Y',strtotime($date))."</td><td>".gmdate("H:i:s", $results['working_time'] - $results['meeting_time'])."</td><td>".gmdate("H:i:s", $results['lunch_time'])."</td><td>".gmdate("H:i:s", $results['break_time'])."</td><td>".gmdate("H:i:s", $results['meeting_time'])."</td><td>".gmdate("H:i:s", $total_time)."</td></tr>";
																		}
																	}
																}
															?>
															</tbody>
                                    					</table>
													</div>
													<div class="clearfix"></div>
												</div>