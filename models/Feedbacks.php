<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Html;

class Feedbacks extends ActiveRecord
{
	public $captcha;

	public function rules()
	{
		return [
			[['name', 'email', 'text', 'captcha'], 'required', 'message' => \Yii::t('app', 'This field is required')],
			['email', 'email', 'message' => \Yii::t('app', 'Invalid email')],
			['url', 'url', 'message' => \Yii::t('app', 'Invalid url')],
			['captcha', 'captcha', 'message' => \Yii::t('app', 'Incorrect Code')],
			['text', 'validateTags'],
			['text', 'validateClosingTags'],
		];
	}

	public function validateTags($attribute, $params)
    {
    	$tags = '<code><i><strike><a><strong>';
        $cutTags = strip_tags($this->$attribute, $tags);
        if (mb_strlen($this->$attribute) !== mb_strlen($cutTags))
        {
        	$this->addError($attribute, \Yii::t('app', 'You have used forbidden tags. Whitelist: {tags}.', ['tags' => '<a>, <code>, <i>, <strike>, <strong>']));
        }
    }

    public function validateClosingTags($attribute, $params)
    {
    	$tags = array(
    		['/<code>/','/<\/code>/'],
    		['/<i>/','/<\/i>/'],
    		['/<strike>/','/<\/strike>/'],
    		['/<a(.*?href="[^"]*".*|.*?title="[^"]*".*)?>/','/<\/a>/'],
    		['/<strong>/','/<\/strong>/']
    	);
    	foreach ($tags as $tag)
        {
        	if (preg_match_all($tag[0], $this->$attribute) != preg_match_all($tag[1], $this->$attribute))
        	{
        		$this->addError($attribute, \Yii::t('app', 'Tags closing/opening error.'));
        	}
        }
    }

	public function beforeSave($insert)
	{
	    if (parent::beforeSave($insert))
        {
            $this->ip = Yii::$app->getRequest()->getUserIP();
            $this->agent = Yii::$app->getRequest()->getUserAgent();
	        $this->date = new Expression('NOW()');
	        return true;
	    }
        else
        {
	        return false;
	    }
	}

}

?>