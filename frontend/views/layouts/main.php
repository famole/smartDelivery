<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Portisur Congelados',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Inicio', 'url' => ['/site/login']],
                ['label' => 'Mapa', 'url' => ['/site/mapa']],
                ['label' => 'Mapa2', 'url' => ['/site/mapa2']],
            ];
            if (!Yii::$app->user->isGuest) {
                
                //Personal
                $menuItems[] = ['label' => 'Personal',
                            'items' => [
                                ['label' => 'Categorias', 'url' => ['/personalcat/index']],
                                ['label' => 'Trabajar con Personal', 'url' => ['/personal/index']],
                                
                            ]];
                
                //Configuracion
                $menuItems[] = ['label' => 'Configuracion',
                            'items' => [
                                ['label' => 'Direcciones', 'url' => ['/direccion/index']],
                                ['label' => 'Estados', 'url' => ['/estados/index']],
                                ['label' => 'Pedidos', 'url' => ['/pedido/index']],
                                ['label' => 'Tipo de Vehiculos', 'url' => ['/tipovehiculo/index']],
                                ['label' => 'Turnos de Entrega', 'url' => ['/turnosentrega/index']],
                                ['label' => 'Vehiculos', 'url' => ['/vehiculo/index']],
                                ['label' => 'Zona', 'url' => ['/zona/index']],
                            ]];
                
                //Sistema
                $menuItems[]= [ 'label' => 'Sistema',
                            'items' => [
                                ['label' => 'Parametros', 'url' => ['/parametros/index']],
                            ]];
                
                $menuItems[] = [
                    'label' => 'Salir (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; Portisur Congelados <?= date('Y') ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
