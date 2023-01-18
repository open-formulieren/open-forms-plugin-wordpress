<div <?php echo get_block_wrapper_attributes(); ?>
    id="<?php echo esc_attr( $html_id ); ?>"
    data-base-url="<?php echo esc_url( $base_url ); ?>"
    data-form-id="<?php echo esc_attr( $form_id ); ?>"
    <?php if ( $base_path ): ?>data-base-path="<?php echo esc_url( $base_path ); ?>"<?php endif; ?>
    <?php if ( $csp_nonce ): ?>data-csp-nonce="<?php echo esc_attr( $csp_nonce ); ?>"<?php endif; ?>
    <?php if ( $lang ): ?>data-lang="<?php echo esc_attr( $lang ); ?>"<?php endif; ?>
    <?php if ( $sentry_dsn ): ?>data-sentry-dsn="<?php echo esc_url( $sentry_dsn ); ?>"<?php endif; ?>
    <?php if ( $sentry_env ): ?>data-sentry-env="<?php echo esc_attr( $sentry_env ); ?>"<?php endif; ?>
></div>
<script <?php if ( $csp_nonce ): ?>nonce="<?php echo esc_attr( $csp_nonce ); ?>"<?php endif; ?>>
    var targetNode = document.getElementById('<?php echo esc_js( $html_id ); ?>');
    var form = new OpenForms.OpenForm(targetNode, targetNode.dataset);
    form.init();
</script>
