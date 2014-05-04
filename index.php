<?php 
   require 'core/init.php';
	require_once 'header.php';
	//require 'core/init.php';

	// $conn = connect($config);

	// if (!$conn) die(); 
	$cats = $courses->get_cat();
 ?>
<div class="container">
	<div class="col-md-3 catagories">
		<div class="nav-container">
			<ul class="nav-sidebarlist">
				<li class="emphasize">All topics</li>
				<?php 
				foreach ($cats as $cat) { ?>
					<li><a href="#"><?php echo $cat['cat_title']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>

	<div class="col-md-9 course-list">
		<div class="col-md-9 course-list-header">
			<div class="list-header">
				<p style="display: block; font-size: 12px;">Browsing</p>
				<h2>All topics</h2>
			</div>
			
		</div>
		<div class="col-md-3 pull-right sorting">
			<p style="display: block; font-size: 12px;">Sort by</p>
			<div class="btn-group btn-group-sm">
				<button type="button" class="btn btn-default active">Recency</button>
				<button type="button" class="btn btn-default">Popularity</button>
			</div>
		</div>

		<div class="col-md-9 line-separator">
		</div>

		<div class="row">
			<div class="col-md-4 course-hero">
				<div class="course-thumbnail">
					<img src="images/courses/css-thumbnail.png" class="course-thumbnail-image">
				</div>
				<div class="course-info">
					<div class="course-topic">
						Computer Programming
					</div>
					<h3 class="course-title">Getting Started with CSS</h3>
					<div class="course-start-date">
						April 23th, 2014
					</div>
					<a href="#" class="course-num-of-unit">16 units</a>
				</div>
				<a href="#" class="course-link"></a>
			</div>

			<div class="col-md-4 course-hero">
				<div class="course-thumbnail">
					<img src="images/courses/php-oop-thumbnail.png" class="course-thumbnail-image">
				</div>
				<div class="course-info">
					<div class="course-topic">
						Computer Science
					</div>
					<h3 class="course-title">OOP in PHP with Tests</h3>
					<div class="course-start-date">
						Self-paced
					</div>
					<a href="#" class="course-num-of-unit">20 units</a>
				</div>
				<a href="#" class="course-link"></a>
			</div>
			<div class="col-md-4 course-hero">
				<div class="course-thumbnail">
					<img src="images/courses/database-thumbnail.png" class="course-thumbnail-image">
				</div>
				<div class="course-info">
					<div class="course-topic">
						Computer Science
					</div>
					<h3 class="course-title">Fundamentals of Database</h3>
					<div class="course-start-date">
						January 31th, 2014
					</div>
					<a href="#" class="course-num-of-unit">22 units</a>
				</div>
				<a href="#" class="course-link"></a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 course-hero">
				<div class="course-thumbnail">
					<img src="images/courses/css-thumbnail.png" class="course-thumbnail-image">
				</div>
				<div class="course-info">
					<div class="course-topic">
						Computer Programming
					</div>
					<h3 class="course-title">Getting Started with CSS</h3>
					<div class="course-start-date">
						April 23th, 2014
					</div>
					<a href="#" class="course-num-of-unit">16 units</a>
				</div>
				<a href="#" class="course-link"></a>
			</div>

			<div class="col-md-4 course-hero">
				<div class="course-thumbnail">
					<img src="images/courses/php-oop-thumbnail.png" class="course-thumbnail-image">
				</div>
				<div class="course-info">
					<div class="course-topic">
						Computer Science
					</div>
					<h3 class="course-title">OOP in PHP with Tests</h3>
					<div class="course-start-date">
						Self-paced
					</div>
					<a href="#" class="course-num-of-unit">20 units</a>
				</div>
				<a href="#" class="course-link"></a>
			</div>
			<div class="col-md-4 course-hero">
				<div class="course-thumbnail">
					<img src="images/courses/database-thumbnail.png" class="course-thumbnail-image">
				</div>
				<div class="course-info">
					<div class="course-topic">
						Computer Science
					</div>
					<h3 class="course-title">Fundamentals of Database</h3>
					<div class="course-start-date">
						January 31th, 2014
					</div>
					<a href="#" class="course-num-of-unit">22 units</a>
				</div>
				<a href="#" class="course-link"></a>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 course-hero">
				<div class="course-thumbnail">
					<img src="images/courses/css-thumbnail.png" class="course-thumbnail-image">
				</div>
				<div class="course-info">
					<div class="course-topic">
						Computer Programming
					</div>
					<h3 class="course-title">Getting Started with CSS</h3>
					<div class="course-start-date">
						April 23th, 2014
					</div>
					<a href="#" class="course-num-of-unit">16 units</a>
				</div>
				<a href="#" class="course-link"></a>
			</div>

			<div class="col-md-4 course-hero">
				<div class="course-thumbnail">
					<img src="images/courses/php-oop-thumbnail.png" class="course-thumbnail-image">
				</div>
				<div class="course-info">
					<div class="course-topic">
						Computer Science
					</div>
					<h3 class="course-title">OOP in PHP with Tests</h3>
					<div class="course-start-date">
						Self-paced
					</div>
					<a href="#" class="course-num-of-unit">20 units</a>
				</div>
				<a href="#" class="course-link"></a>
			</div>
			<div class="col-md-4 course-hero">
				<div class="course-thumbnail">
					<img src="images/courses/database-thumbnail.png" class="course-thumbnail-image">
				</div>
				<div class="course-info">
					<div class="course-topic">
						Computer Science
					</div>
					<h3 class="course-title">A course with a really long title to test the display</h3>
					<div class="course-start-date">
						January 31th, 2014
					</div>
					<a href="#" class="course-num-of-unit">22 units</a>
				</div>
				<a href="#" class="course-link"></a>
			</div>
		</div>
	<div class="col-md-9" id="bottom-line-separator">
		<div class="line-separator"></div>
	</div>
	<div class="col-md-9" id="pagination">
		<div class="row">
			<ul class="pager">
			  <li class="previous"><a href="#">&larr; Previous</a></li>
			  <li class="next"><a href="#">Next &rarr;</a></li>
			</ul>
		</div>
	</div>
</div>
</div>
<!-- ./Body -->

<?php 
	require_once 'footer.php';
 ?>