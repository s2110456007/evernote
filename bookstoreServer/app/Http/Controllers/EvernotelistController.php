<?php

namespace App\Http\Controllers;

use App\Models\Evernotelist;
use App\Models\Note;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\error;

class EvernotelistController extends Controller
{
    public function index()
    {
        $lists = Evernotelist::with(['creator', 'notes'])->get();
        return response()->json($lists, 200);
    }

    public function store(Request $request)
    {
        $curUser = auth()->user();
        $request->merge(['created_by' =>$curUser->id]);

        DB::beginTransaction();

        try{
            $list = Evernotelist::create($request->all());

            if(isset($request['notes'])){
                throw new Exception("No Notes allowed on List creation!");
            }

            $list->save();

            DB::commit();
            return response()->json($list, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("Saving List failed: " . $e->getMessage(), 409);
        }
    }

    public function show($id)
    {
        $list = Evernotelist::where('id', $id)->with(['creator', 'notes',])->first();
        return $list != null ? response()->json($list, 200) : response()->json(null, 200);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try{
            $list = Evernotelist::with(['creator', 'notes'])->first();

            if($list != null){
                $list->update($request->all());
                $list->save();
            }

            DB::commit();

            $list1 = Evernotelist::where('id', $id)
                ->with(['creator', 'notes'])->first();

            return response()->json($list1, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("Updating List failed: " . $e->getMessage(), 409);
        }
    }

    public function destroy($id)
    {
        $list = Evernotelist::where('id', $id)->first();
        if($list != null){
            $list->delete();
            return response()->json('List ('.$id.') successfully deleted', 204);
        }
        return response()->json('List ('.$id.') dose not exist', 422);
    }
}
