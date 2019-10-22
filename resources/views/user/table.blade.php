<div class="table-responsive">
    <table id="user-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($users as $user)
            <tr>
                <td class="text-center">{{ $i++ }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user['role']->role }}</td>
                <td class="text-center">
                    <a href="#" id="{{ $user->id }}" class="editUser" data-toggle="modal" data-target="#editUser">Edit</a>
                    @if (Auth::user()->id !== $user->id)
                    <a href="#" id="{{ $user->id }}" class="deleteUser" data-toggle="modal" data-target="#deleteUser">Hapus</a>
                    @endif
                    <a href="#" id="{{ $user->id }}" class="changePassword" data-toggle="modal" data-target="#changePassword">Password</a>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>