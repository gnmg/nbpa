<?php

/**
 * @version SVN: $Id: JudgeController.php 118 2015-06-02 13:08:34Z morita $
 */
namespace NBPA\Controllers\Manager;

use NBPA\Services\ValidationService as vs;

class JudgeController
{
    /**
     * 審査員一覧画面を表示する.
     *
     * GET /judge/index
     */
    public static function index($app)
    {
        $judges = \ORM::forTable('t_judge')
            ->orderByAsc('id')
            ->findMany();

        $app->render(
            'manager/judge/index.php',
            [
                'app'    => $app,
                'judges' => $judges,
            ]
        );
    }

    /**
     * 審査員編集画面を表示する.
     *
     * GET /judge/edit/:id
     */
    public static function edit($app, $id)
    {
        $judge = \ORM::forTable('t_judge')
            ->where('id', $id)
            ->findOne();

        $app->render(
            'manager/judge/edit.php',
            [
                'app'   => $app,
                'judge' => $judge,
            ]
        );
    }

    /**
     * 審査員情報を更新する.
     *
     * POST /judge/edit
     */
    public static function save($app)
    {
        $id = $app->request->post('id');

        $judge = \ORM::forTable('t_judge')
            ->where('id', $id)
            ->findOne();

        $action = $app->request->post('action');
        if ($action == 'save') {
            $name  = $app->request->post('name');
            $quota = $app->request->post('quota');

            // validation
            $errors = [];
            // name
            if ($error = vs::validateJudgeName($name)) {
                $errors = array_merge($errors, $error);
            }
            // quota
            if ($error = vs::validateJudgeQuota($quota)) {
                $errors = array_merge($errors, $error);
            }

            $judge->name  = $name;
            $judge->quota = $quota;

            if (!empty($errors)) {
                $app->flashNow('errors', $errors);
                $app->render(
                    'manager/judge/edit.php',
                    [
                        'app'   => $app,
                        'judge' => $judge,
                    ]
                );
            } else {
                // save
                $judge->save();

                $app->flash('message', 'Storing judge data has completed.');
                $app->redirect('/manager/judge/index');
            }
        }
    }
}
