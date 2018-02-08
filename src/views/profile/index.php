<?php

use yii\web\IdentityInterface;
use yii\db\ActiveRecord;
use yii\grid\GridView;
use yii\helpers\{Html, Url, ArrayHelper};
use Itstructure\UsersModule\Module;

/* @var $this yii\web\View */
/* @var $searchModel ActiveRecord|IdentityInterface */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $customRewrite bool */
/* @var $indexViewColumns array */

$this->title = Module::t('users', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Module::t('users', 'Create user'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => $customRewrite ? $indexViewColumns : ArrayHelper::merge(
            [
                'id' => [
                    'label' => Module::t('main', 'ID'),
                    'value' => function($searchModel) {
                        return Html::a(
                            Html::encode($searchModel->id),
                            Url::to(['view', 'id' => $searchModel->id])
                        );
                    },
                    'format' => 'raw',
                ],
                'name' => [
                    'label' => Module::t('users', 'Name'),
                    'value' => function($searchModel) {
                        return Html::a(
                            Html::encode($searchModel->name),
                            Url::to(['view', 'id' => $searchModel->id])
                        );
                    },
                    'format' => 'raw',
                ],
                'email' => [
                    'attribute' => 'email',
                    'label' =>  Module::t('users', 'Email'),
                ],
                'created_at' => [
                    'attribute' => 'created_at',
                    'label' => Module::t('main', 'Created date'),
                    'format' =>  ['date', 'd.M.Y H:m:s'],
                ],
                'updated_at' => [
                    'attribute' => 'updated_at',
                    'label' => Module::t('main', 'Updated date'),
                    'format' =>  ['date', 'd.M.Y H:m:s'],
                ],
                'ActionColumn' => [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => Module::t('main', 'Actions'),
                    'template' => '{view} {update} {delete}',
                ],
            ],
            $indexViewColumns
        )
    ]); ?>
</div>
