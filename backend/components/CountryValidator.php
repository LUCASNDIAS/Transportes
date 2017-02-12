<?php
namespace app\components;

use yii\validators\Validator;

class CountryValidator extends Validator
{
	public function validateAttribute($model, $attribute)
	{
		if (!in_array($model->$attribute, ['EUA', 'Web'])) {
			$this->addError($model, $attribute, 'The country must be either "USA" or "Web".');
		}
	}
}
