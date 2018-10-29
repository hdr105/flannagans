<?php exit; ?>
{"section_name":"job_type","section_title":"Job Type","section_view":"accordion","section_size":"default","section_fields":{"title":{"field":"title","label":"Name","type":"text","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"notEmpty"},"file":{"field":"file","label":"Document","type":"file","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":""},"fee_id":{"field":"fee_id","label":"Fee Package","type":"select","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"","db_options":{"table":"fee_package","key":"id","value":"package_name","column":"sites","action":"=","condition":"site_id"},"list_choose":"database"},"recurring":{"field":"recurring","label":"Recurring","type":"custom","type_options":{"size":"100%","width":"300","height":"100","thumbnail":"mini"},"validation":"","options":["Yes","No"],"list_choose":"default","values":["1","0"],"cfieldsdata":{"value":"<div class=\"radio-list\">\n\t\t\t<label class=\"radio-inline\"><span><input type=\"radio\" name=\"data[job_types][recurring]\" id=\"optionsRadios1\" value=\"Yes\"><\/span> Yes <\/label>\n\t\t\t<label class=\"radio-inline\"><span><input type=\"radio\" name=\"data[job_types][recurring]\" id=\"optionsRadios2\" value=\"No\" checked=\"\"><\/span> No <\/label>\n\t\t\t\n\t\t<\/div>\n<div class=\"clearfix\"><\/div>\n\t <div id=\"repeaters\" style=\"display:none;\">\n\t\t<label>Repeats<\/label>\n\t\t<select class=\"form-control input-sm\" name=\"data[job_types][frequency]\" id=\"frequency\" disabled>\n\t\t\t<option value=\"Weekly\">Weekly<\/option>\n\t\t\t<option value=\"Monthly\">Monthly<\/option>\n\t\t\t<option value=\"Yearly\">Yearly<\/option>\n\t\t<\/select>\n\t<\/div>\n\t<div id=\"repeating\" style=\"display:none;\">\n\t\t<label>Repeats Every<\/label>\n\t\t<select class=\"form-control input-sm\" name=\"data[job_types][repeats_value]\" id=\"repeats_value\" disabled>\n\t\t\t<option value=\"1\">1<\/option>\n\t\t\t<option value=\"2\">2<\/option>\n\t\t\t<option value=\"3\">3<\/option>\n\t\t\t<option value=\"4\">4<\/option>\n\t\t\t<option value=\"5\">5<\/option>\n\t\t\t<option value=\"6\">6<\/option>\n\t\t\t<option value=\"7\">7<\/option>\n\t\t\t<option value=\"8\">8<\/option>\n\t\t\t<option value=\"9\">9<\/option>\n\t\t\t<option value=\"10\">10<\/option>\n\t\t\t<option value=\"11\">11<\/option>\n\t\t\t<option value=\"12\">12<\/option>\n\t\t<\/select>\n\t\t<label id=\"typeofrepeats\"><\/label>\n\t<\/div>\n\t\t\t  \n<script>\n\t$(\"#optionsRadios1\").click(function() {\n\t\t$(\"#repeaters\").show();\n\t\t$(\"#frequency\").prop('disabled', false);\n\t\t$(\"#repeating\").show();\n\t\t$(\"#repeats_value\").prop('disabled', false);\n\t\t$(\"#typeofrepeats\").empty();\n\t\t$(\"#typeofrepeats\").append('Week(s)');\n\t});\n\t\n\t$(\"#optionsRadios2\").click(function() {\n\t\t$(\"#repeaters\").hide();\n\t\t$(\"#frequency\").prop('disabled', true);\n\t\t$(\"#repeating\").hide();\n\t\t$(\"#repeating\").prop('disabled', false);\n\t});\n\t\n\t$(\"#frequency\").change(function() {\n\t\t$(\"#repeating\").show();\n\t\tif($(\"#frequency\").val()==1){\n\t\t\t$(\"#typeofrepeats\").empty();\n\t\t\t$(\"#typeofrepeats\").append('Week(s)');\n\t\t} else if($(\"#frequency\").val()==2){\n\t\t\t$(\"#typeofrepeats\").empty();\n\t\t\t$(\"#typeofrepeats\").append('Month(s)');\n\t\t} else if($(\"#frequency\").val()==3){\n\t\t\t$(\"#typeofrepeats\").empty();\n\t\t\t$(\"#typeofrepeats\").append('Year(s)');\n\t\t}\n\t});\n<\/script>"}}}}