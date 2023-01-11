<div <?= get_block_wrapper_attributes(); ?>
    id="<?= $html_id ?>"
    data-base-url="<?= $base_url ?>"
    data-form-id="<?= $form_id ?>"
    <?php if ( $base_path ): ?>data-base-path="<?= $base_path ?>"<?php endif; ?>
    <?php if ( $csp_nonce ): ?>data-csp-nonce="<?= $csp_nonce ?>"<?php endif; ?>
    <?php if ( $lang ): ?>data-lang="<?= $lang ?>"<?php endif; ?>
    <?php if ( $sentry_dsn ): ?>data-sentry-dsn="<?= $sentry_dsn ?>"<?php endif; ?>
    <?php if ( $sentry_env ): ?>data-sentry-env="<?= $sentry_env ?>"<?php endif; ?>
></div>
<script <?php if ( $csp_nonce ): ?>nonce="<?= $csp_nonce ?>"<?php endif; ?>>
    var targetNode = document.getElementById('<?= $html_id ?>');
    var form = new OpenForms.OpenForm(targetNode, targetNode.dataset);
    form.init();
</script>
