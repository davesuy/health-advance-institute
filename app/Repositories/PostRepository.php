<?php

namespace App\Repositories;

use App\Models\Post;
use App\Services\ShardingService;

class PostRepository implements PostRepositoryInterface
{
    protected $model;
    protected $shardingService;

    public function __construct(Post $post, ShardingService $shardingService)
    {
        $this->model = $post;
        $this->shardingService = $shardingService;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        $connection = $this->shardingService->getShardConnection($data['user_id']);
        return $connection->table($this->model->getTable())->insert($data);
    }

    public function update($id, array $data)
    {
        $post = $this->model->find($id);
        if ($post) {
            $connection = $this->shardingService->getShardConnection($post->user_id);
            $connection->table($this->model->getTable())->where('id', $id)->update($data);
            return $post->fill($data);
        }
        return null;
    }

    public function delete($id)
    {
        $post = $this->model->find($id);
        if ($post) {
            $connection = $this->shardingService->getShardConnection($post->user_id);
            return $connection->table($this->model->getTable())->where('id', $id)->delete();
        }
        return false;
    }

    public function find($id)
    {
        $post = $this->model->find($id);
        if ($post) {
            $connection = $this->shardingService->getShardConnection($post->user_id);
            return $connection->table($this->model->getTable())->where('id', $id)->first();
        }
        return null;
    }
}
