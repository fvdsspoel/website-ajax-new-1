<div id="sizeprice-modal" class="modal fade" role="dialog">
  @csrf
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header"  style="background-color: #cca84a; color: white;">
                <h4 style="color: white; "><center>List of Size Prices</center></h4>
                <button type="button" class="close" data-dismiss="modal">
                    &times;</button>
            </div>
            <div class="modal-body">
              <div class="col-md-12">
                <table class="table text-center table-bordered">
                  <tr>
                    <th>Size</th>
                    <th>Price</th>
                  </tr>
                  <tbody id="price-tboday"></tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">
                    Close
              </button>
            </div>
        </div>
    </div>
</div>