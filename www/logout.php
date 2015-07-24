<?php
session_start();
// Logout prcedure - basic functions sourced from w3schools
?>
<html>
<body>
Logging out....
<?php

session_unset(); 
session_destroy();

echo '<script type="text/javascript">
           window.location = "index.php"
      </script>'; 
?>

</body>
</html>