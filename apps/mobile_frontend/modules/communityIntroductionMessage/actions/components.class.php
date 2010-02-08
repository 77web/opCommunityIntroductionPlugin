<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * communityIntroductionMessage components.
 *
 * @package    OpenPNE
 * @subpackage communityIntroduction
 * @author     Masato Nagasawa <nagasawa@tejimaya.com>
 */
class communityIntroductionMessageComponents extends sfComponents
{
  public function executeMenu(sfWebRequest $requests)
  {
    $this->communityId = $requests->getParameter('id');
    $memberId = $this->getUser()->getMemberId();
    $this->countFriends = count(opCommunityIntroductionPlugin::getNotJoinCommunityFriendMemberIds($this->communityId, $memberId));
  }
}
