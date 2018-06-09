<?php

use yii\helpers\Html;
use yii\web\Request;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="text-align:center;"><?= $vission_message->popup_heading; ?></h3>
    </div>
    <div class="modal-body">
        <div class="value-description-wrapper">
            <?php if (!empty($core_values)) { ?>
                <div class="value-des-header">
                    <div class="critical-value-header">
                        Core Value
                    </div>
                    <div class="critical-value-desc">
                        Definition
                    </div>
                </div>
                <div class="value-des-content">
                    <?php
                    $row = 1;
                    foreach ($core_values as $core) {
                        if (empty($core->core_values_name)) {
                            continue;
                        }
                        if (!empty($core->core_values_name)) {
                            $expordValue = explode('-', $core->core_values_name);
                            $firstLetter = $expordValue[0];
                            $fullword = isset($expordValue[1]) ? $expordValue[1] : '';
                            $row++;
                        }
                        ?>
                        <div class="value-des-critical-row row<?= $row; ?>">
                            <div class="value-content-value">
                                <!--<span><?= $firstLetter; ?></span> - <?= $fullword; ?> -->
                                <?= $core->core_values_name; ?>
                            </div>
                            <div class="des-content-value">
                                <ul class="core_value_list">
                                    <li>
                                        <?= $core->definition; ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?> 
        </div>
        <div class="mission-vision-footer">
            <?= $vission_message->vission_msg; ?>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>
