<?php
namespace app\components;

use Yii;
use yii\validators\Validator;
use backend\models\Clientes;

class ClienteValidator extends Validator
{
		
	public function validateAttribute($model, $attribute)
	{
		
		$verificaUnico = Clientes::find()
		->where(['cnpj' => $model->cnpj, 'dono' => Yii::$app->user->identity['cnpj'] ])
		->asArray()
		->one();
		
		if (!empty($verificaUnico)) {
		//if ($model->cnpj != '00000000000') {
			$this->addError($model, $attribute, 'Cliente já cadastrado: ' . $verificaUnico['nome']);
		}
	}
}
