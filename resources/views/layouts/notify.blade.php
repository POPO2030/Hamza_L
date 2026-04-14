@if(session()->has('success'))
    <script>
        swal.fire({
            position: "top-end",
            icon: "success",
            title: "{{session()->get('success')}}",
            showConfirmButton: false,
            timer: 2000
        })
    </script>
{{\Illuminate\Support\Facades\Session::forget(['success'])}}
@endif

@if(session()->has('error'))
    <script>
        swal.fire({
            position: "top-end",
            icon: "error",
            title: "{{session()->get('error')}}",
            showConfirmButton: false,
            timer: 4000
        })
    </script>
    {{\Illuminate\Support\Facades\Session::forget(['error'])}}
@endif


@if($errors->count() > 0)

    <script>
        swal.fire({
            position: "top-end",
            icon: "error",
            title: "{{ implode('\n', $errors->all()) }}",
            showConfirmButton: false,
            timer: 4000
        })
    </script>
@endif


