<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blg_comment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $blog_id
 * @property string $comments
 * @property string $create_date
 *
 * @property User $user
 * @property Blog $blog
 */
class Comment extends \yii\db\ActiveRecord
{


    const MAX_COMMENT_LENTGH = 255;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blg_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'blog_id'], 'integer'],
            ['user_id','exist',
                'targetClass' => User::className(),
                'targetAttribute' => 'id'
            ],
            ['blog_id', 'exist',
                'targetClass' => Blog::className(),
                'targetAttribute' => 'id'
            ],
            [['create_date'], 'safe'],
            [['comments'], 'string', 'max' => self::MAX_COMMENT_LENTGH]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'blog_id' => 'Blog ID',
            'comments' => 'Comments',
            'create_date' => 'Create Date',
        ];
    }


    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            $this->user_id = Yii::$app->user->id;
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(Blog::className(), ['id' => 'blog_id']);
    }

    /**
     * @inheritdoc
     * @return CommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommentQuery(get_called_class());
    }
}
