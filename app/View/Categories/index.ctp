<h2>Categories</h2>
<div class="row">
	<?php foreach($cat as $category): ?>
		<table class="table table-hover table-condensed">
		<thead>
			<tr class="well">
				<div class="row">
					<th class="col-md-4"> <?php echo $category['Category']['cat_name']; ?> </th>
					<th class="col-md-3"></th>
					<th class="col-md-1">Topics</th>
					<th class="col-md-1">Posts</th>
					<th class="col-md-3">Last post</th>
				</div>
			</tr>
		</thead>
		<tbody>
			<?php foreach($category['Forum'] as $forum): ?>
			<tr onclick="document.location='forums/view/<?php echo $forum['id']; ?>'">
				<div class="row">
					<td class="col-md-4">
						<bold class="text-info"><?php echo $forum['forum_name'];?></bold>
						<p><small><?php echo $forum['forum_desc']; ?></small></p>
					</td>
					<td class="col-md-3"></td>
					<td class="col-md-1"><?php echo $forum['num_topics'];?></td>
					<td class="col-md-1"><?php echo $forum['num_posts'];?></td>
					<td class="col-md-3">
					<?php if($forum['last_post']): ?>
						<small>
						<span class="text-info"><?php echo date("Y-m-d h:i:s", $forum['last_post']);?></span><?php if ($forum['last_poster']) echo ' by '.$forum['last_poster']; ?>
						</small>
					<?php else:?>
					<small>Never</small>
					<?php endif; ?>
					</td>
				</div>
			</tr>
			<?php endforeach; ?>
		</tbody>
		</table>
	<?php endforeach; ?>
</div>