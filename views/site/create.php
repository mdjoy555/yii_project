<?php
use yii\helpers\html;
use yii\widgets\ActiveForm;
/** @var yii\web\View $this */

$this->title = 'Yii Crud';
?>
<div class="site-index">
    <h1>Create Post</h1>
    <div class="body-content">
        <?php
            $form = ActiveForm::begin();
        ?>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-6">
                    <?php
                        echo $form->field($post,'title');
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-6">
                    <?php
                        echo $form->field($post,'description')->textarea(['rows' => 6]);
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-6">
                    <?php
                        $items = ['ecommerce'=>'ecommerce','cms'=>'cms','mvc'=>'mvc'];
                        echo $form->field($post,'category')->dropDownList($items,['prompt' => 'Select']);
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-6">
                        <?php
                            echo Html::submitButton('Create',['class' => 'btn btn-primary']);
                        ?>
                        <a href="<?php echo yii::$app->homeUrl;?>" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <?php
            ActiveForm::end();
        ?>
    </div>
</div>
