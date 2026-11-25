<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "as";


$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("your request is not found" . mysqli_connect_error());
}

// DELETE FUNCTION
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $sql = "DELETE FROM `ali` WHERE Id = $id";
    mysqli_query($conn, $sql);

    header("Location: editdelete.php");
    exit;
}

// EDIT FUNCTION
$editRow = null;

if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];

    $sql = "SELECT * FROM `ali` WHERE Id = $id";
    $result = mysqli_query($conn, $sql);

    $editRow = mysqli_fetch_assoc($result);
}

// UPDATE FUNCTION
if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];

    $Name = $_POST["Name"];
    $School = $_POST["School"];
    $Class = $_POST["Class"];
    $Board = $_POST["Board"];
    $Contact = $_POST["Contact"];
    $Description = $_POST["Description"];

    $sql = "UPDATE `ali` SET
            `Name`='$Name',
            `Class`='$Class',
            `School`='$School',
            `Board`='$Board',
            `Contact`='$Contact',
            `Description`='$Description'
            WHERE Id=$id";

    mysqli_query($conn, $sql);

    header("Location: editdelete.php");
    exit;
}

// INSERT FUNCTION
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['update'])) {
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
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctmYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .desc-cell {
            min-width: 220px;
            max-width: 320px;
        }
    </style>

    <title>Student Records</title>
</head>

<body class="bg-body-tertiary">
    <nav class="navbar navbar-expand-lg bg-dark sticky-top" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="#">CRUD PROJECT</a>
        </div>
    </nav>

    <main class="container py-4 py-lg-5">

        <!-- Add / Edit student form -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-body py-3">
                <h1 class="h5 mb-0">
                    <?php echo $editRow ? "Edit Student Details" : "Add A Student Details"; ?>
                </h1>
            </div>
            <div class="card-body p-4">

                <form action="editdelete.php" method="POST">

                    <?php if ($editRow) { ?>
                        <input type="hidden" name="id" value="<?php echo $editRow['Id']; ?>">
                    <?php } ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="Name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="Name" name="Name"
                                value="<?php echo htmlspecialchars($editRow['Name'] ?? ''); ?>" placeholder="Full name"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label for="Contact" class="form-label">Contact</label>
                            <input type="tel" class="form-control" id="Contact" name="Contact"
                                value="<?php echo htmlspecialchars($editRow['Contact'] ?? ''); ?>" placeholder="Contact"
                                required>
                        </div>

                        <div class="col-md-4">
                            <label for="Class" class="form-label">Class</label>
                            <input type="text" class="form-control" id="Class" name="Class"
                                value="<?php echo htmlspecialchars($editRow['Class'] ?? ''); ?>" placeholder="Class"
                                required>
                        </div>

                        <div class="col-md-4">
                            <label for="School" class="form-label">School</label>
                            <input type="text" class="form-control" id="School" name="School"
                                value="<?php echo htmlspecialchars($editRow['School'] ?? ''); ?>" placeholder="School"
                                required>
                        </div>

                        <div class="col-md-4">
                            <label for="Board" class="form-label">Board</label>
                            <input type="text" class="form-control" id="Board" name="Board"
                                value="<?php echo htmlspecialchars($editRow['Board'] ?? ''); ?>" placeholder="Board"
                                required>
                        </div>

                        <div class="col-12">
                            <label for="Description" class="form-label">Description</label>
                            <textarea class="form-control" id="Description" name="Description" rows="3"
                                required><?php echo htmlspecialchars($editRow['Description'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <?php if ($editRow) { ?>
                            <button type="submit" name="update" class="btn btn-success px-4">
                                Update Student
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="btn btn-primary px-4">
                                Add student
                            </button>
                        <?php } ?>
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
                                <td class='fw-semibold'>" . htmlspecialchars($row['Name']) . "</td>
                                <td>" . htmlspecialchars($row['Class']) . "</td>
                                <td>" . htmlspecialchars($row['School']) . "</td>
                                <td>" . htmlspecialchars($row['Contact']) . "</td>
                                <td><span class='badge text-bg-secondary'>" . htmlspecialchars($row['Board']) . "</span></td>
                                <td class='desc-cell text-break'>" . htmlspecialchars($row['Description']) . "</td>

                                <td>
                                    <a href='editdelete.php?edit=" . $row['Id'] . "' class='btn btn-sm btn-primary'>Edit</a>

                                    <a href='editdelete.php?delete=" . $row['Id'] . "' class='btn btn-sm btn-danger'>Delete</a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrY7l3lZESLESAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>