<?php
// get the POST body with php://input
$received = file_get_contents("php://input");

// encode to json
$json_output = json_decode($received, true);

// save json data to a file
$file_handle = fopen('over_temp.json', 'w');
fwrite($file_handle, $received);
fclose($file_handle);
?>
