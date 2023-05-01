<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        \Config\Services::session();
    }

    private function setFlashData(String $name, String $status, String $message)
    {
        session()->setFlashdata($name, [
            'status' => $status,
            'message' => $message
        ]);
    }

    protected function success(String $message = 'Berhasil.', String $flashMessageName = null, mixed $data = null)
    {
        if ($flashMessageName !== null) $this->setFlashData($flashMessageName, 'success', $message);
        $this->response->setStatusCode(200);
        $this->response->setHeader('Content-Type', 'application/json');
        return json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    protected function unauthorized(String $message = 'Terjadi kesalahan autentikasi.', String $flashMessageName = null)
    {
        if ($flashMessageName !== null) $this->setFlashData($flashMessageName, 'error', $message);
        $this->response->setStatusCode(401);
        $this->response->setHeader('Content-Type', 'application/json');
        return json_encode([
            'status' => 'error',
            'message' => $message
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    protected function badRequest(String $message = 'Bad request payload.', String $flashMessageName = null)
    {
        if ($flashMessageName !== null) $this->setFlashData($flashMessageName, 'error', $message);
        $this->response->setStatusCode(400);
        $this->response->setHeader('Content-Type', 'application/json');
        return json_encode([
            'status' => 'error',
            'message' => $message
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    protected function forbidden(String $message = 'Anda tidak memiliki akses.', String $flashMessageName = null)
    {
        if ($flashMessageName !== null) $this->setFlashData($flashMessageName, 'error', $message);
        $this->response->setStatusCode(403);
        $this->response->setHeader('Content-Type', 'application/json');
        return json_encode([
            'status' => 'error',
            'message' => $message
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    protected function notFound(String $message = 'Tidak ditemukan.', String $flashMessageName = null)
    {
        if ($flashMessageName !== null) $this->setFlashData($flashMessageName, 'error', $message);
        $this->response->setStatusCode(404);
        $this->response->setHeader('Content-Type', 'application/json');
        return json_encode([
            'status' => 'error',
            'message' => $message
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    protected function methodNotAllowed(String $message = 'Access method not allowed.', String $flashMessageName = null)
    {
        if ($flashMessageName !== null) $this->setFlashData($flashMessageName, 'error', $message);
        $this->response->setStatusCode(405);
        $this->response->setHeader('Content-Type', 'application/json');
        return json_encode([
            'status' => 'error',
            'message' => $message
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
