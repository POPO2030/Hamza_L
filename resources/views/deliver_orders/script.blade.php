
<script src="{{asset('datatables_js/jquery.min.js')}}"></script>
<script src="{{asset('datatables_js/jquery.dataTables.min.js')}}"></script>


<script>
    $(document).ready(function () {
        $('#table1').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('final_deliver_orders') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'final_deliver_order_id', name: 'final_deliver_order_id' },
                { data: 'get_deliver_order.work_order_id', name: 'get_deliver_order.work_order_id' },
                { data: 'get_deliver_order.receipt_id', name: 'get_deliver_order.receipt_id' },
                { data: 'get_deliver_order.get_customer.name', name: 'get_deliver_order.get_customer.name' },
                { data: 'get_deliver_order.get_products.name', name: 'get_deliver_order.get_products.name' },
                { 
                data: 'created_at', 
                name: 'created_at',
                render: function(data) {
                    var date = new Date(data);
                    var formattedDate = date.getFullYear() + '-' 
                                      + ('0' + (date.getMonth() + 1)).slice(-2) + '-' 
                                      + ('0' + date.getDate()).slice(-2) + ' ' 
                                      + ('0' + date.getHours()).slice(-2) + ':' 
                                      + ('0' + date.getMinutes()).slice(-2) + ':' 
                                      + ('0' + date.getSeconds()).slice(-2);
                    return formattedDate;
                }
            },
                { data: 'action', name: 'action', orderable: false, searchable: false },
                
            ],
            order: [[1, 'desc']] // Sort by the second column (final_deliver_order_id) in descending order
        });
    });
</script>

