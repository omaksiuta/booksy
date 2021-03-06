<table width="100%" height="100" cellpadding="0" cellspacing="0" border="0" bgcolor="#eaeaea" class="">
    <tbody><tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="background: rgba(104,94,238,1);
                       background: -moz-linear-gradient(-45deg, rgba(104,94,238,1) 0%, rgba(246,41,12,1) 0%, rgba(104,94,238,1) 0%, rgba(28,209,219,1) 100%);
                       background: -webkit-gradient(left top, right bottom, color-stop(0%, rgba(104,94,238,1)), color-stop(0%, rgba(246,41,12,1)), color-stop(0%, rgba(104,94,238,1)), color-stop(100%, rgba(28,209,219,1)));
                       background: -webkit-linear-gradient(-45deg, rgba(104,94,238,1) 0%, rgba(246,41,12,1) 0%, rgba(104,94,238,1) 0%, rgba(28,209,219,1) 100%);
                       background: -o-linear-gradient(-45deg, rgba(104,94,238,1) 0%, rgba(246,41,12,1) 0%, rgba(104,94,238,1) 0%, rgba(28,209,219,1) 100%);
                       background: -ms-linear-gradient(-45deg, rgba(104,94,238,1) 0%, rgba(246,41,12,1) 0%, rgba(104,94,238,1) 0%, rgba(28,209,219,1) 100%);">
                    <tbody>
                        <tr>
                            <td>
                                <!-- START space -->
                                <table width="480" height="80" cellpadding="0" cellspacing="0" border="0" align="center">
                                    <tbody><tr><td></td></tr></tbody>
                                </table>
                                <!-- END space -->

                                <!-- START logo -->
                                <table width="480" height="87" cellpadding="0" cellspacing="0" border="0" bgcolor="#e5f2f8" align="center">
                                    <tbody><tr>
                                            <td>
                                                <table width="380" cellpadding="0" cellspacing="0" border="0" align="center">
                                                    <tbody><tr>
                                                            <td align="center" style="font-weight:500; font-size:18px; letter-spacing:0.100em; line-height:auto; color:#203442; font-family:'Poppins', sans-serif; mso-line-height-rule: exactly;">
                                                                <img style="vertical-align:middle;" src="<?php echo get_logo(); ?>">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                <!-- END logo -->

                                <!-- START header -->
                                <table width="480" height="164" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" align="center">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table width="380" cellpadding="0" cellspacing="0" border="0" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td align="center" style="font-weight:300; font-size:38px; letter-spacing:0.025em; line-height:40px; color:#203442; font-family:'Poppins', sans-serif; mso-line-height-rule: exactly;">
                                                                Hi, <?php echo isset($USER) ? $USER : "" ?>!<br>
                                                                <span  style="font-weight:600; font-size:18px; letter-spacing:0.000em; line-height:40px; color:#203442; font-family:'Poppins', sans-serif; mso-line-height-rule: exactly;" contenteditable="false" class="editable">
                                                                    You have received new message from <?php echo isset($CLIENT) ? $CLIENT : "" ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- END header -->

                                <!-- START main content -->
                                <table width="480" height="300" cellpadding="0" cellspacing="0" border="0" bgcolor="#e5f2f8" align="center">
                                    <tbody>
                                        <tr>
                                            <td valign="top">
                                                <table width="380" cellpadding="0" cellspacing="0" border="0" align="center">
                                                    <tbody><tr><td height="65"></td></tr><!-- END space -->
                                                        <tr>
                                                            <td align="center" style="font-weight:300; font-size:16px; letter-spacing:0.025em; line-height:26px; color:#353535; font-family:'Poppins', sans-serif; mso-line-height-rule: exactly;">
                                                                <?php echo isset($MESSAGE) ? $MESSAGE : "" ?>
                                                            </td>
                                                        </tr>
                                                        <tr><td height="36"></td></tr>
                                                        
                                                        <tr><td height="10"></td></tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- END main content -->

                                <!-- START footer -->
                                <table width="480" height="60" cellpadding="0" cellspacing="0" border="0" align="center">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table width="420" height="60" cellpadding="0" cellspacing="0" border="0" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td  align="center" valign="top" style="padding:23px 0px 0px 0px;font-weight:300; font-size:12px; letter-spacing:0.025em; line-height:24px; color:#ffffff; font-family:'Poppins', sans-serif; mso-line-height-rule: exactly;">
                                                                © <?php echo date('Y') . " " . get_CompanyName(); ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- END footer -->
                            </td>
                        </tr>
                    </tbody></table>
            </td>
        </tr>
    </tbody></table>