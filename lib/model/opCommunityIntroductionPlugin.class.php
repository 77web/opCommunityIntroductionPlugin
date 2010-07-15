<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityIntroductionPlugin
 *
 * @package    opCommunityIntroductionPlugin
 * @author     Masato Nagasawa <nagasawa@tejimaya.com>
 */

class opCommunityIntroductionPlugin
{
  static public function getCommunityMemberIds($communityId)
  {
    $communityMemberList = Doctrine::getTable('CommunityMember')->createQuery()
      ->select('member_id AS id')
      ->where('community_id = ?', $communityId)
      ->execute(array(), Doctrine::HYDRATE_ARRAY);

    $ids = array();
    foreach ($communityMemberList as $member)
    {
      $ids[] = $member['id'];
    }

    return $ids;
  }

  static public function getFriendMemberIds($memberId)
  {
    $friendMemberList = Doctrine::getTable('MemberRelationship')->createQuery()
      ->select('member_id_to AS id')
      ->where('member_id_from = ?', $memberId)
      ->andWhere('is_friend = ?' , true)
      ->execute(array(), Doctrine::HYDRATE_ARRAY);

    $ids = array();
    foreach ($friendMemberList as $member)
    {
      $ids[] = $member['id'];
    }

    return $ids;
  }

  static public function getNotJoinCommunityFriendMemberIds($communityId, $memberId, $size = null, $isRandom = false)
  {
    $communityMemberIds = self::getCommunityMemberIds($communityId);
    $friendMemberIds = self::getFriendMemberIds($memberId);
    $ids = array_diff($friendMemberIds, $communityMemberIds);

    if (count($ids) < $size)
    {
      $size = count($ids);
    }
    if ($isRandom)
    {
      shuffle($ids);
    }
    if ($size)
    {
      $ids = array_slice($ids, 0, $size);
    }

    return $ids;
  }

  static public function getNotJoinCommunityFriendMembers($communityId, $memberId, $size = null, $isRandom = false)
  {
    $ids = self::getNotJoinCommunityFriendMemberIds($communityId, $memberId, $size, $isRandom);
    if (!count($ids))
    {
      $ids[] = 0;
    }

    return Doctrine::getTable('Member')->createQuery()
      ->whereIn('id', $ids)
      ->execute();
  }

  static public function isInvitedCommunity($communityId, $memberId)
  {
    $community = Doctrine::getTable('Community')->find($communityId);
    $adminMemberId = $community->getAdminMember()->getId();

    $result = Doctrine::getTable('MessageSendList')->createQuery()
      ->select('id')
      ->where('member_id = ?', $memberId)
      ->andWhere('SendMessageData.member_id = ?', $adminMemberId)
      ->fetchOne();

    return $result ? true : false;
  }
}
