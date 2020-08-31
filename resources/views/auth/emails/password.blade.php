<!DOCTYPE html>
<html>
<head>

</head>
<body>
  Hello,<br />
  You told us you forgot your password. Click on the link to change it.<br />

 <a href="{{ url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> Click here to reset your password </a>
 <p>If you didn’t mean to reset your password, then you can just ignore this email; your password will not change.</p>

 Kind Regards,<br>
 Afyapepe team.

</body>
</html>
