<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\AuditLogModel;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }

    protected function logAudit(string $action, string $entity, ?int $entityId = null, array $old = [], array $new = []): void
    {
        $model = new AuditLogModel();
        $model->insert([
            'user_id'    => session()->get('user_id'),
            'action'     => $action,
            'entity'     => $entity,
            'entity_id'  => $entityId,
            'old_data'   => $old ? json_encode($old, JSON_UNESCAPED_UNICODE) : null,
            'new_data'   => $new ? json_encode($new, JSON_UNESCAPED_UNICODE) : null,
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => (string) $this->request->getUserAgent(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
