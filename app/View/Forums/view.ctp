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
			<tr>
				<td><bold class="text-info"><?php echo $topic['subject'];?></bold>&nbsp;<small class="muted"> by <?php echo $topic['poster']; ?></small></td>
				<td><?php echo $topic['num_replies'];?></td>
				<td><?php echo $topic['num_views'];?></td>
				<td>
					<small>
					<?php echo date("Y-m-d h:i:s", $topic['posted']);?><?php if ($topic['last_poster']) echo ' by '. $topic['last_poster'];?>
					</small>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>