<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <p>Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>
    <p>Silakan klik tombol di bawah ini untuk mereset password Anda:</p>
    
    <a href="{{ route('password.reset', ['token' => $token]) }}" 
       style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; border-radius: 5px;">
        Reset Password
    </a>
    
    <p>Link reset password akan kadaluarsa dalam 60 menit.</p>
    <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
</body>
</html>