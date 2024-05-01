<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medico Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <!-- ... other head elements ... -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
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
            /* Add more styling for the header */
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #ecf0f1;
            /* Adjust to match your specific color */
        }

        .greeting h1,
        .greeting p {
            margin: 0;
        }

        .icon-button {
            background: none;
            border: none;
            font-size: 16px;
            /* Adjust to match your specific size */
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
            /* Adjust to match the design */
            height: 30px;
            /* Adjust to match the design */
            border-radius: 50%;
            margin-right: 10px;
        }

        .sidebar .logo {
            text-align: center;
            padding-bottom: 20px;
        }

        .sidebar img {
            max-width: 100%;
            height: auto;
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
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }

        img {
            width: 40%;
            height: 40%;
            border-radius: 30px;
        }

        .sidebar .navigation a.active,
        .sidebar .navigation a:hover {
            background-color: #0056b3;
            color: white;
        }

        .sidebar .navigation a i.icon {
            margin-right: 10px;
            /* You will need to add your own icons */
        }

        .sidebar .help-center {
            position: absolute;
            bottom: 20px;
            width: calc(14% - 40px);
            /* Considering the padding of the sidebar */
            text-align: center;
        }

        .sidebar .help-center button {
            background: #0056b3;
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

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #2c3e50;
            /* Adjust the color to match your design */
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
            /* Adjust the positioning and size of icons as needed */
        }

        .search-icon {
            left: 10px;
            /* Replace this text icon with an actual icon from an icon library */
        }

        .notification-icon {
            right: 10px;
            /* Replace this text icon with an actual icon from an icon library */
        }

        .search-container input {
            padding: 5px 10px 5px 30px;
            /* Left padding to make room for the icon */
            border-radius: 20px;
            border: none;
        }

        .user-container {
            display: flex;
            align-items: right;
            cursor: pointer;
        }

        .user-container img {
            width: 20%;
            float: right;
            display: flex;
        }

        .user-icon {
            margin-right: 5px;
            /* Replace this text icon with an actual icon from an icon library */
        }



        .admin-name {
            margin-left: 10px;
            float: right;
            right: 100%;
        }

        .summary-container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .summary-box {
            flex-basis: 24%;
            padding: 20px;
            border-radius: 10px;
            background-color: #ffffff;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .summary-box:not(:last-child) {
            margin-right: 1%;
        }

        .summary-title {
            font-size: 1.2rem;
            color: #666666;
            margin-bottom: 10px;
        }

        .summary-count {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .summary-details {
            font-size: 0.9rem;
            color: #666666;
            margin-top: 5px;
        }

        /* Icons */
        .patients-icon {
            color: #ff6666;
        }

        .doctors-icon {
            color: #66b3ff;
        }

        .staff-icon {
            color: #4ddbff;
        }

        .pharmacy-icon {
            color: #ffd633;
        }

        .stats-container {
            width: 300px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        .stats-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .department {
            margin-bottom: 10px;
        }

        .department-name {
            color: #666666;
            font-size: 1rem;
            margin-right: 5px;
        }

        .progress {
            background-color: #f2f2f2;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar {
            height: 10px;
            border-radius: 5px;
        }

        .anesthetics {
            width: 84%;
            background-color: #ffcc00;
        }

        .gynecology {
            width: 94%;
            background-color: #00ccff;
        }

        .neurology {
            width: 99%;
            background-color: #ff6600;
        }

        .oncology {
            width: 75%;
            background-color: #3399ff;
        }

        .orthopedics {
            width: 80%;
            background-color: #ff0066;
        }

        .physiotherapy {
            width: 99%;
            background-color: #66cc66;
        }

        .percentage {
            font-size: 0.9rem;
            color: #666666;
        }

        /* ... (rest of your CSS above) */

        .dashboard-container {
    display: flex;
    justify-content: space-between; /* This will put space between your two main divs */
    padding: 20px; /* Adjust as needed */
    max-width: 100%; /* Make sure the container can expand full width */
}

.chart-container {
    flex: 2; /* Takes up 2 parts of the available space, adjust as needed */
    padding-right: 20px; /* Adjust as needed */
}

.stats-container {
    flex: 1; /* Takes up 1 part of the available space */
    padding-left: 20px; /* Adjust as needed */
    max-width: 300px; /* Adjust max-width as needed to match the design */
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Add responsive design breakpoints if necessary */
@media (max-width: 768px) {
    .dashboard-container {
        flex-direction: column;
    }

    .chart-container,
    .stats-container {
        flex: none;
        width: 100%;
        max-width: none; /* Reset max-width on smaller screens */
        padding-right: 0; /* Reset padding for mobile */
        padding-left: 0; /* Reset padding for mobile */
    }
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
            width: 270px;
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


        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="assets/images/logo.jpg" alt="HealthCare Logo">
        </div>
        <br>
        <nav class="navigation">
            <a href="managerindex.php" class="active"><i class="fas fa-tachometer-alt"></i>&nbsp;Overview</a>
            <a href="mdepartment.php"><i class="fas fa-building"></i>&nbsp;Department</a>
            <a href="mstaff.php"><i class="fas fa-users"></i>&nbsp;Staff</a>
            <a href="mmessage.php"><i class="fas fa-bell"></i>&nbsp;Notifications</a>
            <a href="mearn.php"><i class="fas fa-money-bill"></i>&nbsp;Earn</a>
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
                <h1>Welcome, Admin!</h1>
                <p></p>
            </div>
            <div class="search-and-user">
                <div class="search-container">
                    <i class="search-icon">🔍</i>
                    <input type="text" placeholder="Search for patient files">

                </div>
                <div class="notification-container">
                    <!-- Use an icon library like FontAwesome for the notification icon -->
                    <i class="notification-icon fas fa-bell"></i> <!-- doesnot appear -->
                </div>
                <div class="user-container">

                </div>

            </div>
        </header>

        <div class="summary-container">
            <div class="summary-box">
                <div class="patients-icon">👤</div>
                <div class="summary-count">105k</div>
                <div class="summary-title">Patients</div>
                <div class="summary-details">100 Patients joined this week</div>
            </div>

            <div class="summary-box">
                <div class="doctors-icon">👨‍⚕️</div>
                <div class="summary-count">50+</div>
                <div class="summary-title">Doctors</div>
                <div class="summary-details">3 Doctors joined this week</div>
            </div>

            <div class="summary-box">
                <div class="staff-icon">👥</div>
                <div class="summary-count">150+</div>
                <div class="summary-title">Staffs</div>
                <div class="summary-details">10 Staffs on joined</div>
            </div>

            <div class="summary-box">
                <div class="pharmacy-icon">💊</div>
                <div class="summary-count">04+</div>
                <div class="summary-title">Pharmacy</div>
                <div class="summary-details">55K Medicine on reserve</div>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="chart-container">
                <canvas id="patientVisitsChart"></canvas>
            </div>

            <div class="stats-container">
                <div class="stats-header">
                    <strong>Success Stats</strong>
                    <select>
                        <option>Jun 2023</option>
                        <!-- Add more options for other months here -->
                    </select>
                </div>

                <div class="department">
                    <span class="department-name">Public Health Clinic</span>
                    <span class="percentage">84%</span>
                    <div class="progress">
                        <div class="progress-bar anesthetics"></div>
                    </div>
                </div>

                <div class="department">
                    <span class="department-name">Physical Therapy </span>
                    <span class="percentage">94%</span>
                    <div class="progress">
                        <div class="progress-bar gynecology"></div>
                    </div>
                </div>

                <!-- Repeat the above pattern for other departments -->

                <div class="department">
                    <span class="department-name">ENT</span>
                    <span class="percentage">99%</span>
                    <div class="progress">
                        <div class="progress-bar neurology"></div>
                    </div>
                </div>

                <div class="department">
                    <span class="department-name">Cardiology</span>
                    <span class="percentage">75%</span>
                    <div class="progress">
                        <div class="progress-bar oncology"></div>
                    </div>
                </div>

                <div class="department">
                    <span class="department-name">Physical Therapy</span>
                    <span class="percentage">80%</span>
                    <div class="progress">
                        <div class="progress-bar orthopedics"></div>
                    </div>
                </div>

                
            </div>

            <script>
                const ctx = document.getElementById('patientVisitsChart').getContext('2d');
                const patientVisitsChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Male',
                            data: [1200, 1900, 2200, 1300, 1500, 2000, 2400, 2300, 2200, 2100, 2050, 2000], // Replace these values with your actual data
                            fill: false,
                            borderColor: 'rgb(54, 162, 235)',
                            tension: 0.1
                        }, {
                            label: 'Female',
                            data: [1100, 1400, 2000, 1600, 1700, 2100, 2300, 2100, 1900, 2200, 2000, 1950], // Replace these values with your actual data
                            fill: false,
                            borderColor: 'rgb(255, 99, 132)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,

                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            },
                            legend: {
                                display: true
                            }
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
                        plugins: {
                            tooltip: {
                                // Customize the tooltip here as per Chart.js documentation
                            },
                            legend: {
                                // Customize the legend here as per Chart.js documentation
                            }
                        },
                        elements: {
                            point: {
                                radius: 5, // Adjust the point radius
                                hoverRadius: 7, // Radius when hovered
                                hitRadius: 10, // Clickable area radius
                                borderWidth: 2, // Border width of points
                            },
                            line: {
                                borderWidth: 3 // Width of the line
                            }
                        },
                    }
                });

            </script>

</body>

</html>