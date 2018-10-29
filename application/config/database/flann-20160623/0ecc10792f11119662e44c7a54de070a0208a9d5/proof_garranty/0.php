<?php exit; ?>
{"section_name":"personal_guarantee","section_title":"Personal Guarantee","section_view":"accordion","section_size":"default","section_fields":{"contract_type":{"field":"contract_type","label":"Contact","type":"autocomplete","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty","db_options":{"table":"contact","key":"id","value":"First_Name","column":"site_id","action":"=","condition":"site_id"},"list_choose":"database"},"status":{"field":"status","label":"Status","type":"select","options":["Requested","Recieved","Awaiting 3rd Party","Other"],"type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty","list_choose":"default"},"status_date":{"field":"status_date","label":"Status Date","type":"date","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty"},"request_date":{"field":"request_date","label":"Guarantee Request Sent Date","type":"date","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":""},"recieved_date":{"field":"recieved_date","label":"Guarantee Request Recieved Date","type":"date","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":""},"garranter_name":{"field":"garranter_name","label":"Full Name of Guarantor","type":"text","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty"},"garranter_contact":{"field":"garranter_contact","label":"Contact Phone of Guarantor","type":"text","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty"},"garranter_address":{"field":"garranter_address","label":"Address of Guarantor","type":"textarea","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":""},"attached_document":{"field":"attached_document","label":"Add Document","type":"file","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty"},"contract_comments":{"field":"contract_comments","label":"Comment","type":"comments","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":""}}}