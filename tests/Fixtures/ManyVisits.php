<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\Newspaper\tests\Fixtures;

use Piwik\Date;
use Piwik\Tests\Framework\Fixture;
use Piwik\Tracker;

class ManyVisits extends Fixture
{
    /**
     * @var string
     */
    public $dateTime;

    /**
     * @var int
     */
    protected $articleIterations = 0;

    public $idSite = 1;

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
            $tracker->setUrl('http://example.com/?PaywallPlan=' . $this->getArticleId() . '&ArticleId=' . $this->getArticleId());

            self::checkResponse($tracker->doTrackPageView('Viewing homepage'));
        }
    }

    protected function getArticleId()
    {
        $this->articleIterations++;

        if ($this->articleIterations >= 60) {
            return 3;
        } elseif ($this->articleIterations >= 30) {
            return 2;
        } else {
            return 1;
        }
    }
}
