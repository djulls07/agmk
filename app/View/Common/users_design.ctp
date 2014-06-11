<?php
$specific_user_color="orange";
$games_stats = array(
		array(
		'game_id'	=>	'4',
		'rank1'	=>	'80',
		'rank2'	=>	'700000'
	),
		array(
		'game_id'	=>	'3',
		'rank1'	=>	'80000',
		'rank2'	=>	'80'
	),
		array(
		'game_id'	=>	'0',
		'rank1'	=>	'80000',
		'rank2'	=>	'80'
	)
);
/* TODO: vérifier que les id_game correspondent bien à dex  jeux */
?>
<div id="espace_gauche">
	<div id="espace_gauche_avatar" style="background-color:<?php print $specific_user_color;?>; background-image:url('<?php print $user['User']['avatar'];?>')">
	 </div>
	<div id="espace_gauche_menu">
		<ul class="liste_style">
		
			<?php if ( AuthComponent::user('id') == $user['User']['id'] ) : ?>
				<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
			<?php else :
				echo '<li>';
					if ( ! $are_friends ) {
					
						echo $this->Form->create('Friendship',array('id'	=>	'FriendshipAddForm', 'url' => array('controller' => 'friendships', 'action' => 'add?url=friendships%2Fadd&back='.$user['User']['id']))) ;
						echo $this->Form->input('username', array(
							'type' => 'hidden', 
							'value'	=>	''.$user['User']['username'].''
						));
						echo $this->Form->input('user_id', array('type' => 'hidden', 'class' => 'inputAdd'));
						echo $this->Form->end(__('Add Friend'));
					}else
						echo 'Delete Friendship';
				echo '</li><li>'.
						$this->Html->link(__('Message'), array('controller'	=>	'messages',	'action' => 'ecrire?To='.$user['User']['id']))
					 .'</li>';
			endif; ?>
			
			<li><a href="#Posts">Posts</a></li>
			<li><a href="#Profiles">Profiles</a></li>
			
			<?php if (  $user['User']['role'] == 'author' || $user['User']['role'] == 'admin' ) : ?>
				<li><a href="#Articles">Articles</a></li>
			<?php endif;?>
			
			<?php if ( AuthComponent::user('id') == $user['User']['id'] && (AuthComponent::user('role') == 'author' || AuthComponent::user('role') == 'admin' )) : ?>
				<li style="text-align:center;background-color:green">Author actions</li>
				<li style="text-align:center;border:2px solid green"><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles', 'action' => 'add')); ?></li>
			<?php endif; ?>

			<?php if ( AuthComponent::user('role') == 'admin' ) : ?>
				<li style="text-align:center;background-color:#9d86b7">Admin actions</li>
				<li style="text-align:center;border:2px solid #9d86b7"><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
			<?php if (AuthComponent::user('id') == $user['User']['id'] ) : ?>
				<li style="text-align:center;border:2px solid #9d86b7"><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
				<li style="text-align:center;border:2px solid #9d86b7"><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
				<li style="text-align:center;border:2px solid #9d86b7"><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
				<li style="text-align:center;border:2px solid #9d86b7"><?php echo $this->Html->link(__('List Profiles'), array('controller' => 'profiles', 'action' => 'index')); ?> </li>
				<li style="text-align:center;border:2px solid #9d86b7"><?php echo $this->Html->link(__('New Profile'), array('controller' => 'profiles', 'action' => 'add'));?> </li>
			<?php endif; endif; ?>
			
		</ul>
	</div>
</div>
<div id="espace_droite">
	<?php echo $this->Session->flash(); ?>
	<a id="Posts" class=""></a>
	<a id="Profiles" class=""></a>
	<a id="Articles" class=""></a>
	
	<div id="espace_droite_top">
		<div id="espace_droite_user">
			<div id="espace_droite_user_flag">
				<img src="/img/flag_fr.png">
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
			<div class="espace_droite_stats_fleche">
				<a href="#stats-">&#9664;</a>
			</div>
				<?php foreach ( $games_stats as $game_stat ) : ?>
				<div class="espace_droite_stats_bloc">
					<?php if ($game_stat['game_id']) : ?>
						<div class="espace_droite_stats_bloc_logogame">
							<?php 	$logogame	=	"/img/icons/icon".$game_stat['game_id'].".png";
									if (! file_exists("../webroot".$logogame)) $logogame	=	'/img/agamek_logo_crop.png';
									print "<img src=\"".$logogame."\">";
							?>
						</div>
						<div class="espace_droite_stats_bloc_ranks">
							<div class="espace_droite_stats_bloc_rank">Level <?php print $game_stat['rank1']; ?>
							</div>
							<div class="espace_droite_stats_bloc_rank">Level <?php print $game_stat['rank2']; ?>
							</div>
						</div>
						<div class="espace_droite_stats_bloc_morestats"><a href="">More stats</a>
						</div>
						<?php else : ?>
							<a href="#" class="button">Add Game</a>
						<?php endif; ?>
				</div>
				<? endforeach; ?>
			<!--
			<div class="espace_droite_stats_bloc">
				<div class="espace_droite_stats_bloc_logogame" class="vertical_center_div">LogoGame
				</div>
				<div class="espace_droite_stats_bloc_ranks">
					<div class="espace_droite_stats_bloc_rank" class="vertical_center_div">rank1
					</div>
					<div class="espace_droite_stats_bloc_rank" class="vertical_center_div">rank2
					</div>
				</div>
				<div class="espace_droite_stats_bloc_morestats" class="vertical_center_div"><a href="">More stats</a>
				</div>
			</div>
			
			<div class="espace_droite_stats_bloc">
				<div class="espace_droite_stats_bloc_logogame" class="vertical_center_div">LogoGame
				</div>
				<div class="espace_droite_stats_bloc_ranks">
					<div class="espace_droite_stats_bloc_rank" class="vertical_center_div">rank1
					</div>
					<div class="espace_droite_stats_bloc_rank" class="vertical_center_div">rank2
					</div>
				</div>
				<div class="espace_droite_stats_bloc_morestats" class="vertical_center_div"><a href="">More stats</a>
				</div>
			</div>-->
			<div class="espace_droite_stats_fleche">
				<a href="#stats-">&#9654;</a>
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
		<?php endif; ?>
		</div>
		
		
	<?php echo $this->fetch('content');  ?>

	<!--</div>-->
</div><p/><br>

