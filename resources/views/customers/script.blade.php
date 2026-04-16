
<script src="{{asset('datatables_js/jquery.min.js')}}"></script>
<script src="{{asset('datatables_js/jquery.dataTables.min.js')}}"></script>




<script>
    
 $(document).ready(function () {
    var id = {{ request()->route('id') }};  // Added missing semicolon
    
    $('#table1').DataTable({
        processing: true,
        serverSide: true,
        ajax: `{{ URL('get_receive_receipt/${id}') }}`,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id', name: 'id'},
            { 
                data: null, 
                name: 'get_product.name',
                render: function (data, type, row) {
                    let productName = row.get_product && row.get_product.name ? row.get_product.name : '';
                    let productType = row.product_type ? row.product_type : '';

                    if (productName && productType) {
                        return productName + ' (' + productType + ')';
                    } else if (productName) {
                        return productName;
                    } else if (productType) {
                        return productType;
                    } else {
                        return 'N/A';
                    }
                }
            },
            {data: 'model', name: 'model'},
            {data: 'initial_count', name: 'initial_count'},
            {data: 'final_weight', name: 'final_weight'},
            {data: 'final_count', name: 'final_count'},
            { 
                data: 'created_at', 
                name: 'created_at', 
                render: function(data) {
                    var date = new Date(data);
                    // Fixed date formatting with leading zeros
                    return date.getFullYear() + '-' + 
                        String(date.getMonth() + 1).padStart(2, '0') + '-' + 
                        String(date.getDate()).padStart(2, '0') + ' ' + 
                        String(date.getHours()).padStart(2, '0') + ':' + 
                        String(date.getMinutes()).padStart(2, '0') + ':' + 
                        String(date.getSeconds()).padStart(2, '0');
                }
            },
            // { 
            //     data: 'branch', 
            //     name: 'branch',
            //     render: function(data) {
            //         // Added branch display logic
            //         if (data == 1) {
            //             return 'جسر السويس';
            //         } else if (data == 2) {
            //             return 'بلقس';
            //         }
            //         return data; // Fallback for other values
            //     }
            // },
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: [[1, 'desc']]
    });
});
    
</script>