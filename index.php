<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "week10_db"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === "Saroj" && $password === "Saroj") {
        echo "success";
    } else {
        echo "error";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Data Visualization</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.10.0/chart.min.js"></script>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="login-form">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="button" onclick="authenticateUser()">Login</button>
        </form>
        <div id="error-message"></div>
    </div>

    <div id="chart-container" style="width: 80%; margin: auto; display: none;">
        <canvas id="myChart"></canvas>
    </div>

    <script>
        function authenticateUser() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "index.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (xhr.responseText == "success") {
                        document.getElementById("error-message").innerHTML = "";
                        showDataVisualization();
                    } else {
                        document.getElementById("error-message").innerHTML = "Invalid credentials. Please try again.";
                    }
                }
            };
            xhr.send("username=" + username + "&password=" + password);
        }

        function showDataVisualization() {
            document.getElementById("login-form").style.display = "none";
            document.getElementById("chart-container").style.display = "block";

            var data = {
                labels: ['Option A', 'Option B', 'Option C', 'Option D'],
                datasets: [{
                    label: 'Responses',
                    data: [10, 20, 15, 25],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            var options = {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
