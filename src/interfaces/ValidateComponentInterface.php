<?php

namespace Itstructure\UsersModule\interfaces;

use yii\rbac\ManagerInterface;

/**
 * Interface ValidateComponentInterface
 *
 * @package Itstructure\UsersModule\interfaces
 */
interface ValidateComponentInterface
{
    /**
     * Set validate fields with rules.
     *
     * @param array $rules
     */
    public function setRules(array $rules): void;

    /**
     * Get validate fields with rules.
     *
     * @return array
     */
    public function getRules(): array ;

    /**
     * Set attributes.
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void;

    /**
     * Get attributes.
     *
     * @return array
     */
    public function getAttributes(): array ;

    /**
     * Set attribute labels.
     *
     * @param array $attributeLabels
     */
    public function setAttributeLabels(array $attributeLabels): void;

    /**
     * Get attribute labels.
     *
     * @return array
     */
    public function getAttributeLabels(): array ;

    /**
     * Set manage for roles.
     *
     * @param bool $rbacManage
     */
    public function setRbacManage(bool $rbacManage): void;

    /**
     * Is manage for roles.
     *
     * @return bool
     */
    public function getRbacManage(): bool ;

    /**
     * Set rewrite rules, labels, attributes by custom.
     *
     * @param bool $customRewrite
     */
    public function setCustomRewrite(bool $customRewrite): void;

    /**
     * Get rewrite rules, labels, attributes by custom.
     *
     * @return bool
     */
    public function getCustomRewrite(): bool ;

    /**
     * Set form fields for the template.
     *
     * @param array $formFields
     */
    public function setFormFields(array $formFields): void;

    /**
     * Get Form fields for the template.
     *
     * @return array
     */
    public function getFormFields(): array ;

    /**
     * Set form fields template.
     *
     * @param string|callable $formTemplate
     */
    public function setFormTemplate($formTemplate): void;

    /**
     * Get form fields template.
     *
     * @return string|callable
     */
    public function getFormTemplate();

    /**
     * Set columns for GridView widget in index template file.
     *
     * @param array $indexViewColumns
     */
    public function setIndexViewColumns(array $indexViewColumns): void;

    /**
     * Get columns for GridView widget in index template file.
     *
     * @return array
     */
    public function getIndexViewColumns(): array ;

    /**
     * Set attributes for DetailView widget in view template file.
     *
     * @param array $detailViewAttributes
     */
    public function setDetailViewAttributes(array $detailViewAttributes): void;

    /**
     * Get attributes for DetailView widget in view template file.
     *
     * @return array
     */
    public function getDetailViewAttributes(): array ;

    /**
     * Set authManager (RBAC).
     *
     * @param ManagerInterface $authManager
     */
    public function setAuthManager(ManagerInterface $authManager): void;

    /**
     * Get authManager (RBAC).
     *
     * @return ManagerInterface
     */
    public function getAuthManager(): ManagerInterface;

    /**
     * Search model data.
     *
     * @param $model
     *
     * @return ModelInterface
     */
    public function setModel($model): ModelInterface;
}