<?php 
    require 'core/init.php';
	 require 'navbar.php';
 ?>
<div class="container" style="margin-top: -6px;">
	<div class="panel panel-default">
		<div class="panel-body">
			<h4><strong>Search for courses</strong></h4>
			<form method="post" action="courses.php" role="form" id="course-search-form">
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
					<li><a href="courses.php?cat_id=<?php echo $cat['cat_id']; ?>"><?php echo $cat['title'];?></a><span class="badge pull-right"><?php echo $cat['count']; ?>  </span></li>
				<?php }?>
			</ul>
		</div>
	</div>

	<div class="col-md-8 course-list">
		<div class="col-md-9 course-list-header">
			<div class="list-header">
				<?php 
				if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
					$keyword = $_POST['keyword'];
					if (strlen($keyword) > 16) { ?>
						<h2>Search results for &ldquo;<?php echo substr($keyword, 0, 15) . '...'; ?>&rdquo;</h2>
					<?php } else {?>
						<h2>Search results for &ldquo;<?php echo $keyword; ?>&rdquo;</h2>
					<?php } ?>
                
                <div class="course-wrapper">
						<?php $vscs = $courses->search_courses($_POST['keyword']); 
						foreach ($vscs as $vsc) { ?>
						<div class="row">
							<div class="col-md-9 entry">
								<div class="entry-wrap">
									<div class="entry-thumbnail">
										<a href="courses/<?php echo $vsc['course_alias'] . '/' ;?>" title="Link to <?php echo $vsc['course_title']; ?>"></a>
										<img src="<?php echo $vsc['course_avatar'];?>">
									</div> <!-- end .entry-thumbnail-->
									<div class="entry-meta">
										<span class="school-name"><?php echo $vsc['school']; ?></span>
			                            <span class="pull-right label label-primary"><?php echo $courses->unit_count($vsc['course_id']);?> lectures</span>
										<h2 class="course-title">
											<a href="courses/<?php echo $vsc['course_alias'] . '/' ;?>" title="Link to <?php echo $vsc['course_title']; ?>">
												<span><?php echo $vsc['course_title']; ?></span>
											</a>
										</h2>
										<div class="course-progress">
											<?php if ($vsc['course_type'] == 1) { ?>
												<span class="self-study">Self-study</span><br>
												<div class="go-to-course">
													<a href="courses/<?php echo $vsc['course_alias'] . '/' ;?>"><span>Course info</span></a> 
													<?php if ($courses->is_registered($user_id, $vsc['course_id'])): ?>
														<span class="glyphicon glyphicon-ok"></span><span>Enrolled</span>
													<?php endif ?>
													<div class="pull-right">
														<a href="courses/<?php echo $vsc['course_alias'] . '/' ;?>" class="btn btn-success">Go to class</a>
													</div>										
												</div>
											
											<?php } else { ?>
												<?php $end_date = date('M jS',strtotime($vsc['start_date'] . ' + ' . $vsc['length']*7 . ' days'));?>
												<span><?php echo date('M jS', strtotime($vsc['start_date'])); ?></span>
												<span class="pull-right"><?php echo $end_date; ?></span>
			                                    <?php $tmp = (time() - strtotime($vsc['start_date'])); 
			                                          $week = $tmp / 604800 % 52; 
			                                          $prog = $week / $vsc['length'] * 100;?>
												<div class="progress" style="height: 8px;">
												  <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="<?php echo $prog?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog . '%';?>">
												    <span class="sr-only"><?php echo $prog; ?>% Complete (success)</span>
												  </div>
												</div>
												<a href="courses/<?php echo $vsc['course_alias'] . '/' ;?>" style="text-decoration: none;"><span>Course info</span></a> 
												<?php if ($courses->is_registered($user_id, $vsc['course_id'])): ?>
														| <span class="glyphicon glyphicon-ok"></span>  <span>Enrolled</span>
													<?php endif ?>
												<div class="pull-right">
													<?php 
													if ($general->logged_in()) {
														if ($courses->is_created_by_me($user['user_id'], $vsc['course_id'])){?>
														<a href="editcourse.php?course_alias=<?php echo $vsc['course_alias'] ;?>" class="btn btn-warning">Edit</a>	
													<?php }} ?>
													<a href="courses/<?php echo $vsc['course_alias'] . '/' ;?>" class="btn btn-success">Go to class</a>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
					
                
               <?php } else { ?>
                <?php if (isset($_GET['cat_id'])): ?>
                	<h2><?php echo $courses->get_cat_info('cat_title', 'cat_id', $_GET['cat_id']); ?></h2>
                <?php else: ?>
						<h2>All topics</h2>
					 <?php endif ?>
				<?php } ?>
			</div>
		</div>
		<div class="col-md-9 line-separator">
		</div>

		<div class="course-wrapper">
		<?php if (!isset($_GET['cat_id'])): ?>
			<?php $v_courses = $courses->get_all_courses(); 
			foreach ($v_courses as $v_course) { ?>
			<div class="row">
				<div class="col-md-9 entry">
					<div class="entry-wrap">
						<div class="entry-thumbnail">
							<a href="courses/<?php echo $v_course['course_alias'] . '/' ;?>" title="Link to <?php echo $v_course['course_title']; ?>"></a>
							<img src="<?php echo $v_course['course_avatar'];?>">
						</div> <!-- end .entry-thumbnail-->
						<div class="entry-meta">
							<span class="school-name"><?php echo $v_course['school']; ?></span>
                            <span class="pull-right label label-primary"><?php echo $courses->unit_count($v_course['course_id']);?> lectures</span>
							<h2 class="course-title">
								<a href="courses/<?php echo $v_course['course_alias'] . '/' ;?>" title="Link to <?php echo $v_course['course_title']; ?>">
									<span><?php echo $v_course['course_title']; ?></span>
								</a>
							</h2>
							<div class="course-progress">
								<?php if ($v_course['course_type'] == 1) { ?>
									<span class="self-study">Self-study</span><br>
									<div class="go-to-course">
										<a href="courses/<?php echo $v_course['course_alias'] . '/' ;?>"><span>Course info</span></a> 
										<?php if ($courses->is_registered($user_id, $v_course['course_id'])): ?>
											<span class="glyphicon glyphicon-ok"></span><span>Enrolled</span>
										<?php endif ?>
										<div class="pull-right">
											<a href="courses/<?php echo $v_course['course_alias'] . '/' ;?>" class="btn btn-success">Go to class</a>
										</div>										
									</div>
								
								<?php } else { ?>
									<?php $end_date = date('M jS',strtotime($v_course['start_date'] . ' + ' . $v_course['length']*7 . ' days'));?>
									<span><?php echo date('M jS', strtotime($v_course['start_date'])); ?></span>
									<span class="pull-right"><?php echo $end_date; ?></span>
                                    <?php $tmp = (time() - strtotime($v_course['start_date'])); 
                                          $week = $tmp / 604800 % 52; 
                                          $prog = $week / $v_course['length'] * 100;?>
									<div class="progress" style="height: 8px;">
									  <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="<?php echo $prog?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog . '%';?>">
									    <span class="sr-only"><?php echo $prog; ?>% Complete (success)</span>
									  </div>
									</div>
									<a href="courses/<?php echo $v_course['course_alias'] . '/' ;?>" style="text-decoration: none;"><span>Course info</span></a> 
									<?php if ($courses->is_registered($user_id, $v_course['course_id'])): ?>
											| <span class="glyphicon glyphicon-ok"></span>  <span>Enrolled</span>
										<?php endif ?>
									<div class="pull-right">
										<?php 
										if ($general->logged_in()) {
											if ($courses->is_created_by_me($user['user_id'], $v_course['course_id'])){?>
											<a href="editcourse.php?course_alias=<?php echo $v_course['course_alias'] ;?>" class="btn btn-warning">Edit</a>	
										<?php }} ?>
										<a href="courses/<?php echo $v_course['course_alias'] . '/' ;?>" class="btn btn-success">Go to class</a>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		<?php endif ?>

		<?php if (isset($_GET['cat_id'])): ?>
			<?php  $cat_id = $_GET['cat_id']; 
					 $vcs = $courses->get_course_by_cat($cat_id);?>
					 <?php foreach ($vcs as $vc): ?>
					 	<div class="row">
				<div class="col-md-9 entry">
					<div class="entry-wrap">
						<div class="entry-thumbnail">
							<a href="courses/<?php echo $vc['course_alias'] . '/' ;?>" title="Link to <?php echo $vc['course_title']; ?>"></a>
							<img src="<?php echo $vc['course_avatar'];?>">
						</div> <!-- end .entry-thumbnail-->
						<div class="entry-meta">
							<span class="school-name"><?php echo $vc['school']; ?></span>
                            <span class="pull-right label label-primary"><?php echo $courses->unit_count($vc['course_id']);?> lectures</span>
							<h2 class="course-title">
								<a href="courses/<?php echo $vc['course_alias'] . '/' ;?>" title="Link to <?php echo $vc['course_title']; ?>">
									<span><?php echo $vc['course_title']; ?></span>
								</a>
							</h2>
							<div class="course-progress">
								<?php if ($vc['course_type'] == 1) { ?>
									<span class="self-study">Self-study</span><br>
									<div class="go-to-course">
										<a href="courses/<?php echo $vc['course_alias'] . '/' ;?>"><span>Course info</span></a> 
										<?php if ($courses->is_registered($user_id, $vc['course_id'])): ?>
											<span class="glyphicon glyphicon-ok"></span><span>Enrolled</span>
										<?php endif ?>
										<div class="pull-right">
											<a href="courses/<?php echo $vc['course_alias'] . '/' ;?>" class="btn btn-success">Go to class</a>
										</div>										
									</div>
								
								<?php } else { ?>
									<?php $end_date = date('M jS',strtotime($vc['start_date'] . ' + ' . $vc['length']*7 . ' days'));?>
									<span><?php echo date('M jS', strtotime($vc['start_date'])); ?></span>
									<span class="pull-right"><?php echo $end_date; ?></span>
                                    <?php $tmp = (time() - strtotime($vc['start_date'])); 
                                          $week = $tmp / 604800 % 52; 
                                          $prog = $week / $vc['length'] * 100;?>
									<div class="progress" style="height: 8px;">
									  <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="<?php echo $prog?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog . '%';?>">
									    <span class="sr-only"><?php echo $prog; ?>% Complete (success)</span>
									  </div>
									</div>
									<a href="courses/<?php echo $vc['course_alias'] . '/' ;?>" style="text-decoration: none;"><span>Course info</span></a> 
									<?php if ($courses->is_registered($user_id, $vc['course_id'])): ?>
											| <span class="glyphicon glyphicon-ok"></span>  <span>Enrolled</span>
										<?php endif ?>
									<div class="pull-right">
										<?php 
										if ($general->logged_in()) {
											if ($courses->is_created_by_me($user['user_id'], $vc['course_id'])){?>
											<a href="editcourse.php?course_alias=<?php echo $vc['course_alias'] ;?>" class="btn btn-warning">Edit</a>	
										<?php }} ?>
										<a href="courses/<?php echo $vc['course_alias'] . '/' ;?>" class="btn btn-success">Go to class</a>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
					 <?php endforeach ?>
		<?php endif ?>	
		</div>
</div>
</div>
<!-- ./Body -->

<?php 
	require_once 'footer.php';
 ?>