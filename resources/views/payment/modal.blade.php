<div class="modal fade" id="detailPayment" tabindex="-1" role="dialog" aria-labelledby="addOrder" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body detail-payment">
                <div class="row">
                    <div class="col-md-8">
                        <table>
                            <tr>
                                <td>Status</td>
                                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td><span id="statusDetail"></span></td>
                            </tr>
                            <tr>
                                <td>Requested By</td>
                                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td><span id="requestBy"></span></td>
                            </tr>
                            <tr>
                                <td>Request Date</td>
                                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td><span id="requestDate"></span></td>
                            </tr>
                            <tr>
                                <td>Notes</td>
                                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td><span id="requestNotes"></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('printPayment') }}" target="_blank" class="btn btn-success" id="printBtn" style="display: none;">Print</a>
                    </div>
                </div>
                <br>
                <table id="detail-payment-table">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Item</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody id="detail-payment-body">

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-center">Materai</th>
                            <th class="text-right" id="materaiDetail"></th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-center">PPN</th>
                            <th class="text-right" id="ppnDetail"></th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-center">Total</th>
                            <th class="text-right" id="totalDetail"></th>
                        </tr>
                    </tfoot>
                </table>
                <br>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="approvePayment" tabindex="-1" role="dialog" aria-labelledby="addOrder" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <h4>Are you sure to approve this payment data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success waves-effect waves-light" id="approve-payment">Approve</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectPayment" tabindex="-1" role="dialog" aria-labelledby="addOrder" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <h4>Are you sure to reject this payment data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" id="reject-payment">Reject</button>
            </div>
        </div>
    </div>
</div>