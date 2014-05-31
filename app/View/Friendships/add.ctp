<?php echo $this->Form->create('Friendship') ; ?>

<?php echo $this->Form->input('username', array('type' => 'text', 'label' => 'Friend Name', 'autocomplete' => 'off')); ?>
<div id="results">
</div>
<?php echo $this->Form->end(__('Add Friend')); ?>

<?php echo $this->Html->link('Back', array('action' => 'index')); ?>

<?php echo $this->Html->script('addFriend'); ?>