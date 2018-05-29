<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc><?php echo Router::url('/',true); ?></loc>
		<changefreq>daily</changefreq>
		<priority>1.0</priority>
	</url>
<?php
if (!empty($import_models)):
    foreach ($import_models as $model_name => $settings):
        $priority = $settings['priority'];
        unset($settings['priority']);
        $i = 0;
        do {
            $settings['offset'] = $i;
            $models = $_this->$model_name->find('all', $settings);
            if (!empty($models)):
?>
	<!-- <?php echo $model_name; ?> -->
<?php
				foreach ($models as $model):
?>
	<url>
		<loc><?php echo Router::url(array('controller' => Inflector::tableize($model_name), 'action' => 'view', $model[$model_name][$settings['fields'][0]]), true); ?></loc>
		<lastmod><?php echo $this->Time->toAtom($model[$model_name]['modified']); ?></lastmod>
		<priority><?php echo $priority;?></priority>
	</url>
<?php
				endforeach;
			endif;
			$i+= 20;
		}
        while (!empty($models));
    endforeach;
endif;
?>
</urlset>