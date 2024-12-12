<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ShardingService
{
    public function ensureUserExists($userId)
    {
        $shardConnection = $this->getShardConnection($userId);
        $userExists = DB::connection($shardConnection->getName())->table('users')->where('id', $userId)->exists();

        if (!$userExists) {
            // Create the user in the shard database
            DB::connection($shardConnection->getName())->table('users')->insert([
                'id' => $userId,
                'name' => config('sharding.default_user_name', 'Default User'),
                'email' => 'user' . $userId . '@example.com', // Generate a unique email
                'password' => bcrypt(config('sharding.default_user_password', 'password')),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function getShardConnection($userId)
    {
        // Updated sharding logic to avoid using shard0
        $shardId = ($userId % 2) + 1; // Adjusted to start from shard1
        return DB::connection('shard' . $shardId);
    }
}
