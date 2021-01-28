<div class="col-sm-4 col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading">Member Information</div>
        <ul class="list-group">
            <li class="list-group-item"><a href="/manager/member/show/<?php echo h($member->member_regist_no); ?>?q=<?php echo h($q); ?>&amp;c=<?php echo h($c); ?>&amp;page=<?php echo h($page); ?>">Member Info</a></li>
        </ul>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Payment Information</div>
        <ul class="list-group">
            <li class="list-group-item"><a href="/manager/payment/index?q=<?php echo h($member->member_regist_no); ?>">Payment Info</a></li>
        </ul>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Entry Information</div>
        <ul class="list-group">
            <li class="list-group-item"><a href="/manager/entry/index?q=<?php echo h($member->member_regist_no); ?>">Entry Info</a></li>
        </ul>
    </div>
</div>
