<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>

    <script src="{{ elixir("js/vendor.js") }}"></script>
    <script src="{{ elixir("js/app.js") }}"></script>

    <link rel="stylesheet" href="{{ elixir("css/app.css") }}">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Contacts User</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/">Edit contacts</a></li>
                <li><a href="/contacts/create_contact">Create contact </a></li>
                <li class="active"><a href="/contacts/import_contacts">Upload contact list<span
                                class="sr-only">(current)</span></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/auth/logout">Logout</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<div class="row">
    <div class="col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">Upload file to import contacts</div>
            <div class="panel-body">
                {!! Form::open(array(
                                'url' => 'contacts/import_contacts',
                                'method' => 'post',
                                'class' => 'form',
                                'novalidate' => 'novalidate',
                                'files' => true)) !!}
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="imported_contacts">File input</label>
                        {!! Form::file('imported_contacts', null) !!}

                        <p class="help-block">Only XLS, XLSX, CSV and TSV file types are supported.</p>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                {!! Form::close() !!}

                @if(!is_null($creation_data))
                    @if(!$creation_data->success)
                        <div class="alert alert-danger" role="alert">Error: <br>
                            @if(is_array($creation_data->errors))
                                @foreach($creation_data->errors as $error)
                                    {{$error}}<br>
                                @endforeach
                            @endif
                            {{$creation_data->extra_info}}
                        </div>
                    @else
                        <div class="alert alert-success" role="alert">Success! <br>{{$creation_data->extra_info}}</div>
                    @endif
                @endif

            </div>
        </div>
    </div>
</div>
</body>
</html>
