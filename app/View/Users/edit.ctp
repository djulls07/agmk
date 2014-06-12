<div class="users form">
<?php 
$user=AuthComponent::user();
echo $this->Form->create('User', array(
    'enctype' => 'multipart/form-data'
));?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		//echo $this->Form->input('password');
		echo $this->Form->input('avatar1');
		echo $this->Form->file('User.avatar2');
		//echo $this->Form->input('role');
		echo $this->Form->input('Game', 
			array('label' => 'Game 1',
			'name' => 'data[User][idgame1]',
			'selected' => $this->request->data['User']['idgame1']
		));
		echo $this->Form->input('Game', 
			array('label' => 'Game 2' ,
			'name'=> 'data[User][idgame2]',
			'selected' => $this->request->data['User']['idgame2']
		));
		echo $this->Form->input('Game', 
			array('label' => 'Game' ,
				'name'=> 'data[User][idgame3]',
				'selected' => $this->request->data['User']['idgame3']
		));
	?>
		<div class="input select">
			<label for="UsernewsParPage">News par page</label>
			<select name="data[User][newsParPage]" id="UsernewsParPage">
				<?php for ($i=20;$i>=0;$i-=5) {
					print "<option value='".$i."'";
					if ( $i == $user['newsParPage'] ) print ' selected';
					if ($i==0) print ">&infin;</option>";
					else print ">".$i."</option>";
				} ?>
			</select>
		</div>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li>
			<?php
				echo $this->Form->postLink(
					'Delete',
					array('action' => 'delete', $this->Form->value('id')),
					array('confirm' => 'Are you sure ?')
	            );
                ?>
		</li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Profiles'), array('controller' => 'profiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Profile'), array('controller' => 'profiles', 'action' => 'add')); ?> </li>
	</ul>
</div>
