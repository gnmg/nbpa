<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/manager/manager/dashboard">Dashboard</a></li>
                <li>Analytics</li>
                <li>Entries</li>
            </ol>
        </div><!-- /row -->

        <?php if (isset($flash['errors'])): ?>
        <div class="row">
            <div class="alert alert-danger">
                <?php echo h($flash['errors']); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- search -->
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-inline" role="form" method="get" action="/manager/analytics/entries">
                        <div class="form-group">
                            <label class="sr-only" for="start">Start</label>
                            <input type="date" class="form-control" id="start" name="start" value="<?php echo h($start); ?>" placeholder="Start">
                        </div>
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <div class="form-group">
                            <label class="sr-only" for="end">End</label>
                            <input type="date" class="form-control" id="end" name="end" value="<?php echo h($end); ?>" placeholder="End">
                        </div>
                        <button type="submit" class="btn btn-default" name="action" value="show"><span class="glyphicon glyphicon-search"></span> Show</button>
                        <button type="submit" class="btn btn-default" name="action" value="csv"><span class="glyphicon glyphicon-download"></span> CSV Download</button>
                    </form>
                </div>
            </div>
        </div>

<?php if (!empty($entries)): ?>

        <div class="row">
            <div id="cal_div"></div>
            <div id="geo_div"></div>
        </div>

        <div class="row table-responsive">
            <table class="table table-striped table-hover table-condensed">
                <tr>
                    <th class="text-nowrap">Date</th>
                    <th class="text-nowrap">Total</th>
<?php foreach ($countries as $countryCode => $countryName): ?>
                    <th class="text-nowrap"><?php echo h($countryName); ?></th>
<?php endforeach; ?>
                </tr>
<?php foreach ($dates as $date): ?>
                <tr>
                    <td class="text-nowrap"><?php echo h($date); ?></td>
                    <td class="text-nowrap text-right"><?php echo h(number_format($entries[$date][0])); ?></td>
<?php foreach ($countries as $countryCode => $countryName): ?>
                    <td class="text-nowrap text-right"><?php echo h(number_format($entries[$date][$countryCode])); ?></td>
<?php endforeach; ?>
                </tr>
<?php endforeach; ?>
                <tr>
                    <th class="text-nowrap">Summary</th>
                    <td class="text-nowrap text-right"><?php echo h(number_format($entries['summary'][0])); ?></td>
<?php foreach ($countries as $countryCode => $countryName): ?>
                    <td class="text-nowrap text-right"><?php echo h(number_format($entries['summary'][$countryCode])); ?></td>
<?php endforeach; ?>
                </tr>
            </table>
        </div>

<?php endif; ?>

    </div><!-- /container -->

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load('visualization', '1.1', {packages:['calendar', 'geochart']});
    google.setOnLoadCallback(drawChart);

    function drawChart() {
        // calendar chart
        var dataCal = new google.visualization.DataTable();
        dataCal.addColumn({type: 'date', id: 'Date'});
        dataCal.addColumn({type: 'number', id: 'Entries'});

        dataCal.addRows([
<?php foreach ($dates as $date): ?>
            [new Date('<?php echo h($date); ?>'), <?php echo h($entries[$date][0]); ?>],
<?php endforeach; ?>
        ]);

        var cal = new google.visualization.Calendar(document.getElementById('cal_div'));

        var optCal = {
            title: 'Statistics of entries',
            height: 350,
        };

        cal.draw(dataCal, optCal);

        // geo chart
        var dataGeo = new google.visualization.arrayToDataTable([
            ['Country', 'Entries'],
<?php foreach ($countries as $countryCode => $countryName): ?>
<?php if ($entries['summary'][$countryCode] > 0): ?>
            ['<?php echo addslashes($countryName); ?>', <?php echo $entries['summary'][$countryCode]; ?>],
<?php endif; ?>
<?php endforeach; ?>
        ]);

        var geo = new google.visualization.GeoChart(document.getElementById('geo_div'));

        var optGeo = {
            displayMode: 'auto',
            colorAxis: {colors: ['blue', 'green', 'red']},
        };

        geo.draw(dataGeo, optGeo);
    }
</script>
<script>
    $(function() {
        $("#start").datepicker({dateFormat: 'yy-mm-dd'});
        $("#end").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
