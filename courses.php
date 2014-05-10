<?php 
    require 'core/init.php';
	require 'navbar.php';
 ?>
<div class="container" style="margin-top: -6px;">
	<div class="panel panel-default">
		<div class="panel-body">
			<h4><strong>Search for courses</strong></h4>
			<form method="post" action="" role="form" id="course-search-form">
				<div class="input-group">
			      <input type="text" class="form-control" name="keyword" placeholder="Enter a keyword here">
			      <span class="input-group-btn">
			        <button class="btn btn-default" type="submit" name="submit"><span class="glyphicon glyphicon-search"></span></button>
			      </span>
			    </div>
			</form>
		</div>
	</div>
	<div class="col-md-4 catagories">
		<div class="nav-container">
			<ul class="nav-sidebarlist">
				<li class="emphasize">All topics</li>
				<?php 
				$cats = $courses->get_all_course_by_cat();

				foreach ($cats as $cat) { ?>
					<li><a href="#"><?php echo $cat['title'];?></a><span class="badge pull-right"><?php echo $cat['count']; ?>  </span></li>
				<?php }?>
			</ul>
		</div>
	</div>

	<div class="col-md-8 course-list">
		<div class="col-md-9 course-list-header">
			<div class="list-header">
				<!-- <p style="display: block; font-size: 12px;">Browsing</p> -->
				<?php 
				if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
					$keyword = $_POST['keyword'];
					if (strlen($keyword) > 16) { ?>
						<h2>Search results for &ldquo;<?php echo substr($keyword, 0, 15) . '...'; ?>&rdquo;</h2>
					<?php } else {?>
					<h2>Search results for &ldquo;<?php echo $keyword; ?>&rdquo;</h2>
				<?php } } else { ?>
					<h2>All topics</h2>
				<?php } ?>
			</div>
		</div>
		<div class="col-md-9 line-separator">
		</div>
		<div class="col-md-12 course-list-detail">
		<?php if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
			$keyword = $_POST['keyword']; 

			$results = $courses->search_courses($keyword);
			if ($results != false) {
				foreach ($results as $result) { ?>
					<div class="course-entry">
						<img src="<?php echo $result['course_avatar'];?>">
						<div class="course-meta">
							<a href="<?php echo 'courses/' . $result['course_alias'] . '/'; ?>"><h3><?php echo $result['course_title'];?></h3></a>
							<span><?php echo $result['course_code']; ?></span>
							<span><?php echo $result['course_id']; ?></span>
						</div>
					</div>
			<?php }
            } else { ?> 
                <h3>There is nothing like that!</h3>
            <?php }} else {
				$results = $courses->get_all_courses();

				foreach ($results as $result) {?>
					<div class="course-entry">
						<img src="<?php echo $result['course_avatar'];?>">
						<div class="course-meta">
							<a href="<?php echo 'courses/' . $result['course_alias'] . '/'; ?>"><h3><?php echo $result['course_title'];?></h3></a>
							<span><?php echo $result['course_code']; ?></span>
						</div>
						<?php 
						if ($general->logged_in()) {
							if (($users->get_role($user_id) == 'Teacher') && ($courses->is_created_by_me($user_id, $result['course_id']) === true)) { 
								?>
								<div class="pull-right">
									<a href="editcourse.php?course_alias=<?php echo $result['course_alias']; ?>">Edit</a>
								</div>
							<?php } } ?>
					</div>
			<?php	} }?>
		</div>
	<div class="col-md-9" id="bottom-line-separator">
		<div class="line-separator"></div>
	</div>
</div>
</div>
<!-- ./Body -->

<?php 
	require_once 'footer.php';
 ?>