<?php
// Commencer la session en haut du fichier, avant toute sortie
session_start();

// Votre logique de traitement ici
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectez vous à PoleIT</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <link rel="icon" href="../img/logo.png" sizes="180x180">
</head>
<body>

<section class="vh-100">
  <video autoplay muted loop id="bg-video">
    <source src="../video/gfp-astro-timelapse.mp4" type="video/mp4">
</video>
<?php

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
      include '../sql/connect.php';

      $email = mysqli_real_escape_string(connect(), $_POST['email']);
      $password = mysqli_real_escape_string(connect(), $_POST['password']);

      $query = "SELECT id, email, password FROM users WHERE email = '$email'";
      $result = mysqli_query(connect(), $query);

      if ($result) {
          $rowCount = mysqli_num_rows($result);

          if ($rowCount == 1) {
              $row = mysqli_fetch_assoc($result);

              // vérifier le mot de passe
              if (password_verify($password, $row['password'])) {
                  
                  $_SESSION['id'] = $row['id'];
                  $_SESSION['email'] = $row['email'];
                  // header("Location: ../index.php");
                  echo '<script type="text/javascript">window.location.href = "../index.php";</script>';

                  exit();
              } else {
            
                  $error_message = "Mot de passe incorrect.";
              }
          } else {
        
              $error_message = "Aucun utilisateur trouvé avec cet email.";
          }
      } else {

          $error_message = "Erreur lors de la vérification des informations d'identification : " . mysqli_error(connect());
      }


      $error_message = "Email ou Mot de passe incorrect";
      echo '<div style="display: block; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 20px; background-color: #ff0000; color: #fff; border-radius: 15px; z-index: 9999; text-align: center;">' . htmlentities($error_message) . '</div>';
  }
  ?>


  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="../img/saturne.jpg"
                alt="login form" class="img-fluid img-left" />
                <div class="animated-text"></div>
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form action="login.php" method="post">

                  <div class="d-flex align-items-center mb-3 pb-1">
                    <img src="../img/logo.png" class="logo" alt="logo PoleIt">
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Connectez vous a votre compte</h5>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="email">Adresse mail <span class="required_form">*</span></label>
                    <input type="email" id="email" name="email" class="form-control form-control-lg" />
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="password">Mot de passe <span class="required_form">*</span></label>
                    <input type="password" id="password" name="password" class="form-control form-control-lg" />
                  </div>

                  <div class="pt-1 mb-4">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block" type="submit">Connexion</button>
                  </div>

                  <a class="small text-muted" href="#!">Mot de passe oublié?</a>
                  <p class="mb-5 pb-lg-2" style="color: #000000;">Pas encore membre? <a href="register.php"
                      style="color: #393f81;">Inscrivez vous ici</a></p>
                  <a href="#!" class="small text-muted">cgu.</a>
                  <a href="#!" class="small text-muted">confidentialité</a>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const text = "Avec PoleIT découvrez l'univers sous toutes ses formes";
    const animatedText = document.querySelector('.animated-text');
    let index = 0;

    function typeText() {
      if (index < text.length) {
        animatedText.textContent += text.charAt(index);
        index++;
        setTimeout(typeText, 100);
      }
    }

    typeText();
  });
</script>
    
</body>
</html>