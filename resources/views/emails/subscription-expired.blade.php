<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Langganan Sudah Berakhir</title>
</head>
<body style="margin:0; padding:0; background-color:#0d1117; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#0d1117; padding:40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="560" cellpadding="0" cellspacing="0" style="background-color:#151b23; border-radius:24px; overflow:hidden; border:1px solid #2a323d;">

                    <!-- HEADER -->
                    <tr>
                        <td style="padding:32px 40px 0;">
                            <div style="display:inline-block; padding:6px 14px; background-color:rgba(232,90,90,0.12); border-radius:100px; font-size:11px; font-weight:600; letter-spacing:0.06em; text-transform:uppercase; color:#E85A5A;">
                                Langganan Berakhir
                            </div>
                        </td>
                    </tr>

                    <!-- TITLE -->
                    <tr>
                        <td style="padding:20px 40px 0;">
                            <h1 style="margin:0; font-size:24px; font-weight:800; color:#ffffff; letter-spacing:-0.02em;">
                                Langganan kamu sudah berakhir
                            </h1>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:16px 40px 0;">
                            <p style="margin:0 0 16px; font-size:14.5px; line-height:1.7; color:#9ba3af;">
                                Halo <strong style="color:#e6e8eb;">{{ $company->name }}</strong>,
                            </p>
                            <p style="margin:0 0 16px; font-size:14.5px; line-height:1.7; color:#9ba3af;">
                                Paket langganan Arvessa kamu sudah berakhir sejak
                                <strong style="color:#E85A5A;">{{ $company->plan_expires_at->translatedFormat('d F Y') }}</strong>.
                                Beberapa fitur mungkin sudah dibatasi. Perpanjang sekarang supaya kamu bisa lanjut pakai semua fitur Arvessa tanpa gangguan.
                            </p>
                        </td>
                    </tr>

                    <!-- CTA BUTTON -->
                    <tr>
                        <td style="padding:24px 40px 0;">
                            <a href="{{ route('pricing') }}"
                               style="display:inline-block; padding:14px 28px; background-color:#34B583; color:#ffffff; text-decoration:none; font-size:14px; font-weight:700; border-radius:12px;">
                                Perpanjang Langganan
                            </a>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="padding:40px 40px 32px;">
                            <p style="margin:0; font-size:12.5px; line-height:1.6; color:#5c6672;">
                                Email ini dikirim otomatis oleh sistem Arvessa. Kalau kamu sudah memperpanjang langganan, abaikan saja email ini.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>