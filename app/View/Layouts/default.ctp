<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <?php $this->Html->script('jquery-2.1.1.min.js'); ?>
        <?php $this->fetch('script'); ?>
        <title>
            <?php echo 'Agamek' ?>:
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('cake.generic');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        ?>
    </head>
    <body>
        <div id="container">
			<div class="container_absolute_top"><div class="barres_top">
            <div id="header">
                <!--nocache-->
                <?php echo $this->element('menubar'); ?>
				<?php echo $this->element('banniere'); ?>
				<?php echo $this->element('barre_specific'); ?>
                <!--/nocache-->
            </div>
			</div>
			</div>
			
			<div class="page">
				<div class="contentgauche">
				</div>
			
				<div class="contentcentre">
							
					<div class="content" id="centre">
						<?php echo $this->Session->flash(); ?>

						<?php echo $this->fetch('content'); ?>
					</div>
				</div>
				
				<div class="contentdroite">
				</div>
			</div>			
			
            <div id="footer">
                <?php /* echo $this->Html->link(
                  $this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
                  'http://www.cakephp.org/',
                  array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
                  ); */
                ?>
                <p>
                    <?php //echo $cakeVersion;  ?>
                </p>
            </div>
        </div>
        <!--nocache-->
            <?php //if (AuthComponent::user('role') == 'admin') echo $this->element('sql_dump');  ?>
        <!--/nocache-->
    </body>
</html>
