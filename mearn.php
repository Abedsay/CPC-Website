<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <!-- ... other head elements ... -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">



    <style>
        /* Resetting default styles */
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }


        html {
            height: 100%;
            font-family: 'Arial', sans-serif;
            background: #F0F2F5;
        }

        /* Main layout styles */

        body {
            display: flex;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
            background: #F0F2F5;
            margin: 0;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        header {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Styles for vitals and appointments*/
        .vitals,
        .appointments,
        .reports {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
        }

        .vitals {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .appointment {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 20px;
            border-radius: 8px;
            background-color: #F8F8F8;
        }

        /* Styles for different appointment statuses */
        .status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            color: #fff;
        }

        .status.active {
            background-color: #5CBA47;
        }

        .status.upcoming {
            background-color: #2D9CDB;
        }

        .status.completed {
            background-color: #BDBDBD;
        }


        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #ecf0f1;
        }

        .greeting h1,
        .greeting p {
            margin: 0;
        }

        .icon-button {
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            margin-left: 20px;
            /* Space between icons */
        }

        .user-container {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
        }

        .greeting h1 {
            margin: 0;
            font-size: 1.5rem;
        }

        .greeting p {
            margin: 0;
        }

        .search-and-user {
            display: flex;
            align-items: center;
        }

        .search-container {
            position: relative;
            margin-right: 20px;
        }

        .search-icon,
        .notification-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .search-icon {
            left: 10px;
        }

        .notification-icon {
            right: 10px;
        }

        .search-container input {
            padding: 5px 10px 5px 30px;
            /* Left padding to make room for the icon */
            border-radius: 20px;
            border: none;
        }

        .user-container {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-icon {
            margin-right: 5px;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }
        }

        
        .appointment-container {
            width: 100%;
            padding: 20px;
        }

        .appointment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar {
            position: relative;
        }

        .search-bar input[type="search"] {
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
            padding-right: 40px;
        }

        .search-bar i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .clinic-list {
            display: flex;
            gap: 20px;
            flex-direction: column;

        }

        .clinic-card {
            display: flex;

            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        .clinic-photo {
            margin-top: 10px;
            margin-right: 10px;
            width: 100px;
            height: 100px;
            border-radius: 10px;
            align-items: center;
            margin-bottom: 10px;
            flex-shrink: 0;

        }

        .clinic-details {
            flex-grow: 1;

        }

        .clinic-details p,
        .clinic-details h2,
        .price-range {
            margin: 5px 0;
            font-size: 0.9em;
        }


        .clinic-specialization,
        .clinic-name,
        .clinic-location,
        .price-range {
            margin: 5px 0;
        }

        .clinic-specialization {
            color: #888;
            font-size: 0.9em;
        }

        .clinic-name {
            font-size: 1.1em;
            font-weight: bold;
        }

        .clinic-location {
            font-size: 0.9em;
            color: #888;
        }

        .price-range {
            font-size: 0.9em;
            color: #0056b3;
            font-weight: bold;
        }

        .check-availability {
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 15px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background-color 0.2s ease-in-out;
            width: 120px;
            text-align: center;
            /* Center-align the text within the button */
            margin-top: 45px;
        }

        .check-availability:hover {
            background-color: #003d82;
        }

        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');



        /* The new css */
        .dashboard-container {
            width: 100%;
            margin: 20px auto;
            display: inline-block;
            color: white;
        }

        .card-container {
            display: flex;
            inset-block: auto;
            padding-right: 20px;
            justify-items: space-between;
        }

        .card {
            background: #1f1f1f;
            border-radius: 20px;
            padding: 20px;
            color: white;
            width: 200px;
            height: 20%;
            margin-right: 20px;
            /* This will create space between the cards */
            display: inline-block;
            /* This makes the margin effective */
        }

        .icon-bg {
            display: inline-block;
            padding: 10px;
            background: #333;
            border-radius: 50%;
            width:70px;
        }

        .icon {
            width: 100%;
            height: 100%;
        }

        .title {
            font-size: 18px;
            color: #ccc;
        }

        .amount {
            font-size: 24px;
            margin: 10px 0;
        }

        .change {
            font-size: 16px;
            color: #7bdcb5;
            /* Greenish color for positive change */
        }

        .arrow-up {
            color: #7bdcb5;
        }

        .chart-container {
            background: #1f1f1f;
            border-radius: 20px;
            padding: 20px;
            color: white;
            max-width: 600px;
            margin: 0 auto;
        }




        .chart-box {
            background: #1f1f1f;
            padding: 20px;
            border-radius: 20px;
            display: inline-block;
            width: calc(50% - 10px);
            /* Subtract the margin from the total width */
            margin-right: 20px;
        }

        .chart-box:last-child {
            margin-right: 0;
        }

        .chart-container {
            background: #1f1f1f;
            border-radius: 20px;
            padding: 20px;
            color: white;
            width: 600px;
            /* Adjusted margin for spacing and auto centering */
        }

        canvas {
            display: block;
            width: 100%;
            height: 400px;
            /* Set a fixed height for the canvas to ensure it's visible */
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        html {
            height: 100%;
            font-family: 'Arial', sans-serif;
            background: #F0F2F5;
        }

        /* Main layout styles */

        body {
            display: flex;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
            background: #F0F2F5;
            margin: 0;
        }


        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        header {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Styles for vitals and appointments*/
        .vitals,
        .appointments,
        .reports {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
        }

        .vitals {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .appointment {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 20px;
            border-radius: 8px;
            background-color: #F8F8F8;
        }

        /* Styles for different appointment statuses */
        .status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            color: #fff;
        }

        .status.active {
            background-color: #5CBA47;
        }

        .status.upcoming {
            background-color: #2D9CDB;
        }

        .status.completed {
            background-color: #BDBDBD;
        }

        .sidebar {
       
            background-color: #010C80;
            padding: 20px;
           position:relative;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar .logo {
            text-align: center;
            padding-bottom: 20px;
        }

        .sidebar img {
             width:100%;
             height:100%;
        }

        .sidebar .navigation {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar .navigation a {
            display: flex;
            align-items: center;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }

        img {
            width: 60%;
            height: 60%;
            border-radius: 30px;
        }

        .sidebar .navigation a.active,
        .sidebar .navigation a:hover {
            background-color: #4B91F1;
            color: white;
        }

        .sidebar .navigation a i.icon {
            margin-right: 10px;
        }

        .sidebar .help-center {
            position: absolute;
            bottom: 20px; /* Adjust the distance from the bottom */
            width: calc(100% - 40px); /* Make the button full width minus padding */
            text-align: center;
        }

        .sidebar .help-center button {
            background: #4B91F1;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 10px;
            width: 100%;
            display: block;
        }

        .sidebar .help-center button i.icon {
            margin-right: 5px;
        }

        .sidebar .help-center button span {
            display: block;
            font-size: smaller;
        }
        

        .greeting h1,
        .greeting p {
            margin: 0;
        }

        .icon-button {
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            margin-left: 20px;
            /* Space between icons */
        }

        .user-container {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #010C80;
            color: white;
        }

        .greeting h1 {
            margin: 0;
            font-size: 1.5rem;
        }

        .greeting p {
            margin: 0;
        }

        .search-and-user {
            display: flex;
            align-items: center;
        }

        .search-container {
            position: relative;
            margin-right: 20px;
        }

        .search-icon,
        .notification-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .search-icon {
            left: 10px;
        }

        .notification-icon {
            right: 10px;
        }

        .search-container input {
            padding: 5px 10px 5px 30px;
            /* Left padding to make room for the icon */
            border-radius: 20px;
            border: none;
        }

        .user-container {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-icon {
            margin-right: 5px;
        }

        @media only screen and (max-width: 768px) {
            .sidebar {
                width: 100%;
                padding: 10px;
            }

            .sidebar .logo img {
                max-width: 150px;
            }

            .sidebar .navigation {
                flex-direction: column;
            }

            .sidebar .navigation a {
                margin-bottom: 5px;
            }

            .sidebar .help-center {
                display: none;
            }

            .main-content {
                padding: 10px;
            }

            .main-header {
                padding: 10px;
            }

            .search-container {
                margin-right: 10px;
            }

            .search-container input {
                padding: 8px;
            }
        }

        /* ... existing styles ... */

        /* New styles for flex container and chart boxes */
        .charts-flex-container {
            display: flex;
            justify-content: space-between;
            /* This will arrange the children side by side */
            gap: 20px;
            /* This adds space between your chart containers */
            margin: 20px 0;
            /* This adds some vertical spacing around the charts */
        }

        .chart-box {
            flex: 1;
            /* Each child will take up an equal amount of space */
            padding: 20px;
            background: #1f1f1f;
            border-radius: 20px;
            /* Removed the inline-block and margin-right styles */
        }

        /* Style for the canvas */
        canvas {
            width: 100%;
            height: 100%;
            /* You may want to adjust this height */
        }

        @media (max-width: 768px) {
            .charts-flex-container {
                flex-direction: column;
                /* Stack the charts on top of each other on smaller screens */
            }
        }

        .cards-chart-container {
            display: flex;
            align-items: flex-start;
        }

        .card-pair {
            display: flex;
            flex-direction: column;
            margin-right: 20px;
            /* Space between the card pairs and the chart */
        }

        .card {
            /* Adjust width, margin, and other styles as necessary */
            height: 300px;
            margin-bottom: 20px;
            /* Space between the top and bottom cards */
        }

        .chart-container {
            flex-grow: 1;
            /* Allow the chart to take up the remaining space */
            max-width: 600px;
            display: inline-block;
            /* Or any other fixed width or use flex-basis */
            /* Other styles remain the same */
        }

        @media (max-width: 768px) {
            .cards-chart-container {
                flex-direction: column;
            }

            .card-pair {
                margin-right: 0;
            }

            .chart-container {
                order: -1;
                /* This will move the chart above the cards on smaller screens */
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>


<body>
    
    <aside class="sidebar">
        <div style="width:200px;">
        <div class="logo">
            <img src="assets/images/logo.jpg" alt="HealthCare Logo">
        </div>
        <br>
        <nav class="navigation">
            <a href="managerindex.php"><i class="fas fa-tachometer-alt"></i>&nbsp;Overview</a>
            <a href="mdepartment.php"><i class="fas fa-building"></i>&nbsp;Department</a>
            <a href="mstaff.php"><i class="fas fa-users"></i>&nbsp;Staff</a>
            <a href="mmessage.php"><i class="fas fa-bell"></i>&nbsp;Notifications</a>
            <a href="mearn.php" class="active"><i class="fas fa-money-bill"></i>&nbsp;Earn</a>
            <a href="mannouncements.php"><i class="fas fa-envelope"></i>&nbsp;Announcements</a>
            <a href="index.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Log out</a>

            <div class="help-center">
                <button>
                    <i class="fas fa-question-circle"></i>
                    Help Center
                    <span>Having trouble?</span>
                </button>
            </div>
        </nav>
    </aside>


    <div class="main-content">

        <header class="main-header">
            <div class="greeting">
                <h1>CPC-Earnings</h1>
                
            </div>
            <div class="search-and-user">
                <div class="search-container">
                    <i class="search-icon">🔍</i>
                    <input type="text" placeholder="Search">
                </div>


            </div>
        </header>
    
        <div class="dashboard-container">
            <div class="card-container">
                <div class="card">
                    <div class="icon-bg">
                        <img src="assets/dr1.webp" alt="Doctor" class="icon" />
                    </div>
                    <div class="content">
                        <p class="title">Earning For Doctor</p>
                        <p class="amount">$140,120</p>
                        <p class="change">
                            <span class="arrow-up">↑</span>
                            20% last month
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="icon-bg">
                        <img src="assets/dr1.webp" alt="Doctor" class="icon" />
                    </div>
                    <div class="content">
                        <p class="title">Earning From Doctor</p>
                        <p class="amount">$140,120</p>
                        <p class="change">
                            <span class="arrow-up">↑</span>
                            20% last month
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="icon-bg">
                        <img src="assets/images/lab.png" alt="Doctor" class="icon" />
                    </div>
                    <div class="content">
                        <p class="title">Earning For Lab</p>
                        <p class="amount">$140,120</p>
                        <p class="change">
                            <span class="arrow-up">↑</span>
                            20% last month
                        </p>
                    </div>
                </div>


                <!-- Repeat for other cards -->
            
                <div class="card">
                    <div class="icon-bg">
                        <img src="assets/images/lab.png" alt="Doctor" class="icon" />
                    </div>
                    <div class="content">
                        <p class="title">Earning from lab</p>
                        <p class="amount">$140,120</p>
                        <p class="change">
                            <span class="arrow-up">↑</span>
                            20% last month
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="icon-bg">
                        <img src="assets/images/pharmacy.png" alt="Doctor" class="icon" />
                    </div>
                    <div class="content">
                        <p class="title">Earning For pharmacy </p>
                        <p class="amount">$140,120</p>
                        <p class="change">
                            <span class="arrow-up">↑</span>
                            20% last month
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="icon-bg">
                        <img src="assets/images/pharmacy.png" alt="Doctor" class="icon" />
                    </div>
                    <div class="content">
                        <p class="title">Earning From pharmacy </p>
                        <p class="amount">$140,120</p>
                        <p class="change">
                            <span class="arrow-up">↑</span>
                            20% last month
                        </p>
                    </div>
                </div>
                
            </div>
            
            <!-- Repeat for other cards -->
        </div>
       
        <div class="charts-flex-container">

                <div class="chart-box"><p> income from Clinic : (K)</p>
                    <canvas id="medicineActivityChart"></canvas>
                </div>
                <div class="chart-box"><p> income from Laboratory and Pharmacy : (K)</p>
                    <canvas id="myLineChart2"></canvas>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script src="lineChart.js"></script>
            </div>
            <!-- ... rest of your HTML ... -->
            <div class="chart-container">
                <canvas id="doctorsActivityChart"></canvas>
            </div>


        </div>








        <script>document.querySelectorAll('.dashboard button').forEach(button => {
                button.addEventListener('click', function () {
                    // Replace with actual navigation logic
                    console.log('Navigate to details');
                });
            });
        </script>


        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Doctors Activity Chart
            const doctorsActivityCtx = document.getElementById('doctorsActivityChart').getContext('2d');
            const doctorsActivityChart = new Chart(doctorsActivityCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Doctors Activity',
                        data: [5, 10, 5, 14, 8, 15, 13, 14, 23, 22, 33, 34],
                        backgroundColor: 'rgba(0, 123, 255, 0.2)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white'
                            }
                        }
                    },
                    maintainAspectRatio: false
                }
            });

            // Medicine Activity Chart
            const ctx = document.getElementById('medicineActivityChart').getContext('2d');
            const myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // X-axis labels
                    datasets: [
                        {
                            label: 'Public Health Clinic',
                            data: [10, 11, 12, 13, 2, 4, 1, 4, 5, 63, 4, 2], // Replace with your actual data
                            fill: false,
                            borderColor: 'red',
                            tension: 0.1
                        },
                        {
                            label: 'Dentistry Clinic',
                            data: [20, 19, 18, 17, 2, 3, 1, 4, 6, 8, 5, 32], // Replace with your actual data
                            fill: false,
                            borderColor: 'blue',
                            tension: 0.1
                        },
                        {
                            label: "ENT Clinic",
                            data: [10, 29, 8, 7, 12, 13, 11, 14, 16, 1, 15, 12], // Replace with your actual data
                            fill: false,
                            borderColor: 'green',
                            tension: 0.1
                        }, {
                            label: 'Cardiology Clinic',
                            data: [21, 29, 28, 27, 21, 31, 10, 24, 26, 28, 25, 22], // Replace with your actual data
                            fill: false,
                            borderColor: 'orange',
                            tension: 0.1
                        }, {
                            label: 'Physical Therapy Clinic',
                            data: [1, 9, 8, 7, 12, 13, 11, 14, 16, 18, 15, 22], // Replace with your actual data
                            fill: false,
                            borderColor: 'grey',
                            tension: 0.1
                        },
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const ctx2 = document.getElementById('myLineChart2').getContext('2d');
            const myLineChart2 = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // X-axis labels

                    datasets: [
                        {
                            label: 'Lab',
                            data: [21, 29, 28, 27, 21, 31, 10, 24, 26, 28, 25, 22], // Replace with your actual data
                            fill: false,
                            borderColor: 'orange',
                            tension: 0.1
                        }, {
                            label: 'Pharmacy',
                            data: [1, 9, 8, 7, 12, 13, 11, 14, 16, 18, 15, 22], // Replace with your actual data
                            fill: false,
                            borderColor: 'grey',
                            tension: 0.1
                        },
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
</body>

</html>