<?php

namespace app\modules\catalogs\models;

/**
 * This is the ActiveQuery class for [[Universidad]].
 *
 * @see Universidad
 */
class UniversidadQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Universidad[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Universidad|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
