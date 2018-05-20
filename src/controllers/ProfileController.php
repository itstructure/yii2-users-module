<?php

namespace Itstructure\UsersModule\controllers;

use yii\base\InvalidConfigException;

/**
 * Class ProfileController
 * ProfileController implements the CRUD actions for identityClass.
 *
 * @package Itstructure\UsersModule\controllers
 */
class ProfileController extends BaseController
{
    /**
     * Initialize.
     * Set validateComponent and additionFields.
     */
    public function init()
    {
        $this->viewPath = '@users/views/profile';

        $this->validateComponent = $this->module->get('profile-validate-component');

        parent::init();
    }

    /**
     * Returns addition fields.
     *
     * @throws InvalidConfigException
     *
     * @return array
     */
    protected function getAdditionFields(): array
    {
        $additionFields = [];

        $additionFields['customRewrite'] = $this->validateComponent->getCustomRewrite();

        if ($this->action->id == 'create' || $this->action->id == 'update'){
            $additionFields['additionFields'] = $this->validateComponent->getFormFields();

            $additionTemplate = $this->validateComponent->getFormTemplate();
            if (is_callable($additionTemplate)){
                $additionTemplate = call_user_func($additionTemplate, $this->getModel());
            }
            if (is_string($additionTemplate)){
                $additionFields['additionTemplate'] = $additionTemplate;
            } else {
                throw new InvalidConfigException('Addition template as a result be a string.');
            }

            if ($this->validateComponent->getRbacManage()){
                $additionFields['roles'] = $this->validateComponent->getAuthManager()->getRoles();
            }
        }

        if ($this->action->id == 'index'){
            $additionFields['indexViewColumns'] = $this->validateComponent->getIndexViewColumns();
        }

        if ($this->action->id == 'view'){
            $additionFields['detailViewAttributes'] = $this->validateComponent->getDetailViewAttributes();
        }

        return $additionFields;
    }

    /**
     * Returns identityClass model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return \Yii::$app->user->identityClass;
    }

    /**
     * Returns identityClass Search model name.
     *
     * @return string
     */
    protected function getSearchModelName():string
    {
        return \Yii::$app->user->identityClass . 'Search';
    }
}
