<?php

namespace Itstructure\UsersModule\components;

use Yii;
use yii\web\IdentityInterface;
use yii\base\{Model, Component, InvalidConfigException};
use yii\rbac\ManagerInterface;
use Itstructure\UsersModule\{
    interfaces\ModelInterface,
    interfaces\ValidateComponentInterface,
    models\ProfileValidate
};

/**
 * Class ProfileValidateComponent
 * Component class for validation user fields.
 *
 * @property array $rules
 * @property array $attributes
 * @property array $attributeLabels
 * @property bool  $rbacManage
 * @property bool  $customRewrite
 * @property array $formFields
 * @property array $indexViewColumns
 * @property array $detailViewAttributes
 * @property ManagerInterface $authManager
 *
 * @package Itstructure\UsersModule\components
 */
class ProfileValidateComponent extends Component implements ValidateComponentInterface
{
    /**
     * Validate fields with rules.
     *
     * @var array
     */
    public $rules = [];

    /**
     * Attributes.
     *
     * @var array
     */
    public $attributes = [];

    /**
     * Attribute labels.
     *
     * @var array
     */
    public $attributeLabels = [];

    /**
     * Set manage for roles.
     *
     * @var bool
     */
    public $rbacManage = false;

    /**
     * Rewrite rules, labels, attributes by custom.
     *
     * @var bool
     */
    public $customRewrite = false;

    /**
     * Form fields for the template.
     *
     * @var array
     */
    public $formFields = [];

    /**
     * Columns for GridView widget in index template file.
     *
     * @var array
     */
    public $indexViewColumns = [];

    /**
     * Attributes for DetailView widget in view template file.
     *
     * @var array
     */
    public $detailViewAttributes = [];

    /**
     * Auth manager.
     *
     * @var ManagerInterface|null
     */
    private $authManager = null;

    /**
     * Initialize.
     */
    public function init()
    {
        if ($this->rbacManage && null === $this->authManager){
            throw new InvalidConfigException('The authManager is not defined.');
        }
    }

    /**
     * Returns the authManager (RBAC).
     *
     * @return ManagerInterface
     */
    public function getAuthManager(): ManagerInterface
    {
        return $this->authManager;
    }

    /**
     * Set authManager (RBAC).
     *
     * @param ManagerInterface|null $authManager
     */
    public function setAuthManager(ManagerInterface $authManager = null): void
    {
        $this->authManager = $authManager;
    }

    /**
     * Sets a user model for ProfileValidateComponent validation model.
     *
     * @param Model $model
     *
     * @return ModelInterface
     */
    public function setModel(Model $model): ModelInterface
    {
        if (!$model instanceof IdentityInterface){
            $modelClass = (new\ReflectionClass($model));
            throw new InvalidConfigException($modelClass->getNamespaceName() . '\\' . $modelClass->getShortName().' class  must be implemented from yii\web\IdentityInterface.');
        }

        /** @var ModelInterface $object */
        $object = Yii::createObject([
            'class' => ProfileValidate::class,
            'profileModel' => $model,
            'rules' => $this->rules,
            'attributes' => $this->attributes,
            'attributeLabels' => $this->attributeLabels,
            'rbacManage' => $this->rbacManage,
            'customRewrite' => $this->customRewrite,
            'authManager' => $this->authManager,
        ]);

        return $object;
    }
}
