@extends('layouts.app')

@section('title','Profile')

@section('content')

<a href="{{ route('index') }}" id="back" class="btn btn-outline-secondary rounded-pill shadow-sm mb-3" title="back">
    <i class="fa-solid fa-chevron-left"></i> {{ __('Back') }}
</a>

<div class="container p-0">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- profile -->
            <div>
                {{-- <h1 class="fw-bold">{{ $user->name }} 's profile</h1> --}}
                <h1 class="fw-bold text-dark">{{ __(":name 's profile", ['name' => $user->name]) }}</h1>
                <p class="text-muted">{{ __('Registered email address:') }} {{ $user->email }}</p>
            </div>
            
            <!-- Calorie count -->
            <h2 class="fw-bold mt-5">
                <span><i class="fa-solid fa-fire text-secondary text-danger"></i> {{ __('Total calorie based on cooking record') }}</span>
            </h2>
            <div class="row gap-4 my-4 p-1">
                <div class="col bg-white p-3 rounded border border-2 border-primary shadow">
                    <p class="fs-5 fw-bold">{{ __('Today') }}</p>
                    <p class="fs-3 text-dark mt-1">{{ $todayCalories }} <span class="text-muted">kcal</span></p>
                </div>
                <div class="col bg-white p-3 rounded border border-2 border-warning shadow">
                    <p class="fs-5 fw-bold">{{ __('This week') }}</p>
                    <p class="fs-3 text-dark mt-1">{{ $thisWeekCalories }} <span class="text-muted">kcal</span></p>
                </div>
                <div class="col bg-white p-3 rounded border border-2 border-danger shadow">
                    <p class="fs-5 fw-bold">{{ __('This month') }}</p>
                    <p class="fs-3 text-dark mt-1">{{ $thisMonthCalories }} <span class="text-muted">kcal</span></p>
                </div>
            </div>
            

            <!-- Health Data Registration Form -->
            <h2 class="fw-bold mt-5">
                <span><i class="fa-solid fa-file-pen text-primary"></i> {{ __("Record today's health data") }}</span>
            </h2>
            <div class="card shadow-sm border mt-3 mb-5">
                <div class="card-body p-4">
                    <form action="{{ route('profile.store_health') }}" method="POST">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col">
                                <label class="form-label">{{ __('body weight (kg)') }}</label>
                                <input type="number" name="weight" step="0.1" value="{{ $todayRecord->weight ?? '' }}" placeholder="{{ __('e.g.') }} 65.5" class="border rounded p-2 form-control" required>
                                @error('weight')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label class="form-label">{{ __('systolic blood preasure (mmHg)') }}</label>
                                <input type="number" name="systolic_bp" value="{{ $todayRecord->systolic_bp ?? '' }}" placeholder="{{ __('e.g.') }} 120" class="border rounded p-2 form-control" required>
                                @error('systolic_bp')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label class="form-label">{{ __('diastolic blood pressure (mmHg)') }}</label>
                                <input type="number" name="diastolic_bp" value="{{ $todayRecord->diastolic_bp ?? '' }}" placeholder="{{ __('e.g.') }} 80" class="border rounded p-2 form-control" required>
                                @error('diastolic_bp')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary my-1 shadow-sm">
                                    {{ $todayRecord ? __('Update data') : __('Record data') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            

            {{-- Health measurement history --}}
            <h2 class="fw-bold mt-5">
                <span><i class="fa-solid fa-chart-simple text-success"></i> {{ __('Health measurement history (up to 7 record)') }}</span>
            </h2>

            @if($healthRecords->isEmpty())
                <div class="bg-white p-5 rounded shadow text-center text-muted border">
                    {{ __("There is no data yet. Please enter today's health data using the form above!") }}
                </div>
                </div>
            @else
            {{-- Prevention of table layout collapse --}}
            <div class="table-responsive rounded shadow-sm border mt-3">
                <table class="table table-hover align-middle bg-white rounded m-0 text-center">
                    <thead class="table-success">
                        <tr>
                            <th class="p-3">{{ __('Measurement date') }}</th>
                            <th class="p-3">{{ __('Total calorie for the day') }}</th>
                            <th class="p-3">{{ __('Body weight') }}</th>
                            <th class="p-3">{{ __('Blood pressure (Systolic/Diastolic)') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($healthRecords as $record)
                            <tr>
                                <td class="p-3">{{ \Carbon\Carbon::parse($record->recorded_at)->format('Y/m/d') }}</td>
                                <td class="p-3">
                                    @if($record->daily_calories > 0)
                                        <span>{{ $record->daily_calories }}</span> <span>kcal</span>
                                    @else
                                        <span>{{ __('No cooking records') }}</span>
                                    @endif
                                </td>
                                <td class="p-3">{{ $record->weight }} kg</td>
                                <td class="p-3">
                                    <span class="text-danger">{{ $record->systolic_bp }}</span> 
                                    <span>/</span> 
                                    <span class="text-primary">{{ $record->diastolic_bp }}</span> <span>mmHg</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection