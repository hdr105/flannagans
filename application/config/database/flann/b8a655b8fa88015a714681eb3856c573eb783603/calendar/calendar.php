<?php exit; ?>
{"table":{"crudTitle":"My Calendar","crudRowsPerPage":"50","crudOrderField":"subject","crudOrderType":"asc"},"filter":{"list":["id","subject","related_module","activitytype","date_start","due_date","time_start","time_end","sendnotification","duration_hours","duration_minutes","status","eventstatus","priority","location","notime","visibility","recurringtype","invite_calendars","color","eventsfor","assigned_to","calendarno","parentid","site_id"],"atrr":{"subject":{"alias":"Subject"},"assigned_to":{"alias":"Assigned To"},"activitytype":{"alias":"Event Type"},"date_start":{"alias":"Start Date"},"due_date":{"alias":"End Date"},"time_start":{"alias":"Start Time"},"time_end":{"alias":"End Time"},"sendnotification":{"alias":"Send Notification"},"duration_hours":{"alias":"Duration (Hours)"},"duration_minutes":{"alias":"Duration (Minutes)"},"status":{"alias":"Status"},"priority":{"alias":"Priority"},"location":{"alias":"Location"},"visibility":{"alias":"Visibility"},"recurringtype":{"alias":"Recurring Type"},"invite_calendars":{"alias":"Invited To"},"id":{"alias":"id"}},"actived":["subject","date_start","due_date","time_start","time_end","duration_hours","duration_minutes","status"]},"column":{"list":["id","subject","related_module","activitytype","date_start","due_date","time_start","time_end","sendnotification","duration_hours","duration_minutes","status","eventstatus","priority","location","notime","visibility","recurringtype","invite_calendars","eventsfor","assigned_to","calendarno","parentid","site_id","color","calendar_types.id","calendar_types.type","calendar_types.name","calendar_types.status","calendar_types.color","calendar_types.eventsfor","calendar_types.created_by","calendar_types.created","calendar_types.modified_by","calendar_types.modified","calendar_types.assigned_to","calendar_types.calendar_typesno","calendar_types.site_id","calendar_types.[object Object]"],"atrr":{"subject":{"alias":"Subject"},"assigned_to":{"alias":"Assigned To"},"activitytype":{"alias":"Event Type"},"date_start":{"alias":"Start Date"},"due_date":{"alias":"End Date"},"time_start":{"alias":"Start Time"},"time_end":{"alias":"End Time"},"sendnotification":{"alias":"Send Notification"},"duration_hours":{"alias":"Duration (Hours)"},"duration_minutes":{"alias":"Duration (Minutes)"},"status":{"alias":"Status"},"priority":{"alias":"Priority"},"location":{"alias":"Location"},"visibility":{"alias":"Visibility"},"recurringtype":{"alias":"Recurring Type"},"invite_calendars":{"alias":"Invited To"},"id":{"alias":"id"},"calendar_types.color":{"alias":"Color"}},"actived":["subject","activitytype","date_start","due_date","time_start","time_end","assigned_to","calendar_types.color"]},"quickcreate":{"list":["id","subject","related_module","activitytype","date_start","due_date","time_start","time_end","sendnotification","duration_hours","duration_minutes","status","eventstatus","priority","location","notime","visibility","recurringtype","invite_calendars","color","eventsfor","assigned_to","calendarno","parentid","site_id"],"actived":["subject","activitytype","date_start","due_date","time_start","time_end","invite_calendars","assigned_to"],"atrr":{"subject":{"alias":"Subject"},"activitytype":{"alias":"Event Type"},"date_start":{"alias":"Date Start"},"due_date":{"alias":"Date End"}}},"massedit":{"list":["id","subject","related_module","activitytype","date_start","due_date","time_start","time_end","sendnotification","duration_hours","duration_minutes","status","eventstatus","priority","location","notime","visibility","recurringtype","invite_calendars","color","eventsfor","assigned_to","calendarno","parentid","site_id"],"actived":["subject","related_module"]},"summary":{"list":["id","subject","related_module","activitytype","date_start","due_date","time_start","time_end","sendnotification","duration_hours","duration_minutes","status","eventstatus","priority","location","notime","visibility","recurringtype","invite_calendars","color","eventsfor","assigned_to","calendarno","parentid","site_id"],"actived":["subject","activitytype","date_start","due_date","time_start","time_end"]},"frm_type":"2","ids":["assigned_to","subject","date_start","due_date","time_start","time_end","activitytype","sendnotification","duration_hours","duration_minutes","status","priority","location","visibility","recurringtype","invite_calendars"],"ids2":[["assigned_to","subject","date_start","due_date","time_start","time_end","activitytype","sendnotification","duration_hours","duration_minutes","status","priority","location","visibility","recurringtype","invite_calendars"]],"sections":"0","join":[{"type":"INNER","table":"calendar_types","currentField":"calendar.eventstatus","targetField":"calendar_types.id"}]}