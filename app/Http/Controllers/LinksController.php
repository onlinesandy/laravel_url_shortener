<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use URL;
use App\Link;

class LinksController extends Controller {

    public function index() {
        return view('url_shortener');
    }

    public function shorten(Request $request) { // Generate Short link
        $randomStr = Str::random(5);
        $c_domain = URL::to('/');
        $shorten_link = $c_domain . '/' . $randomStr;
        $validatedData = $request->validate(
                ['url' => 'required|url'], ['url.required' => 'URL is  Required', 'url.url' => 'Please enter Valid URL']
        );
        $Data = [
            'original_link' => $request->url,
            'short_link' => $shorten_link
        ];
        $res = Link::create($Data); // Save in Database
        if (isset($res->id) && $res->id > 0) {
            return json_encode(array('status' => 1));
        } else {
            return json_encode(array('status' => 0));
        }
    }

    public function fetchUrl($link) { // Check link from Link Table
        $c_domain = URL::to('/');
        $shorten_link = $c_domain . '/' . $link;

        $linkArr = Link::where('short_link', 'like', $shorten_link)
                ->first();
        if (isset($linkArr->id) && $linkArr->id > 0) {
            return redirect($linkArr->original_link);
        } else {
            return abort(404);
        }
    }

    public function getUrls(Request $request) { // Get Records from Link Table

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        // Total records
        $totalRecords = Link::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Link::select('count(*) as allcount')
                ->where(function ($query) use($searchValue) {
                    $query->where('links.original_link', 'like', '%' . $searchValue . '%')
                    ->orWhere('links.short_link', 'like', '%' . $searchValue . '%');
                })
                ->count();

        // Fetch records
        $records = Link::orderBy($columnName, $columnSortOrder)
                ->where(function ($query) use($searchValue) {
                    $query->where('links.original_link', 'like', '%' . $searchValue . '%')
                    ->orWhere('links.short_link', 'like', '%' . $searchValue . '%');
                })
                ->select('links.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();

        $data_arr = array();
        $sno = $start + 1;
        foreach ($records as $record) {
            $id = $sno;
            $original_link = $record->original_link;
            $short_link = $record->short_link;
            $created_at = date('d-m-Y H:i:s', strtotime($record->created_at));

            $data_arr[] = array(
                "id" => $id,
                "original_link" => $original_link,
                "short_link" => '<a href="' . $short_link . '" target="_blank">' . $short_link . '<a/>',
                "created_dt" => $created_at
            );
            $sno++;
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }

}
