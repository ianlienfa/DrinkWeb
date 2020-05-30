<div class='container'>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: white;">
        <a class="navbar-brand" href="#">
            <img src="picture/logo.jpg" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">主頁</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#list">店家一覽</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">留言</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">回報問題</a>
                </li>
            </ul>
            <ul class="navbar-nav justify-content-right">
                <?php
                    require_once "/opt/lampp/htdocs/DrinkWeb/control/login_status.php";
                    if (isset($_COOKIE['login'])){
                        echo '<li class="nav-item">
                        <img style="height: 40px; width: 40px; border-radius: 50%;"/>
                        <span style="margin-left: 10px; ">Username</span>
                    </li>';
                    }else{
                        echo '<li class="nav-item">
                        <a class="nav-link" href="#">登入</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">註冊</a>
                    </li>';
                    }
                ?>
            </ul>
        </div>
    </nav>    
</div>