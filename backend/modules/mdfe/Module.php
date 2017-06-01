<?php

namespace backend\modules\mdfe;

/**
 * mdfe module definition class
 */
class Module extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\mdfe\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

//        // initialize the module with the configuration loaded from config.php
//        \Yii::configure($this, require(__DIR__ . '/config/main-local.php'));
    }

}
