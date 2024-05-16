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
if (isset($_POST["btnYes"])) {
    $image = $_POST["image"];
    $path = "uploads/$image";
    echo $path;
    
    if (file_exists($path)) {
        unlink($path);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Delete Event</title>
    <link href="css/Style.css" rel="stylesheet" type="text/css"/>
    <style>
        .table-gray {
            background-color: #D6F0FC;
            margin: 30px;
            padding: 100px;
        }
        .event-img {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>
    <?php
    include('admin-header.php');
    require_once './secret/helper-event.php';
    ?>
    <div class="main">
        <h1>Delete Event</h1>
        <div class="table-gray">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET['id'])) {
                $id = strtoupper(trim($_GET['id']));
            } else {
                $id = "";
            }
            
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            $id = $con->real_escape_string($id);
            
            $sql = "SELECT * FROM EVENT WHERE EVENT_ID = '$id'";
            
            $result = $con->query($sql);
            
            if ($row = $result->fetch_object()) {
                $id = $row->event_id;
                $name = $row->event_name;
                $img = $row->event_img;
                $desc = $row->event_desc;
                $price = $row->price;
                
                $imagePath = "uploads/$img";
                if (!file_exists($imagePath)) {
                    $imagePath = "img/default.png"; // Path to a default image
                }
                
                printf("<h2>Are you sure you want to delete the following Event?</h2>
                        <table border='1' style='background-color:white;'>
                            <tr><td>Event ID: </td><td>%s</td></tr>
                            <tr><td>Event Name: </td><td>%s</td></tr>
                            <tr><td>Image: </td><td><img class='event-img' src='%s' alt='Event Image'/></td></tr>
                            <tr><td>Event Description: </td><td>%s</td></tr>
                            <tr><td>Price: </td><td>%.2f</td></tr>
                        </table>
                        <form action='' method='POST'>
                            <input type='hidden' value='%s' name='hdid' />
                            <input type='hidden' value='%s' name='hdname' />
                            <input type='hidden' name='image' value='%s'/>
                            <input type='submit' value='Yes' name='btnYes' />
                            <input type='button' value='Cancel' name='btnCancel' id='cancel'/>
                        </form>
                        ", $id, $name, $imagePath, $desc, $price, $id, $name, $img);
                
            } else {
                echo "Unable to process. [<a href='maintainEvent.php'>Try again</a>]";
            }
            $result->free();
            $con->close();
            
        } else {
            // Post method
            // delete related feedback records first
            $id = strtoupper(trim($_POST["hdid"]));
            $name = trim($_POST["hdname"]);
            
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            // Start a transaction
            $con->begin_transaction();
            
            try {
                // Delete related feedback records
                $sqlFeedback = "DELETE FROM FEEDBACK WHERE EVENT_ID = ?";
                $stmtFeedback = $con->prepare($sqlFeedback);
                $stmtFeedback->bind_param("s", $id);
                $stmtFeedback->execute();
                
                // Delete the event
                $sqlEvent = "DELETE FROM EVENT WHERE EVENT_ID = ?";
                $stmtEvent = $con->prepare($sqlEvent);
                $stmtEvent->bind_param("s", $id);
                $stmtEvent->execute();
                
                // Commit the transaction
                $con->commit();
                
                printf("
                    <div class='info'>PRODUCT <b>%s</b> has been deleted!
                    [ <a href='maintainEvent.php'>Back to List</a> ]
                    </div>
                    ", $name);
                
            } catch (mysqli_sql_exception $exception) {
                $con->rollback();
                echo "<div class='error'>Error, cannot delete record.
                    [ <a href='maintainEvent.php'>Try again!</a> ]
                    </div>";
            }
            
            $con->close();
        }
        ?>
        </div>
    </div>
    <?php
    include('footer.php');
    ?>
    <script>
        document.getElementById('cancel').onclick = function() {
            window.location.href = 'maintainEvent.php';
        };
    </script>
</body>
</html>
