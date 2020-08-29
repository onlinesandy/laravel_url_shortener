<!DOCTYPE html>
<html dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <title>{{ config('app.name', 'URL Shortener') }}</title>
        <!-- Custom CSS -->
        <!--<link href="{{asset('css/style.min.css')}}" rel="stylesheet">-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">


    </head>

    <body>
        <div class="container">
            <h2>Shorten URL</h2>
            <div style="height: 50px;">
                <div class="alert alert-success s_msg_div" style="display: none;">

                </div>
                <div class="alert alert-warning e_msg_div" style="display: none;">

                </div>
            </div>
            <form action="#" method="post" id="urlForm">
                @csrf
                <div class="form-group">
                    <label for="url">URL:</label>
                    <input type="url" value="{{ old('url') }}" class="form-control" name="url" required="required" id="url" placeholder="Enter URL to be shorten" name="url">

                </div>
                <button type="submit" class="btn btn-primary">Shorten</button>
            </form>
            <hr/>
            <table id='urlTable' width='100%' border="1" style='border-collapse: collapse;'>
                <thead>
                    <tr>
                        <td>S.no</td>
                        <td>Original Link</td>
                        <td>Short Link</td>
                        <td>Created At</td>
                    </tr>
                </thead>
            </table>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    </body>
    <script>
$(document).ready(function () {

    // DataTable
    var urlDataTable = $('#urlTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{route('getUrls')}}",
        columns: [
            {data: 'id'},
            {data: 'original_link'},
            {data: 'short_link'},
            {data: 'created_dt'},
        ]
    });

    $(document).on("submit", '#urlForm', function (e) {
        e.preventDefault();
        var url = $('#url').val();
        if (url == '') {
            alert('Please Enter URL');
        }
        var formData = {
            'url': url,
        };

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('#urlForm > input[name="_token"]').val()},
            url: "{{route('shorten')}}",
            type: "post",
            data: formData,
            success: function (res) {
                var d = JSON.parse(res);
                if (d.status == '1') {
                    $('.s_msg_div').text('URL Shorten successfully');
                    $('.s_msg_div').show();
                    $('#url').val('');
                    urlDataTable.ajax.reload();

                } else {
                    $('.e_msg_div').text('Something Went Wrong');
                    $('.e_msg_div').show();
                }

                $('.s_msg_div').hide(500);
                $('.e_msg_div').hide(500);

            }
        });
    });

});
    </script>
</html>