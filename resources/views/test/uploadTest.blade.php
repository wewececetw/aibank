<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js">
    </script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />

    <title>本息攤還</title>
</head>

<body>
    <form action="{{ url('test/uploadTest') }}" method="post" enctype="multipart/form-data" id="consent_form">

        @csrf
        <!-- 身分證正面/護照影本• • • • -->
        <div class="row m_t_3">
            <div class="column">
                <h3>
                    身分證影本
                    <span class="red-span">*</span>
                </h3>

                <div>
                    <img class="ui fluid image" id="preview-new-cert1" src="#" alt="" hidden>
                </div>
                <input style="width:100%" class="m_t_2" name="certificate_image" data-type="cert1"
                    onchange="readURL(this)" type="file">
            </div>
        </div>
        <div class="form-group">
            <input type="text" name="mytext">
        </div>

        <button type="submit">送出</button>
    </form>


    <script type="text/javascript">
        //預覽
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview-new-' + $(input).data('type')).attr('src', e.target.result);
                    $('#preview-new-' + $(input).data('type')).show();
                    $('#preview-new-' + $(input).data('type')).attr('hidden', false);
                    $('#preview-' + $(input).data('type')).hide();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>

</body>

</html>
