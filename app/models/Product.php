<?php 

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Product extends ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $file;

    public static function tableName()
    {
        return 'product';
    }

    public function rules()
    {
        return [
            [['name', 'price', 'client_id'], 'required'],
            [['price'], 'number'],
            [['client_id'], 'integer'],
            [['photo'], 'string'],
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
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
