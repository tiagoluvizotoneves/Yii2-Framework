<?php 

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Product extends ActiveRecord
{
    /**
     * @var UploadedFile Arquivo de imagem carregado para o produto.
     */
    public $file;

    /**
     * Especifica o nome da tabela associada ao modelo.
     * 
     * @return string O nome da tabela no banco de dados.
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * Define as regras de validação para os atributos do modelo de produto.
     * 
     * @return array As regras de validação para os atributos do modelo.
     */
    public function rules()
    {
        return [
            // Campos obrigatórios
            [['name', 'price', 'client_id'], 'required'],
            // Preço deve ser um número
            [['price'], 'number'],
            // ID do cliente deve ser um inteiro
            [['client_id'], 'integer'],
            // Foto é uma string no caminho da foto armazenada
            [['photo'], 'string'],
            // Validação para o arquivo de foto (opcional, apenas extensões específicas)
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * Processa o upload do arquivo de foto do produto.
     * 
     * @return bool Retorna true se o upload e o salvamento do arquivo foram bem-sucedidos, false caso contrário.
     */
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
