
<nav id="news">
    <?php foreach ($articles as $article) : $article = $article['Article']; ?>
        <div class="row">
            <div class="thumb">
                <?php echo '<a href="/Agamek/articles/view/' . $article['id']. '">'; ?>
                <?= $this->Media->image($article['thumb'], 175, 110); ?>
                </a>
                <p>&nbsp;</p>
            </div>
            <div class="after_thumb">
                <h3>
                    <?=
                    $this->Html->link($article['title'], array(
                        'controller' => 'articles',
                        'action' => 'view',
                        $article['id']
                        )
                    );
                    ?>
                </h3>
                <p> <?php echo $article['subtitle']; ?> </p>
            </div>
        </div>
<?php endforeach; ?>
</nav>