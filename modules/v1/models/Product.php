<?php

namespace app\modules\v1\models;

use Yii;
use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    /**
     * @var mixed|null
     */
    public mixed $id = null;

    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return ['name', 'price', 'photo', 'status', 'id', 'customer_id'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'photo', 'customer_id'], 'required'],
        ];
    }

    /**
     * Registra um novo cliente.
     *
     * @return bool se o registro for bem-sucedido
     * @throws \Exception
     */
    public function create(): bool
    {
        return $this->save();
    }

    /**
     * @return int|string o ID do cliente atual
     */
    public function getId()
    {
        return $this->id;
    }

    public function findByName($name): ?Product
    {
        return Product::findOne(['name' => $name]);
    }
}
