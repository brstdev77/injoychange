<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Request;
use yii\widgets\ActiveForm;
use frontend\models\PilotFrontDailyinspiration;
use frontend\models\PilotFrontLeadershipcorner;
use frontend\models\PilotFrontWeeklychallenge;
use frontend\models\PilotFrontShareawin;
use frontend\models\PilotFrontHighfive;
use frontend\models\PilotFrontHighfiveSearch;
use frontend\models\PilotFrontCheckin;
use frontend\models\PilotFrontUser;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use backend\models\Company;
use frontend\models\PilotFrontNotifications;

/**
 * AboveController.
 */
class AboveController extends Controller {

  /**
   * @inheritdoc
   */
  public function behaviors() {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['logout', 'signup', 'index', 'view', 'create', 'update', 'delete', 'dashboard', 'daily-modal', 'leadership-modal', 'weekly-modal', 'share-a-win-mmodal', 'highfive-like', 'core-values-modal', 'check-in', 'tag-list', 'checkin', 'share-a-win', 'high-five', 'highfive-usercomment-modal', 'get-notifications', 'notification-status'],
        'rules' => [
          [
            'actions' => ['signup', 'index'],
            'allow' => true,
            'roles' => ['?'],
          ],
          [
            'actions' => ['index', 'view', 'create', 'update', 'delete', 'dashboard', 'daily-modal', 'leadership-modal', 'weekly-modal', 'share-a-win-mmodal', 'highfive-like', 'core-values-modal', 'check-in', 'tag-list', 'logout', 'checkin', 'share-a-win', 'high-five', 'highfive-usercomment-modal', 'get-notifications', 'notification-status'],
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'delete' => ['POST'],
        ],
      ],
    ];
  }

  /**
   * Lists all Above models.
   * @return mixed
   */
  public function actionIndex() {
    $this->layout = 'above';

    return $this->render('index');
  }

  //display dashboard page

  public function actionDashboard() {
    $this->layout = 'above';
    $user_id = Yii::$app->user->identity->id;
    $game = 1;
    $comp_id = 1;
    $week_no = 1;
    $dayset = date('Y-m-d');
    //Daily Inspiration
    $daily_entry = PilotFrontDailyinspiration::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $dayset])->one();
    //Core Values
    $corevalues_entry = PilotFrontCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'label' => 'core_values_popup', 'dayset' => $dayset])->one();
    $prev_today_values_currentday = PilotFrontCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $dayset])
            ->andWhere(['!=', 'label', 'core_values_popup'])->orderBy(['created' => SORT_DESC])->all();
    $tv_points = 20;
    $count_tv = 0;
    if (!empty($prev_today_values_currentday)):
      $count_tv = count($prev_today_values_currentday);
      if ($count_tv < 2):
        $tv_points = 20;
      else:
        $tv_points = 0;
      endif;
    endif;
    $today_valuesModel = new PilotFrontCheckin;
    if (Yii::$app->request->post('PilotFrontCheckin')):
      $label = Yii::$app->request->post('PilotFrontCheckin')['label'];
      $comment = Yii::$app->request->post('PilotFrontCheckin')['comment'];
      $serial = Yii::$app->request->post('PilotFrontCheckin')['serial'];
      $checkModel = PilotFrontCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'label' => $label, 'serial' => $serial, 'dayset' => $dayset])->one();
      if (empty($checkModel)):
        $model = new PilotFrontCheckin;
        $model->game_id = $game;
        $model->user_id = $user_id;
        $model->company_id = $comp_id;
        $model->label = $label;
        $model->comment = json_encode($comment);
        $model->serial = $serial;
        $model->points = $tv_points;
        $model->dayset = $dayset;
        $model->created = time();
        $model->updated = time();
        $model->save(false);
      endif;
      Yii::$app->session->setFlash('success', 'Saved Successfully.');
      return $this->redirect(['dashboard']);
      Yii::$app->end();
    endif;
    //High Five 
    $all_highfives = PilotFrontHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment'])->orderBy(['created' => SORT_DESC])->all();
    $prev_highfives_currentday = PilotFrontHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'dayset' => $dayset])->orderBy(['created' => SORT_ASC])->all();
    $hf_points = 10;
    $count_hf = 0;
    if (!empty($prev_highfives_currentday)):
      $count_hf = count($prev_highfives_currentday);
      if ($count_hf < 3):
        $hf_points = 10;
      else:
        $hf_points = 0;
      endif;
    endif;
    $highfiveModel = new PilotFrontHighfive;
    if (Yii::$app->request->post('PilotFrontHighfive')):
      $feature_label = Yii::$app->request->post('PilotFrontHighfive')['feature_label'];
      $feature_value = Yii::$app->request->post('PilotFrontHighfive')['feature_value'];
      $feature_serial = Yii::$app->request->post('PilotFrontHighfive')['feature_serial'];
      $linked_feature_id = Yii::$app->request->post('PilotFrontHighfive')['linked_feature_id'];
      $checkModel = PilotFrontHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => $feature_label, 'feature_serial' => $feature_serial, 'dayset' => $dayset])->one();
      if (empty($checkModel)):
        $model = new PilotFrontHighfive;
        $model->game_id = $game;
        $model->user_id = $user_id;
        $model->company_id = $comp_id;
        $model->feature_label = $feature_label;
        $model->feature_value = json_encode($feature_value);
        $model->feature_serial = $feature_serial;
        $model->linked_feature_id = $linked_feature_id;
        $model->points = $hf_points;
        $model->dayset = $dayset;
        $model->created = time();
        $model->updated = time();
        $model->save(false);
        $savedmodel_id = $model->id;
        //Save Notification for User in pilot_front_notifications Table
        $cmnt = $feature_value;
        preg_match_all("/data-uid=\"(.*?)\"/i", $cmnt, $matches);
        if (!empty($matches)):
          foreach ($matches[1] as $key => $tagged_uid):
            $cmnt_val = json_encode($feature_value);
            $comment_val = json_decode($cmnt_val);
            $max_length = 25;
            if (strlen($comment_val) > $max_length):
              $offset = ($max_length - 3) - strlen($comment_val);
              $comment_val = substr($comment_val, 0, strrpos($comment_val, ' ', $offset)) . '...';
            endif;
            $comment_val = str_replace("<br>", " ", $comment_val);

            $tagged_user = PilotFrontUser::findIdentity($tagged_uid);

            $hf_comment_user = PilotFrontUser::findIdentity($user_id);
            $hf_comment_userName = $hf_comment_user->username;

            $notif_value = '<b>' . $hf_comment_userName . '</b> has tagged you in a comment <a href="javascript:void(0)">"' . $comment_val . '"</a>';
            //Save Other Users Activity not Own
            if ($tagged_uid != $user_id):
              $notif_model = new PilotFrontNotifications;
              $notif_model->game_id = $game;
              $notif_model->user_id = $tagged_uid;
              $notif_model->company_id = $comp_id;
              $notif_model->notif_type_id = $savedmodel_id;
              $notif_model->notif_type = 'highfiveComment';
              $notif_model->notif_value = $notif_value;
              $notif_model->activity_user_id = $user_id;
              $notif_model->notif_status = 1;
              $notif_model->dayset = $dayset;
              $notif_model->created = time();
              $notif_model->updated = time();
              $notif_model->save(false);
            endif;
          endforeach;
        endif;

      endif;
      Yii::$app->session->setFlash('success', 'Saved Successfully.');
      return $this->redirect(['dashboard']);
      Yii::$app->end();
    endif;
    //Leadership Corner
    $leadership_entry_weekly = PilotFrontLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no])->all();
    $leadership_entry_currentday = PilotFrontLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'dayset' => $dayset])->one();
    $leadership_entry_first = PilotFrontLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'first'])->one();
    $leadership_entry_sec = PilotFrontLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'second'])->one();
    $leadership_entry_third = PilotFrontLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'third'])->one();
    //Weekly Challenge
    $weekly_entry = PilotFrontWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no])->one();
    //Share A Win 
    $shareawin_entry = PilotFrontShareawin::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'dayset' => $dayset])->all();
//    $shareawins_all = PilotFrontShareawin::find()->where(['game_id' => $game, 'company_id' => $comp_id])->joinWith('userinfo')->orderBy(['created' => SORT_DESC])->all();

    $shareawins_all = PilotFrontShareawin::find()
            ->where(['game_id' => $game, 'pilot_front_shareawin.company_id' => $comp_id])
            ->joinWith('userinfo')
            ->orderBy(['id' => SORT_DESC])->all();

    //Render Dashboard View
    return $this->render('dashboard', [
          'daily_entry' => $daily_entry,
          'corevalues_entry' => $corevalues_entry,
          'today_valuesModel' => $today_valuesModel,
          'prev_today_values_currentday' => $prev_today_values_currentday,
          'count_tv' => $count_tv,
          'all_highfives' => $all_highfives,
          'highfiveModel' => $highfiveModel,
          'prev_highfives_currentday' => $prev_highfives_currentday,
          'count_hf' => $count_hf,
          'leadership_entry_weekly' => $leadership_entry_weekly,
          'leadership_entry_currentday' => $leadership_entry_currentday,
          'leadership_entry_first' => $leadership_entry_first,
          'leadership_entry_sec' => $leadership_entry_sec,
          'leadership_entry_third' => $leadership_entry_third,
          'weekly_entry' => $weekly_entry,
          'shareawin_entry' => $shareawin_entry,
          'shareawins_all' => $shareawins_all,
    ]);
  }

  public function actionDailyInspiration() {
    $this->layout = 'above';
    return $this->render('daily');
  }

  public function actionCheckin() {
    $this->layout = 'above';
    $game = 1;
    $comp_id = 1;
    $shareawins_all = PilotFrontCheckin::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id])
            ->andWhere(['!=', 'label', 'core_values_popup'])->orderBy(['created' => SORT_DESC]);
    $dataProvider = new ActiveDataProvider([
      'query' => $shareawins_all,
      'pagination' => [
        'pageSize' => 3,
      ],
    ]);
    return $this->render('checkin', [
          'shareawins_all' => $dataProvider,
    ]);
  }

  public function actionHighFive() {
    $this->layout = 'above';
    $query = PilotFrontUser::find()->all();
    $compData = ArrayHelper::map($query, 'id', 'username');
    $searchModel = new PilotFrontHighfiveSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    return $this->render('highfive', [
          'model' => $searchModel,
          'shareawins_all' => $dataProvider,
          'compData' => $compData,
    ]);
  }

  public function actionToolbox() {
    $this->layout = 'above';
    return $this->render('toolbox');
  }

  public function actionShareAWin() {
    $this->layout = 'above';
    $game = 1;
    $comp_id = 1;
    $shareawins_all = PilotFrontShareawin::find()
        ->where(['game_id' => $game, 'pilot_front_shareawin.company_id' => $comp_id])
        ->joinWith('userinfo')
        ->orderBy(['id' => SORT_DESC]);
    $dataProvider = new ActiveDataProvider([
      'query' => $shareawins_all,
      'pagination' => [
        'pageSize' => 3,
      ],
    ]);
    return $this->render('sharewin', [
          'shareawins_all' => $dataProvider,
    ]);
  }

  public function actionHowItWork() {
    $this->layout = 'above';
    return $this->render('howitwork');
  }

  public function actionLeaderboard() {
    $this->layout = 'above';
    return $this->render('leaderboard');
  }

  /**
   * 
   * @return Daily Inspiration Modal
   */
  public function actionDailyModal() {
    $game = 1;
    $comp_id = 1;
    $points = 10;
    $dayset = date('Y-m-d');
    $daily_model = new PilotFrontDailyinspiration;
    $daily_entry = PilotFrontDailyinspiration::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'dayset' => $dayset])->one();
    if (Yii::$app->request->post()):
      $user_id = Yii::$app->request->post('PilotFrontDailyinspiration')['user_id'];
      $dayset = Yii::$app->request->post('PilotFrontDailyinspiration')['dayset'];
      $checkModel = PilotFrontDailyinspiration::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $dayset])->one();
      if (empty($checkModel)):
        $model = new PilotFrontDailyinspiration;
        $model->game_id = $game;
        $model->user_id = $user_id;
        $model->company_id = $comp_id;
        $model->points = $points;
        $model->dayset = $dayset;
        $model->created = time();
        $model->updated = time();
        $model->save();
      endif;
      Yii::$app->session->setFlash('success', 'Saved Successfully.');
      return $this->redirect(['dashboard']);
      Yii::$app->end();
    else:
      $html = $this->renderAjax('game_modals', [
        'daily_model' => $daily_model,
        'daily_entry' => $daily_entry,
      ]);
      return $html;
    endif;
  }

  /**
   * 
   * @return Core Values Modal
   */
  public function actionCoreValuesModal() {
    $game = 1;
    $comp_id = 1;
    $points = 5;
    $label = 'core_values_popup';
    $dayset = date('Y-m-d');
    $corevalues_model = new PilotFrontCheckin;
    $corevalues_entry = PilotFrontCheckin::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'label' => $label, 'dayset' => $dayset])->one();
    if (Yii::$app->request->post()):
      $user_id = Yii::$app->request->post('PilotFrontCheckin')['user_id'];
      $dayset = Yii::$app->request->post('PilotFrontCheckin')['dayset'];
      $checkModel = PilotFrontCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'label' => $label, 'dayset' => $dayset])->one();
      if (empty($checkModel)):
        $model = new PilotFrontCheckin;
        $model->game_id = $game;
        $model->user_id = $user_id;
        $model->company_id = $comp_id;
        $model->label = $label;
        $model->comment = 'Read';
        $model->serial = 1;
        $model->points = $points;
        $model->dayset = $dayset;
        $model->created = time();
        $model->updated = time();
        $model->save();
      endif;
      Yii::$app->session->setFlash('success', 'Saved Successfully.');
      return $this->redirect(['dashboard']);
      Yii::$app->end();
    else:
      $html = $this->renderAjax('game_modals', [
        'corevalues_model' => $corevalues_model,
        'corevalues_entry' => $corevalues_entry,
      ]);
      return $html;
    endif;
  }

  /**
   * 
   * @return Check In With Yourself Modal
   */
  public function actionCheckInModal() {
    $user_id = Yii::$app->user->identity->id;
    $game = 1;
    $comp_id = 1;
    $points = 5;
    $dayset = date('Y-m-d');
    $today_valuesModel = new PilotFrontCheckin;
//    $corevalues_entry = PilotFrontCheckin::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'label' => $label, 'dayset' => $dayset])->one();
    $prev_today_values_currentday = PilotFrontCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $dayset])
            ->andWhere(['!=', 'label', 'core_values_popup'])->all();
    $tv_points = 20;
    $count_tv = 0;
    if (!empty($prev_today_values_currentday)):
      $count_tv = count($prev_today_values_currentday);
      if ($count_tv < 2):
        $tv_points = 20;
      else:
        $tv_points = 0;
      endif;
    endif;
    if (Yii::$app->request->post('PilotFrontCheckin')):
      $label = Yii::$app->request->post('PilotFrontCheckin')['label'];
      $comment = Yii::$app->request->post('PilotFrontCheckin')['comment'];
      $serial = Yii::$app->request->post('PilotFrontCheckin')['serial'];
      $checkModel = PilotFrontCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'label' => $label, 'serial' => $serial, 'dayset' => $dayset])->one();
      if (empty($checkModel)):
        $model = new PilotFrontCheckin;
        $model->game_id = $game;
        $model->user_id = $user_id;
        $model->company_id = $comp_id;
        $model->label = $label;
        $model->comment = json_encode($comment);
        $model->serial = $serial;
        $model->points = $tv_points;
        $model->dayset = $dayset;
        $model->created = time();
        $model->updated = time();
        $model->save(false);
      endif;
      Yii::$app->session->setFlash('success', 'Saved Successfully.');
      return $this->redirect(['dashboard']);
      Yii::$app->end();
    else:
      $html = $this->renderAjax('game_modals', [
        'today_valuesModel' => $today_valuesModel,
        'prev_today_values_currentday' => $prev_today_values_currentday,
        'count_tv' => $count_tv,
      ]);
      return $html;
    endif;
  }

  /**
   * 
   * @return Leadership Modal
   */
  public function actionLeadershipModal() {
    $game = 1;
    $comp_id = 1;
    $points = 10;
    $week_no = 1;
    $dayset = date('Y-m-d');
    $tip_pos = Yii::$app->request->get()['tip'];
    $leadership_model = new PilotFrontLeadershipcorner;
    $leadership_entry = PilotFrontLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => $tip_pos])->one();
    if (Yii::$app->request->post()):
      $user_id = Yii::$app->request->post('PilotFrontLeadershipcorner')['user_id'];
      $tip_pos = Yii::$app->request->post('PilotFrontLeadershipcorner')['tip_pos'];
      $dayset = Yii::$app->request->post('PilotFrontLeadershipcorner')['dayset'];
      $checkModel = PilotFrontLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => $tip_pos])->one();
      if (empty($checkModel)):
        $model = new PilotFrontLeadershipcorner;
        $model->game_id = $game;
        $model->user_id = $user_id;
        $model->company_id = $comp_id;
        $model->week_no = $week_no;
        $model->tip_pos = $tip_pos;
        $model->points = $points;
        $model->dayset = $dayset;
        $model->created = time();
        $model->updated = time();
        $model->save(false);
      endif;
      Yii::$app->session->setFlash('success', 'Saved Successfully.');
      return $this->redirect(['dashboard']);
      Yii::$app->end();
    else:
      $html = $this->renderAjax('game_modals', [
        'leadership_model' => $leadership_model,
        'leadership_entry' => $leadership_entry,
        'tip_pos' => $tip_pos,
      ]);
      return $html;
    endif;
  }

  /**
   * 
   * @return Weekly Challenge Modal
   */
  public function actionWeeklyModal() {
    $game = 1;
    $comp_id = 1;
    $points = 40;
    $week_no = 1;
    $weekly_entry = PilotFrontWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no])->one();
    if (empty($weekly_entry)):
      $weekly_model = new PilotFrontWeeklychallenge;
    else:
      $weekly_model = $weekly_entry;
    endif;
    if (Yii::$app->request->post()):
      $user_id = Yii::$app->request->post('PilotFrontWeeklychallenge')['user_id'];
      $dayset = Yii::$app->request->post('PilotFrontWeeklychallenge')['dayset'];
      $comment = Yii::$app->request->post('PilotFrontWeeklychallenge')['comment'];
      $checkModel = PilotFrontWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'week_no' => $week_no])->one();
      if (empty($checkModel)):
        $model = new PilotFrontWeeklychallenge;
        $model->game_id = $game;
        $model->user_id = $user_id;
        $model->company_id = $comp_id;
        $model->points = $points;
        $model->week_no = $week_no;
        $model->comment = $comment;
        $model->dayset = $dayset;
        $model->created = time();
        $model->updated = time();
        $model->save();
        Yii::$app->session->setFlash('success', 'Saved Successfully.');
        return $this->redirect(['dashboard']);
        Yii::$app->end();
      else:
        $checkModel->comment = $comment;
        $checkModel->updated = time();
        if ($checkModel->save()):
          Yii::$app->session->setFlash('success', 'Updated Successfully.');
          return $this->redirect(['dashboard']);
          Yii::$app->end();
        endif;
      endif;
    else:
      $html = $this->renderAjax('game_modals', [
        'weekly_model' => $weekly_model,
        'weekly_entry' => $weekly_entry,
      ]);
      return $html;
    endif;
  }

  /**
   * 
   * @return Weekly Challenge Modal
   */
  public function actionShareABinModal() {
    $game = 1;
    $comp_id = 1;
    $points = 10;
    $shareawin_model = new PilotFrontShareawin;
    if (Yii::$app->request->post()):
      $user_id = Yii::$app->request->post('PilotFrontShareawin')['user_id'];
      $dayset = Yii::$app->request->post('PilotFrontShareawin')['dayset'];
      $comment = Yii::$app->request->post('PilotFrontShareawin')['comment'];
      $model = new PilotFrontShareawin;
      $model->game_id = $game;
      $model->user_id = $user_id;
      $model->company_id = $comp_id;
      $model->points = $points;
      $model->comment = json_encode($comment);
      $model->dayset = $dayset;
      $model->created = time();
      $model->updated = time();
      $model->save();
      Yii::$app->session->setFlash('success', 'Saved Successfully.');
      return $this->redirect(['dashboard']);
      Yii::$app->end();
    else:
      $html = $this->renderAjax('game_modals', [
        'shareawin_model' => $shareawin_model,
      ]);
      return $html;
    endif;
  }

  /**
   * 
   * Implements High five Likes
   */
  public function actionHighfiveLike() {
    $game = 1;
    $comp_id = 1;
    $points = 0;
    $dayset = date('Y-m-d');
    $user_id = $_POST['user_id'];
    $feature_label = $_POST['feature_label'];
    $linked_feature_id = $_POST['comment_id'];
    $checkModel = PilotFrontHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => $feature_label, 'linked_feature_id' => $linked_feature_id])->one();
    if (empty($checkModel)):
      $model = new PilotFrontHighfive;
      $model->game_id = $game;
      $model->user_id = $user_id;
      $model->company_id = $comp_id;
      $model->feature_label = $feature_label;
      $model->feature_value = 1;
      $model->feature_serial = 1;
      $model->linked_feature_id = $linked_feature_id;
      $model->points = $points;
      $model->dayset = $dayset;
      $model->created = time();
      $model->updated = time();
      $model->save(false);
      //Save Notification for User in pilot_front_notifications Table
      $linked_feature_user_model = PilotFrontHighfive::find()->where(['id' => $linked_feature_id])->one();
      $comment_val = json_decode($linked_feature_user_model->feature_value);
      $max_length = 25;
      if (strlen($comment_val) > $max_length):
        $offset = ($max_length - 3) - strlen($comment_val);
        $comment_val = substr($comment_val, 0, strrpos($comment_val, ' ', $offset)) . '...';
      endif;
      $comment_val = str_replace("<br>", " ", $comment_val);
      $linked_feature_user = PilotFrontUser::findIdentity($linked_feature_user_model->user_id);
      $hf_like_user = PilotFrontUser::findIdentity($user_id);
      $hf_like_userName = $hf_like_user->username;
      $notif_value = '<b>' . $hf_like_userName . '</b> high fived your comment <a href="javascript:void(0)">"' . $comment_val . '"</a>';

      //Save Other Users Activity not Own
      if ($linked_feature_user->id != $user_id):
        $notif_model = new PilotFrontNotifications;
        $notif_model->game_id = $game;
        $notif_model->user_id = $linked_feature_user->id;
        $notif_model->company_id = $comp_id;
        $notif_model->notif_type_id = $linked_feature_id;
        $notif_model->notif_type = 'highfiveLike';
        $notif_model->notif_value = $notif_value;
        $notif_model->activity_user_id = $user_id;
        $notif_model->notif_status = 1;
        $notif_model->dayset = $dayset;
        $notif_model->created = time();
        $notif_model->updated = time();
        $notif_model->save(false);
      endif;
    endif;
    $total_likes = PilotFrontHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $linked_feature_id])->all();
    echo json_encode(['status' => 'success', 'likes' => count($total_likes), 'hand_img' => 'hand-colored.png']);
    exit();
  }

  /**
   * Returns Tagged Users List
   */
  public function actionTagList() {
    $baseurl = Yii::$app->request->baseurl;
    if ($_POST) {
      $q = $_POST['searchword'];
      if (strpos($q, '@') !== false) {
        $q = str_replace("@", "", $q);
      }
      else if (strpos($q, '#') !== false) {
        $q = str_replace("#", "", $q);
      }
      /** Adding Wildcard Character * */
      $attachment = '%';
      $count = strlen($q);
      $pos = $count;
      $newstr = substr_replace($q, $attachment, $pos);
      /** End * */
      /** Query Database Table to Fetch the Users who need to Tag * */
      $company_id = Yii::$app->user->identity->company_id;
      $query = "SELECT * FROM pilot_front_user where company_id = '$company_id' and firstname LIKE '$newstr'";
      $find_tagged_users = PilotFrontUser::findBySql($query)->all();

      /** End * */
      if (empty($find_tagged_users)) {
        $h = '32px';
        $htm = ' <div class="display_box" align="left">
                  No Such User<br/>
                 </div>';
      }
      else {
        $no_u = count($find_tagged_users);
        $h = 'auto';
        $htm = "";
        $i = 1;
        foreach ($find_tagged_users as $tagged_user) {
          $userID = $tagged_user['id'];
          $fname = ucfirst($tagged_user['firstname']);
          $lname = ucfirst($tagged_user['lastname']);
          $prof_image = $tagged_user['profile_pic'];
          if ($prof_image == ''):
            $prof_image_path = '../images/default-user.png';
          else:
            $prof_image_path = $baseurl . '/uploads/thumb_' . $prof_image;
          endif;
          $htm .='<div class="display_box" align="left" onclick="append_data(this)" >';
          $htm .= '<img src="' . $prof_image_path . ' " class="tag-user-img"/>';
          $htm .='<a href="javascript:void(0)" class="addname" title=' . $fname . '&nbsp;' . $lname . ' user-id=' . $userID . '> ' . $fname . '&nbsp;' . $lname . ' </a><br/>';
          $htm .='</div>';
          $i++;
        }
      }
      echo json_encode(array('htm' => $htm, 'height_dis' => $h));
    }
  }

  /**
   * 
   * @return High five Users Comment Modal 
   */
  public function actionHighfiveUsercommentModal() {
    $game = 1;
    $comp_id = 1;
    $points = 10;
    $usercomment_model = new PilotFrontHighfive;
    $user_id = Yii::$app->request->get()['uid'];
    $comment_id = Yii::$app->request->get()['cid'];
    $feature_label = 'highfiveComment';
    $commentValue = PilotFrontHighfive::find()->where(['id' => $comment_id])->one();
    $userComments = PilotFrontHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveUserComment', 'linked_feature_id' => $comment_id])
        ->orderBy(['created' => SORT_ASC])
        ->all();
    $html = $this->renderAjax('game_modals', [
      'usercomment_model' => $usercomment_model,
      'commentValue' => $commentValue,
      'userComments' => $userComments,
    ]);
    return $html;
  }

  /**
   * 
   * Saves High five User Comment 
   */
  public function actionSaveHighfiveUsercomment() {
    $baseurl = Yii::$app->request->baseurl;
    $game = 1;
    $comp_id = 1;
    $cmnt_points = 0;
    $dayset = date('Y-m-d');
    $user_id = Yii::$app->user->identity->id;
    $feature_label = 'highfiveUserComment';
    $feature_value = $_POST['cmnt'];
    $feature_serial = $_POST['cmnt_serial'];
    $linked_feature_id = $_POST['linked_hf_cmnt'];
    $checkModel = PilotFrontHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => $feature_label, 'feature_serial' => $feature_serial, 'linked_feature_id' => $linked_feature_id])->one();
    $html = '';
    if (empty($checkModel)):
      $model = new PilotFrontHighfive;
      $model->game_id = $game;
      $model->user_id = $user_id;
      $model->company_id = $comp_id;
      $model->feature_label = $feature_label;
      $model->feature_value = json_encode($feature_value);
      $model->feature_serial = $feature_serial;
      $model->linked_feature_id = $linked_feature_id;
      $model->points = $cmnt_points;
      $model->dayset = $dayset;
      $model->created = time();
      $model->updated = time();
      $model->save(false);
      //Save Notification for User in pilot_front_notifications Table
      $linked_feature_user_model = PilotFrontHighfive::find()->where(['id' => $linked_feature_id])->one();
      $comment_val = json_decode($linked_feature_user_model->feature_value);
      $max_length = 25;
      if (strlen($comment_val) > $max_length):
        $offset = ($max_length - 3) - strlen($comment_val);
        $comment_val = substr($comment_val, 0, strrpos($comment_val, ' ', $offset)) . '...';
      endif;
      $comment_val = str_replace("<br>", " ", $comment_val);
      $linked_feature_user = PilotFrontUser::findIdentity($linked_feature_user_model->user_id);
      $hf_comment_user = PilotFrontUser::findIdentity($user_id);
      $hf_comment_userName = $hf_comment_user->username;
      $notif_value = '<b>' . $hf_comment_userName . '</b> has commented on your comment <a href="javascript:void(0)">"' . $comment_val . '"</a>';
      //Save Other Users Activity not Own
      if ($linked_feature_user->id != $user_id):
        $notif_model = new PilotFrontNotifications;
        $notif_model->game_id = $game;
        $notif_model->user_id = $linked_feature_user->id;
        $notif_model->company_id = $comp_id;
        $notif_model->notif_type_id = $linked_feature_id;
        $notif_model->notif_type = 'highfiveUserComment';
        $notif_model->notif_value = $notif_value;
        $notif_model->activity_user_id = $user_id;
        $notif_model->notif_status = 1;
        $notif_model->dayset = $dayset;
        $notif_model->created = time();
        $notif_model->updated = time();
        $notif_model->save(false);
      endif;
    endif;
    //Comments Display Under Appreciation Comment
    $allComments = PilotFrontHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => $feature_label, 'linked_feature_id' => $linked_feature_id])
            ->orderBy(['created' => SORT_ASC])->all();
    $i = 1;
    if (!empty($allComments)):
      foreach ($allComments as $comment):
        $cmnt_user = PilotFrontUser::findIdentity($comment->user_id);
        $cmnt_userName = $cmnt_user->username;
        $cmnt_userImage = $cmnt_user->profile_pic;
        $cmnt = json_decode($comment->feature_value);
        if (cmnt_userImage == ''):
          $cmnt_userImagePath = '../images/user_icon.png';
        else:
          $cmnt_userImagePath = $baseurl . '/uploads/thumb_' . $cmnt_userImage;
        endif;
        if ($i % 2 == 0):
          $row_cls = '';
        else:
          $row_cls = 'w';
        endif;
        $created = $comment->created;
        $cmnt_time = date('M d, Y h:i A', $created);
        $html .= '<div class="user-record High-5 ' . $row_cls . '">
                          <div class="user">
                              <img alt="user" src="' . $cmnt_userImagePath . '">
                          </div>
                          <div class="right_info">
                              <ul class="user-info">
                                  <li> <h5>' . $cmnt_userName . '</h5><p class="time1">' . $cmnt_time . '</p></li>
                                  <li> <p> ' . $cmnt . '</p> </li>
                              </ul>
                          </div> 
                      </div>';
        $i++;
        $serial = $comment->feature_serial;
      endforeach;
      $cmnt_serial = $serial + 1;
    else:
      $cmnt_serial = 1;
    endif;
    echo json_encode(array('html' => $html, 'cmnt_serial' => $cmnt_serial, 'status' => 'success'));
  }

  /**
   * 
   * Fetch the Notifications 
   */
  public function actionGetNotifications() {
    $baseurl = Yii::$app->request->baseurl;
    $game = 1;
    $comp_id = 1;
    $cmnt_points = 0;
    $dayset = date('Y-m-d');
    $user_id = Yii::$app->user->identity->id;
    $user_notifs = PilotFrontNotifications::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])->orderBy(['id' => SORT_DESC])->all();
    $notif_html = '';
    if (!empty($user_notifs)):
      foreach ($user_notifs as $user_notif) :
        $notif_type_id = $user_notif->notif_type_id;
        $notif_type = $user_notif->notif_type;
        $notif_value = $user_notif->notif_value;
        $notif_status = $user_notif->notif_status;
        $notif_activity_user_id = $user_notif->activity_user_id;
        $notif_activity_user = PilotFrontUser::findIdentity($notif_activity_user_id);
        $notif_activity_userName = $notif_activity_user->username;
        if ($notif_activity_user->profile_pic):
          $imagePath = Yii::$app->request->baseurl . '/uploads/' . $notif_activity_user->profile_pic;
        else:
          $imagePath = Yii::$app->request->baseurl . '/images/user_icon.png';
        endif;

        if ($notif_status == 1):
          $read_cls = 'w';
        else:
          $read_cls = '';
        endif;

        $notif_html .='<div id="' . $user_notif->id . '" class="user-notify ' . $read_cls . '" data-uid="' . $user_id . '" data-cid="' . $notif_type_id . '">'
            . '<div class="user-img">'
            . '<img src=' . $imagePath . ' height="50px" width="50px">'
            . '</div>'
            . '<div class="user-detail">'
            . '' . $notif_value . ''
            . '</div>'
            . '</div>';
      endforeach;
    else:
      $notif_html .='<div class="no-noification"><b>No Notifications found</b></div> ';
    endif;
    echo json_encode(array('notif_html' => $notif_html));
  }

  /**
   * 
   * Set the Status of Notifications 
   */
  public function actionNotificationStatus() {
    $notif_id = $_GET['nid'];
    $notif_model = PilotFrontNotifications::find()->where(['id' => $notif_id])->one();
    if (!empty($notif_model)):
      $notif_model->notif_status = 0;
      $notif_model->save(false);
    endif;
    return 'success';
  }

}
