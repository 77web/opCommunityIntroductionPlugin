<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityIntroductionPluginObserver
 *
 * @package opCommunityIntroductionPlugin
 * @author  Masato Nagasawa <nagasawa@tejimaya.com>
 */
class opCommunityIntroductionPluginObserver
{
  public function decorateCommunityIntroductionBody(SendMessageData $message)
  {
    $id = $message->getForeignId();
    $community = Doctrine::getTable('Community')->find($id);
    if (!$community)
    {
      return $message->body;
    }

    $params = array(
      'fromMember' => $message->getMember(),
      'message'    => $message->body,
      'community'  => $community,
    );

    return opMessageSender::decorateBySpecifiedTemplate('communityIntroductionMessage', $params);
  }

  public function listenToPostActionEventCommunityJoin($arguments)
  {
    $memberId = sfContext::getInstance()->getUser()->getMemberId();
    $communityId = $arguments['actionInstance']->getVar('id');

    $communityMember = Doctrine::getTable('CommunityMember')
      ->retrieveByMemberIdAndCommunityId($memberId, $communityId);
    if (!$communityMember)
    {
      $communityMember = new CommunityMember();
      $communityMember->setCommunityId($communityId);
      $communityMember->setMemberId($memberId);
      $communityMember->setIsPre(true);
    }

    if ($communityMember->getIsPre())
    {
      $isInvited = opCommunityIntroductionPlugin::isInvitedCommunity($communityId, $memberId);
      if ($isInvited)
      {
        $communityMember->setIsPre(false);
        $communityMember->save();
        sfContext::getInstance()->getUser()->setFlash('notice', 'You have just joined to this %community%.');
        sfContext::getInstance()->getController()->redirect('community/home?id='.$communityId);
      }
    }
  }
}
