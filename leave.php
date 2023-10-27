<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .leave-form {
            background-color: #fff;
            width: 600px;
            height: 600px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group select {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group button {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="leave-form">
        <h2>Leave Request Form</h2>
        <form action="leavesub.php" method="post">
            <div class="form-group">
                <label for="employeeName">Employee Name:</label>
                <input type="text" id="employeeName" name="employeeName" required>
            </div>
            <div class="form-group">
                <label for="managerName">Manager's Name:</label>
                <input type="text" id="managerName" name="managerName" value="Mala KV" readonly>
            </div>
            <div class="form-group">
                <label for="teamLeader">Team Leader:</label>
                <select id="teamLeader" name="teamLeader" required>
                    <option value="sohanraj008@gmail.com">Team Leader 1</option>
                    <option value="sairanjanjagtapp@gmail.com">Team Leader 2</option>
                    <option value="leader3">Team Leader 3</option>
                    <!-- Add more team leaders as needed -->
                </select>
            </div>
            <div class="form-group">
                <label for="leaveType">Leave Type:</label>
                <select id="leaveType" name="leaveType" required>
                    <option value="vacation">Vacation</option>
                    <option value="sick">Sick Leave</option>
                    <option value="personal">Personal Leave</option>
                    <option value="study">Study Leave</option>
                </select>
            </div>
            <div class="form-group">
                <label for="startDate">Start Date:</label>
                <input type="date" id="startDate" name="startDate" required>
            </div>
            <div class="form-group">
                <label for="endDate">End Date:</label>
                <input type="date" id="endDate" name="endDate" required>
            </div>          
            <div class="form-group">
                <button type="submit">Submit Leave Request</button>
            </div>
        </form>
    </div>
</body>

</html>
