<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "biblio".
 *
 * @property integer $biblionumber
 * @property string $frameworkcode
 * @property string $author
 * @property string $title
 * @property string $medium
 * @property string $subtitle
 * @property string $part_number
 * @property string $part_name
 * @property string $unititle
 * @property string $notes
 * @property integer $serial
 * @property string $seriestitle
 * @property integer $copyrightdate
 * @property string $timestamp
 * @property string $datecreated
 * @property string $abstract
 *
 * @property \app\models\BiblioMetadata[] $biblioMetadatas
 * @property \app\models\Biblioitems[] $biblioitems
 * @property \app\models\Items[] $items
 */
class Biblio extends \yii\db\ActiveRecord
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
            'biblioMetadatas',
            'biblioitems',
            'items'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author', 'title', 'medium', 'subtitle', 'part_number', 'part_name', 'unititle', 'notes', 'seriestitle', 'abstract'], 'string'],
            [['copyrightdate'], 'integer'],
            [['timestamp', 'datecreated'], 'safe'],
            [['datecreated'], 'required'],
            [['frameworkcode'], 'string', 'max' => 4],
            [['serial'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'biblio';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'biblionumber' => 'Biblionumber',
            'frameworkcode' => 'Frameworkcode',
            'author' => 'Author',
            'title' => 'Title',
            'medium' => 'Medium',
            'subtitle' => 'Subtitle',
            'part_number' => 'Part Number',
            'part_name' => 'Part Name',
            'unititle' => 'Unititle',
            'notes' => 'Notes',
            'serial' => 'Serial',
            'seriestitle' => 'Seriestitle',
            'copyrightdate' => 'Copyrightdate',
            'timestamp' => 'Timestamp',
            'datecreated' => 'Datecreated',
            'abstract' => 'Abstract',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiblioMetadatas()
    {
        return $this->hasMany(\app\models\BiblioMetadata::className(), ['biblionumber' => 'biblionumber']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiblioitems()
    {
        return $this->hasMany(\app\models\Biblioitems::className(), ['biblionumber' => 'biblionumber']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(\app\models\Items::className(), ['biblionumber' => 'biblionumber']);
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
     * @return \app\models\BiblioQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \app\models\BiblioQuery(get_called_class());
        return $query->where(['biblio.deleted_by' => 0]);
    }
}
