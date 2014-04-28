<?php 
require 'core/init.php';

$cats = $courses->get_cat();

foreach ($cats as $cat) {
	echo substr($cat['cat_title'], 0, strpos($cat['cat_title'], ' -'));
}
?>

<?php require 'footer.php'; ?>