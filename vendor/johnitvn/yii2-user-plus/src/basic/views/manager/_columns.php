<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\jui\DatePicker;

$columns = [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id',
        'width' => '40px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'username',
        'label'=>'Usuario',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'login',
        'label'=>'Correo',
    ],    
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'created_at',
        'label'=>'Fecha creación',
        'value' => function($model) {
            return date('d/m/Y', $model->created_at);
        },
        'filter' => DatePicker::widget([
            'model' => $searchModel,
            'attribute' => 'created_at',
            'dateFormat' => 'php:Y-m-d',
            'options' => [
                'class' => 'form-control',
            ],
        ]),
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'width' => '50px',
        'attribute' => 'confirmed_at',
        'label'=>'Confirmación',
        'value' => function ($model) {
            if ($model->confirmed_at === null) {
                return Html::a(Yii::t('user', 'Confirm'), ['hand-confirm', 'id' => $model->id], [
                            'class' => 'btn btn-xs btn-primary btn-block',
                            'role' => 'modal-remote',
                            'data-confirm' => false, 'data-method' => false, // for overide yii data api
                            'data-request-method' => 'post',
                            'data-confirm-title' => Yii::t('user', 'Are you sure?'),
                            'data-confirm-message' => Yii::t('user', 'Are you sure you want to confirm for this user?'),
                ]);
            } else {
                return '<span class="btn btn-block btn-success btn-xs">Confirmado</span>';
            }
        },
        'format' => 'raw'
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'width' => '50px',
        'attribute' => 'blocked_at',
        'label'=>'Estado',
        'value' => function ($model) {
            if ($model->blocked_at !== null) {
                return Html::a(Yii::t('user', 'Unblock'), ['toggle-block', 'id' => $model->id], [
                            'class' => 'btn btn-xs btn-warning btn-block',
                            'role' => 'modal-remote',
                            'data-confirm' => false, 'data-method' => false, // for overide yii data api
                            'data-request-method' => 'post',
                            'data-confirm-title' => Yii::t('user', 'Are you sure?'),
                            'data-confirm-message' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                ]);
            } else {
                return Html::a(Yii::t('user', 'Block'), ['toggle-block', 'id' => $model->id], [
                            'class' => 'btn btn-xs btn-danger btn-block',
                            'role' => 'modal-remote',
                            'data-confirm' => false, 'data-method' => false, // for overide yii data api
                            'data-request-method' => 'post',
                            'data-confirm-title' => Yii::t('user', 'Are you sure?'),
                            'data-confirm-message' => Yii::t('user', 'Are you sure you want to block this user?'),
                ]);
            }
        },
        'format' => 'raw'
    ],
];
  
        
$rbacModule = Yii::$app->getModule('rbac');
        
$columns[] =   [
    'class' => '\kartik\grid\DataColumn',
    'width' => '130px',
    'attribute' => 'administrator',
    'label'=>'Administrador',
    'value' => function ($model) {
        if (!$model->administrator) {
            return Html::a(Yii::t('user', 'Set SU'), ['toggle-superuser', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-danger btn-block',
                        'role' => 'modal-remote',
                        'data-confirm' => false, 'data-method' => false, // for overide yii data api
                        'data-request-method' => 'post',
                        'data-confirm-title' => Yii::t('user', 'Are you sure?'),
                        'data-confirm-message' => 'Está seguro de otorgar el super usuario?',
            ]);
        } else {
            return Html::a(Yii::t('user', 'Remove SU'), ['toggle-superuser', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-info btn-block',
                        'role' => 'modal-remote',
                        'data-confirm' => false, 'data-method' => false, // for overide yii data api
                        'data-request-method' => 'post',
                        'data-confirm-title' => Yii::t('user', 'Are you sure?'),
                        'data-confirm-message' => Yii::t('user', 'Está seguro de quitar e privilegio de super usuario?'),
            ]);
        }
    },
    'format' => 'raw',
    'filter' => [0 => 'Administrador', 1 => 'No administrador'],
];
    
if (get_class($rbacModule) === 'johnitvn\rbacplus\Module') {
    /**
     * Intergrate with Rbac Plus extension
     */
    $columns[] = [
            'class' => 'kartik\grid\DataColumn',
            'header' => Yii::t('rbac', 'Assignment'),   
            'hAlign' => 'center',
            'value'=>function($model){
                return Html::a('<span class="glyphicon glyphicon-king"></span>',
                                ['/rbac/assignment/assignment', 'id' => $model->id], 
                                [
                                    'role' => 'modal-remote',
                                    'title' => Yii::t('user', 'Assignment'),
                                ]
                        );
            },
            'format' => 'raw',    
            'visible' => Yii::$app->user->identity->isAdministrator(),        
        ];
    
}
        
$columns[] =   [
    'class' => 'kartik\grid\ActionColumn',
    'dropdown' => false,
    'vAlign' => 'middle',
    'urlCreator' => function($action, $model, $key, $index) {
        return Url::to([$action, 'id' => $key]);
    },
        'viewOptions' => ['role' => 'modal-remote', 'title' => 'Ver', 'data-toggle' => 'tooltip'],
        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Editar', 'data-toggle' => 'tooltip'],
        'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Eliminar',
        'data-confirm' => false, 'data-method' => false, // for overide yii data api
        'data-request-method' => 'post',
        'data-toggle' => 'tooltip',
        'data-confirm-title' => Yii::t('user', 'Are you sure?'),
        'data-confirm-message' => Yii::t('user', 'Are you sure want to delete this item?')],
];

    return $columns;