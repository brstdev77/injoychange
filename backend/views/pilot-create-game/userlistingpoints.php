

<?php

use yii\helpers\html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use kartik\file\FileInput;

$this->title = 'Users Overall Points';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Manage Games', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id];
$this->params['breadcrumbs'][] = 'UserPoints';
?>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">
                <table class="table">
                    <tr>
                        <th>Rank</th>
                        <th>Profile Pic</th>
                        <th>Name</th>
                        <th>Overall Points</th>
                    </tr>
                    <?php foreach ($userlisting as $key => $val) {
                      ?>                    
                      <tr>
                          <td><?php echo $key+1; ?></td>
						  <?php if(empty($val['profile_pic']))
								{
									$image = 'noimage.png';
								}
								else
								{
									$image = $val['profile_pic'];
								}
							?>
                          <td><div class="image-wrapper"><img width="100" alt="" src="/frontend/web/uploads/<?php echo $image ?>"></div></td>
                          <td><?php echo $val['user_name']; ?></td>
                          <td><?php echo $val['total_points']; ?></td>
                      </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>