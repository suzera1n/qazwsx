<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class RbacController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $manager = $auth->createRole('manager');
        $manager->description = 'Менеджер';
        $teacher = $auth->createRole('teacher');
        $teacher->description = 'Преподаватель';
        $student = $auth->createRole('student');
        $student->description = 'Студент';
        $auth->add($admin);
        $auth->add($manager);
        $auth->add($teacher);
        $auth->add($student);
        $adminManager = $auth->createPermission('adminManager');
        $adminManager->description = 'Администрирование ресурсов';
        $auth->add($adminManager);
        $auth->addChild($admin, $adminManager);
        $auth->addChild($manager, $adminManager);
        $auth->assign($admin, 1);
        echo "All right\n";
        return ExitCode::OK;
    }
}
