<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>感測器數據分析</title>

    <!-- 引入 mtlib -->
    <script src="https://cdn.jsdelivr.net/npm/mtlib@0.1.0/dist/mtlib.min.js"></script>

    <style>
        /* 修改圖表的預設字體大小 */
        .Chartjs-legend,
        .Chartjs-tooltip {
            font-size: 60px !important;
        }

        body {
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.5);
        }

        /* 添加表格样式 */
        table {
            flex-direction: column;
            height: 300px;
            z-index: 3;
            margin: auto;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: center;
            border: 2px solid black;
            /* 添加边框 */
            padding: 10px;
            /* 添加内边距 */
            font-size: 30px;
        }

        /* Center container */
        .container {
            display: flex;
            align-items: center;
            /* 垂直居中 */
            justify-content: space-between;
            /* 在容器中平均分配空间 */
            height: 100vh;
            width: 150vh;
            z-index: 1;
        }

        canvas {
            max-width: 1200px;
            max-height: 800px;
        }

        .top-left {
            font-family: 'DFKai-sb', sans-serif;
            background: url(https://raw.githubusercontent.com/ht98006/sheeppython-website/main/background.jpg) no-repeat right;
            height: 100px;
            width: 130%;
            color: black;
            font-size: 60px;
            font-weight: bold;
            text-align: left;
            margin: 0;
            padding: 10px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
            display: flex;
            /* 使用Flexbox布局 */
            align-items: center;
            /* 垂直居中 */
        }

        .text {
            margin-left: 20px;
            /* 设置文字与图片的间距 */
            text-align: center;
            z-index: 2;
        }

        /* Style for buttons */
        .button {

            font-family: 'DFKai-sb', sans-serif;
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 30px;
            margin: 2px;
            cursor: pointer;
            background-color: grenn;
            /* Change button background color to blue */
            color: white;
            /* Change button text color to white */
            border-radius: 10px;
            /* Add border radius to button */
        }

        /* Align buttons to the right */
        .buttons-container {
            margin-left: auto;
            /* Pushes the buttons to the right */
            margin-right: 20px;
            /* Add some margin to separate from the edge */
            width: 170vh;
        }
    </style>
</head>

<body>
    <div class="top-left">
        <img src="https://raw.githubusercontent.com/ht98006/sheeppython-website/main/%E5%9C%96%E7%89%873.png" alt="圖片" />
        <div class="text">
            <p>智慧水耕農業養液監控系統</p>
        </div>
        <!-- Buttons Container -->
        <div class="buttons-container">
            <a href="home.php" class="button">主頁</a>
            <a href="plant.php" class="button">植物介紹</a>
            <a href="sensor.php" class="button">感測器介紹</a>
            <a href="data.php" class="button">數據分析</a>
        </div>
    </div>
    </div>


    <div class="container">

        <!-- Data Table -->
        <?php
        $conn = mysqli_connect('localhost', 'root', '', '數據分析');
        if (!$conn) {
            die("连接失败：" . mysqli_connect_error());
        }

        $query = "SELECT ID, IR, DHT, EC, PH FROM sensor";
        $result = mysqli_query($conn, $query);

        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>IR</th><th>DHT</th><th>EC</th><th>PH</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["IR"] . "</td><td>" . $row["DHT"] . "</td><td>" . $row["EC"]  . "</td><td>" . $row["PH"] . "</td></tr>";
            }

            echo "</table>";
        } else {
            echo "0 筆結果";
        }

        

        // Convert data to JavaScript format
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
         
        $query = "SELECT ID, IR, DHT, EC, PH FROM sensor";
        $result = mysqli_query($conn, $query);

        // 將數據轉換為 PHP 數組
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        // 將 PHP 數組轉換為 JavaScript 可以使用的 JSON 格式
        echo "<script>";
        echo "var data = " . json_encode($data) . ";";
        echo "</script>";
        ?>
        <!-- Chart -->
        <canvas id="myChart"></canvas>


    </div>


    <script>
        // 使用 PHP 變量中的數據
        var ids = data.map(item => item.ID);
        var irs = data.map(item => item.IR);
        var dhts = data.map(item => item.DHT);
        var ecs = data.map(item => item.EC);
        var phs = data.map(item => item.PH);

        // 創建圖表
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ids, // X 軸標籤
                datasets: [{
                    label: 'IR',
                    data: irs,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }, {
                    label: 'DHT',
                    data: dhts,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }, {
                    label: 'EC',
                    data: ecs,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }, {
                    label: 'PH',
                    data: phs,
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            fontSize: 30 // Y 軸文字大小
                        }
                    },
                    x: {
                        ticks: {
                            fontSize: 30 // X 軸文字大小
                        }
                    }
                },
                legend: {
                    labels: {
                        fontSize: 40 // 圖例文字大小
                    }
                }
            }
        });
        </script>
</body>

</html>
