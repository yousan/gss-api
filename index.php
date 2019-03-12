<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GSS API</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
<div class="main">
    Googleスプレッドシート(GSS)をREST APIのGETっぽく使えるようにするゲートウェイ。<br>
    GSSの共有URLを入力すると、RESTで取得できるURLを生成します。<br>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">GSS URL</span>
        </div>
        <input type="text" id="url" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default"
               placeholder="https://docs.google.com/spreadsheets/d/1m4BI7R-CcjNREH4DUe1xCM3OIVVSGrGx6-7iUtIvUWE/edit#gid=635058114"
               value="https://docs.google.com/spreadsheets/d/1m4BI7R-CcjNREH4DUe1xCM3OIVVSGrGx6-7iUtIvUWE/edit#gid=635058114"
        >
    </div>

    <button type="button" id="convert-button" class="btn btn-outline-secondary">GET API</button>

    <div>
        <textarea id="output-url" class="form-control" aria-label="With textarea"></textarea>
    </div>

    <div>
        <textarea class="form-control" aria-label="With textarea"></textarea>
    </div>
</div>
</body>
<script src="dist/main.js"></script>
</html>