<div class="users_edit">
<div class="users_edit_title">
	<div class="rotate">
	<h1 style="font-size:300%">EDIT USER</h1>
	</div>
</div>
<div class="users_edit_form">
<?php 
$user=AuthComponent::user();
echo $this->Form->create('User', array(
    'enctype' => 'multipart/form-data'
));?>
	<?php 
		echo '<fieldset><ol>';
		echo '<legend>Informations personnelles</legend>';
			echo $this->Form->input('id');
			echo '<li>'.$this->Form->input('username').'</li>';
			echo '<li>'.$this->Form->input('e-mail',array('type'=>'email'/*,'value'=>$user['mail']*/)).'</li>';
			//echo $this->Form->input('password');
		echo '</ol></fieldset><fieldset><ol>';
		echo '<legend>Avatar</legend>';
			echo '<li>'.$this->Form->input('avatar1', array('label' => 'URL')).'</li>';
			echo '<li>'.$this->Form->file('User.avatar2').'</li>';
		echo '</ol></fieldset><fieldset><ol>';
		echo '<legend>Mes 3 jeux favoris</legend>';
		//echo $this->Form->input('role');
			echo '<li>'.$this->Form->input('Game', 
				array('label' => 'Game 1',
				'name' => 'data[User][idgame1]',
				'selected' => $this->request->data['User']['idgame1']
			)).'</li>';
			echo '<li>'.$this->Form->input('Game', 
				array('label' => 'Game 2' ,
				'name'=> 'data[User][idgame2]',
				'selected' => $this->request->data['User']['idgame2']
			)).'</li>';
			echo '<li>'.$this->Form->input('Game', 
				array('label' => 'Game' ,
					'name'=> 'data[User][idgame3]',
					'selected' => $this->request->data['User']['idgame3']
			)).'</li>';
		echo '</ol></fieldset><fieldset><ol>';
		echo "<legend>Personnaliser l'affichage d'Agamek</legend>";
			echo "<li>".$this->Form->input('newsParPage', array('label'=>'News par page','type'=>'range','step'=>'5','max'=>'30','min'=>'0','value'=>$user['newsParPage']))
				."</li>";
		echo '</ol></fieldset><fieldset>';
			echo $this->Form->button('OK', array('type' => 'submit'));
		echo '</fieldset>'.$this->Form->end();
		?>
</div>


<?php if (false) : ?>
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
<?php endif; ?>

		<!---<div class="input select">
			<label for="UsernewsParPage">News par page</label>
			<select name="data[User][newsParPage]" id="UsernewsParPage">
				<?php/* for ($i=20;$i>=0;$i-=5) {
					print "<option value='".$i."'";
					if ( $i == $user['newsParPage'] ) print ' selected';
					if ($i==0) print ">&infin;</option>";
					else print ">".$i."</option>";
				} */?>
			</select>
		</div>-->
</div>