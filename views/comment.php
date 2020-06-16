<?php 
require_once "/opt/lampp/htdocs/DrinkWeb/include/include.php";
require_once dirname(__FILE__)."/js/commentjs.php";
?>
<link rel="stylesheet" href="css/comment.css">
<link rel="stylesheet" href="//at.alicdn.com/t/font_1356455_c5d3d3ohlbq.css">
<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">


<div class="card container" id="commentdiv" style="display: none;">
    <div class="row text-right">
        <div class="col">
            <button id="close" onclick="closecommentbtn()"></button>
        </div>
    </div>
    <div class="row">
        <h1 class="col" style="font-size: 30px; ">為 <b>麻古茶坊</b> 評價</h1>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col" >
            <img id="storeimg"/>
            <span style="font-size: 25px; margin-left: 10px;">麻古茶坊 信義永吉店</span>
        </div>
    </div>
    <div class="row" style="margin-top: 20px; text-align: center;">
        <div class="col">
            <span style="font-size:23px; margin-right: 10px; line-height: 45px; direction:ltr;">環境</span>
            <div class="box">
                <a class="ion-star b1"></a>
                <a class="ion-star b2"></a>
                <a class="ion-star b3"></a>
                <a class="ion-star b4"></a>
                <a class="ion-star b5"></a>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 10px; text-align: center;">
        <div class="col">
            <span style="font-size:23px; margin-right: 10px; line-height: 45px; direction:ltr;">整體</span>
            <div class="box">
                <a class="ion-star b1"></a>
                <a class="ion-star b2"></a>
                <a class="ion-star b3"></a>
                <a class="ion-star b4"></a>
                <a class="ion-star b5"></a>
            </div>
        </div>
    </div>
    <div style="margin-top: 15px; font-size: 18px;">
        <p>寫下想說的話</p>
        <input type="text" name="storetext" placeholder="">
    </div>
    <div class="row justify-content-end">
            <button id="next" onclick="nextbtn()">Next</button>
    </div>
</div>

<div class="card container" id="commentdiv2" style="display: none;">
    <div class="row text-right">
        <div class="col">
            <button id="close" onclick="closecommentbtn()"></button>
        </div>
    </div>
    <div style="margin-top: 15px; font-size: 18px;">
        <p>寫下想說的話</p>
        <input type="text" name="storetext" placeholder="">
    </div>

</div>