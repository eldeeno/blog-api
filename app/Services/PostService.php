<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Post $post) {}

    public function fetchAll()
    {
        return $this->post
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function fetch(int $id)
    {
        return $this->post->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['user_id'] = Auth::user()->id;
        return $this->post->create($data);
    }

    public function update(array $data, int $id)
    {
        $post = $this->post->findOrFail($id);
        $post->update($data);

        return $post;
    }

    public function delete(int $id): void
    {
        $this->post->destroy($id);
    }
}
