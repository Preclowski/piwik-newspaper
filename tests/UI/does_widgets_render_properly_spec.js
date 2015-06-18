describe("Does widgets render properly", function () {
    this.timeout(0);

    this.fixture = "Piwik\\Plugins\\Newspaper\\tests\\Fixtures\\ManyVisits";

    var generalParams = 'idSite=1&period=day&date=2010-01-03',
        urlBase = 'module=CoreHome&action=index&' + generalParams;

    before(function () {
        testEnvironment.pluginsToLoad = ['Newspaper'];
        testEnvironment.save();
    });

    it('should load a dashboard and take a full screenshot', function (done) {
        var screenshotName = 'does_article_and_paywall_widget_render_properly_on_dashboard';
        var urlToTest = "?" + generalParams + "&module=Newspaper&action=index";

        expect.screenshot(screenshotName).to.be.capture(function (page) {
            page.load(urlToTest);
        }, done);
    });
});