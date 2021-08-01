<?php

require 'orm/db.php';

?>


<?php
/*

Generating codes

*/

    # Get file by name
    ini_set('auto_detect_line_endings',TRUE);
    $handle = fopen('codes/codes.csv','r');

    # Insert all codes
    while ( ($data = fgetcsv($handle) ) !== FALSE ) {

      # If csv have row with 'license key' text - ignore
        if ( $data[4] != 'license_key' ) {
        
            # Create or get table
              $codes = R::dispense('codes');

            # Adding code
              $codes->code = $data[4];
              $codes->userId = null;
              $codes->courseId = null;
    
            # Saving the table
            R::store($codes);                                    
        
        }

    }
    ini_set('auto_detect_line_endings',FALSE);

?>

Done.