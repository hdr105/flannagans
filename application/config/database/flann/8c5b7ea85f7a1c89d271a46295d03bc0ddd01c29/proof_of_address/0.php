<?php exit; ?>
{"section_name":"proof_of_address","section_title":"Proof of Address","section_view":"accordion","section_size":"default","section_fields":{"contract_type":{"field":"contract_type","label":"Contact","type":"autocomplete","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty","db_options":{"table":"contact","key":"id","value":"First_Name"},"list_choose":"database"},"proof_type":{"field":"proof_type","label":"Proof Type","type":"select","options":["Utility Bill","Driving Licence","Passport","Council Tax Bill","Bank Statement","Other"],"type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty","list_choose":"default"},"status":{"field":"status","label":"Status","type":"select","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty","options":["Requested","Recieved","Awaiting Client","Awaitng 3rd Party","Other"],"list_choose":"default"},"status_date":{"field":"status_date","label":"Status Date","type":"date","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty"},"date_recieved":{"field":"date_recieved","label":"Date Recieved","type":"date","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty"},"attached_document":{"field":"attached_document","label":"Add Document","type":"file","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty"},"contract_comments":{"field":"contract_comments","label":"Comment","type":"comments","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":""}}}