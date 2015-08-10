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
                <li class="active"><a href="/contacts/create_contact">Create contact <span
                                class="sr-only">(current)</span></a></li>
                <li><a href="/contacts/import_contacts">Upload contact list</a></li>
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
            <div class="panel-heading">Login</div>
            <div class="panel-body">
                <form method="POST" action="/contacts/create_contact">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                               value="{{ old('name') }}"
                               placeholder="First Name">
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                               value="{{ old('name') }}"
                               placeholder="Last Name">
                    </div>

                    <div id="emails">
                        <button type="button" id="add_email" class="btn btn-danger">Add Email:</button>
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Phone number</label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number">
                    </div>

                    <div id="additional_numbers">
                        <button type="button" id="add_number" class="btn btn-danger">Add phone number:</button>
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
<script>
    var email_counter = parseInt('{{0}}');
    var phone_counter = 0;

    function addEmailCounter() {
        email_counter += 1;
    }

    function addPhoneCounter() {
        phone_counter += 1;
    }

    $("#add_email").click(function () {
        var primary_message = '';
        if (email_counter == 0) {
            primary_message = '<br>Select the email you want to be the primary email for the contact.<br>';
        }

        $("#emails").append(primary_message + "<div class=\"form-group\">" +
                "<label for=\"added_email\">Additional email</label>" +
                '<div class="input-group">' +
                '<span class="input-group-addon">' +
                '<input type="radio" name="primary_email[' + email_counter + ']">' +
                '</span>' +
                '<input type=\"email\" class=\"form-control\" id=\"added_email\" name=\"added_email[' + email_counter + ']\">' +
                '</div><!-- /input-group -->' +
                "</div>");
        addEmailCounter();
    });

    $("#add_number").click(function () {
        $("#additional_numbers").append('<div class="form-group">' +
                '<label for="phone_number">Phone number</label>' +
                '<input type="tel" class="form-control" id="additional_number" name="additional_number[]">' +
                "</div>");
        addPhoneCounter();
    });
</script>
</body>
</html>
