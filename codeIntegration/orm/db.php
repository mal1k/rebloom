<?php
require 'rb.php';

R::setup( 'mysql:host=localhost;dbname=rebloom',
        'db', '2O8k5V6p' );

// Если после пароля поставить true, тогда функция создания таблиц на лету будет включена
// Если после пароля поставить false, тогда функция создания таблиц на лету будет отключена

// Проверка подключения к БД
if(!R::testConnection()) die('database connect error!');