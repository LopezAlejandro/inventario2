<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="items-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!-- <?= Html::a('Create Items', ['create'], ['class' => 'btn btn-success']) ?> -->
        <?= Html::a('Advance Search', '#', ['class' => 'btn btn-info search-button']) ?>
    </p>
    <div class="search-form" style="display:none">
        <?=  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <?php 
    $gridColumn = [
//        ['class' => 'yii\grid\SerialColumn'],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
        ],
        [
            'attribute' => 'new_status',
            'label' => 'Nro de Obra',
            'value' => 'new_status',
            /* 'filterType' => GridView::FILTER_SELECT2,
            'filter' => \yii\helpers\ArrayHelper::map(\app\models\Biblio::find()->asArray()->all(), 'biblionumber', 'new_status'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Nro de Obra', 'id' => 'grid-items-search-bibliostatus']
             */
        ],
        //'itemnumber',
        [
                'attribute' => 'biblionumber',
                'label' => 'Título',
                'value' => function($model){                   
                    return $model->biblionumber0->title;                   
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\Biblio::find()->asArray()->all(), 'biblionumber', 'title'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Título', 'id' => 'grid-items-search-biblionumber']
            ],
            [
                'attribute' => 'number',
                'label'=> 'Ejemplar',
                'value' => function($model){                   
                    return $model->biblioitemnumber0->number; 
                }

            ],
            [
                'attribute' => 'volume',
                'label'=> 'Volumen',
                'value' => function($model){                   
                    return $model->biblioitemnumber0->volume; 
                }

            ],
            [
                'attribute' => 'itemcallnumber',
                'label'=> 'Ubicación',
                'value' => 'itemcallnumber', 
            ],
        /* [
                'attribute' => 'biblioitemnumber',
                'label' => 'Biblioitemnumber',
                'value' => function($model){                   
                    return $model->biblioitemnumber0->biblioitemnumber;                   
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\Biblioitems::find()->asArray()->all(), 'biblioitemnumber', 'biblioitemnumber'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Biblioitems', $generator->getBarcode('081231723897', $generator::TYPE_CODE_128);'id' => 'grid-items-search-biblioitemnumber']
        ], */
        /* [
                'attribute' => 'barcode',
                'label' => 'Codigo de Barras',
                'format' => 'raw',
                'value' => function($model){
                    return Barcode::widget([
                    'value'  => $model.'barcode',
                    'format' => Barcode::CODE128A
                    ]);
                },
        ], */
        'barcode',
        /* 'dateaccessioned',
        'booksellerid:ntext',
        'homebranch',
        'price',
        'replacementprice',
        'replacementpricedate',
        'datelastborrowed',
        'datelastseen',
        'stack',
        'notforloan', */
        [
            'class' => 'kartik\grid\EnumColumn',
            'attribute' => 'damaged',
            'label' => 'Estado',
            'format' => 'html',
            'enum' => [
                '0' => '<span class="text-success">Excelente</span>',
                '1' => '<span class="text-success">Bueno</span>',
                '2' => '<span class="text-warning">Aceptable</span>',
                '3' => '<span class="text-warning">Regular</span>',
                '4' => '<span class="text-danger">Malo</span>',
                '5' => '<span class="text-danger">Pésimo</span>',
            ],
            'filter' => [  // will override the grid column filter (i.e. `loadEnumAsFilter` will be parsed as `false`)
                '0' => 'Excelente',
                '1' => 'Bueno',
                '2' => 'Aceptable',
                '3' => 'Regular',
                '4' => 'Malo',
                '5' => 'Pésimo',

            ],
        ],
        /*'damaged',
        'damaged_on',
        'itemlost',
        'itemlost_on',
        'withdrawn',
        'withdrawn_on',
        'itemcallnumber',
        'coded_location_qualifier',
        'issues',
        'renewals',
        'reserves',
        'restricted',
        'itemnotes:ntext',
        'itemnotes_nonpublic:ntext',
        'holdingbranch',
        'timestamp',
        'deleted_on',
        'location',
        'permanent_location',
        'onloan',
        'cn_source',
        'cn_sort',
        'ccode',
        'materials:ntext',
        'uri:ntext',
        'itype',
        'more_subfields_xml:ntext',
        'enumchron:ntext',
        'copynumber',
        'stocknumber',
        'new_status',
        'exclude_from_local_holds_priority', */
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update}',
        ],
    ]; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-items']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        // your toolbar can include the additional full export menu
        'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Full',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Export All Data</li>',
                    ],
                ],
            ]) ,
        ],
    ]); ?>

</div>
