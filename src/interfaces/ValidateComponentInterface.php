<?php

namespace Itstructure\UsersModule\interfaces;

use yii\base\Model;

/**
 * Interface ValidateComponentInterface
 *
 * @package Itstructure\UsersModule\interfaces
 */
interface ValidateComponentInterface
{
    /**
     * Search model data.
     *
     * @param $model Model
     *
     * @return ModelInterface
     */
    public function setModel(Model $model): ModelInterface;
}