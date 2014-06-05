<?php
$specific_user_color="orange";
$specific_user_messages=0;
$specific_user_GMT=2;
?>

	<div class="home_barre"> <!-- home barre -->
		<div class="home_barre_user">
			<?php if (AuthComponent::user()): $user=AuthComponent::user();?>
				<div class="home_barre_avatar" style="border: 2px solid <?php print $specific_user_color;?>; border-bottom-width:4px"> 
					<?php	echo $this->Html->image($user['avatar'], array(
						"alt" => "AVATAR",
						'url' => array('controller' => 'users', 'action' => 'view', $user['id'])
					));?>
				</div>
				<div class="home_barre_pseudo" style="border: 2px solid <?php print $specific_user_color;?>; border-left:0; border-bottom-width:4px">
					<?php
						echo $this->Html->link($user['username'], array(
							'controller' => 'users',
							'action' => 'view',
							$user['id']
							)
						);
					?>
				</div>
		</div>
		
		<div class="home_barre_boutons">
			<div class="home_barre_bouton1">					
				<?php
					echo $this->Html->link(' ', array(
						'controller' => 'articles',
						'action' => 'index',
						)
					);
				?>
			</div>
			<div class="home_barre_bouton2 <?php if ($user['notifications']) print "home_barre_boutons_plop"; ?>">
				<?php
					echo $this->Html->link($user['notifications'], array(
						'controller' => 'notifications',
						'action' => 'index',
						)
					);
				?>
			</div>
			<div class="home_barre_bouton3 <?php if ($user['messages']) print "home_barre_boutons_plop"; ?>">
				<?php
					echo $this->Html->link(' ', array(
						'controller' => 'messages',
						'action' => 'received',
						)
					);
				?>
			</div>
		</div>
		
		<nav class="home_barre_mines" style="float:left">
			<ul>
			<li>
				<?php
					echo $this->Html->link('MyTeams', array(
						'controller' => 'teams',
						'action' => 'index',
						)
					);
				?>
			</li>
			<li>
				<?php
					echo $this->Html->link('MyEvents', array(
						'controller' => 'events',
						'action' => 'index',
						)
					);
				?>
			</li>
			<li>
				<a href=""> MyGames <span style="vertical-align	:	bottom">&#9660;</span></a>
				<ul>
					<li><a href="#">Tetris</a></li>
					<li><a href="#">Pacman</a></li>
					<li><a href="#">Candy Crush Saga</a></li>
				</ul>
				<?php
					/*echo $this->Html->link('LogOut', array(
						'controller' => 'users',
						'action' => 'logout',
						)
					);*/
				?>
			</li>
			<li>
				<?php
					echo $this->Html->link('Social', array(
						'controller' => 'friendships',
						'action' => 'index',
						)
					);
				?>
			</li>
			<li>
				<?php echo $this->Form->input('searchBar', array('label' => '', 'id' => 'searchBar'));?>
				<div id="searchBarResults"></div>
			</li>
		</nav>
		<?php 
			else: 
				print "</div><nav class=\"home_barre_mines\"><ul><li>";
				echo $this->Html->link('LogIn', array(
					'controller' => 'users',
					'action' => 'login'
					)
				);
				print"</li><li>";
				echo $this->Html->link('Create account', array(
					'controller' => 'users',
					'action' => 'add'
				)
				);
				print"</li></ul></nav>
				<div class=\"home_barre_boutons\"><div class=\"home_barre_bouton1\">";
					echo $this->Html->link(' ', array(
						'controller' => 'articles',
						'action' => 'index',
						)
					);
				?>
				</div>
			</div>
		<?php endif;
		?>
		<nav class="home_barre_mines" style="float:right;">
		<ul>
			<?php if (AuthComponent::user()): $user=AuthComponent::user();?>
			<li>
				<?php
					echo $this->Html->link('LogOut', array(
						'controller' => 'users',
						'action' => 'logout',
						)
					);
				?>
			</li>
			<? endif; ?>
			<li>
					<a href=""><?php echo strftime("%H:%M");?> GMT+<?php print $specific_user_GMT;?></a>
					<ul style="right:0;"><li>
						<?php echo $this->Html->link('AgamekTimeConverter', array(
								'controller' => 'articles',
								'action' => 'index',
								)
							);
						?>
					</li></ul>
			</li>
		</ul>
		</nav>
	</div>
    
