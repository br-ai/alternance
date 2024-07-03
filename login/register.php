<?php
// Commencer la session en haut du fichier, avant toute sortie
session_start();

// Votre logique de traitement ici
?>
<!-- Code Php pour le traitement de l'envoi du formulaire -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../sql/connect.php';
    include '../functions.php';


    $username = mysqli_real_escape_string(connect(), $_POST['username']); // Échapper les données pour éviter les attaques par injection SQL
    $email = mysqli_real_escape_string(connect(), $_POST['email']);
    $password = $_POST['password'];
    
    // check si le username est disponible
    $check_username_query = "SELECT * FROM users WHERE username = '$username'";
    $check_username_result = mysqli_query(connect(), $check_username_query);

    $send_mail = sendMail($email);


    // ...
    if (mysqli_num_rows($check_username_result) > 0) {
        // Le pseudo est déjà utilisé, renvoyer une erreur
        echo '<div style="display: block;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 67px;
        background-color: #ff0000;
        color: #fff;
        border-radius: 15px;
        z-index: 9999;
        text-align: center;">Le username \'' . $username . '\' est déjà utilisé. Veuillez choisir un autre username.</div>';

        exit();
    }


    $check_email_query = "SELECT * FROM users WHERE email = '$email'";
    $check_email_result = mysqli_query(connect(), $check_email_query);

    // ...
    if (mysqli_num_rows($check_email_result) > 0) {
        // L'email est déjà utilisée, renvoyer une erreur
        echo '<div style="display: block;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 67px;
        background-color: #ff0000;
        color: #fff;
        border-radius: 15px;
        z-index: 9999;
        text-align: center;">email \'' . $email . '\' est déjà utilisé. Veuillez choisir un autre email.</div>';

        exit();
    }


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $connexion = connect();

    // Requête d'insertion
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

    // Exécution de la requête
    if (mysqli_query($connexion, $query)) {
      
        $_SESSION['email'] = $email;
        echo '<script type="text/javascript">window.location.href = "../index.php";</script>';
        exit();
    } else {
        // Erreur lors de l'enregistrement
      
        echo '<div style="display: block;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 67px;
        background-color: #ff0000;
        color: #fff;
        border-radius: 15px;
        z-index: 9999;
        text-align: center;">Erreur lors de enregistrement' . mysqli_error($connexion) . '</div>';
        exit();
    }

    // Fermeture de la connexion
    mysqli_close($connexion);
}
?>
<!-- fin du code php pour le traitement de l'envoie du formulaire -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrivez vous à PoleIT</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <link rel="icon" href="../img/logo.png" sizes="180x180">
</head>
<body>

<section class="vh-25">
  <video autoplay muted loop id="bg-video">
    <source src="../video/gfp-astro-timelapse.mp4" type="video/mp4">
</video>

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

                <form action="register.php" method="post">

                  <div class="d-flex align-items-center mb-3 pb-1">
                    <img src="../img/logo.png" class="logo" alt="logo PoleIt">
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Créez un nouveau compte</h5>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="email">Adresse mail <span class="required_form">*</span></label>
                    <input type="email" id="email" name="email" required class="form-control form-control-lg" />
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="username">Username <span class="required_form">*</span></label>
                    <input pattern=".{3,25}" name="username" title="Le nom doit avoir entre 3 et 25 caractères." id="username" required class="form-control form-control-lg" />
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="password">Mot de passe <span class="required_form">*</span></label>
                    <input type="password" id="password" name="password" required class="form-control form-control-lg" />
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="confirmPassword">Confirmation Mot de passe <span class="required_form">*</span></label>
                    <input type="password" id="confirmPassword" required class="form-control form-control-lg" oninput="validatePasswords()" />
                    <p id="passwordError" class="error-message"></p>
                  </div>

                  <div class="pt-1 mb-4">
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block" id="submitButton" disabled>Inscription</button>
                  </div>

                  <a class="small text-muted" href="#!">Mot de passe oublié?</a>
                  <p class="mb-5 pb-lg-2" style="color: #000000;">Déjà membre? <a href="login.php"
                      style="color: #393f81;">Connectez vous ici</a></p>
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

<script>
    function validatePasswords() {
        var password1 = document.getElementById('password').value;
        var password2 = document.getElementById('confirmPassword').value;
        var passwordError = document.getElementById('passwordError');
        var submitButton = document.getElementById('submitButton');

        if (password1 !== password2) {
            passwordError.innerHTML = "Les mots de passe ne correspondent pas.";
            submitButton.disabled = true;
        } else {
            passwordError.innerHTML = "";
            submitButton.disabled = false;
        }
    }
</script>
    
</body>
</html>