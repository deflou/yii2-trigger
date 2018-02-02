<?php
namespace deflou\components\triggers\repositories;

use deflou\components\triggers\Yii2Trigger;
use deflou\interfaces\services\activities\IServiceEvent;
use deflou\interfaces\triggers\ITrigger;
use deflou\interfaces\triggers\repositories\ITriggersRepository;
use deflou\interfaces\users\identities\IUserIdentity;
use deflou\models\triggers\Yii2Triggers;

/**
 * Class Yii2TriggersRepository
 *
 * @package deflou\components\triggers\repositories
 * @author deflou.dev@gmail.com
 */
class Yii2TriggersRepository implements ITriggersRepository
{
    /**
     * @var array
     */
    protected $where = [];

    /**
     * @return static
     */
    public static function getInstance()
    {
        return new static();
    }

    /**
     * @param mixed $where
     *
     * @return $this
     */
    public function find($where)
    {
        $this->where = $where;

        return $this;
    }

    /**
     * @return Yii2Trigger|null
     */
    public function one()
    {
        $model = Yii2Triggers::find()->where($this->where)->one();

        return $model ? new Yii2Trigger($model) : $model;
    }

    /**
     * @return Yii2Trigger[]
     */
    public function all()
    {
        $models = Yii2Triggers::find()->where($this->where)->all();

        $triggers = [];

        foreach ($models as $model) {
            $triggers[] = new Yii2Trigger($model);
        }

        return $triggers;
    }

    /**
     * @param ITrigger $trigger
     *
     * @return bool
     * @throws \Exception
     */
    public function create($trigger): bool
    {
        if ($trigger instanceof Yii2Trigger) {
            $model = $trigger->getModel();

            if (!$model) {
                throw new \Exception('Missed model of "' . Yii2Trigger::class . '"');
            }

            /**
             * @var Yii2Triggers $model
             */
            return $model->save();
        }

        throw new \Exception('Can not operate with "' . get_class($trigger) . '" instance.');
    }

    /**
     * @param ITrigger $trigger
     *
     * @return bool
     */
    public function update($trigger)
    {
        return $this->create($trigger);
    }

    /**
     * @param ITrigger $trigger
     *
     * @return bool
     * @throws \Exception
     */
    public function delete($trigger): bool
    {
        if ($trigger instanceof Yii2Trigger) {
            $model = $trigger->getModel();

            if (!$model) {
                throw new \Exception('Missed model of "' . Yii2Trigger::class . '"');
            }

            /**
             * @var Yii2Triggers $model
             */
            return $model->delete();
        }

        throw new \Exception('Can not operate with "' . get_class($trigger) . '" instance.');
    }

    /**
     * @param IServiceEvent $serviceEvent
     * @param IUserIdentity $userIdentity
     *
     * @return ITrigger[]
     */
    public function identifyTriggersByServiceEvent(IServiceEvent $serviceEvent, IUserIdentity $userIdentity)
    {
        $models = Yii2Triggers::find()
            ->where([ITrigger::FIELD__SOURCE_EVENT => $serviceEvent->getName()])
            ->andWhere(['not', [ITrigger::FIELD__USERS . '.' . $userIdentity->getName() => null]])
            ->all();

        $triggers = [];

        foreach ($models as $model) {
            $triggers[] = new Yii2Trigger($model);
        }

        return $triggers;
    }
}
