<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #F2D837;
        }
        .section {
            margin: 25px 0;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 10px;
        }
        .info-row {
            margin: 8px 0;
        }
        .qr-section {
            background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
            border: 2px solid #F2D837;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            margin: 30px 0;
        }
        .qr-code {
            margin: 20px auto;
            display: block;
            max-width: 300px;
        }
        .warning-box {
            background-color: #FEF2F2;
            border-left: 4px solid #EF4444;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
        }
        .highlight {
            color: #1e293b;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #1e293b; margin: 0;">Tack for din bestallning!</h1>
            <p style="color: #6b7280; margin: 10px 0 0 0;">By Ek Forlag</p>
        </div>

        <p>Hej {{ $order->name }},</p>
        <p>Tack for din bestallning av "<strong>{{ $book->title }}</strong>" med personlig signering!</p>

        <div class="section">
            <div class="section-title">BOKDETALJER</div>
            <div class="info-row"><strong>Titel:</strong> {{ $book->title }}</div>
            <div class="info-row"><strong>ISBN:</strong> {{ $book->isbn }}</div>
            <div class="info-row"><strong>Bokpris:</strong> {{ $book->price }} SEK</div>
            <div class="info-row"><strong>Frakt (Postnord):</strong> 55 SEK</div>
            <div class="info-row"><strong>Totalt att betala:</strong> <span class="highlight">{{ $order->total_price }} SEK</span></div>
        </div>

        <div class="section">
            <div class="section-title">LEVERANSADRESS</div>
            <div class="info-row">{{ $order->street_address }}</div>
            <div class="info-row">{{ $order->postal_code }} {{ $order->city }}</div>
            <div class="info-row">{{ $order->country }}</div>
        </div>

        <div class="section">
            <div class="section-title">SIGNERAD BOK</div>
            <p>Du har bestalt en signerad bok fran Linda Ettehag Kviby.</p>
        </div>

        @if($order->dedication_message)
            <div class="section">
                <div class="section-title">DEDIKATION</div>
                <p>Du har bett om foljande dedikation:</p>
                <p style="font-style: italic; padding-left: 20px;">"{{ $order->dedication_message }}"</p>
            </div>
        @endif

        <div class="qr-section">
            <div class="section-title" style="font-size: 18px; color: #1e293b;">BETALA MED SWISH</div>

            <a href="{{ $swishPaymentUrl }}"
               style="display: inline-block;
                      background: linear-gradient(135deg, #491F5F 0%, #6B2D8E 100%);
                      color: white;
                      padding: 18px 40px;
                      text-decoration: none;
                      border-radius: 12px;
                      font-weight: bold;
                      font-size: 18px;
                      margin: 20px 0;
                      box-shadow: 0 4px 12px rgba(73, 31, 95, 0.3);
                      transition: all 0.3s;">
                BETALA MED SWISH
            </a>

            <p style="margin: 10px 0; font-size: 14px; color: #6b7280;">Klicka pa knappen ovan for att oppna Swish-appen direkt</p>

            <div style="margin: 20px 0; padding: 15px; background: white; border-radius: 8px; border: 2px dashed #E5E7EB;">
                <p style="margin: 0 0 10px 0; font-weight: 600; color: #1e293b;">Eller scanna QR-koden:</p>
                @if($qrCodeUrl)
                    <img src="{{ $qrCodeUrl }}"
                         alt="Swish QR Code"
                         class="qr-code"
                         style="margin: 20px auto; display: block; max-width: 300px;">
                @else
                    <p style="margin: 20px 0;">QR-koden kunde inte genereras. Anvand knappen ovan eller informationen nedan for att swisha manuellt.</p>
                @endif
            </div>

            <div style="margin-top: 20px; text-align: left; background: white; padding: 15px; border-radius: 8px;">
                <p style="margin: 0 0 10px 0; font-weight: 600; color: #1e293b;">Manuell betalning:</p>
                <div class="info-row"><strong>Swish-nummer:</strong> +46734642332</div>
                <div class="info-row"><strong>Mottagare:</strong> Linda Ettehag Kviby</div>
                <div class="info-row"><strong>Belopp:</strong> {{ $order->total_price }} SEK</div>
                <div class="info-row"><strong>Meddelande:</strong> Bestallning #{{ $order->id }}</div>
            </div>
        </div>

        <div class="warning-box">
            <div class="section-title" style="margin-bottom: 5px;">VIKTIGT!</div>
            <p style="margin: 5px 0;">Betalningen maste goras inom 2 timmar for att sakra din bestallning.</p>
            <p style="margin: 5px 0;"><strong>Betalningsdeadline:</strong> {{ $order->payment_deadline->locale('sv')->isoFormat('D MMMM YYYY [kl.] HH:mm') }}</p>
        </div>

        <p>Nar vi har bekraftat din betalning kommer du att fa ett bekraftelsemail. Boken skickas till dig inom nagra dagar.</p>

        <div class="footer">
            <p><strong>Upptack mer fran oss:</strong></p>
            <p>Utforska vara bocker pa <a href="https://byekpublishing.com/books" style="color: #F2D837;">byekpublishing.com/books</a></p>
            <p>Folj vart Sicilien-aventyr pa YouTube!<br>
            Prenumerera: <a href="https://www.youtube.com/@WeBoughtAnAdventureInSicily" style="color: #F2D837;">@WeBoughtAnAdventureInSicily</a></p>

            <p style="margin-top: 20px;">
                Vanliga halsningar,<br>
                <strong>Linda Ettehag Kviby</strong><br>
                By Ek Forlag<br>
                <a href="mailto:linda@byekpublishing.com" style="color: #F2D837;">linda@byekpublishing.com</a>
            </p>
        </div>
    </div>
</body>
</html>
