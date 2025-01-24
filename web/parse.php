<?php
$root = '/home/vadim/www/mebel.loc/public_html/web';


require __DIR__ . '/wp/wp-blog-header.php';
require __DIR__ . '/TableImporter.php';

//
//$handle = fopen("test.csv", "r");
//while (($row = fgetcsv($handle)) !== FALSE) {
//// do something with row values
//print_r($row);
//}
//fclose($handle);

//
//$delimiter = ';';
//
//$csv = file_get_contents('test.csv');
//$row = 1;
//
//if (($handle = fopen("test.csv", "r")) !== FALSE) {
//    while (($data = fgetcsv($handle, 5000, $delimiter)) !== FALSE) {
//        $num = count($data);
//        if ($row == 1) {
//            $row++;
//            continue;
//        }
//
//        echo "<p> $num полей в строке $row: <br /></p>\n";
//        $row++;
//        for ($c = 0; $c < $num; $c++) {
//            echo $data[$c] . "<br />\n";
//        }
//    }
//
//    fclose($handle);
//}
new TableImporter();









