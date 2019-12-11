<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Support\Facades\Auth; 
use Validator;

class PostsController extends Controller
{
    public $successStatus = 200;

    /**
     * index post
     */
    public function index()
    {
        $data = Post::all();

        if (count($data) > 0) {
            $result['message'] = "Success";
            $result['values'] = $data;
        } else {
            $result['message'] = "Failed";
        }

        return response()->json($result, $this->successStatus);
    }

    /**
     * show post
     */
    public function show($id)
    {
        $data = Post::where('id', $id)->get();

        if (count($data) > 0) {
            $result['message'] = "Success";
            $result['values'] = $data;
        } else {
            $result['message'] = "Failed";
        }

        return response()->json($result, $this->successStatus);
    }

    /**
     * add post
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        }

        $input = $request->all();

        $input['created_at'] = date('Y-m-d H:i:s');
        $input['updated_at'] = date('Y-m-d H:i:s');

        $post = Post::create($input);

        return response()->json(['message' => 'Success', 'data' => ['id' => $post->id]], $this->successStatus);
    }

    /**
     * edit post
     */
    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        }

        $data = Post::where('id', $id)->first();
        $data->title = $request->input('title');
        $data->content = $request->input('content');
        $data->active = $request->input('active');
        $data->updated_at = date('Y-m-d H:i:s');
        $data->updated_by = $request->input('updated_by');

        if ($data->save()) {
            $result['message'] = "Success";
            $result['value'] = $data;
        } else {
            $result['message'] = "Failed";
        }

        return response()->json($result, $this->successStatus);
    }

    /**
     * delete post
     */
    public function delete($id)
    {
        $data = Post::where('id', $id)->first();

        if ($data->delete()) {
            $result['message'] = "Success";
            $result['valued'] = $data;
        } else {
            $result['message'] = "Failed";
        }

        return response()->json($result, $this->successStatus);
    }
}