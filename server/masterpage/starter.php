<?php global $gPage; if ($gPage === null) exit; ?>
<?php $loggedInAccount = $gPage->GetLoggedInAccount(); ?>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand text-nowrap" href="<?php echo Core\Config::BASE_PATH; ?>"><img src="<?php echo Core\Config::GetLogoImageURL(); ?>">&ensp;<?php echo Core\Config::TITLE; ?></a>
				</div><!--.navbar-header-->
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right">
<?php if ($loggedInAccount === null) { ?>
						<li><a href="register.php"><i class="fa fa-user-plus fa-fw"></i>&nbsp;<?php echo Core\i18n::Get('REGISTER'); ?></a></li>
						<li><a href="login.php"><i class="fa fa-sign-in fa-fw"></i>&nbsp;<?php echo Core\i18n::Get('LOG_IN'); ?></a></li>
<?php } else { ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-fw"></i>&nbsp;<?php echo $loggedInAccount->Username; ?>&nbsp;<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="settings.php"><i class="fa fa-gear fa-fw"></i>&ensp;<?php echo Core\i18n::Get('SETTINGS'); ?></a></li>
								<li class="divider"></li>
								<li><a id="LogOut"><i class="fa fa-sign-out fa-fw"></i>&ensp;<?php echo Core\i18n::Get('LOG_OUT'); ?></a></li>
							</ul>
						</li>
<?php } ?>
					</ul>
				</div><!--.navbar-collapse-->
			</div><!--.container-->
		</nav>
<?php echo $gPage->GetContents(); ?>
		<div class="footer container">
			<hr>
			<p class="text-muted"><?php echo Core\i18n::Get('COPYRIGHT', date("Y"), Core\Config::TITLE); ?></p>
		</div><!--.footer-->
