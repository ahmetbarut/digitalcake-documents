<!doctype html>
<html lang="en">

<head>
    <title>File Upload</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="main-container" id="page-news-add">

        <div class="main-content">
            <section>
                @if (isset($errors) && $errors->count())
                    <div class="alert alert-warning">{{ $errors->first() }}</div>
                @endif

                @if (Session::get('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif

                <form action="{{ route(config('documents.routes.admin.name') . 'store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white p-4">
                        <div class="form-row">
                            <div class="col-8">
                                <label for="name">file name</label>
                                <input type="text" name="title" id="" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-8">
                                <label for="file">File</label>
                                <input type="file" name="documents" id="" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-8">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="is_public" class="custom-control-input"
                                        id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Mark to public</label>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success">Submit</button>
                    </div>
                </form>
            </section>
        </div>

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>
