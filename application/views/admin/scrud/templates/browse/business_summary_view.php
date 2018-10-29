<div id="summary_view_container">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
            <?=$business_name?>
            </div>
        </div>
        <div class="portlet-body">

            <div >
                 <table class="table table-striped table-bordered table-hover ">
                    <tbody>
                       
                        <tr>
                            <td style="width:50%"><strong>Open Jobs</strong> : <?=$open_jobs?></td>
                        
                           <td><strong>Closed Jobs</strong> : <?=$close_jobs?></td>
                       </tr>

                       <tr>
                           <td><strong>In-Progress Job</strong> : <?=$in_progress?></td>
                       
                           <td><strong>On-Hold Jobs</strong> : <?=$on_hold?></td>
                       </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
            Business Fee
            </div>
        </div>
        <div class="portlet-body">

            <div >
                 <table class="table table-striped table-bordered table-hover ">
                    <tbody>

                       <tr>
                           <td style="width:50%"><strong>Fee</strong> : <?php echo $currency_symbol." "; if($business_fee['Agreed_Fee']){ echo $business_fee['Agreed_Fee']; }else{ echo '0'; }?></td>

                           <td><strong>Status</strong> : <?php 
                                if($business_fee['Fee_Status']==0)
                                    echo 'Unpaid';
                                else if($business_fee['Fee_Status']==1)
                                    echo 'Paid';
                                else
                                    echo '';

                           ?></td>
                       </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php if( count($business_d_info)>0){?>

    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
            Important Dates
            </div>
        </div>
        <div class="portlet-body">

            <div >
                 <table class="table table-striped table-bordered table-hover ">
                    <tbody>
                       
                        <?php $counter=0;?>
                        
                        <?php foreach ($business_d_info as $v):?>
                            <?php if($v[0]=='0000-00-00' || is_null($v[0])){
                                    
                                    continue;
                                }?>
                            <?php if($counter%2==0){
                                echo "<tr>";
                            }?>
                            <td style="width:35%"><strong><?=$v[1]?></strong></td>
                            <td style="width:15%"><?=date("d-m-Y",strtotime($v[0]))?></td>
                        <?php if($counter%2==1){
                                    echo "</tr>";
                                }?>                        
                        <?php $counter++;?>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } ?>

<?php if( isset($contact_info['contacts'][0])){?>

    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
            Contact
            </div>
        </div>
        <div class="portlet-body">

            <div >
                 <table class="table table-striped table-bordered table-hover ">
                    <tbody>
                       
                        <?php if( $contact_info['com_id']==41):?>
                                <tr>
                            <?php if(isset($contact_info['contacts'][0]['First_Name']) && $contact_info['contacts'][0]['First_Name']!= ""):?>
                                <td style="width:50%"><strong>Contact Name</strong>
                                :
                                <?php echo $contact_info['contacts'][0]['First_Name']." ". $contact_info['contacts'][0]['Last_Name'] ; ?>
                                </td>
                                
                            <?php endif;?>
                            <?php if(isset($contact_info['contacts'][0]['Office_Phone']) && $contact_info['contacts'][0]['Office_Phone']!= ""):?>
                                    <td style="width:50%"><strong>Contact Telephone</strong>
                                    :
                                     <?=$contact_info['contacts'][0]['Office_Phone']?></td>
                            <?php endif;?>

                                </tr>
                        <?php endif; ?>
                    <?php $com_id = $contact_info['com_id'];?>
                    <?php if($com_id==42||$com_id==43||$com_id==44):?>
                            <?php $n=0;?>
                            <?php foreach($contact_info['contacts'] as $contact_inf):?>
                                    <?php if($n%2==0){
                                    echo "<tr>";
                                    }?>
                                <?php if((isset($contact_inf['First_Name']) && $contact_inf['First_Name']!= "") or (isset($contact_inf['Last_Name']) && $contact_inf['Last_Name']!= "")):?>
                                        <td style="width:50%">
                                        <strong>Partner Name </strong>
                                        :
                                        <?php echo $contact_inf['First_Name']." ". $contact_inf['Last_Name'] ; ?>
                                        </td>
                                    
                                <?php endif;?>
                                <?php if(isset($contact_inf['Office_Phone']) && $contact_inf['Office_Phone']!= ""):?>

                                        <td style="width:50%"> <strong>Partner Telephone</strong> 
                                        :
                                         <?=$contact_inf['Office_Phone']?></td>

                                <?php endif;?>
                            <?php $n++;?>
                                    <?php if($n%2==1){
                                    echo "</tr>";
                                    }?>
                            <?php endforeach;?>

                    <?php endif;?>
                    <?php if($com_id==45):?>
                            <?php $m=0;?>
                            <?php foreach($contact_info['contacts'] as $contact_inf):?>
                                 <?php if(isset($contact_inf['First_Name']) &&
                                    $contact_inf['First_Name']!= ""):?>
                                        <?php if($m%2==0){
                                        echo "<tr>";
                                        }?>
                                        <td style="width:50%">
                                        <strong>Trustee Name </strong>
                                        :
                                        <?php echo $contact_inf['First_Name']." ". $contact_inf['Last_Name'] ; ?>
                                        </td>
                                        
                                <?php endif;?>
                                <?php if(isset($contact_inf['Office_Phone']) &&
                                    $contact_inf['Office_Phone']!= ""):?>
                                
                                    <td style="width:50%"> <strong>Trustee Telphone</strong> 
                                    :
                                     <?=$contact_inf['Office_Phone']?></td>

                                    <?php if($m%2==1){
                                        echo "</tr>";
                                        }?>
                        <?php endif;?>
                            <?php $m++;?>
                            <?php endforeach;?>
                    <?php endif;?>
                        

                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } ?>
</div>
