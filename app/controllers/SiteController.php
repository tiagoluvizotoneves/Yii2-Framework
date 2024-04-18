<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{

    /**
     * Renderiza a página inicial do site.
     * 
     * Este método configura o formato da resposta para HTML e renderiza a view 'index'.
     * É útil para exibir a página inicial enquanto mantém outros endpoints da API
     * retornando respostas em formato JSON.
     * 
     * @return string A renderização da view 'index'.
     */
    public function actionIndex()
    {
        \Yii::$app->response->format = Response::FORMAT_HTML;
        return $this->render('index'); 
    }
}