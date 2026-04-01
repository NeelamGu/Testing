<?php
    /*if (isset($_POST['password']) && $_POST['password'] == '6AZF$f67ioG') {
        setcookie("password", 'MYPASS', strtotime('+30 days'));
        header('Location: /admin/vendor-login');
        exit;
    }*/
?>
<!DOCTYPE html>
<html>
<head>
    <title>Password protected</title>
</head>
<script>
    function submitForm(){
        var vendorform = document.forms.vendorform;
        vendorform.submit();
    }
</script>
<body>
    <div style="text-align:center;margin-top:50px;">
        <!-- You must enter the correct username and password to log in to the Vendor Account. -->
        You are logging into the Vendor Account...
        <form name="vendorform" method="POST">{{ csrf_field() }}
            <input style="margin-top: 5px; display: none;" type="text" name="email" placeholder="Email" @if(isset($_GET['email']) && $_GET['email']!="") value="{{ $_GET['email'] }}" @endif><br>
            <input style="margin-top: 5px; display: none;" type="password" name="password" placeholder="Password" value="6AZF$f67ioG"><br>
            <button style="margin-top: 5px; display: none;" type="submit" onClick="placeOrder(this.form)">Login</button>
        </form>
        <script language="JavaScript" type="text/javascript">
            window.onload=submitForm();
        </script>
    </div>
</body>
</html>