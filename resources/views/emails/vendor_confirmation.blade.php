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
                -->
        </style>
    </head>
    <body>
        <table width='80%' border='0' cellpadding='3' cellspacing='3' style='border:#EFEFEF 5px solid; padding:5px;'>
            <tr>
                <td colspan='3'></td>
            </tr>
            <tr>
                <td align='left' valign='middle'><img border='0' width="150px" src="{{ asset('front/images/logo5.png') }}" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class='style2' style="padding: 10px;">Hei {{ $name }}<br><br>Takk for registrering som leverandør. Vennligst bekreft din e-post ved å klikke på lenken under. <br><br> <a href="{{ url('vendor/confirm/'.$code) }}">{{ url('vendor/confirm/'.$code) }}</a> <br><br>Ved å bekrefte din e-post godtar du samtidig våre brukervilkår (<a href="{{ url('/supplier-terms-conditions')}}">Vilkår og betingelser</a>)</td>
            </tr>
            <!-- <tr>
                <td>&nbsp;</td>
            </tr> -->
            <tr>
                <td class='style2' style="padding: 10px;">Hvis du har spørsmål eller trenger hjelp, ta gjerne kontakt med vår kundeservice på epost <a href="mailto: hei@samling.no">hei@samling.no</a></td>
            </tr>
           <!--  <tr>
                <td>&nbsp;</td>
            </tr>  -->           
            <tr>
                <td  class='style2' style="padding: 10px;">Med vennlig hilsen Samling.no  
                </td>
            </tr>
        </table>
    </body>
</html>