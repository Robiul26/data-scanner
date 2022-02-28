<?php

$connect = new mysqli('localhost', 'root', '', 'scanner');

// if ($connect) {
//     echo "<script>alert('database connected')</script>";
// } else {
//     echo "<script>alert('database not connected')</script>";
// }

if (isset($_POST['text'])) {
    $text = $_POST['text'];

    $query = "INSERT INTO users(user_id, time)VALUES('$text', NOW())";
    $result = $connect->query($query);

    // if ($result) {
    //     echo "<script>alert('Data saved success')</script>";
    // } else {
    //     echo "<script>alert('Data not saved')</script>";
    // }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robiul</title>
    <script src="./assets/js/instascan.min.js"></script>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <section class="body-section">
        <div class="header">
            <h2>Data Scanner</h2>
        </div>
        <div class="main-section">
            <div class="scanner-section">
                <video id="camId"></video>
                <form action="" method="POST">
                    <input id="outputId" name="text" type="text" style="display: none;">
                </form>
            </div>
            <div class="data-list-scetion">
                <table>
                    <tr>
                        <th>Serial</th>
                        <th>User ID</th>
                        <th>Time</th>
                    </tr>

                    <?php
                    $query = 'SELECT * FROM users';
                    $query = $connect->query($query);
                    if ($query->num_rows > 0) {
                        while ($row = $query->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row['id'] . "</td>
                                    <td>" . $row['user_id'] . "</td>
                                    <td>" . $row['time'] . "</td>
                        </tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
        <footer>
            <p>By <a href="https://web.facebook.com/robiidb">Robiul Robi</a> &copy; 2022</p>
        </footer>
    </section>


    <script type="text/javascript">
        let scanner = new Instascan.Scanner({
            video: document.getElementById('camId')
        });

        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function(e) {
            console.error(e);
        });

        scanner.addListener('scan', function(content) {
            document.getElementById('outputId').value = content;
            document.forms[0].submit();
            var audio = new Audio('./assets/sound/camera-shutter.mp3');
            audio.play();
        });
    </script>
</body>

</html>