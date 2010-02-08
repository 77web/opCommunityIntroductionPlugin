<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityIntroductionPluginBaseRouteCollection
 *
 * @package    opCommunityIntroductionPlugin
 * @subpackage routing
 * @author     Masato Nagasawa <nagasawa@tejimaya.com>
 */
abstract class opCommunityIntroductionPluginBaseRouteCollection extends sfRouteCollection
{
  public function __construct(array $options)
  {
    parent::__construct($options);

    $this->routes = $this->generateRoutes();
    $this->routes += $this->generateNoDefaults();
  }

  abstract protected function generateRoutes();

  protected function generateNoDefaults()
  {
    return array(
      'community_introduction_nodefaults' => new sfRoute(
        '/communityIntroduction/*',
        array('module' => 'default', 'action' => 'error')
      ),
    );
  }
}
