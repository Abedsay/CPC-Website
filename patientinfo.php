
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patient Account Creation</title>
  <style>
body {
  font-family: Arial, sans-serif;
  background-color: #f0f2f5;
}

.container {
  width: 500px;
  margin: 50px auto;
  background-color: #fff; /* White background for form */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
  border-radius: 5px;
  padding: 30px;
}

h1 {
  text-align: center;
  margin-bottom: 20px;
  color: #428bca; /* Blue heading color */
  font-size: 24px; /* Larger heading */
}

.form-group, .insurance {
  margin-bottom: 15px;
}
label {
  display: block;
  margin-bottom: 5px;
  color: #333;
}
input[type="text"],
input[type="email"],
input[type="tel"],
input[type="password"],
textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  font-size: 16px;
}
input[type="radio"] {
  margin-right: 5px;
}

.insurance label[for="insurance_yes"],
.insurance label[for="insurance_no"] {
  margin-right: 10px;
}

input[type="submit"] {
  background-color: #428bca; 
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin-top: 10px;
  cursor: pointer;
  border-radius: 4px;
}

input[type="submit"]:hover {
  background-color: #337ab7; 
}
.insurance {
    display: none;
}
  </style>
</head>
<body>
  <div class="container">
    <h1>Create Patient Account</h1>
    <form action="signupprocess.php" method="post">
      <div class="form-group">
        <label for="name">Full Name:</label>
        <input type="text" name="name" id="name" required placeholder="Name">
      </div>
      <div class="form-group">
        <label for="gender">Gender:</label>
        <input type="radio" name="gender" id="male" value="male" required>Male<br>
        <input type="radio" name="gender" id="female" value="female" required>Female
      </div>
      <div class="form-group">
        <label for="dob">Date of Birth:</label>
        <input type="date" name="dob" id="dob" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required placeholder="Email">
      </div>
      <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="tel" name="phone" id="phone" required placeholder="03123456">
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required placeholder="Enter a strong password">
      </div>
      <div class="form-group">
        <label for="insurance">Do you have health insurance?</label>
        <input type="radio" name="insurance" id="insurance_yes" value="yes" required onclick="showInsuranceInfo()">Yes<br>
        <input type="radio" name="insurance" id="insurance_no" value="no" required onclick="hideInsuranceInfo()">No
      </div>
      <h2 class="insurance">Insurance Information (if applicable)</h2>
      <div class="insurance">
        <label for="insurance_type">Insurance Type:</label>
        <input type="text" name="insurance_type" id="insurance_type" value="Health Insurance" readonly>
      </div>
      <div class="insurance">
        <label for="policy_number">Policy Number:</label>
        <input type="text" name="policy_number" id="policy_number" placeholder="Enter Policy Number">
      </div>
      <div class="insurance">
        <label for="provider">Insurance Provider:</label>
        <input type="text" name="provider" id="provider" placeholder="Enter Insurance Provider">
      </div>
      <div class="insurance">
        <label for="effective_date">Effective Date:</label>
        <input type="date" name="effective_date" id="effective_date" placeholder="YYYY-MM-DD">
      </div>
      <div class="insurance">
        <label for="expiration_date">Expiration Date:</label>
        <input type="date" name="expiration_date" id="expiration_date" placeholder="YYYY-MM-DD">
      </div>
      <div class="form-group">
        <input type="submit" value="Create Account">
      </div>
    </form>
  </div>
  <script>
    function showInsuranceInfo() {
        const insuranceInfos = document.getElementsByClassName("insurance");
        for (let i = 0; i < insuranceInfos.length; i++) {
            insuranceInfos[i].style.display = "block";
        }
    }
    function hideInsuranceInfo() {
        const insuranceInfos = document.getElementsByClassName("insurance");
        for (let i = 0; i < insuranceInfos.length; i++) {
            insuranceInfos[i].style.display = "none";
        }
    }
  </script>
</body>
</html>