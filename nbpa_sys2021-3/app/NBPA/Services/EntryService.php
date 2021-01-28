<?php

/**
 * @version SVN: $Id: EntryService.php 140 2015-06-08 16:35:05Z morita $
 */
namespace NBPA\Services;

use NBPA\Models\Category;
use NBPA\Models\Country;

class EntryService
{
    /**
     * カテゴリ毎の応募数の総数を取得する.
     */
    public static function getPictureEnteredSummary($memberRegistNo)
    {
        $results = [];

        $entries = \ORM::forTable('t_regist_apply')
            ->select('apply_genre')
            ->selectExpr('COUNT(regist_apply_no)', 'count')
            ->where('member_regist_no', $memberRegistNo)
            ->groupBy('apply_genre')
            ->findArray();

        // 初期化
        foreach (Category::getCategories() as $categoryId => $categoryName) {
            $results[$categoryId] = 0;
        }
        $results['total'] = 0;

        // 応募数を反映する。
        foreach ($entries as $entry) {
            $results[$entry['apply_genre']] = $entry['count'];
            $results['total'] += $entry['count'];
        }

        return $results;
    }

    /**
     *
     */
    public static function newEntry(
        $remoteAddr,
        $memberRegistNo,
        $category,
        $imgName,
        $title
    ) {
        $entry = \ORM::forTable('t_regist_apply')->create();

        $entry->ip               = $remoteAddr;
        $entry->apply_genre      = $category;
        $entry->apply_image      = $imgName;
        $entry->pay_status       = 1;
        $entry->member_regist_no = $memberRegistNo;
        $entry->entry_date       = date('Y-m-d H:i:s');
        $entry->revision_date    = date('Y-m-d H:i:s');
        $entry->image_title      = $title;

        $entry->save();
    }

    /**
     * 指定した応募を取得する.
     */
    public static function getEntry($memberRegistNo, $registApplyNo)
    {
        $entry = \ORM::forTable('t_regist_apply')
            ->where('member_regist_no', $memberRegistNo)
            ->where('regist_apply_no', $registApplyNo)
            ->findOne();

        return $entry;
    }

    /**
     * 指定したメンバーの応募を取得する.
     */
    public static function getEntriesByMemberRegistNo($memberRegistNo)
    {
        $entries = \ORM::forTable('t_regist_apply')
            ->where('member_regist_no', $memberRegistNo)
            ->findMany();

        return $entries;
    }

    /**
     * カテゴリ毎の応募を取得する.
     */
    public static function getEntriesByCategory($memberRegistNo, $categoryId)
    {
        $entries = \ORM::forTable('t_regist_apply')
            ->where('member_regist_no', $memberRegistNo)
            ->where('apply_genre', $categoryId)
            ->findMany();

        return $entries;
    }

    /**
     * 応募を取り下げる.
     */
    public static function dropEntries($memberRegistNo, $drops)
    {
        $db = \ORM::getDb();

        try {
            $db->beginTransaction();
            foreach ($drops as $registApplyNo) {
                $entry = \ORM::forTable('t_regist_apply')
                    ->where('member_regist_no', $memberRegistNo)
                    ->where('regist_apply_no', $registApplyNo)
                    ->findOne();
                if ($entry) {
                    $entry->use_id_column('regist_apply_no');
                    $entry->delete();
                }
            }
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
        }
    }

    /**
     * 総エントリー数を取得する.
     */
    public static function getTotalEntryCount()
    {
        $count = \ORM::forTable('t_regist_apply')->count();

        return $count;
    }

    /**
     * 国別のエントリー数を取得する.
     */
    public static function getEntryCountEachCountry()
    {
        $entries = \ORM::forTable('t_regist_apply')
            ->tableAlias('r')
            ->select('pref', 'countryId')
            ->select('sex', 'gender')
            ->selectExpr('COUNT(regist_apply_no)', 'count')
            ->leftOuterJoin('t_member_regist', ['r.member_regist_no', '=', 'm.member_regist_no'], 'm')
            ->groupBy('pref')->groupBy('sex')
            ->findMany();

        $results = [];

        foreach ($entries as $entry) {
            if (!isset($results[$entry->countryId])) {
                $results[$entry->countryId] = [
                    'countryName' => '',
                    'male'        => 0,
                    'female'      => 0,
                ];
            }
            foreach (Country::$countries as $countryId => $countryName) {
                if ($entry->countryId == $countryId) {
                    $results[$entry->countryId]['countryName'] = $countryName;
                }
            }
            if ($entry->gender == 1) {
                $results[$entry->countryId]['female'] = $entry->count;
            }
            if ($entry->gender == 2) {
                $results[$entry->countryId]['male'] = $entry->count;
            }
        }

        return $results;
    }
}
