<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * communityIntroductionMessage acitons.
 *
 * @package    OpenPNE
 * @subpackage communityIntroduction
 * @author     Masato Nagasawa <nagasawa@tejimaya.com>
 */
abstract class opCommunityIntroductionPluginCommunityIntroductionMessageActions extends opCommunityIntroductionPluginActions
{
  public function getForm()
  {
    $app = $this->getContext()->getConfiguration()->getApplication();
    $app = str_replace(' ', '', ucwords(str_replace('_', ' ', $app)));

    $formClass = $app.'CommunityIntroductionMessageForm';

    return new $formClass(null, array('community' => $this->community));
  }

  public function executeInput(sfWebRequest $request)
  {
    $memberId = $this->getUser()->getMemberId();
    if (!count(opCommunityIntroductionPlugin::getNotJoinCommunityFriendMemberIds($this->community->getId(), $memberId)))
    {
      return sfView::ERROR;
    }

    $this->form = $this->getForm();
  }

  public function executeSend(sfWebRequest $request)
  {
    $this->form = $this->getForm();
    if (!$this->processForm($request, $this->form))
    {
      $this->setTemplate('input');
      return;
    }

    $message = sfContext::getInstance()->getI18N()->__('The %Community% introduction message was sent successfully.');
    $this->getUser()->setFlash('notice', $message); 
    $this->redirect('@community_home?id='.$this->community->getId());
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));

    if ($form->isValid())
    {
      $diary = $form->save();
    }

    return $form->isValid();
  }
} 
