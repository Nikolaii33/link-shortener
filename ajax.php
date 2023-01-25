<?php
include 'functions.php';

if (isset($_POST['data'])){
    $newLink = $_POST['data'];
    if (empty($newLink)){
        $data = [
            'status' => true,
            'message' => 'Вы не ввели ссылку',
            'link' => '',
        ];
        exit (json_encode($data, JSON_UNESCAPED_SLASHES));
    }

    $link = checkUrl($newLink);
    if ($link){
        $data = [
            'status' => true,
            'message' => 'Такая ссылка уже существует',
            'link' => 'http://' . $_SERVER['SERVER_NAME'] . '/' . $link['token']
        ];
        exit (json_encode($data, JSON_UNESCAPED_SLASHES));
    }
    if ($saveLink = saveLink($newLink)) {
        $data = [
            'status' => true,
            'message' => 'Ссылка сгенерирована',
            'link' => 'http://' . $_SERVER['SERVER_NAME'] . '/' . $saveLink['token'],
        ];
        exit (json_encode($data, JSON_UNESCAPED_SLASHES));
    }
    $data = [
        'status' => false,
    ];
    exit (json_encode($data));
}



