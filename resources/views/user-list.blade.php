<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Summary</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }

        img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
        }

        .photo-box {
            width: 80px;
            height: 80px;
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
        }

        .hidden-file {
            display: none;
        }
    </style>
</head>

<body style="background-color: lightgray;">
    <div>
        <br>
        <h2>User Summary</h2>
        <table>

            <tbody id="user-list">
                <!-- Users will be inserted here dynamically -->
            </tbody>
        </table>

        <script>
            $(document).ready(function() {
                function fetchUsers() {
                    $.ajax({
                        url: "/api/users",
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            let usersHtml = "";
                            response.forEach(user => {
                                let imageUrl = user.photo_url ? `${user.photo_url}` :
                                    "https://via.placeholder.com/50";

                                usersHtml += `
    <tr>
        <td>
            <img id="user-img-${user.id}" src="${imageUrl}" alt="User Image">
        </td>
                                        <td>${user.name}</td>
                                        <td>${user.email}</td>
                                        <td>${user.position}</td>
                                        <td>${user.role}</td>
                                    </tr>
                                `;
                            });
                            $("#user-list").html(usersHtml);

                            // Attach event listeners after users are loaded
                            $("input[type='file']").on("change", function() {
                                let userId = $(this).data("user-id");
                                let file = this.files[0];

                                if (file) {
                                    previewImage(userId, file);
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching users:", error);
                        }
                    });
                }

                function previewImage(userId, file) {
                    // Create a URL for the file object
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        // Update the image source with the selected image
                        $(`#user-img-${userId}`).attr("src", event.target.result);
                    };
                    reader.readAsDataURL(file);
                }

                fetchUsers(); // Fetch users on page load
            });
        </script>
    </div>
</body>

</html>
