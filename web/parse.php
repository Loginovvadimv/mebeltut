<?php
$root = '/home/vadim/www/mebel.loc/public_html/web';


require __DIR__ . '/wp/wp-blog-header.php';

//
//$handle = fopen("test.csv", "r");
//while (($row = fgetcsv($handle)) !== FALSE) {
//// do something with row values
//print_r($row);
//}
//fclose($handle);


$delimiter = ';';

$csv = file_get_contents('test.csv');
$rows = explode(PHP_EOL, $csv);
$data = [];

foreach ($rows as $row)
{
    $data[] = explode($delimiter, $row);
}
echo '<pre>';
print_r($data);
