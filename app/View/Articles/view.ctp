<?php
	$this->extend('/Common/articles_design');
?>

<div id="article_gameinfo">
	GAME INFO
</div>
<div id="article_view">
	<div id="article_header">
		<div id="article_thumb">
			<?php //$this->Media->image($article['Article']['thumb'], 175, 110); ?>
		</div>
		<div id="article_title">
			<h1><?php echo $article['Article']['title']; ?></h1>
		</div>
		<div id="article_intro">
			<?php echo $article['Article']['intro']; ?>
		</div>
	</div>
	<div id="article_content">
		<?php echo $article['Article']['body']; ?>
	</div>
</div>
<div id="article_user">
	<div id="article_user_img">
		<?php $image = "../../img/avatar.jpg";
			if ( ! empty($article['User']['avatar']) )
			if ( file_exists ( $article['User']['avatar'] ) ) // toussa à mettre dans le model de l'user
				$image = $article['User']['avatar'];
			else
			{
				$file_headers = @get_headers($article['User']['avatar']);
				if($file_headers[0] != 'HTTP/1.1 404 Not Found')
					$image = $article['User']['avatar'];
			}
			print "<img src='".$image."'>";
		?>
	</div>
	<div id="article_user_text">
		<?php	echo $this->Html->link("Article rédigé par ".$article['User']['username'], array(
							'controller' => 'users',
							'action' => 'view',
							$article['User']['id']
						)
					);			
		?>
		<p>
		"<?php echo $article['User']['description']; ?>"
		</p>
		<a href="">Suivre cet auteur</a>
	</div>
</div>
<div id="article_social">
	<a href="">Partager cet article</a>
	<li>
		<?php echo $this->Html->link('Add comment', array(
				'controller' => 'acomments',
				'action' => 'add',
				$article['Article']['id']
			)
		); ?>
	</li>
</div>
<div class="comments">
	<?php foreach ($article['Acomment'] as $comment): ?>
		<p><?php echo h($comment['body']); ?> <br />
		<small>
			<?php 
				echo $this->Html->link($comment['User']['username'], array(
						'controller' => 'users',
						'action' => 'view',
						$comment['user_id']
					)
				);
			?>
		</small></p>
	<?php endforeach; ?>
</div>
</div>


