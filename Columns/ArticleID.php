<?php
namespace Piwik\Plugins\Newspaper\Columns;

use Piwik\Common;
use Piwik\Piwik;
use Piwik\Plugin\Dimension\ActionDimension;
use Piwik\Plugin\Segment;
use Piwik\Tracker\ActionPageview;
use Piwik\Tracker\Request;
use Piwik\Tracker\Visitor;
use Piwik\Tracker\Action;
use Piwik\UrlHelper;

class ArticleID extends ActionDimension
{
    /**
     * @var string
     */
    protected $columnName = 'article_id';

    /**
     * @var string
     */
    protected $columnType = 'INT unsigned';

    /**
     * @return string
     */
    public function getName()
    {
        return Piwik::translate('Newspaper_ArticleID');
    }

    protected function configureSegments()
    {
        $segment = new Segment();
        $segment->setSegment('keywords');
        $segment->setCategory('General_Actions');
        $segment->setName('Newspaper_ArticleID');
        $segment->setAcceptedValues('Article ID, integer');
        $this->addSegment($segment);
    }

    /**
     * @param Request $request
     * @param Visitor $visitor
     * @param Action $action
     *
     * @return mixed|false
     */
    public function onNewAction(Request $request, Visitor $visitor, Action $action)
    {
        if (!($action instanceof ActionPageview)) {
            return false;
        }

        $value = Common::getRequestVar(
            'ArticleId',
            false,
            'integer',
            UrlHelper::getArrayFromQueryString($action->getActionUrl())
        );

        if (false === $value) {
            return $value;
        }

        $value = trim($value);

        return substr($value, 0, 255);
    }
}