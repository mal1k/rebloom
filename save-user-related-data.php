<?php


define('MYSQL_HOST', 'mysql');
define('MYSQL_USER', 'root');
define('MYSQL_PASSWORD', 'rootpwJjdjhhdj@@UHJ@j2@JHJH!');
define('MYSQL_DB', 'wordpress');


$xToken     = "HSDhdy24hg23g232342==";
$auth       = false;
$connection = null;

foreach (getallheaders() as $name => $value) {
    if (($name == "X-Token" || $name == "X-token") && ($value == $xToken)) {
        $auth = true;
    }
}


if ($auth) {

    $json = file_get_contents("php://input");

    $data = json_decode($json, true);
    $json = json_encode($data);


    /// -----

    $connection = mysqli_connect(
        MYSQL_HOST,
        MYSQL_USER,
        MYSQL_PASSWORD,
        MYSQL_DB
    );

    if (empty($connection)) {
        file_put_contents("mysql-errors.log", "Can't establish connection with MySQL server\n", FILE_APPEND);
        return false;
    }

    if ($connection) {

        $data['order_id']          = !empty($data['order_id']) ? $data['order_id'] : null;
        $data['external_order_id'] = !empty($data['external_order_id']) ? $data['external_order_id'] : null;
        $data['phone']             = !empty($data['phone']) ? $data['phone'] : null;
        $data['cod_amount']        = !empty($data['cod_amount']) ? $data['cod_amount'] : null;
        $data['course_ids']        = !empty($data['course_ids']) ? $data['course_ids'] : null;
        $data['webmaster_id']      = !empty($data['webmaster_id']) ? $data['webmaster_id'] : null;
        $data['advertiser_id']     = !empty($data['advertiser_id']) ? $data['advertiser_id'] : null;
        $data['address']           = !empty($data['address']) ? $data['address'] : null;

        $result = mysqli_query(
            $connection,
            "INSERT INTO`rebloom_user_related_data`(`id`,
                        `order_id`,
                        `external_order_id`,
                        `phone`,
                        `cod_amount`,
                        `course_ids`,
                        `webmaster_id`,
                        `advertiser_id`,
                        `address`,
                        `created_at`,
                        `status`) VALUES (NULL,"
            . "'" . $data['order_id'] . "',"
            . "'" . $data['external_order_id'] . "',"
            . "'" . $data['phone'] . "',"
            . "'" . $data['cod_amount'] . "',"
            . "'" . implode(",", $data['course_ids']) . "',"
            . "'" . $data['webmaster_id'] . "',"
            . "'" . $data['advertiser_id'] . "',"
            . "'" . $data['address'] . "',"
            . "'" . date("Y-m-d H:i:s", strtotime("NOW")) . "',"
            . "1)"
        );

        file_put_contents("request.log", date("Y-m-d H:i:s", strtotime("NOW")) . " - ok - " . $json . "\n", 8);
    } else {
        file_put_contents("request.log", date("Y-m-d H:i:s", strtotime("NOW")) . " - error saving to mysql - " . $json . "\n", 8);
    }

    ///-------


    $json = json_encode(['status' => true, 'code' => 200, 'message' => 'Data accepted successful', 'data' => $data]);

    http_response_code(200);
    echo $json;

} else {

    $json = json_encode(['status' => false, 'code' => 401, 'message' => 'Please specify access token']);
    http_response_code(401);
    echo $json;

}