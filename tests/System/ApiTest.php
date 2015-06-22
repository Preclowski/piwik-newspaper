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
use Piwik\Tests\Framework\TestCase\SystemTestCase;

/**
 * @group Plugins
 * @group ApiTest
 * @group Newspaper
 */
class ApiTest extends SystemTestCase
{
    /**
     * @var ManyVisits
     */
    public static $fixture = null;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     *
     * @throws mixed
     */
    public function apiMethodsReturnExpectedResult()
    {
        $this->runApiTests('Newspaper.getArticleReport', array(
            'idSite' => self::$fixture->idSite,
            'date' => self::$fixture->dateTime
        ));
    }

    /**
     * @test
     */
    public function reportResultCountAsExpected()
    {
        $api = API::getInstance()->getArticleReport(self::$fixture->idSite, 'day', self::$fixture->dateTime);

        $this->assertEquals(3, $api->getRowsCount());
    }

    /**
     * @test
     */
    public function emptyReportReturlNothing()
    {
        $api = API::getInstance()->getArticleReport(self::$fixture->idSite, 'day', '2000-01-01');

        $this->assertEquals(0, $api->getRowsCount());
    }
}

ApiTest::$fixture = new ManyVisits;