<?php
namespace App\middlewares;

use App\utils\HttpException;

class AdminMiddleware
{
    public function handle()
    {
        if (!isset($_SERVER['user']) || !isset($_SERVER['user']['is_admin'])) {
            throw new HttpException('Unauthorized', 401);
        }

        if ($_SERVER['user']['is_admin'] !== 1) {
            throw new HttpException('Access forbidden: admin only', 403);
        }
    }
}
