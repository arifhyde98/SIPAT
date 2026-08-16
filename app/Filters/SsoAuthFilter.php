<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Helpers\JwtHelper;

class SsoAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $ssoToken = $request->getGet('sso_token');

        // Handle incoming SSO Token
        if ($ssoToken) {
            $decoded = JwtHelper::decode($ssoToken);
            if ($decoded && isset($decoded['user_id'])) {
                $appPermissions = $decoded['app_permissions'] ?? [];
                
                // Check if user has permission for SIPAT
                if (!isset($appPermissions['SIPAT'])) {
                    return redirect()->to('https://auth.sipat-donggala.my.id/auth/login')
                        ->with('error', 'Anda tidak memiliki hak akses untuk aplikasi SIPAT.');
                }

                $sipatRole = $appPermissions['SIPAT']['role'] ?? 'User';
                $sipatOpd  = $appPermissions['SIPAT']['opd'] ?? '';

                $session->regenerate(true);
                $session->set([
                    'user_id'    => $decoded['user_id'],
                    'user_name'  => $decoded['nama'],
                    'user_email' => $decoded['email'],
                    'user_role'  => $sipatRole,
                    'user_opd'   => $sipatOpd,
                    'is_login'   => true,
                ]);

                // Redirect to clean URL without sso_token in query string
                $currentUrl = current_url();
                $queryParams = $request->getGet();
                unset($queryParams['sso_token']);
                $cleanUrl = $currentUrl . (!empty($queryParams) ? '?' . http_build_query($queryParams) : '');

                return redirect()->to($cleanUrl);
            }
        }

        // If not logged in locally, redirect to SSO Auth Server
        if (!$session->get('is_login')) {
            $ssoServerUrl = 'https://auth.sipat-donggala.my.id/auth/login';
            $queryString = $request->getUri()->getQuery();
            $currentFullUrl = current_url() . ($queryString !== '' ? '?' . $queryString : '');
            
            return redirect()->to($ssoServerUrl . '?redirect_to=' . urlencode($currentFullUrl));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
