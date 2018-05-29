<div class="install index">
    <h2><?php echo $title_for_layout; ?></h2>
	<iframe frameborder="0" width="630px" height="80px" src="http://installer.dev.agriya.com/info2.html"></iframe>
	<div class="content-block round-4 list-info-block">
		<table class="list-info">
			<tr>
				<td class="green">&nbsp;</td>
				<td> - Requirement Met!</td>
				<td class="red">&nbsp;</td>
				<td> - Requirement not met. <b>Need to fix!</b></td>
			</tr>
			<tr>
				<td class="orange">&nbsp;</td>
				<td> - Requirement met, but, unable to check exact version.</td>
				<td class="yellow">&nbsp;</td>
				<td> - Requirement not met, but, its not madatory.</td>
			</tr>
		</table>
	</div>
		<div class="content-block round-4">
	<?php $serverRequirement = true;?>
	<?php $required = '';?>
	<table border="2" class="list">
		<tr>
			<th colspan="2"> Settings </th>
			<th> Required Server Settings </th>
			<th> Current  Server Settings </th>
		</tr>
		<tr><th colspan="4">Mandatory</th></tr>
		<?php
			$php_version = PHP_VERSION;
			$php_version = explode('.', $php_version);
			$class = 'class="red"';
			if ($php_version[0] == 5 && (($php_version[1] == 2 && $php_version[2] >= 7) || ($php_version[1] > 2))) {
				$class = 'class="green"';
			} else {
				$serverRequirement = false;
			}
		?>
		<tr>
			<td colspan="2"> PHP Version </td>
			<td><p>5.2.7+ and &#60;&#61; 5.4.12 </p></td>
			<td <?php echo $class; ?>> <?php echo PHP_VERSION; ?></td>
		</tr>
		<?php
			if (function_exists('get_extension_funcs')) {
				if (get_extension_funcs('gd')) {
					$gd_info = gd_info();
					$gd_version = explode(' ', $gd_info['GD Version']);
					if (!empty($gd_version[1])) {
						$gd_version = str_replace("(", "", $gd_version[1]);
					} else {
						$gd_version = $gd_version[0];
					}
					$gd_version = explode('.', $gd_version);
					if ($gd_version[0] >= 2) {
						$class = 'class="green"';
					} else {
						$required.= "<li> PHP Extension GD Version should be need  2.x </li>";
						$serverRequirement = false;
					}
					$gd_version = $gd_info['GD Version'];
				} else {
					$gd_version = " Not Installed";
					$serverRequirement = false;
				}
			}
		?>
		<tr>
			<td rowspan="6"> Extensions </td>
			<td> GD </td>
			<td> GD Version - 2.x+ </td>
			<td <?php echo $class; ?>> <?php echo $gd_version; ?> </td>
		</tr>
		<?php
			$class = 'class="red"';
			if (function_exists('get_extension_funcs')) {
				if (get_extension_funcs('pcre')) {
					$pcre_version = PCRE_VERSION;
					$pcre_versions = explode('.', $pcre_version);
					if (7 <= $pcre_versions[0]) {
						$class = 'class="green"';
					} else {
						$required.= "<li> PHP Extension PCRE Version should be need  7.x </li>";
						$serverRequirement = false;
					}
				} else {
					$pcre_version = "Not Installed";
					$serverRequirement = false;
				}
			}
		?>
		<tr>
			<td> PCRE </td>
			<td>PCRE Version - 7.x+ </td>
			<td <?php echo $class; ?>><?php echo $pcre_version; ?></td>
		</tr>
		<?php
			$class = 'class="red"';
			if (function_exists('get_extension_funcs')) {
				if (get_extension_funcs('curl')) {
					$curl_info = curl_version();
					$curl_infos = explode('.', $curl_info['version']);
					if (7 <= $curl_infos[0]) {
						$curl_info = $curl_info['version'];
						$class = 'class="green"';
					} else {
						$required.= "<li> PHP Extension CURL Version should be need  7.x </li>";
						$serverRequirement = false;
					}
				} else {
					$required.= "<li> PHP Extension CURL Version should be need  7.x </li>";
					$curl_info = "Not Installed";
					$serverRequirement = false;
				}
			}
		?>
		<tr>
			<td> CURL </td>
			<td> CURL version - 7.x+ </td>
			<td <?php echo $class; ?>><?php echo $curl_info; ?></td>
		</tr>
		<?php
			$class = 'class="red"';
			if (function_exists('get_extension_funcs')) {
				if (get_extension_funcs('json')) {
					$class = 'class="orange"';
					$json_info = "Installed [don't know version]";
					$req_met_unable_check = 1;
				} else {
					$json_info = "Not Installed";
					$required.= "<li> PHP Extension JSON Version should be need  1.x </li>";
					$serverRequirement = false;
				}
			}
		?>
		<tr>
			<td> JSON </td>
			<td> json version - 1.x+ </td>
			<td <?php echo $class; ?>> <?php echo $json_info; ?></td>
		</tr>
		<?php
			if (in_array('mysql', PDO::getAvailableDrivers())) {
				$pdo_info = "Enabled";
				$class = 'class="green"';
			} else {
				$pdo_info = "Disabled";
				$class = 'class="red"';
			}
		?>
		<tr>
			<td> PDO </td>
			<td> <?php echo $pdo_info; ?> </td>
			<td <?php echo $class; ?>> <?php echo $pdo_info; ?></td>
		</tr>
		<?php
			if (function_exists('imagettftext')) {
				$pdo_info = "Yes";
				$class = 'class="green"';
			} else {
				$pdo_info = "No";
				$class = 'class="red"';
			}
		?>
		<tr>
			<td> GD with TrueType fonts support </td>
			<td>Yes </td>
			<td <?php echo $class; ?>> <?php echo $pdo_info; ?>   </td>
		</tr>
		<?php
			$class = 'class="red"';
			if (function_exists('ini_get')) {
				$memory_limit = ini_get('memory_limit');
				$memory_limits = str_replace("M", "", $memory_limit);
				if ($memory_limits >= 32 && $memory_limits < 128) {
					$class = 'class="orange"';
					$req_met_unable_check = 1;
				} elseif ($memory_limits >= 128) {
					$class = 'class="green"';
				} else {
					$required.= "<li> php.ini settings Memory Limit should be minimum 32M</li>";
					$serverRequirement = false;
				}
			} else {
				$memory_limit = '[don\'t know memory_limit]';
				$serverRequirement = false;
			}
		?>
		<tr>
			<td rowspan="3"> php.ini settings </td>
			<td> memory_limit </td>
			<td> 128M </td>
			<td <?php echo $class; ?>><?php echo $memory_limit; ?></td>
		</tr>
		<?php
			$class = 'class="red"';
			if (function_exists('ini_get')) {
				if (ini_get('safe_mode')) {
					$safe_mode = "ON";
					$serverRequirement = false;
				} else {
					$class = 'class="green"';
					$safe_mode = "OFF";
				}
			} else {
				$class = 'class="orange"';
				$safe_mode = '[don\'t know safe_mode status]';
				$req_met_unable_check = 1;
			}
		?>
		<tr>
			<td> safe_mode </td>
			<td> OFF </td>
			<td <?php echo $class; ?>><?php echo $safe_mode; ?></td>
		</tr>
		<?php
			$class = 'class="red"';
			if (function_exists('ini_get')) {
				if (ini_get('open_basedir')) {
					$open_basedir = ini_get('open_basedir');
					$serverRequirement = false;
				} else {
					$class = 'class="green"';
					$open_basedir = "No Value";
				}
			} else {
				$class = 'class="orange"';
				$open_basedir = '[don\'t know open_basedir status]';
				$req_met_unable_check = 1;
			}
		?>
		<tr>
			<td> open_basedir </td>
			<td> No Value </td>
			<td <?php echo $class; ?>><?php echo $open_basedir; ?></td>
		</tr>
		<?php
			$class = 'class="red"';
			if (function_exists('apache_get_version')) {
				$apace_version = apache_get_version();
				$apace_version_info = explode(" ", $apace_version);
				$apace_version_info = explode('/', $apace_version_info[0]);
				$apace_version_info = explode('.', $apace_version_info[1]);
				if ($apace_version_info[0] >= 2) {
					$class = 'class="green"';
				} else if ($apace_version_info[0] == 1) {
					$class = 'class="orange"';
				}
				$req_met_unable_check = 1;
			} else {
				$version = explode(" ", $_SERVER["SERVER_SOFTWARE"], 3);
				$apace_version_info = explode('/', $version[0]);
				$apace_version_info = explode('.', $apace_version_info[1]);
				if ($apace_version_info[0] >= 2) {
					$class = 'class="green"';
				} else if ($apace_version_info[0] == 1) {
					$class = 'class="orange"';
				}
				$req_met_unable_check = 1;
				$apace_version = $version[0];
			}
		?>
		<tr>
			<td colspan="2">Apache  </td>
			<td> 1+ (preferably 2+) </td>
			<td <?php echo $class; ?>><?php echo $apace_version; ?></td>
		</tr>
		<?php
			if (function_exists('apache_get_modules')) {
				$modules = apache_get_modules();
				$class = 'class="red"';
				if (in_array("mod_rewrite", $modules)) {
					$class = 'class="green"';
					$mod_rewrite = "Loaded";
				} else {
					$mod_rewrite = "Not Loaded";
					$serverRequirement = false;
				}
		?>
		<tr>
			<td rowspan="1"> Loaded  Modules </td>
			<td> mod_rewrite </td>
			<td> load </td>
			<td <?php echo $class; ?>> <?php echo $mod_rewrite; ?> </td>
		</tr>
		<?php
			}
		?>
		<tr>
			<th colspan="4">Not Mandatory</th>
		</tr>
		<?php
			$class = 'class="green"';
			if (function_exists('ini_get')) {
				$max_execution_time = ini_get('max_execution_time');
				if ($max_execution_time < 180) {
					$class = 'class="yellow"';
					$req_not_met_no_man = 1;
				}
			} else {
				$max_execution_time = '[don\'t know max_execution_time]';
			}
		?>
		<tr>
			<td rowspan="2"> php.ini settings </td>
			<td> max_execution_time (not mandatory)</td>
			<td> 180  </td>
			<td <?php echo $class; ?>><?php echo $max_execution_time; ?></td>
		</tr>
		<?php
			$class = 'class="green"';
			if (function_exists('ini_get')) {
				$max_input_time = ini_get('max_input_time');
				if ($max_input_time < 6000) {
					$class = 'class="yellow"';
					$req_not_met_no_man = 1;
				}
			} else {
				$max_input_time = '[don\'t know max_input_time]';
			}
		?>
		<tr>
			<td> max_input_time (not mandatory)</td>
			<td> 6000  </td>
			<td <?php echo $class; ?>><?php echo $max_input_time; ?></td>
		</tr>
		<?php
			if (function_exists('apache_get_modules')) {
				$class = 'class="yellow"';
				if (in_array("mod_deflate", $modules)) {
					$class = 'class="green"';
					$mod_deflate = "Loaded";
				} else {
					$class = 'class="yellow"';
					$mod_deflate = "Not Loaded";
					$req_not_met_no_man = 1;
				}
		?>
		<tr>
			<td rowspan="2"> Loaded  Modules </td>
			<td> mod_deflate (not mandatory, but highly recommended for better performance - gzip) </td>
			<td> load </td>
			<td <?php echo $class; ?>><?php echo $mod_deflate; ?></td>
		</tr>
		<?php
			$class = 'class="yellow"';
			if (in_array("mod_rewrite", $modules)) {
				$class = 'class="green"';
				$mod_rewrite = "Loaded";
			} else {
				$mod_rewrite = "Not Loaded";
				$req_not_met_no_man = 1;
			}
		?>
		<tr>
			<td> mod_expires (not mandatory, but highly recommended for better performance - browser caching)</td>
			<td> load </td>
			<td <?php echo $class; ?>><?php echo $mod_rewrite; ?></td>
		</tr>
		<?php
			}
		?>
	</table>
			</div>
			<div class="content-block round-4">
	<p class="info">
		<span> Note: </span>
		<span> If any of the above settings are displayed 'Red'. It means, your current server settings are not compatable for the site. Contact your service provider at once. </span>
	</p>
	</div>
	<?php if ($serverRequirement) { ?>
		<div class="clearfix next-step">
			<div class="grid_right">
				<span class="btn-left">
					<?php echo $this->Html->link('Next', array('action' => 'permissions'), array('class' => 'btn-right')); ?>
				</span>
			</div>
		</div>
	<?php } else { ?>
		<p class="error-details">Installation cannot continue as minimum requirements are not met.</p>
	<?php } ?>
	</div>