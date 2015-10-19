<?php
namespace App\Libraries\Theme;

use App\Libraries\Theme\Exceptions\ThemeNotFoundException;
use Illuminate\Contracts\Container\Container;
use File;
use App\Libraries\Theme\Exceptions\ThemeInfoAttributeException;

/**
 * Theme
 *
 * @author Karlo Mikuš
 * @version 0.0.1
 * @package App\Libraries\Theme
 */
class Theme {

    /**
     * Scanned themes
     * @var ThemeInfo[]
     */
    private $themes;

    /**
     * View finder
     * @var \Illuminate\View\Factory
     */
    private $view;

    /**
     * Base theme folder
     * @var string
     */
    private $basePath;

    /**
     * Current active theme
     * @var string|null
     */
    private $activeTheme;

    /**
     * Setup default view finder and view paths.
     *
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        // Default themes path
        $this->basePath = realpath(public_path('themes'));

        // Config view finder
        $paths = $app['config']['view.paths'];
        $this->view = $app->make('view');
        $this->view->setFinder(new ThemeViewFinder($app['files'], $paths));

        // Scan themes
        $this->scanThemes();
    }

    /**
     * Set current active theme
     *
     * @param string $theme Theme namespace
     * @throws ThemeNotFoundException
     */
    public function setTheme($theme)
    {
        if (!$this->themeExists($theme)) {
            throw new ThemeNotFoundException($theme);
        }

        $this->activeTheme = $theme;
        $this->loadTheme();
    }

    /**
     * Get all found themes
     *
     * @return mixed
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * Return currently active theme
     *
     * @return null|string
     */
    public function get()
    {
        return $this->activeTheme;
    }

    /**
     * Load a theme
     *
     * @throws \Exception
     */
    private function loadTheme()
    {
        if (isset($this->activeTheme)) {
            $theme = $this->findThemeByNamespace($this->activeTheme);

            $viewFinder = $this->view->getFinder();

            if (is_null($theme->getParent())) {
                $viewFinder->prependPath($theme->getPath());
            }
            else {
                $this->loadTheme($theme->getParent());
            }
        }
        else {
            throw new \Exception('Unable to load a theme!');
        }
    }

    /**
     * Find a theme from all scanned themes
     *
     * @param string $namespace
     * @return null|ThemeInfo
     */
    private function findThemeByNamespace($namespace)
    {
        foreach ($this->themes as $theme) {
            if ($namespace === $theme->getNamespace())
                return $theme;
        }

        return null;
    }

    /**
     * Check if theme exists
     *
     * @param $theme
     * @return bool
     */
    private function themeExists($theme)
    {
        $themes = [];
        foreach ($this->themes as $themeInfo) {
            if (!array_key_exists($themeInfo->getNamespace(), $themes)) {
                $themes[$themeInfo->getNamespace()] = $themeInfo;
            }
        }

        return array_key_exists($theme, $themes);
    }

    /**
     * Check all available themes
     *
     * @throws ThemeInfoAttributeException
     */
    private function scanThemes()
    {
        $themeDirectories = glob($this->basePath . '/*', GLOB_ONLYDIR);

        $themeInfo = [];
        foreach ($themeDirectories as $themePath) {
            $json = $themePath . '/theme.json';

            if (File::exists($json)) {
                $themeInfo[] = $this->parseThemeInfo(json_decode(File::get($json), true));
            }
        }

        $this->themes = $themeInfo;
    }

    /**
     * Find theme views path
     *
     * @param $theme
     * @return string
     */
    private function findPath($theme)
    {
        $themePath = $this->basePath . '/' . $theme . '/views';

        return $themePath;
    }

    /**
     * Parse theme json file
     *
     * @param array $info
     * @return ThemeInfo
     * @throws ThemeInfoAttributeException
     */
    private function parseThemeInfo(array $info)
    {
        $themeInfo = new ThemeInfo();

        $required = ['name', 'author', 'namespace'];
        foreach ($required as $key) {
            if (!array_key_exists($key, $info))
                throw new ThemeInfoAttributeException($key);
        }

        $themeInfo->setName($info['name']);
        $themeInfo->setAuthor($info['author']);
        $themeInfo->setNamespace($info['namespace']);

        if (isset($info['description']))
            $themeInfo->setDescription($info['description']);
        if (isset($info['version']))
            $themeInfo->setVersion($info['version']);
        if (isset($info['parent']))
            $themeInfo->setParent($info['parent']);

        $themeInfo->setPath($this->findPath($info['namespace']));

        return $themeInfo;
    }

}