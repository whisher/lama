<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2><% trans('mails.forgot'); %></h2>
        <p>To reset your password, <a href="<% route('users.reset',array('id'=>$id,'code'=>$resetCode)) %>">click here.</a></p>
        <p>Or point your browser to this address: <br /> <% route('users.reset',array('id'=>$id,'code'=>$resetCode)) %></p>
        <p>If you did not request a password reset, you can safely ignore this email - nothing will be changed.</p>
        <p>Thank you, <br />
            ~The Admin Team</p>
    </body>
</html>