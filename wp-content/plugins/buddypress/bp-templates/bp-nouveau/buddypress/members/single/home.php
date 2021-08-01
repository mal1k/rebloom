<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/codeIntegration/orm/db.php';
$postName = $_POST['name'];
$postSurname = $_POST['surname'];
$userID = get_current_user_id();
session_start();
if (isset($_POST['session'])){
    unset($_SESSION['passOfReg']);
    exit;
}
if ( isset($_POST['editProfileSave']) ) { # if pressed save button

    $searchEmail = R::findAll('rebloom_users', "user_email = ? AND id != ?", [$email, $userID]);

    if ( $searchEmail != null ) { // if email exist
        $errors[] = 'This email is already in use';
    }

    if ( empty($_POST['name']) && empty($_POST['surname']) && empty($_POST['email']) ) { // if not inputs used
        $errors[] = 'All inputs are required';
    }


    if ( empty($errors) ) {

        R::exec("
        UPDATE `rebloom_usermeta` SET
            `meta_value` = '$postName'
        WHERE meta_key = 'first_name' AND user_id = $userID");

        R::exec("
        UPDATE `rebloom_usermeta` SET
            `meta_value` = '$postSurname'
        WHERE meta_key = 'last_name' AND user_id = $userID");

        $args = array(
            'ID'         => $userID,
            'user_email' => esc_attr( $email )
        );
        wp_update_user( $args );

        header('Location: '.$_SERVER['REQUEST_URI']);

    }

}

if (isset($_POST['repeatPassword'])) {
    wp_set_password($_POST['repeatPassword'], $userID);
}

?>
<style type="text/css">
    .button_choice_pass div{
        width: 50%;
        text-align: center;
    }
    .button_choice_pass .submit_login_form{
        width: 85%;
    }
</style>
<div id="wrapper">
    <div class="lal"></div>
    <?php  require $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/masterstudy-child/navi.php' ;?>

	<?php bp_nouveau_member_hook( 'before', 'home_content' ); ?>
	<div id="item-header" role="complementary" data-bp-item-id="<?php echo esc_attr( bp_displayed_user_id() ); ?>" data-bp-item-component="members" class="users-header single-headers">

		<?php //bp_nouveau_member_header_template_part(); ?>

	</div><!-- #item-header -->
<div class="container">
    <div class="post_type_exist clearfix">
    
    <div class="stm-lms-wrapper">
    <div class="container">
        


<div class="row">

    <div class="col-md-3 col-sm-12">

		
<div class="stm_lms_user_side">

    <!-- <div class="stm-lms-user-avatar-edit">
        <?php $my_avatar = get_user_meta($userID, 'stm_lms_user_avatar', true); ?>
        <input type="file"/>
        <?php if (!empty($my_avatar)): ?>
            <i class="lnricons-cross delete_avatar"></i>
        <?php endif; ?>
        <i class="lnricons-pencil"></i>
        <?php if (!empty($current_user['avatar'])): ?>
            <div class="stm-lms-user_avatar">
                <?php echo wp_kses_post($current_user['avatar']); ?>
            </div>
        <?php endif; ?>
    </div> -->

        <div class="stm-lms-user-avatar-edit">
            <div class="file-data">
                <label for="change-photo"><img src="<?php echo $my_avatar; ?>" style="border-radius: 50px; object-fit: cover; width: 75px; height: 75px;" class="rounded-circle mt- shadow-xl preload-img playerPhoto"></label>
                <input type="file" style="display:none;" class="upload-file bg-highlight shadow-s rounded-s " accept="image/*" id="change-photo">
            </div>
        </div>


    <div class="stm_lms_profile_buttons_set 44">
        <div class="stm_lms_profile_buttons_set__inner">

            
            
            
<div class="stm-lms-user_edit_profile_btn active" data-container=".stm_lms_edit_account">
	<a href="#">
        <i class="fa fa-cog"></i>
        <span>Edit profile</span>
    </a>
    </div>
            
        </div>
    </div>

</div>
    </div>

    <div class="col-md-9 col-sm-12">

        <div class="stm_lms_private_information" data-container-open=".stm_lms_private_information">
          

			
<div class="stm_lms_user_info_top" style="display: none;">
	<!--<h1>Kira Belousova</h1>-->
    <?php $user_info = $user_id ? new WP_User( $user_id ) : wp_get_current_user();?>
    <h1><?php echo $user_info->first_name . ' ' . $user_info->last_name; ?></h1>
	<?php echo $user_info->ID;?>
<div class="stm_lms_user_info_top__socials">
													</div>
</div>
			
      <div class="stm_lms_user_body_parameters">
    
    
    </div>
        </div>

		
<div data-container-open=".stm_lms_edit_account" style="display: block;">



        <div id="stm_lms_edit_account" class="stm_lms_edit_account">
            <div class="stm_lms_user_info_top"><h1>Edit Profile</h1></div>

            <?php
            
            if ( isset($_POST['editProfileSave']) ) { # if pressed save button
                if ( !empty($errors) ) {
                    echo '<font color="red">' . $errors[0] . "</font>";
                }
            }

            ?>
        <form method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <label class="heading_font">Name</label>
                    <input name="name" placeholder="Enter your name" pattern="^[a-zA-Z]+$" title="Use only letters" value="<?php echo $user_info->first_name; ?>" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="heading_font">Surname</label>
                        <input name="surname" placeholder="Enter your last name" pattern="^[a-zA-Z]+$" title="Use only letters" value="<?php echo $user_info->last_name; ?>" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="heading_font">Email</label>
                        <input name="email" placeholder="Enter your email" value="<?php echo $user_info->user_email; ?>" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-n3">
                    <button name="editProfileSave" class="btn btn-save">
                        <span>Save changes</span>
                    </button>
                </div>
                <div class="col-md-12"></div>
            </div>
        </form>
        
        <?php
        $user_login_page = explode('/', $_SERVER['REQUEST_URI']);
        $current_user = wp_get_current_user();
        if($current_user->user_nicename == $user_login_page[2]){?>
            <form class="change_pass" method="post" action="">
                <div class="stm_lms_edit_socials">
                    <div class="row">
                        <div class="col-md-12 mt-5">
                        <h3>Change Password</h3>
                        </div>
                    </div>
                    <div class="stm_lms_edit_socials_list">
                        <div class="button_choice_pass">
                            <h3>Do you want to save this password or create a new one?</h3>
                            <div style="float:right"><input type="button" value="Save" class="submit_login_form save_password"></div>
                            <div><input type="button" value="Create" class="submit_login_form create_password"></div>
                        </div>
                        <div class="row" style="display:none">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="heading_font">New Password</label>
                                    <div class="form-group-social">
                                        <input name="password" placeholder="Enter your New Password" type="password" class="form-control password_create">
                                        <i class="fa fa-key"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="heading_font">Re-type new password</label>
                                    <div class="form-group-social">
                                        <input type="password" name="repeatPassword" placeholder="Enter your new password" class="form-control repeatPassword_create">
                                        <i class="fa fa-key"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(!empty ($_SESSION['passOfReg'])){?>
                            <div class="row save_password" style="display: none">
                                <h3 style="float: left;line-height: 25px;padding: 0;margin: 0;">Your password:</h3>
                                <input value="<?php echo $_SESSION['passOfReg'];?>" disabled="disabled" style="text-align: center;font-size: 18px;">
                            </div>
                        <?php } ?>
                        <div class="error_message stm-lms-message error" style="display: none;">Passwords don't match</div>
                        <input type="submit" value="Create" style="display: none;" class="submit_login_form create_password_submit" />
                    </div>
                </div>
            </form>
        <?php } ?>
</div>
</div>
    </div>

</div>    </div>
</div>


    
	<div id="buddypress">
		<?php if ( ! bp_nouveau_is_object_nav_in_sidebar() ) : ?>
        <div id="item-nav">
			<?php bp_get_template_part( 'members/single/parts/item-nav' ); ?>
        </div>
        
		<?php endif; ?>

		<div id="item-body" class="item-body">

        



        <div id="item-body">

        
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active">
        <a href="https://rebloom.world/members/kira/#my-courses" data-toggle="tab">My Courses</a>
    </li>
</ul>

<div class="tab-content">

    <div role="tabpanel" id="my-courses" class="tab-pane vue_is_disabled active is_vue_loaded">
        <h1 class="page-title">Courses</h1>
        <div style="position:relative;">
        <h3>Activate purchase</h3>
            <form class="submitCode" method="POST" onsubmit="return false" style="margin: 0 0 1% 2%;">
                <input placeholder='Please enter code' name="typedCode" class="simple-field-data-mask" style="padding-left: 15px; outline:none; background: aliceblue; border-radius:50px; position:absolute; z-index:1;height: 45px; width:200px;" type="text"></input>
                <input name="courseId" type="hidden" value="<?php echo $_product->id; ?>"></input>
                <input name="userId" type="hidden" value="<?php echo $user_id; ?>"></input>
                <button name="buttonAccessCode" type="submit" style="width: 50px; z-index: 2; height: 45px; top: 0px; right: -180px; position: relative; background: rgb(229, 120, 93); border-radius: 0px 50px 50px 0px;" style="position:relative!important; top:0; right:0; height: 45px; width:45px;">
                <i class="icon ion-android-arrow-forward"></i><b style="color: #ffffff!important;">OK</b></button> <div style="color:red" class="class_error"></div>
            </form>
        </div>
    <div>
        <?php
          # Get information of bought courses
            $user_id = get_current_user_id();
            $current_user= wp_get_current_user();
            $customer_email = $current_user->email;
            $customer_phone = $current_user->user_login;

            $args = array(
                'post_type' => 'stm-courses',
                'posts_per_page' => 12
                );
            // $orderIds = $wpdb->get_results("SELECT post_id FROM rebloom_postmeta WHERE meta_value = $user_id AND meta_key = '_customer_user'");

            $orderFound = R::findOne('rebloom_user_related_data', 'phone = ?', [$customer_phone]);
            $orderIds = explode(',', $orderFound->courseIds);

            if ( empty($orderIds[0]) ) {
                echo ( 'No courses' );
            }
            if ( $orderIds[0] != null ) :

                foreach ($orderIds as $orderId) :

                    ?>
                    
                    <div class="stm-lms-user-courses col-sm-4">
                        <div class="stm_lms_instructor_courses__grid">
                            <div class="stm_lms_instructor_courses__single">
                            <div class="stm_lms_instructor_courses__single__inner">
                                <div class="stm_lms_instructor_courses__single--image">
                                    <div data-image="https://storage.googleapis.com/rebloom-media-bucket/2020/09/6f193ad9-ba-main.jpg" data-preview="https://storage.googleapis.com/rebloom-media-bucket/2018/08/eec3313d-full-course.gif" class="course__img">
                                    <?php echo get_the_post_thumbnail($orderId); ?>
                                    </div>
                                </div>
                                <div class="stm_lms_instructor_courses__single--inner">
                                    <div class="stm_lms_instructor_courses__single--terms"></div>
                                        <div class="stm_lms_instructor_courses__single--title">
                                                <h5 style="font-size: 24px;"><?php echo get_the_title($orderId);// echo $orderId; ?></h5>
                                        </div>
                                        <div class='mb-3'>
                                            <?php  if ( get_the_excerpt($orderId) != null ) {
                                                echo get_the_excerpt($orderId);
                                            } else {
                                                echo "This course don't have description";
                                            } ?>
                                        </div>
                                        <!--
                                        <div class="stm_lms_instructor_courses__single--progress">
                                            <div class="stm_lms_instructor_courses__single--progress_top">
                                                <div class="stm_lms_instructor_courses__single--completed">
                                                0% Complete
                                                </div>
                                            </div>
                                            <div class="stm_lms_instructor_courses__single--progress_bar">
                                                <div class="stm_lms_instructor_courses__single--progress_filled" style="width: 0%;">
                                                </div>
                                            </div>
                                        </div>
                                        -->
                                        <div class="stm_lms_instructor_courses__single--enroll">
    
                                        <div class="d-flex justify-content-between">
    
                                    <!-- if course is active -->
                                        <?php                             
                                        $findCourseCode = R::findOne('codes', 'status = 1 AND user_id = ?', [get_current_user_id()]);
                                        if ( isset($findCourseCode) ) { ?>
                                            <!--<a href="<?php echo $httpsProtocol . $_SERVER['SERVER_NAME']?>/courses/rebloom-full-course/<?php echo $orderId; ?>" class="btn__courses">
                                                <span>Start Course</span>
                                            </a>-->
    
                                            <a href="<?php echo get_permalink( $orderId ) . '#curriculum'; ?>" class="btn__courses">
                                                <span>Start Course</span>
                                            </a>
    
                                        <div class="stm_lms_instructor_courses__single--started d-flex justify-content-between flex-direction-column">
                                            <span style="color: rgb(0, 0, 0); text-align: right; font-size: 17px;">Active</span>
                                            <!--<a href="<?php echo $httpsProtocol .  $_SERVER['SERVER_NAME']?>/courses/rebloom-full-course/<?php echo $orderId; ?>" style="text-decoration: underline !important; text-transform: capitalize;">
                                                View all lessons
                                            </a>-->
    
                                    
                                        </div>
    
                                    <!-- if course is locked -->
                                        <?php
                                        } 
                                        else { ?>
    
                                        <!--<div style="position:relative;">
                                            <form method="POST">
                                            <input name="typedCode" class="simple-field-data-mask" style="padding-left: 15px; outline:none; background: aliceblue; border-radius:50px; position:absolute; z-index:1;height: 45px; width:150px;" type="text"></input>
                                            <input name="courseId" type="hidden" value="<?php echo $_product->id; ?>"></input>
                                            <input name="userId" type="hidden" value="<?php echo $user_id; ?>"></input>
                                            <button name="buttonAccessCode" type="submit" style="width: 50px; z-index: 2; height: 45px; top: 0px; right: -130px; position: relative; background: rgb(229, 120, 93); border-radius: 0px 50px 50px 0px;" style="position:relative!important; top:0; right:0; height: 45px; width:45px;"><i class="icon ion-android-arrow-forward"></i><b style="color: #ffffff!important;">OK</b></button>
                                            </form>
                                        </div>-->
    
                                            <div class="stm_lms_instructor_courses__single--started d-flex justify-content-between flex-direction-column">
                                                <span style="color: rgb(0, 0, 0); text-align: right; font-size: 17px;">Locked</span>
                                            </div>
    
                                        <?php } ?>
    
                                        </div>
                                    </div>
                                </div>
    
                            </div>
                            </div>
                        </div>
                    </div></div>
            
    
                <?php endforeach; ?>

            <?php endif; ?>

    </div>
	
  </div>
  
</div>

    <?php // bp_nouveau_member_template_part(); 



    

    ?>

		</div><!-- #item-body -->
	</div><!-- // .bp-wrap -->
	<?php bp_nouveau_member_hook( 'after', 'home_content' ); ?>
</div><!-- // .bp-wrap -->
</div><!-- // .bp-wrap -->
</div><!-- // .bp-wrap -->
<script>

    <?php
     if (isset($_SERVER['HTTPS']))
        $protocol = $_SERVER['HTTPS'];
    else
        $protocol = '';

    if (($protocol) && ($protocol != 'off')) $protocol = 'https://';
    else $protocol = 'http://';

    //$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
    $nameOfServer = $_SERVER['HTTP_HOST']; ?>
    var url = "<?php echo $protocol . $nameOfServer ?>";
    url = url+'/wp-content/plugins/buddypress/bp-templates/bp-nouveau/buddypress/members/single/code_validate.php';
    
    jQuery(function($){
        $(document).on('submit','.submitCode', function(){
            $.ajax(url,{
                type: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: (data)=>{
                    if(data.status){
                        location.reload();
                    }
                    else{
                        $('.class_error').text(data.error);
                    }
                },
                error: function(xhr, textStatus, error){
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                }
            })
        })
    })

    jQuery(document).on('click','.button_choice_pass .submit_login_form', _=>{
        var $_save_pas = jQuery('div').is('.save_password');
        
        

        if($_save_pas){
            jQuery.ajax({
                type: 'post',
                data: {'session': 1}
            });
        }
    })

    jQuery(document).on('mousedown','.submit_login_form', function() {
        jQuery(this).css({'outline': 'none', 'box-shadow': 'inset 0 6px 7px 0px #00000040'});
    });

    jQuery(document).on('click', '.button_choice_pass .create_password', function() {
        $_this = jQuery(this).parents(".button_choice_pass");
        $_this.hide("slow");
        $_this.siblings('.row').show("slow");
    });

    jQuery(document).on('click', '.button_choice_pass .save_password', function() {
         var $_save_pas = jQuery('div').is('.save_password');
        if($_save_pas){
            $_this = jQuery(this).parents('.button_choice_pass');
            $_this.hide("slow");
            $_this.siblings('.save_password').show("slow");
        }
        else{
            $_this = jQuery(this).parents(".stm_lms_edit_socials");
            $_this.hide("slow");
        }
    });


    jQuery(document).on('keyup', '.repeatPassword_create, .password_create', function(){
        var $_error_message = jQuery('.error_message');
        if(jQuery(this).val().length >= 8){
            $_error_message.text('');
            $_error_message.css({"display":"none"});
            if(jQuery('.repeatPassword_create').val().length >= 8 && jQuery('.password_create').val().length >= 8) {
                if (jQuery('.repeatPassword_create').val() == jQuery('.password_create').val())
                    jQuery('.create_password_submit').css({"display": "block"});
                else $_error_message.text('Passwords don\'t match');
            }
        }
        else if(jQuery(this).val().length == 0)
            $_error_message.text('At least one of the rows is empty.');
        else $_error_message.text('The minimum password length is 8 characters.');
        if($_error_message.text().length != 0){
            $_error_message.css({"display":"block"});
            jQuery('.create_password_submit').css({"display": "none"});
        }
    });


 var uploadFile = $('.upload-file');
        function activate_upload_file(){
            function readURL(input) {
                if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                        $('.file-data img').attr('src', e.target.result);
                        $('.file-data img').attr('class','rounded-circle mt- shadow-xl preload-img');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(".upload-file").change(function(e) {
                readURL(this);
                var fileName = e.target.files[0].name;
                $('.upload-file-data').removeClass('disabled');
                $('.upload-file-name').html(e.target.files[0].name)
                $('.upload-file-modified').html(e.target.files[0].lastModifiedDate);
                $('.upload-file-size').html(e.target.files[0].size/1000+'kb')
                $('.upload-file-type').html(e.target.files[0].type)
            });
        };
        if(uploadFile.length){activate_upload_file();}
</script>