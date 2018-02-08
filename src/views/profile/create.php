<?php

use Itstructure\UsersModule\Module;

/* @var $this yii\web\View */
/* @var $model Itstructure\UsersModule\models\ProfileValidate */
/* @var $customRewrite bool */
/* @var $additionFields array */
/* @var $roles yii\rbac\Role[] */

$this->title = Module::t('users', 'Create user');
$this->params['breadcrumbs'][] = ['label' => Module::t('users', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'customRewrite' => $customRewrite,
        'additionFields' => $additionFields,
        'roles' => isset($roles) && is_array($roles) ? $roles : [],
    ]) ?>

</div>
