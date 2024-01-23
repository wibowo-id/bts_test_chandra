<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function GetAllChecklist()
    {
        $datas = Checklist::all();

        return response()->json([
           'code' => 200,
           'data' => $datas
        ]);
    }

    public function CreateChecklist(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|string',
        ]);

        try {
            $model = new Checklist();
            $model->name = $request->input('name');
            $model->save();

            $code = 200;
            $message = "Data berhasil disimpan";
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
        }

        $data = array(
            'code'=> $code,
            'success'=> $code == 200 ? true : false,
            'message'=> $message
        );

        return response()->json($data);
    }

    public function DeleteChecklist($id)
    {
        Checklist::find($id)->delete();

        return response()->json([
           'code' => 200,
           'message' => 'berhasil hapus data'
        ]);
    }

    public function GetAllChecklistItem()
    {
        $datas = ChecklistItem::select('checklist_items.*', 'checklists.name as checklist_name')->join('checklists', 'checklists.id', '=', 'checklist_items.checklist_id')->get();

        return response()->json([
           'code' => 200,
           'data' => $datas
        ]);
    }

    public function CreateChecklistItem(Request $request, $checklistId)
    {
        $this->validate($request, [
            'itemName' => 'required|string',
        ]);

        try {
            $model = new ChecklistItem();
            $model->itemName = $request->input('itemName');
            $model->checklist_id = $checklistId;
            $model->save();

            $code = 200;
            $message = "Data berhasil disimpan";
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
        }

        $data = array(
            'code'=> $code,
            'success'=> $code == 200 ? true : false,
            'message'=> $message
        );

        return response()->json($data);
    }

    public function GetChecklistItemDetail($checklistId, $id)
    {
        $datas = ChecklistItem::where('id', '=', $id)->where('checklist_id', '=', $checklistId)->get();

        return response()->json([
           'code' => 200,
           'data' => $datas
        ]);
    }

    public function UpdateChecklistItemDetail(Request $request, $id, $checklistId)
    {
        $this->validate($request, [
            'itemName' => 'required|string',
        ]);

        try {
            $model = ChecklistItem::where('id', '=', $id)->where('checklist_id', '=', $checklistId)->update([
                'itemName' => $request->input('itemName')
            ]);

            $code = 200;
            $message = "Data berhasil di edit";
        } catch (\Exception $e) {
            $code = 500;
            $message = $e->getMessage();
        }

        $data = array(
            'code'=> $code,
            'success'=> $code == 200 ? true : false,
            'message'=> $message
        );

        return response()->json($data);
    }

    public function DeleteChecklistItem($checklistId, $id)
    {
        ChecklistItem::where('id', '=', $id)->where('checklist_id', '=', $checklistId)->delete();

        return response()->json([
           'code' => 200,
           'message' => 'berhasil hapus data'
        ]);
    }

    public function RenameChecklistItemDetail()
    {
        return "";
    }

}
