<div class="container-fluid ps-0">
    <img class="vw-100 vh-5" src="img/sushi_header.png" alt="Afbeelding van sushi">
</div>
<nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark">
    <div class="row container-fluid ps-0 ps-3">
        <div class="col-4"></div>
        <a class="col-1 navbar-brand ps-3 text-bright-red" href="index.php">ZuZu</a>
        <div class="col-1 collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <!--                Unable to fix the undefined error due to the fact I cannot define them in this file.-->
                <!--                By trying to define them, the use of them for outside the include file becomes nullified due to the fact-->
                <!--                that it overwrites the variable I used outside the include file.-->
                <li class="nav-item">
                    <a class="nav-link <?= $navHomeClass; ?>" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $navSushiClass; ?>" href="sushi_orders.php">Sushi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $navOverviewClass; ?>" href="order_overview.php">Besteloverzicht</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $navInfoClass; ?>" href="customer_info.php">Klantgegevens</a>
                </li>
            </ul>
        </div>
        <div class="col-5"></div>
    </div>
</nav>