<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\Feedbacks;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;


class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                //'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $feedbacks = new Feedbacks();

        $list = new ActiveDataProvider([
                'query' => $feedbacks->find(),
                'pagination' => [
                    'pagesize' => 25,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_DESC,
                    ],
                ],
        ]);


        $message = '';
        if ($feedbacks->load(Yii::$app->request->post()) && $feedbacks->validate())
        {
            if ($feedbacks->save(false)) $message=\Yii::t('app', '{name}, your feedback has been sent.', ['name' => $feedbacks->name]);
        }
        else if ($feedbacks->load(Yii::$app->request->post()) && !$feedbacks->validate())
        {
            $message = \Yii::t('app', 'Form errors. {open_link}Back to form.{close_link}', ['open_link' => '<a href="#add_feedback">', 'close_link' => '</a>']);
        }


        return $this->render(
            'index',
            [
                'feedbacks' => $list, //feedbacks list (ActiveDataProvider)
                'form' => $feedbacks, //feedbacks
                'message' => $message,
            ]
        );

    }

 
}
