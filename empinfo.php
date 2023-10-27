<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/ffc92e568f.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Information</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="./styles/empinfo.css">
    <style>
        /* Set a fixed width for input fields */
        .input-field {
            width: 100%;
        }
    </style>
</head>
<body>
    <a href="index.html" class="bzx"><i class="fa-solid fa-house fa-2xl"></i></a>
    <div class="container">
        <h1>Employee Information</h1>
        <table>
            <thead>
                <tr>
                <th onclick="sortTable(0)">SL.No <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(1)">Name <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(2)">Employee ID <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(3)">Title <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(4)">Email <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(5)">Phone <i class="fas fa-sort"></i></th>
                    <th onclick="sortTable(6)">Aadhar Number <i class="fas fa-sort"></i></th>
                    <th>Password <i class="fas fa-sort"></i></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Database connection
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "employees";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch data from the database
                    $sql = "SELECT * FROM employee_info";
                    $result = $conn->query($sql);

                    $serialNumber = 1; // Initialize the serial number

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>".$serialNumber."</td>
                                    <td><span class='text-field'>".$row["name"]."</span><input type='text' class='input-field' name='name' value='".$row["name"]."' style='display: none;'></td>
                                    <td><span class='text-field'>".$row["employee_id"]."</span><input type='text' class='input-field' name='employee_id' value='".$row["employee_id"]."' style='display: none;'></td>
                                    <td><span class='text-field'>".$row["title"]."</span><input type='text' class='input-field' name='title' value='".$row["title"]."' style='display: none;'></td>
                                    <td><span class='text-field'>".$row["email"]."</span><input type='text' class='input-field' name='email' value='".$row["email"]."' style='display: none;'></td>
                                    <td><span class='text-field'>".$row["phone"]."</span><input type='text' class='input-field' name='phone' value='".$row["phone"]."' style='display: none;' minlength='10' maxlength='10'></td>
                                    <td><span class='text-field'>".$row["aadhar_number"]."</span><input type='text' class='input-field' name='aadhar_number' value='".$row["aadhar_number"]."' style='display: none;' minlength='12' maxlength='12'></td>
                                    <td><span class='text-field'>".$row["password"]."</span><input type='text' class='input-field' name='password' value='".$row["password"]."' style='display: none;'></td>
                                    <td>
                                    <button class='edit-button' data-id='".$row["id"]."'><i class='fas fa-pencil-alt'></i></button>
                                    <button class='save-button' data-id='".$row["id"]."' style='display: none;'><i class='fas fa-check'></i></button>
                                    <button class='cancel-button' data-id='".$row["id"]."' style='display: none;'><i class='fas fa-times'></i></button>
                                    </td>
                                </tr>";

                            $serialNumber++; // Increment the serial number
                        }
                    } else {
                        echo "<tr><td colspan='9'>No data available</td></tr>";
                    }
                    // Close connection
                    $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <link rel="stylesheet" href="./styles/empinfo.css">
    <script>
        function sortTable(columnIndex) {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.querySelector("table");
        switching = true;
        
        // Set the sorting direction to ascending:
        var dir = "asc";
        var arrow = table.getElementsByTagName("th")[columnIndex].getElementsByTagName("i")[0];
        
        while (switching) {
            switching = false;
            rows = table.getElementsByTagName("tr");
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[columnIndex];
                y = rows[i + 1].getElementsByTagName("td")[columnIndex];
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
        // Toggle sorting direction
        if (dir == "asc") {
            dir = "desc";
            arrow.classList.remove("fa-sort");
            arrow.classList.remove("fa-sort-up");
            arrow.classList.add("fa-sort-down");
        } else {
            dir = "asc";
            arrow.classList.remove("fa-sort");
            arrow.classList.remove("fa-sort-down");
            arrow.classList.add("fa-sort-up");
        }
    }
    document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".edit-button");
    const saveButtons = document.querySelectorAll(".save-button");
    const cancelButtons = document.querySelectorAll(".cancel-button");

    editButtons.forEach((editButton) => {
        editButton.addEventListener("click", function () {
            const row = editButton.parentElement.parentElement;
            const saveButton = row.querySelector(".save-button");
            const cancelButton = row.querySelector(".cancel-button");
            const textFields = row.querySelectorAll(".text-field");
            const inputFields = row.querySelectorAll(".input-field");

            textFields.forEach((textField) => {
                textField.style.display = "none";
            });

            inputFields.forEach((inputField) => {
                inputField.style.display = "block";
            });

            editButton.style.display = "none";
            saveButton.style.display = "block";
            cancelButton.style.display = "block";
        });
    });

    saveButtons.forEach((saveButton) => {
        saveButton.addEventListener("click", function () {
            const row = saveButton.parentElement.parentElement;
            const editButton = row.querySelector(".edit-button");
            const textFields = row.querySelectorAll(".text-field");
            const inputFields = row.querySelectorAll(".input-field");

            const formData = new FormData();
            formData.append("id", saveButton.getAttribute("data-id"));

            let isValid = true; // Flag to check input validity

            inputFields.forEach((inputField) => {
                const value = inputField.value.trim();
                if (value === "") {
                    isValid = false;
                    inputField.setCustomValidity("Please fill in this field.");
                    return;
                }
                formData.append(inputField.name, value);
                inputField.style.display = "none";
            });

            if (!isValid) {
                inputFields.forEach((inputField) => {
                    inputField.reportValidity();
                });
                return;
            }

            textFields.forEach((textField, index) => {
                textField.style.display = "block";
                textField.textContent = inputFields[index].value; // Update with edited value
            });

            editButton.style.display = "block";
            saveButton.style.display = "none";

            // Send an AJAX request to update the data
            fetch("update_employee.php", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Employee information updated successfully.");
                } else {
                    console.error("Error updating employee information.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        });
    });

    cancelButtons.forEach((cancelButton) => {
        cancelButton.addEventListener("click", function () {
            const row = cancelButton.parentElement.parentElement;
            const editButton = row.querySelector(".edit-button");
            const textFields = row.querySelectorAll(".text-field");
            const inputFields = row.querySelectorAll(".input-field");

            inputFields.forEach((inputField) => {
                inputField.style.display = "none";
            });

            textFields.forEach((textField, index) => {
                textField.style.display = "block";
                textField.textContent = inputFields[index].value; // Restore original value
            });

            editButton.style.display = "block";
            cancelButton.style.display = "none";
            saveButton.style.display = "none";
        });
    });
});

    </script>
</body>
</html>
