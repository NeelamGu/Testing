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
            <td class='style2' style="padding: 10px;">Kjære {{ $name }}</td>
        </tr>
        <tr>
            <td class='style2' style="padding: 10px;">Velkommen som leverandør hos Samling.no. Du kan nå lage dine
                annonser, og legge til informasjon og bilder av dine produkter og tjenester. Se også vår video om
                hvordan du optimaliserer din leverandørkonto og drar nytte av de flotte funksjonene på Samling
                <br>
                <a href="https://youtu.be/JcoQ6FjgxUI">https://youtu.be/JcoQ6FjgxUI</a>
            </td>
            /* <td class='style2' style="padding: 10px;">Velkommen som leverandør hos Samling.no. Du kan nå lage dine
                annonser, og legge til informasjon og bilder av dine produkter og tjenester. Se også vår video om
                hvordan du optimaliserer din leverandørkonto og drar nytte av de flotte funksjonene på Samling
                <br>
                <a href="https://youtu.be/JcoQ6FjgxUI">https://youtu.be/JcoQ6FjgxUI</a>
            </td> */
        </tr>
        <tr>
            <td class='style2' style="padding: 10px;">Siden du nå er en del av leverandør-fellesskapet, ber vi deg om å
                bli med i Facebook-gruppen <a
                    href="https://www.facebook.com/groups/1412921866259594">https://www.facebook.com/groups/1412921866259594</a>
                Her vil du motta informasjon og bli kjent med andre leverandører.
            </td>
        </tr>
        /* <tr>
            <td class='style2' style="padding: 10px;">Navn: {{ $name }}</td>
        </tr>
        <tr>
            <td class='style2' style="padding: 10px;">Telefonnummer: {{ $mobile }}</td>
        </tr> */
        <tr>
            <td class='style2' style="padding: 10px;">Ditt valgte abonnement er [Chosen plan]
            </td>
        </tr>
        <tr>
            <td class='style2' style="padding: 10px;">Faktura vil bli sendt til din oppgitte epost-adresse.
            </td>
        </tr>
        <tr>
            <td class='style2' style="padding: 10px;">Samling.no er en markedsføringsside for alle som leverer produkter
                og tjenester til små og store samlinger. Som registrert leverandør vil bedriften din få mer synlighet og
                dermed større kundekrets. Du vil også få mulighet til å svare på kunders oppdragsforespørsler.
            </td>
        </tr>
        <!--  <tr>
                <td class='style2' style="padding: 10px;"></td>
            </tr>  -->
        <tr>
            <td class='style2' style="padding: 10px;">Hvis du har spørsmål eller trenger hjelp, ta gjerne kontakt med
                vår kundeservice på epost <a href="mailto:hei@samling.no">hei@samling.no</a>
            </td>
        </tr>
        <tr>
            <td class='style2' style="padding: 10px;"></td>
        </tr>
        <tr>
            <td class='style2' style="padding: 10px;"> Med vennlig hilsen<br />
                Samling.no
            </td>
        </tr>
    </table>
</body>

</html>