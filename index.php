<?php

include 'functions.php';

if (mb_strlen($_SERVER['REQUEST_URI']) > 1) {
    $token = mb_substr($_SERVER['REQUEST_URI'], 1);
    $link = getLinkByToken($token);
    $errorPage = '';
    if (!$link) {
        $errorPage = 'Вы пытаетесь перейти на несуществующую страницу';
    }
    updateLink($token);
    header("location:" . $link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сократитель ссылок</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <style>
        a{
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container text-center" >
    <?php if(isset($errorPage) && mb_strlen($errorPage) > 0) { ?>
        <div class="errorPage" style="margin-top: 20px;"><strong style="color: red"><?php echo $errorPage ?></strong></div>
    <?php } ?>
    <h1 style="margin-top: 10%">Сократитель ссылок</h1>
    <form action="" method="post">
    <div class="input-group mb-3" style="margin-top: 30px">
        <input name="link"id="link" type="text" class="form-control" placeholder="Вставьте ссылку сюда" >
        <button name="submit"class="btn btn-outline-secondary" type="button" id="shortLink">Сгенерировать</button>
    </div>
</form>
    <div class="message"></div>
    <div class="gen-link"></div>
    <div class="errors" style="color: red"></div>
</div>
</body>
<script>
    $('#shortLink').on('click', function (e) {
        e.preventDefault();
        let link = $('#link').val();
        $.ajax({
            type: "POST",
            url: 'ajax.php',
            data: {data: link},
            success: function (response) {
                let data = JSON.parse(response);
                let $errorsContainer = $('.errors');
                if (data.status) {
                    let $messageContainer = $('.message');
                    let $linkContainer = $('.gen-link');
                    let $errorPageContainer = $('.errorPage');
                    $errorsContainer.text('');
                    $messageContainer.text('');
                    $linkContainer.empty();
                    $errorPageContainer.empty();
                    $messageContainer.text(data.message)
                    $linkContainer.append(`<a href="${data.link}" target="_blank">${data.link}</a>`)
                }else{
                    $errorsContainer.text('Ошибка');
                }

            }
        });
    })

</script>
</html>

