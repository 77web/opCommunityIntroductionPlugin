<?php op_include_box('error', __('There is not %friend% you can introduce.', array('%friend%' => $op_term['friend'])), array('title' => __('Errors'))) ?>

<?php use_helper('Javascript') ?>
<?php op_include_line('backLink', link_to_function(__('Back to previous page'), 'history.back()')) ?>
