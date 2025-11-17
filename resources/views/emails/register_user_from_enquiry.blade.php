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
                <td class='style2' style="padding: 10px;">Hei {{ $name }}</td>
            </tr>
            <tr>
                <td class='style2' style="padding: 10px;">Velkommen til Samling.no!</td>
            </tr>
            <tr>
                <td class='style2' style="padding: 10px;"></td>
            </tr>
            <tr>
                <td class='style2' style="padding: 10px;">Oppdag hvor enkelt det er å planlegge ditt arrangement. Her vil du finne alt du trenger til din neste samling, under ett tak.</td>
            </tr> 
           <!--  <tr>
                <td class='style2' style="padding: 10px;"></td>
            </tr> -->
            <tr>
                <td class='style2' style="padding: 10px;">Ditt oppdrag er registrert og sendt ut til alle aktuelle leverandører.</td>
            </tr>  
            <tr>
                <td class='style2' style="padding: 10px;">Takk for at du bruker Samling og lykke til med ditt arrangement! </td>
            </tr>
            <tr>
                <td class='style2' style="padding: 10px;">Hvis du har spørsmål eller trenger hjelp, ta gjerne kontakt med vår kundeservice på epost hei@samling.no</td>
            </tr>  
            <tr>
                <td class='style2' style="padding: 10px;">Dine påloggingsdetaljer er som nedenfor :-</td>
            </tr> 
            <tr>
                <td class='style2' style="padding: 10px;">E-post: {{ $email }}</td>
            </tr>  
            <tr>
                <td class='style2' style="padding: 10px;">Passord: {{ $password }}</td>
            </tr>
            <!-- <tr>
                <td class='style2' style="padding: 10px;"></td>
            </tr> -->
            <tr>
                <td class='style2' style="padding: 10px;">Med vennlig hilsen Samling.no</td>
            </tr>  
              
<!--             <tr>
                <td class='style2' style="padding: 10px;"></td>
            </tr>   -->            
           <!--  <tr>
                <td  class='style2' style="padding: 10px;"> Med vennlig hilsen<br />
                    Samling.no!
                </td>
            </tr> -->
        </table>
    </body>
</html>