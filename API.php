<?php

namespace Piwik\Plugins\Newspaper;

use Piwik\Archive;
use Piwik\DataTable;
use Piwik\DataTable\Row;

class API extends \Piwik\Plugin\API
{
    /**
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     *
     * @return DataTable
     */
    public function getArticleReport($idSite, $period, $date, $segment = false)
    {
        $archive = Archive::build($idSite, $period, $date, $segment);
        $dt = $archive->getDataTable(Archiver::NEWSPAPER_ARCHIVE_ARTICLE_RECORD);

        return $dt;
    }

    /**
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     *
     * @return DataTable
     */
    public function getPaywallReport($idSite, $period, $date, $segment = false)
    {
        $archive = Archive::build($idSite, $period, $date, $segment);
        $dt = $archive->getDataTable(Archiver::NEWSPAPER_ARCHIVE_PAYWALL_RECORD);

        return $dt;
    }
}
