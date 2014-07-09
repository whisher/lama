<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2><% trans('mails.register'); %></h2>
        <p><b><% trans('mails.user'); %>:</b> <% $email %></p>
        <p>To activate your account, <a href="<% route('base.user.activate',array('id'=>$id,'code'=>$activationCode)) %>">click here.</a></p>
        <p>Or point your browser to this address: <br /> <% route('base.user.activate',array('id'=>$id,'code'=>$activationCode)) %></p>
        <p>Thank you, <br />
            ~The Admin Team</p>
    </body>
</html>