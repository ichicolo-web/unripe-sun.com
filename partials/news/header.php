<?php
$uri = $_SERVER['REQUEST_URI'];
$replaceUrl = preg_replace('/\//', ' ', $uri);
?>

    <h1 onclick="Javascript: location.href='/'">Unripe</h1>

    <div class="panel stuff">
        <img src="/images/news/tomori.png">
    </div><!--

 --><div class="panel description">
        <h2>News</h2>
        <p class="point">Unripeの最新情報をお届けします！</p>
    </div>
