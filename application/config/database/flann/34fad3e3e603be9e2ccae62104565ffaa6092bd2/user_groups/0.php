<?php exit; ?>
{"section_name":"user_group","section_title":"User Group","section_view":"accordion","section_size":"default","section_fields":{"ugroup_name":{"field":"ugroup_name","label":"Group Name","type":"text","type_options":{"size":"210","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty"},"crud_users":{"field":"crud_users","label":"Group Members","type":"select","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty","db_options":{"table":"crud_users","key":"id","value":"user_first_name","column":"site_id","action":"=","condition":"site_id","customtext":"user_status=1"},"list_choose":"database","multiple":"multiple"},"ugroup_status":{"field":"ugroup_status","label":"Group Status","type":"select","options":["Active","Inactive"],"type_options":{"size":"210","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty","list_choose":"default"},"assigned_to":{"field":"assigned_to","label":"Assigned To","type":"autocomplete","type_options":{"size":"210","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty","db_options":{"table":"crud_users","key":"id","value":"user_first_name","column":"site_id","action":"=","condition":"site_id","customtext":"user_status=1"},"list_choose":"database"}}}