<div id="article_view">
	<div id="article_header">
		<div class="thumb">
		    <?= $this->Media->image($article['thumb'], 175, 110); ?>
		    <p>&nbsp;</p>
	    </div>
	    <div class="article_title">
	    	<?php echo h($article['Article']['title']); ?>
	    </div>
	    <div class="article_intro">
	    	<?php echo h($article['Article']['intro']); ?>
	    </div>
	</div>
	<div id="article_content">
		<?php echo h($article['Article']['body']); ?>
	</div>
</div>