<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

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
