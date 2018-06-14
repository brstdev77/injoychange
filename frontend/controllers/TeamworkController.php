<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeamworkController implements the CRUD actions for Teamwork model.
 */
class TeamworkController extends Controller {

  /**
   * @inheritdoc
   */
  public function behaviors() {
    return [
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'delete' => ['POST'],
        ],
      ],
    ];
  }

  /**
   * 
   * @return mixed
   */
  public function actionIndex() {
    $this->layout = 'team';
    return $this->render('index');
  }

  //display dashboard page

  public function actionDashboard() {
    $this->layout = 'team';
    return $this->render('dashboard');
  }

  public function actionDailyInspiration() {
    $this->layout = 'team';
    return $this->render('daily');
  }

  public function actionCheckin() {
    $this->layout = 'team';
    return $this->render('checkin');
  }

  public function actionHiveFive() {
    $this->layout = 'team';
    return $this->render('hivefive');
  }

  public function actionToolbox() {
    $this->layout = 'team';
    return $this->render('toolbox');
  }

  public function actionShareAWin() {
    $this->layout = 'team';
    return $this->render('sharewin');
  }

  public function actionHowItWork() {
    $this->layout = 'team';
    return $this->render('howitwork');
  }

  public function actionLeaderboard() {
    $this->layout = 'team';
    return $this->render('leaderboard');
  }

}
