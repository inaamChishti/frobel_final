<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frobel School System - Login Credentials</title>
</head>
<body style="background-color:#0000ff42">
    <!-- Header Table with Logo -->
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <!-- Include the image using the cid approach -->
                <img src="{{ $message->embed(public_path('img/FrobelEducationWhite (1).png')) }}" alt="Frobel Education" style="max-width: 100%; height: auto;background-color:#0000ff42;">
                <br>
                <p>Dear Parent,</p>
                <p>We are delighted to welcome you to Frobel School System.</p>
                <p>Your login credentials for accessing details about your child are as follows:</p>
                <p><strong>Username:</strong> {{ $user->username }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
                <p>Please click the following button to log in:</p>
                <a href="{{ $loginUrl }}" style="text-decoration: none;">
                    <button style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Login Now</button>
                </a>
                <p>If you have any questions or concerns, feel free to contact our support team.</p>
                <p>Best regards,<br>Frobel School System</p>
            </td>
        </tr>
        <tr>
            <td>

            </td>
        </tr>
    </table>

    <!-- Main Content Table -->
    <table width="100%" cellpadding="20" cellspacing="0">

    </table>
</body>
</html>
