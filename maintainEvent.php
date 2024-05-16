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
    "event_id" => "Product ID",
    "event_name" => "Product Name",
    "event_img" => "Image",
    "event_desc" => "Description",
    "price" => "Price"
);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Event</title>
    <link href="css/Style.css" rel="stylesheet" type="text/css"/>
    <style>
        table {
            background-color: white;
        }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .eventId, .eName, .price {
            text-align: center;
            width: 10%;
        }
        .desc {
            width: 40%;
            text-align: justify;
        }
        .button {
            width: 10%;
            text-align: center;
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
        <h1>Event</h1>
        <p>Status: 
        <?php
        // Search functionality
        if (empty($_GET)) {
            $sort = "event_id"; // Default sorting
            $order = "ASC";
            $name = "%";
        } else {
            $sort = $_GET["sort"];
            $order = $_GET["order"];
            $name = $_GET['event_name'];
        }
        printf("<a href='?sort=%s&order=%s&event_name=%s'>All</a>", $sort, $order, '%');
        ?>  
        </p>
        <form action="" method="GET">
            <input type="hidden" name="sort" value="<?php echo isset($sort) ? $sort : "%"; ?>">
            <input type="hidden" name="order" value="<?php echo isset($order) ? $order : "%"; ?>">
            <input type="search" name="event_name" placeholder="Searching"/>
        </form>
        <br>
        <?php
        if (isset($_POST["btnDelete"])) {
            if (isset($_POST["checked"])) {
                $check = $_POST["checked"];
            } else {
                $check = null;
            }
            
            if (!empty($check)) {
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
                $escape = array();
                
                foreach ($check as $value) {
                    $escape[] = $con->real_escape_string($value);
                }
                
                $sql = "DELETE FROM EVENT WHERE EVENT_ID IN ('" . implode("', '", $escape) . "')";
                
                if ($con->query($sql)) {
                    printf("<div class='info'> <b>%d</b> record(s) has been deleted.</div>", $con->affected_rows);
                }
                $con->close();
            }
        }
        ?>
        
        <form action="" method="POST">
            <table border="1" cellspacing="0" cellpadding="5">
                <tr>
                    <th></th>
                    <?php 
                    foreach ($header as $key => $value) {
                        if ($key == $sort) {
                            printf("<th>
                                <a href='?sort=%s&order=%s&event_name=%s'>%s</a>
                                <img src='img/%s' />
                                </th>", $key, ($order == "ASC") ? "DESC" : "ASC", $name, $value, ($order == "ASC") ? 'asc.png' : 'desc.png');
                        } else {
                            printf("<th>
                                <a href='?sort=%s&order=ASC&event_name=%s'>%s</a>
                                </th>", $key, $name, $value);
                        }
                    } 
                    ?>
                    <th><a href="add-event.php">Create New Event</a></th>
                </tr>
                
                <?php
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }

                $sql = "SELECT event_id, event_name, event_img, event_desc, price FROM Event WHERE event_name LIKE '$name%' ORDER BY $sort $order";

                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_object()) {
                        $imagePath = "uploads/" . $row->event_img;
                        if (!file_exists($imagePath)) {
                            $imagePath = "img/default.png"; // Path to a default image
                        }
                        printf("
                            <tr>
                            <td><input type='checkbox' name='checked[]' value='%s' /></td>
                            <td class='eventId'>%s</td>
                            <td class='eName'>%s</td>
                            <td><img class='event-img' src='%s' alt='Event Image'/></td>
                            <td class='desc'>%s</td>
                            <td class='price'>RM%.2f</td>
                            <td class='button'>
                                <a href='edit-event.php?id=%s'>Edit</a>
                                <a href='delete-event.php?id=%s'>Delete</a>
                            </td>
                            </tr>", $row->event_id, $row->event_id, $row->event_name, $imagePath, $row->event_desc, $row->price, $row->event_id, $row->event_id);
                    }
                }

                printf("<tr>
                    <td colspan='7'>Have %d Event(s) existing.
                     [ <a href='add-event.php'>Add New Product</a> ]
                    </td>
                       </tr>", $result->num_rows);

                $result->free();
                $con->close();
                ?>
                    
                <tr>
                    <td colspan="7"><input class="delete-all" type="submit" value="Delete All" name="btnDelete" onclick="return confirm('This will delete all records.\n Are You Sure?')"/></td>
                </tr>
            </table>
        </form>
    </div>
    <?php
    include('footer.php');
    ?>
</body>
</html>
