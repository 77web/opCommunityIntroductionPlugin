<?php echo __('Send message as introduces this %community% to %friend%.') ?>
<?php echo __('If introduced from administrator of the %community%, you can join without the approval of the approval system.') ?>
<?php $communityTitle = $op_term['community']->titleize()->pluralize() ?>
<?php
$options = array(
  'title' => __('Introduce this %community% to %friend%', array('%community%' => $communityTitle, '%friend%' => $op_term['friend']->pluralize())),
  'url' => url_for('@community_introduction_message_send?id='.$community->getId())
);
?>
<?php
$body = __('I was joined into the %name% %community%. please join when good together with me.', array('%name%' => $community->getName()))
?>
<?php $form->getWidget('body')->setDefault($body) ?>
<?php op_include_form('messageForm', $form, $options) ?>

<?php echo __('* The choice of an destination place is random.') ?>
<?php echo __('* When the member who wants to send is not displayed on a list, please push %link% and update a display.', array('%link%' => link_to('ここ', '@community_introduction_message_input?id='.$community->getId()))) ?>
