<?php 
	session_start();

	if (isset($_POST['endpoint'])) $_SESSION['endpoint'] =  $_POST['endpoint']; 
	if (isset($_POST['master'])) $_SESSION['master'] =  $_POST['master'];
	if (isset($_POST['password'])) $_SESSION['password'] =  $_POST['password'];

	$conn = mysqli_connect($_SESSION['endpoint'], $_SESSION['master'], $_SESSION['password']);
	if (mysqli_connect_errno()) {
		header('location: login.php');
	}
	else{
	$sql = "CREATE DATABASE lab;";
	mysqli_query($conn, $sql);
	}

	$db = mysqli_connect($_SESSION['endpoint'], $_SESSION['master'], $_SESSION['password'], "lab");
	
	$table = "CREATE TABLE `Lab` (
			   `ID` int(11) NOT NULL AUTO_INCREMENT,
			   `Name` varchar(45) DEFAULT NULL,
			   `Country` varchar(90) DEFAULT NULL,
			   PRIMARY KEY (`ID`),
			   UNIQUE KEY `ID_UNIQUE` (`ID`)
			 ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";
	
	mysqli_query($db, $table);

	$name = "";
	$country = "";
	$id = 0;
	$update = false;

	if (isset($_POST['save'])) {
		$name = $_POST['Name'];
		$country = $_POST['Country'];

		mysqli_query($db, "INSERT INTO Lab (Name, Country) VALUES ('$name', '$country')"); 
		$_SESSION['message'] = "Employee saved"; 
		header('location: index.php');
	}

	if (isset($_POST['update'])) {
		$id = $_POST['ID'];
		$name = $_POST['Name'];
		$address = $_POST['Country'];
	
		mysqli_query($db, "UPDATE Lab SET Name='$name', Country='$address' WHERE ID=$id");
		$_SESSION['message'] = "Employee updated!"; 
		header('location: index.php');
	}

	if (isset($_GET['del'])) {
		$id = $_GET['del'];
		mysqli_query($db, "DELETE FROM Lab WHERE ID=$id");
		$_SESSION['message'] = "Employee deleted!"; 
		header('location: index.php');
	}

	if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$update = true;
		$record = mysqli_query($db, "SELECT * FROM Lab WHERE ID=$id");

		if (count($record) == 1 ) {
			$n = mysqli_fetch_array($record);
			$name = $n['Name'];
			$address = $n['Country'];
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to RDS</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php $results = mysqli_query($db, "SELECT * FROM Lab"); ?>
<h1 align = "center">Employee Information</h1>
<div style="text-align:center;"><a href="login.php"><button class="logout_btn" onclick="Logout()" style="font-size:25px;">Logout</button></a></div>
<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Country</th>
			<th colspan="2">Action</th>
		</tr>
	</thead>
	
	<?php while ($row = mysqli_fetch_array($results)) { ?>
		<tr>
			<td><?php echo $row['ID']; ?></td>
			<td><?php echo $row['Name']; ?></td>
			<td><?php echo $row['Country']; ?></td>
			<td>
				<a href="index.php?edit=<?php echo $row['ID']; ?>" class="edit_btn" >Edit</a>
			</td>
			<td>
				<a href="index.php?del=<?php echo $row['ID']; ?>" class="del_btn">Delete</a>
			</td>
		</tr>
	<?php } ?>
</table>
	<form method="post" action="index.php" >
	   <input type="hidden" name="ID" value="<?php echo $id; ?>">
		<div class="input-group">
			<label>Name</label>
			<input type="text" name="Name" value="<?php echo $name; ?>">
		</div>
		<div class="input-group">
			<label>Country</label>
			<input type="text" name="Country" value="<?php echo $address; ?>">
		</div>
		<div class="input-group">
			<?php if ($update == true): ?>
				<button class="btn" type="submit" name="update" style="background: #556B2F;" >update</button>
			<?php else: ?>
				<button class="btn" type="submit" name="save" >Add Employee</button>
			<?php endif ?>
		</div>
	</form>
</body>
<?php if (isset($_SESSION['message'])): ?>
	<div class="msg">
		<?php 
			echo $_SESSION['message']; 
			unset($_SESSION['message']);
		?>
	</div>
<?php endif ?>
</html>

<?php
function Logout(){
// remove all session variables
session_unset();

// destroy the session
session_destroy();

}
?>