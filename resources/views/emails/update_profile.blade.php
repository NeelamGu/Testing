<html>

<head>
    <style type='text/css'>
        <!--
        .style1 {
            color: #FFFFFF
        }

        .style2 {
            font-size: 11px;
            font-weight: bold;
            text-decoration: none;
            font-family: Verdana, Arial, Helvetica, sans-serif;
            color: #666666;
        }

        .style3 {
            text-decoration: none;
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #666666;
        }
        -->
    </style>
</head>

<body>
    <table width='80%' border='0' cellpadding='3' cellspacing='3' style='border:#EFEFEF 5px solid; padding:5px;'>
        <tr>
            <td colspan='3'></td>
        </tr>
        <tr>
            <td align='left' valign='middle'><img border='0' width="150px"
                    src="{{ asset('front/images/logo5.png') }}" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td class='style2' style="padding: 10px;">Hi,</td>
        </tr>
        <tr>
            <td class='style2' style="padding: 10px;">This is to inform you that a vendor has recently updated their profile on the website. Please review the changes and approve the updated profile at your earliest convenience.</td>
  
        </tr>

        <tr>
            <td class='style2' style="padding: 10px;"><strong>Vendor Details:</strong></td>
        </tr>

        <tr>
            <td class='style2' style="padding: 10px;">Vendor Name: {{$name}}</td>
        </tr>

        <tr>
            <td class='style2' style="padding: 10px;">Profile Name: {{$product_name}}
            </td>
        </tr>
        
        <tr>
            <td class='style2' style="padding: 10px;"></td>
        </tr>
    </table>
</body>

</html>