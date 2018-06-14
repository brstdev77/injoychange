<?phpuse backend\models\PilotCreateGame;use frontend\models\PilotFrontUser;$user_id = Yii::$app->user->identity->id;//Get the Challenge(Game) ID$game = PilotFrontUser::getGameID('service');//User Company ID$comp_id = Yii::$app->user->identity->company_id;//Active Challenge Object (Start Date & End Date) $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();$gameID = '';if (!empty($game_obj)) {    $gameID = $game_obj->id;}if (empty($game_obj->prize_content)) {    ?>    <!--Contest Rules & Prizes Modal HTML-->    <div class="modal fade" role="dialog" id="rules-prizes" data-backdrop="static" data-keyboard="false">        <div class="modal-dialog">                   <div class="modal-content">                <div class="modal-header">                    <button type="button" class="close skip_survey" data-dismiss="modal"></button>                    <h4 class="modal-title">Contest Rules/Prizes</h4>                </div>                <div class="modal-body rules-prizes">                    <div class="container-fluid" >                        <p> Raffle will be for all participating employees. Tickets will allow you to be entered for a chance to win some great prizes.                            How do I earn raffle tickets?</p>                        <p>Raffle tickets will be earned in the following manner:</p>                        <div class="outer-raffle">                            <div class="raffle-pts">                                <ul>                                     <li>100 challenge pts = 1 raffle ticket</li>                                    <?php if ($gameID == '159' || $gameID == '158'): ?>                                        <li>10000 Steps = 100 Points</li>                                    <?php endif; ?>                                    <li>At the end of the challenge, all participants' raffle tickets will be put into the drawing.</li>                                    <li>Winners will be notified</li>                                    <li>More points = more chances to win!</li>                                </ul>                            </div>                            <div class="raffle-img">                                <img src="../images/raffle_ticket.png"/>                            </div>                        </div>                        <p>Prizes will be:</p>                        <ul>                            <li>1st - $200 Visa Gift Card</li>                            <li>2nd - $100 Visa Gift Card</li>                        </ul>                    </div>                </div>                <div class = "modal-footer">                </div>            </div>        </div>    </div><?php }else{ ?>         <div class="modal fade" role="dialog" id="rules-prizes" data-backdrop="static" data-keyboard="false">        <div class="modal-dialog">                   <div class="modal-content">                <div class="modal-header">                    <button type="button" class="close skip_survey" data-dismiss="modal"></button>                    <h4 class="modal-title">Contest Rules/Prizes</h4>                </div>                <div class="modal-body rules-prizes">                    <div class="container-fluid" >                        <?php                         $prize = backend\models\PilotPrizesCategory::find()->where(['!=','prize_content',''])->andwhere(['id' => $game_obj->prize_content])->one();                         if (!empty($prize)) {                            echo $prize->prize_content;                        }                        ?>                    </div>                </div>            </div>        </div>     </div><?php } ?>