<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>404 - Page Not Found</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      width: 100%;
      font-family: Arial, sans-serif;
      background-color: #33d4cf;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .container {
      text-align: center;
      padding: 20px;
    }

    .container img {
      max-width: 200px;
      margin-bottom: 20px;
    }

    .container h1 {
      font-size: 60px;
      margin-bottom: 10px;
    }

    .container p {
      font-size: 20px;
      margin-bottom: 20px;
    }

    .container a {
      display: inline-block;
      background: #fff;
      color: #33d4cf;
      text-decoration: none;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      transition: background 0.3s;
    }

    .container a:hover {
      background: #f1f1f1;
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="<?php echo ASSETS_DIR; ?>/images/zeon.png" alt="logo"/>
    <h1>Page Not Found</h1>
    <p>The page you are looking for doesn't exist or has been moved.</p>
  </div>
</body>
</html>
