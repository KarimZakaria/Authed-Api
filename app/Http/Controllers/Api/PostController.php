<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Post;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Http\Requests\PostFormRequest;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $data['posts'] = PostResource::collection(Post::get());
        return $this->apiResponse($data);
    }

    public function show($id)
    {
        $post = Post::find($id);
        // $data['post'] = new PostResource(Post::findOrFail($id));
        if($post)
        {
            return $this->apiResponse(new PostResource($post), 200, 'Success'. $id);
        }
        else
        {
            return $this->apiResponse(null, 404, 'Not Found');
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255|min:5',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(), 'Something Went Wrong', 400);
        }
        $post = Post::create($request->all());
        return $this->apiResponse(new PostResource($post), 'Post Created Successfully', 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255|min:5',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse($validator->errors(), 'Something Went Wrong', 400);
        }
        $post = Post::find($id);
        if($post)
        {
            $post->update($request->all());
            return $this->apiResponse(new PostResource($post), 200, 'PostUpdated Successfully'. $id);
        }
        else
        {
            return $this->apiResponse('That ID IS NOT FOUND', 404, 'Not Found');
        }

    }
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post)
        {
            $post->delete($id);
            return $this->apiResponse(new PostResource($post), 200, 'Post '. $id . ' Deleted Successfully');
        }
        else
        {
            return $this->apiResponse('That ID IS NOT FOUND', 404, 'Not Found');
        }
    }
}
