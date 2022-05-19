<?php

require_once './connection//connection.php';
include_once './helpers/utils.php';

if (!isset($_SESSION['SAVED_LOGIN'])) {
    $_SESSION['REPORT_MSG'] = array(
        'code' => 1,
        'msg' => 'Please, sign in first',
        'body' => null
    );
    redirectToPage('index.php');
}

try {
    if (isset($_POST['update-btn'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];
        if ($_POST['month'] + 5 > 12) {
            $month = ($_POST['month'] + 5)-12;
        } else {
            $month = $_POST['month'] + 5;
        }
        $day = $_POST['day'];
        $year = $_POST['year'];

        // check if username exists
        $sql = "SELECT id FROM Users WHERE username != :1 AND username = :2";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':1', $_GET['username']);
        $stmt->bindParam(':2', $username);

        // update details
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $_SESSION['REPORT_MSG'] = array(
                    'code' => 1,
                    'msg' => 'Username already used.',
                    'body' => null
                );
            } else {
                $sql =
                    "UPDATE Users 
                    SET 
                        firstname = :1, 
                        lastname = :2, 
                        username = :3,
                        address = :4,
                        gender = :5,
                        month = :6,
                        day = :7,
                        year = :8
                    WHERE 
                        username = :9";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':1', $firstname);
                $stmt->bindParam(':2', $lastname);
                $stmt->bindParam(':3', $username);
                $stmt->bindParam(':4', $address);
                $stmt->bindParam(':5', $gender);
                $stmt->bindParam(':6', $month);
                $stmt->bindParam(':7', $day);
                $stmt->bindParam(':8', $year);
                $stmt->bindParam(':9', $_GET['username']);

                if ($stmt->execute()) {
                    if ($_GET['username'] === $_SESSION['SAVED_LOGIN']) {
                        $_SESSION['SAVED_LOGIN'] = $username;
                    }
                    $_SESSION['REPORT_MSG'] = array(
                        'code' => 0,
                        'msg' => 'Successfully updated.',
                        'body' => null
                    );
                    redirectToPage('records.php');
                } else {
                    $_SESSION['REPORT_MSG'] = array(
                        'code' => 2,
                        'msg' => 'Something happened.',
                        'body' => null
                    );
                }
            }
        } else {
            $_SESSION['REPORT_MSG'] = array(
                'code' => 2,
                'msg' => 'Something happened.',
                'body' => null
            );
        }
    }

    // get user fullname
    $sql = "SELECT CONCAT(firstname, ' ', lastname) AS fullname FROM Users WHERE username = :1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':1', $_SESSION['SAVED_LOGIN']);

    if ($stmt->execute()) {
        $result = $stmt->fetch();
        $fullname = $result['fullname'];
    } else {
        $_SESSION['REPORT_MSG'] = array(
            'code' => 2,
            'msg' => 'Something happened.',
            'body' => null
        );
    }

    // get user data
    $sql = "SELECT * FROM Users WHERE username = :1";
    $stmt =  $conn->prepare($sql);
    $stmt->bindParam(':1', $_GET['username']);

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            $userData = $stmt->fetch();
        } else {
            $_SESSION['REPORT_MSG'] = array(
                'code' => 1,
                'msg' => 'Username does not exist.',
                'body' => null
            );
            redirectToPage('records.php');
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records | Shiena's Mini System</title>
    <link rel="stylesheet" href="./assets/bootstrap-5.0.2/css/bootstrap.css">
    <link rel="stylesheet" href="./assets/css/base.css">
    <style>
        div.editting {
            margin: auto;
            width: 80vw;
            height: 80vh;
            background-color: #81334950;
            box-shadow: #813349bb 0px 0px 4px 4px;
            padding: 1.25rem;
        }

        hr {
            background-color: aliceblue;
            min-height: 1px !important;
        }

        div.editting-form {
            background-color: #ffffffcc;
        }
    </style>
</head>

<body class="vh-100 d-flex">
    <div class="editting d-flex flex-column">
        <div class="d-flex justify-content-between">
            <div class="d-inline-flex text-light">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                </svg>
                <h2 class="ms-3 my-auto">Shiena's Mini System</h2>
            </div>

            <div class="dropdown my-auto">
                <button class="btn btn-theme dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                    </svg>
                    <span><?= $fullname ?></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="index.php">Sign out</a></li>
                </ul>
            </div>
        </div>
        <hr>
        <h2 class="text-light">Edit Account</h2>
        <div class="editting-form flex-grow-1 p-3">

            <form class="needs-validation" method="POST" novalidate>
                <div class="row">
                    <div class="col-4 mb-3">
                        <label for="firstname">First name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?= $userData['firstname'] ?>" required>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="lastname">Last name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?= $userData['lastname'] ?>" required>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $userData['username'] ?>" required>
                    </div>
                    <div class="col-8 mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?= $userData['address'] ?>" required>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="username">Gender</label>
                        <select name="gender" id="gender" class="form-control" required>
                            <option disabled selected>Select gender</option>
                            <option value="male" <?= $userData['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                            <option value="female" <?= $userData['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>

                    <div class="col-4 mb-3">
                        <label for="username">Birthday</label>
                        <div class="d-flex gap-1">
                            <select class="form-control" name="month" id="month">
                                <option value="" disabled selected>Month</option>
                                <?php for ($month = 1; $month <= 12; $month++) : ?>
                                    <option value="<?= $month ?>" <?= $userData['month'] == $month ? 'selected' : '' ?>><?= date("F", mktime(0, 0, 0, $month, 10)) ?></option>
                                <?php endfor ?>
                            </select>
                            <select class="form-control" name="day" id="day">
                                <option value="" disabled selected>Day</option>
                                <?php for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $userData['month'], $userData['year']); $day++) : ?>
                                    <option value="<?= $day ?>" <?= $userData['day'] == $day ? 'selected' : '' ?>><?= $day ?></option>
                                <?php endfor ?>
                            </select>
                            <select class="form-control" name="year" id="year">
                                <option value="" disabled selected>Year</option>
                                <?php
                                $range = 22;
                                $currentYear = date("Y");
                                for ($year = $currentYear; $year >= $currentYear-$range; $year--) : ?>
                                    <option value="<?= $year ?>" <?= $userData['year'] == $year ? 'selected' : '' ?>><?= $year ?></option>
                                <?php endfor ?>
                            </select>
                        </div>
                    </div>

                </div>
                <button class="btn btn-primary" type="submit" name="update-btn">Update</button>
                <a href="records.php" class="btn btn-secondary" type="submit">Back</a>
            </form>

        </div>

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


    <script src="assets/jQuery/jquery-3.6.0.min.js"></script>
    <script src="./assets/bootstrap-5.0.2/js/bootstrap.bundle.js"></script>
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

            $('select#year, select#month').on('change', function() {
                const year = $('select#year').val();
                const month = $('select#month').val();
                const daysOfMonth = new Date(year, month, 0).getDate();

                $('select#day').html('<option value="" disabled selected>Day</option>');
                for (let day = 1; day <= daysOfMonth; day++) {
                    $('select#day').append(`<option value="${day}">${day}</option>`);
                }
            })

            document.querySelectorAll('.alert').forEach(function(alert) {
                setTimeout(() => alert.classList.remove('show'), 10000);
            })
        })();
    </script>
</body>

</html>

<?php unset($_SESSION['REPORT_MSG']);
