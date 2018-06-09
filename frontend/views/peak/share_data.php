<div id=myCarousel class="carousel slide" data-ride=carousel>
    <div class="carousel-inner inner_s" role=listbox>
        <?php
        $i = 1;
        foreach ($shareawins_all as $shareawin):
            if ($i == 1):
                $cls = 'active';
            else:
                $cls = '';
            endif;
            $shareawin->comment = strip_tags($shareawin->comment);
            $share_comment = json_decode($shareawin->comment);
            // print_r($share_comment);
            $max_length = 70;
            if (strlen($share_comment) > $max_length) {
                $offset = ($max_length - 3) - strlen($share_comment);
                $bar = preg_match('/\s/', $share_comment);
                if ($bar >= 1):
                    $share_comment = substr($share_comment, 0, strrpos($share_comment, ' ', $offset)) . '...';
                else:
                    $share_comment = substr($share_comment, 0, 65) . '...';
                endif;
            }
            ?>
            <div class="item c_slider <?= $cls ?>">
                <div class=carousel-caption>
                    <div class=share-content>
                        <p>
                            <?= $share_comment; ?>
                        </p>
                    </div>
                    <div class=share-user-data>
                        <?php
                        if ($shareawin->userinfo->profile_pic) {
                            $imagePath = Yii::$app->request->baseurl . '/uploads/thumb_' . $shareawin->userinfo->profile_pic;
                        } else {
                            $imagePath = Yii::$app->request->baseurl . '/images/user_icon.png';
                        }
                        ?> 
                        <img src="<?= $imagePath; ?>"  class=slider-userimage alt=slider height=63 width=63>
                    </div>
                    <div class=share-user-name>
                        <?php echo ucwords($shareawin->userinfo->username); ?>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        endforeach;
        ?>
    </div>
    <a class="left carousel-control" href="#myCarousel" role=button data-slide=prev>
        <img src="<?= $baseurl; ?>/images/left.png" alt=left height=31 width=18>
    </a>
    <a class="right carousel-control" href="#myCarousel" role=button data-slide=next>
        <img src="<?= $baseurl; ?>/images/right.png" alt=left height=31 width=18>
    </a>
</div> 