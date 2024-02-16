<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\To_do_list;
use Carbon\Carbon;


class ListController extends Controller
{
  

    public function addList(Request $req)
    {
        $list = new To_do_list;
        $list->title = $req->title;
        $list->content = $req->content;
        $list->user_id = $req->user_id;
        $list->due_date =$req->due_date;
     
    
        $result = $list->save();
        
        if ($result) {
            return ["Result" => "Data has been saved"];
        } else {
            return ["Result" => "Operation Failed"];
        }
    }

    public function deleteList($id)
    {
    
        try {

        $list  = To_do_list::findOrFail($id);


      $list ->delete();

        return ["Result" => "Deleted successfully"];
    } catch (\Exception $e) {
   
        return ["Result" => "Error: " . $e->getMessage()];
    }
    }


    
    
    public function updateList(Request $request, $id)
    {
        $list = To_do_list::find($id);
    

        if (!$list) {
            return response()->json(['message' => 'List not found'], 404);
        }
    
        
        $validatedData = [];
        if ($request->filled('title')) {
            $validatedData['title'] = $request->input('title');
        }
        if ($request->filled('content')) {
            $validatedData['content'] = $request->input('content');
        }
    
     
        if (empty($validatedData)) {
            return response()->json(['message' => 'No fields provided for update'], 400);
        }
    
        
        $list->fill($validatedData);
        $list->save();
    
        return ["Result" => "Updated successfully"];
    }
    
    
    


    public function getListById($user_id)
    {
        $lists = To_do_list::where('user_id', $user_id)->get();

        if ($lists->count() > 0) {
            return response()->json($lists, 200);
        } else {
            return response()->json(['message' => 'TO DO LISTS NOT FOUND'], 404);
        }
    }




  

   

    public function calculateWeeksDifference($inputDate)
    {

        $startDate = Carbon::parse($inputDate);

        $currentDate = Carbon::now();

        $weeksDifference = $startDate->diffInWeeks($currentDate);

        return $weeksDifference;
    }

    public function calculateDaysDifference($inputDate)
    {

        $startDate = Carbon::parse($inputDate);

        $currentDate = Carbon::now();

        $daysDifference = $startDate->diffInDays($currentDate);

        return $daysDifference;
    }


    public function calculateWeeksAndDaysPregrency($inputDate)
    {
        $startDate = Carbon::parse($inputDate);

        $currentDate = Carbon::now();

        $weeksDifference = $startDate->diffInWeeks($currentDate);
        $remainingDays = $startDate->diffInDays($currentDate) % 7;

        if ($remainingDays === 7) {
            $weeksDifference++;
            $remainingDays = 0;
        }
        return [
            'weeks' => $weeksDifference,
            'days' => $remainingDays,
        ];
    }
}









