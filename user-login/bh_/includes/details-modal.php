<style>

table, td, th {
    text-align: center;
}
.bold {
    font-weight: 700;
}
.txt-center {
    text-align: center;
}
.payment {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 0 20px; 
    width: 100%;
}

.payment__details {
    display: flex;
    justify-content: space-between;
    width: 80%;
}

.payment__details-item {
    text-align: left;
}

</style>

<!-- Modal -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title txt-center" >Payment Details</h4>
            </div>



            <div class="modal-body"></div>

            <div class="modal-footer txt-center">
                <button type="button" class="btn btn-success">Approve</button>
                <button type="button" class="btn btn-danger">Cancel</button>
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End Modal -->