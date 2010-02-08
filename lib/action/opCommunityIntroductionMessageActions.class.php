<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * base actions class for the opCommunityIntroductionPlugin.
 *
 * @package    OpenPNE
 * @subpackage communityIntroduction
 * @author     Masato Nagasawa <nagasawa@tejimaya.com>
 */
abstract class opCommunityIntroductionPluginActions extends sfActions
{
  public function initialize($context, $moduleName, $actionName)
  {
    parent::initialize($context, $moduleName, $actionName);

    $this->security['all'] = array('is_secure' => true, 'credentials' => 'SNSMember');
  }

  public function preExecute()
  {
    sfConfig::set('sf_nav_type', 'community');

    $this->community = $this->getRoute()->getObject();
  }
}
