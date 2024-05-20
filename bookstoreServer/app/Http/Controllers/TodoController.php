<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::with(['note', 'creator', 'assignee', 'tags'])->get();
        return response()->json($todos, 200);
    }

    public function store(Request $request)
    {
        $curUser = auth()->user();
        $request->merge(['created_by' =>$curUser->id]);

        $request = $this->parseRequest($request);
        DB::beginTransaction();

        try{
            $todo = Todo::create($request->all());

            if(isset($request['tags']) && is_array($request['tags'])){
                foreach ($request['tags'] as $tag) {
                    $dbTag = Tag::firstOrNew([
                        'name' => $tag['name']
                    ]);
                    $todo->tags()->save($dbTag);
                }
            }

            DB::commit();
            return response()->json($todo, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("Saving Todo failed: " . $e->getMessage(), 409);
        }
    }

    public function getAddableTags($id)
    {
        $todo = Todo::with('tags')->find($id);
        if($todo){
            $excludedTagIds = $todo->tags->pluck('id')->toArray();

            $addableTags = Tag::whereNotIn('id', $excludedTagIds)->get();

            return response()->json($addableTags);
        }

        if($id == '-1'){
            $addableTags = Tag::all();

            return response()->json($addableTags);
        }

        return response()->json('no note found', status:404);
    }

    public function show($id)
    {
        $todos = Todo::where('id', $id)
        ->with(['note', 'creator', 'assignee', 'tags'])->first();
        return $todos != null ? response()->json($todos, 200) : response()->json(null, 200);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try{
            $todo = Todo::with(['note', 'creator', 'assignee', 'tags'])
                ->where('id', $id)->first();

            if($todo != null) {
                $request = $this->parseRequest($request);
                $todo->update($request->all());


                $ids = [];
                if (isset($request['tags']) && is_array($request['tags'])) {
                    foreach ($request['tags'] as $tag) {
                        array_push($ids, $tag['id']);
                    }
                }

                $todo->tags()->sync($ids);
                $todo->save();
            }

            DB::commit();

            $todo1 = Todo::with(['note', 'creator', 'assignee', 'tags'])
                ->where('id', $id)->first();

            return response()->json($todo1, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("Updating Todo failed: " . $e->getMessage(), 409);
        }
    }

    public function destroy($id)
    {
        $todo = Todo::where('id', $id)->first();
        if($todo != null){
            $todo->delete();
            return response()->json('Todo ('.$id.') successfully deleted', 204);
        }
        return response()->json('Todo ('.$id.') dose not exist', 422);
    }

    private function parseRequest (Request $request) :Request {
        $date = new \DateTime($request->due_date);
        $request['published'] = $date->format('Y-m-d H:i:s');
        return $request;
    }
}
