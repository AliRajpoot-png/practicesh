<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "as";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("your request is not found" . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST["Name"];
    $School = $_POST["School"];
    $Class = $_POST["Class"];
    $Board = $_POST["Board"];
    $Contact = $_POST["Contact"];
    $Description = $_POST["Description"];

    $sql = "INSERT INTO `ali` (`Name`, `Class`, `School`, `Board`, `Contact`, `Description`)
            VALUES ('$Name', '$Class', '$School', '$Board', '$Contact', '$Description')";
    $result = mysqli_query($conn, $sql);
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .desc-cell {
            min-width: 220px;
            max-width: 320px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-4.1.0.js"
        integrity="sha256-P4IlcYIfOn3YB0zga4ZJhrt/OdwjOrKSQsdxQykVcM4=" crossorigin="anonymous"></script>

    <link href="https://cdn.datatables.net/v/dt/dt-3.1.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/dt-3.1.6/datatables.min.js"></script>
    <script>const table = new DataTable('#myTable', {});</script>


    <title>Student Records</title>
</head>

<body class="bg-body-tertiary">
    <nav class="navbar navbar-expand-lg bg-dark sticky-top" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="#">CRUD PROJECT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-4 py-lg-5">

        <!-- Add student form -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-body py-3">
                <h1 class="h5 mb-0">Add A Student Details</h1>
            </div>
            <div class="card-body p-4">
                <?php if (isset($_GET['success'])) {
                    echo "<script>
        alert('Data submitted successfully!');
    </script>";
                }
                ?>
                <form action="/practicesh/improvedme.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="Name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="Name" name="Name" placeholder="Full name"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="Contact" class="form-label">Contact</label>
                            <input type="tel" class="form-control" id="Contact" name="Contact" placeholder="Contact"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label for="Class" class="form-label">Class</label>
                            <input type="text" class="form-control" id="Class" name="Class" placeholder="Class"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label for="School" class="form-label">School</label>
                            <input type="text" class="form-control" id="School" name="School" placeholder="School"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label for="Board" class="form-label">Board</label>
                            <input type="text" class="form-control" id="Board" name="Board" placeholder="Board"
                                required>
                        </div>
                        <div class="col-12">
                            <label for="Description" class="form-label">Description</label>
                            <textarea class="form-control" id="Description" name="Description" rows="3"
                                required></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">Add student</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Students table -->
        <div class="card shadow-sm">
            <div class="card-header bg-body py-3">
                <h2 class="h5 mb-0">Students</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-hover" id="myTable">
                    <thead class="table table-dark table-hover">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Class</th>
                            <th scope="col">School</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Board</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM `ali`";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                <th scope='row'>" . $row['Id'] . "</th>
                                <td class='fw-semibold'>" . $row['Name'] . "</td>
                                <td>" . $row['Class'] . "</td>
                                <td>" . $row['School'] . "</td>
                                <td>" . $row['Contact'] . "</td>
                                <td><span class='badge text-bg-secondary'>" . $row['Board'] . "</span></td>
                                <td class='desc-cell text-break'>" . $row['Description'] . "</td>
<td> <button class='edit btn btn-sm btn-primary' id='"  . "'>Edit</button> <button class='delete btn btn-sm btn-primary' id='d"  . "'>Delete</button>  </td>                            
                                </tr>";
                        }
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>

    </main>
    <script>
        new DataTable('#myTable');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>