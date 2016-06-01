<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
?>
<?php $this->beginContent('@app/views/layouts/main.php');?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="header">
				MAIN NAVIGATION
			</li>
			<li <?php 
                    if ($controller=="site" && $action=="index") {
                        echo 'class="active treeview"'; } ?> >
				<a href="<?= Yii::$app->homeUrl; ?>"> 
				    <i class="fa fa-dashboard"></i> 
				    <span>Dashboard</span>
				</a>
			</li>
			<li <?php
                if ($controller=="user") {
                    echo 'class="active treeview"'; } ?> >
                <a href="#"> <i class="fa fa-folder"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li <?php 
                        if ($controller=="user" && $action=="index") {
                            echo 'class="active"'; } ?> >
                        <a href="<?= Yii::$app->urlManager->createUrl('user/index');?>"><i class="fa fa-circle-o"></i> Users</a>
                    </li>
                </ul>
            </li>
            <li <?php
            if ($controller=="tests-type") {
                echo 'class="active treeview"'; } ?> >
                <a href="<?= Yii::$app->urlManager->createUrl('tests-type/index');?>"> <i class="fa fa-folder"></i> <span>Tests Type</span> </a>
            </li>
			<li <?php 
                if ($controller=="chapters" || $controller=="chapters-content" || $controller=="question-type" || $controller=="test-section") {
                    echo 'class="active treeview"'; } ?> >
				<a href="#"> <i class="fa fa-pie-chart"></i> <span>CMS</span> <i class="fa fa-angle-left pull-right"></i> </a>
				<ul class="treeview-menu">
                    <li <?php
                    if ($controller=="chapters" && $action=="index") {
                        echo 'class="active"'; } ?> >
                        <a href="<?= Yii::$app->urlManager->createUrl('chapters/index');?>"><i class="fa fa-circle-o"></i> Chapters</a>
                    </li>
					<li <?php 
                        if ($controller=="chapters-content" && $action=="index") {
                            echo 'class="active"'; } ?> >
                        <a href="<?= Yii::$app->urlManager->createUrl('chapters-content/index');?>"><i class="fa fa-circle-o"></i> Chapters Content</a>
                    </li>
                    <li <?php 
                        if ($controller=="question-type" && $action=="index") {
                            echo 'class="active"'; } ?> >
                        <a href="<?= Yii::$app->urlManager->createUrl('question-type/index');?>"><i class="fa fa-circle-o"></i> Question Type</a>
                    </li>
                    <li <?php
                    if ($controller=="test-section" && $action=="index") {
                        echo 'class="active"'; } ?> >
                        <a href="<?= Yii::$app->urlManager->createUrl('test-section/index');?>"><i class="fa fa-circle-o"></i> Test Section</a>
                    </li>
				</ul>
			</li>
            <li <?php
            if ($controller=="slider" || $controller=="country" || $controller=="state" || $controller=="city" || $controller=="master-dropdown") {
                echo 'class="active treeview"'; } ?> >
				<a href="#"> <i class="fa fa-table"></i> <span>System</span> <i class="fa fa-angle-left pull-right"></i> </a>
				<ul class="treeview-menu">
                    <!--<li <?php
                    if ($controller=="slider" && $action=="index") {
                        echo 'class="active"'; } ?> >
                        <a href="<?= Yii::$app->urlManager->createUrl('slider/index');?>"><i class="fa fa-circle-o"></i> Banner</a>
                    </li>
                    <li <?php
                    if ($controller=="country" && $action=="index") {
                        echo 'class="active"'; } ?> >
                        <a href="<?= Yii::$app->urlManager->createUrl('country/index');?>"><i class="fa fa-circle-o"></i> Country</a>
                    </li>
                    <li <?php
                    if ($controller=="state" && $action=="index") {
                        echo 'class="active"'; } ?> >
                        <a href="<?= Yii::$app->urlManager->createUrl('state/index');?>"><i class="fa fa-circle-o"></i> State</a>
                    </li>
                    <li <?php
                    if ($controller=="city" && $action=="index") {
                        echo 'class="active"'; } ?> >
                        <a href="<?= Yii::$app->urlManager->createUrl('city/index');?>"><i class="fa fa-circle-o"></i> City</a>
                    </li>-->
                    <li <?php
                    if ($controller=="master-dropdown" && $action=="index") {
                        echo 'class="active"'; } ?> >
                        <a href="<?= Yii::$app->urlManager->createUrl('master-dropdown/index');?>"><i class="fa fa-circle-o"></i> Master Dropdown</a>
                    </li>
				</ul>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
    		<?= Html::encode($this->title) ?>
        	<small>Control panel</small>
        </h1>
         <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </section>

    <?php echo $content; ?>
</div><!-- /.content-wrapper -->

<?php $this->endContent();?>