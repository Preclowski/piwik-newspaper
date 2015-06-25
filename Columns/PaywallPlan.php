<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\Newspaper\Columns;

use Piwik\Common;
use Piwik\Piwik;
use Piwik\Plugin\Dimension\VisitDimension;
use Piwik\Plugin\Segment;
use Piwik\Tracker\Request;
use Piwik\Tracker\Visitor;

class PaywallPlan extends VisitDimension
{
    /**
     * @var string
     */
    protected $columnName = 'paywall_plan';

    /**
     * @var string
     */
    protected $columnType = 'SMALLINT unsigned';

    /**
     * @return string
     */
    public function getName()
    {
        return Piwik::translate('Newspaper_PaywallPlan');
    }

    protected function configureSegments()
    {
        $segment = new Segment();
        $segment->setCategory('General_Visit');
        $segment->setName('Newspaper_Paywallplan');
        $segment->setAcceptedValues('ID of paywall plan');
        $this->addSegment($segment);
    }

    public function onNewVisit(Request $request, Visitor $visitor, $action)
    {
        $queryParams = $this->getArrayFromQueryString($action->getActionUrl());

        if (!ctype_digit($queryParams['PaywallPlan'])) {
            return false;
        }

        return Common::getRequestVar(
            'PaywallPlan',
            0,
            'integer',
            $queryParams
        );
    }

    /**
     * This method is temporary fix for broken UrlHelper class method
     *
     * @param $url
     *
     * @return array
     */
    protected function getArrayFromQueryString($url)
    {
        $parsedUrl = parse_url($url);
        $parsedParams = explode('&', $parsedUrl['query']);
        $queryParams = [];

        foreach ($parsedParams as $param) {
            $param = explode('=', $param);

            $queryParams[$param[0]] = $param[1];
        }

        return $queryParams;
    }
}