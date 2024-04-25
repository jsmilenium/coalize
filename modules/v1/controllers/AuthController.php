<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\User;
use DateTimeImmutable;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Yii;
use yii\base\InvalidConfigException;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\helpers\Json;

class AuthController extends Controller
{
    public $modelClass = 'modules\v1\models\User';

    public $enableCsrfValidation = false;

    /**
     * Login action.
     *
     * @return array
     * @throws BadRequestHttpException|InvalidConfigException
     */
    public function actionLogin(): array
    {
        $model = new User();

        if (Yii::$app->request->isPost) {
            $bodyParams = Json::decode(Yii::$app->getRequest()->getRawBody(), true);
            $model->load($bodyParams, '');
            $user = $model->findByUsername($bodyParams['username']);
            $userId = $user->getAttribute('id');

            if ($model->validate() && $model->login()) {
                $now = new DateTimeImmutable();
                $jwt = Yii::$app->get('jwt');

                $token = $jwt
                    ->builder()
                    ->issuedBy('http://localhost')
                    ->permittedFor('http://localhost')
                    ->identifiedBy($userId)
                    ->issuedAt($now)
                    ->canOnlyBeUsedAfter($now)
                    ->expiresAt($now->modify('+1 hour'))
                    ->withClaim('uid', $userId)
                    ->getToken($jwt->signer(), $jwt->key())
                    ->toString();

                return [
                    'message' => 'Login efetuado com sucesso!',
                    'access_token' => $token,
                ];
            } else {
                throw new BadRequestHttpException('Falha ao efetuar login. Verifique suas credenciais.');
            }
        } else {
            throw new BadRequestHttpException('Método não permitido. Utilize o método POST para efetuar login.');
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        Yii::$app->response->statusCode = 204;
        return Yii::$app->response;
    }

    /**
     * @throws InternalErrorException
     */
    public function actionRegister(): array
    {
        try {
            $bodyParams = Json::decode(Yii::$app->getRequest()->getRawBody(), true);
            $model = new User();

            if ($model->load($bodyParams, '') && $model->register()) {
                return [
                    'message' => 'Usuário registrado com sucesso!',
                ];
            } else {
                throw new BadRequestHttpException('Falha ao registrar usuário. Verifique os dados informados.');
            }
        } catch (\Exception $e) {
            throw new InternalErrorException('Falha ao criar usuário: ' . $e->getMessage(),500);
        }
    }
}
