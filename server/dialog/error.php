<?php global $gPage; if ($gPage === null) exit; ?>
		<div id="ErrorDialog" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
						<h4 class="modal-title"><?php echo Core\i18n::Get('ERROR'); ?></h4>
					</div>
					<div class="modal-body alert-danger">&zwnj;</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Core\i18n::Get('OK'); ?></button>
					</div>
				</div>
			</div>
		</div><!--#ErrorDialog-->
