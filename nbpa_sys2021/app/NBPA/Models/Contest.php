<?php

/**
 * @version SVN: $Id: Contest.php 118 2015-06-02 13:08:34Z morita $
 */
namespace NBPA\Models;

class Contest
{
    const STAGE_1ST_POINT          = 0;
    const STAGE_1ST_APPROVE        = 1;
    const STAGE_2ND_POINT          = 2;
    const STAGE_2ND_APPROVE        = 3;
    const STAGE_SEMI_FINAL_POINT   = 4;
    const STAGE_SEMI_FINAL_APPROVE = 5;
    const STAGE_FINAL              = 6;

    const STAGE_UPS        = 16;
    const STAGE_CATEGORY   = 32;
    const STAGE_SMITHONIAN = 64;

    // pull down
    public static $judgeStages = [
        '0' => '1st - point',
        '1' => '1st - approve',
        '2' => '2nd - point',
        '3' => '2nd - approve',
        '4' => 'Semi final - point',
        '5' => 'Semi final - approve',
        '6' => 'Final',
    ];
}
