<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        .container {
            margin-top: 50px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #343a40;
        }
        table {
            margin-top: 10px;
        }
        th {
            background-color: #f2f2f2;
            color: black;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e9ecef;
        }
        .no-data {
            text-align: center;
            font-size: 1.2em;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Registered Users</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Program Graduated</th>
                    <th>Year Graduated</th>
                    <th>Year of Admission</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <tr>
                    <td colspan="9" class="no-data">Loading user data...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        // Function to fetch user details from the server
        const fetchUserDetails = async () => {
            try {
                const response = await fetch('fetch_users.php'); // Change to your server endpoint
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const users = await response.json();
                displayUsers(users);
            } catch (error) {
                console.error('Error fetching user details:', error);
                document.getElementById('userTableBody').innerHTML = '<tr><td colspan="9" class="no-data">Error loading user data.</td></tr>';
            }
        };

        // Function to display users in the table
        const displayUsers = (users) => {
            const userTableBody = document.getElementById('userTableBody');
            userTableBody.innerHTML = ''; // Clear existing table rows

            if (users.length === 0) {
                userTableBody.innerHTML = '<tr><td colspan="9" class="no-data">No registered users found.</td></tr>';
                return;
            }

            users.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.id_number}</td>
                    <td>${user.fullname}</td>
                    <td>${user.email}</td>
                    <td>${user.contact}</td>
                    <td>${user.dob}</td>
                    <td>${user.sex}</td>
                    <td>${user.program_graduated}</td>
                    <td>${user.year_graduated}</td>
                    <td>${user.admission}</td>
                `;
                userTableBody.appendChild(row);
            });
        };

        // Call the function to fetch user details when the page loads
        document.addEventListener('DOMContentLoaded', fetchUserDetails);
    </script>
</body>
</html>
