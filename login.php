<!DOCTYPE html>
<html>
<head>
    <title>Connect to RDS instance</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<h1 align = "center">Connect to RDS instance</h1>
<body>
	<form method="post" action="index.php" >
		<div class="input-group">
			<label>RDS Endpoint</label>
			<input type="text" name="endpoint" value="" placeholder="ex: xxx.xxxxxxx.us-east-1.rds.amazonaws.com">
		</div>
		<div class="input-group">
			<label>Master Name</label>
			<input type="text" name="master" value="" placeholder="master">
        </div>
        <div class="input-group">
			<label>Password</label>
			<input type="password" name="password" value="" placeholder="lab-password">
        </div>
        <div class="input-group">
			<label>Database</label>
			<input type="text" name="database" value="" placeholder="lab">
		</div>
		<div class="input-group">
            <button align="center" class="btn" type="submit" name="login" >Login</button>
            <button align="center" class="btn" type="reset" name="reset" >Reset</button>
		</div>
	</form>
</body>
</html>
