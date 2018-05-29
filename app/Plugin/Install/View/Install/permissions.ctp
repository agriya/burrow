<div class="install index">
    <h2><?php echo $title_for_layout; ?></h2>
	<iframe frameborder="0" width="630px" height="80px" src="http://installer.dev.agriya.com/info3.html"></iframe>
	<div class="content-block round-4">
    <?php
        $filePermission = true;
		$directories = array(
			TMP,
			APP . 'media',
			JS,
			CSS,
			APP . 'Config',
			VENDORS . 'securimage'
		);
		$files = array(
			APP . 'Config',
			APP . 'webroot',
			APP . 'Console' . DS . 'Command' . DS . 'cron.sh',
			APP . 'Console' . DS . 'Command' . DS . 'CronShell.php',
			CAKE_CORE_INCLUDE_PATH . DS . 'Cake' . DS . 'Console' . DS . 'cake',
		);
	?>
	<table border="2" class="list">
		<tr>
			<th> Folders</th>
			<th> Permissions</th>
		</tr>
		<?php
			foreach($directories as $directory) {
				if (_is_writable_recursive($directory)) {
					echo '<tr><td> ' . $directory . '</td><td class="green">Writable</td></tr>';
				} else {
					$filePermission = false;
					echo '<tr><td>' . $directory . '</td><td class="red">Not Writable</td></tr>';
				}
			}
		?>
		<?php
			foreach($files as $file) {
				if (is_writable($file)) {
					echo '<tr><td> ' . $file . '</td><td class="green">Writable</td></tr>';
				} else {
					$filePermission = false;
					echo '<tr><td>' . $file . '</td><td class="red">Not Writable</td></tr>';
				}
			}
		?>
	</table>
	</div>
	<?php if ($filePermission) { ?>
		<div class="clearfix next-step">
			<div class="grid_right">
				<span class="btn-left">
					<?php echo $this->Html->link('Next', array('action' => 'license'), array('class' => 'btn-right')); ?>
				</span>
			</div>
		</div>
	<?php } else { ?>
		<p class="error-details">Installation cannot continue as minimum requirements are not met.</p>
	<?php } ?>
</div>
<?php
	function _is_writable_recursive($dir)
	{
		if (!($folder = @opendir($dir))) {
			return false;
		}
		while ($file = readdir($folder)) {
			if ($file != '.' && $file != '..' && $file != '.svn' && (!is_writable($dir . DS . $file) || (is_dir($dir . DS . $file) && !_is_writable_recursive($dir . DS . $file)))) {
				closedir($folder);
				return false;
			}
		}
		closedir($folder);
		return true;
	}
?>