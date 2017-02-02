<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use backend\models\Usuarios;
use yii\base\InvalidParamException;

/**
 * Classe para gerenciar as permissões dos Usuários
 * @author Lucas Dias
 *
 */
class RbacController extends Controller
{
	/**
	 * Cria permissões para fins de teste
	 * Não usar em produção !!!
	 */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // add "createPost" permission
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        // add "author" role and give this role the "createPost" permission
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($author, 2);
        $auth->assign($admin, 1);
    }
    /**
     * Adiciona relacionamento entre dois objetos do authManager
     * @param string $pai
     * @param string $filho
     */
    public function actionAddChild($pai, $filho)
    {
    	$auth = Yii::$app->authManager;
    	
   		// Verifica se é permissão
    	$checkpermissao = $auth->getPermission($pai);
    	if(!$checkpermissao){
    		
    		// Verifica se é função
    		$checkfuncao = $auth->getRole($pai);
    		if($checkfuncao){
    			$definePai = $checkfuncao;
    		}
    	} else {
    		$definePai = $checkpermissao;
    	}
    	
    	// Verifica se é permissão
    	$checkpermissao = $auth->getPermission($filho);
    	if(!$checkpermissao){
    	
    		// Verifica se é função
    		$checkfuncao = $auth->getRole($filho);
    		if($checkfuncao){
    			$defineFilho = $checkfuncao;
    		}
    	} else {
    		$defineFilho = $checkpermissao;
    	}
    	
    	$auth->addChild($definePai, $defineFilho);
    	
    }
    
    /**
     * Cria uma nova permissão
     * @param string $permissao
     * @param string $descricao
     * @throws InvalidParamException
     */
    public function actionCriarPermissao($permissao,$descricao)
    {
    	$auth = Yii::$app->authManager;

    	// Verifica se a permissão já existe
    	$checkpermissao = $auth->getPermission($permissao);
    	if($checkpermissao){
    		throw new InvalidParamException("Permissão já existente: \"$permissao\".");
    	}
    	
    	// Cria uma nova permissão
    	$createPerm = $auth->createPermission($permissao);
    	$createPerm->description = $descricao;
    	$auth->add($createPerm);
    }
    
    /**
     * Cria uma nova função (Role)
     * @param string $funcao
     * @throws InvalidParamException
     */
    public function actionCriarFuncao($funcao)
    {
    	$auth = Yii::$app->authManager;
    
    	// Verifica se a função já existe
    	$checkfuncao = $auth->getRole($funcao);
    	if($checkfuncao){
    		throw new InvalidParamException("Funcao já existente: \"$funcao\".");
    	}
    	 
    	// Cria uma nova permissão
    	$createFunc = $auth->createRole($funcao);
    	$auth->add($createFunc);
    }
    
    /**
     * Associa um usuario à uma função através do apelido
     * @param string $role
     * @param string $username (apelido)
     * @throws InvalidParamException
     */
	public function actionAssign($role, $username)
    {
    	$user = Usuarios::find()->where(['apelido' => $username])->one();
    	if (!$user) {
    		throw new InvalidParamException("Nenhum usuario com o apelido: \"$username\".");
    	}
    
    	$auth = Yii::$app->authManager;
    	$role = $auth->getRole($role);
    	if (!$role) {
    		throw new InvalidParamException("Funçao inexistenteD: \"$role\".");
    	}
    
    	$auth->assign($role, $user->id);
    }
    
    /**
     * Remove função de um usuário pelo apelido
     * @param string $role
     * @param string $username
     * @throws InvalidParamException
     */
	public function actionRevoke($role, $username)
    {
    	$user = Usuarios::find()->where(['apelido' => $username])->one();
    	if (!$user) {
    		throw new InvalidParamException("Nenhum usuario com o apelido: \"$username\".");
    	}
    
    	$auth = Yii::$app->authManager;
    	$role = $auth->getRole($role);
    	if (!$role) {
    		throw new InvalidParamException("Funçao inexistente: \"$role\".");
    	}
    
    	$auth->revoke($role, $user->id);
    }
    
    /**
     * Remove todas as funções de um usuário pelo apelido
     * @param string $username
     * @throws InvalidParamException
     */
    public function actionRevokeAll($username)
    {
    	$user = Usuarios::find()->where(['apelido' => $username])->one();
    	if (!$user) {
    		throw new InvalidParamException("Nenhum usuario com o apelido: \"$username\".");
    	}
    
    	$auth = Yii::$app->authManager;
    	$auth->revokeAll($user->id);
    }
    /**
     * Remove todas as regras / pemissões
     * (desativado por segurança console/controllers/RbacController)
     */
    public function actionRemoveAll()
    {
    	$auth = Yii::$app->authManager;
    	//$auth->removeAll();
    }
    
    /**
     * Verifica todas as funções
     */
    public function actionGetRoles()
    {
    	$auth = Yii::$app->authManager;
    	print_r($auth->getRoles());
    }
    
    /**
     * Verifica todas as Permissões
     */
    public function actionGetPermissions()
    {
    	$auth = Yii::$app->authManager;
    	print_r($auth->getPermissions());
    }
}