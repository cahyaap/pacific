<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<body>
    @include('layouts.navbar')
    <div class="py-4 container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">User</div>

                    <div class="card-body">
                        <a class="btn btn-block btn-success" href="#" data-toggle="modal" data-target="#addUser">Add New User</a><br>
                        <div class="text-center" id="load-table" style="margin: 10px 0;">
                            <span><img src="{{ asset('loading.gif') }}" height="50px">
                                <p>Loading data, please wait...</p>
                            </span>
                        </div>
                        <div id="user-table-container">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('user.modal', ['roles' => $roles])
    @include('layouts.footer')
</body>
@include('layouts.script')
<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    function getUser(div) {
        $.ajax({
            url: "{{ route('getUserTable') }}",
            data: {
                send: true
            },
            beforeSend: function() {
                $('#load-table').show();
                $(div).hide();
            },
            success: function(data) {
                $(div).html(data);
                $('#load-table').hide();
                $(div + ' table').DataTable();
                $(div).show();
            }
        });
    }

    $(document).ready(function() {
        getUser('#user-table-container');

        $('#email').change(function() {
            $.ajax({
                url: "{{ route('emailChecking') }}",
                data: {
                    send: true,
                    email: $(this).val()
                },
                success: function(data) {
                    $('#email-error').hide();
                    $('.submit-user').removeAttr('disabled');
                    if (data.userExist === true) {
                        $('#email-error').show();
                        $('.submit-user').attr('disabled', 'disabled');
                    }
                }
            });
        });

        $('#editemail').change(function() {
            $.ajax({
                url: "{{ route('emailChecking') }}",
                data: {
                    send: true,
                    email: $(this).val()
                },
                success: function(data) {
                    $('#edit-email-error').hide();
                    $('.submit-edit-user').removeAttr('disabled');
                    if (data.userExist === true && data.data[0].email !== defaultEmail) {
                        $('#edit-email-error').show();
                        $('.submit-edit-user').attr('disabled', 'disabled');
                    }
                }
            });
        });

        $('#add-user').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('createUser') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    _token: CSRF_TOKEN,
                    name: $('#name').val(),
                    email: $('#email').val(),
                    roleId: $('#role').val(),
                    password: $('#password').val()
                },
                success: function(data) {
                    getUser('#user-table-container');
                    $('.close').click();
                }
            });
        });

        var defaultEmail = "";
        $(document).on('click', '.editUser', function() {
            $.ajax({
                url: "{{ route('getUserData') }}",
                data: {
                    send: true,
                    id: $(this).attr('id')
                },
                success: function(data) {
                    defaultEmail = data.data.email;
                    $('#userId').val(data.data.id);
                    $('#editname').val(data.data.name);
                    $('#editemail').val(data.data.email);
                    $('#editrole').val(data.data.role_id);
                }
            });
        });

        $('#edit-user').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('editUser') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    _token: CSRF_TOKEN,
                    name: $('#editname').val(),
                    email: $('#editemail').val(),
                    roleId: $('#editrole').val(),
                    id: $('#userId').val()
                },
                success: function(data) {
                    getUser('#user-table-container');
                    $('.close').click();
                }
            });
        });

        var id;

        $(document).on('click', '.deleteUser', function() {
            id = $(this).attr('id');
        });

        $(document).on('click', '#delete-user', function() {
            $.ajax({
                url: "{{ route('deleteUser') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    getUser('#user-table-container');
                    $('.close').click();
                }
            });
        });

        $(document).on('click', '.changePassword', function() {
            $.ajax({
                url: "{{ route('getUserData') }}",
                data: {
                    send: true,
                    id: $(this).attr('id')
                },
                success: function(data) {
                    $('#userIdChangePassword').val(data.data.id);
                    $('#changepassemail').val(data.data.email);
                }
            });
        });

        $('#change-password').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('changePassword') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    _token: CSRF_TOKEN,
                    password: $('#editpassword').val(),
                    id: $('#userIdChangePassword').val()
                },
                success: function(data) {
                    getUser('#user-table-container');
                    $('.close').click();
                }
            });
        });

    });
</script>

</html>