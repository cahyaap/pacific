<div id="addUser" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body add-user">
                <form id="add-user">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" id="name" name="name" class="form-control" required="required" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input type="email" id="email" name="email" class="form-control" required="required" placeholder="Email">
                                <span class="input-error-text" id="email-error">Email already exist</span>
                            </div>
                            <div class="form-group">
                                <select id="role" name="role" class="form-control" required="required">
                                    <option value="">-- Choose role --</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="password" id="password" name="password" class="form-control" required="required" placeholder="Password">
                            </div>
                        </div>
                    </div>
                    <div style="padding-right: 0;padding-left: 0;" class="modal-footer add-user">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                        <button type="submit" value="submit" class="btn btn-success waves-effect waves-light submit-user">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="editUser" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body edit-user">
                <form id="edit-user">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="userId" name="userId" class="form-control" required="required" placeholder="User ID">
                            <div class="form-group">
                                <input type="text" id="editname" name="editname" class="form-control" required="required" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input type="email" id="editemail" name="editemail" class="form-control" required="required" placeholder="Email">
                                <span class="input-error-text" id="edit-email-error">Email already exist</span>
                            </div>
                            <div class="form-group">
                                <select id="editrole" name="editrole" class="form-control" required="required">
                                    <option value="">-- Choose role --</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div style="padding-right: 0;padding-left: 0;" class="modal-footer edit-user">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                        <button type="submit" value="submit" class="btn btn-success waves-effect waves-light submit-edit-user">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="changePassword" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body change-password">
                <form id="change-password">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="userIdChangePassword" name="userId" class="form-control" required="required" placeholder="User ID">
                            <div class="form-group">
                                <input type="email" id="changepassemail" name="changepassemail" class="form-control" required="required" placeholder="Email" readonly>
                            </div>
                            <div class="form-group">
                                <input type="password" id="editpassword" name="editpassword" class="form-control" required="required" placeholder="New Password">
                            </div>
                        </div>
                    </div>
                    <div style="padding-right: 0;padding-left: 0;" class="modal-footer change-password">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                        <button type="submit" value="submit" class="btn btn-success waves-effect waves-light submit-change-password">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="addOrder" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete User Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body delete-user">
                <h4>Are you sure to delete this user data?</h4>
                <small style="color: red">All the user data will be deleted too</small>
            </div>
            <div class="modal-footer delete-user">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" id="delete-user">Delete</button>
            </div>
        </div>
    </div>
</div>