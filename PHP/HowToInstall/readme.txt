To use to the api into your project, please copy over all files below in the right folder, if the folders do not exist. Create them yourself in the as shown folder structure.

After that apply these changes.

Change the data in the config.php file, these values are unique and should be different on your application!

Now to use the api, use the following code as an example.

<?php
require('DaVinciAuth.php');
DaVinciAuth::ensureLoggedIn();

// My code
?>
<p>Hello there <?=DaVinciAuth::$user->userNumber?>!</p>
<a href="/logout.php">Click here to logout</a>