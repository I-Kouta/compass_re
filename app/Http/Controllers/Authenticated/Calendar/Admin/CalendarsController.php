<?php

namespace App\Http\Controllers\Authenticated\Calendar\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\Admin\CalendarView;
use App\Calendars\Admin\CalendarSettingView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show(){ // スクール予約確認のビュー
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.admin.calendar', compact('calendar'));
    }

    public function reserveDetail($user_id = 0, $date, $part){ // 'calendar.admin.detail'
        $reservePersons = ReserveSettings::with('users')->where('setting_reserve', $date)->where('setting_part', $part)->get();
        return view('authenticated.calendar.admin.reserve_detail', compact('reservePersons', 'date', 'part'));
    }

    public function reserveSettings(){ // スクール枠登録のビュー
        $calendar = new CalendarSettingView(time());
        return view('authenticated.calendar.admin.reserve_setting', compact('calendar'));
    }

    public function updateSettings(Request $request){ // 処理のみ。画面なし、reserveSettingsへ
        $reserveDays = $request->input('reserve_day');
        foreach($reserveDays as $day => $parts){
            foreach($parts as $part => $frame){
                ReserveSettings::updateOrCreate([
                    'setting_reserve' => $day,
                    'setting_part' => $part,
                ],[
                    'setting_reserve' => $day,
                    'setting_part' => $part,
                    'limit_users' => $frame,
                ]);
            }
        }
        return redirect()->route('calendar.admin.setting', ['user_id' => Auth::id()]);
    }
}
