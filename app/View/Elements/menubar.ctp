<?php
App::uses('AuthComponent', 'Component');
$games = $this->requestAction(array('controller'=>'games', 'action' => 'listgames'));
$specific_user_color="orange";
$specific_user_avatar="avatar.jpg";
$specific_user_notifications=10;
$specific_user_messages=0;
$specific_user_GMT=2;
?>
<nav id='cssmenu'>
	<div class="home_barre"> <!-- home barre -->
		<div class="home_barre_user">
			<?php if (AuthComponent::user()): ?>
				<div class="home_barre_avatar" style="border: 2px solid <?php print $specific_user_color;?>"> 
					<?php	echo $this->Html->image($specific_user_avatar, array(
						"alt" => "AVATAR",
						'url' => array('controller' => 'users', 'action' => 'view', AuthComponent::user('id'))
					));?>
				</div>
				<div class="home_barre_pseudo" style="border: 2px solid <?php print $specific_user_color;?>; border-left:0">
					<?php
						echo $this->Html->link(AuthComponent::user('username'), array(
							'controller' => 'users',
							'action' => 'view',
							AuthComponent::user('id')
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
			<div class="home_barre_bouton2">
				<?php
					echo $this->Html->link($specific_user_notifications, array(
						'controller' => 'articles',
						'action' => 'index',
						)
					);
				?>
			</div>
			<div class="home_barre_bouton3">
				<?php
					echo $this->Html->link($specific_user_messages, array(
						'controller' => 'articles',
						'action' => 'mymessages',
						)
					);
				?>
			</div>
		</div>
		
		<div class="home_barre_mines">
			<div class="home_barre_mything">
				<?php
					echo $this->Html->link('| MyTeams', array(
						'controller' => 'articles',
						'action' => 'myteams',
						)
					);
				?>
			</div>
			<div class="home_barre_mything">
				<?php
					echo $this->Html->link('| MyEvents |', array(
						'controller' => 'articles',
						'action' => 'myevents',
						)
					);
				?>
			</div>
			<div class="home_barre_mything">
				<?php
					echo $this->Html->link(' LogOut |', array(
						'controller' => 'users',
						'action' => 'logout',
						)
					);
				?>
			</div>
		</div>
		<?php 
			else: 
				print "<div class=\"home_barre_connexion\">";
				echo $this->Html->link('LogIn', array(
					'controller' => 'users',
					'action' => 'login'
					)
				);
				print"</div><div class=\"home_barre_inscription\">";
				echo $this->Html->link('Create account', array(
					'controller' => 'users',
					'action' => 'add'
				)
				);
				print"</div></div>";
			endif;
		?>
		<div class="home_barre_time">
			<div class="home_barre_time_date">
				<?php echo strftime("%d/%m/%y");?>
			</div>
			<div class="home_barre_time_heure">
				<?php echo strftime("%H:%M");?> GMT+<?php print $specific_user_GMT;?>
			</div>
		</div>
	</div>
    
</nav>