<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to the task</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/flat-ui.min.css">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
	      rel="stylesheet"
	      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
	      crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo e('css/app.css'); ?>">
	<?php echo $__env->yieldPushContent('styles'); ?>
	<script>
		window.Laravel = <?php echo json_encode([
			'csrfToken' => csrf_token(),
			'api_token' => Auth::user()->api_token
		]); ?>
	</script>
</head>
<body>
	<div class="container" id="app">
		<?php echo $__env->yieldContent('content'); ?>
	</div>
	<footer class="footer">
		<div class="container">
			<p class="text-muted">Code Test</p>
		</div>
	</footer>
	<?php echo $__env->yieldPushContent('json'); ?>
	<script src="<?php echo e('js/app.js'); ?>"></script>
	<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
