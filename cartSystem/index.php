
<?php

include('assets/init.php');

if(isset($_POST['submit'])){
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = mysqli_query($sqlConnect,"SELECT * FROM users WHERE username='$username' AND password='$password'");

    if(mysqli_num_rows($query) > 0){

        $result = mysqli_fetch_assoc($query);

        setcookie("authenticationCartSystem", $result['user_id'], time() + (10 * 365 * 24 * 60 * 60));
    
    }else{

        echo "<span style='color:red;'>No user or not correct u and p</span>";
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"
        integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA=="
        crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            color: white;
        }

        .cart {
            height: 75vh;
            background-color: grey;


        }

        .products {
            height: 75vh;
            background-color: dodgerblue;

        }
    </style>
</head>

<body>
    <div class="cart" id="cart">
        THIS IS CART SECTION
    </div>

    <div class="products" id="product">
        THIS IS PRODUCT SECTION

    </div>

    <div id="login">

        <form method="post">

            username <input type="tex" name="username" />
            password <input type="text" name="password" />
            <input type="submit" name="submit">login</input>

        </form>

    </div>
</body>

<script>
    function ajaxFetcher(type) {

        $.get('requests.php' + "?f=" + type, {

        }, function (data) {

            if (data.status == 200) {

                if (type == 'cart') {

                    $('#cart').html(data.html);
                }
                if (type == 'getProduct') {

                    $('#product').html(data.html);
                }
                if (type == 'login') {

                    $('#login').html(data.html);
                }
            } else {

                alert('Something WENT extremely Wrong');
            }

        });
    }

    function cart(type, id, count) {

        $.ajax({
            type: "POST",
            url: "requests.php?f=updateCart&s=" + type,

            data: {
                "id": id,
                "count": count
            },

            dataType: 'JSON',

            success: function (data) {

                if (data.status == 200) {

                    app_start();
                }

            }
        });

    }

    function app_start() {

        ajaxFetcher('getProduct');
        ajaxFetcher('cart');

    }


    window.onload = app_start;
</script>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

</html>