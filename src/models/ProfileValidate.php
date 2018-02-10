<?php

namespace Itstructure\UsersModule\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\rbac\ManagerInterface;
use yii\base\{Model, InvalidConfigException};
use Itstructure\UsersModule\interfaces\ModelInterface;

/**
 * Class for validation user fields.
 *
 * @property array  $rules
 * @property array  $attributes
 * @property array  $attributeLabels
 * @property bool  $rbacManage
 * @property bool  $customRewrite
 * @property IdentityInterface|ActiveRecord  $profileModel
 * @property ManagerInterface  $authManager
 * @property string  $name
 * @property string  $login
 * @property string  $email
 * @property integer  $status
 * @property string  $password
 * @property string  $passwordRepeat
 *
 * @package Itstructure\UsersModule\models
 */
class ProfileValidate extends Model implements ModelInterface
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
     * Current profile (user) model.
     *
     * @var IdentityInterface|ActiveRecord
     */
    public $profileModel;

    /**
     * Auth manager.
     *
     * @var ManagerInterface|null
     */
    private $authManager = null;

    /**
     * Scenarios constants.
     */
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

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
     * @inheritdoc
     */
    public function rules()
    {
        $rules = $this->customRewrite ? $this->rules : ArrayHelper::merge(
            [
                'required' => [
                    [
                        'name',
                        'login',
                        'email',
                        'status'
                    ],
                    'required',
                ],
                'requiredOnCreate' => [
                    [
                        'password',
                        'passwordRepeat',
                    ],
                    'required',
                    'on' => self::SCENARIO_CREATE,
                ],
                'string' => [
                    [
                        'name',
                        'login',
                        'email',
                        'password',
                        'passwordRepeat',
                    ],
                    'string',
                    'max' => 255,
                ],
                'integer' => [
                    [
                        'status',
                    ],
                    'integer',
                ],
                'name' => [
                    'name',
                    'unique',
                    'skipOnError'     => true,
                    'targetClass'     => \Yii::$app->user->identityClass,
                    'targetAttribute' => ['name' => 'name'],
                    'filter' => $this->getScenario() == self::SCENARIO_UPDATE ? 'id != '.$this->id : ''
                ],
                'login' => [
                    'login',
                    'unique',
                    'skipOnError'     => true,
                    'targetClass'     => \Yii::$app->user->identityClass,
                    'targetAttribute' => ['login' => 'login'],
                    'filter' => $this->getScenario() == self::SCENARIO_UPDATE ? 'id != '.$this->id : ''
                ],
                'email' => [
                    'email',
                    'unique',
                    'skipOnError'     => true,
                    'targetClass'     => \Yii::$app->user->identityClass,
                    'targetAttribute' => ['email' => 'email'],
                    'filter' => $this->getScenario() == self::SCENARIO_UPDATE ? 'id != '.$this->id : ''
                ],
                'password' => [
                    'password',
                    'compare',
                    'compareAttribute' => 'passwordRepeat',
                ],
                'passwordRepeat' => [
                    'passwordRepeat',
                    'compare',
                    'compareAttribute' => 'password',
                ]
            ],
            $this->rules
        );

        return $this->rbacManage ? ArrayHelper::merge(
            $rules,
            [
                'requiredRoles' => [
                    'roles',
                    'required',
                ],
                'validateRoles' => [
                    'roles',
                    'validateRoles',
                ],
            ]
        ) : $rules;
    }

    /**
     * Scenarios.
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => $this->attributes(),
            self::SCENARIO_UPDATE => $this->attributes(),
            self::SCENARIO_DEFAULT => $this->attributes(),
        ];
    }

    /**
     * List if attributes.
     *
     * @return array
     */
    public function attributes()
    {
        $attributes = $this->customRewrite ? $this->attributes : ArrayHelper::merge(
            [
                'name',
                'login',
                'email',
                'status',
                'password',
                'passwordRepeat',
            ],
            $this->attributes
        );

        return $this->rbacManage ? ArrayHelper::merge(
            $attributes,
            [
                'roles',
            ]
        ) : $attributes;
    }

    /**
     * List if attribute labels.
     *
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = $this->customRewrite ? $this->attributeLabels : ArrayHelper::merge(
            [
                'name' => 'Name',
                'login' => 'Login',
                'email' => 'Email',
                'status' => 'Status',
                'password' => 'Password',
                'passwordRepeat' => 'Password confirm',
            ],
            $this->attributeLabels
        );

        return $this->rbacManage ? ArrayHelper::merge(
            $attributeLabels,
            [
                'roles' => 'Roles',
            ]
        ) : $attributeLabels;
    }

    /**
     * Set auth manager.
     *
     * @param ManagerInterface|null $authManager
     */
    public function setAuthManager(ManagerInterface $authManager = null): void
    {
        $this->authManager = $authManager;
    }

    /**
     * Get field value.
     *
     * @param string $name field name.
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        if ($this->profileModel->isNewRecord){
            return $this->{$name} ?? '';
        }

        if ($this->rbacManage && 'roles' === $name){
            $roles = $this->authManager->getRolesByUser($this->profileModel->getId());
            return array_keys($roles);
        }

        if ($this->rbacManage && 'authManager' === $name){
            return $this->authManager;
        }

        return $this->profileModel->{$name} ?? '';
    }

    /**
     * Set field value.
     *
     * @param string $name  name of field.
     *
     * @param mixed  $value value to be stored in field.
     *
     * @return mixed
     */
    public function __set($name, $value)
    {
        return $this->{$name} = $value;
    }

    /**
     * Returns profile (user) model.
     *
     * @return IdentityInterface
     */
    public function getProfileModel(): IdentityInterface
    {
        return $this->profileModel;
    }

    /**
     * Set profile (user) model.
     *
     * @param $model IdentityInterface.
     *
     * @return void
     */
    public function setProfileModel(IdentityInterface $model): void
    {
        $this->profileModel = $model;
    }

    /**
     * Validate roles data format.
     *
     * @param $attribute
     *
     * @return bool
     */
    public function validateRoles($attribute): bool
    {
        if (!is_array($this->roles)){
            $this->addError($attribute, 'Incorrect roles data format.');
            return false;
        }

        return true;
    }

    /**
     * Save user data.
     *
     * @return bool
     */
    public function save(): bool
    {
        if ($this->profileModel->isNewRecord){
            $this->setScenario(self::SCENARIO_CREATE);
        } else {
            $this->setScenario(self::SCENARIO_UPDATE);
        }

        if (!$this->validate()){
            return false;
        }

        foreach ($this->attributes() as $attribute) {

            if (null !== $this->{$attribute} && 'roles' !== $attribute){
                $this->profileModel->{$attribute} = $this->{$attribute};
            }
        }

        if (!$this->profileModel->save()){
            return false;
        }

        if ($this->rbacManage){
            $this->assignRoles();
        }

        return true;
    }

    /**
     * Returns current model id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->profileModel->getId();
    }

    /**
     * Assign roles.
     *
     * @return void
     */
    private function assignRoles(): void
    {
        if (!$this->profileModel->isNewRecord){
            $this->authManager->revokeAll(
                $this->profileModel->getId()
            );
        }

        foreach ($this->roles as $role){
            $this->authManager->assign(
                $this->authManager->getRole($role),
                $this->profileModel->getId()
            );
        }
    }
}
