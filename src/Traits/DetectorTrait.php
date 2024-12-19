<?php

namespace Awful\Monitoring\Traits;

use WhichBrowser\Parser;

trait DetectorTrait
{
    /**
     * Appends the custom attributes to the model dynamically.
     */
    public static function bootDetectorTrait(): void
    {
        static::retrieved(function ($model) {
            if (!in_array('browser', $model->appends)) {
                $model->appends[] = 'browser_name';
            }

            if (!in_array('platform', $model->appends)) {
                $model->appends[] = 'platform';
            }

            if (!in_array('device', $model->appends)) {
                $model->appends[] = 'device';
            }

            if (!in_array('city', $model->appends)) {
                $model->appends[] = 'city';
            }

            if (!in_array('country', $model->appends)) {
                $model->appends[] = 'country';
            }
        });
    }

    /**
     * An array of browser names.
     *
     * @var array
     */
    protected array $browserName = [
        'Edge' => 'Edge',
        'MSIE' => 'Internet Explorer',
        'Trident' => 'Internet Explorer',
        'Firefox' => 'Firefox',
        'OPR' => 'Opera',
        'Chrome' => 'Chrome',
        'Safari' => 'Safari',
        'Opera' => 'Opera',
    ];

    /**
     * An array of device names.
     *
     * @var array
     */
    protected array $deviceName = [
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    ];

    /**
     * Get browser name.
     * @return string
     */
    protected function getBrowser(): string
    {
        if (PHP_SAPI === 'cli') {
            return 'CLI';
        }

        if (!empty($this->user_agent)) {
            $parser = new Parser(json_decode($this->user_agent));
            $name = $parser->browser->toString();

            if ($name) {
                return $name;
            }

            foreach ($this->browserName as $key => $browser) {
                if (str_contains($this->user_agent, $key)) {
                    return $browser;
                }
            }
        }

        return 'Unknown Browser';
    }

    /**
     * Get device name.
     * @return string
     */
    protected function getDevice(): string
    {
        if (PHP_SAPI === 'cli') {
            return 'CLI';
        }

        if (!empty($this->user_agent)) {
            // Parse the user agent string
            $parser = new Parser(json_decode($this->user_agent));
            $name = $parser->device->toString();

            if ($name) {
                return $name;
            }

            foreach ($this->deviceName as $pattern => $name) {
                if (preg_match($pattern, $this->user_agent)) {
                    return $name;
                }
            }
        }

        return 'Unknown Device Name';
    }

    /**
     * Get platform name.
     * @return string
     */
    protected function getPlatform(): string
    {
        if (PHP_SAPI === 'cli') {
            return 'CLI';
        }

        if (!empty($this->user_agent)) {
            // Parse the user agent string
            $parser = new Parser(json_decode($this->user_agent));
            $name = $parser->os->toString();
            if ($name) {
                return $name;
            }
        }

        return 'Unknown Platform Name';
    }

    public function getBrowserAttribute(): string
    {
        return $this->getBrowser();
    }

    public function getDeviceAttribute(): string
    {
        return $this->getDevice();
    }

    public function getPlatformAttribute(): string
    {
        return $this->getPlatform();
    }

    public function getCityAttribute(): string
    {
        if (isset($this->properties)) {
            $properties = json_decode($this->properties);
            if (isset($properties['city'])) return $properties['city'];
        }

        return 'Unknown';
    }

    public function getCountryAttribute(): string
    {
        if (isset($this->properties)) {
            $properties = json_decode($this->properties);
            if (isset($properties['country'])) return $properties['country'];
        }

        return 'Unknown';
    }

}
