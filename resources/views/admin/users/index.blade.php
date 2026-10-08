@extends('layouts.app')

@section('title','Admin: Users')

@section('content')

    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="small table-secondary text-secondary">
            <tr>
                <th></th>
                <th>STATUS</th>
                <th>ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>CREATED AT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_users as $user)
                <tr>
                    <td>
                        @if (Auth::user()->id !== $user->id)
                            <div class="dropdown">
                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>

                                <div class="dropdown-menu">
                                    @if ($user->trashed())
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#activate-user-{{ $user->id }}">
                                        <i class="fa-solid fa-user-check"></i>&nbsp;Activate&nbsp;{{ $user->name }}
                                        </button>
                                    @else
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user-{{ $user->id }}">
                                        <i class="fa-solid fa-user-slash"></i>&nbsp;Deactivate&nbsp;{{ $user->name }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                            {{-- Include the modal here --}}
                            @include('admin.users.modal.status')
                        @endif
                    </td>
                    <td>
                        @if ($user->trashed())
                            {{-- This condition returns TRUE if the user was soft deleted. --}}
                            <i class="fa-regular fa-circle text-secondary"></i>&nbsp;Inactive
                        @else
                            <i class="fa-solid fa-circle text-success"></i>&nbsp;Active
                        @endif
                    </td>
                    <td>{{ $user->id }}</td>
                    <td>
                        <a href="#" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('Y/m/d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $all_users->links() }}
@endsection