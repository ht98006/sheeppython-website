<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <title>感測器數據分析</title>
   
    <style>
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
            margin:auto;
            border-collapse: collapse;
        }

        th, td {
            text-align: center;
            border: 2px solid black; /* 添加边框 */
            padding: 10px; /* 添加内边距 */
            font-size: 30px;
        }

        /* Center container */
        .container {
            display: flex;
            align-items: center; /* 垂直居中 */
            justify-content: space-between; /* 在容器中平均分配空间 */
            height: 100vh;
            width:  150vh;
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
            display: flex; /* 使用Flexbox布局 */
            align-items: center; /* 垂直居中 */
        }
        
        .text {
            margin-left: 20px; /* 设置文字与图片的间距 */
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
            background-color: grenn; /* Change button background color to blue */
            color: white; /* Change button text color to white */
            border-radius: 10px; /* Add border radius to button */
        }

        /* Align buttons to the right */
        .buttons-container {
            margin-left: auto; /* Pushes the buttons to the right */
            margin-right: 20px; /* Add some margin to separate from the edge */
            width:  170vh; 
        }
        
    </style>   
</head>
    <!-- 引入 Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js">
        
    </script>
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

            $query = "SELECT DATETIME FROM log";
            $result = mysqli_query($conn, $query);

            // 将日期时间数据存储到数组中
            $datetimeData = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $datetimeData[] = $row['DATETIME'];
            }

            // 将数据传递到 JavaScript 中
            echo "<script>";
            echo "var datetimeData = " . json_encode($datetimeData) . ";";
            echo "</script>";


            $query = "SELECT ID, IR, DHT, EC, PH FROM sensor";
            $result = mysqli_query($conn, $query);

            // Convert data to JavaScript format
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            
        ?>
       <!-- Chart -->
        <canvas id="myChart"></canvas>
    
    </div>

     
    <script>
    // 数据库传递的日期时间数据
    var datetimeData = <?php echo json_encode($datetimeData); ?>;

    // Pass data from PHP to JavaScript
    var data = <?php echo json_encode($data); ?>;

    // Extract data for chart
    var ids = data.map(item => item.ID);
    var irs = data.map(item => item.IR);
    var dhts = data.map(item => item.DHT);
    var ecs = data.map(item => item.EC);
    var phs = data.map(item => item.PH);
     
    //Chart.defaults.global.defaultFontSize = 20;
    // Create chart
    var ctx = document.getElementById('myChart').getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            // 使用数据库传递的日期时间数据作为 X 轴标签
            labels: datetimeData,
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
                    // 這裡是你可以改變 Y 軸文字大小的地方
                    fontSize: 30
                }
            },
            x: {
                ticks: {
                    // 這裡是你可以改變 X 軸文字大小的地方
                    fontSize: 30
                }
            }
        },
        legend: {
            labels: {
                // 這裡是你可以改變文字大小的地方
                fontSize: 40
            }
        }
    }
    });
    </script>

</body>
</html>
