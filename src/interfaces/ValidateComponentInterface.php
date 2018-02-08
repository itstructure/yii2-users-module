<?php

namespace Itstructure\UsersModule\interfaces;

use yii\web\IdentityInterface;

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
     * @param $model IdentityInterface
     *
     * @return ModelInterface
     */
    public function setModel(IdentityInterface $model): ModelInterface;
}