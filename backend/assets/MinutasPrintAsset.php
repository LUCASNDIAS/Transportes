<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class MinutasPrintAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    		'css/minuta.css'
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
