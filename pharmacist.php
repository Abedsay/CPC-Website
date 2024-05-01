<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "clinic";
$conn = new mysqli($servername, $username, $password, $database, "3308");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql_pre = "SELECT prescription.preid
FROM prescription JOIN patient ON prescription.id = patient.id
WHERE prescription.seenbyphar=1";


$stmt2 = $conn->prepare($sql_pre);
$stmt2->execute();
$result2 = $stmt2->get_result();
$prescriptions = [];
while($row = $result2->fetch_assoc()) {
    $prescriptions[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="med.js"></script>
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
            position: relative;
            width: 250px;
            /* Adjust width as necessary */
            background-color: #fff;
            /* Adjust color as necessary */
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

        /* Styles for vitals and appointments to match the design */
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

        /* Add this to your styles.css file */

        .sidebar {
            width: 250px;
            background: #f8f9fa;
            padding: 20px;
            height: 100vh;
            /* Adjust height as needed */
        }

        .sidebar .logo {
            text-align: center;
            padding-bottom: 15px;
            padding-top: 15px;
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

        /* Add this to your styles.css file */

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
            align-items: center;
            cursor: pointer;
        }

        .user-icon {
            margin-right: 5px;
            /* Replace this text icon with an actual icon from an icon library */
        }


        /* Add more specific styles as needed */


        .reports-section,
        .calendar-section {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            grid-row: 1 / span 2;
            /* Makes them stretch over two rows */
        }

        h2 {
            margin-bottom: 20px;
        }

        .report-item,
        .appointment {
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .report-item:hover,
        .appointment:hover {
            background-color: #f4f4f4;
        }

        .report-info,
        .appointment-info {
            margin-left: 15px;
        }

        .fa-vial,
        .fa-chevron-right {
            color: #7f8c8d;
        }

        .date-highlight {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
            border-radius: 8px;
        }

        .banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background-color: #0056b3;
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .banner-content h1 {
            font-size: 1.5em;
            /* Adjust size as needed */
            margin: 0 0 10px 0;
        }

        .banner-content p {
            margin: 0;
        }

        .banner-image img {
            max-height: 100%;
            float: right;
            /* Adjust size as needed */
        }

        .vitals-section {
            background-color: #f9f9f9;
            /* Light grey background */
            padding: 20px;
            /* Adjust padding as needed */
            border-radius: 8px;
            /* Rounded corners for the section */

            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .vitals-cards {
            display: flex;
            justify-content: space-between;
            /* Distributes space evenly */
        }

        .vital-card {
            background-color: #fff;
            /* White background for cards */
            padding: 10px 20px;
            /* Padding inside cards */
            border-radius: 8px;
            /* Rounded corners for cards */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for depth */
            width: 22%;
            /* Adjust width as needed */
        }

        .vital-card h3 {
            margin: 0 0 10px 0;
            /* Spacing below headings */
            font-size: 0.9em;
            /* Smaller font size for headings */
        }

        .vital-card p {
            margin: 0;
            /* No margin for paragraph to keep things tight */
            font-weight: bold;
            /* Bold for the numbers */
            font-size: 1.2em;
            /* Larger font size for numbers */
        }

        .appointments-section {
            background-color: #f9f9f9;
            /* Light grey background */
            border-radius: 8px;
            /* Rounded corners for the section */

            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .appointments-table {
            width: 100%;
            border-collapse: collapse;
        }

        .appointments-table thead th {
            background-color: #ecf0f1;
            color: #333;
            text-align: left;
            padding: 10px;
        }

        .appointments-table tbody td {
            padding: 10px;
            border-bottom: 1px solid #ecf0f1;
        }

        .status {
            padding: 5px 10px;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            text-align: center;
            display: inline-block;
        }

        .status.active {
            background-color: #27ae60;
        }

        .status.upcoming {
            background-color: #2980b9;
        }

        .status.completed {
            background-color: #95a5a6;
        }

        .appointments-table img {
            width: 30px;
            /* Adjust size as needed */
            border-radius: 50%;
            margin-right: 10px;
        }

        @media (max-width: 768px) {

            .sidebar,
            .left-column,
            .right-column {
                width: 100%;
                /* Ensures that sidebar and content columns take full width */
                height: auto;
                /* Height auto for proper sizing */
            }

            .main-content,
            .dashboard-grid {
                margin-left: 0;
                padding-left: 0;
                /* Removes any margin or padding that pushes content to the side */
            }

            .dashboard-grid {
                display: block;
                /* Stacks the left and right columns */
            }

            .content-section {
                /* Ensure all content sections take full width and display one after another */
                display: block;
                width: 100%;
            }
        }

        @media (max-width: 1024px) {

            /* You might not need this if the above media query already handles up to 1024px width */
            .dashboard-grid {
                grid-template-columns: 1fr;
                /* Adjust if you are using a grid display */
            }

            .reports-section,
            .calendar-section,
            .content-section {
                margin-bottom: 20px;
                /* Ensures a margin at the bottom of sections */
            }

            /* Add more specific styles if needed */
        }


        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;

            /* Adjust the '300px' to fit the width of your sidebar */
            column-gap: 20px;
            /* Space between columns */
        }

        .right-column {
            /* This column will contain the reports and calendar */
            display: flex;
            flex-direction: column;
            height: fit-content;
        }

        .sidebar .navigation a.active {
            background-color: #0056b3;
            color: white;
        }

        .content-section {
            padding: 20px;
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            height: 100vh;
            max-height: calc(100vh - 130px);
        }

        .content-section h2 {
            color: #2c3e50;
            /* Dark blue color matching the theme */
            margin-bottom: 10px;
            /* Space below the header */
            font-size: 1.25rem;
            /* Slightly larger font size */
            border-bottom: 2px solid #eaeaea;
            /* Light line for separation */
            padding-bottom: 5px;
            /* Space between text and line */
            width: 100%; /* Make sure it takes full width */
            box-sizing: border-box;
        }

        /* Styles for lists within content sections */
        .content-section ul {
            list-style: none;
            /* Remove default list styles */
            padding: 0;
            /* Remove default padding */
            margin: 0;
            /* Remove default margin */
        }

        .content-section ul li {
            background-color: #f8f9fa;
            /* Light grey background for each item */
            padding: 10px 15px;
            /* Padding inside list items */
            border-radius: 5px;
            /* Rounded corners for list items */
            margin-bottom: 8px;
            /* Space between list items */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
            /* Very subtle shadow for depth */
            font-size: 0.9rem;
            /* Slightly reduced font size */
            color: #333;
            /* Dark grey color for text */
        }

        .content-section ul li:last-child {
            margin-bottom: 0;
            /* No margin for the last item */
        }

        /* Style for the notifications button */

        .notifications-section {
            position: absolute;
            left: 57%;
            bottom: 10px;
            /* Adjust as needed */
            transform: translateX(-50%);
            width: 100%;
        }

        .notifications-section button {
            width: calc(100% - 40px);
            /* Account for padding */
            padding: 10px 20px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Style for the notifications popup */
        .notification-popup {
            display: block;
            /* Initially hidden */
            position: absolute;
            right: -410px;
            /* Width of sidebar plus some offset */
            width: 400px;
            max-height: 400px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
            z-index: 10;
            padding: 10px;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .notification-item {
            background-color: #f3f3f3;
            /* Light background for each item */
            border-radius: 4px;
            /* Rounded corners for each item */
            padding: 10px;
            /* Padding inside each item */
            margin-bottom: 10px;
            /* Space between items */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            /* Subtle shadow for each item */
            list-style-type: none;
            /* Remove list bullets */
        }

        .notification-item:last-child {
            margin-bottom: 0;
            /* Remove margin for the last item */
        }

        .notification-time {
            color: #6c757d;
            /* Muted text color */
            font-size: 0.8em;
            /* Smaller text */
            margin-bottom: 4px;
            /* Space between time and username */
        }

        .notification-sender {
            font-weight: bold;
            /* Bold username */
            margin-bottom: 4px;
            /* Space between username and comment */
        }

        .notification-comment {
            font-size: 0.9em;
            /* Slightly smaller text for comments */
        }

        .toggle-suggest-btn {
            display: block;
            margin: 0 auto;
            /* Centers the button horizontally */
            background: none;
            border: none;
            color: #333;
            /* Color of the arrow, make sure it's visible on the background */
            font-size: 24px;
            /* Adjust the size of the arrow as needed */
            cursor: pointer;
        }

        .announcement-toggle-container {
            position: sticky;
            bottom: 0;
            background-color: #fff;
            padding: 10px;
            border-top: 1px solid #eee;
        }

        .toggle-suggest-btn i {
            color: #333;
            /* Or any color that would show up against the button background */
        }

        .announcement-form {
            display: block;
            padding: 10px;
            border-top: 1px solid #eee;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        #announcementText {
            width: 100%;
            /* Ensure the textarea spans the width of the popup */
            padding: 8px;
            margin-bottom: 10px;
            /* Space between textarea and button */
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
            /* Allow vertical resizing */
        }

        .announcement-form button {
            background-color: #5cb85c;
            /* A green submit button */
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .announcement-content {
            overflow-y: auto;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
        }

        .download-button {
            display: inline-flex;
            /* Aligns the icon and text */
            align-items: center;
            /* Centers items vertically */
            justify-content: center;
            /* Centers items horizontally */
            margin-left: 15px;
            /* Adds space between the text and the button */
            padding: 8px 12px;
            /* Size of the button */
            background-color: #0056b3;
            /* Theme color for the button background */
            color: white;
            /* Text color */
            text-decoration: none;
            /* Removes underline from links */
            border-radius: 4px;
            /* Rounded corners */
            font-size: 0.8rem;
            /* Size of the text */
            transition: background-color 0.3s;
            /* Smooth transition for hover effect */
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            /* For anchor tag buttons */
        }

        /* Download button specific styles */


        /* Submit button specific styles */
        .submit-button {
            background-color: #28a745;
            /* Green color for submit action */
            color: white;
            /* Text color */
        }

        .button i {
            margin-right: 5px;
            /* Adds a small space between the icon and text */
        }

        .button:hover,
        .button:focus {
            opacity: 0.8;
            outline: none;
            /* Remove outline if focused */
        }

        #uploadForm label {
            display: block;
            /* Labels appear above inputs */
            margin-top: 10px;
            /* Space above each label */
            color: #333;
            /* Dark grey color for text */
        }

        /* Styles for form inputs */
        #uploadForm input[type="text"],
        #uploadForm input[type="file"] {
            width: 100%;
            /* Full width */
            padding: 10px;
            /* Comfortable padding inside inputs */
            margin-top: 5px;
            /* Space between label and input */
            margin-bottom: 10px;
            /* Space between inputs */
            border: 1px solid #ccc;
            /* Subtle border */
            border-radius: 4px;
            /* Rounded corners */
        }

        /* Styles for the form submit button */
        #uploadForm button {
            background-color: #28a745;
            /* Green color to indicate 'upload' action */
            color: white;
            /* Text color */
            padding: 10px 15px;
            /* Button size */
            border: none;
            /* No border */
            border-radius: 4px;
            /* Rounded corners */
            cursor: pointer;
            /* Cursor indicates button */
            margin-top: 10px;
            /* Space above the button */
            transition: background-color 0.3s;
            /* Transition for hover effect */
            border-radius: 15px;
        }

        #uploadForm button:hover {
            background-color: #218838;
            /* Darker green on hover */
        }

        /* Style for the lab test cards container */
        .lab-tests-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Style for individual lab test cards */
        .lab-test-card {
            background-color: #f3f3f3;
            /* Light gray background similar to the appointments */
            padding: 20px;
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Slight shadow for depth */
            display: flex;
            justify-content: space-between;
            /* Space out the details and buttons */
            align-items: center;
            margin-bottom: 10px;
            /* Space between cards */
        }

        /* Style for lab test details */
        .lab-test-details {
            /* If you want to align items to start, you can uncomment the next line */
            /* align-items: flex-start; */
            flex-grow: 1;
            /* Allow details to fill space */
        }

        /* Style for the buttons group */
        .lab-test-buttons {
            display: flex;
            gap: 10px;
            /* Space between buttons */
        }

        /* Styling the buttons */
        .download-button {
            background-color: #0056b3;
            /* Blue background */
            color: white;
            /* White text */
            border: none;
            border-radius: 15px;
            /* Rounded corners */
            padding: 10px 15px;
            /* Padding inside buttons */
            cursor: pointer;
            /* Pointer cursor on hover */
            text-decoration: none;
            /* Remove underline from links if using <a> tags */
            font-size: 0.9em;
            transition: background-color 0.2s;
            /* Smooth color transition on hover */
        }

        .submit-button {
            background-color: #28a745;
            /* Blue background */
            color: white;
            /* White text */
            border: none;
            border-radius: 15px;
            /* Rounded corners */
            padding: 10px 15px;
            /* Padding inside buttons */
            cursor: pointer;
            /* Pointer cursor on hover */
            text-decoration: none;
            /* Remove underline from links if using <a> tags */
            font-size: 0.9em;
            transition: background-color 0.2s;
            /* Smooth color transition on hover */
        }

        /* Hover effect for buttons */
        .download-button:hover {
            background-color: #003d82;
            /* Slightly darker blue on hover */
        }

        .submit-button:hover {
            background-color: #218838;
            /* Slightly darker blue on hover */
        }

        /* Adjust the button styles if they are anchors */
        a.download-button,
        a.submit-button {
            display: inline-block;
            /* Allows padding and margin adjustments */
        }

        .otification-popup {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .messaging-container {
            display: flex;
            width: 100%;
            background-color: #F0F2F5;
            height: 99vh;
            max-height: calc(100vh - 130px);
            border-radius: 8px;
        }

        .contact-list {
            width: 25%;
            background: #fff;
            overflow-y: auto;
            border-right: 1px solid #ddd;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .chat-area {
            width: 75%;
            display: flex;
            flex-direction: column;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .chat-header {
            background-color: #f5f5f5;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        .chat-messages {
            flex-grow: 1;
            overflow-y: auto;
        }

        .chat-input-area {
            padding: 15px;
            background-color: #fff;
            border-top: 1px solid #ddd;
            display: flex;
            align-items: center;
        }

        .chat-input-area input {
            flex-grow: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
            margin-right: 10px;
        }

        .contact-list {
            width: 350px;
            background-color: #ffffff;
            padding: 20px;
            overflow-y: auto;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
        }

        .search-bar {
            position: relative;
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 100%;
            padding: 10px 40px 10px 20px;
            border-radius: 20px;
            border: 1px solid #e6e6e6;
            font-size: 14px;
        }

        .search-button {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
        }

        .chat-tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .tab {
            background: none;
            border: none;
            padding-bottom: 10px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            color: #9a9a9a;
        }

        .tab.active {
            color: #000000;
            border-bottom: 2px solid #0056b3;
        }

        .contact {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 10px;
            transition: background-color 0.2s ease-in-out;
            cursor: pointer;
        }

        .contact:hover {
            background-color: #f2f2f2;
        }

        .contact img {
            border-radius: 50%;
            width: 45px;
            height: 45px;
            object-fit: cover;
            margin-right: 10px;
        }

        .contact-info h5 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .contact-info p {
            font-size: 12px;
            color: #9a9a9a;
        }

        .contact-time {
            margin-left: auto;
            font-size: 12px;
            color: #9a9a9a;
        }

        .chat-area {
            background: #fff;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #ddd;
            background-color: #f5f5f5;
        }

        .chat-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .chat-info h4 {
            margin: 0;
            font-weight: 500;
        }

        .chat-info p {
            margin: 0;
            font-size: 0.9em;
            color: #4caf50;
        }

        .chat-options {
            margin-left: auto;
        }

        .chat-messages {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .message {
            padding: 10px 15px;
            border-radius: 20px;
            margin-bottom: 10px;
            max-width: 60%;
            word-wrap: break-word;
        }

        .message.sent {
            background-color: #e6f7ff;
            align-self: flex-end;
        }

        .message.received {
            background-color: #f0f0f0;
            align-self: flex-start;
        }

        .message-time {
            display: block;
            text-align: right;
            color: #999;
            font-size: 0.8em;
        }

        .chat-input {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .chat-input input {
            flex: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
            margin-right: 10px;
        }

        .send-button {
            border: none;
            background: #0056b3;
            color: #fff;
            padding: 10px 15px;
            border-radius: 20px;
            cursor: pointer;
        }

        /* More detailed styling and responsiveness */
        #messagesSection {
            padding: 0px;
            height: 99vh;
            max-height: calc(100vh - 130px);
        }

        .sidebar {
            width: 250px;
            background: #010C80;
            padding: 20px;
            height: 100vh;
        }

        .sidebar .logo {
            text-align: center;
            padding-bottom: 20px;
        }

        .sidebar img {
            width: 100%;
            height: 100%;
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
            width: 100%;
            height: 100%;
            border-radius: 10px;
        }

        .sidebar .navigation a.active,
        .sidebar .navigation a:hover {
            background-color: #4B91F1;
            color: white;
        }

        .sidebar .navigation a i.icon {
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
        .medication-storage {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    padding: 20px;
}

.medication-card {
    background-color: #f3f3f3;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 10px;
    text-align: center;
}

.medication-image {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
    margin-bottom: 10px;
    width: 150px; /* Adjust the width as needed */
    height: 200px; /* Adjust the height as needed */
    object-fit: contain; 
}

.medication-name {
    font-size: 1rem;
    margin-bottom: 5px;
}

.quantity-adjuster {
    display: flex;
    align-items: center;
    justify-content: center;
}

.decrease-quantity,
.increase-quantity {
    background-color: #eee;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
}

.quantity {
    margin: 0 10px;
}

#saveStorageButton {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 20px;
    display: block;
    width: 100%;
}

.storage-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#viewStorage h2 {
    margin: 0; /* Adjust as necessary */
}
.medication-storage-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%; /* Make sure it takes full width */
    box-sizing: border-box;
}

.save-button {
    background-color: #28a745; /* Blue background */
    color: white; /* White text */
    border: none;
    border-radius: 15px; /* Rounded corners */
    padding: 10px 15px; /* Padding inside buttons */
    cursor: pointer; /* Pointer cursor on hover */
    text-decoration: none; /* Remove underline from links if using <a> tags */
    font-size: 0.9em;
    transition: background-color 0.2s; /* Smooth color transition on hover */
}
/* Hover effect for buttons */
.save-button:hover {
    background-color: #218838; /* Slightly darker blue on hover */
}
/* Adjust the button styles if they are anchors */
a.save-button {
    display: inline-block; /* Allows padding and margin adjustments */
}

        /* Additional styling as needed for responsiveness and positioning */

        /* Add more detailed styling for calendar and fonts */

        /* Include FontAwesome CSS */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');

        /* Add responsive design and more detailed styles as necessary */
        .buttons-container {
    display: flex;
    align-items: center;
  }
    .view-records {
        background-color: #007bff;
    }
    .submit-records {
        background-color: #007bff;
    }
    .generate-records {
        background-color: #28a745;
    }
    .record-entry {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            border-bottom: 1px solid #eaeaea;
        }
        .record-info {
            display: flex;
            align-items: center;
        }
        .record-details {
            display: flex;
            flex-direction: column;
        }
  .button {
    text-align: center;
    padding: 8px 16px;
    margin: 0 4px;
    border: none;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: bold;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s;
  }
    </style>
</head>


<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="assets/images/WhatsApp Image 2024-04-20 at 1.59.26 PM.jpeg" alt="HealthCare Logo">
        </div>
        <br>
        <nav class="navigation">
            <a href="#" onclick="showSection('viewStorage', event);" class="active"><i class="fas fa-vials"></i>&nbsp;Storage</a>
            <a href="#" onclick="showSection('viewPrescriptions', event);"><i class="fas fa-envelope"></i>&nbsp;Prescriptions</a>
            <a href="#" onclick="showSection('messagesSection', event);"><i class="fas fa-bell"></i>&nbsp;Notifications</a>
        </nav>

    </aside>
    <div class="main-content">
        <header class="main-header">
            <div class="greeting">
                <h1>Welcome, Pharmacist!</h1>
                <p>Review and manage your medication storage easily.</p>
            </div>
            <div class="search-and-user">
                <div class="search-container">
                    <i class="search-icon">🔍</i>
                    <input type="text" placeholder="Search">
                </div>
            </div>
        </header>

        <div class="dashboard-grid">
            <div class="left-column">
                <div id="viewStorage" class="content-section" style="display: block;">
                    <div class="medication-storage-header">
                        <h2>Medication Storage</h2>
                        <button id="save-button" class="save-button">Save</button>
                    </div>                    
                    <div class="medication-storage">    
                        <!-- Repeat this structure for each medication -->
                        <div class="medication-card">
                            <img src="assets/Aspirin.jpg" alt="Medication Name" class="medication-image">
                            <div class="medication-info">
                                <h3 class="medication-name">Aspirin</h3>
                                <div class="quantity-adjuster">
                                    <button class="decrease-quantity">-</button>
                                    <span class="quantity">10</span>
                                    <button class="increase-quantity">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="medication-card">
                            <img src="assets/Diphenhydramine.jpg" alt="Medication Name" class="medication-image">
                            <div class="medication-info">
                                <h3 class="medication-name">Diphenhydramine</h3>
                                <div class="quantity-adjuster">
                                    <button class="decrease-quantity">-</button>
                                    <span class="quantity">10</span>
                                    <button class="increase-quantity">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="medication-card">
                            <img src="assets/Loratadine.jpg" alt="Medication Name" class="medication-image">
                            <div class="medication-info">
                                <h3 class="medication-name">Loratadine</h3>
                                <div class="quantity-adjuster">
                                    <button class="decrease-quantity">-</button>
                                    <span class="quantity">10</span>
                                    <button class="increase-quantity">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="medication-card">
                            <img src="assets/Ibuprofen.jpg" alt="Medication Name" class="medication-image">
                            <div class="medication-info">
                                <h3 class="medication-name">Ibuprofen</h3>
                                <div class="quantity-adjuster">
                                    <button class="decrease-quantity">-</button>
                                    <span class="quantity">10</span>
                                    <button class="increase-quantity">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="medication-card">
                            <img src="assets/Acetaminophen.jpg" alt="Medication Name" class="medication-image">
                            <div class="medication-info">
                                <h3 class="medication-name">Acetaminophen</h3>
                                <div class="quantity-adjuster">
                                    <button class="decrease-quantity">-</button>
                                    <span class="quantity">10</span>
                                    <button class="increase-quantity">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="medication-card">
                            <img src="assets/Bismuth Subsalicylate.jpg" alt="Medication Name" class="medication-image">
                            <div class="medication-info">
                                <h3 class="medication-name">Bismuth Subsalicylate</h3>
                                <div class="quantity-adjuster">
                                    <button class="decrease-quantity">-</button>
                                    <span class="quantity">10</span>
                                    <button class="increase-quantity">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="medication-card">
                            <img src="assets/Loperamide.png" alt="Medication Name" class="medication-image">
                            <div class="medication-info">
                                <h3 class="medication-name">Loperamide</h3>
                                <div class="quantity-adjuster">
                                    <button class="decrease-quantity">-</button>
                                    <span class="quantity">10</span>
                                    <button class="increase-quantity">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="medication-card">
                            <img src="assets/Calcium Carbonate.jpg" alt="Medication Name" class="medication-image">
                            <div class="medication-info">
                                <h3 class="medication-name">Calcium Carbonate</h3>
                                <div class="quantity-adjuster">
                                    <button class="decrease-quantity">-</button>
                                    <span class="quantity">10</span>
                                    <button class="increase-quantity">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="medication-card">
                            <img src="assets/Saline nasal spray.jpg" alt="Medication Name" class="medication-image">
                            <div class="medication-info">
                                <h3 class="medication-name">Saline Nasal Spray</h3>
                                <div class="quantity-adjuster">
                                    <button class="decrease-quantity">-</button>
                                    <span class="quantity">10</span>
                                    <button class="increase-quantity">+</button>
                                </div>
                            </div>
                        </div>

                        <!-- End of medication card -->
                    </div>
                </div>
                <div id="viewPrescriptions" class="content-section" style="display: none;"> 
                    <h2 class="record-name">Prescriptions</h2>
                    <div class="list-container">
                        <?php foreach ($prescriptions as $prescription): ?>
                        <div class="record-entry">
                            <div class="record-info">
                                <div class="record-details">
                                    <div class="record-id">Prescription ID: <?= htmlspecialchars($prescription['preid'])?></div>
                                </div>
                            </div>
                            <div class="buttons-container">
                                <a href="viewprescription.php?preid=<?= htmlspecialchars($prescription['preid']) ?>">
                                <button class="button view-records">View Record</button></a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div id="messagesSection" class="content-section" style="display: none;">
                    <div class="messaging-container">
                        <aside class="contact-list">
                            <div class="search-bar">
                                <input type="text" placeholder="Search">
                                <button class="search-button"><i class="fas fa-search"></i></button>
                            </div>

                            <div class="contact" data-doctor-id="doctor1">
                                <img src="assets/dr1.webp" alt="Dr. Lionel Messie">
                                <div class="contact-info">
                                    <h5>Dr. Lionel Messie</h5>
                                    <p>House, my patient needs a new kidney!</p>
                                </div>
                                <span class="contact-time">15:30</span>
                            </div>
                            <div class="contact" data-doctor-id="doctor2">
                                <img src="assets/dr1.webp" alt="Dr. Lionel Messie">
                                <div class="contact-info">
                                    <h5>Dr. Lionel Messie</h5>
                                    <p>House, my patient needs a new kidney!</p>
                                </div>
                                <span class="contact-time">15:30</span>
                            </div>
                            <div class="contact" data-doctor-id="doctor3">
                                <img src="assets/dr1.webp" alt="Dr. Lionel Messie">
                                <div class="contact-info">
                                    <h5>Dr. Lionel Messie</h5>
                                    <p>House, my patient needs a new kidney!</p>
                                </div>
                                <span class="contact-time">15:30</span>
                            </div>

                        </aside>

                        <section class="chat-area">
                            <header class="chat-header">
                                <img src="assets/dr1.webp" alt="Dr. Lionel Messie" class="chat-avatar">
                                <div class="chat-info">
                                    <h4>Dr. Lionel Messie</h4>
                                    <p>Online</p>
                                </div>
                                <div class="chat-options">
                                    <i class="fas fa-ellipsis-h"></i>
                                </div>
                            </header>
                            <div class="chat-messages">
                                <div class="message sent">
                                    <p>Thanks for your help!</p>
                                    <span class="message-time">16:30</span>
                                </div>
                                <div class="message received">
                                    <p>House, my patient needs a new kidney! If you can help or arrange it will be an
                                        honor for us.</p>
                                    <span class="message-time">15:30</span>
                                </div>
                            </div>

                        </section>

                    </div>
                </div>


            </div>
            <div class="right-column">
                <!-- The new container for announcements -->
                <div id="announcementsSection" class="ontent-section">
                    <div id="notificationPopup" class="otification-popup">
                        <div class="announcement-content">
                            <div class="notification-item">
                                <div class="notification-time">10:30 AM</div>
                                <div class="notification-sender">Clinic</div>
                                <div class="notification-comment">Flu Shot Clinic: Oct 26, 10AM-2PM</div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-time">11:00 AM</div>
                                <div class="notification-sender">Pediatrics</div>
                                <div class="notification-comment">Story Time: Nov 5, 11AM (Waiting Room)</div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-time">11:30 AM</div>
                                <div class="notification-sender">Dr. Smith</div>
                                <div class="notification-comment">Adjusted hours next week. See website.</div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-time">12:00 PM</div>
                                <div class="notification-sender">Dr. Jones</div>
                                <div class="notification-comment">Telemedicine appointments now available!</div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-time">12:30 PM</div>
                                <div class="notification-sender">Clinic</div>
                                <div class="notification-comment">Closed Dec 25th (Christmas).</div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-time">01:00 PM</div>
                                <div class="notification-sender">Clinic</div>
                                <div class="notification-comment">New Patient Portal! See website for details.</div>
                            </div>
                        </div>
                    </div>
                    <div class="announcement-form">
                        <h3>Suggest an Announcement</h3>
                        <form id="announcementForm">
                            <textarea id="announcementText" placeholder="Type your announcement..." rows="3"></textarea>
                            <button type="submit" onclick="submitAnnouncement(event)">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>