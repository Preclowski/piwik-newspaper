<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\Newspaper;

use Piwik\View;
use Piwik\WidgetsList;

class Widgets extends \Piwik\Plugin\Widgets
{
    protected $category = 'Newspaper_Newspaper';

    protected function init()
    {
        $this->addWidget('Articles Report', $method = 'getArticleReport');
        $this->addWidget('Paywall Plan Report', $method = 'getPaywallReport');
    }
}
