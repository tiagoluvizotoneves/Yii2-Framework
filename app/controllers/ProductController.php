<?php

namespace app\controllers;

use app\models\Client;
use Yii;
use app\models\Product;
use sizeg\jwt\JwtHttpBearerAuth;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\UploadedFile;

class ProductController extends ActiveController
{
    public $modelClass = 'app\models\Product';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
            'except' => ['options'], 
        ];
        
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create']); 
        return $actions;
    }

    public function actionCreate()
    {
        if (!Yii::$app->user->identity) {
            Yii::$app->response->statusCode = 401;
            return $this->asJson(['error' => 'Você não está autorizado a executar esta ação.']);
        }

        $model = new Product();
        $model->load(Yii::$app->request->post(), '');
        $model->file = UploadedFile::getInstanceByName('photo');

        // Verifica se o cliente existe
        if (!Client::findOne($model->client_id)) {
            return $this->asJson([
                'error' => 'Cliente não encontrado. Verifique o ID do cliente.'
            ]);
        }

        if ($model->upload()) { 
            if ($model->save()) { 
                return $this->asJson([
                    'message' => 'Produto cadastrado com sucesso.',
                    'data' => $model
                ]);
            } else {
                return $this->asJson([
                    'error' => 'Falha ao salvar o produto. Verifique os dados e tente novamente.',
                    'details' => $model->getErrors()
                ]);
            }
        } else {
            return $this->asJson([
                'error' => 'Falha no upload ou dados inválidos'
            ]);
        }
    }

    public function actionListPaginated()
    {
        if (!Yii::$app->user->identity) {
            Yii::$app->response->statusCode = 401;
            return $this->asJson(['error' => 'Você não está autorizado a executar esta ação.']);
        }

        $params = Yii::$app->request->queryParams;
        $query = Product::find();

        // Filtra por cliente se um client_id for fornecido
        if (isset($params['client_id']) && $params['client_id']) {
            $query->andWhere(['client_id' => $params['client_id']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
        ]);

        $products = $dataProvider->getModels();
        $pagination = $dataProvider->getPagination();

        return $this->asJson([
            'items' => $products,
            'pagination' => [
                'totalCount' => $pagination->totalCount,
                'pageCount' => $pagination->getPageCount(),
                'currentPage' => $pagination->getPage() + 1,
                'perPage' => $pagination->pageSize,
            ],
        ]);
    }

}
