<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Request;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use yii\imagine\Image;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use frontend\models\PilotFrontRecognitionEmail;

class RecognitionController extends Controller {

    public function actionDashboard() {
        $this->layout = 'recognition';
        return $this->render('dashboard');
    }

    public function actionDailyModal() {
        $daily_email = new PilotFrontRecognitionEmail;
        $daily_modal = 1;
        $daily_image_path = Yii::getAlias('@back_end') . '/img/daily-inspiration-images/1526440567_3.jpg';
        $html = $this->renderAjax('game_modals', [
            'daily_image_path' => $daily_image_path,
            'daily_email' => $daily_email,
            'daily_modal' => $daily_modal
        ]);
        return $html;
    }
    public function actionDailyEmail() {
        $daily_email = new PilotFrontRecognitionEmail;
        $message = '';
        $headers = [];
        if (Yii::$app->request->post()):
             $daily_image_path = Yii::getAlias('@back_end') . '/img/daily-inspiration-images/1526440567_3.jpg';
            $messagecontent = '<html><body><img src="' . Yii::getAlias('@back_end') . '/img/daily-inspiration-images/1526440567_3.jpg"></body></html>';
            //$messagecontent ='hello';
            $send_email = Yii::$app
                    ->mailer
                    ->compose('send-image', ['model' => $_POST['message'], 'daily_image_path' => '1526440567_3.jpg'])
                    ->setFrom('support@injoyglobal.com')
                    ->setTo($_POST['email_id'])
                    ->setSubject('Daily Inspiration Image')
                    ->send();
            if ($send_email == 1):
                $daily_email->email_id = $_POST['email_id'];
                $daily_email->message = json_encode($messagecontent);
                $daily_email->attachment = $daily_image_path;
                $daily_email->created = time();
                $daily_email->save(false);
                return 'Image Shared Successfully';
            else:
                return 'Image not shared';
            endif;
        endif;
    }
     public function actionPersonalReportModal() {
        $report_modal = 1;
        $html = $this->renderAjax('game_modals', [
            'report_modal' => $report_modal
        ]);
        return $html;
    }
     public function actionCertificateModal() {
        $certificate_modal = 1;
        $html = $this->renderAjax('game_modals', [
            'certificate_modal' => $certificate_modal
        ]);
        return $html;
    }
}
