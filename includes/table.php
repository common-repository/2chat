<div class="wrap">

    <h1 class="wp-heading-inline"><?php echo esc_html($_LANG['tool_wa_button_generator_list_title'])?></h1>
    <a href="<?php echo esc_url(admin_url('admin.php?page=2chat-plugin&action=new')); ?>" class="page-title-action"><?php echo esc_html($_LANG['add_new'])?></a>
    <hr class="wp-header-end">
    <div class="notice inline notice-success is-dismissible">
		<p><?php echo esc_html($_LANG['tool_wa_button_generator_sub_title'])?></p>
	</div>


    <table style="margin-top: 10px;" class="wp-list-table widefat fixed striped table-view-list posts">
        <thead>
            <tr>
                <th width="20%"><?php echo esc_html($_LANG['alias'])?></th>
                <th width="20%"><?php echo esc_html($_LANG['phone'])?></th>
                <th><?php echo esc_html($_LANG['shortcode'])?></th>
                <th width="10%"><?php echo esc_html($_LANG['actions'])?></th>
            </tr>
        </thead>

        <?php
        if ($data) {
            $copyID = '_2chat-plugin-'.$row->id;
            ?>
            <tbody>
                <?php
                foreach ($data as $row) {
                    ?>
                    <tr>
                        <td><?php echo esc_html($row->alias); ?></td>
                        <td><?php echo esc_html($row->phone_number); ?></td>
                        <td>
                            <b><span id="<?php echo esc_attr($copyID)?>">[2chat_whatsapp_button alias="<?php echo esc_html($row->alias); ?>"]</span></b>
                            &nbsp;
                            <a href="#" _2chat-data-copy-id="<?php echo esc_attr($copyID)?>"><?php echo esc_html($_LANG['copy_shortcode'])?></a>
                        </td>
                        <td>
                            <a href="<?php echo esc_url(admin_url('admin.php?page=2chat-plugin&action=edit&id=' . $row->id)); ?>"><?php echo esc_html($_LANG['edit'])?></a> |
                            <a href="<?php echo esc_url(admin_url('admin.php?_wpnonce=' . $row->nounceCode . '&page=2chat-plugin&action=delete&id=' . $row->id)); ?>" onclick="return confirm('<?php echo esc_attr($_LANG['delete_confirm_message'])?>');"><?php echo esc_html($_LANG['delete'])?></a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
            <?php
        } else {?>
        <tbody>
            <tr>
                <td colspan="4"><?php echo esc_html($_LANG['tool_wa_buton_empty_list_message'])?></td>
            </tr>
        </tbody>
        <?php } ?>
    </table>
</div>
<script>
window.history.pushState('page2', '2 Chat', `${location.pathname}?page=2chat-plugin`);
(function() {
    let attr = '_2chat-data-copy-id';
    var copyButtons = document.querySelectorAll(`[${attr}]`);

    copyButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var copyText = document.getElementById(this.getAttribute(attr)).innerHTML;
            navigator.clipboard.writeText(copyText)
            .then(function() {
                alert(`<?php echo esc_js($_LANG['copyboard_ok'])?>: \n\n ${copyText}`);
            })
            .catch(function(err) {
                alert(`<?php echo esc_js($_LANG['copyboard_error'])?>`);
                console.error(err);
            });
        });
        return false;
    });
})();
</script>
