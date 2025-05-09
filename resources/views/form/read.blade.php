<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css">


</head>

<body>
    <div class="container mt-4">
        <a href="{{ route('create') }}" class="bg-black"><button class="btn btn-primary">Create Form</button></a>
        <table id="users-table" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="itemList">

            </tbody>
        </table>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
    <script src="backend/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('read.data') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]

            });
        });

        //  Edit button click handler
        $('#users-table').on('click', '.edit-button', function() {
            var id = $(this).data('id');
            window.location = '/form-edit/' + id;
        });


        function deleteItem(id) {
            const url = '{{ route('delete.data', ':id') }}'.replace(':id', id);
            let csrfToken = '{{ csrf_token() }}';
            if (confirm('Are you sure you want to delete this data?')) {
                axios.delete(url, {
                        header: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(function(response) {
                        console.log(response.data);
                        $('#users-table').DataTable().ajax.reload();
                        alert('Data deleted successfully!');
                    })
                    .catch(function(error) {
                        console.error(error);
                        alert('Error deleting data.');
                    });
            }
        }
    </script>

</body>

</html>
