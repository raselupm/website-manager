<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title></title>
    <!--[if (mso 16)]>
    <style type="text/css">
        a {text-decoration: none;}
    </style>
    <![endif]-->
    <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG></o:AllowPNG>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <!--[if !mso]><!-- -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet">
    <!--<![endif]-->
</head>

<body>
<div class="es-wrapper-color">
    <!--[if gte mso 9]>
    <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
        <v:fill type="tile" color="#eeeeee"></v:fill>
    </v:background>
    <![endif]-->
    <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <td class="esd-email-paddings" valign="top">
                <table class="es-content esd-header-popover" cellspacing="0" cellpadding="0" align="center">
                    <tbody>
                    <tr></tr>
                    <tr>
                        <td class="esd-stripe" esd-custom-block-id="7799" align="center">
                            <table class="es-header-body" style="background-color: #044767;" width="600" cellspacing="0" cellpadding="0" bgcolor="#044767" align="center">
                                <tbody>
                                <tr>
                                    <td class="esd-structure es-p35t es-p40b es-p35r es-p35l" align="left">
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td class="esd-container-frame" width="530" valign="top" align="center">
                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                        <tr>
                                                            <td class="esd-block-text es-m-txt-c" align="center">
                                                                <h1 style="color: #ffffff; line-height: 100%;">{{env('APP_NAME')}}</h1>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="es-content" cellspacing="0" cellpadding="0" align="center">
                    <tbody>
                    <tr>
                        <td class="esd-stripe" align="center">
                            <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                <tbody>
                                <tr>
                                    <td class="esd-structure es-p35t es-p25b es-p35r es-p35l" esd-custom-block-id="7811" align="left">
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td class="esd-container-frame" width="530" valign="top" align="center">
                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                        <tr>
                                                            <td class="esd-block-text es-p20t es-p5b" align="left">
                                                                <h3 style="color: #333333;">Hello there,<br></h3>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="esd-block-text es-p15t es-p10b" align="left">
                                                                <p style="font-size: 16px; color: #777777;">Your website {{$domain_name}} is <strong>{{$type == 1 ? 'UP' : 'DOWN'}}</strong> since {{date('F j, Y - g:i a', strtotime($time))}}.</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="esd-block-text es-p5t es-p10b" align="left">
                                                                <p style="font-size: 16px; color: #777777;">You can view historical outages
                                                                    <a href="{{env('APP_URL')}}{{$domain_name}}">here</a></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="esd-block-text" align="left">
                                                                <p style="font-size: 16px; color: #777777;">Good luck!</p>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>

</html>
