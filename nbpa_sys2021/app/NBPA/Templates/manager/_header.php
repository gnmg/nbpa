<!doctype html>
<html ng-app>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NBPA Management Console</title>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <style type="text/css">
      body {
        padding-top: 70px;
      }

      .container {
        width: 90%;
      }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/manager/manager/dashboard">NBPA 2019
            <span class="label label-info">
              <?php echo h($app->mode); ?></span>
          </a>
        </div>

        <?php if ($app->manager): ?>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav navbar-left">
            <!-- DATA -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-hdd"></span>
                Data <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="/manager/member/index"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    Members</a></li>
                <li><a href="/manager/entry/index"><span class="glyphicon glyphicon-camera" aria-hidden="true"></span>
                    Entries</a></li>
                <li><a href="/manager/payment/index"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
                    Payments</a></li>
              </ul>
            </li>

            <!-- COMMUNICATION -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-link"></span>
                Communication <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="/manager/communication/index"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                    Mail</a></li>
              </ul>
            </li>

            <!-- CONTEST -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-fire"></span>
                Contest <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="/manager/contest/index"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                    Judging</a></li>
                <li><a href="/manager/judge/index"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    Judges</a></li>
                <li><a href="/manager/contest/setting"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    Settings</a></li>
              </ul>
            </li>

            <!-- ANALYTICS -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span>
                Analytics <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="/manager/analytics/members"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    Members</a></li>
                <li><a href="/manager/analytics/entries"><span class="glyphicon glyphicon-camera" aria-hidden="true"></span>
                    Entries</a></li>
              </ul>
            </li>

            <!-- Manager -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>
                <?php echo h($app->manager->mgr_name); ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="/manager/manager/signout"><span class="glyphicon glyphicon-log-out"></span> Sign out</a></li>
                <li><a href="/manager/manager/password"><span class="glyphicon glyphicon-cog"></span> Change password</a></li>
              </ul>
            </li>

          </ul>
        </div>
        <?php endif; ?>

      </div><!-- /container -->
    </nav>