<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "biblioitems".
 *
 * @property integer $biblioitemnumber
 * @property integer $biblionumber
 * @property string $volume
 * @property string $number
 * @property string $itemtype
 * @property string $isbn
 * @property string $issn
 * @property string $ean
 * @property string $publicationyear
 * @property string $publishercode
 * @property string $volumedate
 * @property string $volumedesc
 * @property string $collectiontitle
 * @property string $collectionissn
 * @property string $collectionvolume
 * @property string $editionstatement
 * @property string $editionresponsibility
 * @property string $timestamp
 * @property string $illus
 * @property string $pages
 * @property string $notes
 * @property string $size
 * @property string $place
 * @property string $lccn
 * @property string $url
 * @property string $cn_source
 * @property string $cn_class
 * @property string $cn_item
 * @property string $cn_suffix
 * @property string $cn_sort
 * @property string $agerestriction
 * @property integer $totalissues
 *
 * @property \app\models\Biblio $biblionumber0
 * @property \app\models\Items[] $items
 */
class BiblioItems extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct(){
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => \Yii::$app->user->id,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'biblionumber0',
            'items'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['biblionumber', 'totalissues'], 'integer'],
            [['volume', 'number', 'isbn', 'issn', 'ean', 'publicationyear', 'volumedesc', 'collectiontitle', 'collectionissn', 'collectionvolume', 'editionstatement', 'editionresponsibility', 'notes', 'lccn', 'url'], 'string'],
            [['volumedate', 'timestamp'], 'safe'],
            [['itemtype', 'cn_source', 'cn_item', 'cn_suffix'], 'string', 'max' => 10],
            [['publishercode', 'illus', 'pages', 'size', 'place', 'cn_sort', 'agerestriction'], 'string', 'max' => 255],
            [['cn_class'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'biblioitems';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'biblioitemnumber' => 'Biblioitemnumber',
            'biblionumber' => 'Biblionumber',
            'volume' => 'Volume',
            'number' => 'Number',
            'itemtype' => 'Itemtype',
            'isbn' => 'Isbn',
            'issn' => 'Issn',
            'ean' => 'Ean',
            'publicationyear' => 'Publicationyear',
            'publishercode' => 'Publishercode',
            'volumedate' => 'Volumedate',
            'volumedesc' => 'Volumedesc',
            'collectiontitle' => 'Collectiontitle',
            'collectionissn' => 'Collectionissn',
            'collectionvolume' => 'Collectionvolume',
            'editionstatement' => 'Editionstatement',
            'editionresponsibility' => 'Editionresponsibility',
            'timestamp' => 'Timestamp',
            'illus' => 'Illus',
            'pages' => 'Pages',
            'notes' => 'Notes',
            'size' => 'Size',
            'place' => 'Place',
            'lccn' => 'Lccn',
            'url' => 'Url',
            'cn_source' => 'Cn Source',
            'cn_class' => 'Cn Class',
            'cn_item' => 'Cn Item',
            'cn_suffix' => 'Cn Suffix',
            'cn_sort' => 'Cn Sort',
            'agerestriction' => 'Agerestriction',
            'totalissues' => 'Totalissues',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiblionumber0()
    {
        return $this->hasOne(\app\models\Biblio::className(), ['biblionumber' => 'biblionumber']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(\app\models\Items::className(), ['biblioitemnumber' => 'biblioitemnumber']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'uuid' => [
                'class' => UUIDBehavior::className(),
                'column' => 'id',
            ],
        ];
    }

    /**
     * The following code shows how to apply a default condition for all queries:
     *
     * ```php
     * class Customer extends ActiveRecord
     * {
     *     public static function find()
     *     {
     *         return parent::find()->where(['deleted' => false]);
     *     }
     * }
     *
     * // Use andWhere()/orWhere() to apply the default condition
     * // SELECT FROM customer WHERE `deleted`=:deleted AND age>30
     * $customers = Customer::find()->andWhere('age>30')->all();
     *
     * // Use where() to ignore the default condition
     * // SELECT FROM customer WHERE age>30
     * $customers = Customer::find()->where('age>30')->all();
     * ```
     */

    /**
     * @inheritdoc
     * @return \app\models\BiblioItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \app\models\BiblioItemsQuery(get_called_class());
        return $query->where(['biblioitems.deleted_by' => 0]);
    }
}
