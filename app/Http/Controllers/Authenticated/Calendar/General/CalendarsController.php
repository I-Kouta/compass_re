<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show(){ // スクール予約のビュー'calendar.general.show'
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){ // 予約完了時の操作'reserveParts'
        DB::beginTransaction();
        try{
            $getDate = $request->getData; // 20xx-xx-xx,年月日
            $getPart = $request->getPart; // 1,2,3部
            // ↓[20xx-xx-xx]=>1,みたいに連想配列を返す
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                // dd($reserve_settings); // setting_reserve,setting_part,limit_usersが配列
                $reserve_settings->decrement('limit_users'); // limit_usersカラムの値を1つ減らす
                $reserve_settings->users()->attach(Auth::id()); // 中間テーブルに保存する記述
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    public function delete(Request $request){
        // dd($request); // 値を減らすメソッドはincrement
        DB::beginTransaction();
        try{
            $getDate = $request->cancel_reserve;
            $getPart = $request->cancel_part;
            $reserve_settings = ReserveSettings::where('setting_reserve', $getDate)->where('setting_part', $getPart)->first();
            // dd($reserve_settings);
            $reserve_settings->increment('limit_users');
            $reserve_settings->users()->detach(Auth::id()); // 中間テーブルに保存する記述
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
}
