<div class="wrap">

<form method="post" action="<?php echo esc_url($formUrl); ?>">

    <input type="hidden" name="_wpnonce" value="<?php echo esc_attr($nounceCode); ?>">

    <h1 class="wp-heading-inline">
        <?php echo esc_html( ($action === 'edit' && !empty($getID) ) ? $_LANG['edit'] : $_LANG['add_new']);?>
        <?php echo esc_html($_LANG['tool_wa_button_generator_form_title'])?>
    </h1>
    <hr class="wp-header-end">

    <?php if (!empty($messageError)) { ?>
    <div class="notice inline notice-error  is-dismissible ">
		<p><?php echo esc_html($messageError)?></p>
	</div>

    <?php } ?>


        <?php if ($action === 'edit' && !empty($getID)) : ?>
            <input type="hidden" name="id" value="<?php echo esc_attr($getID); ?>">
        <?php endif; ?>

        <table style="margin-top: 10px;" class="wp-list-table widefat">
            <tr>
                <td width="50%">
                    <p class="submit">
                        <input type="submit" name="save-data" class="button button-primary" value="<?php echo esc_html($_LANG['save_data'])?>">
                        &nbsp;
                        <a href="<?php echo esc_url(admin_url('admin.php?page=2chat-plugin')); ?>"><?php echo esc_html($_LANG['cancel'])?></a>
                    </p>

                    <table class="form-table">
                        <tr>
                            <th>
                                <label for="alias"><?php echo esc_html($_LANG['alias'])?></label>
                            </th>
                            <td>
                                <input type="text" name="alias" id="alias" value="<?php echo esc_attr($formValues['alias']); ?>" required>
                                <br><small><?php echo esc_html($_LANG['tool_wa_button_generator_input_alias_helper'])?></small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="chat_box_title"><?php echo esc_html($_LANG['tool_wa_button_generator_input_chat_box_label'])?></label>
                            </th>
                            <td>
                                <input type="text" name="chat_box_title" id="chat_box_title" value="<?php echo esc_attr($formValues['chat_box_title']); ?>" required>
                                <br><small><?php echo esc_html($_LANG['tool_wa_button_generator_input_chat_box_helper'])?></small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="status_text"><?php echo esc_html($_LANG['tool_wa_button_generator_input_status_text_label'])?></label>
                            </th>
                            <td>
                                <input type="text" name="status_text" id="status_text" value="<?php echo esc_attr($formValues['status_text']); ?>" required>
                                <br><small><?php echo esc_html($_LANG['tool_wa_button_generator_input_status_text_helper'])?></small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="status_text"><?php echo esc_html($_LANG['tool_wa_button_generator_input_greeting_message_label'])?></label>
                            </th>
                            <td>
                                <textarea name="greeting_message" id="greeting_message" rows="4" cols="50" required><?php echo esc_textarea($formValues['greeting_message']); ?></textarea>
                                <br><small><?php echo esc_html($_LANG['tool_wa_button_generator_input_greeting_message_helper'])?></small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="status_text"><?php echo esc_html($_LANG['tool_wa_button_generator_input_phone_number_label'])?></label>
                            </th>
                            <td>
                                <input type="text" name="phone_number" id="phone_number" value="<?php echo esc_attr($formValues['phone_number']); ?>" required>
                                <br><small><?php echo esc_html($_LANG['tool_wa_button_generator_input_phone_number_helper'])?></small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="visitor_message_placeholder"><?php echo esc_html($_LANG['tool_wa_button_generator_input_visitor_message_placeholder_label'])?></label>
                            </th>
                            <td>
                                <input type="text" name="visitor_message_placeholder" id="visitor_message_placeholder" value="<?php echo esc_attr($formValues['visitor_message_placeholder']); ?>" required>
                                <br><small><?php echo esc_html($_LANG['tool_wa_button_generator_input_visitor_message_placeholder_helper'])?></small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="color_sheme"><?php echo esc_html($_LANG['tool_wa_button_generator_input_color_scheme_label'])?></label>
                            </th>
                            <td>
                                <select name="color_sheme" id="color_sheme">
                                    <option value="automatic" <?php selected($formValues['color_sheme'], 'automatic'); ?>><?php echo esc_html($_LANG['tool_wa_button_generator_input_color_scheme_automatic'])?></option>
                                    <option value="light" <?php selected($formValues['color_sheme'], 'light'); ?>><?php echo esc_html($_LANG['tool_wa_button_generator_input_color_scheme_light'])?></option>
                                    <option value="dark" <?php selected($formValues['color_sheme'], 'dark'); ?>><?php echo esc_html($_LANG['tool_wa_button_generator_input_color_scheme_dark'])?></option>
                                </select>
                                <br><small><?php echo esc_html($_LANG['tool_wa_button_generator_input_color_scheme_helper'])?></small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="position"><?php echo esc_html($_LANG['tool_wa_button_generator_input_position_label'])?></label>
                            </th>
                            <td>
                                <select name="position" id="position">
                                    <option value="right" <?php selected($formValues['position'], 'right'); ?>><?php echo esc_html($_LANG['tool_wa_button_generator_input_position_right'])?></option>
                                    <option value="left" <?php selected($formValues['position'], 'left'); ?>><?php echo esc_html($_LANG['tool_wa_button_generator_input_position_left'])?></option>
                                </select>
                                <br><small><?php echo esc_html($_LANG['tool_wa_button_generator_input_position_helper'])?></small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="show_notification_badge"><?php echo esc_html($_LANG['tool_wa_button_generator_input_notification_badge_label'])?></label>
                            </th>
                            <td>
                                <select name="show_notification_badge" id="show_notification_badge">
                                    <option value="yes" <?php selected($formValues['show_notification_badge'], 'yes'); ?>><?php echo esc_html($_LANG['tool_wa_button_generator_input_notification_badge_show'])?></option>
                                    <option value="no" <?php selected($formValues['show_notification_badge'], 'no'); ?>><?php echo esc_html($_LANG['tool_wa_button_generator_input_notification_badge_none'])?></option>
                                </select>
                                <br><small><?php echo esc_html($_LANG['tool_wa_button_generator_input_notification_badge_helper'])?></small>
                            </td>
                        </tr>
                    </table>

                    <p class="submit">
                        <input type="submit" name="save-data" class="button button-primary" value="<?php echo esc_attr($_LANG['save_data'])?>">
                        &nbsp;
                        <a href="<?php echo esc_url(admin_url('admin.php?page=2chat-plugin')); ?>"><?php echo esc_html($_LANG['cancel'])?></a>
                    </p>
                </td>
                <td>
                    <p>&nbsp;</p>
                    <div style="text-align: center;">
                        <a href="#" class="page-title-action" onclick="loadIframe();return false;"><?php echo esc_html($_LANG['tool_wa_button_generator_preview_button'])?></a>
                    </div>

                    <p>&nbsp;</p>
                            <small><?php echo esc_html($_LANG['tool_wa_button_generator_button_helper'])?><small>
                            <div id=2chat-iframe-content style="width:100%px;height: 500px;border: 1px solid #ccc;position: relative;">
                                <iframe id="2chat-iframe" style="width: 100%;height: 100%;"></iframe>

                            </div>
                    </div>
                </td>
            <tr>
        </table>

    <script>
        function loadIframe() {
                // Obtén una referencia al iframe
                document.cookie = 'miCookie=miValor; SameSite=None; Secure';

                var iframe = document.getElementById('2chat-iframe');

                let _2chatTag = '><',
                    _2chatConfig = {
                    phoneNumber:document.getElementsByName('phone_number')[0].value,
                    accountName: document.getElementsByName('chat_box_title')[0].value,
                    statusMessage:document.getElementsByName('status_text')[0].value,
                    chatMessage: document.getElementsByName('greeting_message')[0].value,
                    placeholder: document.getElementsByName('visitor_message_placeholder')[0].value,
                    position: document.getElementsByName('position')[0].value,
                    colorScheme: document.getElementsByName('color_sheme')[0].value,
                    showNotification: document.getElementsByName('show_notification_badge')[0].value=='yes',
                };

                _scriptString = `window._2chatConfig= ${JSON.stringify(_2chatConfig)}; <?php require_once('script.php')?>`;
                iframe.srcdoc = `<html${_2chatTag}body${_2chatTag}script>${_scriptString}</script${_2chatTag}/body${_2chatTag}/html>`;
        }
        loadIframe();
    </script>
    </form>
</div>