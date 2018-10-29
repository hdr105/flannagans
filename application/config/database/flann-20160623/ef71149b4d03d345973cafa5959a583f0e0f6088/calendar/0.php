<?php exit; ?>
{"section_name":"calendar_information","section_title":"Calendar Information","section_view":"accordion","section_size":"default","section_fields":{"assigned_to":{"field":"assigned_to","label":"Assigned To","type":"select","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"","db_options":{"table":"crud_users","key":"id","value":"user_name","column":"site_id","action":"=","condition":"site_id","customtext":"id!=1"},"list_choose":"database"},"subject":{"field":"subject","label":"Subject","type":"text","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty"},"date_start":{"field":"date_start","label":"Start Date","type":"date_simple","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"date"},"due_date":{"field":"due_date","label":"End Date","type":"date_simple","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"date"},"time_start":{"field":"time_start","label":"Start Time","type":"time","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":""},"time_end":{"field":"time_end","label":"End Time","type":"time","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":""},"activitytype":{"field":"activitytype","label":"Event Type","type":"select","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"","options":["Meeting","Call","Mobile Call"],"list_choose":"default"},"sendnotification":{"field":"sendnotification","label":"Send Notification","type":"radio","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"","values":["1","0"],"options":["Yes","No"]},"duration_hours":{"field":"duration_hours","label":"Duration (Hours)","type":"text","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":""},"duration_minutes":{"field":"duration_minutes","label":"Duration (Minutes)","type":"text","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":""},"status":{"field":"status","label":"Status","type":"select","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"","options":["Planned","Held","Not Held"],"list_choose":"default"},"priority":{"field":"priority","label":"Priority","type":"select","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"","options":["High","Low","Normal"],"list_choose":"default"},"location":{"field":"location","label":"Location","type":"text","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":""},"visibility":{"field":"visibility","label":"Visibility","type":"select","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"","options":["Public","Private"],"list_choose":"default"},"recurringtype":{"field":"recurringtype","label":"Recurring Type","type":"select","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"","options":["Daily","Weekly (Same Day as Created)","Fort Nightly( After Every 15 Days of First Event)","Monthly (Same Date as Created)"],"list_choose":"default"},"invite_calendars":{"field":"invite_calendars","label":"Calendars","type":"select","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"","db_options":{"table":"calendar_types","key":"id","value":"name"},"list_choose":"database","multiple":"multiple"}}}