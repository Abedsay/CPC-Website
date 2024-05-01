
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            /* Adjust width as necessary */
            background-color: #fff;
            /* Adjust color as necessary */

            height: 100vh;
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
            /* Add more styling for the header */
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
            width: 60%;
            height: 60%;
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

        /* Add more styling as needed for the fonts, colors, and other elements */
        /* Add this to your styles.css file */
        /* Main header styling */
        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
            background-color: #2c3e50;
            /* Dark blue background */
            color: white;
            border-radius: 6px;
            /* Rounded corners for the header */
        }

        .greeting {
            margin-right: 20px;
            /* Add space to the right of the greeting */
        }

        /* Greeting and search/user container */
        .greeting h1 {
            font-size: 1.8rem;
            /* Slightly larger font size for the heading */
            font-weight: normal;
            /* Remove bold from headings, if preferred */
            margin-bottom: 4px;
            /* Space between the heading and subheading */
        }

        .greeting p {
            font-size: 1rem;
            /* Standard font size for subheading */
            opacity: 0.9;
            /* Slightly transparent for less emphasis */
        }

        .search-and-user {
            display: flex;
            align-items: center;
        }

        /* Search bar enhancements */
        .search-bar input {
            padding: 10px 15px;
            border-radius: 20px;
            border: 2px solid #ddd;
            /* Slightly thicker border for definition */
            font-size: 1rem;
            /* Matching font size for input */
            margin-right: 1rem;
            /* Space before the add employee button */
        }

        /* Add employee button */
        .add-employee-btn {
            background-color: #0056b3;
            /* Brighter blue for the button */
            color: white;
            border: none;
            border-radius: 20px;
            /* Fully rounded corners for the button */
            padding: 10px 20px;
            text-align: center;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            /* Smooth transition for hover effect */
        }

        .add-employee-btn:hover {
            background-color: #003c82;
            /* Darker blue on hover for button */
        }

        /* User container */
        .user-container {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            /* White background for user info */
            border-radius: 20px;
            /* Rounded corners for the user container */
            padding: 5px 15px;
        }

        .user-icon {
            color: #2c3e50;
            /* Same color as the header for the user icon */
            margin-right: 10px;
        }

        .user-container span {
            font-size: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .main-header {
                flex-direction: column;
                align-items: flex-start;
                /* Align items to the start on mobile */
            }

            .search-and-user {
                flex-direction: column;
                align-items: stretch;
                /* Full-width elements on mobile */
                margin-top: 1rem;
                /* Space between search/user and greeting on mobile */
            }
        }



        h1 {
            font-size: 24px;
            color: #333;
            /* Adjust the font, size, and color to match your design */
        }

        .search-bar {
            flex-grow: 1;
            /* Allows the search bar to take up available space */
            margin-right: 20px;
            /* Add space to the right of the search bar */
        }

        .search-bar input {
            padding: 10px 15px;
            border-radius: 20px;
            border: 2px solid #ddd;
            width: 100%;
            outline: none;
        }

        .add-employee-btn {
            padding: 10px 20px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;

            margin-right: 20px;
            /* Add space to the right of the button */
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

        .employee-table {
            background: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-header,
        .table-row {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid #EEE;
        }

        .table-header {
            background-color: #F8F8F8;
            font-weight: bold;
        }

        .table-row {
            background-color: #FFFFFF;
            transition: background-color 0.3s;
        }

        .table-row:hover {
            background-color: #F0F0F0;
        }

        .avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .actions i {
            margin: 0 5px;
            cursor: pointer;
        }

        .employee-details {
            background: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
            /* Or whatever width you desire */
            margin-left: 20px;
            /* To create space between the table and the details view */
        }

        .employee-header {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #EEE;
        }

        .employee-info-card {
            padding: 20px;
            text-align: center;
            /* Centers the content */
        }

        .employee-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        h3 {
            margin-bottom: 10px;
        }

        .status-active {
            color: #28a745;
            /* Active status color */
            font-weight: bold;
        }

        .employee-activities-chart {
            padding: 20px;
            /* You can set a height or leave it to be determined by Chart.js */
        }

        .see-all-link {
            text-decoration: none;
            color: #0056b3;
        }

        .content-container {
            display: flex;
            justify-content: space-between;
        }

        .employee-table-container {
            flex: 1;
            margin-right: 20px;
            /* Adjust the spacing between table and details as needed */
        }

        .employee-details-container {
            width: 350px;
            /* Set a fixed width for the sidebar */
            flex-shrink: 0;
            /* Prevent the sidebar from shrinking */
        }

        .table-row,
        .employee-info-card {
            background-color: #fff;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table-row:hover,
        .employee-info-card:hover {
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .content-area {
            display: flex;
            justify-content: space-between;
            /* Adjust as necessary */
        }

        .employee-table {
            flex: 3;
            /* Adjust the ratio based on your design requirements */
            /* Your styling here */
        }

        .employee-details-view {
            flex: 1;
            /* Adjust the ratio based on your design requirements */
            margin-left: 20px;
            /* Adjust the spacing as needed */
            /* Your styling here */
        }

        body {
            font-family: Arial, sans-serif;
        }

        .table-container {
            margin: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #4CAF50;
            color: black;
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
            color:white;
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

        /* Modal Styles */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Could be more or less, depending on screen size */
            max-width: 500px;
            /* Maximum width */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .form-container {
            background: #ffffff;
            width: 300px;
            padding: 20px;
            margin: 30px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form h2 {
            margin-top: 0;
        }

        form p {
            font-size: 0.9em;
            color: #666;
        }

        form label {
            display: block;
            margin-top: 10px;
        }

        form input[type=text],
        form input[type=email],
        form input[type=tel],
        form input[type=date],
        form select,
        form textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form textarea {
            height: 80px;
            resize: vertical;
        }

        #charactersLeft {
            display: block;
            text-align: right;
            font-size: 0.8em;
            color: #666;
        }

        .form-actions {
            margin-top: 20px;
            text-align: right;
        }

        .form-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #cancelButton {
            background: #ccc;
        }

        #saveButton {
            background: #0084ff;
            color: white;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .table-container {
            max-width: 80%;
            margin: 20px;
            float: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .action-icons {
            font-size: 18px;
            cursor: pointer;
        }

        .action-icons .fa-edit {
            color: #ffca2c;
            margin-right: 10px;
        }

        .action-icons .fa-trash-alt {
            color: #e94949;
        }

        /* Continue with the rest of your styling... */


        /* Ensure you include any necessary responsiveness or additional styling */


        /* You can add more styles for colors, fonts, etc., to match your design */

        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
    </style>
</head>

<body>
    <div style="width:250px;">
    <aside class="sidebar">
        <div class="logo">
            <img src="assets/images/logo.jpg" alt="HealthCare Logo">
        </div>
        <br>
        <nav class="navigation">
            <a href="managerindex.php"><i class="fas fa-tachometer-alt"></i>&nbsp;Overview</a>
            <a href="mdepartment.php"><i class="fas fa-building"></i>&nbsp;Department</a>
            <a href="mstaff.php" class="active"><i class="fas fa-users"></i>&nbsp;Staff</a>
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
        </div>
    </aside>

    <div class="main-content">

        <header class="main-header">
            <div class="greeting">
                <h1>Staff Information</h1>
                <p></p>
            </div>
            <div class="search-and-user">

                <div class="notification-container">
                    <!-- Use an icon library like FontAwesome for the notification icon -->
                    <i class="notification-icon fas fa-bell"></i> <!-- doesnot appear -->
                </div>
                <div class="search-bar">
                    <input type="text" placeholder="Search for anything">
                </div>
                

            </div>
        </header>
        <div class="content-area">
        <div class="table-container">
        <h2>Employees</h2>
        <table id="employee-table">
            <!-- Table headers -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Dept.</th>
                    <th>Mobile</th>
                    <th>Action</th>
                </tr>
            </thead>
            <!-- Table body populated by PHP -->
            <tbody>
            <?php
            include "get_staff.php";
if (isset($employees) && is_array($employees)) {
    foreach ($employees as $employee) {
        echo "<tr>";
        echo "<td>" . $employee["id"]. "</td>";
        echo "<td>" . $employee["name"]. "</td>";
        echo "<td>" . $employee["department"]. "</td>";
        echo "<td><a href='tel:" . $employee["mobile"] . "' class='contact-link'>" . $employee["mobile"] . "</a></td>";

        echo "<td><button class='delete-btn' data-id='" . $employee["id"]. "'>Delete</button></td>";
        echo "</tr>";
    }}
    else {
        echo 'No employees found.';
    }
    ?>
</tbody>
        </table>
    </div>
    <form id="addEmployeeForm">
                <h2>Add Employee</h2>
                <p>Such as personal details, and contact information.</p>

                <label for="employeeName">Employee Name</label>
                <input type="text" id="employeeName" name="employeeName" placeholder="Type here" required>

                
                <label for="Clinic">Clinic</label>
                
                <select id="Clinic" name="Clinic" required>
                    <option value="Public Health">Public Health</option>
                    <option value="Dentistry">Dentistry</option>
                    <option value="ENT">ENT</option>
                    <option value="Cardiology">Cardiology</option>
                    <option value=">Physical Therapy">Physical Therapy</option>
                    
                    <option value=">Lab ">Lab</option>
                    <option value="Pharmacy ">Pharmacy </option>
                </select>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="example@gmail.com" required>

                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" placeholder="Type here" required>

                <label for="address">Address</label>
                <input type="text" id="address" name="address" placeholder="Type here" required>

                <label for="descriptions">Descriptions</label>
                <textarea id="descriptions" name="descriptions" placeholder="Type here" maxlength="400"
                    required></textarea>
                <span id="charactersLeft">400 characters left</span>

                <div class="form-actions">
                    <button type="button" id="cancelButton">Cancel</button>
                    <button type="submit" id="saveButton">Save</button>
                </div>
            </form>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    console.log('Document ready. Fetching data.');

    fetch('get_staff.php') // Ensure this points to the right path on your server
        .then(response => {
            console.log('Data received.', response);
            return response.json();
        })
        .then(employees => {
            console.log('Processing data.', employees);
            const tableBody = document.getElementById('employee-table').getElementsByTagName('tbody')[0];
            tableBody.innerHTML = ''; // Clear any existing rows

            // Add new rows from the fetched data
            employees.forEach((employee, index) => {
                let row = tableBody.insertRow();

                row.insertCell(0).textContent = index + 1;
                row.insertCell(1).textContent = employee.id;
                row.insertCell(2).textContent = employee.name;
                row.insertCell(3).textContent = employee.department;
                row.insertCell(4).textContent = employee.mobile;

                let deleteCell = row.insertCell(5);
                let deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                deleteButton.classList.add('delete-btn'); // Use classList.add for consistency and potential CSS styling
                deleteButton.dataset.id = employee.id;
                document.addEventListener('click', function(e) {
    
    deleteCell.appendChild(deleteButton);
});

            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });

    // Submit event listener for the form
    document.getElementById('addEmployeeForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Create a FormData object from the form
    const formData = new FormData(this);

    // Append 'action' to formData for server-side handling
    formData.append('action', 'add');

    // Make an AJAX call to add the employee
    fetch('get_staff.php', { 
        method: 'POST', 
        body: formData 
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Handle successful addition here...
            alert('Employee added successfully!');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error adding employee:', error);
        alert('Error adding employee.');
    });
});
document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('delete-btn')) {
            const employeeId = e.target.dataset.id;
            if (confirm('Are you sure you want to delete this employee?')) {
                fetch('get_staff.php', { // Make sure this points to 'staff.php'
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=delete&id=${employeeId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        e.target.closest('tr').remove();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error deleting employee:', error);
                    alert('Error deleting employee.');
                });
            }
        }
    });
    

});

    </script>
        </body>
        </html>
        