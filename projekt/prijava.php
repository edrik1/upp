<?php 
		print '
		<div class="container" style=" padding: 16px; background-color: white;">
		<h1>Prijava korisnika</h1>
		<p>Molimo Vas da popunite obrazac za prijavu korisnika.</p>
		<hr>
		<div class="row">
		<div class="col-sm-6">
		<div class="prijava">';
		
		if ($_POST['_action_'] == FALSE) {
			print '
			<form action="" name="myForm" id="myForm" method="POST">
				<input type="hidden" id="_action_" name="_action_" value="TRUE">
	
				<label for="username">Username:*</label>
				<input type="text" id="username" name="username" value="" pattern=".{5,10}" required>
										
				<label for="password">Password:*</label>
				<input type="password" id="password" name="password" value="" pattern=".{4,}" required>
				<button type="submit">Login</button>						
			</form>';
		}
		else if ($_POST['_action_'] == TRUE) {
			
			$query  = "SELECT * FROM users";
			$query .= " WHERE username='" .  $_POST['username'] . "'";
			$result = @mysqli_query($MySQL, $query);
			$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
			
			if (password_verify($_POST['password'], $row['password'])) {
				#password_verify https://secure.php.net/manual/en/function.password-verify.php
				$_SESSION['user']['valid'] = 'true';
				$_SESSION['user']['id'] = $row['id'];
				$_SESSION['user']['firstname'] = $row['firstname'];
				$_SESSION['user']['lastname'] = $row['lastname'];
				$_SESSION['message'] = '<p>Dobrodošli, ' . $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] . '</p>';
				# Redirect to admin website
				header("Location: index.php?menu=7");
			}
			
			# Bad username or password
			else {
				unset($_SESSION['user']);
				$_SESSION['message'] = '<p>Unijeli Ste pogrešan email ili lozinku!</p>';
				header("Location: index.php?menu=6");
			}
		}
		print '
		</div>
		</div>
		</div>
		</div>';
?>