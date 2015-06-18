<?php

namespace Piwik\Plugins\Newspaper\Columns;

use Piwik\Common;
use Piwik\Piwik;
use Piwik\Plugin\Dimension\VisitDimension;
use Piwik\Plugin\Segment;
use Piwik\Tracker\Request;
use Piwik\Tracker\Visitor;
use Piwik\Tracker\Action;
use Piwik\UrlHelper;

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
        $segment->setSegment('achievementPoints');
        $segment->setCategory('General_Visit');
        $segment->setName('Newspaper_Paywallplan');
        $segment->setAcceptedValues('Name of paywall plan');
        $this->addSegment($segment);
    }

    public function onNewVisit(Request $request, Visitor $visitor, $action)
    {
        if (empty($action)) {
            return 0;
        }

        return Common::getRequestVar('PaywallPlan', 0, 'string', UrlHelper::getArrayFromQueryString($action->getActionUrl()));
    }
}