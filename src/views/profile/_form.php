<?php

use yii\widgets\ActiveForm;
use yii\helpers\{ArrayHelper, Html};
use Itstructure\FieldWidgets\{Fields, FieldType};
use Itstructure\UsersModule\Module;

/* @var $this yii\web\View */
/* @var $model Itstructure\UsersModule\models\ProfileValidate */
/* @var $form yii\widgets\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $customRewrite bool */
/* @var $additionFields array */
/* @var $additionTemplate string */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

            <?php echo $customRewrite ? $additionTemplate : $additionTemplate . Fields::widget([
                    'fields' => $customRewrite ? $additionFields : ArrayHelper::merge(
                        ArrayHelper::merge(
                            isset($roles) && is_array($roles) && !empty($roles) ?
                                [
                                    'roles' => [
                                        'name' => 'roles',
                                        'type' => FieldType::FIELD_TYPE_CHECKBOX,
                                        'data' => ArrayHelper::map($roles, 'name', 'name'),
                                        'label' => Module::t('users', 'Roles')
                                    ]
                                ] : [],
                            [
                                'name' => [
                                    'name' => 'name',
                                    'type' => FieldType::FIELD_TYPE_TEXT,
                                    'label' => Module::t('users', 'Name')
                                ],
                                'login' => [
                                    'name' => 'login',
                                    'type' => FieldType::FIELD_TYPE_TEXT,
                                    'label' => Module::t('users', 'Login')
                                ],
                                'email' => [
                                    'name' => 'email',
                                    'type' => FieldType::FIELD_TYPE_TEXT,
                                    'label' => Module::t('users', 'Email')
                                ],
                                'status' => [
                                    'name' => 'status',
                                    'type' => FieldType::FIELD_TYPE_DROPDOWN,
                                    'data' => [
                                        1 => Module::t('main', 'Active'),
                                        0 => Module::t('main', 'Blocked')
                                    ],
                                    'label' => Module::t('users', 'Status'),
                                ],
                                'password' => [
                                    'name' => 'password',
                                    'type' => FieldType::FIELD_TYPE_PASSWORD,
                                    'label' => Module::t('users', 'Password')
                                ],
                                'passwordRepeat' => [
                                    'name' => 'passwordRepeat',
                                    'type' => FieldType::FIELD_TYPE_PASSWORD,
                                    'label' => Module::t('users', 'Password confirm')
                                ],
                            ]
                        ),
                        $additionFields
                    ),
                    'model' => $model,
                    'form'  => $form,
                ]) ?>

        </div>
    </div>


    <div class="form-group">
        <?php echo Html::submitButton(Module::t('main', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
