<?php
session_start();
require 'header.php';
require 'connection.php';
include('search.php');

// Retrieve the quiz ID from the URL parameter
$quizID = $_GET['quizID'];

// Perform the rankings query based on the quiz ID
$rankingsQuery = "
  SELECT c.score, u.username
  FROM conductedquizzes c
  JOIN users u ON c.usersID = u.ID
  WHERE c.quizID = :quizID
  ORDER BY c.score DESC
  LIMIT 10
";

$stmt = $db->prepare($rankingsQuery);
$stmt->bindParam(':quizID', $quizID, PDO::PARAM_INT);
$stmt->execute();

$rankings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retrieve the user's username from the session
$userUsername = $_SESSION['username'];

// Find the rank of the user within the rankings
$userRank = 0;
foreach ($rankings as $index => $ranking) {
  $username = $ranking['username'];
  if ($username === $userUsername) {
    $userRank = $index + 1;
    break;
  }
}
?>

<div class="col-md-12">
  <div class="jumbotron col-12 my-4" style="background-color: #ffffff89; color: #062747; backdrop-filter: blur(5px); border-radius: 20px; box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.5);">
     <h2>Quiz Rank</h2>
    <?php if ($userRank > 0) { ?>
      <p>Your Rank: #<?php echo $userRank; ?></p>
    <?php } else { ?>
      <p>You did not conduct this quiz.</p>
    <?php } ?>

    <?php if (!empty($rankings)) { ?>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Rank</th>
            <th>Username</th>
            <th>Score</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rankings as $index => $ranking) { ?>
            <tr>
              <td><?php echo $index + 1; ?></td>
              <td><?php echo $ranking['username']; ?></td>
              <td><?php echo $ranking['score']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p>No rankings available.</p>
    <?php } ?>
    <button class="btn btn-primary mx-2" onclick="window.location.href = 'results.php?qid=<?php echo $quizID;?>&cqid=<?php echo $answeredID;?>'">Go to Result</button> 
  </div>
</div>

<?php require 'bottom.php'; ?>
<?php require 'footer.php'; ?>
