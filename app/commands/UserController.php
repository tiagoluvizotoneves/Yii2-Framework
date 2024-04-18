<?php
    namespace app\commands;

    use yii\console\Controller;
    use app\models\User;
    use Yii;

    class UserController extends Controller
    {
        public function actionCreate($username, $password, $name)
        {
            $user = new User();
            $user->username = $username;
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($password);
            $user->name = $name;

            if ($user->save()) {
                echo "Usuário criado com sucesso!\n";
            } else {
                echo "Erro ao criar usuário: " . implode(", ", $user->getFirstErrors()) . "\n";
            }
        }
    }
    