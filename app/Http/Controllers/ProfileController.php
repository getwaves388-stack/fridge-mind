<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\HealthRecord;

class ProfileController extends Controller
{
    public function show()
    {
        $user = User::find(Auth::id());
        if (!$user) { return redirect()->route('login'); }

        $now = Carbon::now();
        
        // 1. Total calories for today
        $todayCalories = $user->recipes()
            ->whereDate('created_at', Carbon::today())
            ->sum('calories');

        // 2. Total calories for this week (Monday〜today)
        $thisWeekCalories = $user->recipes()
            ->whereBetween('created_at', [$now->startOfWeek()->format('Y-m-d 00:00:00'), Carbon::now()->format('Y-m-d 23:59:59')])
            ->sum('calories');

        // 1. Total calories for month (The 1st〜today)
        $thisMonthCalories = $user->recipes()
            ->whereBetween('created_at', [$now->startOfMonth()->format('Y-m-d 00:00:00'), Carbon::now()->format('Y-m-d 23:59:59')])
            ->sum('calories');

        // Retrieve today's health date    
        $todayRecord = $user->healthRecords()->where('recorded_at', Carbon::today())->first();

        // Retrieve the latest 7 health data
        $healthRecords = $user->healthRecords()
            ->orderBy('recorded_at', 'desc')
            ->take(7)
            ->get();


        // Conbine the total calories
        $healthRecords->map(function ($record) use ($user) {
            // recorded_at
            $dayCalories = $user->recipes()
                ->whereDate('created_at', $record->recorded_at)
                ->sum('calories');

            // Add (daily_calories) to the health data object
            $record->daily_calories = $dayCalories;
            return $record;
        });

        
        return view('profile.show', compact(
            'user',
            'todayCalories',
            'thisWeekCalories',
            'thisMonthCalories',
            'todayRecord',
            'healthRecords'
        ));
    }

    public function storeHealth(Request $request)
    {
        $request->validate([
            'weight' => 'required|numeric|min:0|max:300',  
            'systolic_bp' => 'required|integer|min:0|max:300',   
            'diastolic_bp' => 'required|integer|min:0|max:300',  
        ]);

        $userId = Auth::id();
        $today = Carbon::today()->toDateString();

        // Overwrite or create new
        HealthRecord::updateOrCreate(
            [
                'user_id' => $userId,
                'recorded_at' => $today,
            ],
            [
                'weight' => $request->weight,
                'systolic_bp' => $request->systolic_bp,
                'diastolic_bp' => $request->diastolic_bp,
            ]
        );

        return redirect()->route('profile.show');
    }
}
