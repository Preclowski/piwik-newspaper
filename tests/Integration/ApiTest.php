<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\Newspaper\tests\Integration;

use Piwik\Plugins\Newspaper\API;
use Piwik\Plugins\Newspaper\tests\Fixtures\ManyVisits;
use Piwik\Tests\Framework\Fixture;
use Piwik\Tests\Framework\TestCase\IntegrationTestCase;

/**
 * @group Plugins
 * @group ApiTest
 * @group Newspaper
 */
class ApiTest extends IntegrationTestCase
{
    /**
     * @var Fixture
     */
    public static $fixture = null;

    /**
     * @test
     *
     * @throws mixed
     */
    public function apiMethodsReturnExpectedResult()
    {
        $this->runApiTests('Newspaper.getArticleReport', array(
            'idSite' => self::$fixture->idSite,
            'date' => 'today'
        ));
        $this->runApiTests('Newspaper.getPaywallReport', array(
            'idSite' => self::$fixture->idSite,
            'date' => 'today'
        ));
    }

    /**
     * @test
     */
    public function articleReportResultCountAsExpected()
    {
        $api = API::getInstance()->getArticleReport(self::$fixture->idSite, 'day', 'today');

        $this->assertEquals(3, $api->getRowsCount());
    }

    /**
     * @test
     */
    public function emptyArticleReportReturlNothing()
    {
        $api = API::getInstance()->getArticleReport(self::$fixture->idSite, 'day', '2000-01-01');

        $this->assertEquals(0, $api->getRowsCount());
    }

    /**
     * @test
     */
    public function paywallReportResultCountAsExpected()
    {
        $api = API::getInstance()->getPaywallReport(self::$fixture->idSite, 'day', 'today');

        $this->assertEquals(2, $api->getRowsCount());
    }

    /**
     * @test
     */
    public function emptyPaywallReportReturlNothing()
    {
        $api = API::getInstance()->getPaywallReport(self::$fixture->idSite, 'day', '2000-01-01');

        $this->assertEquals(0, $api->getRowsCount());
    }
}

ApiTest::$fixture = new ManyVisits;