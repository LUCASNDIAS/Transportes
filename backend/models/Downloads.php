<?php

namespace backend\models;

use Yii;
use backend\commands\Basicos;
use backend\models\Tabelas;
use yii\db\Query;
use ZipArchive;

class Downloads
{

    /**
     * @param array $arquivos
     * @return ZipArchive
     */
    public function criarZip(array $arquivos)
    {
        $zip = new ZipArchive();

        $dir = Yii::getAlias('@webroot/') . 'zip/';

        $filename = $dir . md5(Yii::$app->user->identity['cnpj'] . date('U')) . '.zip';

        if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
            exit("cannot open <$filename>\n");
        }

        foreach ($arquivos as $file) {
            if (is_file($file)) {
                $explode = explode('/', $file);
                $nome =  $explode[count($explode)-1];
                $zip->addFile($file, $nome);
            }
        }

        $zip->close();

        return is_file($filename) ? $filename : ['erro' => 'Arquivo não criado.'];
    }

    public function aplicaFiltro(array $formulario)
    {
        $basico = new Basicos();

        $query = (new Query())
            ->select([
                'chave' => 'chave',
                'status' => 'status'
            ])
            ->from('cte')
            ->where([
                'dono' => Yii::$app->user->identity['cnpj'],
                'ambiente' => 1,
            ])
            ->andWhere(['or', 'status="' . $formulario['status'] . '"', 'status="ENTREGUE"']);


        if ($formulario['di'] != '' && $formulario['df'] != '') {
            $di = $basico->formataData('db', $formulario['di']);
            $df = $basico->formataData('db', $formulario['df']);
            $query->andWhere(['between', 'cridt', $di, $df]);
        }

        if ($formulario['tomador'] != '') {
            $query->andWhere([
                'tomador' => $formulario['tomador']
            ]);
        }

        $retorno = $this->setPath($query->all());

        return $retorno;
    }

    protected function setPath(array $query)
    {
        $dirCte = Yii::getAlias('@cte/');
        $usuario = Yii::$app->user->identity['cnpj'];
        $ambiente = 'producao';

        foreach ($query as $arquivo) {
            $interno = ($arquivo['status'] == 'AUTORIZADO' || $arquivo['status'] == 'ENTREGUE') ? '/enviadas/aprovadas/' : '/canceladas/';
            $file[] = $dirCte . $usuario . '/' . $ambiente . $interno . $arquivo['chave'] . '-cte.xml';
        }

        return (isset($file)) ? $file : ['erro' => 'Sem arquivos.'];
    }
}