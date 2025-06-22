<?php
/**
 * Router.php
 *
 * Router sederhana untuk menangani route GET, POST, PUT, DELETE pada aplikasi MVC.
 *
 * @package   projek\core
 * @author    Dimas Bayu Nugroho
 * @copyright (c) 2025
 * @license   MIT
 */
class Router
{
    /**
     * @var array $routes Menyimpan semua route yang terdaftar, dikelompokkan berdasarkan method HTTP.
     */
    private $routes = [
        'GET'    => [],
        'POST'   => [],
        'PUT'    => [],
        'PATCH'  => [],
        'DELETE' => [],
    ];

    /**
     * Daftarkan route baru.
     *
     * @param string   $method  HTTP method (GET, POST, dll)
     * @param string   $path    Path/URI yang akan di-handle
     * @param callable $handler Fungsi/callback yang akan dijalankan jika route cocok
     * @return void
     */
    public function add(string $method, string $path, $handler)
    {
        $method = strtoupper($method);
        $path = $this->normalizePath($path);
        $this->routes[$method][$path] = $handler;
    }

    /**
     * Shortcut untuk mendaftarkan route GET.
     */
    public function get(string $path, $handler)
    {
        $this->add('GET', $path, $handler);
    }

    /**
     * Shortcut untuk mendaftarkan route POST.
     */
    public function post(string $path, $handler)
    {
        $this->add('POST', $path, $handler);
    }

    /**
     * Shortcut untuk mendaftarkan route PUT.
     */
    public function put(string $path, $handler)
    {
        $this->add('PUT', $path, $handler);
    }

    /**
     * Shortcut untuk mendaftarkan route PATCH.
     */
    public function patch(string $path, $handler)
    {
        $this->add('PATCH', $path, $handler);
    }

    /**
     * Shortcut untuk mendaftarkan route DELETE.
     */
    public function delete(string $path, $handler)
    {
        $this->add('DELETE', $path, $handler);
    }

    /**
     * Normalisasi path agar konsisten.
     */
    private function normalizePath($path)
    {
        $path = trim($path);
        if ($path === '' || $path === false) {
            return '/';
        }
        if ($path[0] !== '/') {
            $path = '/' . $path;
        }
        return rtrim($path, '/');
    }

    /**
     * Render halaman 404 jika route tidak ditemukan.
     */
    private function render404()
    {
        http_response_code(404);
        $view404 = __DIR__ . '/../view/404.view.php';
        if (file_exists($view404)) {
            include $view404;
        } else {
            echo "404 Not Found";
        }
    }

    /**
     * Jalankan router: cocokkan path & method, lalu panggil handler yang sesuai.
     * Jika tidak ada yang cocok, tampilkan halaman 404.
     */
    public function dispatch()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptName !== '/' && strpos($uri, $scriptName) === 0) {
            $uri = substr($uri, strlen($scriptName));
        }
        $uri = strtok($uri, '?');
        $uri = '/' . ltrim($uri, '/');

        $method = $_SERVER['REQUEST_METHOD'];

        // Cek route statis dulu
        if (isset($this->routes[$method][$uri])) {
            call_user_func($this->routes[$method][$uri]);
            return;
        }

        // Cek dynamic route (misal: /tamu/(:any))
        foreach ($this->routes[$method] as $route => $handler) {
            if (strpos($route, '(:any)') !== false) {
                $pattern = str_replace('(:any)', '([^/]+)', $route);
                if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                    array_shift($matches); // buang full match
                    return call_user_func_array($handler, $matches);
                }
            }
        }

        error_log("404: method=$method, uri=$uri");
        $this->render404();
    }
}