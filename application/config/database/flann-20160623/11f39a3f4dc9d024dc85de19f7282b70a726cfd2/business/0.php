<?php exit; ?>
{"section_name":"basic_information","section_title":"Basic Information","section_view":"accordion","section_size":"default","section_fields":{"title":{"field":"title","label":"Business Name","type":"text","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty"},"internal_b_id":{"field":"internal_b_id","label":"Internal Business ID","type":"text","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":""},"referal_part":{"field":"referal_part","label":"Name of Referral Party","type":"text","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":""},"legal_entity":{"field":"legal_entity","label":"Legal Entity","type":"hidden","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"","hidden_options":{"choice":"manual","value":"4"}},"industry":{"field":"industry","label":"Industry","type":"select","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"","options":["Charities","Construction","Contractor\/One Person Company","Engineering","Indivisual","IT","Medical","Rental","Retail","Telecom"],"list_choose":"default"},"b_type":{"field":"b_type","label":"Business Type","type":"text","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":""},"assigned_to":{"field":"assigned_to","label":"Assigned To","type":"select","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty","db_options":{"table":"crud_users","key":"id","value":"user_first_name","column":"site_id","action":"=","condition":"site_id","customtext":"group_id!=1 AND group_id!=5"},"list_choose":"database"}}}