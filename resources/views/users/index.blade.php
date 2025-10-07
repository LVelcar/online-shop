@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        <h1>List of Users</h1>

        @empty( $users )
            <div class="alert alert-danger" role="alert">
                The list of users is empty.
            </div>
        @else
            <div class="table-responsive mt-2">
                <table class="table table-striped">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Admin Since</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                {{ optional($user->admin_since)->diffForHumans() ?? 'Never' }}
                            </td>


                            <td class="d-flex justify-content-around">
                                <form class="d-inline m-1" action="{{ route('users.admin.toggle', ['user' => $user->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm px-3">
                                        {{ $user->isAdmin() ? 'Remove' : 'Make' }}
                                        Admin
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endempty
    </div>
@endsection