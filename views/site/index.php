<?php

/* @var $this yii\web\View */

use app\models\Order;
use app\models\User;
use yii\widgets\LinkPager;
use yii\widgets\Menu;

$this->title = 'Yii app';
?>
<div class="site-index">
    <div class="body-content">
        <h2>Heading</h2>
        <?=
            Menu::widget([
                'options' => ['class' => 'nav nav-tabs p-b'],
                'items' => [
                    ['label' => 'All orders', 'url' => [''], 'active' => $status && $status == 'all'],
                    ['label' => 'Pending', 'url' => ['', 'status' => 0], 'active' => $status === 0],
                    ['label' => 'In progress', 'url' => ['', 'status' => 1], 'active' => $status === 1],
                    ['label' => 'Completed', 'url' => ['', 'status' => 2], 'active' => $status === 2],
                    ['label' => 'Canceled', 'url' => ['', 'status' => 3], 'active' => $status === 3],
                    ['label' => 'Error', 'url' => ['', 'status' => 4], 'active' => $status === 4],
                ],
                'activeCssClass'=>'active',
            ]);
        ?>

        <!--
        <ul class="nav nav-tabs p-b">
            <li class="active"><a href="#">All orders</a></li>
            <li><a href="#">Pending</a></li>
            <li><a href="#">In progress</a></li>
            <li><a href="#">Completed</a></li>
            <li><a href="#">Canceled</a></li>
            <li><a href="#">Error</a></li>
            <li class="pull-right custom-search">
                <form class="form-inline" action="/admin/orders" method="get">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
                        <span class="input-group-btn search-select-wrap">
                            <select class="form-control search-select" name="search-type">
                                <option value="1" selected="">Order ID</option>
                                <option value="2">Link</option>
                                <option value="3">Username</option>
                            </select>
                            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                        </span>
                    </div>
                </form>
            </li>
        </ul>
        -->
        <table class="table order-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Link</th>
                <th>Quantity</th>
                <th class="dropdown-th">
                    <div class="dropdown">
                        <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Service
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li class="active"><a href="">All (894931)</a></li>
                            <li><a href=""><span class="label-id">214</span>  Real Views</a></li>
                            <li><a href=""><span class="label-id">215</span> Page Likes</a></li>
                            <li><a href=""><span class="label-id">10</span> Page Likes</a></li>
                            <li><a href=""><span class="label-id">217</span> Page Likes</a></li>
                            <li><a href=""><span class="label-id">221</span> Followers</a></li>
                            <li><a href=""><span class="label-id">224</span> Groups Join</a></li>
                            <li><a href=""><span class="label-id">230</span> Website Likes</a></li>
                        </ul>
                    </div>
                </th>
                <th>Status</th>
                <th class="dropdown-th">
                    <div class="dropdown">
                        <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Mode
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li class="active"><a href="">All</a></li>
                            <li><a href="">Manual</a></li>
                            <li><a href="">Auto</a></li>
                        </ul>
                    </div>
                </th>
                <th>Created</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order->id ?></td>
                        <td><?= User::findOne($order->user_id)->getFullName() ?></td>
                        <td class="link"><?= $order->link ?></td>
                        <td><?= $order->quantity ?></td>
                        <td class="service">
                            <span class="label-id">15</span> Views
                        </td>
                        <td><?= $order->getStatus() ?></td>
                        <td><?= $order->getMode() ?></td>
                        <td><span class="nowrap"><?= $order->getCreatedDate() ?></span> <span class="nowrap"><?= $order->getCreatedTime() ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-sm-8">
                <nav>
                    <?= LinkPager::widget(['pagination' => $pages]); ?>
                </nav>
            </div>
            <div class="col-sm-4 pagination-counters">
                1 to 100 of <?= Order::find()->count() ?>
            </div>
        </div>
    </div>
</div>
