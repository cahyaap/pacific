<div class="table-responsive">
    <table id="user-table">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Role</th>
                <th class="text-center">Action</th>
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
                    @if (Auth::user()->id !== $user->id && !in_array($user->id, $user_used))
                    <a href="#" id="{{ $user->id }}" class="deleteUser" data-toggle="modal" data-target="#deleteUser">Delete</a>
                    @endif
                    <a href="#" id="{{ $user->id }}" class="changePassword" data-toggle="modal" data-target="#changePassword">Password</a>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Role</th>
                <th class="text-center">Action</th>
            </tr>
        </tfoot>
    </table>
</div>