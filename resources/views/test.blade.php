<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">


    </head>
    <body>
        <form action="/test" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>上传文件</td>
                    <td>
                        <input type="file" name="image" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" />
                        <input type="reset" />
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
