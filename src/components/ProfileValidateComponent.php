<?php

namespace Itstructure\UsersModule\components;

use Yii;
use yii\db\ActiveRecordInterface;
use yii\web\IdentityInterface;
use yii\base\{Component, InvalidConfigException};
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
    private $rules = [];

    /**
     * Attributes.
     *
     * @var array
     */
    private $attributes = [];

    /**
     * Attribute labels.
     *
     * @var array
     */
    private $attributeLabels = [];

    /**
     * Set manage for roles.
     *
     * @var bool
     */
    private $rbacManage = false;

    /**
     * Rewrite rules, labels, attributes by custom.
     *
     * @var bool
     */
    private $customRewrite = false;

    /**
     * Form fields for the template.
     *
     * @var array
     */
    private $formFields = [];

    /**
     * Columns for GridView widget in index template file.
     *
     * @var array
     */
    private $indexViewColumns = [];

    /**
     * Attributes for DetailView widget in view template file.
     *
     * @var array
     */
    private $detailViewAttributes = [];

    /**
     * Auth manager.
     *
     * @var ManagerInterface
     */
    private $authManager;

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
     * Set validate fields with rules.
     *
     * @param array $rules
     */
    public function setRules(array $rules): void
    {
        $this->rules = $rules;
    }

    /**
     * Get validate fields with rules.
     *
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * Set attributes.
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * Get attributes.
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Set attribute labels.
     *
     * @param array $attributeLabels
     */
    public function setAttributeLabels(array $attributeLabels): void
    {
        $this->attributeLabels = $attributeLabels;
    }

    /**
     * Get attribute labels.
     *
     * @return array
     */
    public function getAttributeLabels(): array
    {
        return $this->attributeLabels;
    }

    /**
     * Set manage for roles.
     *
     * @param bool $rbacManage
     */
    public function setRbacManage(bool $rbacManage): void
    {
        $this->rbacManage = $rbacManage;
    }

    /**
     * Is manage for roles.
     *
     * @return bool
     */
    public function getRbacManage(): bool
    {
        return $this->rbacManage;
    }

    /**
     * Set rewrite rules, labels, attributes by custom.
     *
     * @param bool $customRewrite
     */
    public function setCustomRewrite(bool $customRewrite): void
    {
        $this->customRewrite = $customRewrite;
    }

    /**
     * Get rewrite rules, labels, attributes by custom.
     *
     * @return bool
     */
    public function getCustomRewrite(): bool
    {
        return $this->customRewrite;
    }

    /**
     * Set form fields for the template.
     *
     * @param array $formFields
     */
    public function setFormFields(array $formFields): void
    {
        $this->formFields = $formFields;
    }

    /**
     * Get Form fields for the template.
     *
     * @return array
     */
    public function getFormFields(): array
    {
        return $this->formFields;
    }

    /**
     * Set columns for GridView widget in index template file.
     *
     * @param array $indexViewColumns
     */
    public function setIndexViewColumns(array $indexViewColumns): void
    {
        $this->indexViewColumns = $indexViewColumns;
    }

    /**
     * Get columns for GridView widget in index template file.
     *
     * @return array
     */
    public function getIndexViewColumns(): array
    {
        return $this->indexViewColumns;
    }

    /**
     * Set attributes for DetailView widget in view template file.
     *
     * @param array $detailViewAttributes
     */
    public function setDetailViewAttributes(array $detailViewAttributes): void
    {
        $this->detailViewAttributes = $detailViewAttributes;
    }

    /**
     * Get attributes for DetailView widget in view template file.
     *
     * @return array
     */
    public function getDetailViewAttributes(): array
    {
        return $this->detailViewAttributes;
    }

    /**
     * Set authManager (RBAC).
     *
     * @param ManagerInterface $authManager
     */
    public function setAuthManager(ManagerInterface $authManager): void
    {
        $this->authManager = $authManager;
    }

    /**
     * Get authManager (RBAC).
     *
     * @return ManagerInterface
     */
    public function getAuthManager(): ManagerInterface
    {
        return $this->authManager;
    }

    /**
     * Set a user model for ProfileValidateComponent validation model.
     *
     * @param $model
     *
     * @throws InvalidConfigException
     *
     * @return ModelInterface
     */
    public function setModel($model): ModelInterface
    {
        ProfileValidate::checkProfileModel($model);

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
