<html lang='en' xmlns='http://www.w3.org/1999/xhtml' xmlns:o='urn:schemas-microsoft-com:office:office'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width,initial-scale=1'>
    <meta name='x-apple-disable-message-reformatting'>
    <title></title>
    <style>
        table,
        td,
        div,
        h3,
        p {
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body style='margin:0;background:#ebebeb;padding:5px;'>
    <table style='width:100%;border-collapse:collapse;border:0;border-spacing:0;'>
        <tr>
            <td align='center' style='padding:0;'>
                <table style='width:600px;border-collapse:collapse;border:0;border-spacing:0;text-align:left;background:#ffffff;'>
                    <tr>
                        <td style='padding:0px;'>
                            <table role='presentation' style='width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;'>
                                <tr>
                                    <td style='padding:10px;color:#153643; text-align: center;'><img src='<?= imageCheck("logos", "frajosan.png", "default.png") ?>' style='max-height: 80px;'></td>
                                </tr>
                                <tr>
                                    <td style='border-top: 1px dashed #000;margin-bottom:50px;'></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding:30px'>
                            <table style='width:100%;border-collapse:collapse;border:0;border-spacing:0;'>
                                <tr>
                                    <td>
                                        <h3 style='font-size:20px;margin:0 0 20px 0;font-family:Arial,sans-serif;'><?= $mailSubject ?></h3>
                                        <p style='margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;'><?= $mailBody ?></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding:20px 30px;background:darkblue;'>
                            <table role='presentation' style='width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;'>
                                <tr>
                                    <th style='padding: 0px;width:100%;font-size:14px;line-height:16px;color:#ffffff;' align='left'>Frajosan Technologies</th>
                                </tr>
                                <tr>
                                    <td style='padding: 0px;width:100%;font-size:14px;line-height:16px;color:#ffffff;' align='left'>The leading IT company in software development and Database administration.</td>
                                </tr>
                                <tr>
                                    <td style='padding: 0px;width:100%;font-size:14px;line-height:16px;color:#ffffff;' align='left'>Tel: +254-796-594-366</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>