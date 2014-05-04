<?php 
require 'core/init.php';
$folder = 'dbstanford';
// $dir = mkdir('courses/'. $folder, 777);
// echo $dir;
$mkfir = file_put_contents('courses/' . $folder . '/lecture.php',
									'<?php $alias = \'' . $folder . '\'; require \'../index.php\';?>');
echo '<br>' . $mkfir;
?>
