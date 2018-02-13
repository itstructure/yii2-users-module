<?php

use yii\db\ActiveRecord;
use yii\web\{View, IdentityInterface};
use yii\helpers\{Html, ArrayHelper};
use yii\widgets\DetailView;
use Itstructure\UsersModule\Module;

/* @var $this View */
/* @var $model ActiveRecord|IdentityInterface */
/* @var $customRewrite bool */
/* @var $detailViewAttributes array */

$this->title = Module::t('users', 'User') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-view">

    <p>
        <?php echo Html::a(Module::t('main', 'Update'), ['update', 'id' => $model->id], [
            'class' => 'btn btn-primary'
        ]) ?>

        <?php echo Html::a(Module::t('main', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Module::t('main', 'Are you sure you want to do this action?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => $customRewrite ? $detailViewAttributes : ArrayHelper::merge(
            [
                'id' => [
                    'attribute' => 'id',
                    'label' => Module::t('main', 'ID')
                ],
                'name' => [
                    'attribute' => 'name',
                    'label' => Module::t('users', 'Name')
                ],
                'login' => [
                    'attribute' => 'login',
                    'label' => Module::t('users', 'Login')
                ],
                'email' => [
                    'attribute' => 'email',
                    'label' => Module::t('users', 'Email')
                ],
                'status' => [
                    'attribute' => 'status',
                    'label' => Module::t('users', 'Status'),
                    'value' => isset($model->status) && !empty($model->status) ? function($data) {
                        return $data->status == 1 ? Module::t('main', 'Active') : Module::t('main', 'Blocked');
                    } : Module::t('users', 'No status'),
                ],
                'roles' => [
                    'attribute' => 'roles',
                    'label' => Module::t('users', 'Roles'),
                    'value' => isset($model->roleName) && !empty($model->roleName) ? function($data) {
                        return $data->roleName;
                    } : Module::t('users', 'No roles'),
                ],
                'created_at' => [
                    'attribute' => 'created_at',
                    'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                    'label' => Module::t('main', 'Created date')
                ],
                'updated_at' => [
                    'attribute' => 'updated_at',
                    'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                    'label' => Module::t('main', 'Updated date')
                ],
            ],
            $detailViewAttributes
        )
    ]) ?>

</div>
