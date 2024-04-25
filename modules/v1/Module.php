<?php

namespace app\modules\v1;

use yii\filters\auth\HttpBearerAuth;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\v1\controllers';

    public function init()
    {
        parent::init();
    }
}