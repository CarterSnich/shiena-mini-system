<?php
require_once './connection/connection.php';
include_once './helpers/utils.php';


if (isset($_POST['register-btn'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    if ($_POST['month'] + 5 > 12) {
        $month = ($_POST['month'] + 5) - 12;
    } else {
        $month = $_POST['month'] + 5;
    }
    $day = $_POST['day'];
    $year = $_POST['year'];

    $sql = "SELECT id FROM Users WHERE username = :1";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':1', $username);

    try {
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $_SESSION['REPORT_MSG'] = array(
                    'code' => 1,
                    'msg' => 'Username already exist',
                    'body' => null
                );
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);

                $sql =
                    "INSERT INTO Users (
                        firstname,
                        lastname,
                        username,
                        password,
                        address,
                        gender,
                        month,
                        day,
                        year
                    ) 
                    VALUES (:1, :2, :3, :4, :5, :6, :7, :8, :9)";
                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':1', $firstname);
                $stmt->bindParam(':2', $lastname);
                $stmt->bindParam(':3', $username);
                $stmt->bindParam(':4', $hashed);
                $stmt->bindParam(':5', $address);
                $stmt->bindParam(':6', $gender);
                $stmt->bindParam(':7', $month);
                $stmt->bindParam(':8', $day);
                $stmt->bindParam(':9', $year);

                if ($stmt->execute()) {
                    $_SESSION['SAVED_LOGIN'] = $username;
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
    <title>Register | Shiena's Mini System</title>
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

        <form class="d-flex m-auto p-5 needs-validation w-75" method="POST" novalidate>

            <div class="mx-5 my-auto text-center text-light">
                <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                </svg>
                <h2 class="mt-3">Registration</h2>
            </div>

            <div class="ms-5 me-3 text-light">

                <div class="row">

                    <div class="col">
                        <div class="mb-2">
                            <label for="firstname">First name</label>
                            <input type="text" name="firstname" id="firstname" class="form-control form-control-theme" required>
                        </div>
                        <div class="mb-2">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control form-control-theme" required>
                        </div>
                    </div>

                    <div class="col">
                        <div class="mb-2">
                            <label for="lastname">Last name</label>
                            <input type="text" name="lastname" id="lastname" class="form-control form-control-theme" required>
                        </div>
                        <div class="mb-2">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control form-control-theme" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-2">
                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" class="form-control form-control-theme" required>
                        </div>
                    </div>

                    <div class="col">
                        <div class="mb-2">
                            <label for="firstname">Gender</label>
                            <select type="text" name="gender" id="gender" class="form-control form-control-theme" required>
                                <option value="">Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="col">
                        <div class="mb-2">
                            <label for="firstname">Birthday</label>
                            <div class="d-flex form-control form-control-theme datepicker">
                                <select type="text" name="month" id="month" class="flex-grow-1" required>
                                    <option value="" disabled selected>Month</option>
                                    <?php for ($month = 1; $month <= 12; $month++) : ?>
                                        <option value="<?= $month ?>"><?= date("F", mktime(0, 0, 0, $month, 10)) ?></option>
                                    <?php endfor ?>
                                </select>
                                <select type="text" name="day" id="day" class="flex-grow-1" required>
                                    <option value="" disabled selected>Day</option>
                                </select>
                                <select type="text" name="year" id="year" class="flex-grow-1" required>
                                    <option value="" disabled selected>Year</option>
                                    <?php
                                    $range = 22;
                                    $currentYear = date("Y");
                                    for ($year = $currentYear; $year >= $currentYear-$range; $year--) : ?>
                                        <option value="<?= $year ?>"><?= $year ?></option>
                                    <?php endfor ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="d-grid my-3">
                    <button class="btn btn-theme" type="submit" name="register-btn">Register</button>
                </div>

                <p class="text-light text-center mt-3 mb-0">Already have an account, <a href="index.php">sign in here</a>!</p>
            </div>
        </form>

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
    </div>
</body>

</html>

<?php unset($_SESSION['REPORT_MSG']) ?>