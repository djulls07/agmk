<?php
	$this->extend('/Common/articles_design');

$specific_user_color="orange";
$specific_user_avatar="avatar.jpg";?>
<div id="espace_gauche"><?php echo $this->Session->flash(); ?>
	<div id="espace_gauche_avatar" style="background-color:<?php print $specific_user_color;?>; background-image:url('/img/<?php print $specific_user_avatar;?>')">
	 </div>
	<div id="espace_gauche_menu">
		<ul class="liste_style">
			<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List Profiles'), array('controller' => 'profiles', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New Profile'), array('controller' => 'profiles', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div id="espace_droite">
	<div id="espace_droite_top">
		<div id="espace_droite_user">
			<div id="espace_droite_user_flag">
				<img src="images/flag_fr.png">
			</div>
			<div id="espace_droite_user_team" class="vertical_center_div">
				<a href=""><?php echo __(h($user['User']['username']))."team";?></a>
			</div>
			<div id="espace_droite_user_pseudo" class="vertical_center_div">
				<?php echo __(h($user['User']['username'])); ?>
				 (<?php echo __('Id'); ?> : <?php echo h($user['User']['id']); ?>)
			</div>
		</div>
		<div id="espace_droite_stats">
			<div id="espace_droite_stats_bloc1">
				<div id="espace_droite_stats_bloc_logogame" class="vertical_center_div">LogoGame
				</div>
				<div id="espace_droite_stats_bloc_ranks">
					<div id="espace_droite_stats_bloc_rank1" class="vertical_center_div">rank1
					</div>
					<div id="espace_droite_stats_bloc_rank2" class="vertical_center_div">rank2
					</div>
				</div>
				<div id="espace_droite_stats_bloc_morestats" class="vertical_center_div"><a href="">More stats</a>
				</div>
			</div>
			<div id="espace_droite_stats_bloc2">
				<div id="espace_droite_stats_bloc_logogame" class="vertical_center_div">LogoGame
				</div>
				<div id="espace_droite_stats_bloc_ranks">
					<div id="espace_droite_stats_bloc_rank1" class="vertical_center_div">rank1
					</div>
					<div id="espace_droite_stats_bloc_rank2" class="vertical_center_div">rank2
					</div>
				</div>
				<div id="espace_droite_stats_bloc_morestats" class="vertical_center_div"><a href="">More stats</a>
				</div>
			</div>
			<div id="espace_droite_stats_bloc3">
				<div id="espace_droite_stats_bloc_logogame" class="vertical_center_div">LogoGame
				</div>
				<div id="espace_droite_stats_bloc_ranks">
					<div id="espace_droite_stats_bloc_rank1" class="vertical_center_div">rank1
					</div>
					<div id="espace_droite_stats_bloc_rank2" class="vertical_center_div">rank2
					</div>
				</div>
				<div id="espace_droite_stats_bloc_morestats" class="vertical_center_div"><a href="">More stats</a>
				</div>
			</div>
		</div>
	</div>
	<div id="espace_droite_wall">
		<h3><?php echo __('Related Posts'); ?></h3>
		<?php if (!empty($user['Post'])): ?>
			<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Title'); ?></th>
				<th><?php echo __('Modified'); ?></th>
				<th><?php echo __('User Id'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($user['Post'] as $post): ?>
				<tr>
					<td><?php echo $post['id']; ?></td>
					<td><?php echo $post['title']; ?></td>
					<td><?php echo $post['modified']; ?></td>
					<td><?php echo $post['user_id']; ?></td>
					<td class="actions">
						<?php echo $this->Html->link(__('View'), array('controller' => 'posts', 'action' => 'view', $post['id'])); ?>
						<?php 
							if ($post['user_id'] == AuthComponent::user('id')) {
								echo $this->Html->link(__('Edit'),
									array('controller' => 'posts', 'action' => 'edit', $post['id'])); 

								echo $this->Form->postLink(__('Delete'), array(
								'controller' => 'posts', 'action' => 'delete', $post['id']),
								array('message' => 'Are you sure ?'));
							}
							?>
					</td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>

		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
			</ul>
		</div>
	</div>
</div><p/><br>

