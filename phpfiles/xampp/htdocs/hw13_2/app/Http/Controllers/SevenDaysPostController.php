<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Hekmatinasser\Verta\Verta;

class SevenDaysPostController extends Controller
{
    public function show()
    {
        $results = Post::selectRaw('created_at, count(created_at) as count')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('created_at')
            ->orderBy('created_at', 'desc')
            ->take(7)
            ->get();
//        dd($results);

        $label = [];
        $data = [];
//        $wantedResult = [];
        foreach ($results as $result) {
            $dateTime = Carbon::createFromFormat('Y-m-d H:i:s', $result->getOriginal('created_at'));
            $result->created_at = Carbon::createFromDate($dateTime->year, $dateTime->month, $dateTime->day);
            $result->created_at = Verta($result->created_at);

//            var_dump($results);
//            $label .= $result->created_at->format('Y-n-j');
            array_push($label,  $result->created_at->format('Y-n-j'));
            array_push($data,  $result->count);
//            $data .= $result->count;
//            $data = [2, 2, 4];
//            $label = ['name', 'size', 'data'];
//            $wantedResult = Arr::add($wantedResult, $result->created_at->format('Y-n-j'), $result->count);

        }


        return view('chart')->with('label', json_encode($label))->with('data', json_encode($data));
//        var_dump($label);
//        var_dump($data);
    }
}
