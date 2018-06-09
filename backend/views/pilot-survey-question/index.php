<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\PilotInhouseUser;
use backend\models\PilotCreateGame;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotSurveyQuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$highlight_tag1 = Yii::$app->request->get('PilotSurveyQuestionSearch');
if ($highlight_tag1 != '') {
    $highlight_tag = $highlight_tag1['tag_id'];
}
$this->title = 'Pilot Survey Questions';
$this->params['breadcrumbs'][] = $this->title;
$tags_name = [];
$this->registerJsFile(Yii::$app->homeUrl . 'js/jquery.mark.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
?>
<div class="pilot-survey-question-index">
    <?php if (Yii::$app->session->getFlash('created')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('created'); ?>
        </div>
    <?php } ?>
    <div class="grid_managegame grid_verical">

        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Survey Question Listing</h3>
                <?= Html::a('Add Survey Question<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-default pull-right']) ?>
            </div>
            <?php if (PilotInhouseUser::isUserAdmin(Yii::$app->user->identity->id)): ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'S No.',
                        ],
                        //'id',
                        'question',
                        //'created',
                        [
                            'label' => 'Tag Name',
                            'attribute' => 'tag_id',
                            'format' => 'html',
                            'contentOptions' => ['class' => 'tags-column'],
                            'headerOptions' => ['class' => 'tags-column'],
                            'value' => function ($model) {
                                if (!empty($model->tag_id)):
                                    $tags[] = explode(',', $model->tag_id);
                                    foreach ($tags as $value => $new) {
                                        foreach ($new as $tag_id) {
                                            $tags_name1 = backend\models\PilotTags::getRecords($tag_id);
                                            $tags_name[] = '<span class="tag label label-info">' . $tags_name1 . '</span>';
                                        }
                                    }
                                    $tags_string = implode(' ', $tags_name);
                                    return $tags_string;
                                else:
                                    return ' ';
                                endif;
                            },
                        ],
                        [
                            'label' => 'Question And Answer Type',
                            'attribute' => 'type',
                            'filter' => array('checkbox' => "Checkbox", 'textbox' => "Textbox"),
                            'format' => 'raw',
                            'value' => function ($model) {

                                return ucfirst($model->type);
                            },
                        ],
                        [
                            'label' => 'Created By',
                            //'attribute' => 'created',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return backend\models\PilotSurveyQuestion::getcreated($model->id);
                            },
                        ],
                        // ['class' => 'yii\grid\ActionColumn'],
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Operation',
                            'headerOptions' => ['width' => '245'],
                            'template' => '{edit} {delete} ',
                            'buttons' => [
                                'edit' => function ($url, $model) {
                                    return "<a class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-survey-question/update?id=" . $model->id . "'><i class='fa fa-pencil-square-o'></i> Edit</a>";
                                },
                                'delete' => function ($url, $model) {
                                    $survey_question = array();
                                    $game_obj = PilotCreateGame::find()->all();
                                    foreach ($game_obj as $game):
                                        $survey_questions[] = explode(',', $game->survey_questions);
                                        foreach ($survey_questions as $questions):
                                            foreach ($questions as $value):
                                                if (!(in_array($value, $survey_question))):
                                                    $survey_question[] = $value;
                                                endif;
                                            endforeach;
                                        endforeach;
                                    endforeach;
                                    if (!(in_array($model->id, $survey_question))):
                                        return "<a   data-confirm='Are you sure you want to delete this item?' data-method='post' class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-survey-question/delete?id=" . $model->id . "' rel='" . $model->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                                    else:
                                        return "<a class=' grid btn btn-default' disabled='disabled'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                                    endif;
                                },
                            ],
                        ],
                    ],
                ]);
                ?>
            <?php else: ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'S No.',
                        ],
                        //'id',
                        'question',
                        //'created',
                        [
                            'label' => 'Tag Name',
                            'attribute' => 'tag_id',
                            'format' => 'html',
                            'contentOptions' => ['class' => 'tags-column'],
                            'headerOptions' => ['class' => 'tags-column'],
                            'value' => function ($model) {
                                if (!empty($model->tag_id)):
                                    $tags[] = explode(',', $model->tag_id);
                                    foreach ($tags as $value => $new) {
                                        foreach ($new as $tag_id) {
                                            $tags_name1 = backend\models\PilotTags::getRecords($tag_id);
                                            $tags_name[] = '<span class="tag label label-info">' . $tags_name1 . '</span>';
                                        }
                                    }
                                    $tags_string = implode(' ', $tags_name);
                                    return $tags_string;
                                else:
                                    return ' ';
                                endif;
                            },
                        ],
                        [
                            'label' => 'Question And Answer Type',
                            'attribute' => 'type',
                            'filter' => array('checkbox' => "Checkbox", 'textbox' => "Textbox"),
                            'format' => 'raw',
                            'value' => function ($model) {

                                return ucfirst($model->type);
                            },
                        ],
                        [
                            'label' => 'Created By',
                            //'attribute' => 'created',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return backend\models\PilotSurveyQuestion::getcreated($model->id);
                            },
                        ],
                        // ['class' => 'yii\grid\ActionColumn'],
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Operation',
                            'headerOptions' => ['width' => '245'],
                            'template' => '{edit}',
                            'buttons' => [
                                'edit' => function ($url, $model) {
                                    return "<a class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-survey-question/update?id=" . $model->id . "'><i class='fa fa-pencil-square-o'></i> Edit</a>";
                                },
                            ],
                        ],
                    ],
                ]);
                ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<input type="hidden" name="highlight_tag" value="<?= $highlight_tag; ?>" id="highlight_tag">