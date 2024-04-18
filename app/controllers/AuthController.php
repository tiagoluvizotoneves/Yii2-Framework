<?php 
    namespace app\controllers;

    use Yii;
    use yii\web\Controller;
    use app\models\User;
    use sizeg\jwt\Jwt;
    use sizeg\jwt\JwtHttpBearerAuth;
    
    class AuthController extends Controller
    {
        public function behaviors()
        {
            $behaviors = parent::behaviors();
            $behaviors['authenticator'] = [
                'class' => JwtHttpBearerAuth::class,
                'except' => ['login'],  // Exclui o login da autenticação por token
            ];
            return $behaviors;
        }
    
        public function actionLogin()
        {
            $username = Yii::$app->request->post('username');
            $password = Yii::$app->request->post('password');
    
            $user = User::findOne(['username' => $username]);
            if ($user && $user->validatePassword($password)) {
                $jwt = Yii::$app->jwt;
                $token = $jwt->getBuilder()
                             ->setIssuedAt(time())
                             ->setExpiration(time() + 3600) // Token expira em 1 hora
                             ->set('uid', $user->id)
                             ->getToken($jwt->getSigner('HS256'), $jwt->getKey());
                
                return $this->asJson([
                    'token' => (string) $token
                ]);
            } else {
                Yii::$app->response->statusCode = 401;
                return $this->asJson(['error' => 'Unauthorized']);
            }
        }
    }    