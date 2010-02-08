<?php
$this->dispatcher->connect(
  'op_message_plugin.decorate_body',
  array('opCommunityIntroductionPluginObserver', 'decorateCommunityIntroductionBody')
);

$this->dispatcher->connect(
  'op_action.post_execute_community_join',
  array('opCommunityIntroductionPluginObserver', 'listenToPostActionEventCommunityJoin')
);
