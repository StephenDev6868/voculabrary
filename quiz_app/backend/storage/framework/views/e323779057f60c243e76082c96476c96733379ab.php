<script type="text/javascript" src="<?php echo e(asset('js/ckfinder/ckfinder.js')); ?>"></script>
<script>CKFinder.config( { connectorPath: <?php echo json_encode(route('ckfinder_connector'), 15, 512) ?> } );</script>
<?php /**PATH /var/www/backend/vendor/ckfinder/ckfinder-laravel-package/views/setup.blade.php ENDPATH**/ ?>