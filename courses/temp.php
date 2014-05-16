		<!-- Exercise.php-->
		<?php if ($filename == 'exercise.php'): ?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-content">
			<div class="row announcement">
				<div class="col-lg-12 col-md-12" style="padding-left: 0; padding-right: 0;">
					<h2 class="page-header">Course Exercises</h2>
					<select class="selectpicker" name="ex_filter" id="ex_filter">
						<option>All</option>
						<?php $v_units = $courses->get_distinct_unit($id); ?>
						<?php foreach ($v_units as $v_unit): ?>
							<option> <?php echo $v_unit['unit_name'];?></option>
						<?php endforeach ?>
					</select>
					<?php if ($is_owner): ?>
					<div class="pull-right">
						<a href="#" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-flash"></span>Create new</a>
					</div>
					<?php endif ?>
				</div>			
				</div>
				
				<div class="panel-group" name="exercise-list">
					<?php $v_units = $courses->get_distinct_unit($id);
					foreach ($v_units as $v_unit) { ?><?php }?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#collpase<?php echo $v_unit['unit_id'];?>"><?php echo $v_unit['unit_name']; ?></a>
							</h4>
						</div>
						<div class="panel-body">
							<div id="collpase<?php echo $v_unit['unit_id'];?>" class="panel-collapse collapse in">
								<div class="panel-body">
									 <?php $v_exs = $courses->get_exercise_by_unit($id, $v_unit['unit_id']);?>
									 <?php foreach ($v_exs as $v_ex): ?>
									 	<span><?php echo $v_ex['exercise_title']; ?></span>
									 <?php endforeach; ?>
								</div> 
							</div>
						</div>
					</div>
					
				</div>
				<!-- <div class="col-lg-12 col-md-12" >
					<?php $exs = $courses->get_all_exercises($id); ?>
					<?php foreach ($exs as $ex): ?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title"><?php echo $ex['exercise_title']; ?></h4>
							</div>
							<div class="panel-body">
								<?php echo $ex['question']; ?>
							</div>
							<div class="panel-footer">
								<li>
									<?php echo $ex['multi_one']; ?>
								</li>
								<li>
									<?php echo $ex['multi_two']; ?>
								</li>
								<li>
									<?php echo $ex['multi_three']; ?>
								</li>
								<li>
									<?php echo $ex['multi_four']; ?>
								</li>
							</div>
						</div>
					<?php endforeach ?>
				</div> -->
			</div>
		</div>
		<?php endif ?>
		<!-- End of exercise.php-->