<?php 
$file = 'courses.php';

#echo substr($file,0, strlen($file) - strpos($file, '.php') + 2);
echo strlen($file) . '<br>';
echo strpos($file, 'php') . '<br>';
echo ucfirst(substr($file, 0, strpos($file, 'php') - 1));
require 'core/init.php';
require 'navbar.php'; ?>
 <div class="container" style="margin-top: 88px;">
 	  <div class="btn-group bootstrap-select"><button type="button" class="btn dropdown-toggle selectpicker btn-default" data-toggle="dropdown"><span class="filter-option pull-left">Mustard</span>&nbsp;<span class="caret"></span></button><div class="dropdown-menu open" style="max-height: 318px; overflow: hidden; min-height: 0px;"><ul class="dropdown-menu inner selectpicker" role="menu" style="max-height: 306px; overflow-y: auto;"><li rel="0" class="selected"><a tabindex="0" class="" style=""><span class="text">Mustard</span><i class="glyphicon glyphicon-ok icon-ok check-mark"></i></a></li><li rel="1"><a tabindex="0" class="" style=""><span class="text">Ketchup</span><i class="glyphicon glyphicon-ok icon-ok check-mark"></i></a></li><li rel="2"><a tabindex="0" class="" style=""><span class="text">Relish</span><i class="glyphicon glyphicon-ok icon-ok check-mark"></i></a></li></ul></div></div>
 </div>

<?php require 'footer.php'; ?>