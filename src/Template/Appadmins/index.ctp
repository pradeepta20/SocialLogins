<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>css/developer_style.css">
<div class="page-content">   
    <?php if ($this->request->session()->read('Auth.User.type') == 2) { ?>

        <div class="user-profile" id="user-profile-2">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-18">
                    <li class="active">
                        <?php if (!empty($userTwitterInformation->user_id)) { ?>
                            <a class="tick_icon" href="#home" data-toggle="tab" aria-expanded="true">
                                <i class="navy blue ace-icon fa fa-twitter-square bigger-120"></i>
                                Twitter
                            </a>
                        <?php } else { ?>
                            <a style="cursor: pointer;" href="<?php echo HTTP_ROOT . 'twitterlogin'; ?>">
                                <i class="navy blue ace-icon fa fa-twitter-square bigger-120"></i>
                                Twitter
                            </a>
                        <?php } ?>
                    </li>
                    <!--
                    <li class="">
                        <?php if (!empty($userInstagramInformation->user_id)) { ?>
                            <a class="tick_icon" href="#pictures" data-toggle="tab" aria-expanded="false">
                                <i class="pink ace-icon fa fa-instagram bigger-120"></i>
                                Instagram
                            </a>
                        <?php } else { ?>                        
                            <a style="cursor: pointer;" href="<?php echo HTTP_ROOT . 'instgramlogin'; ?>" >
                                <i class="pink ace-icon fa fa-instagram bigger-120"></i>
                                Instagram
                            </a>
                        <?php } ?>
                    </li>
                    -->
                    <li class="">
                        <?php if (!empty($userfacebookInformation->user_id)) { ?>
                            <a class="tick_icon" href="#feed" data-toggle="tab" aria-expanded="false">
                                <i class="blue ace-icon fa fa-facebook-square bigger-120"></i>
                                Facebook
                            </a>
                        <?php } else { ?>
                            <a style="cursor: pointer;" href="<?php echo HTTP_ROOT . 'fblogin'; ?>">
                                <i class="blue ace-icon fa fa-facebook-square bigger-120"></i>
                                Facebook
                            </a>
                        <?php } ?>
                    </li>

                    <li class="">
                        <?php if (!empty($usergoogleInformation->user_id)) { ?>
                            <a class="tick_icon" href="#friends" data-toggle="tab" aria-expanded="false">
                                <i class="red ace-icon fa fa-google-plus-square bigger-120"></i>
                                Google+
                            </a>
                        <?php } else { ?>
                            <a style="cursor: pointer;" href="<?php echo HTTP_ROOT . 'googlelogin'; ?>">
                                <i class="red ace-icon fa fa-google-plus-square bigger-120"></i>
                                Google+
                            </a>
                        <?php } ?>  
                    </li>

                    <!---LinkedIn --->

                    <!--
                    <li class="">
                        <?php if (!empty($userlinkedinInformation->user_id)) { ?>
                            <a class="tick_icon" href="#linkedin" data-toggle="tab" aria-expanded="false">
                                <i class="steel blue ace-icon fa fa-linkedin-square bigger-120"></i>
                                LinkedIn
                            </a>
                        <?php } else { ?>
                            <a style="cursor: pointer;" href="https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id=<?php echo CLIENT_ID; ?>&redirect_uri=<?php echo CALLBACK_URL; ?>&state=81p5zrubn6nwzySTFi9onjjZc9FmXm&scope=r_basicprofile r_emailaddress">
                                <i class="steel blue ace-icon fa fa-linkedin-square bigger-120"></i>
                                LinkedIn
                            </a>
                        <?php } ?>  
                    </li>
                    -->



                </ul>

                <div class="tab-content no-border padding-24">
                    <div class="tab-pane active" id="home">
                        <?php if (!empty($userTwitterInformation)) { ?>
                            <div class="row"> 
                                <h4 class="blue">
                                    <span class="middle">Twitter Information</span>
                                </h4>
                                <div class="col-xs-12 col-sm-9"> 
                                    <div class="profile-user-info">

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> UserID </div>

                                            <div class="profile-info-value">
                                                <span><?php echo ($userTwitterInformation->twitter_id) ? $userTwitterInformation->twitter_id : ''; ?></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Name </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userTwitterInformation->name; ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Username </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userTwitterInformation->screen_name; ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> User Handle </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userTwitterInformation->user_handle; ?></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Join Date</div>

                                            <div class="profile-info-value">
                                                <span><?php echo ($userTwitterInformation->created_at) ? date('F j Y', strtotime($userTwitterInformation->created_at)) : ''; ?></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Location </div>

                                            <div class="profile-info-value">
                                                <i class="fa fa-map-marker light-orange bigger-110"></i>
                                                <span><?php echo $userTwitterInformation->location; ?></span>                                            
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Description </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userTwitterInformation->description; ?></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Followers </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userTwitterInformation->followers; ?></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Following </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userTwitterInformation->following; ?></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Tweets </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userTwitterInformation->tweet_count; ?></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Favorites</div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userTwitterInformation->favourites_count; ?></span>
                                            </div>
                                        </div>

<!--                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Retweets</div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userTwitterInformation->retweet_count; ?></span>
                                            </div>
                                        </div>-->

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Profile Image </div>

                                            <div class="profile-info-value">
                                                <span><img src="<?php echo ($userTwitterInformation->profile_image) ? HTTP_ROOT . DIR_TWITTER_IMAGE . $userTwitterInformation->profile_image : HTTP_ROOT . 'img/no-image.jpg'; ?>"></span>
                                            </div>
                                        </div>
                                        <div class="space space-4"></div>

                                    </div>


                                </div>                       
                            </div>
                        <?php } else { ?>
                            <h5 style="color: red;text-align: center;">No record found!!!</h5>
                        <?php } ?>


                        <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">                  
                            <?php if (count($userTwitterInformation->tweets) > 0) { ?>
                                <table class="table table-striped table-bordered table-hover dataTable no-footer DTTT_selectable" id="dynamic-table" role="grid" aria-describedby="dynamic-table_info">
                                    <thead>
                                        <tr>                                    
                                            <th>Tweet ID</th>
                                            <th>Tweet Content</th>
                                            <th>Favorites</th>
                                            <th>Retweet</th>
                                            <th>Hashtags</th>
                                            <th>Date & Time of Tweet</th>

                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php foreach ($userTwitterInformation->tweets as $tweet) { ?>
                                            <tr>
                                                <td><?php echo $tweet->tweet_id; ?></td>
                                                <td><?php echo $tweet->tweet_content; ?></td>
                                                <td><?php echo $tweet->favorite_count; ?></td>
                                                <td><?php echo $tweet->retweet_count; ?></td>
                                                <td><?php echo $tweet->hashtags; ?></td>
                                                <td><?php echo ($tweet->date_of_tweet) ? date('M j, Y H:i:s A', strtotime($tweet->date_of_tweet)) : ''; ?></td>
                                            </tr>

                                        <?php } ?>


                                    </tbody>
                                </table>
                            <?php } ?>                            

                        </div>
                        <div style="margin-top:10px;">
                            <a class="twitter_button" href="<?php echo HTTP_ROOT . 'twitterlogin'; ?>">                                        
                                Fetch Again From Twitter
                            </a>
                        </div> 
                        <div class="hr hr-8 dotted"></div>

                        <div class="space-20"></div>
                    </div>
                    <div class="tab-pane" id="pictures">
                        <?php if (!empty($userInstagramInformation)) { ?>
                            <div class="row"> 
                                <h4 class="blue">
                                    <span class="middle">Instagram Information</span>
                                </h4>
                                <div class="col-xs-12 col-sm-9"> 
                                    <div class="profile-user-info">                                       
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Username </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userInstagramInformation->username; ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Fullname </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userInstagramInformation->full_name; ?></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Bio </div>

                                            <div class="profile-info-value">                                               
                                                <span><?php echo $userInstagramInformation->bio; ?></span>                                            
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Website </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userInstagramInformation->website; ?></span>
                                            </div>
                                        </div>


                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Profile Image </div>

                                            <div class="profile-info-value">
                                                <span><img style="width: 80px;height: 80px;" src="<?php echo ($userInstagramInformation->profile_image) ? HTTP_ROOT . DIR_INSTAGRAM_IMAGE . $userInstagramInformation->profile_image : HTTP_ROOT . 'img/no-image.jpg'; ?>"></span>
                                            </div>
                                        </div>
                                        <div class="space space-4"></div>

                                    </div>

                                    <a class="instagram_button" href="<?php echo HTTP_ROOT . 'instgramlogin'; ?>">                                        
                                        Fetch Again From Instagram
                                    </a>

                                    <div class="hr hr-8 dotted"></div>
                                </div>                       
                            </div>
                        <?php } else { ?>
                            <h5 style="color: red;">No record found!!!</h5>
                        <?php } ?>
                        <div class="space-20"></div>                       
                    </div>
                    <div class="tab-pane" id="feed">
                        <?php if (!empty($userfacebookInformation)) { ?>
                            <div class="row"> 
                                <h4 class="blue">
                                    <span class="middle">Facebook Information</span>
                                </h4>
                                <div class="col-xs-12 col-sm-9"> 
                                    <div class="profile-user-info">

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> UserID </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userfacebookInformation->facebook_id; ?></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Name </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userfacebookInformation->name; ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Email </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userfacebookInformation->email; ?></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Gender </div>

                                            <div class="profile-info-value">                                               
                                                <span><?php echo $userfacebookInformation->gender; ?></span>                                            
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Age Range </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $userfacebookInformation->age_range; ?></span>
                                            </div>
                                        </div>

                                        <!--                                        <div class="profile-info-row">
                                                                                    <div class="profile-info-name"> First Name </div>
                                        
                                                                                    <div class="profile-info-value">
                                                                                        <span><?php echo $userfacebookInformation->first_name; ?></span>
                                                                                    </div>
                                                                                </div>
                                        
                                                                                <div class="profile-info-row">
                                                                                    <div class="profile-info-name"> Last Name </div>
                                        
                                                                                    <div class="profile-info-value">
                                                                                        <span><?php echo $userfacebookInformation->last_name; ?></span>
                                                                                    </div>
                                                                                </div>-->
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Profile Image </div>

                                            <div class="profile-info-value">
                                                <span><img src="<?php echo ($userfacebookInformation->picture) ? HTTP_ROOT . DIR_FACEBOOK_IMAGE . $userfacebookInformation->picture : HTTP_ROOT . 'img/no-image.jpg'; ?>"></span>
                                            </div>
                                        </div>
                                        <div class="space space-4"></div>

                                    </div>

                                    <a class="facebook_button" href="<?php echo HTTP_ROOT . 'fblogin'; ?>">                                        
                                        Fetch Again From Facebook
                                    </a>

                                    <div class="hr hr-8 dotted"></div>
                                </div>                       
                            </div>
                        <?php } else { ?>
                            <h5 style="color: red;text-align: center;">No record found!!!</h5>
                        <?php } ?>
                    </div>
                    <div class="tab-pane" id="friends">
                        <?php if (!empty($usergoogleInformation)) { ?>
                            <div class="row"> 
                                <h4 class="blue">
                                    <span class="middle">Google Plus Information</span>
                                </h4>
                                <div class="col-xs-12 col-sm-9"> 
                                    <div class="profile-user-info">
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Name </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $usergoogleInformation->name; ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Email </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $usergoogleInformation->email; ?></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Gender </div>

                                            <div class="profile-info-value">                                               
                                                <span><?php echo $usergoogleInformation->gender; ?></span>                                            
                                            </div>
                                        </div>


                                        <!--                                        <div class="profile-info-row">
                                                                                    <div class="profile-info-name"> First Name </div>
                                        
                                                                                    <div class="profile-info-value">
                                                                                        <span><?php echo $userfacebookInformation->first_name; ?></span>
                                                                                    </div>
                                                                                </div>-->

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Link </div>

                                            <div class="profile-info-value">
                                                <span><?php echo $usergoogleInformation->link; ?></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Profile Image </div>

                                            <div class="profile-info-value">
                                                <span><img style="width: 50px;" src="<?php echo ($usergoogleInformation->picture) ? HTTP_ROOT . DIR_GOOGLEPLUS_IMAGE . $usergoogleInformation->picture : HTTP_ROOT . 'img/no-image.jpg'; ?>"></span>
                                            </div>
                                        </div>


                                        <div class="space space-4"></div>

                                    </div>

                                    <a class="google_button" href="<?php echo HTTP_ROOT . 'googlelogin'; ?>">                                        
                                        Fetch Again From Google+
                                    </a>

                                    <div class="hr hr-8 dotted"></div>
                                </div>                       
                            </div>
                        <?php } else { ?>
                            <h5 style="color: red;text-align: center;">No record found!!!</h5>
                        <?php } ?>
                    </div>

                    <div class="tab-pane" id="linkedin">
                        <h5 style="color: red;text-align: center;">No record found!!!</h5>
                    </div>

                </div>
            </div>
        </div>
    <?php } else { ?>
        <div><h3>
                <?php echo $this->Custom->getTime($this->request->session()->read('Auth.User.created')); ?>
            </h3></div>
    <?php } ?>

</div>
</div>
</div>


