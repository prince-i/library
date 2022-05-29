<?php 
include '../conn.php';

$method = $_POST['method'];

if ($method == 'fetch_book_list') {
	$book_title = $_POST['book_title'];
	$c = 0;

	$query ="SELECT * FROM book_details WHERE title LIKE '$book_title%'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $j){
			$c++;

			echo '<tr style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#update_book_details" onclick="get_update_book_details(&quot;'.$j['id'].'~!~'.$j['title'].'~!~'.$j['description'].'~!~'.$j['author'].'~!~'.$j['date_publish'].'~!~'.$j['category'].'~!~'.$j['book_type'].'~!~'.$j['book_qty'].'&quot;)">';
				echo '<td>'.$c.'</td>';
				echo '<td>'.$j['title'].'</td>';
				echo '<td>'.$j['description'].'</td>';
				echo '<td>'.$j['author'].'</td>';
				echo '<td>'.$j['date_publish'].'</td>';
				echo '<td>'.$j['category'].'</td>';
				echo '<td>'.$j['book_type'].'</td>';
				echo '<td>'.$j['book_qty'].'</td>';
			echo '</tr>';
		}
	}else{
			echo '<tr>';
				echo '<td colspan="7" style="color:red;">No Result</td>';
			echo '</tr>';
	}
}


if ($method == 'register_book') {
	$title = $_POST['title'];
	$description = $_POST['description'];
	$author = $_POST['author'];
	$date_publish = $_POST['date_publish'];
	$category = $_POST['category'];
	$book_type = $_POST['book_type'];
	$book_qty = $_POST['book_qty'];

	$check = "SELECT id FROM book_details WHERE title = '$title' AND description = '$description' AND author = '$author' AND date_publish = '$date_publish' AND category = '$category' AND book_type = '$book_type'";
	$stmt = $conn->prepare($check);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {

		echo 'Book Already Exist';	
		
	}else{

		$book_qrcode =  $title.''.$author;

		$query = "INSERT INTO book_details (`title`,`description`,`author`,`date_publish`,`category`,`book_type`,`book_qrcode`,`book_qty`) VALUES ('$title','$description','$author','$date_publish','$category','$book_type','$book_qrcode','$book_qty')";
		$stmt2 = $conn->prepare($query);
		if ($stmt2->execute()) {
			echo 'success';
		}else{
			echo 'error';
		}
		
	}
}

if ($method =='update_book_details') {
	$id = $_POST['id'];
	$title = $_POST['title'];
	$description = $_POST['description'];
	$author = $_POST['author'];
	$date_publish = $_POST['date_publish'];
	$category = $_POST['category'];
	$book_type = $_POST['book_type'];
	$book_qty = $_POST['book_qty'];

	$book_qrcode =  $title.''.$author;

	$query ="UPDATE book_details SET title = '$title', description = '$description', author ='$author', date_publish = '$date_publish', category = '$category', book_type = '$book_type', book_qrcode = '$book_qrcode', book_qty = '$book_qty' WHERE id = '$id'";
	$stmt = $conn->prepare($query);
	if ($stmt->execute()) {
		echo 'success';
	}else{
		echo 'error';
	}
}

if ($method =='delete_book_details') {
	$id = $_POST['id'];
	$title = $_POST['title'];
	$description = $_POST['description'];
	$author = $_POST['author'];
	$date_publish = $_POST['date_publish'];
	$category = $_POST['category'];
	$book_type = $_POST['book_type'];
	$book_qty = $_POST['book_qty'];

	$query ="DELETE FROM book_details WHERE id = '$id'";
	$stmt = $conn->prepare($query);
	if ($stmt->execute()) {
		echo 'success';
	}else{
		echo 'error';
	}
}
$conn = NULL;
?>