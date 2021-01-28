<?php

/**
 * @version SVN: $Id: AnalyticsController.php 124 2015-06-03 08:35:49Z morita $
 */
namespace NBPA\Controllers\Manager;

use NBPA\Models\Country;
use NBPA\Models\Member;

class AnalyticsController
{
    /**
     * メンバー統計.
     */
    public static function members($app)
    {
        $start  = $app->request->get('start');
        $end    = $app->request->get('end');
        $action = $app->request->get('action');

        // default: $end = today
        $datetime = new \Datetime($end);
        $end      = $end ? $end : $datetime->format('Y-m-d');

        // default: $start = 90 days ago
        $datetime->modify('-90 days');
        $start = $start ? $start : $datetime->format('Y-m-d');

        $stats = Member::getMembersEachCountry($start, $end);

        $dates     = \Utils\DateUtil::dateList($start, $end);
        $countries = Country::$countries;
        $members   = [];

        // initialize
        foreach ($dates as $date) {
            $members[$date][0] = 0; // Total
            foreach ($countries as $countryCode => $countryName) {
                $members[$date][$countryCode]     = 0;
                $members['summary'][0]            = 0; // Summary
                $members['summary'][$countryCode] = 0; // Summary
            }
        }
        foreach ($stats as $stat) {
            $date        = $stat['date'];
            $countryCode = $stat['country'];
            $count       = $stat['count'];

            $members[$date][$countryCode] = $count;
            $members[$date][0] += $count; // Total
            $members['summary'][0] += $count; // Summary
            $members['summary'][$countryCode] += $count; // Summary
        }

        if ($action == 'csv') {
            $app->response->headers->set('Content-Type', 'text/csv');
            $app->response->headers->set('Content-Disposition', 'attachment; filename="analytics-members.csv"');
            echo 'date,total,' . implode(',', $countries) . "\n";
            foreach ($dates as $date) {
                echo "{$date},{$members[$date][0]}";
                foreach ($countries as $countryCode => $countryName) {
                    echo ",{$members[$date][$countryCode]}";
                }
                echo "\n";
            }
        } else {
            $app->render(
                'manager/analytics/members.php',
                [
                    'app'         => $app,
                    'start'       => $start,
                    'end'         => $end,
                    'dates'       => $dates,
                    'members'     => $members,
                    'countries'   => $countries,
                    'countryTLDs' => Country::$countryTLDs,
                ]
            );
        }
    }

    /**
     * エントリー統計.
     */
    public static function entries($app)
    {
        $start  = $app->request->get('start');
        $end    = $app->request->get('end');
        $action = $app->request->get('action');

        // default: $end = today
        $datetime = new \Datetime($end);
        $end      = $end ? $end : $datetime->format('Y-m-d');

        // default: $start = 90 days ago
        $datetime->modify('-90 days');
        $start = $start ? $start : $datetime->format('Y-m-d');

        $query = <<<EOS
SELECT
    DATE(r.entry_date) AS date, pref AS country, COUNT(regist_apply_no) AS count
FROM
    t_regist_apply r LEFT JOIN t_member_regist m ON r.member_regist_no = m.member_regist_no
WHERE
    DATE(r.entry_date) >= ? AND DATE(r.entry_date) <= ?
GROUP BY
    DATE(r.entry_date), pref
ORDER BY
    DATE(r.entry_date)
EOS;

        $stats = \ORM::forTable('t_regist_apply')
            ->rawQuery($query, [$start, $end])
            ->findArray();

        $dates     = \Utils\DateUtil::dateList($start, $end);
        $countries = Country::$countries;
        $entries   = [];

        // initialize
        foreach ($dates as $date) {
            $entries[$date][0] = 0; // Total
            foreach ($countries as $countryCode => $countryName) {
                $entries[$date][$countryCode]     = 0;
                $entries['summary'][0]            = 0; // Summary
                $entries['summary'][$countryCode] = 0; // Summary
            }
        }
        foreach ($stats as $stat) {
            $date        = $stat['date'];
            $countryCode = $stat['country'];
            $count       = $stat['count'];

            $entries[$date][$countryCode] = $count;
            $entries[$date][0] += $count; // Total
            $entries['summary'][0] += $count; // Summary
            $entries['summary'][$countryCode] += $count; // Summary
        }

        if ($action == 'csv') {
            $app->response->headers->set('Content-Type', 'text/csv');
            $app->response->headers->set('Content-Disposition', 'attachment; filename="analytics-entries.csv"');
            echo 'date,total,' . implode(',', $countries) . "\n";
            foreach ($dates as $date) {
                echo "{$date},{$entries[$date][0]}";
                foreach ($countries as $countryCode => $countryName) {
                    echo ",{$entries[$date][$countryCode]}";
                }
                echo "\n";
            }
        } else {
            $app->render(
                'manager/analytics/entries.php',
                [
                    'app'         => $app,
                    'start'       => $start,
                    'end'         => $end,
                    'dates'       => $dates,
                    'entries'     => $entries,
                    'countries'   => $countries,
                    'countryTLDs' => Country::$countryTLDs,
                ]
            );
        }
    }
}
