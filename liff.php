<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p id="isLoggedIn"><b>isLoggedIn:</b> </p>
    <p id="userId"><b>userId:</b></p>
    <button id="btnLogOut" onclick="logOut()">Log Out</button>

    <!-- <script src="https://static.line-scdn.net/liff/edge/2.1/liff.js"></script> -->
    <script src="https://static.line-scdn.net/liff/edge/versions/2.5.0/sdk.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script>

        function logOut() {
            liff.logout()
            window.location.reload()
        }


        async function getUserProfile() {
            const profile = await liff.getProfile()
            document.getElementById("userId").append(profile.userId)
            // var userID = document.getElementById("userId").append(profile.userId);
            
            const uid = document.getElementById('userId').value;
            var Data = new FormData();

            Data.append('userID', uid);

            $.ajax({
                url: 'https://line-chatbot-icute-interns-php.herokuapp.com/order_home.php',
                type: 'POST',
                dataType: 'json',
                data: Data,
                cache: false,
                contentType: false,
                processData: false,
                succuss: function (res) {

                }
            });
            
        }
        async function main() {
            await liff.init({ liffId: "1655607383-lza4vpZb" })
            document.getElementById("isLoggedIn").append(liff.isLoggedIn())
            // if(liff.isInCilent()) {
            //     document.getElementById("btnLogOut").style.display = "none"
            // }
            if(liff.isLoggedIn()) {
                getUserProfile()
            } else {
                liff.login()
            }
        }
        main()
    </script>
</body>
</html>