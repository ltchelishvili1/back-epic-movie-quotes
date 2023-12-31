@props(['url', 'name'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
    <style>
        @media only screen and (min-width: 600px) {
            #body {
                box-sizing: border-box;
                width: 100% !important;
                height: 100vh;
                margin: 0;
                padding: 79px 194px;
                background-color: black;
            }

            img {
                width: 22px;
                height: 20px;
                margin-left: 48%;
            }

            h1 {
                margin-bottom: 73px;
                font-weight: 900;
                font-size: 12px;
                color: #DDCCAA;
                font-weight: 500;
                margin-left: 45%;
            }

            p {
                color: #FFFFFF;
                font-weight: 400;
                font-size: 16px;
            }

            button {
                background: #E31221;
                border-radius: 4px;
                padding: 7px 13px;
                font-size: 16px;
                color: #FFFFFF;
                border: none;
                font: inherit;
                outline: inherit;
                margin-top: 27px;
                margin-bottom: 35px;
            }

            a {
                color: white !important;
                text-decoration: none;
            }

            .url {
                color: #DDCCAA;
                margin-top: 24px;
                margin-bottom: 30px;
                word-break: break-all;
            }

            .problem {
                margin-bottom: 28px;
            }

            .hi {
                margin-bottom: 24px;
            }
        }

        @media only screen and (max-width: 500px) {
            #body {
                box-sizing: border-box;
                width: 100%;
                margin: 0;
                padding: 50px 35px;
                background-color: black;
            }

            img {
                width: 22px;
                height: 20px;
                margin-left: 51%;
            }

            h1 {
                margin-bottom: 26px;
                font-weight: 900;
                font-size: 12px;
                color: #DDCCAA;
                font-weight: 500;
                margin-left: 37%;
            }

            p {
                color: #FFFFFF;
                font-weight: 400;
                font-size: 16px;
            }

            button {
                background: #E31221;
                border-radius: 4px;
                padding: 7px 13px;
                font-size: 16px;
                color: #FFFFFF;
                border: none;
                font: inherit;
                outline: inherit;
                margin-top: 8px;
                margin-bottom: 12px;
            }

            a {
                color: white !important;
                text-decoration: none;
            }

            .url {
                color: #DDCCAA;
                margin-top: 8px;
                margin-bottom: 12px;
                max-width: 60vw;
                word-break: break-all;
            }

            .problem {
                margin-bottom: 12px;
            }

            .crew {
                padding-bottom: 50px;
            }
        }
    </style>
</head>

<body id=body>
    <img src="https://i.postimg.cc/8JL0bT3L/Vector.png" class="dialog" alt="dialog">
    <h1>{{__('validation.movie_quotes')}}</h1>

    <p .class="hi">{{__('validation.hello')}} {{ucwords($name)}}</p>
    <p>{{__('validation.thanks_for_reset')}}
    </p>
    <a href="{{$url}}"><button>
            {{__('validation.reset_password')}}

        </button></a>
    <p>{{__('validation.if_click_fails')}}</p>
    <p class="url">{{$url}}</p>
    <p class="problem">{{__('validation.have_any_problems')}}</p>
    <p class="crew">{{__('validation.moviequotes.crew')}}</p>
</body>

</html>