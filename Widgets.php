<?php

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
