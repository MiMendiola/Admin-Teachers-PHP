<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404</title>
    <style>
        html {
            height: 100%;
        }

        body {  
            height: 100%;
            background: url("https://wallpapercave.com/wp/6SLzBEY.jpg") no-repeat left top;
            background-size: cover;  
            overflow: hidden;
                
            display: flex;
            flex-flow: column wrap;
            justify-content: center;
            align-items: center;
        }

        .iamg {
            height: 100%;
            width: 100%;
            background: url("https://i.makeagif.com/media/9-20-2015/vzCUY-.gif") no-repeat;
            background-size: contain;  

        }
        .text h1{
            color: #011718;
            margin-top: -200px;
            font-size: 15em;
            text-align: center;
            text-shadow: -5px 5px 0px rgba(0,0,0,0.7), -10px 10px 0px rgba(0,0,0,0.4), -15px 15px 0px rgba(0,0,0,0.2);
            font-family: monospace;
            font-weight: bold;
        }

        .text h2{
        color: grey;
        font-size: 5em;
        text-shadow: -5px 5px 0px rgba(0,0,0,0.7);
        text-align: center;
        margin-top: -150px;
        font-family: monospace;
        font-weight: bold;
        }
        .text h3{
            color: white;
            margin-left: 30px;
            font-size: 2em;
            text-shadow: -5px 5px 0px rgba(0,0,0,0.7);
            margin-top: -40px;
            font-family: monospace;
            font-weight: bold;
        }
        .torch {
            margin: -150px 0 0 -150px;
            width: 300px;
            height: 300px;
            box-shadow: 0 0 0 9999em #000000f7;
            opacity: 1;
            border-radius: 50%;
            position: fixed;
            background: rgba(0,0,0,0.3);
        }
        .torch:after {
            content: '';
            display: block;
            border-radius: 50%;
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            box-shadow: inset 0 0 40px 2px #000, 0 0 20px 4px rgba(13,13,10,0.2);  
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

    <script>
        $(document).mousemove(function (event) {
            $('.torch').css({
                'top': event.pageY,
                'left': event.pageX
            });
        });
    </script>
</head>
<body>
    <div class="text">
    <div class="iamg"></div>
        <h1>401</h1>
            <h2>You didn't say the magic world!</h2>
        <h3>Sorry Missing Permisions. You shald not pass.</h3>
    </div>
    <div class="torch">
    </div>
</body>
</html>










