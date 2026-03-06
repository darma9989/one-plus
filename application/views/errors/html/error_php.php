<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div style="background: #fff; border: 1px solid #fecaca; border-left: 5px solid #ef4444; padding: 20px; margin: 20px 0; border-radius: 12px; font-family: 'Plus Jakarta Sans', sans-serif; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);">
	<h4 style="margin: 0 0 10px 0; color: #991b1b; font-weight: 800; display: flex; align-items: center; gap: 8px;">
        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        PHP Error Encountered
    </h4>

	<div style="font-size: 14px; color: #475569;">
        <p><strong>Severity:</strong> <?php echo $severity; ?></p>
        <p><strong>Message:</strong> <?php echo $message; ?></p>
        <p><strong>Filename:</strong> <?php echo $filepath; ?></p>
        <p><strong>Line:</strong> <?php echo $line; ?></p>
    </div>

	<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>
        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #fecaca;">
            <p style="font-weight: 700; color: #1e293b; margin-bottom: 8px;">Debug Backtrace:</p>
            <?php foreach (debug_backtrace() as $error): ?>
                <?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>
                    <div style="background: #f8fafc; padding: 10px; border-radius: 8px; font-family: monospace; font-size: 12px; margin-bottom: 5px; border: 1px solid #e2e8f0;">
                        <strong>File:</strong> <?php echo $error['file']; ?><br />
                        <strong>Line:</strong> <?php echo $error['line']; ?><br />
                        <strong>Func:</strong> <?php echo $error['function']; ?>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
	<?php endif ?>
</div>
