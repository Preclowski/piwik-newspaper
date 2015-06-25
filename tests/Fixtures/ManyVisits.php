<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\Newspaper\tests\Fixtures;

use Piwik\Date;
use Piwik\Plugin\Manager;
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
    protected $articleIterations = 1;

    /**
     * @var int
     */
    public $idSite = 1;

    public function setUp()
    {
        $this->dateTime = Date::now()->getDatetime();
        $this->setUpWebsite();
        $this->trackVisits();
        $this->extraPluginsToLoad[] = 'Newspaper';
    }

    private function setUpWebsite()
    {
        self::createWebsite($this->dateTime);
    }

    /**
     * @throws \Exception
     */
    protected function trackVisits()
    {
        $tracker = self::getTracker(1, $this->dateTime, true, true);

        for ($i = 0; $i <= 100; $i++) {
            $tracker->setForceNewVisit(true);
            $tracker->setUrl('http://piwik.net/index.php?PaywallPlan=' . $this->getPaywallPlan() . '&ArticleId=' . $this->getArticleId());
            $pageview = $tracker->doTrackPageView('Viewing homepage ' . rand(0, 10000));

            self::checkResponse($pageview);
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

    protected function getPaywallPlan()
    {
        $this->articleIterations++;

        if ($this->articleIterations % 3 === 0) {
            return 3;
        } elseif ($this->articleIterations % 2 === 0) {
            return 2;
        } else {
            return 1;
        }
    }
}
