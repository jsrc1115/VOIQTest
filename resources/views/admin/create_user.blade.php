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
            <a class="navbar-brand" href="#">Admin User</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/">Edit users</a></li>
                <li class="active"><a href="/admin/create_user">Create user <span class="sr-only">(current)</span></a></li>
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
            <div class="panel-heading">Create User</div>
            <div class="panel-body">
                <form method="POST" action="/admin/create_user">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                               placeholder="Name">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                               placeholder="Email">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <div class="form-group">
                        <label for="password">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation">
                    </div>

                    <div>
                        <button type="submit" class="btn btn-success">Create</button>
                    </div>
                </form>

                @if(!is_null($creation_data))
                    @if(!$creation_data->success)
                        <div class="alert alert-danger" role="alert">Error: <br>
                            @foreach($creation_data->errors as $error)
                                {{$error}}<br>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-success" role="alert">Success!</div>
                    @endif
                @endif

            </div>
        </div>
    </div>
</div>
</body>
</html>
