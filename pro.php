<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>肥胖預測</title>
    <script type="text/javascript"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <style type="text/css">
        .docu {
            text-align: left;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        header {
            background-color: #666;
            padding: 30px;
            text-align: center;
            font-size: 30px;
            color: white;
        }

        nav {
            float: left;
            width: 20%;
            height: 450px;
            background: #ccc;
            padding: 20px;
            display: block;
            text-align: center;
        }

        nav a {
            list-style-type: none;
            padding: 0;
        }

        article {
            float: left;
            padding: 20px;
            width: 80%;
            background-color: #f1f1f1;
            height: 450px; /*only for demonstration, should be removed */
        }

        footer {
            background-color: #777;
            padding: 10px;
            text-align: center;
            color: white;
        }

        @media (max-width: 600px) {
            nav, article {
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>

<body>
<header>
    <h2>大數據</h2>
</header>

<nav style="display: flex; flex-direction: column; align-items: center; justify-content: space-evenly;">
    <a href="#" onclick="showContent('projectDescription')"style="font-size: 25px;">專題說明</a><br>
    <a href="#" onclick="showContent('implementationResults')"style="font-size: 25px;">實作成果</a><br>
    <a href="#" onclick="showContent('modelPerformance')"style="font-size: 25px;">模型效能</a>
</nav>

<script>
    function showContent(contentId) {
        // 隱藏所有文章區塊
        document.getElementById('projectDescription').style.display = 'none';
        document.getElementById('implementationResults').style.display = 'none';
        document.getElementById('modelPerformance').style.display = 'none';

        // 顯示點選的文章區塊
        document.getElementById(contentId).style.display = 'block';
    }
</script>

<?php
if(isset($_POST['FAVC']) & isset($_POST['FCVC']) & isset($_POST['NCP']) & isset($_POST['CAEC']) & isset($_POST['CH20']) & isset($_POST['SCC']) & isset($_POST['FAF']) & isset($_POST['TUE']) & isset($_POST['CALC']) & isset($_POST['MTRANS'])) {
    $FAVC = $_POST['FAVC'];
    $FCVC = $_POST['FCVC'];
    $NCP = $_POST['NCP'];
    $CAEC = $_POST['CAEC'];
    $CH20 = $_POST['CH20'];
    $SCC = $_POST['SCC'];
    $FAF = $_POST['FAF'];
    $TUE = $_POST['TUE'];
    $CALC = $_POST['CALC'];
    $MTRANS = $_POST['MTRANS'];

    $str = '"C:\Program Files\R\R-4.3.1\bin\Rscript"'.' .\model.R'." $FAVC $FCVC $NCP $CAEC $CH20 $SCC $FAF $TUE $CALC $MTRANS";
    #C:\"Program Files"\R\R-4.3.1\bin\Rscript C:\xampp\htdocs\R_test\model.R 1 2 3 1 2 1 0 1 1 4
    exec($str, $output, $return_var);

    $pattern = "/\[\d\]/" ;
    $replacement = "";

    foreach ($output as &$value) {
        $value = preg_replace($pattern, $replacement, $value);
    }
}
?>

<article id="projectDescription">
    <h2>專題說明</h2>
    <h3>1.專題題目：肥胖預測</h3>
    <h3>2.專題目標：預測目標的體重範圍</h3>
    <h3>3.資料集名稱：Obesity or CVD risk (Classify/Regressor/Cluster)</h3>
    <h3>4.機器學習名稱：svm演算法</h3>
</article>

<article id="implementationResults" style="display: none;">
    <h2>實作成果</h2>
    <!-- docu -->
    <div class="docu">
        <form action='pro.php' method='post'>
            FAVC   頻繁食用高熱量食物(1:no,2:yes)：<input type='text' name='FAVC' id="FAVC"/><br>
            FCVC   食用蔬菜頻率(1~3)：<input type='text' name='FCVC' id="FCVC"/><br>
            NCP    主餐次數(1~4)：<input type='text' name='NCP' id="NCP"/><br>
            CAEC   兩餐之間食物消耗量(1:no,2:Sometimes,3:Frequently,4:Always)：<input type='text' name='CAEC' id="CAEC"/><br>
            CH2O   每日飲水量(1~3)：<input type='text' name='CH20' id="CH20"/><br>
            SCC    卡路里消耗監測(1:no,2:yes)：<input type='text' name='SCC' id="SCC"/><br>
            FAF    體力活動頻率(0~2)：<input type='text' name='FAF' id="FAF"/><br>
            TUE    使用技術設備的時間(0~2)：<input type='text' name='TUE' id="TUE"/><br>
            CALC   酒精消耗量(1:no,2:Sometimes,3:Frequently,4:Always)：<input type='text' name='CALC' id="CALC"/><br>
            MTRANS 使用的交通(1:Automobile,2:Bike,3:Motorbike,4:Public_Transportation,5:Walking)：<input type='text' name='MTRANS' id="MTRANS"/><br>
            <input type='submit' value="送出"/>
        </form>
    </div>
    <div class="output-block">
        <h3>體重範圍</h3>
        <pre>
            <?php
            if(isset($output[0])) {
                print_r($output[0]);
            }
            echo "<script>";
            echo "$('#FAVC').val(".$output[1].");";
            echo "$('#FCVC').val(".$output[2].");";
            echo "$('#NCP').val(".$output[3].");";
            echo "$('#CAEC').val(".$output[4].");";
            echo "$('#CH20').val(".$output[5].");";
            echo "$('#SCC').val(".$output[6].");";
            echo "$('#FAF').val(".$output[7].");";
            echo "$('#TUE').val(".$output[8].");";
            echo "$('#CALC').val(".$output[9].");";
            echo "$('#MTRANS').val(".$output[10].");";
            echo "</script>";
            ?>
        </pre>
    </div>
</article>

<article id="modelPerformance" style="display: none;">
    <h2>模型效能</h2>
    <img src="images/model.png" class="img-thumbnail" style="width:600px;height:260px" />
</article>



<footer>
    <h2>資工四乙 4A9G0122 陳冠霖</h2>
</footer>

</body>
</html>
