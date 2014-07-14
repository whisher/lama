<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2><% trans('mails.newpassword'); %></h2>
        <p><blockquote><% $newPassword %></blockquote></p>
        <p><% trans('mails.thankyou'); %><br />
            ~The Admin Team</p>
    </body>
</html>