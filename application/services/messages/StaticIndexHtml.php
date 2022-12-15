<?php
namespace app\services\messages;

/**
 * Check if there is index.html file in the root erp directory eq default server index.html
 * on some servers if this file exists file, the http://yourdomain/erp/ page may not work properly
 */

defined('BASEPATH') or exit('No direct script access allowed');

use app\services\messages\AbstractMessage;

class StaticIndexHtml extends AbstractMessage
{
    public function isVisible()
    {
        return file_exists(FCPATH . 'index.html') && is_admin();
    }

    public function getMessage()
    {
        ?>
		<h4>Static <b>index.html</b> file detected in the ERP root directory!</h4>
		The system detected static <b>index.html</b> file in the ERP root directory (<?php echo FCPATH; ?>)
		<br />
		To prevent any unwanted results, you should delete the file <b>index.html</b> and leave only the core index.php file.
		<?php
    }
}
