<!DOCTYPE html>
<html>
<head>
    <title>Book Details</title>


        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/theme/favicon.png">
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/main.css?v=3.4">
<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js"></script>

    <!-- <style>
        /* Add some basic styles for better presentation */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        p {
            color: #666;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .book-details img {
            max-width: 200px;
            height: auto;
            margin-bottom: 10px;
        }
    </style> -->
</head>
<body>

<?php
    include 'partials/header.php';
    include  'partials/mobile-header.php'
    ?>



<div class="container">
  
    <?php
// Establish a connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_bridge";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a Book ID is provided in the URL
if(isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    $cover_img = isset($_GET['cover_img']) ? urldecode($_GET['cover_img']) : '';


    // Fetch book details for the provided Book ID
    $sql = "SELECT * FROM book WHERE book_id = $book_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display book details
        $row = $result->fetch_assoc();
?>
        <div class="row">
    <div class="col-md-6">
        <!-- Left Column for Cover Image -->
        <div class="cover-img-container" style="height: 400px; overflow: hidden;">
            <?php if(!empty($row["cover_img"]) && file_exists($row["cover_img"])) { ?>
                <img class="default-img" src="<?php echo $row["cover_img"]; ?>" alt="">
            <?php } else { ?>
                <img class="default-img" src="uploadedBooks/default_cover.png" alt="Default Book Cover">
            <?php } ?>
        </div>
    </div>
    <div class="col-md-6">
        <!-- Right Column for Book Details -->
        <div class="book-details" style="height: 400px; overflow-y: auto;">
            <h2><?php echo $row["title"]; ?></h2>
            <p><strong>Authors:</strong> <?php echo $row["authors"]; ?></p>
            <p><strong>ISBN:</strong> <?php echo $row["isbn"]; ?></p>
            <p><strong>Edition:</strong> <?php echo $row["edition"]; ?></p>
            <p><strong>Number of Pages:</strong> <?php echo $row["num_of_pages"]; ?></p>
            <p><strong>Language:</strong> <?php echo $row["language"]; ?></p>
            <p><strong>Description:</strong> <?php echo $row["description"]; ?></p>
            <p><strong>Publisher:</strong> <?php echo $row["publisher"]; ?></p>
            <p><strong>Publication Date:</strong> <?php echo $row["publication_date"]; ?></p>
            <!-- Display additional images if available -->
            <?php 
                if (!empty($row["additional_imgs"])) {
                    $additionalImages = explode(",", $row["additional_imgs"]);
                    foreach ($additionalImages as $image) {
                        echo "<img src='" . trim($image) . "' alt='Additional Image'>";
                    }
                }
            ?>
            
        </div>
       <div class="modal-footer">
                <button type="button" class="btn btn-primary">Make a request</button>
            </div>
    </div>
</div>

        
<?php
    } else {
        echo "Book not found";
    }
} else {
    echo "No book ID provided";
}

$conn->close();
?>

</
</body>
</html>

<?php
    include 'partials/footer.php'
    ?>