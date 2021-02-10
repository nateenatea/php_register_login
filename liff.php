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
    <img id="pictureUrl">
    <p id="userId"><b>userId:</b></p>
    <p id="statusMessage"><b>statusMessage:</b></p>
    <p id="displayName"><b>displayName:</b></p>
    <p id="decodedIDToken"><b>email:</b></p>
    <button id="btnLogOut" onclick="logOut()">Log Out</button>

    <!-- <script src="https://static.line-scdn.net/liff/edge/2.1/liff.js"></script> -->
    <script src="https://static.line-scdn.net/liff/edge/versions/2.5.0/sdk.js"></script>

    <script>

        function logOut() {
            liff.logout()
            window.location.reload()
        }


        async function getUserProfile() {
            const profile = await liff.getProfile()
            document.getElementById("pictureUrl").src = profile.pictureUrl
            document.getElementById("userId").append(profile.userId)
            document.getElementById("statusMessage").append(profile.statusMessage)
            document.getElementById("displayName").append(profile.displayName)
            document.getElementById("decodedIDToken").append(liff.getDecodedIDToken().email)
            
        }
        async function main() {
            await liff.init({ liffId: "1655607383-lza4vpZb" })
            document.getElementById("isLoggedIn").append(liff.isLoggedIn())
            if(liff.isInCilent()) {
                document.getElementById("btnLogOut").style.display = "none"
            }
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