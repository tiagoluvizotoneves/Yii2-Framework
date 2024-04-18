<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Client extends ActiveRecord
{
    /**
     * @var UploadedFile arquivo carregado
     */
    public $file;

    public static function tableName()
    {
        return 'client';
    }

    public function rules()
    {
        return [
            [['name', 'cpf', 'cep', 'street', 'city', 'state'], 'required'],
            [['cpf'], 'unique'],
            [['cpf'], 'string', 'length' => 11],
            [['cep'], 'string', 'length' => 8],
            [['number'], 'string', 'length' => 10],
            [['complement'], 'string', 'length' => 255],
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, png'],
            [['gender'], 'in', 'range' => ['M', 'F']],
        ];
    }

    public function upload()
    {
        if ($this->file) {
            $filePath = '/var/www/html/tests/' . $this->file->baseName . '.' . $this->file->extension;
            if ($this->file->saveAs($filePath)) {
                $this->photo = $filePath;
                return true;
            } else {
                return false;
            }
        }
        return true;
    }


}
