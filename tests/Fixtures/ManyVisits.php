<?php

namespace Piwik\Plugins\Newspaper\tests\Fixtures;

use Piwik\Date;
use Piwik\Tests\Framework\Fixture;

class ManyVisits extends Fixture
{
    public $dateTime = '2015-06-18 01:23:45';

    public function setUp()
    {
        $this->setUpWebsite();
        $this->trackVisit(1);
        $this->trackVisit(2);
        $this->trackVisit(3);
    }

    public function tearDown()
    {
    }

    private function setUpWebsite()
    {
        for ($i = 1; $i <= 3; $i++) {
            if (!self::siteCreated($i)) {
                $idSite = self::createWebsite($this->dateTime, $ecommerce = 0, 'Site ' . $i);
                $this->assertSame($i, $idSite);
            }
        }
    }

    /**
     * @param $idSite
     *
     * @throws \Exception
     */
    protected function trackVisit($idSite)
    {
        $tracker = self::getTracker($idSite, $this->dateTime, $defaultInit = true);

        for ($i = 0; $i <= 100; $i++) {
            $tracker->setForceVisitDateTime(Date::factory($this->dateTime)->addHour(rand(0.1, 0.5))->getDatetime());
            $tracker->setUrl('http://example.com/?PaywallPlan=' . rand(1, 3) . '&ArticleId=' . rand(0, 50));
            self::checkResponse($tracker->doTrackPageView('Viewing homepage'));
        }
    }
}
