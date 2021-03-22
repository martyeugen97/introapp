<?php

/* @var $this yii\web\View */

use app\models\User;
use app\models\Service;
use app\getters\StatusGetter;
use app\getters\ServiceGetter;
use app\getters\ModeGetter;
use yii\widgets\LinkPager;
use yii\widgets\Menu;
use yii\helpers\Url;

Yii::$app->language = Yii::$app->params['language'];
$this->title = Yii::$app->params['title'];
?>
<div class="site-index">
    <div class="body-content">
        <ul class="nav nav-tabs p-b">
            <li <?= !isset($params['status']) ? 'class="active"' : '' ?> >
                <a href="<?= Url::toRoute(['', 'mode' => $params['mode'], 'service_id' => $params['service_id']]) ?>">
                    <?= Yii::t('app', 'panel.label.all_orders')?></a>
            </li>

            <?php foreach (StatusGetter::getList() as $statusId => $statusName): ?>
                <li <?= (is_numeric($params['status']) && $params['status'] == $statusId) ? 'class="active"' : '' ?> >
                    <a href="<?= Url::toRoute(array_merge($params ?? [], ['', 'status' => $statusId])) ?>">
                        <?= Yii::t('app', $statusName) ?>
                    </a>
                </li>
            <?php endforeach ?>

            <li class="pull-right custom-search">
                <form class="form-inline" action="" method="get">
                    <div class="input-group">
                        <?php if (is_numeric($params['status'])): ?>
                            <input type="hidden" name="status" value="<?= $params['status']?>">
                        <?php endif; ?>
                        <input type="text" name="search" class="form-control" value="<?= $params['search'] ?? '' ?>"
                               placeholder="<?=  Yii::t('app', 'panel.label.search_orders') ?>">
                        <span class="input-group-btn search-select-wrap">
                            <select class="form-control search-select" name="search-type">
                                <option value="1" <?= $params['search-type'] == 1 ? 'selected' : '' ?>>
                                    <?=  Yii::t('app','panel.label.order_id') ?>
                                </option>
                                <option value="2" <?= $params['search-type'] == 2 ? 'selected' : '' ?>>
                                    <?=  Yii::t('app','panel.label.link') ?>
                                </option>
                                <option value="3" <?= $params['search-type'] == 3 ? 'selected' : '' ?>>
                                    <?=  Yii::t('app','panel.label.username') ?>
                                </option>
                            </select>
                            <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-search"aria-hidden="true"></span>
                            </button>
                        </span>
                    </div>
                </form>
            </li>
        </ul>
        <table class="table order-table">
            <thead>
            <tr>
                <th><?= Yii::t('app','panel.label.id') ?></th>
                <th><?= Yii::t('app','panel.label.user') ?></th>
                <th><?= Yii::t('app','panel.label.link') ?></th>
                <th><?= Yii::t('app','panel.label.quantity') ?></th>
                <th class="dropdown-th">
                    <div class="dropdown">
                        <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?= Yii::t('app','panel.label.service') ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li <?= !isset($params['service_id']) ? 'class="active"' : '' ?> >
                                <a href="<?= Url::toRoute(['', 'status' => $params['status'], 'mode' => $params['mode']]) ?>">
                                    <?= Yii::t('app','panel.label.all') ?>
                                    (<?= ServiceGetter::getCount() ?>)
                                </a>
                            </li>
                            <?php foreach(ServiceGetter::getList() as $service): ?>
                                <li <?= is_numeric($params['service_id']) && $params['service_id'] == $service->id ? 'class="active"' : '' ?>>
                                    <a href="<?= Url::toRoute(array_merge($params ?? [], ['', 'service_id' => $service->id])) ?>">
                                        <span class="label-id"><?= $service->id ?></span> <?= $service->name ?>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </th>
                <th><?= Yii::t('app','panel.label.status') ?></th>
                <th class="dropdown-th">
                    <div class="dropdown">
                        <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?= Yii::t('app', 'panel.label.mode') ?>
                            <span class="caret"></span>
                        </button>
                        <?=
                            Menu::widget([
                                'options' => ['class' => 'dropdown-menu', 'aria-labelledby' => 'dropdownMenu1'],
                                'items' => [
                                    ['label' => Yii::t('app', 'panel.label.all'), 'url' => ['', 'status' => $params['status'],
                                        'service_id' => $params['service_id']], 'active' => !isset($params['mode'])],
                                    ['label' => Yii::t('app','panel.label.mode_manual'), 'url' => ['', 'status' => $params['status'], 'mode' => 1,
                                        'service_id' => $params['service_id']], 'active' => is_numeric($params['mode']) && $params['mode'] == 1],
                                    ['label' => Yii::t('app','panel.label.mode_auto'), 'url' => ['', 'status' => $params['status'], 'mode' => 0,
                                        'service_id' => $params['service_id']], 'active' => is_numeric($params['mode']) && $params['mode'] == 0],
                                ],
                                'activeCssClass'=>'active',
                            ]);
                        ?>
                    </div>
                </th>
                <th><?= Yii::t('app','panel.label.created') ?></th>
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
                            <span class="label-id"><?= $order->service_id ?></span>
                            <?= Service::findOne($order->service_id)->name ?>
                        </td>
                        <td><?= Yii::t('app', StatusGetter::get($order->status)) ?></td>
                        <td><?= Yii::t('app', ModeGetter::get($order->mode)) ?></td>
                        <td>
                            <span class="nowrap"><?= $order->getCreatedDate() ?></span>
                            <span class="nowrap"><?= $order->getCreatedTime() ?></span>
                        </td>
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
                <?= $pages->offset + 1 ?> to <?= $pages->offset + count($orders) ?> of <?= $pages->totalCount ?>
            </div>
        </div>
    </div>
</div>
