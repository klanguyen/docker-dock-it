<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dock It</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato&family=Rancho&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body { font-family: Lato, sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: Rancho, cursive; }
        h1 { font-size: 5em; margin-bottom: 0; text-shadow: 0 .2rem .5rem var(--blue); }
        .bg-black { background-color: #232323; border-bottom: 5px solid var(--blue);}

    </style>
</head>
<body class="vh-100">
<div class="d-flex align-items-start flex-column h-100">

    <div class="text-center sticky-top shadow-lg p-2 w-100 text-light bg-black">
        <h1>Dock It</h1>
        <a href="phpinfo.php" target="content_frame" class="px-2">PHP Info</a> |
        <a href="funflix.php" target="content_frame" class="px-2">PHP Final</a>
    </div>
    <iframe src="phpinfo.php" name="content_frame" class="w-100 flex-grow-1 border-0"></iframe>
</div>
</body>
</html>