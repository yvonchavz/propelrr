<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ajax Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
</head>

<body>
    <div class="container">
        <div class="row" style="margin-top: 45px">
            <div class="col-md-6">
                <form id="profile-form" action="action.php?action=create" method="post">
                    <div class="mb-3">
                        <label for="name">Full name:</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter name">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="email">Email Address:</label>
                        <input type="text" class="form-control" name="email" placeholder="Enter email address">
                        <span class="text-danger error-text email_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="mobile_number">Mobile Number:</label>
                        <input type="text" class="form-control" name="mobile_number" placeholder="Enter mobile number">
                        <span class="text-danger error-text mobile_number_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="bday">Date of Birth:</label>
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" id="bday" name="bday" class="form-control">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                        <span class="text-danger error-text bday_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="age">Age:</label>
                        <input type="number" class="form-control" name="age" placeholder="Enter age">
                        <span class="text-danger error-text age_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="gender">Gender:</label>
                        <select name="gender" class="form-select" aria-label="Default select example">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <span class="text-danger error-text gender_error"></span>
                    </div>
                    <div class="mb-3 float-end">
                        <button type="submit" class="btn btn-success" id="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(function() {

            $("#bday").change(function() {
                var today = new Date(),
                    dob = new Date($("#bday").val().trim()),
                    age = new Date(today - dob).getFullYear() - 1970;

                    $('input[name="age"]').val(age); // Changed it to `val()` as it is the textbox.
            });

            //ADD NEW PROFILE
            $('#profile-form').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.code == 0) {
                            $.each(data.error, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            $(form)[0].reset();
                            alert('Profile added successfully!');
                        }
                    }
                });
            });

        });
    </script>

</body>

</html>