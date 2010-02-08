<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * BaseCommunityIntroductionMessageForm form.
 *
 * @package    opCommunityIntroductionPlugin
 * @subpackage form
 * @author     Masato Nagasawa <nagasawa@tejimaya.com>
 */
abstract class BaseCommunityIntroductionMessageForm extends BaseSendMessageDataForm
{
  protected $community = null;

  public function __construct($object = null, $options = array(), $CSRFSecret = null)
  {
    if (isset($options['community']))
    {
      $this->community = $options['community'];
      unset($options['community']);
    }

    return parent::__construct($object, $options, $CSRFSecret);
  }

  public function setup()
  {
    BaseSendMessageDataForm::setup();

    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['foreign_id'],
      $this['member_id'],
      $this['is_deleted'],
      $this['is_send'],
      $this['message_type_id'],
      $this['subject'],
      $this['thread_message_id'],
      $this['return_message_id']
    );
    $this->setValidator('body', new sfValidatorString(array('required' => true, 'trim' => true)));

    // friends
    $this->setWidgetOfFriendsMember();
    $this->widgetSchema->setLabel('member_id_list', sfContext::getInstance()->getI18N()->__('Destination'));
    $this->widgetSchema->moveField('member_id_list', sfWidgetFormSchema::BEFORE, 'body');

    $this->widgetSchema->setNameFormat('message[%s]');
  }

  abstract protected function setWidgetOfFriendsMember();

  public function isValid()
  {
    if (!($this->community instanceof Community))
    {
      return false;
    }

    return parent::isValid();
  }

  public function updateObject($values = null)
  {
    $object = parent::updateObject($values);
    $object->setForeignId($this->community->getId());
    $object->setMemberId(sfContext::getInstance()->getUser()->getMemberId());
    $object->setSubject(sfContext::getInstance()->getI18N()->__('%Community% introduction message'));
    $object->setIsSend(1);

    $messageTypeId = Doctrine::getTable('MessageType')->getMessageTypeIdByName('community_introduction');
    $object->setMessageTypeId($messageTypeId);

    foreach ($this->getValue('member_id_list') as $memberId)
    {
      $this->saveSendList($object, $memberId);
    }

    return $object;
  }

  public function saveSendList(SendMessageData $message, $memberId)
  {
    $send = new MessageSendList();
    $send->setSendMessageData($message);
    $send->setMemberId($memberId);
    $send->save();
  }
}
