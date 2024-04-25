<?php

namespace app\modules\v1\models;

use Yii;
use yii\db\ActiveRecord;

class Customer extends ActiveRecord
{
    /**
     * @var mixed|null
     */
    public mixed $id = null;

    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return ['name', 'cpf', 'address', 'number', 'city', 'state', 'complement', 'photo', 'gender', 'id', 'status', 'created_at', 'updated_at'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['name', 'cpf', 'address', 'number', 'city', 'state', 'complement', 'gender', 'photo'], 'required'],
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

    public function findByName($name): ?Customer
    {
        return Customer::findOne(['name' => $name]);
    }

    public function findByCpf($cpf): ?Customer
    {
        return Customer::findOne(['cpf' => $cpf]);
    }

    public function validateCpf($cpf): bool
    {
        $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
        if (strlen($cpf) != 11) {
            return false;
        }
        for ($i = 0, $j = 0; $i < 9; $i++) {
            $j += $cpf[$i] * (10 - $i);
        }
        $j = ((10 * $j) % 11) % 10;
        if ($cpf[9] != $j) {
            return false;
        }
        for ($i = 0, $j = 0; $i < 10; $i++) {
            $j += $cpf[$i] * (11 - $i);
        }
        $j = ((10 * $j) % 11) % 10;
        return $cpf[10] == $j;
    }
}
