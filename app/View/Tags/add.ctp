<h1> Add tag </h1>
<?= $this->Form->create('Tag'); ?>
<?= $this->Form->input('content', array(
    'label' => 'Tag name',
    'value' => '#'
    ));
?>
<?= $this->Form->end(__('Add')); ?>