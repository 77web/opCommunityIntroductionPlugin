<?php slot('firstRow') ?>
<?php $communityTitle = $op_term['community']->titleize()->pluralize() ?>
<tr>
<th><?php echo __('%community% Name', array('%community%' => $communityTitle)) ?></th>
<td><?php echo $community->getName() ?></td>
</tr>
<?php end_slot() ?>
<?php
$options = array(
  'title' => __('Introduce this %community% to %friend%', array('%community%' => $communityTitle, '%friend%' => $op_term['friend']->pluralize())),
  'firstRow' => get_slot('firstRow'),
  'url' => url_for('@community_introduction_message_send?id='.$community->getId())
);
?>

<?php op_include_form('messageForm', $form, $options) ?>
