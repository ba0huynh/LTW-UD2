<?php 

require_once("./database/database.php");
$servername="localhost";
$username="root";
$password="";
$dbname="ltw_ud2";
$conn=new mysqli($servername,$username,$password,$dbname);
?> 

<?php
$Class = intval($_GET['Class']);
$sql = "SELECT DISTINCT subjects.id, subjects.subjectName
        FROM books
        JOIN subjects ON books.subjectId = subjects.id
        WHERE classNumber = $Class";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
<div>
    <div>
        <a class="text-pink-500 italic" href="/LTW-UD2/searchPage.php?subject=<?= $row["id"] ?>"><?= $row["subjectName"] ?></a>
    </div>
    <?php
        $subject_id = $row['id'];
        $sql1 = "SELECT DISTINCT type
                 FROM books
                 WHERE subjectId = $subject_id AND classNumber = $Class";
        $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
            while ($row1 = $result1->fetch_assoc()) {
    ?>
    <div>
        <a class="text-blue-500 italic" href="/LTW-UD2/searchPage.php?subject=<?= urlencode($row["id"]) ?>&type=<?= urlencode($row1["type"]) ?>">

            <?= $row1["type"] ?>
        </a>
    </div>
    <?php
            }
        }
    ?>
</div>
<?php
    }
}
?>
