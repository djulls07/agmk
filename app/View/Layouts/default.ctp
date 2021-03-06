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
        <?php echo $this->Html->script("//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"); ?>
        <?php echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js');?>
        <?php echo $this->Html->css('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css'); ?>

        <!--Script pour actualiser messages -->
        <?php if (AuthComponent::user('id')) echo $this->Html->script('getUserNotifs'); ?>
        <?php echo $this->Html->script('searchBar'); ?>

        <?php echo $this->fetch('script'); ?>
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
				<div id="header_left_temporaire"> <img src="http://djpit.com/wp-content/uploads/2014/07/under-construction-girl.png" /> </div>
				<div id="header_right_temporaire"> <img src="/img/20130304-elite_auto_paint_supply_website_under_construction.png" /> </div>
                <?php echo $this->element('menubar')/*, array(),
                    array(
                        // utilise la configuration de cache "long_view"
                        "cache" => "long",
                        // défini à true pour avoir before/afterRender appelé pour l'element
                        "callbacks" => true
                    )
                )*/; ?>
				<?php echo $this->element('banniere')/*, array(),
                    array(
                        // utilise la configuration de cache "long_view"
                        "cache" => "long",
                        // défini à true pour avoir before/afterRender appelé pour l'element
                        "callbacks" => true
                    )
                )*/; ?>
				<?php echo $this->element('barre_specific')/*, array(),
                    array(
                        // utilise la configuration de cache "long_view"
                        "cache" => "long",
                        // défini à true pour avoir before/afterRender appelé pour l'element
                        "callbacks" => true
                    )
                )*/; ?>
            </div>
			</div>
			</div>
			
			<div class="page">
				<aside id="contentgauche">
				</aside>
				
				<aside id="contentdroite">
				</aside>
			
				<section id="contentcentre">
							
					<div class="content" id="centre">
						<?php echo $this->Session->flash(); ?>

						<?php echo $this->fetch('content'); ?>
						
						<?php echo $this->element('footer')/*, array(),
							array(
								// utilise la configuration de cache "long_view"
								"cache" => "long",
								// défini à true pour avoir before/afterRender appelé pour l'element
								"callbacks" => true)*/
								; 
						?>
					</div>
				</section>
				
			</div>
			<?php /*if (AuthComponent::user('id') == 72)*/ echo $this->element('chat'); ?>
        </div>
        <!--nocache-->
            <div style="positon:relative; bottom:1px; z-index:10;">
                <?php if (AuthComponent::user('username') == 'djulls07') {
                    echo '<div style="position:fixed;bottom:1px;z-index:10;">' . $this->element('sql_dump') . '</div>';  
                    //debug(AuthComponent::user());
                }
                ?></div>
        <!--/nocache-->
       <?php echo $this->Js->writeBuffer();?>
    </body>
</html>
