<?php

use yii\helpers\Html;
use yii\web\Request;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3 class="modal-title"  style="text-align: center;">User Information</h3>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6"><img src="/frontend/web/uploads/<?= $user->profile_pic; ?>" style="width:120px; margin-right: 10px;margin-bottom:7px"></div>
        <div class="col-md-6">
            <h4 style="font-weight: bold; margin-top: 0;" id="game-name"><?= $user->username; ?></h4>
            <p id="company-name-preview"><?= $user->emailaddress; ?></p>
        </div>
    </div>
    <hr style="border-bottom: 1px solid #ccc; margin:0px;">
    <div class="row">
        <div class="col-md-6">
            <h4 style="color:#45C0EC">Company</h4>
            <p style="font-weight: bold;font-size: 14px;"><?= frontend\models\PilotFrontUser::getcompanyname($user->company_id); ?></p>
        </div>
        <div class="col-md-6">
            <h4 style="color:#45C0EC">Team</h4>
            <?php if ($user->team_id != ''): ?>
                <p style="font-weight: bold;font-size: 14px;"><?= frontend\models\PilotFrontUser::getteamname($user->company_id, $user->team_id); ?></p>
            <?php else: ?>
                <p style="font-weight: bold;font-size: 14px;">NA</p>
            <?php endif; ?>
        </div>
    </div>
    <hr style="border-bottom: 1px solid #ccc; margin:0px;">
    <div class="row">
        <div class="col-md-6">
            <h4 style="color:#45C0EC">Device</h4>
            <?php if ($user->device != ''): ?>
                <p style="font-weight: bold;font-size: 14px;"><?= $user->device; ?></p>
            <?php else: ?>
                <p style="font-weight: bold;font-size: 14px;">NA</p>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h4 style="color:#45C0EC">Browser</h4>
            <p style="font-weight: bold;font-size: 14px;"><?= $user->browser; ?></p>
        </div>
    </div>
    <hr style="border-bottom: 1px solid #ccc; margin:0px;">
    <div class="row">
        <div class="col-md-6">
            <h4 style="color:#45C0EC">Status</h4>
            <p style="font-weight: bold;font-size: 14px;"><?php
                if ($user->status == 10):echo 'Active';
                else: echo 'Inactive';
                endif;
                ?></p>
        </div>
        <div class="col-md-6">
            <h4 style="color:#45C0EC">Last Login</h4>
            <p style="font-weight: bold;font-size: 14px;"><?= frontend\models\PilotFrontUser::gettimeago($user->last_access_time); ?></p>
        </div>
    </div>
</div>
<div class="modal-footer" style="text-align: center;">
    <button type="button" class="btn btn-default ajax-loader" data-dismiss="modal">Close</button>
</div>