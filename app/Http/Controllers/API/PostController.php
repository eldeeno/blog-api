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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $posts = $this->postService->fetchPosts();

            return $this->okResponse('Fetched successfully.', PostResource::collection($posts));
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        try {
            $post = $this->postService->createPost($request->validated());

            return $this->createdResponse('Post created successfully.', new PostResource($post));
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $post = $this->postService->fetchPost($id);

            return $this->okResponse('Fetched successfully.', new PostResource($post));
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, $id)
    {
        try {
            $post = $this->postService->fetchPost($id);

            Gate::authorize('update', $post);

            $post = $this->postService->updatePost($request->validated(), $id);

            return $this->okResponse('Post updated successfully.', new PostResource($post));
        } catch (UnauthorizedException $e) {
            return $this->unauthorizedResponse('You are not authorized to perform this action.');
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $post = $this->postService->fetch($id);

            Gate::authorize('delete', $post);

            $this->postService->deletePost($id);

            return $this->okResponse('Post deleted successfully.');
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }
}
