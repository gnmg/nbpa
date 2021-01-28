<?php

namespace NBPA\Controllers\Campaign;

use NBPA\Models\Member;

class CampaignController
{
    /**
     * メンバー統計.
     */
    public static function members($app)
    {
        $code   = $app->request->get('code');
        $start  = $app->request->get('start');
        $end    = $app->request->get('end');
        $action = $app->request->get('action');

        // default: $end = today
        $datetime = new \Datetime($end);
        $end      = $end ? $end : $datetime->format('Y-m-d');

        // default: $start = 90 days ago
        $datetime->modify('-90 days');
        $start = $start ? $start : $datetime->format('Y-m-d');

        $stats = Member::getMembersByCampaignCode($code, $start, $end); // TODO:

        $dates   = \Utils\DateUtil::dateList($start, $end);
        $members = [];

        // initialize
        foreach ($dates as $date) {
            $members[$date][0]     = 0; // Total
            $members['summary'][0] = 0; // Summary
        }
        foreach ($stats as $stat) {
            $date  = $stat['date'];
            $count = $stat['count'];

            $members[$date][0] += $count; // Total
            $members['summary'][0] += $count; // Summary
        }

        $app->render(
            'campaign/analytics/members.php',
            [
                'app'     => $app,
                'code'    => $code,
                'start'   => $start,
                'end'     => $end,
                'dates'   => $dates,
                'members' => $members,
            ]
        );
    }
}
