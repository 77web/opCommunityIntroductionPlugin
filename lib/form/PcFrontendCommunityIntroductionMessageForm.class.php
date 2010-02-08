<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PcFrontendCommunityIntroductionMessageForm form.
 *
 * @package    opCommunityIntroductionPlugin
 * @subpackage form
 * @author     Masato Nagasawa <nagasawa@tejimaya.com>
 */
class PcFrontendCommunityIntroductionMessageForm extends BaseCommunityIntroductionMessageForm
{
  protected function setWidgetOfFriendsMember()
  {
    $memberList = opCommunityIntroductionPlugin::getNotJoinCommunityFriendMembers(
      $this->community->getId(), sfContext::getInstance()->getUser()->getMember());

    $memberNames = array();
    foreach ($memberList as $member)
    {
      $memberNames[$member->getId()] = $member->getName();
    }
    $this->setWidget('member_id_list', new sfWidgetFormSelectCheckbox(array('choices' => $memberNames, 'class' => 'memberCheckList')));
    $this->setValidator('member_id_list', new sfValidatorChoice(array('choices' => array_keys($memberNames), 'multiple' => true)));
  }
}
