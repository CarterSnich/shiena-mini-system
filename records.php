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
    // delete user
    if (isset($_POST['delete-btn'])) {
        $sql = "DELETE FROM Users WHERE username = :1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':1', $_POST['delete-btn']);

        if ($stmt->execute()) {
            if ($_POST['delete-btn'] === $_SESSION['SAVED_LOGIN']) {
                redirectToPage('index.php');
            } else {
                redirectToPage('records.php');
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

    $sql = "SELECT * FROM Users";
    $stmt =  $conn->prepare($sql);

    if ($stmt->execute()) {
        $rows = $stmt->fetchAll();
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
        div.records {
            margin: auto;
            width: 96vw;
            height: 80vh;
            background-color: #81334950;
            box-shadow: #813349bb 0px 0px 4px 4px;
            padding: 1.25rem;
        }

        hr {
            background-color: aliceblue;
            min-height: 1px !important;
        }

        div.records-table {
            background-color: #ffffffcc;
        }

        div.records-table {
            position: relative;
            bottom: 0;
            overflow-y: hidden;
            flex-grow: 1;
            flex-flow: column;
            display: flex;
        }

        div.rows-wrapper {
            display: flex;
            flex-flow: column;
            flex-grow: 1;
            overflow-y: hidden;
        }

        div.rows-wrapper>div.rows-group {
            padding-block: 0.25rem;
            flex-grow: 1;
            display: flex;
            flex-flow: column;
            overflow-y: scroll;
            row-gap: 0.25rem;
        }

        div.row-item:hover {
            background-color: #eeeeee !important;
            transition: 200ms ease-in-out;
        }
    </style>
</head>

<body class="vh-100 d-flex">
    <div class="records d-flex flex-column">
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
        <h2 class="text-light">Account Records</h2>
        <div class="records-table flex-grow-1">
            <div class="d-flex p-1">
                <h4 class="px-3 m-0">#</h4>
                <div class="d-flex flex-grow-1">
                    <h4 class="w-50 m-0">Full name</h4>
                    <h4 class="w-50 m-0">Username</h4>
                    <h4 class="w-50 m-0">Gender</h4>
                    <h4 class="w-50 m-0">Birthday</h4>
                    <h4 class="w-50 m-0">Address</h4>
                </div>
                <h4 class="ps-3 pe-5 m-0">Action</h4>
            </div>
            <div class="rows-wrapper">
                <div class="rows-group">

                    <?php foreach ($rows as $key => $row) : ?>
                        <div class="row-item d-flex p-1 rounded mx-1 bg-white">
                            <div class="px-3 m-0 my-auto"><?= $key + 1 ?></div>
                            <div class="d-flex flex-grow-1">
                                <div class="w-50 m-0 my-auto"><?= $row['gender'] == 'male' ? 'Mr.' : 'Miss' ?> <?= "$row[firstname] $row[lastname]" ?><?= $_SESSION['SAVED_LOGIN'] === $row['username'] ? '<i class="text-muted"> (Me)</i>' : '' ?></div>
                                <div class="w-50 m-0 my-auto"><?= $row['username'] ?></div>
                                <div class="w-50 m-0 my-auto text-capitalize"><?= $row['gender'] ?></div>
                                <div class="w-50 m-0 my-auto"><?= date("F d, Y", strtotime("$row[year]-$row[month]-$row[day]")) ?></div>
                                <div class="w-50 m-0 my-auto"><?= $row['address'] ?></div>
                            </div>
                            <div class="m-0">
                                <a href="editting-form.php?username=<?= $row['username'] ?>" class="btn btn-primary">Edit</a>
                                <button type="button" class="btn <?= $_SESSION['SAVED_LOGIN'] === $row['username'] ? 'disabled btn-secondary' : 'btn-danger' ?>" <?php if ($_SESSION['SAVED_LOGIN'] !== $row['username']) : ?> data-bs-toggle="modal" data-bs-target="#delete-<?= $row['id'] ?>" <?php endif ?>>
                                    Delete
                                </button>
                            </div>
                        </div>
                    <?php endforeach ?>

                </div>
            </div>
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

    <!-- delete modals -->
    <?php foreach ($rows as $key => $row) : ?>
        <?php if ($row['username'] === $_SESSION['SAVED_LOGIN']) continue; ?>
        <div class="modal fade" id="delete-<?= $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Delete user <span class="text-primary"><?= "$row[firstname] $row[lastname]" ?></span>?
                        </h5>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" name="delete-btn" value="<?= $row['username'] ?>" form="delete-form">Confirm</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <form method="POST" id="delete-form" class="d-none"></form>

    <script src="./assets/bootstrap-5.0.2/js/bootstrap.bundle.js"></script>

    <script>
        (function() {

            document.querySelectorAll('.alert').forEach(function(alert) {
                setTimeout(() => alert.classList.remove('show'), 10000);
            })
        })()
    </script>
</body>

</html>

<?php
unset($_SESSION['REPORT_MSG']);
