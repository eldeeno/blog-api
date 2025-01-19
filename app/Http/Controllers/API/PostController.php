<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\UnauthorizedException;

class PostController extends Controller
{
    public function __construct(private PostService $postService) {}

    public function getPosts()
    {
        try {
            $posts = $this->postService->fetchAll();

            return $this->okResponse('Fetched successfully.', PostResource::collection($posts));
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function getPost($id)
    {
        try {
            $post = $this->postService->fetch($id);

            return $this->okResponse('Fetched successfully.', new PostResource($post));
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function createPost(StorePostRequest $request)
    {
        try {
            $post = $this->postService->create($request->validated());

            return $this->createdResponse('Post created successfully.', new PostResource($post));
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function updatePost(UpdatePostRequest $request, $id)
    {
        try {
            $post = $this->postService->fetch($id);

            Gate::authorize('update', $post);

            $post = $this->postService->update($request->validated(), $id);

            return $this->okResponse('Post updated successfully.', new PostResource($post));
        } catch (UnauthorizedException $e) {
            return $this->unauthorizedResponse('You are not authorized to perform this action.', $e);
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function deletePost($id)
    {
        try {
            $post = $this->postService->fetch($id);

            Gate::authorize('delete', $post);

            $this->postService->delete($id);

            return $this->okResponse('Post deleted successfully.');
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }
}
