<?php if ($countFriends): ?>
<?php
echo link_to(
  __('Introduce to %friend%'),
  '@community_introduction_message_input?id='.$communityId
)
?><br>
<?php endif ?>
