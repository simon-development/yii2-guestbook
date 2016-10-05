<?php

/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title = \Yii::t('app', 'Guestbook');
?>
<div class="site-index">
<?php if ($message){?><p class="hint-block"><b><?=$message?></b></p><?php } ?>

<h1><?=\Yii::t('app', 'Feedbacks');?> <a href="#add_feedback" class="add_button">+</a></h1>
<?= GridView::widget([
    'dataProvider' => $feedbacks,
    'columns' => [
        [
            'attribute'=>'date',
            'label'=>\Yii::t('app', 'Date'),
            'format'=>'datetime',
        ],
        [
            'attribute'=>'name',
            'label'=>\Yii::t('app', 'Name'),
            'format' => 'raw',
            'value' => function($data)
            {
                if ($data->url)
                {
                    return Html::a(
                        $data->name,
                        $data->url,
                        [
                            'title' => $data->url,
                            'target' => '_blank'
                        ]
                    );
                };
                return Html::tag('p', Html::encode($data->name));
            }
        ],
        [
            'attribute'=>'email',
            'label'=>'E-mail',
            'format' => 'raw',
            'value' => function($data){
                return Html::mailto($data->email, $data->email);
            }
        ],
        [
            'attribute'=>'ip-agent',
            'label'=>'IP/Agent',
            'format' => 'raw',
            'value' => function($data){
                return Html::tag('p', Html::encode($data->ip)).
                    Html::tag('p', Html::encode($data->agent));;
            }
        ],
        [
            'attribute'=>'text',
            'label'=>\Yii::t('app', 'Feedback'),
            'format' => 'raw',
            'value' => function($data){
                return nl2br(Html::decode($data->text));
            }
        ],
    ],
]); ?>

<h2 style="padding-top: 50px;" id="add_feedback"><?= \Yii::t('app', 'Add feedback');?></h2>
<?php $f = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <?= $f->field($form, 'name'); ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $f->field($form, 'email'); ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <?= $f->field($form, 'url'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= $f->field($form, 'text')->textArea(['rows' => '6']); ?>
            <p>
            <?=\Yii::t('app', 'Tags:');?> <a class="add_tag" data-parameter="strong">strong</a>
            <a class="add_tag" data-parameter="i">italic</a>
            <a class="add_tag" data-parameter="strike">strike</a>
            <a class="add_tag" data-parameter="code">code</a>
            <a class="add_tag" data-parameter="a">a</a>
            </p>
            <p>
            <a class="show_preview"><?= \Yii::t('app', 'Preview');?></a>
            </p>
            <div id="preview"></div>
        </div>
    </div>
    <?= $f->field($form, 'captcha')->widget(Captcha::className()) ?>
    <?= Html::submitButton(\Yii::t('app', 'Send'), ['class' => 'btn btn-primary submit-button']) ?>
<?php ActiveForm::end(); ?>

</div>
