<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Yii Crud';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <h1><?php echo Html::encode($this->title) ?></h1>
    <p>
        <?php echo Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            'description',
            'category',
            ['class' => 'yii\grid\ActionColumn']
        ],
    ]); ?>
</div>