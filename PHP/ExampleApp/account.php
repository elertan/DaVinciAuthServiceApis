<?php
require('DaVinciAuth.php');
DaVinciAuth::ensureLoggedIn();

// My code
?>
<p>Hello there <?=DaVinciAuth::$user->userNumber?>!</p>
<a href="/logout.php">Click here to logout</a>