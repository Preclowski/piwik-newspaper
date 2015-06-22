<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\Newspaper;

use Piwik\ArchiveProcessor;
use Piwik\DataAccess\LogAggregator;
use Piwik\DataTable;
use Piwik\Metrics;
use Piwik\Piwik;

class Archiver extends \Piwik\Plugin\Archiver
{
    const NEWSPAPER_ARCHIVE_ARTICLE_RECORD = 'Newspaper_archive_article_record';
    const NEWSPAPER_ARCHIVE_PAYWALL_RECORD = 'Newspaper_archive_paywall_record';

    /**
     * @throws \Exception
     */
    public function aggregateDayReport()
    {
        $archiveProcessor = $this->getProcessor();
        $logAggregator = $this->getLogAggregator();

        $this->aggregateArticles($logAggregator, $archiveProcessor);
        $this->aggregatePaywalls($logAggregator, $archiveProcessor);
    }

    public function aggregateMultipleReports()
    {
        foreach (array(
                     self::NEWSPAPER_ARCHIVE_ARTICLE_RECORD,
                     self::NEWSPAPER_ARCHIVE_PAYWALL_RECORD
                 ) as $archive) {
            $this->getProcessor()->aggregateDataTableRecords($archive);
        }
    }

    /**
     * @param LogAggregator $logAggregator
     * @param ArchiveProcessor $archiveProcessor
     *
     * @throws \Exception
     */
    private function aggregateArticles(LogAggregator $logAggregator, ArchiveProcessor $archiveProcessor)
    {
        $query = $logAggregator->queryActionsByDimension(
            array('log_link_visit_action.article_id'),
            'log_link_visit_action.article_id IS NOT NULL'
        );

        $dt = new DataTable;
        foreach ($query->fetchAll() as $id => $row) {
            $dt->addRowFromSimpleArray(array(
                'label' => Piwik::translate('Article') . ' ' . $id,
                'nb_visits' => $row[Metrics::INDEX_NB_VISITS]
            ));
        }

        $archiveProcessor->insertBlobRecord(
            self::NEWSPAPER_ARCHIVE_ARTICLE_RECORD,
            $dt->getSerialized($this->maximumRows)
        );
    }

    /**
     * @param LogAggregator $logAggregator
     * @param ArchiveProcessor $archiveProcessor
     *
     * @throws \Exception
     */
    private function aggregatePaywalls(LogAggregator $logAggregator, ArchiveProcessor $archiveProcessor)
    {
        $query = $logAggregator->queryVisitsByDimension(
            array('log_visit.paywall_plan'),
            'log_visit.paywall_plan IS NOT NULL'
        );

        $dt = new DataTable;
        foreach ($query->fetchAll() as $id => $row) {
            $dt->addRowFromSimpleArray(array(
                'label' => Piwik::translate('Paywall plan') . ' ' . $id,
                'nb_visits' => $row[Metrics::INDEX_NB_VISITS]
            ));
        }

        $archiveProcessor->insertBlobRecord(
            self::NEWSPAPER_ARCHIVE_PAYWALL_RECORD,
            $dt->getSerialized($this->maximumRows)
        );
    }
}
