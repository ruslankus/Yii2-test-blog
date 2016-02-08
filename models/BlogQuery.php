<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Blog]].
 *
 * @see Blog
 */
class BlogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/


    public function withUserId($user_id)
    {
        $this->andWhere(
            'blg_blog.user_id = :user_id',
            [
                'user_id' => $user_id
            ]

        );
    }

    /**
     * @inheritdoc
     * @return Blog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Blog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}