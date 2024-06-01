<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * @throws \Exception
     */
    public function store(StorePostRequest $request)
    {
         $data =$request->validated();
         $user= $request->user();
//         dd($data);



        DB::beginTransaction();
        $allFilePath=[];
        try{
            $post = Post::create($data);
            /** @var UploadedFile[] $files */
            $files = $data['attachments'] ?? [];
            foreach ($files as $file){
                $path  =$file->store('attachments/'.$post->id,'public');
                $allFilePath[] =$path;
                PostAttachment::create([
                    'post_id' => $post->id,
                    'name'=>$file->getClientOriginalName(),
                    'path'=>$path,
                    'mime'=>$file->getMimeType(),
                    'size'=>$file->getSize(),
                    'created_by' =>$user->id
                ]);
            }
            DB::commit();
        }
        catch (\Exception $e){
            foreach ($allFilePath as $path){
                Storage::disk('public')->delete($path);
            }
            DB::rollBack();
            throw  $e;
        }

         return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data=$request->validated();
        $user =$request->user();
        DB::beginTransaction();
        $allFilePath=[];
        try{

            $post->update($data);
            $deleted_ids = $data['deleted_file_ids'] ?? [];
            $attachments = PostAttachment::query()
                ->where('post_id',$post->id)
                ->where('id',$deleted_ids)
                ->get();

            foreach ($attachments as $attachment){
                $attachment->delete();
            }
             /** @var UploadedFile[] $files */
            $files = $data['attachments'] ?? [];
            foreach ($files as $file){
                $path  =$file->store('attachments/'.$post->id,'public');
                $allFilePath[] =$path;
                PostAttachment::create([
                    'post_id' => $post->id,
                    'name'=>$file->getClientOriginalName(),
                    'path'=>$path,
                    'mime'=>$file->getMimeType(),
                    'size'=>$file->getSize(),
                    'created_by' =>$user->id
                ]);
            }
            DB::commit();
        }
        catch (\Exception $e){
            foreach ($allFilePath as $path){
                Storage::disk('public')->delete($path);
            }
            DB::rollBack();
            throw  $e;
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $id=Auth::id();

        if($post->user_id != $id){
            return response("You don't have permission to delete this post");
        }

        $post->delete();
        return  back();
    }

    public  function  downloadAttachment(PostAttachment $attachment)
    {
        //TODO check if user has permission to download
        return response()->download(Storage::disk('public')->path($attachment->path),$attachment->name);

    }
}
