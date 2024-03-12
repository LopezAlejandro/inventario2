<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "items".
 *
 * @property integer $itemnumber
 * @property integer $biblionumber
 * @property integer $biblioitemnumber
 * @property string $barcode
 * @property string $dateaccessioned
 * @property string $booksellerid
 * @property string $homebranch
 * @property string $price
 * @property string $replacementprice
 * @property string $replacementpricedate
 * @property string $datelastborrowed
 * @property string $datelastseen
 * @property integer $stack
 * @property integer $notforloan
 * @property integer $damaged
 * @property string $damaged_on
 * @property integer $itemlost
 * @property string $itemlost_on
 * @property integer $withdrawn
 * @property string $withdrawn_on
 * @property string $itemcallnumber
 * @property string $coded_location_qualifier
 * @property integer $issues
 * @property integer $renewals
 * @property integer $reserves
 * @property integer $restricted
 * @property string $itemnotes
 * @property string $itemnotes_nonpublic
 * @property string $holdingbranch
 * @property string $timestamp
 * @property string $deleted_on
 * @property string $location
 * @property string $permanent_location
 * @property string $onloan
 * @property string $cn_source
 * @property string $cn_sort
 * @property string $ccode
 * @property string $materials
 * @property string $uri
 * @property string $itype
 * @property string $more_subfields_xml
 * @property string $enumchron
 * @property string $copynumber
 * @property string $stocknumber
 * @property string $new_status
 * @property integer $exclude_from_local_holds_priority
 *
 * @property \app\models\Biblioitems $biblioitemnumber0
 * @property \app\models\Biblio $biblionumber0
 */
class Items extends \yii\db\ActiveRecord
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
            'biblioitemnumber0',
            'biblionumber0'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['biblionumber', 'biblioitemnumber', 'issues', 'renewals', 'reserves'], 'integer'],
            [['dateaccessioned', 'replacementpricedate', 'datelastborrowed', 'datelastseen', 'damaged_on', 'itemlost_on', 'withdrawn_on', 'timestamp', 'deleted_on', 'onloan'], 'safe'],
            [['booksellerid', 'itemnotes', 'itemnotes_nonpublic', 'materials', 'uri', 'more_subfields_xml', 'enumchron'], 'string'],
            [['price', 'replacementprice'], 'number'],
            [['barcode'], 'string', 'max' => 20],
            [['homebranch', 'coded_location_qualifier', 'holdingbranch', 'cn_source', 'itype'], 'string', 'max' => 10],
            [['stack', 'notforloan', 'damaged', 'itemlost', 'withdrawn', 'restricted', 'exclude_from_local_holds_priority'], 'string', 'max' => 1],
            [['itemcallnumber', 'cn_sort'], 'string', 'max' => 255],
            [['location', 'permanent_location', 'ccode'], 'string', 'max' => 80],
            [['copynumber', 'stocknumber', 'new_status'], 'string', 'max' => 32],
            [['barcode'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'itemnumber' => 'Itemnumber',
            'biblionumber' => 'Biblionumber',
            'biblioitemnumber' => 'Biblioitemnumber',
            'barcode' => 'Barcode',
            'dateaccessioned' => 'Dateaccessioned',
            'booksellerid' => 'Booksellerid',
            'homebranch' => 'Homebranch',
            'price' => 'Price',
            'replacementprice' => 'Replacementprice',
            'replacementpricedate' => 'Replacementpricedate',
            'datelastborrowed' => 'Datelastborrowed',
            'datelastseen' => 'Datelastseen',
            'stack' => 'Stack',
            'notforloan' => 'Notforloan',
            'damaged' => 'Damaged',
            'damaged_on' => 'Damaged On',
            'itemlost' => 'Itemlost',
            'itemlost_on' => 'Itemlost On',
            'withdrawn' => 'Withdrawn',
            'withdrawn_on' => 'Withdrawn On',
            'itemcallnumber' => 'Itemcallnumber',
            'coded_location_qualifier' => 'Coded Location Qualifier',
            'issues' => 'Issues',
            'renewals' => 'Renewals',
            'reserves' => 'Reserves',
            'restricted' => 'Restricted',
            'itemnotes' => 'Itemnotes',
            'itemnotes_nonpublic' => 'Itemnotes Nonpublic',
            'holdingbranch' => 'Holdingbranch',
            'timestamp' => 'Timestamp',
            'deleted_on' => 'Deleted On',
            'location' => 'Location',
            'permanent_location' => 'Permanent Location',
            'onloan' => 'Onloan',
            'cn_source' => 'Cn Source',
            'cn_sort' => 'Cn Sort',
            'ccode' => 'Ccode',
            'materials' => 'Materials',
            'uri' => 'Uri',
            'itype' => 'Itype',
            'more_subfields_xml' => 'More Subfields Xml',
            'enumchron' => 'Enumchron',
            'copynumber' => 'Copynumber',
            'stocknumber' => 'Stocknumber',
            'new_status' => 'New Status',
            'exclude_from_local_holds_priority' => 'Exclude From Local Holds Priority',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiblioitemnumber0()
    {
        return $this->hasOne(\app\models\Biblioitems::className(), ['biblioitemnumber' => 'biblioitemnumber']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiblionumber0()
    {
        return $this->hasOne(\app\models\Biblio::className(), ['biblionumber' => 'biblionumber']);
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
     * @return \app\models\ItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \app\models\ItemsQuery(get_called_class());
        return $query->where(['items.deleted_by' => 0]);
    }
}
