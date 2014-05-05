<?php 
require 'core/init.php';

$htmlString = '<h1 class="panel-title">Panel title</h1>';

$courses->insert_html($htmlString);

$out = $courses->load_html(1);
var_dump($out);

echo $out;
 ?>