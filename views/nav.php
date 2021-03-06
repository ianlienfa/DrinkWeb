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
                    <a class="nav-link" href="#intro">主頁</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#list">店家一覽</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#info">留言一覽</a>
                </li>
                <li class="nav-item">
                <a href="comment.php" class="nav-link" style="cursor: pointer;">留言</a>                </li>
            </ul>
            <ul class="navbar-nav justify-content-right">
                <?php
                    if (isset($_COOKIE['login'])){
                        $db= new DBController();
                        $conn=$db->connectDB();
                        $row=getUser($conn, $_COOKIE['login']);
                        echo '<li class="nav-item">
                        <div class="crop" style="width: auto;height: auto;overflow: hidden;">';
                        if ($row[1]!=null&&$row[2]!=null){
                            echo '<img id="userimg" style="height: 40px; width: 40px;     object-fit: cover;
                            object-position: center;border-radius: 50%;" src="data:'.$row[1].';base64,'.base64_encode($row[0]).'"/>';
                        }else{
                            echo '<img id="userimg" style="height: 40px; width: 40px;     object-fit: cover;
                            object-position: center;border-radius: 50%;" src="picture/profile.png"/>';
                        }
                        echo '<span style="margin-left: 10px; line-height: 40px;">'.$row[2].'</span></div>
                        </li><li class="nav-item">
                        <a class="nav-link" href="reset_passwd.php">修改密碼</a>
                        </li><li class="nav-item">
                        <a class="nav-link" href="logout.php">登出</a>
                        </li>';
                    }else{
                        echo '<li class="nav-item">
                        <a class="nav-link" href="login.php">登入</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">註冊</a>
                    </li>';
                    }
                ?>
            </ul>
        </div>
    </nav>    
</div>