<?php
// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, $fields_lbs);



// loop over the rows, outputting them
//while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);


foreach ($data as $dk => $dv) {
         fputcsv($output, $dv);                               
}
?>