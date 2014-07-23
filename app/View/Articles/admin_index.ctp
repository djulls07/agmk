<table>
    <tr>
        <th><?= $this->paginator->sort('id', 'Id'); ?></th>
        <th><?= $this->Paginator->sort('username', 'Author'); ?></th>
        <th><?= $this->paginator->sort('title', 'Title'); ?></th>
        <th><?= $this->Paginator->sort('published', 'Public'); ?></th>
        <th><?= $this->paginator->sort('created', 'Added'); ?></th>
        <th><?= $this->paginator->sort('modified', 'Modified'); ?> </th>
        <th class="action"> <?php echo __('Action'); ?></th>
    </tr>
    <?php foreach ($articles as $article) : ?>
        <tr>
            <td><?php echo $article['Article']['id']; ?></td>
            <td><?php echo $article['User']['username']; ?></td>
            <td><?php echo $article['Article']['title']; ?></td>
            <td><?php echo $article['Article']['published']; ?></td>
            <td><?php echo $article['Article']['created']; ?></td>
            <td><?php echo $article['Article']['modified']; ?></td>
            <td>
            	<?php echo $this->Form->postLink('Delete', 
            	array('action' => 'delete', $article['Article']['id']),
            	array('message' => 'are you sure ?')
            	); ?>
            	<?php echo $this->Html->link('Edit', array('action' => 'edit', $article['Article']['id'])); ?>
            	<?php echo $this->Html->link('View', array('action' => 'view', $article['Article']['id'])); ?>
            </td>
        </tr>   
    <?php endforeach; ?>
</table>
