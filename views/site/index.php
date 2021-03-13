<?php

/* @var $this yii\web\View */

use app\models\Order;
use app\models\User;
use app\models\Service;
use yii\widgets\LinkPager;
use yii\widgets\Menu;

$this->title = 'Yii app';
?>
<div class="site-index">
    <div class="body-content">
        <?=
            Menu::widget([
                'options' => ['class' => 'nav nav-tabs p-b'],
                'items' => [
                    ['label' => 'All orders', 'url' => ['', 'mode' => $mode, 'service_id' => $service_id], 'active' => $status && $status == 'all'],
                    ['label' => 'Pending', 'url' => ['', 'status' => 0, 'mode' => $mode, 'service_id' => $service_id], 'active' => $status === 0],
                    ['label' => 'In progress', 'url' => ['', 'status' => 1, 'mode' => $mode, 'service_id' => $service_id], 'active' => $status === 1],
                    ['label' => 'Completed', 'url' => ['', 'status' => 2, 'mode' => $mode, 'service_id' => $service_id], 'active' => $status === 2],
                    ['label' => 'Canceled', 'url' => ['', 'status' => 3, 'mode' => $mode, 'service_id' => $service_id], 'active' => $status === 3],
                    ['label' => 'Error', 'url' => ['', 'status' => 4, 'mode' => $mode, 'service_id' => $service_id], 'active' => $status === 4],
                ],
                'activeCssClass'=>'active',
            ]);
        ?>
        <form class="form-inline" action="" method="get">
            <div class="input-group">
                <input type="hidden" name="status" value="<?= $status ?>">
                <input type="hidden" name="mode" value="<?= $mode ?>" >
                <input type="hidden" name="service_id" value="<?= $service_id ?>" >
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
                        <?php
                            $services = Service::find()->all();
                            $allServices = count($services);
                            $items = [
                                [
                                    'label' => "All (${allServices})",
                                    'url' => ['', 'status' => $status, 'mode' => $mode],
                                    'active' => $service_id && $service_id == 'all'
                                ]
                            ];

                            foreach($services as $serviceItem) {
                                array_push($items, [
                                        'label' => $serviceItem->name,
                                        'url' => ['', 'status' => $status, 'mode' => $mode, 'service_id' => $serviceItem->id],
                                        'active' => $service_id === $serviceItem->id
                                    ]
                                );
                            }

                            echo Menu::widget([
                                'options' => ['class' => 'dropdown-menu', 'aria-labelledby' => 'dropdownMenu1'],
                                'items' => $items,
                                'activeCssClass'=>'active',
                            ]);
                        ?>
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
                        <?=
                            Menu::widget([
                                'options' => ['class' => 'dropdown-menu', 'aria-labelledby' => 'dropdownMenu1'],
                                'items' => [
                                    ['label' => 'All', 'url' => ['', 'status' => $status, 'service_id' => $service_id], 'active' => $mode && $mode == 'all'],
                                    ['label' => 'Manual', 'url' => ['', 'status' => $status, 'mode' => 1, 'service_id' => $service_id], 'active' => $mode === 1],
                                    ['label' => 'Auto', 'url' => ['', 'status' => $status, 'mode' => 0, 'service_id' => $service_id], 'active' => $mode === 0],
                                ],
                                'activeCssClass'=>'active',
                            ]);
                        ?>
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
                            <span class="label-id"><?= $order->service_id ?></span> <?= Service::findOne($order->service_id)->name ?>
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
