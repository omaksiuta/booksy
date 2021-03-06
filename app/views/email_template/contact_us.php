<!doctype html>
<html lang="en-US">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <style type="text/css">
            a:hover { text-decoration: none !important; }
            :focus { outline:none; border:0;}
        </style>
    </head>
    <body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f8f9;" bgcolor="#eaeeef" leftmargin="0">
        <!--100% body table-->
        <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f8f9" style="@import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300); font-family: 'Roboto', sans-serif , Arial, Helvetica, sans-serif;">
            <tr>
                <td>
                    <table style="background-color: #f2f8f9; max-width:670px; margin:0 auto;" width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="height:80px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">
                                <a href="<?php echo base_url(); ?>" title="<?php echo get_CompanyName(); ?>"><img width="" src="<?php echo get_CompanyLogo(); ?>" title="<?php echo get_CompanyName(); ?>" alt="<?php echo get_CompanyName(); ?>"></a>
                            </td>
                        </tr>
                        <tr>
                            <td height="40px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:600px; background:#fff; border-radius:3px; text-align:left; -webkit-box-shadow:0 1px 3px 0 rgba(0, 0, 0, 0.16), 0 1px 3px 0 rgba(0, 0, 0, 0.12);-moz-box-shadow:0 1px 3px 0 rgba(0, 0, 0, 0.16), 0 1px 3px 0 rgba(0, 0, 0, 0.12);box-shadow:0 1px 3px 0 rgba(0, 0, 0, 0.16), 0 1px 3px 0 rgba(0, 0, 0, 0.12)">
                                    <tr>
                                        <td style="padding:40px;">
                                            <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <h1 style="color: #3075BA; font-weight: 400; margin: 0; font-size: 32px;">Hi <?php echo isset($user) ? $user : ""; ?>,</h1>
                                                        <p style="font-size:15px; color:#171f23de; line-height:24px; margin:8px 0 30px;"><?php echo translate('new_contact_request'); ?></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>

                                                        <table cellpadding="0" cellspacing="0" style="width: 100%; border: 1px solid #ededed">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:#171f23de"><?php echo translate('name'); ?>:</td>
                                                                    <td style="padding: 10px; border-bottom: 1px solid #ededed; color: rgba(23,31,35,.87);" ><?php echo $name; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:#171f23de"><?php echo translate('email'); ?>:</td>
                                                                    <td style="padding: 10px; border-bottom: 1px solid #ededed; color: rgba(23,31,35,.87);" ><?php echo isset($email) ? $email : ""; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding: 10px; border-bottom: 1px solid #ededed;border-right: 1px solid #ededed; width: 35%; font-weight:500; color:#171f23de"><?php echo translate('phone'); ?>:</td>
                                                                    <td style="padding: 10px; border-bottom: 1px solid #ededed; color: rgba(23,31,35,.87);"><?php echo isset($phone) ? $phone : ""; ?></td>
                                                                </tr>
                                                                <?php if (isset($service) && $service != ""): ?>
                                                                    <tr>
                                                                        <td style="padding: 10px; border-bottom: 1px solid #ededed;border-right: 1px solid #ededed; width: 35%; font-weight:500; color:#171f23de"><?php echo translate('service'); ?>:</td>
                                                                        <td style="padding: 10px; border-bottom: 1px solid #ededed; color: rgba(23,31,35,.87);"><?php echo isset($service) ? $service : ""; ?></td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                                <?php if (isset($event) && $event != ""): ?>
                                                                    <tr>
                                                                        <td style="padding: 10px; border-bottom: 1px solid #ededed;border-right: 1px solid #ededed; width: 35%; font-weight:500; color:#171f23de"><?php echo translate('event'); ?>:</td>
                                                                        <td style="padding: 10px; border-bottom: 1px solid #ededed; color: rgba(23,31,35,.87);"><?php echo isset($event) ? $event : ""; ?></td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                                <?php if (isset($subject) && $subject != ""): ?>
                                                                    <tr>
                                                                        <td style="padding: 10px; border-bottom: 1px solid #ededed;border-right: 1px solid #ededed; width: 35%; font-weight:500; color:#171f23de"><?php echo translate('subject'); ?>:</td>
                                                                        <td style="padding: 10px; border-bottom: 1px solid #ededed; color: rgba(23,31,35,.87);"><?php echo isset($subject) ? $subject : ""; ?></td>
                                                                    </tr>
                                                                <?php endif; ?>


                                                                <tr>
                                                                    <td style="padding: 10px; border-bottom: 1px solid #ededed;border-right: 1px solid #ededed; width: 35%; font-weight:500; color:#171f23de"><?php echo translate('message'); ?>:</td>
                                                                    <td style="padding: 10px; border-bottom: 1px solid #ededed; color: rgba(23,31,35,.87);"><?php echo isset($message) ? $message : ""; ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:25px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">
                                <p style="font-size:14px; color:#455056bd; line-height:18px; margin:0 0 0;"><strong>&copy;</strong> <?php echo get_CompanyName() . " " . date("Y"); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:80px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table><!--/100% body table-->
    </body>
</html>