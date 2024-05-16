<?php
if (isset($_POST['logout'])) {
    if (isset($_COOKIE["login-user"])) {
        // Unset the cookie by setting its expiration time to the past
        setcookie("login-user", "", time() - 3600);
        $message = "LogOut Successful.";
        echo '<script>';
        echo 'alert("' . $message . '");';
        echo 'setTimeout(function() { window.location.href = "home.php"; }, 1000);';
        echo '</script>';
    } else {
        $message = "Error, do not have any cookies.";
        echo '<script>';
        echo 'alert("' . $message . '");';
        echo 'setTimeout(function() { window.location.href = "home.php"; }, 1000);';
        echo '</script>';
    }
}
?>

<?php
$header = array(
    "event_id" => "Event ID",
    "event_name" => "Event Name",
    "event_img" => "Image",
    "event_desc" => "Description",
    "event_venue" => "Venue",
    "event_status" => "Status",
    "date" => "Date",
    "time" => "Time",
    "price" => "Price"
);

//search
if (empty($_GET)) {
    $name = "%";
} else {
    $name = $_GET['event_name'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin Event Page</title>
    <style>
        .main {
            text-align: center;
        }
        .img {
            width: 50%;
        }
        .desc {
            text-align: justify;
            padding: 2%;
            font-size: 24px;
        }
        .line {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <?php
    include('admin-header.php');
    require_once './secret/helper-event.php';
    ?>
    <div class="main">
        <h1>Product Info</h1>
        <form action="" method="GET">
            <input type="search" name="event_name" placeholder="Searching" />
        </form>
        <br>
        
        <?php
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $sql = "SELECT * FROM Event WHERE EVENT_NAME LIKE '$name%' ";

        // Execute the query
        $result = $con->query($sql);

        // Check if the result contains records
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $image = $row->event_img;
                $file = "uploads/$image"; // Default image path
                if (!file_exists($file)) {
                    $file = "img/default.png"; // Path to a default image
                }
                
                printf("<div class='event-info'>
                    <h1>%s</h1>
                    <img class='img' src='%s' alt='Event Image' />
                    <p class='desc' style='text-align:center'>%s</p>
                    <div class='line'> Price: RM%.2f <br>
                    <div class='button'>
                        <a href='edit-event.php?id=%s'>Edit</a>
                        <a href='delete-event.php?id=%s'>Delete</a>
                    </div>
                    </div>",
                    $row->event_name, $file, $row->event_desc, $row->price, $row->event_id, $row->event_id);
            }
        }

        $result->free();
        $con->close();
        ?>
        
    </div>
    <?php
    include('footer.php');
    ?>
</body>
</html>
