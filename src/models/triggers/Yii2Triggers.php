<?php

namespace deflou\models\triggers;

use deflou\interfaces\triggers\ITrigger;
use yii\mongodb\ActiveRecord;

/**
 * This is the model class for collection "<df prefix>_triggers".
 *
 * @property $_id
 * @property $name
 * @property $title
 * @property $description
 *
 * @property $source_service
 * @property $destination_service
 *
 * @property $source_event
 * @property $destination_action
 *
 * @property $event_options
 * @property $action_options
 *
 * @property $users
 * @property $created
 * @property $last_execution_time
 * @property $executions_count
 */
class Yii2Triggers extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        $prefix = getenv('DF_DB_PREFIX') ?: 'df';

        return  $prefix . '_triggers';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            ITrigger::NAME,
            ITrigger::TITLE,
            ITrigger::DESCRIPTION,

            ITrigger::FIELD__SOURCE_SERVICE,
            ITrigger::FIELD__DESTINATION_SERVICE,

            ITrigger::FIELD__SOURCE_EVENT,
            ITrigger::FIELD__DESTINATION_ACTION,

            ITrigger::FIELD__EVENT_OPTIONS,
            ITrigger::FIELD__ACTION_OPTIONS,

            ITrigger::FIELD__USERS,
            ITrigger::FIELD__CREATED,
            ITrigger::FIELD__LAST_EXECUTION_TIME,
            ITrigger::FIELD__EXECUTIONS_COUNT
        ];
    }
}
