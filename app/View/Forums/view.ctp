<!-- forum menu first -->
<?php $this->start('menu_forum_gauche'); ?>
<li class="col-md-12 text-center"><a href="http://agamek.org/categories">Back</a></li>
<?php $this->end(); ?>

<?php //debug($forum); ?>
<h2><?php echo $forum['Forum']['forum_name']; ?></h2>
<div class="row">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Topic</th>
				<th>Replies</th>
				<th>Views</th>
				<th>Last post</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($forum['Topic'] as $topic): ?>
			<tr onclick="document.location='http://agamek.org/topics/view/<?php echo $topic['id']; ?>'"
			<?php if ($topic['sticky'] == true) echo 'class="success"'; ?>
			>
				<td>
					<?php if ($topic['sticky'] == true) echo '<i class="icon-search"></i>';
						else echo '<i class="icon-search"></i>';?>
					<bold class="text-info">
					<?php echo $topic['subject'];?></bold>&nbsp;<small class="muted"> by <?php echo $topic['poster']; ?></small></td>
				<td><?php echo $topic['num_replies'];?></td>
				<td><?php echo $topic['num_views'];?></td>
				<td>
					<small>
					<span class="text-info">
					<?php if ($topic['last_post']) echo date("Y-m-d h:i:s", $topic['last_post']);?>
					</span>
					<?php if ($topic['last_poster']) echo ' by '. $topic['last_poster'];?>
					</small>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>