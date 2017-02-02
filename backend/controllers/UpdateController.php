<?php

namespace backend\controllers;

use yii\web\Controller;
use backend\models\Clientes;

class UpdateController extends Controller
{
	public function actionIndex(){
		
		return $this->render('index');
		
	}
	
	public function actionClientes(){
		
		$a = new Clientes();
		$b = $a->verTodos();
		
		$campos = [
				'id',
				'cridt',
				'criusu',
				'dono',
				'nome',
				'cnpj',
				'ie',
				'endrua',
				'endnro',
				'endbairro',
				'endcid',
				'enduf',
				'endcep',
				'responsaveis',
				'telefones',
				'emails',
				'tabelas',
				'status'
		];
		
		foreach ($b as $k){
			$id = '';
			$cridt = date('Y-m-d');
			$criusu = trim($k['criusu']);
			$dono = \Yii::$app->user->identity['cnpj'];
			$nome = trim($k['nome']);
			$cnpj = trim($k['cnpj']);
			$ie = trim($k['ie']);
			$exprua = explode(',', $k['endrua']);
			$endrua = (isset($exprua[1])) ? trim($exprua[0]) : $k['endrua'];
			$endnro = (isset($exprua[1])) ? trim($exprua[1]) : '';
			$endbairro = trim($k['endbairro']);
			$endcid = trim($k['endcid']);
			$enduf = trim($k['enduf']);
			$endcep = trim($k['cep']);
			$responsaveis = '';
			$telefones = '';
			$emails = '';
				
			for($w=1;$w<=3;$w++){
				$resp_atual = 'resp'.$w;
				$email_atual = 'email'.$w;
				$tel_atual = 'tel'.$w;
		
				if( !empty($k[$resp_atual]) ){
					$responsaveis .= trim($k[$resp_atual]) . '|';
					$telefones .= trim($k[$tel_atual]) . '|';
					$emails .= trim($k[$email_atual]) . '|';
				}
			}
				
			$tabelas = '';
			$status = '1';
				
			for ($z=1;$z<=30;$z++) {
				$tab_atual = 'tab'.$z;
				if( !empty($k[$tab_atual]) ){
					$tabelas .= trim($k[$tab_atual]) . '|';
				}
			}
				
			$valores[] = [
					$id,
					$cridt,
					$criusu,
					$dono,
					$nome,
					$cnpj,
					$ie,
					$endrua,
					$endnro,
					$endbairro,
					$endcid,
					$enduf,
					$endcep,
					$responsaveis,
					$telefones,
					$emails,
					$tabelas,
					$status
			];
		}
		
		// Desabilitado (elias e loggica já atualizados)
		//$db = \Yii::$app->db;
		//$sql = $db->queryBuilder->batchInsert('clientes_nova', $campos, $valores);
		//$db->createCommand($sql)->execute();
		
		$certo = $db ? 'Atualizado' : 'Erro na atualização';
		
		return $this->render('clientes',[
				'certo' => $certo
		]);
		
	}
}