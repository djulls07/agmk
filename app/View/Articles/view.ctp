<?php
	$this->extend('/Common/articles_design');
?>

<div id="article_gameinfo">
	GAME INFO
</div>
<div id="article_view">
	<div id="article_header">
		<div id="article_thumb">
			<img src="<?php echo $article['Article']['thumb']; ?>" />
		</div>
	</div>
	
	<div id="article_content">
		<div id="article_title">
			<?php echo $article['Article']['title']; ?>
		</div>
		<div id="article_date">
			Le <?php echo date('d/m/Y',strtotime($article['Article']['created'])).', par <a href="/users/view/'.$article['User']['id'].'">'.$article['User']['username'].'</a>';  ?>
		</div>
		<!--<div id="article_intro">
			<?php echo $article['Article']['intro']; ?>
		</div>-->
		
		<?php echo $article['Article']['body']; ?>
	
	
		<div id="article_user">
			<div id="article_user_img">
				<?php $image = "../../img/avatar.jpg";
					if ( ! empty($article['User']['avatar']) )
					if ( file_exists ( $article['User']['avatar'] ) )
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
				Article rédigé par
				<?php	echo $this->Html->link($article['User']['username'], array(
									'controller' => 'users',
									'action' => 'view',
									$article['User']['id']
								)
							);	
				?>
				<p>
				"<?php echo $article['User']['description']; ?>"
				</p>
				<a href="">Suivre cet auteur</a> <a href="">Partager cet article</a>
			</div>
		</div>
	</div>
</div>

<div id="article_social">
		<a href="/acomments/add/<?php echo $article['Article']['id'];?>"> <img src="/img/messages_article.png" /></a>
</div>
<div id="article_comments"><a name="comments"></a>
	<?php foreach ($article['Acomment'] as $comment):?>
		<div class="article_comment">
			<div class="article_comment_image">
			<?php echo $this->Html->image($comment['User']['avatar'], array(
						"alt" => "AVATAR")); ?>
			</div>
			<div class="article_comment_text">
				<div class="article_comment_text_title">
					<?php 
						echo $this->Html->link($comment['User']['username'], array(
								'controller' => 'users',
								'action' => 'view',
								$comment['user_id']
							)
						);
						echo "<span style=\"float:right\">".date('d/m/Y H:i:s',strtotime($comment['created']))."</span>";
					?>
				</div>
				<div class="article_comment_text_text">
					<?php echo h($comment['content']); ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>


