<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "operation".
 *
 * @property integer $operation_id
 * @property integer $operation_channel_id
 * @property string $operation_serial_num
 * @property integer $operation_type
 * @property integer $operation_status
 * @property string $operation_snapshot
 * @property string $operation_message
 * @property string $operation_created_at
 * @property string $operation_finished_at
 * @property string $operation_updatead_at
 *
 * @property AccountLog[] $accountLogs
 * @property Channel $operationChannel
 */
class Operation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['operation_channel_id', 'operation_serial_num', 'operation_type', 'operation_snapshot'], 'required'],
            [['operation_channel_id', 'operation_type', 'operation_status'], 'integer'],
            [['operation_snapshot'], 'string'],
            [['operation_created_at', 'operation_finished_at', 'operation_updatead_at'], 'safe'],
            [['operation_serial_num'], 'string', 'max' => 64],
            [['operation_message'], 'string', 'max' => 255],
            [['operation_channel_id', 'operation_serial_num'], 'unique', 'targetAttribute' => ['operation_channel_id', 'operation_serial_num'], 'message' => 'The combination of Operation Channel ID and Operation Serial Num has already been taken.'],
            [['operation_channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['operation_channel_id' => 'channel_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'operation_id' => 'Operation ID',
            'operation_channel_id' => 'Operation Channel ID',
            'operation_serial_num' => 'Operation Serial Num',
            'operation_type' => 'Operation Type',
            'operation_status' => 'Operation Status',
            'operation_snapshot' => 'Operation Snapshot',
            'operation_message' => 'Operation Message',
            'operation_created_at' => 'Operation Created At',
            'operation_finished_at' => 'Operation Finished At',
            'operation_updatead_at' => 'Operation Updatead At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountLogs()
    {
        return $this->hasMany(AccountLog::className(), ['account_log_operation_id' => 'operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperationChannel()
    {
        return $this->hasOne(Channel::className(), ['channel_id' => 'operation_channel_id']);
    }
}