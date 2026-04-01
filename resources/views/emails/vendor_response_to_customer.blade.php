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
                    color:#666666;
                }
                .style3 {
                    text-decoration: none;
                    font-family: Verdana, Arial, Helvetica, sans-serif;
                    font-size: 11px;
                    color:#666666;
                }
                button a{
                text-decoration: none;
                color: #fff
                }
                button{
                background-color: #e46f01;
                border: none;
                padding: 10px 15px;
                margin: 20px 0
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
                <td align='left' valign='middle'><img width="150px" border='0' src="{{ asset('front/images/logo5.png') }}" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class='style2' style="padding: 10px;">Hei {{ $name }}</td>
            </tr>
            <tr>
                <td class='style2' style="padding: 10px;">Du har mottatt en ny melding fra {{ $product_name }}. Vennligst gå inn på Samling.no for å lese meldingen.<br>
<button><a href="{{ url('user/enquiries') }}">Se melding</a></button></td><br>
            </tr>
            <tr>
                <td class='style2' style="padding: 10px;"></td>
            </tr>    
            <tr>
                <td class='style2' style="padding: 10px;"></td>
            </tr>
            <tr>
                <td class='style2' style="padding: 10px;">Hilsen Samling.no </td>
            </tr>
        </table>
    </body>
</html>