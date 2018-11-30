<?php

namespace backend\assets;

use yii\base\Exception;
use yii\web\AssetBundle as BaseAdminLteAsset;
use backend\modules\clientes\models\Clientes;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class AdminLteAssetUser extends BaseAdminLteAsset
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';
    public $css = [
        'css/AdminLTE.min.css',
    ];
    public $js = [
        'js/app.min.js'
    ];
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    /**
     * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
     * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
     */
    public $skin = '';

    /**
     * @inheritdoc
     */
    public function init()
    {

        if (!\Yii::$app->user->isGuest) {
            $cliente = Clientes::find()
                ->where([
                    'cnpj' => \Yii::$app->user->identity['cnpj'],
                    'dono' => \Yii::$app->user->identity['cnpj'],
                ])
                ->one();

            $this->skin = ($cliente->clientesPrefs === null) ? 'skin-purple' : $cliente->clientesPrefs->tema;
        }
        // Append skin color file if specified
        if ($this->skin) {
            if (('_all-skins' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
                throw new Exception('Invalid skin specified');
            }

            $this->css[] = sprintf('css/skins/%s.min.css', $this->skin);
        }

        parent::init();
    }
}