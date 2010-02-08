<?php echo __('%name% sent you %Community% introduction message.', array('%name%' => $fromMember->getName())) ?>


<?php echo __('%community% Name') ?>:
<?php echo $community->getName() ?>


<?php if ($message): ?>
<?php echo __('Message') ?>:
<?php echo $message ?>
<?php endif; ?>


<?php echo __('URL of this %Community%') ?>

<?php echo url_for('@community_home?id='.$community->getId(), true) ?>
