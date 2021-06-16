<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>403 Access Forbidden!</title>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Press+Start+2P');

        html,
        body {
            width: 100%;
            height: 100vh;
            margin: 0;
        }

        * {
            font-family: 'Press Start 2P', cursive;
            box-sizing: border-box;
        }

        #app {
            padding: 1rem;
            background: black;
            display: flex;
            height: 100%;
            justify-content: center;
            align-items: center;
            color: #54FE55;
            text-shadow: 0px 0px 10px;
            font-size: 6rem;
            flex-direction: column;

        }

        .txt {
            font-size: 1.8rem;
        }

        @keyframes blink {
            0% {
                opacity: 0
            }

            49% {
                opacity: 0
            }

            50% {
                opacity: 1
            }

            100% {
                opacity: 1
            }
        }

        a {
            text-decoration: none;
            margin-top: 25px;
            font-size: 25px;
            color: #00FF41;
        }

        .blink {
            animation-name: blink;
            animation-duration: 1s;
            animation-iteration-count: infinite;
        }
    </style>
</head>

<body>

    <div id="app">
        <div>403</div>
        <div class="txt">
            Access Forbidden<span class="blink">_</span>
        </div>
        <a class="link" href="<?= base_url(); ?>">Go back!</a>
    </div>
</body>

</html>