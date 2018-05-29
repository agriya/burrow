<?php /*
foreach ($types_for_admin_layout as $t):
    CmsNav::add('cms.children.content.children.create.children.' . $t['Type']['alias'], array(
        'title' => $t['Type']['title'],
        'url' => array(
            'admin' => true,
            'controller' => 'nodes',
            'action' => 'add',
            $t['Type']['alias'],
            ),
        ));
endforeach;

foreach ($vocabularies_for_admin_layout as $v):
    $weight = 9999 + $v['Vocabulary']['weight'];
    CmsNav::add('cms.children.content.children.taxonomy.children.' . $v['Vocabulary']['alias'], array(
        'title' => $v['Vocabulary']['title'],
        'url' => array(
            'admin' => true,
            'controller' => 'terms',
            'action' => 'index',
            $v['Vocabulary']['id'],
            ),
        'weight' => $weight,
        ));
endforeach;

foreach ($menus_for_admin_layout as $m):
    $weight = 9999 + $m['Menu']['weight'];
    CmsNav::add('cms.children.menus.children.' . $m['Menu']['alias'], array(
        'title' => $m['Menu']['title'],
        'url' => array(
            'admin' => true,
            'controller' => 'links',
            'action' => 'index',
            $m['Menu']['id'],
            ),
        'weight' => $weight,
        ));
endforeach;*/

echo $this->Layout->adminMenus(CmsNav::items());
?>