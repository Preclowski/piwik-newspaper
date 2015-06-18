<?php

namespace Piwik\Plugins\Newspaper;

use Piwik\View;

class Controller extends \Piwik\Plugin\Controller
{
    /**
     * @return string
     *
     * @throws \Exception
     */
    public function getPaywallReport()
    {
        return $this->renderReport(__FUNCTION__);
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    public function getArticleReport()
    {
        return $this->renderReport(__FUNCTION__);
    }
}
