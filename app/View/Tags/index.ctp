<?php
$this->extend('/Common/view');

$this->assign('title', 'Tags list');

$this->start('sidebar');
?>

<li>
    <?= $this->Html->link('Add', array('action' => 'add')); ?>
</li>
<?php $this->end(); ?>

<?= $this->Paginator->numbers(); ?>
<table>
<tr>
    <th> <?= $this->Paginator->sort('id', 'Id'); ?> </th>
    <th> <?= $this->Paginator->sort('tag', 'Tag'); ?> </th>
    <th> Actions </th>
    <th> Modified </th>
</tr>

<?php foreach($tags as $tag) : $tag = $tag['Tag']; ?>

<tr>
    <td> <?= $tag['id']; ?> </td>
    <td> <?= $tag['content']; ?> </td>
    <td>
        <?php
        echo $this->Html->link(
        'Edit',
        array('action' => 'edit', $tag['id'])
        );
        ?>
        <?php
        echo $this->Form->postLink(
        'Delete',
        array('action' => 'delete', $tag['id']),
        array('confirm' => 'Are you sure ?')
        );
        ?>
    </td>
    <td> <?= $tag['modified']; ?> </td>   
</tr>
<?php endforeach; ?>
<?php unset($tag); ?>
</table>

