<?php global $gPage; if ($gPage === null) exit; ?>
		<div id="DeleteDialog" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
						<h4 class="modal-title"><?php echo Core\i18n::Get('DELETE'); ?></h4>
					</div>
					<div class="modal-body"><?php echo Core\i18n::Get('ARE_YOU_SURE_YOU_WANT_TO_DELETE'); ?></div>
					<div class="modal-footer">
						<button type="button" id="DeleteDialog_ConfirmButton" class="btn btn-danger" data-dismiss="modal"><?php echo Core\i18n::Get('DELETE'); ?></button>
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Core\i18n::Get('CANCEL'); ?></button>
					</div>
				</div>
			</div>
		</div><!--#DeleteDialog-->
