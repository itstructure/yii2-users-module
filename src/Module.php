<?php

namespace Itstructure\UsersModule;

use Yii;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\base\Module as BaseModule;
use Itstructure\UsersModule\components\ProfileValidateComponent;

/**
 * Users module class.
 *
 * @property null|string|array $loginUrl
 * @property bool $rbacManage
 * @property bool $customRewrite
 * @property array $accessRoles
 * @property View $_view
 *
 * @package Itstructure\UsersModule
 */
class Module extends BaseModule
{
    /**
     * Login url.
     *
     * @var null|string|array
     */
    public $loginUrl = null;

    /**
     * Set manage for rbac (roles and permissions).
     *
     * @var bool
     */
    public $rbacManage = false;

    /**
     * Array of roles to module access.
     *
     * @var array
     */
    public $accessRoles = ['@'];

    /**
     * Rewrite rules, labels, attributes, template fields by custom.
     *
     * @var bool
     */
    public $customRewrite = false;

    /**
     * View component to render content.
     *
     * @var View
     */
    private $_view = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Yii::setAlias('@users', static::getBaseDir());

        if (null !== $this->loginUrl) {
            Yii::$app->getUser()->loginUrl = $this->loginUrl;
        }

        /**
         * Set Profile validate component
         */
        $this->setComponents(
            ArrayHelper::merge(
                $this->getProfileValidateComponentConfig(),
                $this->components
            )
        );

        $this->registerTranslations();
    }

    /**
     * Returns module root directory.
     *
     * @return string
     */
    public static function getBaseDir(): string
    {
        return __DIR__;
    }

    /**
     * Module translator.
     *
     * @param       $category
     * @param       $message
     * @param array $params
     * @param null  $language
     *
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/users/' . $category, $message, $params, $language);
    }

    /**
     * Set i18N component.
     *
     * @return void
     */
    public function registerTranslations(): void
    {
        Yii::$app->i18n->translations = ArrayHelper::merge(
            [
                'modules/users/*' => [
                    'class'          => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                    'sourceLanguage' => Yii::$app->language,
                    'basePath'       => '@users/messages',
                    'fileMap'        => [
                        'modules/users/main' => 'main.php',
                        'modules/users/users' => 'users.php',
                    ],
                ]
            ],
            Yii::$app->i18n->translations
        );
    }

    /**
     * Get the view.
     *
     * @return View
     */
    public function getView()
    {
        if (null === $this->_view) {
            $this->_view = $this->get('view');
        }

        return $this->_view;
    }

    /**
     * Profile validate component config.
     *
     * @return array
     */
    private function getProfileValidateComponentConfig(): array
    {
        return [
            'profile-validate-component' => [
                'class' => ProfileValidateComponent::class,
                'rbacManage' => $this->rbacManage,
                'customRewrite' => $this->customRewrite,
                'authManager' => $this->rbacManage ? Yii::$app->authManager : null,
            ]
        ];
    }
}
