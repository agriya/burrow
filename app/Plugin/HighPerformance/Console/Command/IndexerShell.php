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
require_once APP . 'Plugin' . DS . 'HighPerformance' . DS . 'Console' . DS . 'Command' . DS . 'TrueShell.php';
class IndexerShell extends TrueShell
{
    public $tasks = array();
    public function nout($str) 
    {
        $this->out($str, 0);
    }
    public function help() 
    {
        $this->info('Usage: ');
        $this->info(' fill    [modelname]');
        $this->info(' search (<modelname>|_all) <query>');
        $this->info('');
    }
    public function fill($modelName = null) 
    {
        $modelName = @$this->args[1];
        if ($modelName === '_all' || !$modelName) {
            $Models = $this->allModels(true);
            // Purge all
            $x = $Models[0]->Behaviors->Searchable->execute($Models[0], 'DELETE', '', array(
                'fullIndex' => true,
            ));
        } else {
            $Models = array(
                ClassRegistry::init($modelName)
            );
        }
        $cbProgress = array(
            $this,
            'nout'
        );
        foreach($Models as $Model) {
            $this->info('> Indexing %s', $Model->name);
            if (false === ($count = $Model->elastic_fill($cbProgress))) {
                return $this->err('Error indexing model: %s. errors: %s', $Model->name, $Model->Behaviors->Searchable->errors);
            }
            $this->out('');
            $this->info('%7s %18s have been added to the Elastic index', $count, $Model->name);
            $this->out('', 2);
        }
    }
    public function search($modelName = null, $query = null) 
    {
        $modelName = @$this->args[1];
        if ($modelName === '_all' || !$modelName) {
            $models = $this->allModels();
        } else {
            $models = array(
                $modelName
            );
        }
        foreach($models as $modelName) {
            if ($query === null && !($query = @$this->args[1])) {
                return $this->err('Need to specify: $query');
            }
            if (!($Model = ClassRegistry::init($modelName))) {
                return $this->err('Can\'t instantiate model: %s', $modelName);
            }
            $raw_results = $Model->elastic_search($query);
            if (is_string($raw_results)) {
                $this->crit($raw_results);
            }
            pr(compact('raw_results'));
        }
    }
    public function allModels($instantiated = false) 
    {
        App::uses('ModelBehavior', 'Model');
        App::uses('SearchableBehavior', 'HighPerformance.Model/Behavior');
        return SearchableBehavior::allModels($instantiated);
    }
}
