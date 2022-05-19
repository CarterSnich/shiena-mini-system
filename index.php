<?php
require_once 'connection/connection.php';
include_once './helpers/utils.php';

unset($_SESSION['SAVED_LOGIN']);

if (isset($_POST['signin-btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT username, password FROM Users WHERE username = :1";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':1', $username);

    try {
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch();
                if (password_verify($password, $row['password'])) {
                    $_SESSION['SAVED_LOGIN'] = $username;
                    redirectToPage('records.php');
                } else {
                    $_SESSION['REPORT_MSG'] = array(
                        'code' => 1,
                        'msg' => 'Incorrect password.',
                        'body' => null
                    );
                }
            } else {
                $_SESSION['REPORT_MSG'] = array(
                    'code' => 1,
                    'msg' => 'Username does not exist.',
                    'body' => null
                );
            }
        } else {
            $_SESSION['REPORT_MSG'] = array(
                'code' => 2,
                'msg' => 'Something happened.',
                'body' => null
            );
        }
    } catch (\Throwable $th) {
        $_SESSION['REPORT_MSG'] = array(
            'code' => 3,
            'msg' => 'Something happened.',
            'body' => $th->getMessage()
        );
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in | Shiena's Mini System</title>
    <link rel="stylesheet" href="./assets/bootstrap-5.0.2/css/bootstrap.css">
    <link rel="stylesheet" href="./assets/css/base.css">
    <style>
        form {
            min-width: 365px;
            background-color: #81334950;
            box-shadow: #813349bb 0px 0px 4px 4px;
        }
    </style>
</head>

<body>
    <div class="d-flex vh-100">

        <form class="m-auto p-5 needs-validation" method="POST" novalidate>


            <div class="mb-3 text-center text-light">
                <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                </svg>
                <h2>Sign in</h2>
            </div>
            <div class="mb-2 d-flex flex-column">
                <input type="text" class="form-control form-control-theme rounded-0 rounded-top border-bottom-0" id="username" name="username" placeholder="Username" required>
                <input type="password" class="form-control form-control-theme rounded-0 rounded-bottom" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-theme" type="submit" name="signin-btn">Sign in</button>
            </div>

            <p class="text-light mt-3">Want to have an account, <a href="registration.php">register now</a>!</p>

        </form>

    </div>

    <div class="alert-container">
        <?php if (isset($_SESSION['REPORT_MSG'])) : ?>
            <div class="mx-auto alert alert-<?= ($_SESSION['REPORT_MSG']['code'] == 0) ? 'success' : (($_SESSION['REPORT_MSG']['code'] == 1) ? 'warning' : 'danger') ?> alert-dismissible fade show shadow-lg" role="alert">
                <?= $_SESSION['REPORT_MSG']['msg'] ?>
                <?= $_SESSION['REPORT_MSG']['body'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>
    </div>


    <script src="assets/bootstrap-5.0.2/js/bootstrap.bundle.js"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);

            document.querySelectorAll('.alert').forEach(function(alert) {
                setTimeout(() => alert.classList.remove('show'), 10000);
            })
        })();
    </script>
</body>

</html>

<?php


unset($_SESSION['REPORT_MSG']);
