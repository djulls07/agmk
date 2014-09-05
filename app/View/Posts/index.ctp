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
	<th><?php echo $this->Paginator->sort('id', 'Post ID'); ?></th>
	<th><?php echo $this->Paginator->sort('poster', 'Owner'); ?></th>
	<th><?php echo $this->Paginator->sort('message', 'Message'); ?></th>
	<th><?php echo $this->Paginator->sort('posted', 'Posted');?></th>
</tr>

<?php foreach($posts as $post) : ?>
<tr>
	<td> 
		<?php echo $post['Post']['id'];?>
	</td>
	<td> 
		<?php echo $post['Post']['poster'];?>
	</td>
	<td>
		<?php echo $this->Html->link(substr($post['Post']['message'],0,100).'.....', 
			array('action'=>'view', $post['Post']['id']));?>
	</td>
	<td>
		<?php echo $post['Post']['posted'];?>
	</td>

<?php endforeach; ?>
<?php unset($post); ?>
</table>
</div>