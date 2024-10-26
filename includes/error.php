<div class="wrap">
    <div style="display: flex;justify-content: center;align-items: center;">
        <div style="flex: 0 0 220px;text-align: center;padding-top:100px">
            <h1>Error <?php echo esc_html($errorCode)?></h1>
            <a href="<?php echo esc_url($url)?>"><?php echo esc_html($title)?></a>
            <?php if (!empty($messageError)) { ?>
                <code><?php echo esc_html($messageError); ?></code>
            <?php } ?>
        </div>
    </div>
</div>