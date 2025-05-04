<?php
  session_start();
  include('training/database/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>
   <!-- custom css file link  -->
   <link rel="stylesheet" href="training/css/login.css">
</head>
<body>

<?php if (isset($_GET['status']) && $_GET['status'] == 'gagal'): ?>
   <div class="error-message">
       ⚠️ Login gagal! Data yang Anda masukkan salah.
   </div>
<?php endif; ?>
  
<div class="form-container">

   <form action="login_access.php" method="post">
      
      <input type="username" name="username" required placeholder="enter username">
      <input type="password" name="pass" required placeholder="enter your password">
      <input type="submit" name="login" value="login now" class="form-btn">
      
   </form>

</div>

</body>
</html>