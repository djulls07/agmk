<?php
App::uses('AuthComponent', 'Component');
$games = $this->requestAction(array('controller'=>'games', 'action' => 'listgames'));
$specific_user_color="orange";
$specific_user_avatar="images/avatar.png";
$specific_user_notifications=10;
$specific_user_messages=0;
$specific_user_GMT=2;
?>
<nav id='cssmenu'>
	<div class="home_barre"> <!-- home barre -->
		<div class="home_barre_user">
				<div class="home_barre_avatar" style="border: 2px solid <?php print $specific_user_color;?>"> 
				<?php echo $this->Html->image($specific_user_avatar, array(
					"alt" => "AVATAR",
					'url' => array('controller' => 'users', 'action' => 'view', AuthComponent::user('id'))
				));?>
				</div>
				<div class="home_barre_pseudo" style="border: 2px solid <?php print $specific_user_color;?>; border-left:0">
					<a href="?page=espace_membre"><?php print AuthComponent::user('username');?></a>
					<?php
						echo $this->Html->link(AuthComponent::user('username'), array(
							'controller' => 'users',
							'action' => 'view',
							AuthComponent::user('id')
							)
						);
					?>
				</div>
				<!--<div class="home_barre_connexion"><a href="?page=connexion">Connexion</a></div>
				<div class="home_barre_inscription"><a href="?page=inscription">Inscription</a></div>-->
		</div>
		
		<div class="home_barre_boutons">
			<div class="home_barre_bouton1">					
				<?php
					echo $this->Html->link('Accueil', array(
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
			<div class="home_barre_myteams">
				<?php
					echo $this->Html->link('| MyTeams', array(
						'controller' => 'articles',
						'action' => 'myteams',
						)
					);
				?>
			</div>
			<div class="home_barre_myevents">
				<?php
					echo $this->Html->link('| MyEvents |', array(
						'controller' => 'articles',
						'action' => 'myevents',
						)
					);
				?>
			</div>
		</div>
		
		<div class="home_barre_time">
			<div class="home_barre_time_date">
				<?php echo strftime("%d/%m/%y");?>
			</div>
			<div class="home_barre_time_heure">
				<?php echo strftime("%H:%M");?> GMT+<?php print $specific_user_GMT;?>
			</div>
		</div>
	</div>
    <ul>
        <li><?php
            echo $this->Html->link('Home', array(
                'controller' => 'articles',
                'action' => 'index'
                )
            );
            ?>
        </li>
        <li class='has-sub'>
            <?php
            echo $this->Html->link('Games', array(
                'controller' => 'articles',
                'action' => 'index'
                )
            );
            ?>
            <ul>
                <?php for($i=0; $i<count($games)-1; $i++): ?>
                <li>
                    <?php
                    echo $this->Html->link($games[$i]['Game']['name'], array(
                        'controller' => 'articles',
                        'action' => 'index',
                        $games[$i]['Game']['id']
                        )
                    );
                    ?>
                </li>
                <?php endfor; ?>
                <li class='last'>
                    <?php
                    echo $this->Html->link($games[$i]['Game']['name'], array(
                        'controller' => 'articles',
                        'action' => 'index',
                        $games[$i]['Game']['id']
                        )
                    );
                    ?>
                </li>
            </ul>
        </li>
        <li>
            <?php
            echo $this->Html->link('Forum', array(
                'controller' => 'posts',
                'action' => 'index'
                )
            );
            ?>
        </li>
        <li class='last'><a href='#'><span>Contact</span></a></li>
            <?php $user = AuthComponent::user(); ?>
            <?php if ($user): ?>
            <li>
                <?php
                echo $this->Html->link(
                    'Connected as ' . $user['username'], array(
                    'controller' => 'users',
                    'action' => 'view',
                    $user['id']
                    )
                );
                ?>
            </li>
            <li>
    <?php
    echo $this->Html->link('LogOut', array(
        'controller' => 'users',
        'action' => 'logout'
        )
    );
    ?>
            </li>
        <?php else: ?>
            <li>
    <?php
    echo $this->Html->link('LogIn', array(
        'controller' => 'users',
        'action' => 'login'
        )
    );
    ?>
            </li>
            <li>
    <?php
    echo $this->Html->link('Create account', array(
        'controller' => 'users',
        'action' => 'add'
        )
    );
    ?>
            </li>
<?php endif; ?>
        </li>
    </ul>
</nav>