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
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Base path dinamis
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        $basePath = rtrim($scriptName, '/\\');
        if ($basePath === '' || $basePath === '\\') $basePath = '';

        if ($basePath && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        // Normalisasi path
        $uri = $this->normalizePath($uri);

        if (isset($this->routes[$method][$uri])) {
            call_user_func($this->routes[$method][$uri]);
        } else {
            $this->render404();
        }
    }
}