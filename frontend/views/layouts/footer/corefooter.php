<?php
$baseurl = Yii::$app->request->baseurl;

$company_name = 'site';
if (isset($_SESSION['company_name'])):
  $company_name = $_SESSION['company_name'];
endif;
?>
<footer id=footer class="footer top-space1">
    <div class=footer1>
        <div class=container>
            <div class=row>
                <div class=col-md-12>
                    <div class=widget-body>
                        <ul class="footer-bottom-menu">
                            <li>Copyright<span> &copy; </span><?= date('Y') ?> InJoy Global, Inc.</li>
                            <li><a target="_blank" href="<?= $baseurl; ?>/<?= $company_name; ?>/privacy-policy">Privacy Policy</a></li>
                            -
                            <li><a target="_blank" href="<?= $baseurl; ?>/<?= $company_name; ?>/terms-condition">Terms of Use</a></li>
                        </ul>
                    </div></div>
            </div>
        </div>
    </div>
</footer>