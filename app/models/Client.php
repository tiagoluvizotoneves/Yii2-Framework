<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Client extends ActiveRecord
{
    /**
     * @var UploadedFile Arquivo de imagem carregado para o perfil do cliente.
     */
    public $file;

    /**
     * Define a tabela associada com o modelo.
     * 
     * @return string O nome da tabela associada ao modelo.
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * Regras de validação para atributos do modelo.
     * 
     * @return array As regras de validação para os atributos do modelo.
     */
    public function rules()
    {
        return [
            // Campos obrigatórios
            [['name', 'cpf', 'cep', 'street', 'city', 'state'], 'required'],
            // CPF deve ser único no banco de dados
            [['cpf'], 'unique'],
            // Validação de tamanho para CPF e CEP
            [['cpf'], 'string', 'length' => 11],
            [['cep'], 'string', 'length' => 8],
            // Validação de tamanho para número
            [['number'], 'string', 'length' => 10],
            // Validação de tamanho para complemento
            [['complement'], 'string', 'length' => 255],
            // Validação para o arquivo de foto (opcional, apenas extensões específicas)
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, png'],
            // Gênero deve ser 'M' (Masculino) ou 'F' (Feminino)
            [['gender'], 'in', 'range' => ['M', 'F']],
        ];
    }

    /**
     * Processa o upload do arquivo de foto do cliente.
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
