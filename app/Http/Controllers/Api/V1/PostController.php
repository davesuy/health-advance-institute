<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\PostRepositoryInterface;
use App\Services\TagService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postRepository;
    protected $tagService;

    public function __construct(PostRepositoryInterface $postRepository, TagService $tagService)
    {
        $this->postRepository = $postRepository;
        $this->tagService = $tagService;
    }

    public function index()
    {
        $posts = $this->postRepository->all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $data = $request->only(['title', 'body', 'user_id', 'tags']);
        $post = $this->postRepository->create($data);

        if (isset($data['tags'])) {
            foreach ($data['tags'] as $tagName) {
                $this->tagService->ensureTagExists($tagName);
                $tag = \App\Models\Tag::where('name', $tagName)->first();
                $post->tags()->attach($tag);
            }
        }

        return response()->json(['message' => 'Post created successfully']);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['title', 'body']);
        $this->postRepository->update($id, $data);
        return response()->json(['message' => 'Post updated successfully']);
    }

    public function destroy($id)
    {
        $this->postRepository->delete($id);
        return response()->json(['message' => 'Post deleted successfully']);
    }

    public function show($id)
    {
        $post = $this->postRepository->find($id);
        return response()->json($post);
    }
}
