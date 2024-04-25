<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\Customer;
use Exception;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\helpers\Json;
use yii\data\Pagination;

class CustomerController extends Controller
{
    public $modelClass = 'modules\v1\models\Customer';

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        $behaviors['corsFilter'] = ['class' => Cors::class];
        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        return [
            'create' => ['GET', 'POST'],
        ];
    }

    /**
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function actionCreate(): array
    {
        $model = new Customer();
        if (Yii::$app->request->isPost) {
            $bodyParams = Json::decode(Yii::$app->getRequest()->getRawBody(), true);
            $customer = $model->findByCpf($bodyParams['cpf']);
            if($customer) {
                throw new BadRequestHttpException('Cliente já cadastrado.');
            }
            if(!$model->validateCpf($bodyParams['cpf'])) {
                throw new BadRequestHttpException('CPF inválido.');
            }
            $model->load($bodyParams, '');

            if ($model->validate() && $model->create()) {
                return [
                    'message' => 'Cliente cadastrado com sucesso!',
                ];
            } else {
                throw new BadRequestHttpException('Falha ao cadastrar cliente. Verifique os dados informados.');
            }
        }else{
            return [
                'message' => 'Método não permitido. Utilize o método POST para registrar um cliente.',
            ];
        }
    }

    public function actionIndex()
    {
        $query = Customer::find()->where(['status' => 1]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return [
            'models' => $models,
            'pages' => $pages,
        ];
    }
}
