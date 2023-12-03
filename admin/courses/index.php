<?php
require __DIR__.'/../template/header.php';

$courses = $mysqli->query("select * from courses")->fetch_all(MYSQLI_ASSOC);

$imageId = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
   $imageId = mysqli_real_escape_string($mysqli, $_POST['imageId']);
   $courseStatus = $mysqli->query("select * from courses where id='$imageId'")->fetch_assoc();
   $imageStatus = $courseStatus['status'];


   if(isset($_POST['open']) && $_POST['open']){
       $mysqli->query("update courses set status = 'open' where id='$imageId'");
   }
   if(isset($_POST['close'])){
       $mysqli->query("update courses set status = 'close' where id = '$imageId'");
   }
   if(isset($_POST['delete']) && $_POST['delete']){
       $mysqli->query("delete from payments where course_id = '$imageId'");
       $mysqli->query("delete from courses where id = '$imageId'");
   }
//   if($imageStatus == 'open'){
//       $mysqli->query("update courses set status ='close' where id ='$imageId'");
//   }else{
//       $mysqli->query("update courses set status ='open' where id ='$imageId'");
//   }
//
//   if($_POST['delete']){
//       $mysqli->query("delete from courses where id='$imageId'");
//   }



   echo "<script>location.href='index.php'</script>";
}

?>

<div class="container-fluid">
    <a href="create.php" class="btn btn-success">Add course</a>

<table class="table">

    <thead class="table-header">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Description</th>
            <th>Image</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($courses as $course): ?>
    <tr>
        <td><?php echo $course['id'] ?></td>
        <td><?php echo $course['name'] ?></td>
        <td><?php echo $course['description'] ?></td>
        <td>
            <div class="card-image-custom" style="background-image: url(<?php echo $config['admin_url'].'courses/uploads/'. $course['image'] ?>);"></div>
        </td>
        <td><?php echo $course['status'] ?></td>
        <td>
            <a href="edit.php?id=<?php echo $course['id'] ?>" class="btn btn-warning">Edit</a>
            <form action="" style="display: inline" method="post" >
                <input type="hidden" name="imageId" value="<?php echo $course['id'] ?>">
                <?php if($course['status'] == 'open'){ ?>
                <input type="submit" value="Close" name="close" class="btn btn-danger" onclick="confirm('Are you sure?')">
                <?php
                }else{ ?>
                <input type="submit" value="Open" name="open" class="btn btn-danger" onclick="confirm('Are you sure?')">
                <?php } ?>
                <input type="submit" value="Delete" name="delete" class="btn btn-danger" onclick="confirm('You are about to delete this course')">

            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

<?php require __DIR__.'/../template/footer.php' ?>
