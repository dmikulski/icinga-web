<?php echo '<?xml version="1.0" encoding="utf-8"?>'. chr(10); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<base href="<?php echo $ro->getBaseHref(); ?>" />
		<title><?php if(isset($t['title'])) echo htmlspecialchars($t['title']) . ' - '; echo AgaviConfig::get('core.app_name'); ?></title>
		<link rel="shortcut icon" type="image/x-icon" href="images/icinga/favicon.ico" />
		<?php echo $slots['additional_header_data']; ?>
		
	</head>
	<body id="default">
	
		<div id="main-container">
		
			<div id="frameTop">
				
				<div id="navigationTop">
					<?php echo $slots['navigation_top']; ?>
				</div>

			</div>

			<div id="frameMiddle">
				
				<?php echo (array_key_exists('navigation_left', $slots)) ? $slots['navigation_left'] : null; ?>
				
				<div id="contentArea">
				<?php if(isset($t['title'])) echo '<h1 class="pageTitle">' . htmlspecialchars($t['title']) . '</h1>'; ?>
				
				<?php echo $slots['error_frame']; ?>
				
				<?php echo $inner; ?>
				</div>
			</div>
		
		</div>
	</body>
</html>
