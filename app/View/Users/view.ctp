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
		'game_id'	=>	'16',
		'rank1'	=>	'80000',
		'rank2'	=>	'80'
	)
);

/* TODO: vérifier que les id_game correspondent bien à des  jeux */
?>


<div id="espace_gauche">
	<!--<div id="espace_gauche_avatar" style="background-color:<?php print $specific_user_color;?>;" >-->
	<div id="espace_gauche_avatar">
		<a href="<?php print $user['User']['avatar'];?>"><img src="<?php print $user['User']['avatar'];?>"></a>
		<img src="/img/rank_gold.png" />
	</div>
	<div id="espace_gauche_menu">
		<ul class="liste_style">
		
			<?php if ( AuthComponent::user('id') == $user['User']['id'] ) : ?>
				<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
			<?php 
			endif; ?>
			
			<li><a href="#Posts" onclick="this.className='li_visited'">Posts</a></li>
			<li><a href="#Profiles" onclick="this.className='li_visited'">Profiles</a></li>
			
			<?php if (  $user['User']['role'] == 'author' || $user['User']['role'] == 'admin' ) : ?>
				<li><a href="#Articles">Articles</a></li>
			<?php endif;?>
		</ul>
		
			
		<?php if ( AuthComponent::user('id') == $user['User']['id'] && (AuthComponent::user('role') == 'author' || AuthComponent::user('role') == 'admin' )) : ?>
		<ul class="liste_style" style="border:2px solid green">
			<li>Author actions</li>
			<li><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles', 'action' => 'add')); ?></li>
		</ul>
		<?php endif; ?>		
		
		<?php if ( AuthComponent::user('role') == 'admin' ) : ?>
		<ul class="liste_style" style="border:2px solid red">
			<li>Admin actions</li>
			<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<?php if (AuthComponent::user('id') == $user['User']['id'] ) : ?>
			<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List Profiles'), array('controller' => 'profiles', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New Profile'), array('controller' => 'profiles', 'action' => 'add'));?> </li>
			<li><?php echo $this->Html->link(__('List Games'), array('controller' => 'games', 'action' => 'index'));?> </li>
			<li><?php echo $this->Html->link(__('New Game'), array('controller' => 'games', 'action' => 'add'));?> </li>
		</ul>
		<?php endif; endif; ?>
			
	</div>
</div>
<div id="espace_droite">	
	<div id="espace_droite_top">
	
		<div id="espace_droite_user">
			<img src="/img/flag_fr.png">

			<span id="espace_droite_user_pseudo">
				<?php echo __(h($user['User']['username'])); ?>
			</span>
			
			<span id="espace_droite_user_pseudo_id"><?php echo __('Id:').h($user['User']['id']); ?></span>

			<div id="espace_droite_user_team">
			
				<?php if ( AuthComponent::user('id') != $user['User']['id'] ) :
					echo '<div class="icone_user">';
						if ( ! $are_friends ) {
						
							echo $this->Form->create('Friendship',array('div' => false, 'id'	=>	'FriendshipAddForm', 'url' => array('controller' => 'friendships', 'action' => 'add?url=friendships%2Fadd&back='.$user['User']['id']))) ;
								echo $this->Form->input('username', array(
									'type' => 'hidden', 
									'value'	=>	''.$user['User']['username'].''
								));
								echo $this->Form->input('user_id', array('type' => 'hidden', 'class' => 'inputAdd'));
								echo $this->Form->submit('', array('type'=>'image','div'=>false,'title'=>'Add Friend','src' => '/img/add_friend.png')); 
							echo $this->Form->end();
						}
						else
						{
							echo $this->Form->create('Friendship',array('div' => false, 'id'	=>	'FriendshipAddForm', 'url' => array('controller' => 'friendships', 'action' => 'remove?url=friendships%2Fadd&back='.$user['User']['id']))) ;
								echo $this->Form->input('username', array(
									'type' => 'hidden', 
									'value'	=>	''.$user['User']['username'].''
								));
								echo $this->Form->input('user_id', array('type' => 'hidden', 'class' => 'inputAdd'));
								echo $this->Form->submit('', array('type'=>'image','div'=>false,'title'=>'Remove Friend','src' => '/img/delete_friend.png')); 
							echo $this->Form->end();
						}
						echo "</div><div class='icone_user'>";
						echo $this->Html->image("/img/mail.png", array ( 'title'	=>	"Message",	'url' => array('controller' => 'messages','action'=> 'ecrire?To='.$user['User']['id'])));
						echo"</div>";
				endif; ?>
				
				<a href=""><?php //echo __(h($user['User']['username']))."team";?></a>
			</div>
		</div>
		
		<div id="espace_droite_userinfoslevel">
			<div id="espace_droite_userinfos">
				<table>
					<tr>
						<td>Age</td>
						<td>-2</td>
					</tr>
					<tr>
						<td>Sexe</td>
						<td>gros</td>
					</tr>
					<tr>
						<td>Pays</td>
						<td>France</td>
					</tr>
					<tr>
						<td>Main Team</td>
						<td>PSG</td>
					</tr>
				</table>
			</div>
			<div id="espace_droite_stats_rewards">
				<div id="espace_droite_stats_rewards_title"><span>LEVEL</span></div>
				<img src="/img/level9.png"/>
				<br>
				MANA STONE
			</div>
		</div>
		
		<div id="espace_droite_experience">
			<div id="xp_level">10</div>
			<div id="xp_barre" onclick="document.getElementById('xp_barre').style.width='500px'"> </div>
			<img src="/img/barre_xp.png"/>
			<!--<div class="espace_droite_experience_level espace_droite_experience_level_min">9</div>
			<div class="progress-bar"></div>
			<div class="espace_droite_experience_level espace_droite_experience_level_max">10</div>-->
		</div>
		
		<div id="espace_droite_stats_ranksrewards">
			<div id="espace_droite_stats">
				<div id="espace_droite_stats_titre">
					<span>AGAMEK</span><span>OFFICIAL</span>
				</div>
				
				<ul id="espace_droite_stats_ranks">
					<?php 	foreach ( $games_stats as $game_stat ) : 
						if ($game_stat['game_id']) :?>
							<li>
								<div class="espace_droite_stats_ranks_logojeu"><div class="espace_droite_stats_ranks_border">
									<?php 	$logogame	=	"/img/icons/logo_gameid-".$game_stat['game_id'].".png";
										if (! file_exists("../webroot".$logogame)) $logogame	=	'/img/agamek_logo_crop.png';
										print "<img src=\"".$logogame."\">";
									?>
								</div></div>
								<div class="espace_droite_stats_rank"><div class="espace_droite_stats_ranks_border">
									Level <?php print $game_stat['rank1']; ?>
								</div></div>
								<div class="espace_droite_stats_rank"><div class="espace_droite_stats_ranks_border">
									Level <?php print $game_stat['rank2']; ?>
								</div></div>
							</li>
						<?php else : ?>
							<li>Add Game</li>
						<?php endif; ?>
					<? endforeach; ?>
				</ul>
				
				<div id="espace_droite_stats_seemore">
					<a href="">SEE MORE</a>
				</div>	
			</div>
			
			<div id="espace_droite_stats_rewards">
				<div id="espace_droite_stats_rewards_title"><span>REWARDS</span></div>
				<ul>
					<li><div class="star-five"> </div><div class="star-five"> </div><div class="star-five"> </div><div class="star-five"> </div><div class="star-five"> </div></li>
					<li><div class="star-five"> </div><div class="star-five"> </div><div class="star-five"> </div><div class="star-five"> </div><div class="star-five"> </div></li>
					<li><div class="star-five"> </div><div class="star-five"> </div><div class="star-five"> </div><div class="star-five"> </div><div class="star-five"> </div></li>
					<li><div class="star-five"> </div><div class="star-five"> </div><div class="star-five"> </div><div class="star-five"> </div><div class="star-five"> </div></li>
				</ul>
			</div>
		</div>
	</div>
	
	<div id="wall">
		<a id="Posts" class=""></a>
		<a id="Profiles" class=""></a>
		<a id="Articles" class=""></a>
		<?php echo $this->Session->flash(); ?>
		<div id="idPosts">
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
		<div id="idProfiles">
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
		<div id="idArticles">
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
		


		<!--<ul>
			<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
		</ul>-->
	</div>


</div>

