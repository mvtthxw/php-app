<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Simple PHP App</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="hero-unit">


                <h1>Hello!</h1>

                <table style="width:40%">
                <tr>
                  <td><B>Container name</B></td>
                  <td>
                    <?php
                      $hostname = gethostname();
                      echo "{$hostname}";
                    ?>
                  </td>
                </tr>
                <tr>
                  <td><B>Current Time</B>
                  </td>
                  <td><?php echo "Current time is " . date("h:i:sa"); ?><br/><br/></td>
                </tr>
                </table>


            </div>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
    </body>

</html>
