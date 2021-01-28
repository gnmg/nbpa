<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li>Dashboard</li>
            </ol>
        </div><!-- /row -->

        <?php if (isset($flash['errors'])): ?>
        <div class="row">
            <div class="alert alert-danger">
                <?php echo h($flash['errors']); ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-2 text-right">Current contest term:</div>
            <div class="col-md-10"><?php echo h($termStart); ?> - <?php echo h($termEnd); ?> (<?php echo h($timezone); ?>)</div>
        </div>

        <div class="row">
            <div class="col-md-2 text-right">Total photographers:</div>
            <div class="col-md-2">
                <?php echo h(number_format($memberCount)); ?>
                <button type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-target="#memberCnt">detail</button>
            </div>
        </div>

        <div id="memberCnt" class="row collapse">
            <div class="col-md-2 text-right"></div>
            <div class="col-md-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Country</th>
                            <th>Female</th>
                            <th>Male</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($memberCountries as $memberCountry): ?>
                        <tr>
                            <td><?php echo h($memberCountry['countryName']); ?></td>
                            <td class="text-right"><?php echo h(number_format($memberCountry['female'])); ?></td>
                            <td class="text-right"><?php echo h(number_format($memberCountry['male'])); ?></td>
                        </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 text-right">Total entries:</div>
            <div class="col-md-2">
                <?php echo h(number_format($entryCount)); ?>
                <button type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-target="#entryCnt">detail</button>
            </div>
        </div>

        <div id="entryCnt" class="row collapse">
            <div class="col-md-2 text-right"></div>
            <div class="col-md-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Country</th>
                            <th>Female</th>
                            <th>Male</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($entryCountries as $entryCountry): ?>
                        <tr>
                            <td><?php echo h($entryCountry['countryName']); ?></td>
                            <td class="text-right"><?php echo h(number_format($entryCountry['female'])); ?></td>
                            <td class="text-right"><?php echo h(number_format($entryCountry['male'])); ?></td>
                        </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div><!-- /container -->

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
