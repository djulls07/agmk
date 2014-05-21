<div class="background">
<?php
$this->extend('/Common/view');

$this->assign('title', $post['Post']['title']);

$this->start('sidebar');
?>
<li>
	<?php echo $this->Html->link('Edit', array(
		'action' => 'edit', 
		$post['Post']['id']
	)); ?>
</li>
<li>
	<?php echo $this->Html->link('Add comment', array(
			'controller' => 'comments',
			'action' => 'add',
			$post['Post']['id']
		)
	); ?>
</li>
<?php $this->end(); ?>

<p class="post_body"><?php echo h($post['Post']['body']); ?></p>

<div class="comments">
<?php foreach ($post['Comment'] as $comment): ?>
	<p><?php echo h($comment['body']); ?> <br />
	<small>
		<?php 
			echo $this->Html->link($comment['User']['username'], array(
					'controller' => 'users',
					'action' => 'view',
					$comment['user_id']
				)
			);
		?>
	</small></p>
<?php endforeach; ?>
</div>
</div>