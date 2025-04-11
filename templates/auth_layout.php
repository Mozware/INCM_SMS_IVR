<!-- templates/auth_layout.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title> <?= $title ?? 'Flow Alert' ?> </title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/assets/css/kaiadmin.min.css" />
  <link rel="stylesheet" href="/assets/css/plugins.min.css" />
  <link rel="stylesheet" href="/assets/css/fonts.min.css" />
  <link rel="icon" href="/assets/img/favicon.ico" type="image/x-icon" />
  <!-- Fonts and icons -->
  <script src="/assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: { families: ["Public Sans:300,400,500,600,700"] },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["/assets/css/fonts.min.css"],
      },
      active: function () {
        sessionStorage.fonts = true;
      },
    });
  </script>
</head>

<body class="login-page bg-light">
  <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <?= $content ?>
  </div>
  <script src="/assets/js/core/jquery-3.7.1.min.js"></script>
  <script src="/assets/js/core/bootstrap.min.js"></script>
  <script src="/assets/js/kaiadmin.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?php if (!empty($alert)): ?>
    <script>
      Swal.fire({
        title: '<?= $alert['title'] ?>',
        text: '<?= $alert['text'] ?>',
        icon: '<?= $alert['icon'] ?>'
      });
    </script>
  <?php endif; ?>
</body>

</html>