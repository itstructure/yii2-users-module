<?php

namespace Itstructure\UsersModule\controllers;

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

        $this->additionFields['customRewrite'] = $this->validateComponent->getCustomRewrite();

        parent::init();
    }

    /**
     * Set other additionFields for all actions.
     *
     * @param $action
     *
     * @return mixed
     */
    public function beforeAction($action)
    {
        if ($this->action->id == 'create' || $this->action->id == 'update'){
            $this->additionFields['additionFields'] = $this->validateComponent->getFormFields();

            if ($this->validateComponent->getRbacManage()){
                $this->additionFields['roles'] = $this->validateComponent->getAuthManager()->getRoles();
            }
        }

        if ($this->action->id == 'index'){
            $this->additionFields['indexViewColumns'] = $this->validateComponent->getIndexViewColumns();
        }

        if ($this->action->id == 'view'){
            $this->additionFields['detailViewAttributes'] = $this->validateComponent->getDetailViewAttributes();
        }

        return parent::beforeAction($action);
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
