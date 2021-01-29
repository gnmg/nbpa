<?php
/**
 * @version SVN: $Id: ApplyPoint.php 118 2015-06-02 13:08:34Z morita $
 */
namespace NBPA\Models;

class ApplyPoint
{
    public static function getApplyPoint($applyNo, $judgeId, $stage)
    {
        $applyPoint = \ORM::forTable('t_apply_points')
            ->where('regist_apply_no', $applyNo)
            ->where('judge_id', $judgeId)
            ->where('stage', $stage)
            ->findOne();
        if (!$applyPoint) {
            $applyPoint = \ORM::forTable('t_apply_points')
                ->create([
                    'regist_apply_no' => $applyNo,
                    'judge_id'        => $judgeId,
                    'stage'           => $stage,
                ])->set_expr('created_at', 'NOW()');
        }

        return $applyPoint;
    }

    public static function getApplyPoints($applyNo, $stage)
    {
        $points = \ORM::forTable('t_apply_points')
            ->where('regist_apply_no', $applyNo)
            //->whereLte('stage', $stage)
            ->whereGte('stage', $stage - 1)
            ->findMany();

        return $points;
    }
}
