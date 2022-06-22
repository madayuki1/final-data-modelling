<?php
require 'classes\data.classes.php';

$data = new data();
$arrayGenre = $data->findTopGenre();
$genreList = json_encode($arrayGenre);

$arrayCountry = $data->userCountry();
$countryList = json_encode($arrayCountry);

$assoc = $data->castingCountMongo();
$assoc = array_count_values($assoc);
// var_dump($assoc);
$castingCount = array();
$castingCountActorName = array();
foreach ($assoc as $one => $value) {
    // var_dump($one . ' ' . $value);
    array_push($castingCountActorName, $one);
    array_push($castingCount, $value);

}
$allActor = $data->all_actor();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
    <title>Document</title>
</head>

<body>

    <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
        <button id="genre" class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
        <button class="w3-bar-item w3-button" onclick="topGenre()">Top 5 Genre</button>
        <button class="w3-bar-item w3-button" onclick="userCountry()">User's Home Country</button>
        <button class="w3-bar-item w3-button" onclick="castCount()">Actor Cast Count</button>
    </div>

    <div id="main">

        <div class="w3-teal">
            <button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
            <div class="w3-container">
                <h1>Pemodelan Data</h1>
            </div>
        </div>

        <div class="container" style="position: relative; height:30vh; width:45vw; margin-top:50px">
            <!-- <div class="container"> -->
            <canvas id='myChart'></canvas>
        </div>


    </div>

</body>
<script>
    let myChart = document.getElementById('myChart').getContext('2d');


    function topGenre() {
        let genreArray = <?php echo $genreList; ?>;
        let genre = [];
        let count = [];

        for (var i = 0; i < 5; i++) {
            genre.push(genreArray[i]['genre']);
        }

        for (var i = 0; i < 5; i++) {
            count.push(genreArray[i]['total']);
        }
        let chart = new Chart(myChart, {
            type: 'doughnut',
            data: {
                labels: genre,
                datasets: [{
                    label: 'Number of Records',
                    data: count,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(52, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                    ]
                }]
            },
            options: {},
            layout: {
                left: 0,
                right: 0,
                bottom: 0,
                top: 100
            }
        });
        w3_close();
    }

    function userCountry() {
        myChart.clearRect(0, 0, myChart.width, myChart.height);
        let countryArray = <?php echo $countryList; ?>;
        let country = [];
        let countryCount = [];

        for (var i = 0; i < 5; i++) {
            country.push(countryArray[i]['country_name']);
        }

        for (var i = 0; i < 5; i++) {
            countryCount.push(countryArray[i]['total']);
        }
        let chart = new Chart(myChart, {
            type: 'bar',
            data: {
                labels: country,
                datasets: [{
                    label: 'Number of Records',
                    data: countryCount,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(52, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                    ]
                }]
            },
            options: {},
            layout: {
                left: 0,
                right: 0,
                bottom: 0,
                top: 100
            }
        });
        w3_close();
    }

    function castCount() {

        let castingCount = <?php echo json_encode($castingCount); ?>

        let castingCountActorName = <?php echo json_encode($castingCountActorName); ?>

        let chartGenre = new Chart(myChart, {
            type: 'line',
            data: {
                labels: castingCountActorName,
                datasets: [{
                    label: 'Number of Records',
                    data: castingCount,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(52, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                    ]
                }]
            },
            options: {
                maintainAspectsRatio: false,
                responsive: true,
                title: {
                    display: true,
                    text: 'Top 5 Movies Genres',
                    fontSize: 25
                },
                legend: {
                    display: true,
                    position: 'right',
                    labels: {
                        fontColor: '#000'
                    }
                }
            },
            layout: {
                left: 0,
                right: 0,
                bottom: 0,
                top: 100
            }
        });
        w3_close();
    }

    function rating() {

    }

    function w3_open() {
        document.getElementById("main").style.marginLeft = "25%";
        document.getElementById("mySidebar").style.width = "25%";
        document.getElementById("mySidebar").style.display = "block";
        document.getElementById("openNav").style.display = 'none';
    }

    function w3_close() {
        document.getElementById("main").style.marginLeft = "0%";
        document.getElementById("mySidebar").style.display = "none";
        document.getElementById("openNav").style.display = "inline-block";
    }
</script>

</html>