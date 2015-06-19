<?php

namespace Piwik\Plugins\Newspaper\tests\Fixtures;

use Piwik\Date;
use Piwik\Tests\Framework\Fixture;
use Piwik\Tracker;

class ManyVisits extends Fixture
{
    public $dateTime = '';
    protected $articleIterations = 0;

    public function setUp()
    {
        $date = new \DateTime();
        $this->dateTime = $date->format('Y-m-d');
        $this->setUpWebsite();
        $this->trackVisits();
    }

    public function tearDown()
    {
    }

    private function setUpWebsite()
    {
        self::createWebsite($this->dateTime, $ecommerce = 0, 'Site 1');
    }

    /**
     * @throws \Exception
     */
    protected function trackVisits()
    {
        $tracker = self::getTracker(1, $this->dateTime, $defaultInit = true, true);

        for ($i = 0; $i <= 100; $i++) {
            $tracker->setForceNewVisit(true);
            //$tracker->setForceVisitDateTime(Date::factory($this->dateTime)->addHour(rand(0.1, 0.5))->getDatetime());
            $tracker->setUrl('http://example.com/?PaywallPlan=' . $this->getArticleId() . '&ArticleId=' . rand(0, 50));

            self::checkResponse($tracker->doTrackPageView('Viewing homepage'));
        }
    }

    protected function getArticleId()
    {
        $this->articleIterations++;

        if ($this->articleIterations >= 30) {
            return 2;
        } elseif ($this->articleIterations >= 60) {
            return 3;
        } else {
            return 1;
        }
    }
}
