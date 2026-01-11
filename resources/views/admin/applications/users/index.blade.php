@extends('layouts.admin')
@section('title', 'Access Control / Users')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="gh-box mb-4">
                <div class="gh-box-header">Invite User</div>
                <div class="gh-box-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="fw-bold small">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="fw-bold small">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="fw-bold small">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small">Role</label>
                            <select name="role" class="form-select">
                                <option value="operator">Operator</option>
                                <option value="kadis">Kepala Dinas</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-sm">Add user to organization</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="gh-box">
                <div class="gh-box-header">Members</div>
                <table class="table mb-0 align-middle">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3">Name</th>
                            <th>Role</th>
                            <th class="text-end pe-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle" style="width: 24px; height: 24px; font-size: 10px;">
                                            {{ substr($u->name, 0, 1) }}</div>
                                        <div>
                                            <div class="fw-bold small">{{ $u->name }}</div>
                                            <div class="text-muted" style="font-size: 11px;">{{ $u->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge border fw-normal text-muted"
                                        style="background: #f6f8fa;">{{ $u->role }}</span>
                                </td>
                                <td class="text-end pe-3">
                                    @if (auth()->id() != $u->id)
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST"
                                            onsubmit="return confirm('Remove user?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm text-danger small">Remove</button>
                                        </form>
                                    @else
                                        <span class="text-muted small italic">It's you</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
