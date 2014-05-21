<?php
App::uses('AuthComponent', 'Component');
$games = $this->requestAction(array('controller'=>'games', 'action' => 'listgames'));
?>
<nav id='cssmenu'>
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