<?php
/* @var $this yii\web\View */

$this->title = "See All | Get to Know the Team";
$baseurl = Yii::$app->request->baseurl;
$j = 0;
$k = 0;
$class1 = '';
$class2 = '';
$class3 = '';
$class4 = '';
$class5 = '';
$class6 = '';
$page = Yii::$app->request->get('page');
if ($page == ''):
    $page = 1;
endif;
if ($page >= 1):
    $next = $page + 1;
    $prev = $page - 1;
endif;
if ($page == 1):
    $class1 = 'active';
endif;
if ($page == 2):
    $class2 = 'active';
endif;
if ($page == 3):
    $class3 = 'active';
endif;
if ($page == 4):
    $class4 = 'active';
endif;
if ($page == 5):
    $class5 = 'active';
endif;
if ($page == 6):
    $class6 = 'active';
endif;
if ($tip == 'Week 4-three'):
    $total = 36;
endif;
if ($tip == 'Week 4-two'):
    $total = 33;
endif;
if ($total == 24 && $page == 4):
    $next = 0;
endif;
if ($tip == 'Week 4-one'):
    $total = 30;
endif;
if ($total == 30 && $page == 5):
    $next = 0;
endif;
if ($total == 33 && $page == 6):
    $next = 0;
endif;
if ($total == 36 && $page == 6):
    $next = 0;
endif;
?>
<?php
$this->registerCssFile($baseurl . '/css/seeall.css');
?>
<div class="site-index">
    <div class="seeall-data">
        <div class="dashboard-title"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/learning/dashboard">&lt; Dashboard</a></div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 high-five-title">GET TO KNOW THE TEAM</div>
        </div>
        <div class="toolbox-outer">
            <?php if ($tip == 'Week 4-three'): ?>
                <?php if($page == 1): ?>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/linda2.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Linda LoRe</strong>
                            </p>
                            <p class="user_hobby">Linda’s favorite holiday is Christmas.</p>
                            <p class="hobby_description">Christmas is my favorite holiday! The infamous Cookie Party, the Family Gatherings (especially the funny gift exchange with my 10 siblings, mom, and dad) and all of the gatherings in between! We cannot forget all of the decorations... If you know, you KNOW!</p>
                            <!--div class="hobby_image">
                                <img alt="user" title="Image" src="/images/varun_chicken.png">
                            </div-->
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1512029219_5a1fbc2342032.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Pradeep Kumar</strong>
                            </p>
                            <p class="user_hobby">Correct! Pradeep's favorite holiday is NOT Christmas.</p>
                            <p class="hobby_description">Diwali is one of the India's biggest festivals. The word 'Diwali' means rows of lighted lamps. It is a festival of lights. During this festival, people light up their houses.</p>
                            <!--div class="hobby_image">
                                <img alt="user" title="Image" src="/images/brady_apple.png">
                            </div-->
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/know_rajat.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Rajat Saini</strong>
                            </p>
                            <p class="user_hobby">Rajat's favorite holiday is Christmas.</p>
                            <p class="hobby_description">Ever since I was a kid, I have been super into Christmas. The holiday has always been my favorite time of the year for more reasons than just one. Christmas is by far the best holiday in terms of presents which is just one of the many reasons I love Christmas.</p>
                            <!--div class="hobby_image">
                                <img alt="user" title="Image" src="/images/clea_chicken.png">
                            </div-->
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/rakesh.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Rakesh Sanghvi</strong>
                            </p>
                            <p class="user_hobby">Rakesh was not a tennis star.</p>
                            <p class="hobby_description">Most people do not know that I love travelling and visiting new places</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/6.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Elly Bannon</strong>
                            </p>
                            <p class="user_hobby">Elly Bannon was not a tennis star.</p>
                            <p class="hobby_description">Most people don't know that I have an INSANE sense of smell. I can smell what you had for lunch, a flower from across the house, cookies that were baked a week ago and probably a ladybug fart.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/jeff2.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Jeff Baietto</strong>
                            </p>
                            <p class="user_hobby">Most people don't know that Jeff was a tennis star.</p>
                            <p class="hobby_description">I was the #1 ranked paddle tennis player in the United States (Division 3, lowest division : ) for a full 48 hours : )</p>
                        </div> 
                    </div>
                <?php
                endif;
                if ($page == 2): ?>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="../images/varun.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Holly Bennett Etzell</strong>
                            </p>
                            <p class="user_hobby">Holly did NOT mention sleeping.</p>
                            <p class="hobby_description">Most people don't know I was very involved in the arts growing up...I was in choir, show choir, band, dance and theater in high school.</p>
                            <!--div class="hobby_image">
                                <img alt="user" title="Image" src="/images/varun_chicken.png">
                            </div-->
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1512029219_5a1fbc2342032.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Pradeep Sharma</strong>
                            </p>
                            <p class="user_hobby">Pradeep did mention sleeping..</p>
                            <p class="hobby_description">I love to sleep.</p>
                            <!--div class="hobby_image">
                                <img alt="user" title="Image" src="/images/brady_apple.png">
                            </div-->
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1509688959_59fc067f478f7.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Kunal Khullar</strong>
                            </p>
                            <p class="user_hobby">Kunal did mention sleeping.</p>
                            <p class="hobby_description">I love to sleep and I am very lazy.</p>
                            <!--div class="hobby_image">
                                <img alt="user" title="Image" src="/images/clea_chicken.png">
                            </div-->
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1509688959_59fc067f478f7.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Kunal Khullar</strong>
                            </p>
                            <p class="user_hobby">Kunal likes to spend time with his kids.</p>
                            <p class="hobby_description">My favorite thing to do outside of work is spend time with my daughter - Kaasni. I think her innocence and sweet talk is an out of world experience.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/^54A8FF015CA2AE515A5756B92BB06F3DC274C9D225BC0C8767^pimgpsh_fullsize_distr.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Phil Dixon</strong>
                            </p>
                            <p class="user_hobby">Phil likes to spend time with his kids.</p>
                            <p class="hobby_description">My kids are tiring and challenging at times but constant sources of entertainment.  I love how they are getting to experience the world (for the first time), wins, losses, heartbreak, learning, its pretty cool.  But challenging, did I say that already?</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/jeff2.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Jeff Baietto</strong>
                            </p>
                            <p class="user_hobby">Jeff likes to spend time with his kids.</p>
                            <p class="hobby_description">Hanging with my son. Being with him, watching him experience something new, hearing his laugh or just holding him, simply transcend my previous definition of happy!</p>
                        </div> 
                    </div>
                    
                    <?php
                endif;
                if ($page == 3):
                    ?>
                    <?php //three data start   ?>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="../images/varun.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Varun Verma</strong>
                            </p>
                            <p class="user_hobby">Varun has watched a movie more than 30 times.</p>
                            <p class="hobby_description">I love watching movies and I watched the movie Real Steel more than 30 times</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/tushar.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Tushar Watts</strong>
                            </p>
                            <p class="user_hobby">Tushar has not watched a movie more than 30 times.</p>
                            <p class="hobby_description">I rarely watch movies.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="../images/veerdaman.JPG">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>VeerDaman Singh</strong>
                            </p>
                            <p class="user_hobby">Veer Daman has not watched a movie more than 30 times.</p>
                            <p class="hobby_description">I have watched the movie Border more than 20 times in the theater.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="../images/varun.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Varun Verma</strong>
                            </p>
                            <p class="user_hobby">Varun's favorite comfort food is KFC Chicken.</p>
                            <p class="hobby_description"></p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/varun_chicken.png">
                            </div>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/1.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Brady Teter</strong>
                            </p>
                            <p class="user_hobby">Brady's favorite comfort food is apples.</p>
                            <p class="hobby_description"></p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/brady_apple.png">
                            </div>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/7.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Clea Martin</strong>
                            </p>
                            <p class="user_hobby">Clea's favorite comfort food is her grandma's Cherry Strudel.</p>
                            <p class="hobby_description">It is a flaky, buttery filo dough crust with a caramelized cherry filling with made special sour cherries! She always makes multiple trays for my family and I whenever we visit her in Romania.</p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/clea_chicken.png">
                            </div>
                        </div> 
                    </div>
                    
                    <?php
                endif;
                if ($page == 4):
                    ?>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1520854406_5aa66586cd875.jpeg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Priyanka Sharma</strong>
                            </p>
                            <p class="user_hobby">Try again! Another InJoy Team Member has more siblings.</p>
                            <p class="hobby_description">I have one younger brother. He is doing Mechanical Engineering.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/linda2.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Linda LoRe</strong>
                            </p>
                            <p class="user_hobby">Correct! Linda has the most siblings.</p>
                            <p class="hobby_description">I have 10 siblings, and I'm the 1st born! 10 of us are within 10 years apart, 8 of us are from the same mom and dad, and all of us love each other every much and would do anything for each other.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/ryan.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Ryan Waranauskas</strong>
                            </p>
                            <p class="user_hobby">Try Again! Another InJoy Team Member has more siblings.</p>
                            <p class="hobby_description">My brother and sister are both highly educated--one being a forensic scientist, and the other being a computer engineer. My sister works for the state of Illinois in the CSI department, and my brother is approaching graduation from San Jose University.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1520855914_5aa66b6a555f4.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Varsha Kumari</strong>
                            </p>
                            <p class="user_hobby">Try again! Varsha did not study sociology in college.</p>
                            <p class="hobby_description">I have done my schooling from Hamirpur (Himachal Pradesh). I studied computer science engineering because I love programming and I love to solve problems using computing technology.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/8.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Holly Bennett Etzell</strong>
                            </p>
                            <p class="user_hobby">Try again! Holly did not study sociology in college.</p>
                            <p class="hobby_description">I started in Pre Med, but changed to psychology.  I still have a strong interest in medicine, but psychology felt right.  Growing up in a family of divorce led me to appreciate the importance of psychology & living your relationships with intention.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/1.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Brady Teter</strong>
                            </p>
                            <p class="user_hobby">Correct! Brady studied a form of sociology in college.</p>
                            <p class="hobby_description">I went to the University of Tennessee and studied Industrial Sociology and Labor Relations.</p>
                        </div> 
                    </div>
                    
                    <?php
                endif;
                if ($page == 5):
                    ?>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1520863913_5aa68aa909cdd.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Sukhdeep Kaur</strong>
                            </p>
                            <p class="user_hobby">Correct! Sukhdeep's favorite holiday is Diwali.</p>
                            <p class="hobby_description">I love diwali festival and always wait for this holiday. Because it is festival of lights, people do home decoration, shopping and gifts for each other. People all get together, wear new clothes and cook delicious dishes which spreads happiness among people.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="../images/varun.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Varun Verma</strong>
                            </p>
                            <p class="user_hobby">Try again! Varun's favorite holiday is not Diwali.</p>
                            <p class="hobby_description">Holi is my favorite holiday. Holi is the festival of colors and this festival signifies the victory of good over evil, the arrival of spring, end of winter, and for many is a festive day to meet others, play and laugh, forget and forgive, and repair broken relationships.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/rakesh.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Rakesh Sanghvi</strong>
                            </p>
                            <p class="user_hobby">Try Again! Rakesh's favorite holiday is not Diwali.</p>
                            <p class="hobby_description">Christmas is one of those holidays you spend with all of your family. You get to see aunts, uncles, cousins and grandparents even more during the holiday season whether you're doing a family dinner or even a family trip somewhere.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/^54A8FF015CA2AE515A5756B92BB06F3DC274C9D225BC0C8767^pimgpsh_fullsize_distr.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Phil Dixon</strong>
                            </p>
                            <p class="user_hobby">Try Again!  Phil did not say that.</p>
                            <p class="hobby_description">I did run with the Bulls in Pamplona, Spain.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1512029219_5a1fbc2342032.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Pradeep Kumar</strong>
                            </p>
                            <p class="user_hobby">Pradeep's favorite thing to do outside of work  is visiting new places.</p>
                            <p class="hobby_description">While I Visit on new places always make me fresh and I feel happy. I love to meet new people and learn about their culture.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1509688959_59fc067f478f7.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Kunal Khullar</strong>
                            </p>
                            <p class="user_hobby">Try Again! Kunal did not say that.</p>
                            <p class="hobby_description">My trip to US with my family was special. We got to visit a beautiful country and spend time great people.  My family was with me so it was really special.</p>
                        </div> 
                    </div>
                    <?php
                endif;
                if ($page == 6):
                    ?>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/6.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Elly Bannon</strong>
                            </p>
                            <p class="user_hobby">Elly does not have a cat that sings.</p>
                            <p class="hobby_description">I have 1 pug named, Pearl and 1 cat named Skippy that live in NH and 1 fluffy kitten named Ollie that lives with me here in CA. Ollie just turned 3 and is my registered emotional support pet.</p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/elly_Cats.png">
                            </div>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/7.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Clea Martin</strong>
                            </p>
                            <p class="user_hobby">Clea has singing cats.</p>
                            <p class="hobby_description">I have two cute and hilarious cats (Miko & Aria). I've had them for about 6 years! My favorite thing about them is that they sing back to me when I'm singing. Miko's favorite song to sing is Hakuna Matata because it sounds like the word "tuna" which he loves!</p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/clea_cats.png">
                            </div>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/veerdaman.JPG">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>VeerDaman Singh</strong>
                            </p>
                            <p class="user_hobby">Veer Daman does not have a cat that sings.</p>
                            <p class="hobby_description">I have a dog who is a German Spitz.</p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/verrdamar_dog.png">
                            </div>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/tushar.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Tushar Watts</strong>
                            </p>
                            <p class="user_hobby">Tushar does play cricket.</p>
                            <p class="hobby_description">I enjoy the sportsmanship and aura of the game.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/ryan.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Ryan Waranauskas</strong>
                            </p>
                            <p class="user_hobby">Ryan's favorite thing to do outside of work  is enjoying play guitar.</p>
                            <p class="hobby_description">I enjoy the freedom of expression and the ability to "speak another language" alongside other musicians. It is a unique bond that has not only created some of my favorite memories, but also ignited some of my closest friendships in my life so far. </p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/Abhipray.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Abhipray Gupta</strong>
                            </p>
                            <p class="user_hobby">Abhipray enjoys spending time with Family.</p>
                            <p class="hobby_description">If you get enough time to spend with you family in you daily routine life you are the luckiest person in the world I try to spend most of my free time with my family. discuss with them how to make personal life better and more enjoyable.</p>
                        </div> 
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($tip == 'Week 4-two'): ?>
                <?php if($page == 1): ?>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/rakesh.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Rakesh Sanghvi</strong>
                            </p>
                            <p class="user_hobby">Rakesh was not a tennis star.</p>
                            <p class="hobby_description">Most people do not know that I love travelling and visiting new places</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/6.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Elly Bannon</strong>
                            </p>
                            <p class="user_hobby">Elly Bannon was not a tennis star.</p>
                            <p class="hobby_description">Most people don't know that I have an INSANE sense of smell. I can smell what you had for lunch, a flower from across the house, cookies that were baked a week ago and probably a ladybug fart.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/jeff2.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Jeff Baietto</strong>
                            </p>
                            <p class="user_hobby">Most people don't know that Jeff was a tennis star.</p>
                            <p class="hobby_description">I was the #1 ranked paddle tennis player in the United States (Division 3, lowest division : ) for a full 48 hours : )</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="../images/varun.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Holly Bennett Etzell</strong>
                            </p>
                            <p class="user_hobby">Holly did NOT mention sleeping.</p>
                            <p class="hobby_description">Most people don't know I was very involved in the arts growing up...I was in choir, show choir, band, dance and theater in high school.</p>
                            <!--div class="hobby_image">
                                <img alt="user" title="Image" src="/images/varun_chicken.png">
                            </div-->
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1512029219_5a1fbc2342032.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Pradeep Sharma</strong>
                            </p>
                            <p class="user_hobby">Pradeep did mention sleeping..</p>
                            <p class="hobby_description">I love to sleep.</p>
                            <!--div class="hobby_image">
                                <img alt="user" title="Image" src="/images/brady_apple.png">
                            </div-->
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1509688959_59fc067f478f7.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Kunal Khullar</strong>
                            </p>
                            <p class="user_hobby">Kunal did mention sleeping.</p>
                            <p class="hobby_description">I love to sleep and I am very lazy.</p>
                            <!--div class="hobby_image">
                                <img alt="user" title="Image" src="/images/clea_chicken.png">
                            </div-->
                        </div> 
                    </div>
                <?php
                endif;
                if ($page == 2): ?>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1509688959_59fc067f478f7.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Kunal Khullar</strong>
                            </p>
                            <p class="user_hobby">Kunal likes to spend time with his kids.</p>
                            <p class="hobby_description">My favorite thing to do outside of work is spend time with my daughter - Kaasni. I think her innocence and sweet talk is an out of world experience.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/^54A8FF015CA2AE515A5756B92BB06F3DC274C9D225BC0C8767^pimgpsh_fullsize_distr.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Phil Dixon</strong>
                            </p>
                            <p class="user_hobby">Phil likes to spend time with his kids.</p>
                            <p class="hobby_description">My kids are tiring and challenging at times but constant sources of entertainment.  I love how they are getting to experience the world (for the first time), wins, losses, heartbreak, learning, its pretty cool.  But challenging, did I say that already?</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/jeff2.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Jeff Baietto</strong>
                            </p>
                            <p class="user_hobby">Jeff likes to spend time with his kids.</p>
                            <p class="hobby_description">Hanging with my son. Being with him, watching him experience something new, hearing his laugh or just holding him, simply transcend my previous definition of happy!</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="../images/varun.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Varun Verma</strong>
                            </p>
                            <p class="user_hobby">Varun has watched a movie more than 30 times.</p>
                            <p class="hobby_description">I love watching movies and I watched the movie Real Steel more than 30 times</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/tushar.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Tushar Watts</strong>
                            </p>
                            <p class="user_hobby">Tushar has not watched a movie more than 30 times.</p>
                            <p class="hobby_description">I rarely watch movies.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="../images/veerdaman.JPG">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>VeerDaman Singh</strong>
                            </p>
                            <p class="user_hobby">Veer Daman has not watched a movie more than 30 times.</p>
                            <p class="hobby_description">I have watched the movie Border more than 20 times in the theater.</p>
                        </div> 
                    </div>
                    
                    <?php
                endif;
                if ($page == 3):
                    ?>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="../images/varun.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Varun Verma</strong>
                            </p>
                            <p class="user_hobby">Varun's favorite comfort food is KFC Chicken.</p>
                            <p class="hobby_description"></p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/varun_chicken.png">
                            </div>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/1.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Brady Teter</strong>
                            </p>
                            <p class="user_hobby">Brady's favorite comfort food is apples.</p>
                            <p class="hobby_description"></p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/brady_apple.png">
                            </div>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/7.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Clea Martin</strong>
                            </p>
                            <p class="user_hobby">Clea's favorite comfort food is her grandma's Cherry Strudel.</p>
                            <p class="hobby_description">It is a flaky, buttery filo dough crust with a caramelized cherry filling with made special sour cherries! She always makes multiple trays for my family and I whenever we visit her in Romania.</p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/clea_chicken.png">
                            </div>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1520854406_5aa66586cd875.jpeg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Priyanka Sharma</strong>
                            </p>
                            <p class="user_hobby">Try again! Another InJoy Team Member has more siblings.</p>
                            <p class="hobby_description">I have one younger brother. He is doing Mechanical Engineering.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/linda2.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Linda LoRe</strong>
                            </p>
                            <p class="user_hobby">Correct! Linda has the most siblings.</p>
                            <p class="hobby_description">I have 10 siblings, and I'm the 1st born! 10 of us are within 10 years apart, 8 of us are from the same mom and dad, and all of us love each other every much and would do anything for each other.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/ryan.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Ryan Waranauskas</strong>
                            </p>
                            <p class="user_hobby">Try Again! Another InJoy Team Member has more siblings.</p>
                            <p class="hobby_description">My brother and sister are both highly educated--one being a forensic scientist, and the other being a computer engineer. My sister works for the state of Illinois in the CSI department, and my brother is approaching graduation from San Jose University.</p>
                        </div> 
                    </div>
                    <?php
                endif;
                if ($page == 4):
                    ?>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1520855914_5aa66b6a555f4.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Varsha Kumari</strong>
                            </p>
                            <p class="user_hobby">Try again! Varsha did not study sociology in college.</p>
                            <p class="hobby_description">I have done my schooling from Hamirpur (Himachal Pradesh). I studied computer science engineering because I love programming and I love to solve problems using computing technology.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/8.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Holly Bennett Etzell</strong>
                            </p>
                            <p class="user_hobby">Try again! Holly did not study sociology in college.</p>
                            <p class="hobby_description">I started in Pre Med, but changed to psychology.  I still have a strong interest in medicine, but psychology felt right.  Growing up in a family of divorce led me to appreciate the importance of psychology & living your relationships with intention.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/1.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Brady Teter</strong>
                            </p>
                            <p class="user_hobby">Correct! Brady studied a form of sociology in college.</p>
                            <p class="hobby_description">I went to the University of Tennessee and studied Industrial Sociology and Labor Relations.</p>
                        </div> 
                    </div>
            <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1520863913_5aa68aa909cdd.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Sukhdeep Kaur</strong>
                            </p>
                            <p class="user_hobby">Correct! Sukhdeep's favorite holiday is Diwali.</p>
                            <p class="hobby_description">I love diwali festival and always wait for this holiday. Because it is festival of lights, people do home decoration, shopping and gifts for each other. People all get together, wear new clothes and cook delicious dishes which spreads happiness among people.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="../images/varun.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Varun Verma</strong>
                            </p>
                            <p class="user_hobby">Try again! Varun's favorite holiday is not Diwali.</p>
                            <p class="hobby_description">Holi is my favorite holiday. Holi is the festival of colors and this festival signifies the victory of good over evil, the arrival of spring, end of winter, and for many is a festive day to meet others, play and laugh, forget and forgive, and repair broken relationships.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/rakesh.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Rakesh Sanghvi</strong>
                            </p>
                            <p class="user_hobby">Try Again! Rakesh's favorite holiday is not Diwali.</p>
                            <p class="hobby_description">Christmas is one of those holidays you spend with all of your family. You get to see aunts, uncles, cousins and grandparents even more during the holiday season whether you're doing a family dinner or even a family trip somewhere.</p>
                        </div> 
                    </div>
                    <?php
                endif;
                if ($page == 5):
                    ?>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/^54A8FF015CA2AE515A5756B92BB06F3DC274C9D225BC0C8767^pimgpsh_fullsize_distr.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Phil Dixon</strong>
                            </p>
                            <p class="user_hobby">Try Again!  Phil did not say that.</p>
                            <p class="hobby_description">I did run with the Bulls in Pamplona, Spain.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1512029219_5a1fbc2342032.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Pradeep Kumar</strong>
                            </p>
                            <p class="user_hobby">Pradeep's favorite thing to do outside of work  is visiting new places.</p>
                            <p class="hobby_description">While I Visit on new places always make me fresh and I feel happy. I love to meet new people and learn about their culture.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1509688959_59fc067f478f7.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Kunal Khullar</strong>
                            </p>
                            <p class="user_hobby">Try Again! Kunal did not say that.</p>
                            <p class="hobby_description">My trip to US with my family was special. We got to visit a beautiful country and spend time great people.  My family was with me so it was really special.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/6.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Elly Bannon</strong>
                            </p>
                            <p class="user_hobby">Elly does not have a cat that sings.</p>
                            <p class="hobby_description">I have 1 pug named, Pearl and 1 cat named Skippy that live in NH and 1 fluffy kitten named Ollie that lives with me here in CA. Ollie just turned 3 and is my registered emotional support pet.</p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/elly_Cats.png">
                            </div>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/7.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Clea Martin</strong>
                            </p>
                            <p class="user_hobby">Clea has singing cats.</p>
                            <p class="hobby_description">I have two cute and hilarious cats (Miko & Aria). I've had them for about 6 years! My favorite thing about them is that they sing back to me when I'm singing. Miko's favorite song to sing is Hakuna Matata because it sounds like the word "tuna" which he loves!</p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/clea_cats.png">
                            </div>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/veerdaman.JPG">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>VeerDaman Singh</strong>
                            </p>
                            <p class="user_hobby">Veer Daman does not have a cat that sings.</p>
                            <p class="hobby_description">I have a dog who is a German Spitz.</p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/verrdamar_dog.png">
                            </div>
                        </div> 
                    </div>
                    <?php
                endif;
                if ($page == 6):
                    ?>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/tushar.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Tushar Watts</strong>
                            </p>
                            <p class="user_hobby">Tushar does play cricket.</p>
                            <p class="hobby_description">I enjoy the sportsmanship and aura of the game.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/ryan.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Ryan Waranauskas</strong>
                            </p>
                            <p class="user_hobby">Ryan's favorite thing to do outside of work  is enjoying play guitar.</p>
                            <p class="hobby_description">I enjoy the freedom of expression and the ability to "speak another language" alongside other musicians. It is a unique bond that has not only created some of my favorite memories, but also ignited some of my closest friendships in my life so far. </p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/Abhipray.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Abhipray Gupta</strong>
                            </p>
                            <p class="user_hobby">Abhipray enjoys spending time with Family.</p>
                            <p class="hobby_description">If you get enough time to spend with you family in you daily routine life you are the luckiest person in the world I try to spend most of my free time with my family. discuss with them how to make personal life better and more enjoyable.</p>
                        </div> 
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($tip == 'Week 4-one'): ?>
                <?php if ($page == 1): ?>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/8.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Holly Bennett Etzell</strong>
                            </p>
                            <p class="user_hobby">Holly did NOT mention sleeping.</p>
                            <p class="hobby_description">Most people don't know I was very involved in the arts growing up...I was in choir, show choir, band, dance and theater in high school.</p>
                            <!--div class="hobby_image">
                                <img alt="user" title="Image" src="/images/varun_chicken.png">
                            </div-->
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1512029219_5a1fbc2342032.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Pradeep Sharma</strong>
                            </p>
                            <p class="user_hobby">Pradeep did mention sleeping.</p>
                            <p class="hobby_description">I love to sleep.</p>
                            <!--div class="hobby_image">
                                <img alt="user" title="Image" src="/images/brady_apple.png">
                            </div-->
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1509688959_59fc067f478f7.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Kunal Khullar</strong>
                            </p>
                            <p class="user_hobby">Kunal did mention sleeping.</p>
                            <p class="hobby_description">I love to sleep and I am very lazy.</p>
                            <!--div class="hobby_image">
                                <img alt="user" title="Image" src="/images/clea_chicken.png">
                            </div-->
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="../images/varun.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Varun Verma</strong>
                            </p>
                            <p class="user_hobby">Varun's favorite comfort food is KFC Chicken.</p>
                            <p class="hobby_description"></p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/varun_chicken.png">
                            </div>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/1.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Brady Teter</strong>
                            </p>
                            <p class="user_hobby">Brady's favorite comfort food is apples.</p>
                            <p class="hobby_description"></p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/brady_apple.png">
                            </div>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/7.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Clea Martin</strong>
                            </p>
                            <p class="user_hobby">Clea's favorite comfort food is her grandma's Cherry Strudel.</p>
                            <p class="hobby_description">It is a flaky, buttery filo dough crust with a caramelized cherry filling with made special sour cherries! She always makes multiple trays for my family and I whenever we visit her in Romania.</p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/clea_chicken.png">
                            </div>
                        </div> 
                    </div>
                    <?php
                endif;
                if ($page == 2):
                    ?>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1509688959_59fc067f478f7.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Kunal Khullar</strong>
                            </p>
                            <p class="user_hobby">Kunal likes to spend time with his kids.</p>
                            <p class="hobby_description">My favorite thing to do outside of work is spend time with my daughter - Kaasni. I think her innocence and sweet talk is an out of world experience.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/^54A8FF015CA2AE515A5756B92BB06F3DC274C9D225BC0C8767^pimgpsh_fullsize_distr.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Phil Dixon</strong>
                            </p>
                            <p class="user_hobby">Phil likes to spend time with his kids.</p>
                            <p class="hobby_description">My kids are tiring and challenging at times but constant sources of entertainment.  I love how they are getting to experience the world (for the first time), wins, losses, heartbreak, learning, its pretty cool.  But challenging, did I say that already?</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/jeff2.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Jeff Baietto</strong>
                            </p>
                            <p class="user_hobby">Jeff likes to spend time with his kids.</p>
                            <p class="hobby_description">Hanging with my son. Being with him, watching him experience something new, hearing his laugh or just holding him, simply transcend my previous definition of happy!</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="../images/varun.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Varun Verma</strong>
                            </p>
                            <p class="user_hobby">Varun has watched a movie more than 30 times.</p>
                            <p class="hobby_description">I love watching movies and I watched the movie Real Steel more than 30 times</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/tushar.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Tushar Watts</strong>
                            </p>
                            <p class="user_hobby">Tushar has not watched a movie more than 30 times.</p>
                            <p class="hobby_description">I rarely watch movies.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="../images/veerdaman.JPG">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>VeerDaman Singh</strong>
                            </p>
                            <p class="user_hobby">Veer Daman has not watched a movie more than 30 times.</p>
                            <p class="hobby_description">I have watched the movie Border more than 20 times in the theater.</p>
                        </div> 
                    </div>
                    <?php
                endif;
                if ($page == 3):
                    ?>
                    <?php //three data end   ?>
                    <?php //second data start      ?>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1520854406_5aa66586cd875.jpeg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Priyanka Sharma</strong>
                            </p>
                            <p class="user_hobby">Try again! Another InJoy Team Member has more siblings.</p>
                            <p class="hobby_description">I have one younger brother. He is doing Mechanical Engineering.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/linda2.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Linda LoRe</strong>
                            </p>
                            <p class="user_hobby">Correct! Linda has the most siblings.</p>
                            <p class="hobby_description">I have 10 siblings, and I'm the 1st born! 10 of us are within 10 years apart, 8 of us are from the same mom and dad, and all of us love each other every much and would do anything for each other.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/ryan.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Ryan Waranauskas</strong>
                            </p>
                            <p class="user_hobby">Try Again! Another InJoy Team Member has more siblings.</p>
                            <p class="hobby_description">My brother and sister are both highly educated--one being a forensic scientist, and the other being a computer engineer. My sister works for the state of Illinois in the CSI department, and my brother is approaching graduation from San Jose University.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1520855914_5aa66b6a555f4.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Varsha Kumari</strong>
                            </p>
                            <p class="user_hobby">Try again! Varsha did not study sociology in college.</p>
                            <p class="hobby_description">I have done my schooling from Hamirpur (Himachal Pradesh). I studied computer science engineering because I love programming and I love to solve problems using computing technology.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/8.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Holly Bennett Etzell</strong>
                            </p>
                            <p class="user_hobby">Try again! Holly did not study sociology in college.</p>
                            <p class="hobby_description">I started in Pre Med, but changed to psychology.  I still have a strong interest in medicine, but psychology felt right.  Growing up in a family of divorce led me to appreciate the importance of psychology & living your relationships with intention.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/1.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Brady Teter</strong>
                            </p>
                            <p class="user_hobby">Correct! Brady studied a form of sociology in college.</p>
                            <p class="hobby_description">I went to the University of Tennessee and studied Industrial Sociology and Labor Relations.</p>
                        </div> 
                    </div>
                    <?php //Ist data end      ?>
                    
                    <?php
                endif;
                if ($page == 4):
                    ?>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1520863913_5aa68aa909cdd.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Sukhdeep Kaur</strong>
                            </p>
                            <p class="user_hobby">Correct! Sukhdeep's favorite holiday is Diwali.</p>
                            <p class="hobby_description">I love diwali festival and always wait for this holiday. Because it is festival of lights, people do home decoration, shopping and gifts for each other. People all get together, wear new clothes and cook delicious dishes which spreads happiness among people.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="../images/varun.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Varun Verma</strong>
                            </p>
                            <p class="user_hobby">Try again! Varun's favorite holiday is not Diwali.</p>
                            <p class="hobby_description">Holi is my favorite holiday. Holi is the festival of colors and this festival signifies the victory of good over evil, the arrival of spring, end of winter, and for many is a festive day to meet others, play and laugh, forget and forgive, and repair broken relationships.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/rakesh.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Rakesh Sanghvi</strong>
                            </p>
                            <p class="user_hobby">Try Again! Rakesh's favorite holiday is not Diwali.</p>
                            <p class="hobby_description">Christmas is one of those holidays you spend with all of your family. You get to see aunts, uncles, cousins and grandparents even more during the holiday season whether you're doing a family dinner or even a family trip somewhere.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/^54A8FF015CA2AE515A5756B92BB06F3DC274C9D225BC0C8767^pimgpsh_fullsize_distr.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Phil Dixon</strong>
                            </p>
                            <p class="user_hobby">Try Again!  Phil did not say that.</p>
                            <p class="hobby_description">I did run with the Bulls in Pamplona, Spain.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1512029219_5a1fbc2342032.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Pradeep Kumar</strong>
                            </p>
                            <p class="user_hobby">Pradeep's favorite thing to do outside of work  is visiting new places.</p>
                            <p class="hobby_description">While I Visit on new places always make me fresh and I feel happy. I love to meet new people and learn about their culture.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/uploads/1509688959_59fc067f478f7.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Kunal Khullar</strong>
                            </p>
                            <p class="user_hobby">Try Again! Kunal did not say that.</p>
                            <p class="hobby_description">My trip to US with my family was special. We got to visit a beautiful country and spend time great people.  My family was with me so it was really special.</p>
                        </div> 
                    </div>
                    <?php
                endif;
                if ($page == 5):
                    ?>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/6.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Elly Bannon</strong>
                            </p>
                            <p class="user_hobby">Elly does not have a cat that sings.</p>
                            <p class="hobby_description">I have 1 pug named, Pearl and 1 cat named Skippy that live in NH and 1 fluffy kitten named Ollie that lives with me here in CA. Ollie just turned 3 and is my registered emotional support pet.</p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/elly_Cats.png">
                            </div>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="http://injoyglobal.com/wp-content/uploads/2017/02/7.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Clea Martin</strong>
                            </p>
                            <p class="user_hobby">Clea has singing cats.</p>
                            <p class="hobby_description">I have two cute and hilarious cats (Miko & Aria). I've had them for about 6 years! My favorite thing about them is that they sing back to me when I'm singing. Miko's favorite song to sing is Hakuna Matata because it sounds like the word "tuna" which he loves!</p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/clea_cats.png">
                            </div>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/veerdaman.JPG">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>VeerDaman Singh</strong>
                            </p>
                            <p class="user_hobby">Veer Daman does not have a cat that sings.</p>
                            <p class="hobby_description">I have a dog who is a German Spitz.</p>
                            <div class="hobby_image">
                                <img alt="user" title="Image" src="/images/verrdamar_dog.png">
                            </div>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/tushar.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Tushar Watts</strong>
                            </p>
                            <p class="user_hobby">Tushar does play cricket.</p>
                            <p class="hobby_description">I enjoy the sportsmanship and aura of the game.</p>
                        </div> 
                    </div>
                    <div class="toolbox-row odd">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/ryan.png">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Ryan Waranauskas</strong>
                            </p>
                            <p class="user_hobby">Ryan's favorite thing to do outside of work  is enjoying play guitar.</p>
                            <p class="hobby_description">I enjoy the freedom of expression and the ability to "speak another language" alongside other musicians. It is a unique bond that has not only created some of my favorite memories, but also ignited some of my closest friendships in my life so far. </p>
                        </div> 
                    </div>
                    <div class="toolbox-row even">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="/images/Abhipray.jpg">
                            </div>
                        </div>
                        <div class="description">
                            <p>
                                <strong>Abhipray Gupta</strong>
                            </p>
                            <p class="user_hobby">Abhipray enjoys spending time with Family.</p>
                            <p class="hobby_description">If you get enough time to spend with you family in you daily routine life you are the luckiest person in the world I try to spend most of my free time with my family. discuss with them how to make personal life better and more enjoyable.</p>
                        </div> 
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        </div>
        <div id="pagination-wrapper"><ul class="pagination">
                <?php if ($prev == 0): ?>
                    <li class="prev disabled">
                        <span aria-hidden="true">&laquo;</span>
                    </li>
                <?php else: ?>
                    <li class="prev"><a data-page="<?php echo $prev - 1; ?>" href="/learning/know-the-team?page=<?= $prev; ?>">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="<?= $class1; ?>"><a data-page="0" href="/learning/know-the-team?page=1">1</a></li>
                <li class="<?= $class2; ?>"><a data-page="1" href="/learning/know-the-team?page=2">2</a></li>
                <li class="<?= $class3; ?>"><a data-page="2" href="/learning/know-the-team?page=3">3</a></li>
                <li class="<?= $class4; ?>"><a data-page="3" href="/learning/know-the-team?page=4">4</a></li>
                <?php if ($total > 24): ?>
                    <li class="<?= $class5; ?>"><a data-page="4" href="/learning/know-the-team?page=5">5</a></li>
                    <?php
                endif;
                if ($total > 30):
                    ?>
                    <li class="<?= $class6; ?>"><a data-page="5" href="/learning/know-the-team?page=6">6</a></li>
                <?php endif; ?>
                <?php if ($next == 0): ?>
                    <li class="next disabled">
                        <span aria-hidden="true">&raquo;</span>
                    </li>
                <?php else: ?>
                    <li class="next"><a data-page="1" href="/learning/know-the-team?page=<?= $next; ?>">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span></a></li>
                <?php endif; ?>
            </ul></div>
    </div>
</div>
<a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up"></i></a>  
</div>
<?php $this->registerJsFile($baseurl . "/js/scroll.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]); ?>
<?php $this->registerJsFile($baseurl . "/js/score.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]); ?>