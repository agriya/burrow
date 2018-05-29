<?php
/**
 * Burrow
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    Burrow
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
$content_analytics = '';
if (isPluginEnabled('IntegratedGoogleAnalytics')) {
    $content_analytics = __l('To analyze the site analytic status detail and also it shows the graphical representation of overall bounce rate and traffic');
}
CmsHook::setExceptionUrl(array(
    'insights/public_stats',
));
CmsNav::add('analytics', array(
    'title' => __l('Analytics') ,
    'data-bootstro-step' => '3',
    'data-bootstro-content' => __l('To analyze overall user registration rate, their demographics, user login rate and also the overall project posting/funding rate.'),
    'icon-class' => 'bar-chart',
    'weight' => 21,
    'children' => array(
		'insights' => array(
            'title' => __l('Insights') ,
            'url' => array(
                'admin' => true,
                'controller' => 'insights',
                'action' => 'admin_index',
            ) ,
            'weight' => 20,
        ) ,
    )
));
CmsNav::add('masters', array(
    'title' => 'Masters',
    'weight' => 200,
    'children' => array(
        'Demographics' => array(
            'title' => __l('Demographics') ,
            'url' => '',
            'weight' => 3000,
        ) ,
        'Educations' => array(
            'title' => __l('Educations') ,
            'url' => array(
                'controller' => 'user_educations',
                'action' => 'index',
            ) ,
            'weight' => 3001,
        ) ,
        'Employments' => array(
            'title' => __l('Employments') ,
            'url' => array(
                'controller' => 'user_employments',
                'action' => 'index',
            ) ,
            'weight' => 3002,
        ) ,
        'IncomeRanges' => array(
            'title' => __l('Income Ranges') ,
            'url' => array(
                'controller' => 'user_income_ranges',
                'action' => 'index',
            ) ,
            'weight' => 3003,
        ) ,
		'Habits' => array(
            'title' => __l('Habits') ,
            'url' => array(
                'controller' => 'habits',
                'action' => 'index',
            ) ,
            'weight' => 3004,
        ) ,
        'Relationships' => array(
            'title' => __l('Relationships') ,
            'url' => array(
                'controller' => 'user_relationships',
                'action' => 'index',
            ) ,
            'weight' => 3005,
        ) ,
    )
));
$defaultModel = array(
    'UserProfile' => array(
        'belongsTo' => array(
            'UserEducation' => array(
                'className' => 'Insights.UserEducation',
                'foreignKey' => 'user_education_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ) ,
            'UserEmployment' => array(
                'className' => 'Insights.UserEmployment',
                'foreignKey' => 'user_employment_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ) ,
            'UserRelationship' => array(
                'className' => 'Insights.UserRelationship',
                'foreignKey' => 'user_relationship_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ) ,
            'UserIncomeRange' => array(
                'className' => 'Insights.UserIncomeRange',
                'foreignKey' => 'user_income_range_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ) ,
        ) ,
    )
);
CmsHook::bindModel($defaultModel);
CmsHook::setJsFile(array(
    APP . 'Plugin' . DS . 'Insights' . DS . 'webroot' . DS . 'js' . DS . 'libs' . DS . 'highcharts.js',
    APP . 'Plugin' . DS . 'Insights' . DS . 'webroot' . DS . 'js' . DS . 'libs' . DS . 'fhighcharts.js',
) , 'admin');
?>