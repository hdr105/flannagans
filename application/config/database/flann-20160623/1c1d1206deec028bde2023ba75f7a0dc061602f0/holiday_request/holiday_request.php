<?php exit; ?>
{"table":{"crudTitle":"Holiday Requests","crudRowsPerPage":"2000"},"filter":{"list":["id","Title","Start_Date","End_Date","Current_Job","Job_Deadline","Status","site_id","eventsfor","assigned_to","holiday_requestno"],"atrr":{"Start_Date":{"alias":"Start Date"},"End_Date":{"alias":"End Date"},"Current_Job":{"alias":"Current Job"},"id":{"alias":"id"},"assigned_to":{"alias":"User"}},"actived":["Title","Start_Date","End_Date","assigned_to"]},"column":{"list":["id","assigned_to","Title","Start_Date","End_Date","Current_Job","Job_Deadline","Status","site_id","eventsfor","holiday_requestno","crud_users.id","crud_users.group_id","crud_users.user_name","crud_users.user_password","crud_users.user_email","crud_users.user_first_name","crud_users.user_las_name","crud_users.user_info","crud_users.user_code","crud_users.user_status","crud_users.user_manage_flag","crud_users.user_setting_management","crud_users.user_global_access","crud_users.site_id","crud_users.line_manager","crud_users.emp_start_date","crud_users.emp_end_date","crud_users.holidays_entitlement","crud_users.holidays_start_date","crud_users.holidays_end_date","crud_users.working_hours","crud_users.additional_entitlements","crud_users.notes","crud_users.contract_file","crud_users.emp_type","crud_users.ni_no","crud_users.tax_id","crud_users.id_doc_type","crud_users.profile_image","crud_users.id_expiry_date","crud_users.eventsfor","crud_users.created_by","crud_users.created","crud_users.modified_by","crud_users.modified","crud_users.assigned_to","crud_users.crud_usersno","crud_users.[object Object]"],"atrr":{"Start_Date":{"alias":"Start Date"},"End_Date":{"alias":"End Date"},"Current_Job":{"alias":"Current Job"},"id":{"alias":"id"},"Job_Deadline":{"alias":"Job Deadline"},"assigned_to":{"alias":"User"},"crud_users.holidays_entitlement":{"alias":"Available Holidays"}},"actived":["assigned_to","Title","Start_Date","End_Date","Status","crud_users.holidays_entitlement"]},"quickcreate":{"list":["id","Title","Start_Date","End_Date","Current_Job","Job_Deadline","Status","site_id","eventsfor","assigned_to","holiday_requestno"]},"massedit":{"list":["id","Title","Start_Date","End_Date","Current_Job","Job_Deadline","Status","site_id","eventsfor","assigned_to","holiday_requestno"],"actived":["Status"],"atrr":{"Job_Deadline":{"alias":"Job_Deadline"}}},"summary":{"list":["id","Title","Start_Date","End_Date","Current_Job","Job_Deadline","Status","site_id","eventsfor","assigned_to","holiday_requestno"]},"frm_type":"2","ids":["assigned_to","Title","Start_Date","End_Date","Status"],"ids2":[["assigned_to","Title","Start_Date","End_Date","Status"]],"sections":"0","join":[{"type":"INNER","table":"crud_users","currentField":"holiday_request.assigned_to","targetField":"crud_users.id"}]}