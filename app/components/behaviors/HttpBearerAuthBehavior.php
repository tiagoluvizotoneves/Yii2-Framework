<?php
    namespace app\components\behaviors;

    use yii\base\Behavior;
    use yii\web\User;
    use sizeg\jwt\JwtHttpBearerAuth;
    
    class HttpBearerAuthBehavior extends Behavior
    {
        public function events()
        {
            return [
                User::EVENT_BEFORE_LOGIN => 'beforeLogin',
            ];
        }
    
        public function beforeLogin($event)
        {
            $event->identity->attachBehavior('jwtAuth', [
                'class' => JwtHttpBearerAuth::class,
                'except' => ['login']
            ]);
        }
    }
    