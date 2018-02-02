<?php
namespace deflou\components\triggers;

use deflou\interfaces\triggers\ITrigger;
use deflou\models\triggers\Yii2Triggers;

/**
 * Class Yii2Trigger
 *
 * @package deflou\components\triggers
 * @author deflou.dev@gmail.com
 */
class Yii2Trigger extends TriggerAbstract implements ITrigger
{
    /**
     * @var Yii2Triggers
     */
    protected $model = null;

    /**
     * @return null|Yii2Triggers
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    protected function getAttribute($name)
    {
        if (!$this->model) {
            return null;
        }

        return $this->model->$name;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    protected function setAttribute($name, $value)
    {
        if (!$this->model) {
            return $this;
        }

        $this->model->$name = $value;

        return $this;
    }
}
