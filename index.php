<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="./style/bootstrap.css">
    <script src="./scripts/assets/bootstrap.js"></script>
    <link rel="stylesheet" href="./style/style.css">
</head>

<body>

    <?php
    $admin = false;

    if ($admin) {
        require_once(__DIR__ . '/router.php');
    } else { ?>
        <div class="login_form">
            <form class="row g-3">
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputEmail4">
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Password</label>
                    <input type="password" class="form-control" id="inputPassword4">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </div>
            </form>
        </div>
    <?php } ?>

</body>

</html>