<?php

function connectDb():void
{
    mysqli_report(MYSQLI_REPORT_OFF);

    $link = @mysqli_connect('localhost', 'fake_user', 'wrong_password', 'does_not_exist');

    if (!$link) {
        file_put_contents('mysql.log','Ошибка при подключении: ' . mysqli_connect_error(). "\n", FILE_APPEND);
    }

    //TODO добавить ниже код для загрузки данных в бд
}