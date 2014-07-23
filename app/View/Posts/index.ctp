<div class="background">
<?php
$this->extend('/Common/view');

$this->assign('title', 'Agamek Forum');

$this->start('sidebar');
?>
<li>
	<?php 
	echo $this->Html->link(
	'Add Post', 
	array('controller' => 'posts', 'action' => 'add')
	); 
	?>
</li>
<?php $this->end(); ?>

<?php echo $this->Paginator->numbers(); ?>

<table>
<tr>
	<th><?php echo $this->Paginator->sort('username', 'Owner'); ?></th>
        <th><?php echo $this->Paginator->sort('title', 'Title'); ?></th>
	<th>Actions</th>
	<th><?php echo $this->Paginator->sort('created', 'Created'); ?></th>
</tr>

<?php foreach($posts as $post) : ?>
<tr>
	<td> 
		<?php echo $this->Html->link($post['User']['username'],
			array('controller' => 'users', 'action' => 'view', $post['Post']['user_id'])); ?>
	</td>
	<td> <?php echo $this->Html->link($post['Post']['title'],
		array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])); ?>
	</td>
	<td> 
		<?php echo $this->Html->link('Read', array('action' => 'view', $post['Post']['id'])); ?>
		<?php echo $this->Html->link(
			'Edit',
			array('controller' => 'posts', 'action' => 'edit', $post['Post']['id'])
		);
		?>
		<?php
			echo $this->Form->postLink(
			'Delete',
			array('action' => 'delete', $post['Post']['id']),
			array('confirm' => 'Are you sure ?')
                );
		?>
	</td>
	<td> <?php echo $post['Post']['created'] ?> </td>
</tr>

<?php endforeach; ?>
<?php unset($post); ?>
</table>
</div>