<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
//use yii\helpers\ArrayHelper;
use backend\models\Company;
use backend\models\PilotGettoknowCorner;
use backend\models\PilotGettoknowCornerSearch;
use backend\models\PilotGettoknowCategory;
use yii\data\ActiveDataProvider;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotLeadershipCornerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pilot GetToKnow Corners';
$this->params['breadcrumbs'][] = ['label' => 'pilot-gettoknow-category', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$searchModel = new PilotGettoknowCornerSearch();
//$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider = new ActiveDataProvider([
    'query' => PilotGettoknowCorner::find()->where(['category_id' => Yii::$app->request->get('cid')]),
        ]);
$category = PilotGettoknowCategory::find()->where(['id' => Yii::$app->request->get('cid')])->one();
if (!$category) {

    return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-gettoknow-category/index");
}
$model = new PilotGettoknowCorner();
?>


<div class="grid_leadership_corners grid_verical">
    <?php if (Yii::$app->session->getFlash('custom_message')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('custom_message'); ?>
        </div>
    <?php } ?>
    <div class="box box-warning">
        <div class="box-header">

            <h3 class="box-title">Get to Know the Team Corner</h3>
            <?= Html::a('Add New Corner<i class="fa fa-plus"></i>', ['create', 'cid' => Yii::$app->request->get('cid')], ['class' => 'btn btn-default pull-right add-corner', 'disabled' => true]) ?>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="150"><a data-sort="week" href="/backend/web/pilot-gettoknow-corner/index?cid=3&amp;sort=week">Week</a></th>
                    <th width="400">First Option Description</th>
                    <th width="400">Second Option Description</th>
                    <th width="400">Third Option Description</th>
                    <th>Updated by</th><th class="action-column">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'itemOptions' => ['class' => ''],
                    'layout' => '{items}<br/><div id="pagination-wrapper">{pager}</div>',
                    'pager' => ['options' => [
                            'class' => 'pagination',
                        ]
                    ],
                    'emptyText' => ' <div class="no-data"> no data found </div>',
                    'itemView' => function ($model, $key, $index, $widget) use ($count) {
                        if (!empty($model->first_user_profile)):
                            $img_src1 = Yii::getAlias('@back_end') . '/img/knowtheteam/' . $model->first_user_profile;
                        else:
                            $img_src1 = 'http://root.injoymore.com/backend/web/img/knowtheteam/user_icon.png';
                        endif;
                        if (!empty($model->first_user_profile)):
                            $img_src2 = Yii::getAlias('@back_end') . '/img/knowtheteam/' . $model->second_user_profile;
                        else:
                            $img_src2 = 'http://root.injoymore.com/backend/web/img/knowtheteam/user_icon.png';
                        endif;
                        if (!empty($model->first_user_profile)):
                            $img_src3 = Yii::getAlias('@back_end') . '/img/knowtheteam/' . $model->third_user_profile;
                        else:
                            $img_src3 = 'http://root.injoymore.com/backend/web/img/knowtheteam/user_icon.png';
                        endif;
//                        $img_src1 = Yii::$app->homeUrl . 'img/knowtheteam/' . $model->first_user_profile;
//                        $img_src2 = Yii::$app->homeUrl . 'img/knowtheteam/' . $model->second_user_profile;
//                        $img_src3 = Yii::$app->homeUrl . 'img/knowtheteam/' . $model->third_user_profile;
                        ?>
                        <tr><td></td><td colspan="5"><?= $model->question; ?></td></tr>
                        <tr><td><?= $model->week; ?></td>
                            <td>
                                <div class="row"><div style="text-align:center" class="col-md-12"><b><?= $model->first_user; ?></b>
                                        <?php if ($model->first_user_answer == 1): ?>
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        <?php endif; ?>
                                    </div><div style="text-align:center" class="col-md-4"><img src="<?= $img_src1; ?>" style="width:100px;text-align:left;"></div>
                                    <div style="word-wrap: break-word;" class="col-md-8"><p><?= $model->first_user_description; ?></p>
                                    </div></div>
                            </td>
                            <td>
                                <div class="row"><div style="text-align:center" class="col-md-12"><b><?= $model->second_user; ?></b>
                                        <?php if ($model->second_user_answer == 1): ?>
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        <?php endif; ?>
                                    </div><div style="text-align:center" class="col-md-4"><img src="<?= $img_src2; ?>" style="width:100px;text-align:left;"></div>
                                    <div style="word-wrap: break-word;" class="col-md-8"><p><?= $model->second_user_description; ?></p>
                                    </div></div>
                            </td>
                            <td>
                                <div class="row"><div style="text-align:center" class="col-md-12"><b><?= $model->third_user; ?></b>
                                        <?php if ($model->third_user_answer == 1): ?>
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        <?php endif; ?>
                                    </div><div style="text-align:center" class="col-md-4"><img src="<?= $img_src3; ?>" style="width:100px;text-align:left;"></div>
                                    <div style="word-wrap: break-word;" class="col-md-8"><p><?= $model->third_user_description; ?></p>
                                    </div></div>
                            </td>
                            <td><?= backend\models\PilotGettoknowCorner::getUpdated($model->id, $model->user_id); ?></td>
                            <td>  <a href="update?id=<?= $model->id; ?>&cid=<?= Yii::$app->request->get('cid');?>" class=" grid btn btn-default edit_know_corner"><i class="fa fa-pencil-square-o"></i> Edit</a>
                                <a href="delete?id=<?= $model->id; ?>" class=" grid btn btn-default" data-confirm="Are you sure you want to delete this item?" data-method="post"><i class="fa fa-trash-o"></i>&nbsp;Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                ]);
                ?> 
        </table>
        <? /* =
          GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'columns' => [
          //                ['class' => 'yii\grid\SerialColumn',
          //                    'header' => 'S No.',
          //                ],
          //  'id',


          [
          'label' => 'Week',
          'attribute' => 'week',
          //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
          'headerOptions' => ['width' => '150'],
          'format' => 'html',
          'value' => function ($model) {
          return $model->week;
          },
          ],
          [
          'label' => 'First Option Description',
          // 'attribute' => 'title',
          //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
          'headerOptions' => ['width' => '400'],
          'format' => 'raw',
          'value' => function ($model) {
          $img_src = Yii::$app->homeUrl . 'img/knowtheteam/' . $model->first_user_profile;
          return '<div class="row"><div class="col-md-12" style="text-align:center"><b>' . $model->first_user . '</b></div><div class="col-md-4" style="text-align:center"><img style="width:100px;text-align:left;" src=" ' . $img_src . ' "></div>
          <div class="col-md-8" style="word-wrap: break-word;">' . $model->first_user_description . '</div></div>';
          },
          ],
          [
          'label' => 'Second Option Description',
          // 'attribute' => 'title',
          //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
          'headerOptions' => ['width' => '400'],
          'format' => 'raw',
          'value' => function ($model) {
          $img_src = Yii::$app->homeUrl . 'img/knowtheteam/' . $model->second_user_profile;
          return '<div class="row"><div class="col-md-12" style="text-align:center"><b>' . $model->second_user . '</b></div><div class="col-md-4" style="text-align:center"><img style="width:100px;text-align:left;" src=" ' . $img_src . ' "></div>
          <div class="col-md-8" style="word-wrap: break-word;">' . $model->second_user_description . '</div></div>';
          },
          ],
          [
          'label' => 'Third Option Description',
          // 'attribute' => 'title',
          //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
          'headerOptions' => ['width' => '400'],
          'format' => 'raw',
          'value' => function ($model) {
          $img_src = Yii::$app->homeUrl . 'img/knowtheteam/' . $model->third_user_profile;
          return '<div class="row"><div class="col-md-12" style="text-align:center"><b>' . $model->third_user . '</b></div><div class="col-md-4" style="text-align:center"><img style="width:100px;text-align:left;" src=" ' . $img_src . ' "></div>
          <div class="col-md-8" style="word-wrap: break-word;">' . $model->third_user_description . '</div></div>';
          },
          ],
          //                [
          //                    'label' => 'Dashboard Image',
          //                    //'attribute' => 'dashboard_image',
          //                    //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
          //                    //'headerOptions' => ['width' => '300'],
          //                    'format' => 'html',
          //                    'value' => function ($model) {
          //                        if ($model->dashboard_image) {
          //                            return '<img style="width:150px"src=' . Yii::$app->homeUrl . 'img/leadership-corner-images/' . $model->dashboard_image . '>';
          //                        } else {
          //                            return 'No Image Uploaded';
          //                        }
          //                    },
          //                ],
          //                [
          //                    'label' => 'Lightbox Image',
          //                    //'attribute' => 'popup_image',
          //                    //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
          //                    //'headerOptions' => ['width' => '300'],
          //                    'format' => 'html',
          //                    'value' => function ($model) {
          //                        if ($model->popup_image) {
          //                            return '<img style="width:150px"src=' . Yii::$app->homeUrl . 'img/leadership-corner-images/' . $model->popup_image . '>';
          //                        } else {
          //                            return 'No Image Uploaded';
          //                        }
          //                    },
          //                ],
          // 'discription',
          // 'created',
          //'updated',
          // 'position',
          [
          'label' => 'Updated by',
          //'attribute' => 'updated',
          //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
          //'headerOptions' => ['width' => '300'],
          'format' => 'html',
          'value' => function ($model) {

          return backend\models\PilotGettoknowCorner::getUpdated($model->id, $model->user_id);
          },
          ],
          // 'user_id',
          //  ['class' => 'yii\grid\ActionColumn'],
          ['class' => 'yii\grid\ActionColumn',
          'header' => 'Operation',
          'template' => '  {update}{delete}',
          'buttons' => [
          'update' => function ($url, $model) {
          return "<a class=' grid btn btn-default edit_know_corner' href='update?id=$model->id'><i class='fa fa-pencil-square-o'></i> Edit</a>";
          },
          'delete' => function ($url, $model) {
          return "<a data-method='post' data-confirm='Are you sure you want to delete this item?'class=' grid btn btn-default' href='delete?id=" . $model->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
          },
          ],
          ],
          ],
          ]); */
        ?>
    </div>
</div>


<!-- bootstrap model popup  start here-->
<div class="container">
    <div class="modal fade" id="add_gettoknow_corner" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Get To Know the Team Corner</h4>
                </div>
                <div class="modal-body">
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'gettoknow_corner_form',
                                'options' => ['enctype' => 'multipart/form-data']]);
                    ?> 
                    <?
                    //= $form->field($model, 'client_listing')->dropDownList(
                    // ArrayHelper::map(Company::find()->all(), 'id', 'company_name'), ['prompt' => 'Select Client']
                    // );
                    ?>
                    <?php
                    if ((!empty($model->popup_image))) {
                        $imgcheck = 1;
                        $class = 'existimage';
                    } else {
                        $imgcheck = 0;
                        $class = '';
                    }
                    ?> 
                    <?=
                    $form->field($model, 'week')->dropDownList([
                        'Week 1-one' => 'Week 1-one',
                        'Week 1-two' => 'Week 1-two',
                        'Week 1-three' => 'Week 1-three',
                        'Week 2-one' => 'Week 2-one',
                        'Week 2-two' => 'Week 2-two',
                        'Week 2-three' => 'Week 2-three',
                        'Week 3-one' => 'Week 3-one',
                        'Week 3-two' => 'Week 3-two',
                        'Week 3-three' => 'Week 3-three',
                        'Week 4-one' => 'Week 4-one',
                        'Week 4-two' => 'Week 4-two',
                        'Week 4-three' => 'Week 4-three',
                        'Week 5-one' => 'Week 5-one',
                        'Week 5-two' => 'Week 5-two',
                        'Week 5-three' => 'Week 5-three',
                        'Week 6-one' => 'Week 6-one',
                        'Week 6-two' => 'Week 6-two',
                        'Week 6-three' => 'Week 6-three',
                        'Week 7-one' => 'Week 7-one',
                        'Week 7-two' => 'Week 7-two',
                        'Week 7-three' => 'Week 7-three',
                            ], ['prompt' => 'Select Week']
                    )->label('Week' . Html::tag('span', '*', ['class' => 'required']));
                    ?>

                    <p id="week_error_create" style="color:#dd4b39;"></p>
                    <?= $form->field($model, 'question')->textInput(['maxlength' => true])->label('Question' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <?= $form->field($model, 'first_user')->textInput(['maxlength' => true])->label('First Option Name' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <?=
                    $form->field($model, 'first_user_description')->widget(CKEditor::className(), [
                        'options' => ['rows' => 3],
                        'preset' => 'basic'
                    ])->label('First Option Description' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <?= $form->field($model, 'first_user_profile')->fileInput(['accept' => 'image/*', 'id' => 'browsefirstuser', 'class' => $class, 'maxlength' => true])->label('First Option Image' . Html::tag('span', '*', ['class' => 'required'])) ?>
                    <div class="form-group browsefirstuser">                        
                        <img class="removeimagebrowsefirstuser" style="margin-right:20px;height:100px;width:100px;"src="<?php echo Yii::$app->homeUrl ?>/img/knowtheteam/"><a class="btn btn-default" id="removefirst">Remove</a>
                    </div>
                    <?= $form->field($model, 'first_user_answer')->radioList(array(1 => 'Correct', 0 => 'Incorrect'))->label('Answer' . Html::tag('span', '*', ['class' => 'required'])); ?>

                    <!-- Second Option Details -->

                    <?= $form->field($model, 'second_user')->textInput(['maxlength' => true])->label('Second Option Name' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <?=
                    $form->field($model, 'second_user_description')->widget(CKEditor::className(), [
                        'options' => ['rows' => 3],
                        'preset' => 'basic'
                    ])->label('Second Option Description' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <?= $form->field($model, 'second_user_profile')->fileInput(['accept' => 'image/*', 'id' => 'browseseconduser', 'class' => $class, 'maxlength' => true])->label('Second Option Image' . Html::tag('span', '*', ['class' => 'required'])) ?>
                    <div class="form-group browseseconduser">                        
                        <img class="removeimagebrowseseconduser" style="margin-right:20px;height:100px;width:100px;"src="<?php echo Yii::$app->homeUrl ?>/img/knowtheteam/"><a class="btn btn-default" id="removesecond">Remove</a>
                    </div>
                    <?= $form->field($model, 'second_user_answer')->radioList(array(1 => 'Correct', 0 => 'Incorrect'))->label('Answer' . Html::tag('span', '*', ['class' => 'required'])); ?>

                    <!-- Third Option Details -->

                    <?= $form->field($model, 'third_user')->textInput(['maxlength' => true])->label('Third Option Name' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <?=
                    $form->field($model, 'third_user_description')->widget(CKEditor::className(), [
                        'options' => ['rows' => 3],
                        'preset' => 'basic'
                    ])->label('Third Option Description' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <?= $form->field($model, 'third_user_profile')->fileInput(['accept' => 'image/*', 'id' => 'browsethirduser', 'class' => $class, 'maxlength' => true])->label('Third Option Image' . Html::tag('span', '*', ['class' => 'required'])) ?>
                    <div class="form-group browsethirduser">                        
                        <img class="removeimagebrowsethirduser" style="margin-right:20px;height:100px;width:100px;"src="<?php echo Yii::$app->homeUrl ?>/img/knowtheteam/"><a class="btn btn-default" id="removethird">Remove</a>
                    </div>
                    <?= $form->field($model, 'third_user_answer')->radioList(array(1 => 'Correct', 0 => 'Incorrect'))->label('Answer' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <?=
                    $form->field($model, 'category_id'
                    )->hiddenInput(['value' => Yii::$app->request->get('cid'), 'readonly' => true])->label('');
                    ?>

                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'id' => 'submit-disable']) ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<style>
    i.fa.fa-check {
        color: green;
        border-radius: 20px;
        border: 1px solid green;
        padding: 11px 4px;
        margin-left: 5px;
    }
</style>



<!-- edit*****************************************************************EDIT model popup  start here**************************************************************************-->
