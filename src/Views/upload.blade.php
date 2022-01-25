    <div class="main-container" id="page-news-add">

        <div class="main-content">
            <section>
                <div class="page-header">
                    <h1>{{ trans('news::admin.news_add_page_title') }}</h1>
                    <p class="lead"> {{ trans('news::admin.news_add_page_description') }}</p>
                </div>

                @if (isset($errors) && $errors->count())
                    <div class="alert alert-warning">{{ $errors->first() }}</div>
                @endif

                @if (Session::get('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif

                <form action="{{ route(config('documents.routes.admin.name') . 'store') }}" method="POST" enctype="multipart/form-data">
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
                                    <input type="checkbox" name="is_public" class="custom-control-input" id="customCheck1">
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
@endsection
