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

        .sidebar {
            width: 250px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
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

        /* Styles for vitals and appointments */
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
            /* Add more styling for vitals cards */
        }

        .appointment {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 20px;
            border-radius: 8px;
            background-color: #F8F8F8;
            /* Add more styling for appointment cards */
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

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
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

        .doctor-list {
            display: flex;
            flex-direction: column;
            padding: 10px;
        }

        .doctor-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px; /* Spacing between cards */
        }

        .doctor-photo {
            width: 50px;
            height: 50px; 
            border-radius: 50%;
            object-fit: cover; /* Ensures the image covers the area without distortion */
            margin-right: 15px;
        }

        .doctor-details {
            flex-grow: 1;
        }

        .doctor-specialization, 
        .doctor-name, 
        .doctor-location, 
        .price-range {
            margin: 5px 0;
        }

        .doctor-specialization {
            color: #888;
            font-size: 0.9em;
        }

        .doctor-name {
            font-size: 1.1em;
            font-weight: bold;
        }

        .doctor-location {
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
        }

        .check-availability:hover {
            background-color: #003d82;
        }

        /* Include FontAwesome CSS */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');

    </style>
</head>


<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="assets/images/logo.jpg" alt="HealthCare Logo">
        </div>
        <br>
        <nav class="navigation">
            <a href="managerindex.php"><i class="fas fa-tachometer-alt"></i>&nbsp;Overview</a>
            <a href="mdepartment.php" class="active"><i class="fas fa-building"></i>&nbsp;Department</a>
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
                <h1>Staff</h1>
                <p></p>
            </div>
            <div class="search-and-user">
                <div class="search-container">
                    <i class="search-icon">🔍</i>
                    <input type="text" placeholder="Search">
                </div>
                <div class="notification-container">
                    <i class="notification-icon fas fa-bell"></i> 
                </div>
                

            </div>
        </header>
       
        
        <div class="doctor-list">
            
            <div class="doctor-card">
                <img src="assets/dr1.webp" alt="Doctor Lionel Messie" class="doctor-photo">
                <div class="doctor-details">
                    <p class="doctor-specialization">Cardiology</p>
                    <h2 class="doctor-name">Dr. Bader </h2>
                    <p class="doctor-location">Dubai, UAE</p>
                </div>
            </div>
            <div class="doctor-card">
                <img src="assets/dr1.webp" alt="Doctor Lionel Messie" class="doctor-photo">
                <div class="doctor-details">
                    <p class="doctor-specialization">Cardiology</p>
                    <h2 class="doctor-name">Dr. Lana</h2>
                    <p class="doctor-location">Dubai, UAE</p>
                </div>
            </div>
            
        </div>
    </div>
</body>

</html>