<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class FaturaPrintAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
                'css/bootstrap.css',
                'css/fontawesome',
                'css/ionicons.css',
    		'css/AdminLTE.css',
                'css/print.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
