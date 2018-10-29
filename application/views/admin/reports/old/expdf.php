
							<table class="table table-striped table-bordered table-hover table-condensed flip-content" >
							<?php
								if (!empty($fields_lbs)) {
									?>
										<tr>
											<?php
												foreach ($fields_lbs as $lk => $lv) {
													echo '<th>' . $lv . '</th>';
												}
											?>	
										</tr>
									<?php
								}


								if (!empty($data)) {
									foreach ($data as $dk => $dv) {
										echo '<tr>';
										foreach ($dv as $key => $value) {
											echo '<td>' . $value . '</td>';
										}
										echo '</tr>';
									}
								}
							?>
							</table>
						