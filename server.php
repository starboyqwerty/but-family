<?php 
// connect to database
$conn = mysqli_connect(
  getenv('DB_HOST') ?: 'localhost',
  getenv('DB_USER') ?: 'root',
  getenv('DB_PASSWORD') ?: '',
  getenv('DB_NAME') ?: 'but_db'
);

// lets assume a user is logged in with id $userid
$userid = 2;

if (!$conn) {
  die("Error connecting to database: " . mysqli_connect_error($conn));
  exit();
}

// if user clicks like or dislike button
if (isset($_POST['action'])) {
  $postid = $_POST['postid'];
  $action = $_POST['action'];
  switch ($action) {
        case 'like':
         $sql="INSERT INTO rating_info (userid, postid, rating_action) 
                   VALUES ($userid, $postid, 'like') 
                   ON DUPLICATE KEY UPDATE rating_action='like'";
         break;
        case 'dislike':
          $sql="INSERT INTO rating_info (userid, postid, rating_action) 
               VALUES ($userid, $postid, 'dislike') 
                   ON DUPLICATE KEY UPDATE rating_action='dislike'";
         break;
        case 'unlike':
              $sql="DELETE FROM rating_info WHERE userid=$userid AND postid=$postid";
              break;
        case 'undislike':
          $sql="DELETE FROM rating_info WHERE userid=$userid AND postid=$postid";
      break;
        default:
                break;
  }

  // execute query to effect changes in the database ...
  mysqli_query($conn, $sql);
  echo getRating($postid);
  exit(0);
}

// Get total number of likes for a particular post
function getLikes($id)
{
  global $conn;
  $sql = "SELECT COUNT(*) FROM rating_info 
                  WHERE postid = $id AND rating_action='like'";
  $rs = mysqli_query($conn, $sql);
  $result = mysqli_fetch_array($rs);
  return $result[0];
}

// Get total number of dislikes for a particular post
function getDislikes($id)
{
  global $conn;
  $sql = "SELECT COUNT(*) FROM rating_info 
                  WHERE postid = $id AND rating_action='dislike'";
  $rs = mysqli_query($conn, $sql);
  $result = mysqli_fetch_array($rs);
  return $result[0];
}

// Get total number of likes and dislikes for a particular post
function getRating($id)
{
  global $conn;
  $rating = array();
  $likes_query = "SELECT COUNT(*) FROM rating_info WHERE postid = $id AND rating_action='like'";
  $dislikes_query = "SELECT COUNT(*) FROM rating_info 
                                        WHERE postid = $id AND rating_action='dislike'";
  $likes_rs = mysqli_query($conn, $likes_query);
  $dislikes_rs = mysqli_query($conn, $dislikes_query);
  $likes = mysqli_fetch_array($likes_rs);
  $dislikes = mysqli_fetch_array($dislikes_rs);
  $rating = [
        'likes' => $likes[0],
        'dislikes' => $dislikes[0]
  ];
  return json_encode($rating);
}

// Check if user already likes post or not
function userLiked($postid)
{
  global $conn;
  global $userid;
  $sql = "SELECT * FROM rating_info WHERE userid=$userid 
                  AND postid=$postid AND rating_action='like'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
        return true;
  }else{
        return false;
  }
}

// Check if user already dislikes post or not
function userDisliked($postid)
{
  global $conn;
  global $userid;
  $sql = "SELECT * FROM rating_info WHERE userid=$userid 
                  AND postid=$postid AND rating_action='dislike'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
        return true;
  }else{
        return false;
  }
}

$sql = "SELECT * FROM posts";
$result = mysqli_query($conn, $sql);
// fetch all posts from database
// return them as an associative array called $posts
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);