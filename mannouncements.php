<!DOCTYPE html>
<!-- saved from url=(0053)file:///C:/Users/TD/Desktop/manager/appointments.html -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <!-- ... other head elements ... -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="./se_files/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
   
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

        .sidebar {
            width: 250px;
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
        .clinic-list {
            display: flex;
            gap:20px;
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

        .check-availability,.accept-btn,.reject-btn {
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 15px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 0.9em; 
            transition: background-color 0.2s ease-in-out;
            width: 120px; 
            height:40px;
            text-align: center; /* Center-align the text within the button */
            margin-top:45px;
        }
        
        .check-availability:hover,.accept-btn:hover,.reject-btn :hover {
            background-color: #003d82;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        
    </style>


<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="assets/images/WhatsApp Image 2024-04-19 at 21.06.23_841d4b7d.jpg" alt="HealthCare Logo">
        </div>
        <br>
        <nav class="navigation">
            <a href="managerindex.php"><i class="fas fa-tachometer-alt"></i>&nbsp;Overview</a>
            <a href="mdepartment.php"><i class="fas fa-building"></i>&nbsp;Department</a>
            <a href="mstaff.php"><i class="fas fa-users"></i>&nbsp;Staff</a>
            <a href="mmessage.php"><i class="fas fa-bell"></i>&nbsp;Notifications</a>
            <a href="mearn.php"><i class="fas fa-money-bill"></i>&nbsp;Earn</a>
            <a href="mannouncements.php" class="active"><i class="fas fa-envelope"></i>&nbsp;Announcements</a>
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
                <h1>Announcements</h1>
                <p></p>
            </div>
            <div class="search-and-user">
                <div class="search-container">
                    <i class="search-icon">🔍</i>
                    <input type="text" placeholder="Search">
                </div>
            </div>
        </header>
        <div class="clinic-list" id="currentClinics">
            <h2>Current Announcements</h2>
            <!-- Public Health Clinic -->
            <div class="clinic-card">
                <img src="assets/dr1.webp" alt="Public Health Clinic" class="clinic-photo">
                <div class="clinic-details">
                    <p class="clinic-specialization">Public Health</p>
                    <h2 class="clinic-name">Public Health Clinic</h2>
                    <p>Comprehensive health assessments to monitor and maintain overall well-being.</p>
                    <p class="clinic-location">Dubai, UAE</p>
                </div>
              
            </div>

            <!-- Ent Clinic -->
            <div class="clinic-card">
                <img src="assets/dr1.webp" alt="ENT Clinic" class="clinic-photo">
                <div class="clinic-details">
                    <p class="clinic-specialization">Ear, Nose, Throat</p>
                    <h2 class="clinic-name">Ear, Nose, Throat Clinic</h2>
                    <p>Specialized care for ENT conditions including infections and allergies.</p>
                    <p class="clinic-location">Dubai, UAE</p>
                </div>
                
            </div>

            <!-- Dentistry Clinic -->
            <div class="clinic-card">
                <img src="assets/dr1.webp" alt="Dentistry Clinic" class="clinic-photo">
                <div class="clinic-details">
                    <p class="clinic-specialization">Dentistry</p>
                    <h2 class="clinic-name">Dentistry Clinic</h2>
                    <p>Expert dental services for maintaining oral health and hygiene.</p>
                    <p class="clinic-location">Dubai, UAE</p>
                </div>
               
            </div>

            <!-- Cardiology Clinic -->
            <div class="clinic-card">
                <img src="assets/dr1.webp" alt="Cardiology Clinic" class="clinic-photo">
                <div class="clinic-details">
                    <p class="clinic-specialization">Cardiology</p>
                    <h2 class="clinic-name">Cardiology Clinic</h2>
                    <p>Specialized care for heart-related conditions including heart diseases and hypertension.</p>
                    <p class="clinic-location">Dubai, UAE</p>
                </div>
                
            </div>
        
            <!-- Physical Therapy Clinic -->
            <div class="clinic-card">
                <img src="assets/dr1.webp" alt="Physical Therapy Clinic" class="clinic-photo">
                <div class="clinic-details">
                    <p class="clinic-specialization">Physical Therapy</p>
                    <h2 class="clinic-name">Physical Therapy Clinic</h2>
                    <p>Expert rehabilitation services to restore movement and function, alleviate pain, 
                        <br> and prevent disabilities through personalized treatment plans. </p>
                    <p class="clinic-location">Dubai, UAE</p>
                </div>
              
            </div>
            
        </div>
        <br>
        <div class="clinic-list" id="clinicRequests">
            <h2>Current Requests</h2>
            <!-- Clinic requests will be listed here -->
            <div class="clinic-card request-card" data-clinic-id="1">
                <img src="assets/dr1.webp" alt="Public Health Clinic" class="clinic-photo">
                <div class="clinic-details">
                    <p class="clinic-specialization">Public Health</p>
                    <h2 class="clinic-name">Public Health Clinic</h2>
               
                    <p class="clinic-location">Dubai, UAE</p>
                </div>
            <span><button class="accept-btn" >Accept</button>
              <button class="reject-btn">Reject</button></span>
            </div>
            <!-- Repeat for other requests -->
          </div>

    </div>
 <script>
            function acceptClinicRequest(event) {
        // Stop the default form submission if the button is inside a form
        event.preventDefault();

        // Get the closest clinic card to the clicked button
        const clinicCard = event.target.closest('.clinic-card');

        // Create a new "View Doctor" button
        const viewButton = document.createElement('button');
        viewButton.textContent = 'View Doctor';
        viewButton.className = 'check-availability'; // Make sure this class matches your CSS for styling
        viewButton.addEventListener('click', function() {
            // Handle the view action, such as redirecting to the doctor's profile page
            window.location.href = 'link-to-doctor-profile.html'; // Replace with the actual doctor profile link
        });

     

        // Remove the reject button if it exists
        const rejectButton = clinicCard.querySelector('.reject-btn');
        if (rejectButton) {
            rejectButton.remove();
        }

        // Remove the accept button
        event.target.remove();

        // Move the clinic card to the current section
        const currentClinicsContainer = document.getElementById('currentClinics'); // Make sure this is the ID of your current clinics container
        currentClinicsContainer.appendChild(clinicCard);
        }

        // Assuming your accept buttons have the class '.accept-btn'
        document.querySelectorAll('.accept-btn').forEach(button => {
        button.addEventListener('click', acceptClinicRequest);
        });

        </script>
        <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('.reject-btn').forEach(button => {
            button.addEventListener('click', function() {
            const parentCard = this.closest('.clinic-card');
            parentCard.remove(); // Remove the request card
            });
        });
        });
</script>
 </body></html>