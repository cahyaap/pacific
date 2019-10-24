<div id="addDemand" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Request</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body add-demand">
                <form id="add-demand">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select id="item" name="item" class="form-control" required="required">
                                    <option value="">-- Choose request --</option>
                                    @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name." - ".$item->desc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" id="price" name="price" class="form-control" required="required" placeholder="Price per unit" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" id="quantity" name="quantity" class="form-control" required="required" placeholder="Quantity" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="ppn" name="ppn" class="form-control" required="required">
                                    <option value="">-- Choose ppn --</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <span style="font-style: italic; color: blue;" id="ppnValue"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="materai" name="materai" class="form-control" required="required">
                                    <option value="">-- Choose materai --</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <span style="font-style: italic; color: blue;" id="materaiValue"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="number" id="total" name="total" class="form-control" placeholder="Total" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea rows="4" id="note" name="note" class="form-control" required="required" placeholder="Note"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <p style="font-style: italic; color: red;">
                                    *) Notes<br>
                                    <strong>Price</strong> and <strong>quantity</strong> are number only<br>
                                    Example: 1000, 15000, 500000, 2000000, etc
                                </p>
                            </div>
                        </div>
                    </div>
                    <div style="padding-right: 0;padding-left: 0;" class="modal-footer add-demand">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                        <button type="submit" value="submit" class="btn btn-success waves-effect waves-light submit-demand">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="editDemand" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Request</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body edit-demand">
                <form id="edit-demand">
                    <div class="row">
                        <div class="col-md-12">

                        </div>
                    </div>
                    <div style="padding-right: 0;padding-left: 0;" class="modal-footer edit-demand">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                        <button type="submit" value="submit" class="btn btn-success waves-effect waves-light submit-edit-demand">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteDemand" tabindex="-1" role="dialog" aria-labelledby="addOrder" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Request Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body delete-demand">
                <h4>Are you sure to delete this request data?</h4>
                <small style="color: red">All the request data will be deleted too</small>
            </div>
            <div class="modal-footer delete-demand">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" id="delete-demand">Delete</button>
            </div>
        </div>
    </div>
</div>

<div id="addDemandItem" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body add-item">
                <form id="add-item">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" id="itemname" name="itemname" class="form-control" required="required" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <textarea rows="4" id="itemdesc" name="itemdesc" class="form-control" required="required" placeholder="Description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div style="padding-right: 0;padding-left: 0;" class="modal-footer add-item">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                        <button type="submit" value="submit" class="btn btn-success waves-effect waves-light submit-item">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="editItem" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body edit-item">
                <form id="edit-item">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="itemId" class="form-control">
                            <div class="form-group">
                                <input type="text" id="edititemname" name="edititemname" class="form-control" required="required" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <textarea rows="4" id="edititemdesc" name="edititemdesc" class="form-control" required="required" placeholder="Description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div style="padding-right: 0;padding-left: 0;" class="modal-footer edit-item">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                        <button type="submit" value="submit" class="btn btn-success waves-effect waves-light submit-edit-item">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteItem" tabindex="-1" role="dialog" aria-labelledby="addOrder" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Item Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body delete-item">
                <h4>Are you sure to delete this item data?</h4>
                <small style="color: red">All the item data will be deleted too</small>
            </div>
            <div class="modal-footer delete-item">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" id="delete-item">Delete</button>
            </div>
        </div>
    </div>
</div>