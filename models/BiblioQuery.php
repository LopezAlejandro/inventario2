<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Biblio]].
 *
 * @see Biblio
 */
class BiblioQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Biblio[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Biblio|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
