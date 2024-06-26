<?php

namespace app\controllers;

use Yii;
use app\models\Client;
use sizeg\jwt\JwtHttpBearerAuth;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\UploadedFile;

class ClientController extends ActiveController
{
    /**
     * Define a classe modelo para este controlador.
     * Especifica que as operações CRUD serão baseadas no modelo 'Client'.
     */
    public $modelClass = 'app\models\Client';

    /**
     * Configura comportamentos adicionais para este controlador, além dos padrões do ActiveController.
     * Configura autenticação JWT para todas as ações, usando JWT Http Bearer Auth.
     *
     * @return array Configurações de comportamento modificado.
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        // Configura o autenticador para usar JWT Http Bearer Auth
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
        ];
        
        return $behaviors;
    }

    /**
     * Personaliza as ações padrão do ActiveController.
     * Remove as ações 'delete' e 'create' para serem substituídas por implementações personalizadas.
     *
     * @return array Configuração modificada das ações.
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create']); 
        return $actions;
    }

    /**
     * Ação para criar um novo cliente.
     * Valida autenticação, carrega dados do POST, verifica se o CPF já está cadastrado, faz upload de foto e salva o cliente.
     *
     * @return yii\web\Response Resposta da API em formato JSON.
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->identity) {
            Yii::$app->response->statusCode = 401;
            return $this->asJson(['error' => 'Você não está autorizado a executar esta ação.']);
        }

        $model = new Client();
        $model->load(Yii::$app->request->post(), '');

        // Checando se o CPF já está cadastrado
        $existingClient = Client::findOne(['cpf' => $model->cpf]);
        if ($existingClient) {
            return $this->asJson([
                'message' => 'Cliente já cadastrado com este CPF.',
                'data' => $existingClient
            ]);
        }

        $model->file = UploadedFile::getInstanceByName('photo');
        try {
            if ($model->upload()) { // Tenta fazer o upload se um arquivo for fornecido
                if ($model->save(false)) { // Salva o modelo sem validar novamente
                    return $this->asJson([
                        'message' => 'Cadastro enviado com sucesso.',
                        'data' => $model
                    ]);
                } else {
                    return $this->asJson(['errors' => $model->getErrors()]);
                }
            } else {
                return $this->asJson(['error' => 'Falha no upload ou dados inválidos']);
            }
        } catch (\yii\db\Exception $e) {
            return $this->asJson([
                'error' => 'Erro ao salvar os dados no banco. Verifique se os dados estão corretos e dentro dos limites de tamanho permitidos.',
                'details' => $e->errorInfo
            ]);
        }
    }

    /**
     * Ação para listar clientes de forma paginada.
     * Valida autenticação e retorna uma lista paginada de clientes.
     *
     * @return yii\web\Response Resposta da API em formato JSON com lista paginada de clientes.
     */
    public function actionListPaginated()
    {
        if (!Yii::$app->user->identity) {
            Yii::$app->response->statusCode = 401;
            return $this->asJson(['error' => 'Você não está autorizado a executar esta ação.']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Client::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
        ]);

        $clients = $dataProvider->getModels();
        $pagination = $dataProvider->getPagination();

        return $this->asJson([
            'items' => $clients,
            'pagination' => [
                'totalCount' => $pagination->totalCount,
                'pageCount' => $pagination->getPageCount(),
                'currentPage' => $pagination->getPage() + 1,
                'perPage' => $pagination->pageSize,
            ],
        ]);
    }


}
