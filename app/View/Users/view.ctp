<?php
$specific_user_color="orange";
?>
<div id="espace_gauche"><?php echo $this->Session->flash(); ?>
	<div id="espace_gauche_avatar" style="background-color:<?php print $specific_user_color;?>; background-image:url('<?php print $user['User']['avatar'];?>')">
	 </div>
	<div id="espace_gauche_menu">
		<ul class="liste_style">
		
			<?php if ( AuthComponent::user('id') == $user['User']['id'] ) : ?>
				<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
			<?php endif; ?>
			
			<li><a href="#Posts">Posts</a></li>
			<li><a href="#Profiles">Profiles</a></li>
			
			<?php if (  $user['User']['role'] == 'author' || $user['User']['role'] == 'admin' ) : ?>
				<li><a href="#Articles">Articles</a></li>
			<?php endif;?>
			
			<?php if ( AuthComponent::user('id') == $user['User']['id'] && (AuthComponent::user('role') == 'author' || AuthComponent::user('role') == 'admin' )) : ?>
				<li style="text-align:center;background-color:green">Author actions</li>
				<li style="text-align:center;border:1px solid green"><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles', 'action' => 'add')); ?></li>
			<?php endif; ?>

			<?php if ( AuthComponent::user('role') == 'admin' ) : ?>
				<li style="text-align:center;background-color:#9d86b7">Admin actions</li>
				<li style="text-align:center;border:1px solid #9d86b7"><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
			<?php if (AuthComponent::user('id') == $user['User']['id'] ) : ?>
				<li style="text-align:center;border:1px solid #9d86b7"><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
				<li style="text-align:center;border:1px solid #9d86b7"><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
				<li style="text-align:center;border:1px solid #9d86b7"><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
				<li style="text-align:center;border:1px solid #9d86b7"><?php echo $this->Html->link(__('List Profiles'), array('controller' => 'profiles', 'action' => 'index')); ?> </li>
				<li style="text-align:center;border:1px solid #9d86b7"><?php echo $this->Html->link(__('New Profile'), array('controller' => 'profiles', 'action' => 'add'));?> </li>
			<?php endif; endif; ?>
			
		</ul>
	</div>
</div>
<div id="espace_droite">

	<a id="Posts" class=""></a>
	<a id="Profiles" class=""></a>
	<a id="Articles" class=""></a>
	
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

		<div class="related" id="idPosts">
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
		<div class="related" id="idProfiles">
			<h3><?php echo __('Related Profiles'); ?></h3>
			<?php if (!empty($user['Profile'])): ?>
			<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Game Name'); ?></th>
				<th><?php echo __('Pseudo'); ?></th>
				<th><?php echo __('Level'); ?></th>
				<th><?php echo __('Modified'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($user['Profile'] as $profile): ?>
				<tr>
					<td><?php echo $profile['id']; ?></td>
					<td><?php echo $profile['game_name']; ?></td>
					<td><?php echo $profile['pseudo']; ?></td>
					<td><?php echo $profile['level']; ?></td>
					<td><?php echo $profile['modified']; ?></td>
					<td class="actions">
						<?php echo $this->Html->link(__('View'), array('controller' => 'profiles', 'action' => 'view', $profile['id'])); ?>
						<?php echo $this->Html->link(__('Edit'), array('controller' => 'profiles', 'action' => 'edit', $profile['id'])); ?>
						<?php echo $this->Form->postLink(__('Delete'),
							array('controller' =>'profiles', 'action' => 'delete', $profile['id']),
							array('message' => 'Are you sure ?')
						);?>
					</td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>

			<div class="actions">
				<ul>
					<li><?php echo $this->Html->link(__('New Profile'), array('controller' => 'profiles', 'action' => 'add'
					)); ?> </li>
				</ul>
			</div>
		</div>

		<div class="related" id="idArticles">
			<h3><?php echo __('Related Articles'); ?></h3>
			<?php if (!empty($user['Article'])): ?>
			<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Title'); ?></th>
				<th><?php echo __('Modified'); ?></th>
				<th><?php echo __('Public'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($user['Article'] as $article): ?>
				<tr>
					<td><?php echo $article['id']; ?></td>
					<td><?php echo $article['title']; ?></td>
					<td><?php echo $article['modified']; ?></td>
					<td><?php echo $article['published']; ?></td>
					<td class="actions">
						<?php echo $this->Html->link(__('View'), array('controller' => 'articles', 'action' => 'view', $article['id'])); ?>
						<?php if ($article['author_id'] == AuthComponent::user('id')) : ?>
							<?php echo $this->Html->link(__('Edit'), array('controller' => 'articles', 'action' => 'edit', $article['id'])); ?>
							<?php echo $this->Form->postLink(__('Delete'),
								array('controller' =>'articles', 'action' => 'delete', $article['id']),
								array('message' => 'Are you sure ?')
							);?>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>
		<?php if (in_array(AuthComponent::user('role'), array('admin', 'author'))) : ?>
		<div class="actions">
				<ul>
					<li><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles', 'action' => 'add')); ?> </li>
				</ul>
			</div>
		</div>
		<?php endif; ?>

		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
			</ul>
		</div>
	<!--</div>-->
</div><p/><br>

