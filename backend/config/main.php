<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                   => 'app-backend',
    'basePath'             => dirname(__DIR__),
    'controllerNamespace'  => 'backend\controllers',
    'defaultRoute'         => 'main',//默认控制器
    'bootstrap'            => ['log'],
    'modules'              => [
        /* 系统 modules */
        'sys' => [
            'class' => 'backend\modules\sys\index',
        ],
        /* 微信 modules */
        'wechat' => [
            'class' => 'backend\modules\wechat\index',
        ],
        /* 会员 modules */
        'member' => [
            'class' => 'backend\modules\member\index',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\sys\Manager',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['site/login'],
            'idParam' => '__admin',
            'as afterLogin' => 'common\behaviors\AfterLogin',
        ],
        // 这是用于在后台登录的会话cookie的名称
        'session' => [
            'name' => 'advanced-backend',
        ],

        'request'=>[
            'csrfParam'=>'_csrf_backend'
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        /**----------------------路由配置--------------------**/
        'urlManager' => [
            'class'           => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,  //这个是生成路由 ?r=site/about--->/site/about
            'showScriptName'  => false,
            'suffix'          => '.html',//静态
            'rules'           =>[

            ],
        ],

        /**-------------------错误定向页-------------------**/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        /**-------------------RBAC配置-------------------**/
        'authManager' => [
            'class'             => 'yii\rbac\DbManager',
            'itemTable'         => '{{%sys_auth_item}}',
            'assignmentTable'   => '{{%sys_auth_assignment}}',
            'itemChildTable'    => '{{%sys_auth_item_child}}',
            'ruleTable'         => '{{%sys_auth_rule}}',
        ],

        /**-------------------后台操作日志-------------------**/
        'actionlog' => [
            'class' => 'common\models\sys\ActionLog',
        ],
    ],
    'params' => $params,
];
