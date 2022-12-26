<header class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h1>
                    <a href="<?php echo BASE_URL ?>">Tested site</a>
                </h1>
            </div>
            <nav class="col-8">
                <ul>
                    <li><a href="#">Главная</a></li>
                    <li><a href="#">О нас</a></li>
                    <li><a href="#">Услуги</a></li>
                    <li>
                        <?php if (isset($_SESSION['id'])): ?>
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <?php echo $_SESSION['login']; ?>
                            </a>
                            <ul>
                                <li><a href="<?php echo BASE_URL . "logout.php" ?>">Exit</a></li>
                                <li><a href="<?php echo BASE_URL . "password_change.php" ?>">Change Password</a></li>
                            </ul>
                        <?php else:?>
                            <a href="<?php echo BASE_URL . "authorization.php" ?>">
                                <i class="fa fa-user"></i>
                                Sing in
                            </a>
                            <ul>
                                <li><a href="<?php echo BASE_URL . "registration.php" ?>">Registration</a></li>
                            </ul>
                        <?php endif; ?>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>