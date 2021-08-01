<?php
    require( $_SERVER['DOCUMENT_ROOT'].'/wp-load.php' );
    require_once $_SERVER['DOCUMENT_ROOT']. '/codeIntegration/orm/db.php';

# Try to find the code that the user entered
if(!isset($_POST['typedCode']))
   header("Location: /");
   
    if ( isset($_POST['typedCode']) ) { # if code is typed
        $findOneCode = R::findOne('codes', 'code = ? AND user_id is null', [ $_POST['typedCode'] ]);
        # Enter the USER and COURSE id who used it.
        if ( isset($findOneCode) ) { # if not exists in database
            # compare code
            if ($findOneCode['code'] == $_POST['typedCode']) { # if codes compare true

                global $current_user;

                $findCoursesInDB = R::findOne('rebloom_user_related_data', 'phone = ?', [$current_user->user_login]);
                $userUpdateRB = R::load('codes', $findOneCode['id']);

                    $userUpdateRB->userId = get_current_user_id();
                    $userUpdateRB->status = 1;
                
                    R::store( $userUpdateRB );
                
                //header('Location: ' . get_permalink( $_POST['courseId'] ) );
                $response = [
                    "status"  => true,
                ];
                echo json_encode($response);
                exit; 
            } else {
                $response = [
                    "status"  => false,
                    "error" => 'Check your code on case sensitive.',
                ];
                echo json_encode($response);
                exit; 
            } 

        } else { 
            $response = [
                "status"  => false,
                "error" => 'Invalid or used code. Please try again.',
            ];
            echo json_encode($response);
            exit; 
        } 
    }
    
?>