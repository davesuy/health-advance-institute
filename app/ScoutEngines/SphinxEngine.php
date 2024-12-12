<?php

namespace App\ScoutEngines;

use Illuminate\Support\Facades\Log;
use Laravel\Scout\Builder;
use Laravel\Scout\Engines\Engine;
use Foolz\SphinxQL\SphinxQL;
use Foolz\SphinxQL\Drivers\Mysqli\Connection;
use mysqli_sql_exception;

class SphinxEngine extends Engine
{
    protected $sphinx;

    public function __construct()
    {
       // Log::info('Initializing SphinxEngine');
        $this->sphinx = new Connection();
        $this->sphinx->setParams([
            'host' => env('SPHINX_HOST', '127.0.0.1'),
            'port' => env('SPHINX_PORT', 9312)
        ]);
        $this->connect();
    }

    protected function connect()
    {
        try {
            $this->sphinx->connect();
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 2006) { // MySQL server has gone away
                $this->reconnect();
            } else {
                throw $e;
            }
        }
    }

    protected function reconnect()
    {
        if ($this->isConnected()) {
            $this->sphinx->close();
        }
        $this->connect();
    }

    protected function isConnected()
    {
        try {
            $this->sphinx->ping();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function search(Builder $builder)
    {

        Log::info('SphinxEngine search method called');
        try {
            $sphinxQL = new SphinxQL($this->sphinx);
            $sphinxQL->select('*')
                ->from('test1')
                ->match('content', $builder->query);
            $result = $sphinxQL->execute();
            return $result->fetchAllAssoc();
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 2006) { // MySQL server has gone away
                $this->reconnect();
                return $this->search($builder);
            }
            throw $e;
        }
    }

    public function mapIds($results)
    {
        return collect(array_keys($results));
    }

    public function map(Builder $builder, $results, $model)
    {
        if (count($results) === 0) {
            return $model->newCollection();
        }

        $keys = $this->mapIds($results)->all();
        return $model->getScoutModelsByIds($builder, $keys)->get();
    }

    public function getTotalCount($results)
    {
        return count($results);
    }

    public function flush($model)
    {
        // Implement the flush logic
    }

    public function paginate(Builder $builder, $perPage, $page)
    {
        // Implement the paginate logic
    }

    public function createIndex($name, array $options = [])
    {
        // Implement the createIndex logic
    }

    public function deleteIndex($name)
    {
        // Implement the deleteIndex logic
    }

    public function lazyMap(Builder $builder, $results, $model)
    {
        // Implement the lazyMap logic
    }

    public function update($models)
    {
        // Implement the update logic
    }

    public function delete($models)
    {
        // Implement the delete logic
    }
}
