/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

describe("Does widgets render properly", function () {
    this.timeout(0);

    this.fixture = "Piwik\\Plugins\\Newspaper\\tests\\Fixtures\\ManyVisits";

    before(function () {
        testEnvironment.configOverride = {
            General: {
                testmode: 'true'
            }
        };
        testEnvironment.pluginsToLoad = ['Newspaper'];
        testEnvironment.save();
    });

    it('should load a dashboard and take a full screenshot of article widget', function (done) {
        var screenshotName = 'does_article_widget_render_properly_on_dashboard';
        var urlToTest = '?module=Widgetize&action=iframe&idSite=1&period=year&date=today' +
            '&moduleToWidgetize=Newspaper&actionToWidgetize=getArticleReport';

        expect.screenshot(screenshotName).to.be.capture(function (page) {
            page.load(urlToTest);
        }, done);
    });

    it('should load a dashboard and take a full screenshot of paywall widget', function (done) {
        var screenshotName = 'does_paywall_widget_render_properly_on_dashboard';
        var urlToTest = '?module=Widgetize&action=iframe&idSite=1&period=year&date=today' +
            '&moduleToWidgetize=Newspaper&actionToWidgetize=getPaywallReport';

        expect.screenshot(screenshotName).to.be.capture(function (page) {
            page.load(urlToTest);
        }, done);
    });
});