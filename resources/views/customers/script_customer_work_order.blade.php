{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}

<script src="{{asset('datatables_js/jquery.min.js')}}"></script>
<script src="{{asset('datatables_js/jquery.dataTables.min.js')}}"></script>
<script>
    
    $(document).ready(function () {
        var id = {{ request()->route('receiveReceipt_id') }}
        var customer_id = {{request()->route('customer_id')}}
        $('#table2').DataTable({
        processing: true,
        serverSide: true,
        ajax: `{{ URL('get_work_order/${id}/${customer_id}') }}`,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id', name: 'id'},
            {data: 'product_details', name: 'product_details'},
            {data: 'initial_product_count', name: 'initial_product_count'},
            {data: 'product_count', name: 'product_count'},
            {data: 'product_weight', name: 'product_weight'},
            {data: 'created_at', name: 'created_at', render: function(data) {
    var date = new Date(data);
    return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' ' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
}},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: [[1, 'desc']] // Sort by the second column (id) in descending order
    });
    
    });

    
</script>