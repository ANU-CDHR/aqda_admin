<?php
namespace frontend\models;

use Yii;

/**
 * This is the model class for table "format".
 *
 * @property int $id
 * @property string $value
 *
 * @property Storageformat[] $storageformats
 * @property Storage[] $storages
 */
class Format extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'format';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[Storageformats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStorageformats()
    {
        return $this->hasMany(Storageformat::className(), ['formatId' => 'id']);
    }

    /**
     * Gets query for [[Storages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStorages()
    {
        return $this->hasMany(Storage::className(), ['id' => 'storageId'])->viaTable('storageformat', ['formatId' => 'id']);
    }
}
