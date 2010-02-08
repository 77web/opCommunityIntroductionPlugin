<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommuntiyIntroductionPluginFrontendRouteCollection
 *
 * @package    opCommunityIntroductionPlugin
 * @subpackage routing
 * @author     Masato Nagasawa <nagasawa@tejimaya.com>
 */
class opCommuntiyIntroductionPluginFrontendRouteCollection extends opCommunityIntroductionPluginBaseRouteCollection
{
  protected function generateRoutes()
  {
    return array(
      'community_introduction_message_input' => new sfDoctrineRoute(
        '/communityIntroductionMessage/:id',
        array('module' => 'communityIntroductionMessage', 'action' => 'input'),
        array('id' => '\d+'),
        array('model' => 'Community', 'type' => 'object')
      ),
      'community_introduction_message_send' => new sfDoctrineRoute(
        '/communityIntroductionMessage/send/:id',
        array('module' => 'communityIntroductionMessage', 'action' => 'send'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'Community', 'type' => 'object')
      ),
    );
  }
}
