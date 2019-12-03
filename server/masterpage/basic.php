<?php global $gPage; if ($gPage === null) exit; ?>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand text-nowrap" href="<?php echo Core\Config::BASE_PATH; ?>"><img src="<?php echo Core\Config::GetLogoImageURL(); ?>">&ensp;<?php echo Core\Config::TITLE; ?></a>
				</div><!--.navbar-header-->
			</div><!--.container-->
		</nav>
<?php echo $gPage->GetContents(); ?>
