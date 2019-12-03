<?php global $gPage; if ($gPage === null) exit; ?>
		<div id="ProgressDialog" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"><?php echo Core\i18n::Get('PLEASE_WAIT'); ?></h4>
					</div>
					<div class="modal-body">
						<div class="progress">
							<div class="progress-bar progress-bar-info" style="width:0%"></div>
						</div>
					</div>
				</div>
			</div>
		</div><!--#ProgressDialog-->
